<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordMailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\SendEmail;
use App\Models\Company;
use App\Models\EmailHistory;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * Register User Email
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerEmail(Request $request)
    {
        $validator = $this->validator($request->all(), User::rules()->only(['email'])->toArray());
        $validator->validate();
        $params = $validator->safe()->only(['email']);
        $registeredUsers = User::where('email', $params['email'])->get();
        if ($registeredUsers->count() === 0) {
            $user = new User();
            $user->email = $params['email'];
            $user->verification_code = mt_rand('11111', '99999');
            $user->expired_at = now()->addHours(5);
            $user->status = User::STATUS_EMAIL_AUTH_IN_PROGRESS;
            $user->withdraw_count = 0;
            $user->created_by = 0;
            $user->updated_by = 0;
            $user->save();
        } else if ($registeredUsers->count() === 1) {
            $user = $registeredUsers->first();
            if ($user->status === User::STATUS_VALID) {
                return $this->sendErrorResponse('email_already_registered', 400);
            } else if ($user->status === User::STATUS_EMAIL_AUTH_IN_PROGRESS) {
                $user->verification_code = mt_rand('11111', '99999');
                $user->expired_at = now()->addHours(5);
                $user->save();
            }
        } else {
            return $this->sendErrorResponse('email_already_registered', 400);
        }
        SendEmail::dispatch(
            config('sendgrid.email_address_registration'),
            [$user->email => $user->email],
            [
                'auth_code' => $user->verification_code,
                'email' => $params['email']
            ]
        );
        EmailHistory::create([
            'template_id' => config('sendgrid.email_address_registration'),
            'from' => env('MAIL_FROM_ADDRESS'),
            'to' => $user->email,
            'body' => view('emails.emailRegistration', [
                'auth_code' => $user->verification_code,
                'email' => $params['email']
            ])->render(),
            'created_at' => now(),
            'created_by' => 0,
            'updated_by' => 0
        ]);
        return $this->sendSuccessResponse($user, 200, 'request_successful');
    }

    /**
     * Verify user Email with verifcation code
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyEmail(Request $request)
    {
        $validator = $this->validator($request->all(), User::rules()->only(['email', 'verification_code'])->toArray());
        $validator->validate();
        $params = $validator->safe()->only(['email', 'verification_code']);

        $user = User::where('email', $params['email'])->where('status', User::STATUS_EMAIL_AUTH_IN_PROGRESS)->firstOrFail();

        // Check verification_code
        if ($user->verification_code != $params['verification_code']) {
            return $this->sendErrorResponse('verification_code_incorrect', 400);
        }

        // Check verification_code expire time
        if (now()->gt($user->expired_at)) {
            return $this->sendErrorResponse('verification_code_expired', 400);
        }

        // TODO: Need to Confirm
        $user->verified_at = now();
        $user->status = User::STATUS_VALID;
        $user->save();

        return $this->sendSuccessResponse([], 200, 'request_successful');
    }

    /**
     * Login user function
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (Hash::check($request->password, $user->crypted_password)) {
                if ($user->status == User::STATUS_VALID && $user->withdraw_count == 0) {
                    $tokenObject = $user->createToken('Personal Access Token');
                    DB::beginTransaction();
                    $user->last_login_at = now();
                    $user->login_times++;
                    $user->save();
                    if ($user->user_info_id) {
                        $type = 3;
                    } elseif ($user->company_id) {
                        $type = Company::find($user->company_id)->type;
                    }
                    DB::commit();
                    return $this->sendSuccessResponse([
                        'access_token' => $tokenObject->accessToken,
                        'type' => $type
                    ], 200, 'login_success');
                } else {
                    return $this->sendErrorResponse('account_invalid', 401);
                }
            } else {
                return $this->sendErrorResponse('invalid_credentials', 401);
            }
        } catch (Exception $error) {
            DB::rollBack();
            return $this->sendErrorResponse('internal_server_error', 500, [$error->getMessage()]);
        }
    }

    /**
     * Send reset password mail
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetPasswordMail(ResetPasswordMailRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if ($user->status == User::STATUS_VALID && $user->withdraw_count == 0) {
                $resetPasswordToken = Str::random(8);
                DB::beginTransaction();
                $user->reset_password_token = bcrypt($resetPasswordToken);
                $user->reset_password_expired_at = now()->addHours(5);
                $user->save();
                $url = env('FRONTEND_URL') . '?token=' . Crypt::encryptString(json_encode([
                    'token' => $resetPasswordToken,
                    'userId' => $user->id
                ]));
                SendEmail::dispatch(
                    config('sendgrid.reset_password'),
                    [$user->email => $user->email],
                    ['url' => $url]
                );
                EmailHistory::create([
                    'template_id' => config('sendgrid.reset_password'),
                    'from' => env('MAIL_FROM_ADDRESS'),
                    'to' => $user->email,
                    'body' => view('emails.resetPasswordMail', ['url' => $url])->render(),
                    'created_at' => now(),
                    'created_by' => 0,
                    'updated_by' => 0
                ]);
                DB::commit();
                return $this->sendSuccessResponse([], 200);
            } else {
                return $this->sendErrorResponse('account_invalid', 401);
            }
        } catch (Exception $error) {
            DB::rollBack();
            return $this->sendErrorResponse('internal_server_error', 500, [$error->getMessage()]);
        }
    }

    /**
     * Reset password
     * @param \App\Http\Requests\ResetPasswordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $data = Crypt::decryptString($request->reset_password_token);
            $data = json_decode($data);
            $user = User::find($data->userId);
            if ($user->status != User::STATUS_VALID || $user->withdraw_count != 0) {
                return $this->sendErrorResponse('account_invalid', 403);
            }
            if (is_null($user->reset_password_token)) {
                return $this->sendErrorResponse('invalid_access', 403);
            }
            if (is_null($user->reset_password_expired_at) || now()->gt($user->reset_password_expired_at)) {
                return $this->sendErrorResponse('password_reset_token_expired', 403);
            }
            if (!Hash::check($data->token, $user->reset_password_token)) {
                return $this->sendErrorResponse('invalid_token', 403);
            }
            if (Hash::check($request->password, $user->crypted_password)) {
                return $this->sendErrorResponse('old_new_password_same', 403);
            }
            DB::beginTransaction();
            $user->crypted_password = bcrypt($request->password);
            $user->reset_password_token = NULL;
            $user->reset_password_expired_at = NULL;
            $user->updated_by = $user->id;
            $user->save();
            DB::table('oauth_access_tokens')->where('user_id', $user->id)->update([
                'revoked' => 1,
                'updated_at' => now()
            ]);
            DB::commit();
            return $this->sendSuccessResponse([]);
        } catch (Exception $error) {
            DB::rollBack();
            return $this->sendErrorResponse('internal_server_error', 500, [$error->getMessage()]);
        }
    }
}
