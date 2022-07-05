<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserInfo;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Resources\UserMyPageInfoResource;
use App\Models\Company;
use App\Models\CompanyShipping;
use App\Models\InCharge;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserShipping;
use App\Repositories\CompanyShippingRepository;
use App\Repositories\InchargeRepository;
use App\Repositories\UserShippingRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    /**
     * Register user info
     *
     * @param \App\Http\Requests\RegisterUserInfo $request
     * @return \Illuminate\Http\Response
     */
    public function registerUserInfo(RegisterUserInfo $request)
    {
        try {
            $requestData = $request->safe()->all();
            $user = User::where('email', $requestData['email'])->first();
            if ($user->company_id || $user->user_info_id) {
                return $this->sendErrorResponse('user_info_already_registered', 403);
            }
            DB::beginTransaction();
            $user->crypted_password = bcrypt($requestData['password']);
            $user->status = User::STATUS_VALID;
            if ($requestData['type'] == 3) {
                $userInfoData = [
                    'name' => $requestData['user_name'],
                    'postal_code' => $requestData['postal_code'],
                    'prefecture_id' => $requestData['prefecture_id'],
                    'city' => $requestData['city'],
                    'address' => $requestData['address'],
                    'building' => $requestData['building'] ?? NULL,
                    'tel' => $requestData['tel'],
                    'fax' => $requestData['fax'] ?? NULL,
                    'other' => $requestData['other'] ?? NULL,
                    'created_at' => now(),
                    'created_by' => $user->id,
                    'updated_by' => $user->id
                ];
                $shippingData = Arr::only($userInfoData, [
                    'name', 'postal_code', 'prefecture_id', 'city', 'address', 'building', 'tel', 'created_at', 'created_by',
                    'updated_by'
                ]);
                $shippingData['user_id'] = $user->id;
                $shipping = UserShipping::create($shippingData);
                $userInfoData['shipping_id'] = $shipping->id;
                if ($request->hasFile('image')) {
                    $userInfoData['image'] = $request->image->storeAs(
                        'users/images',
                        'userImage_' . $user->id . '_' . time() . '.' . $request->image->extension()
                    );
                }
                $userInfo = UserInfo::create($userInfoData);
                $user->user_info_id = $userInfo->id;
            }
            if ($requestData['type'] == 1 || $requestData['type'] == 2) {
                $companyInfoData = [
                    'name' => $requestData['company_name'] ?? NULL,
                    'type' => $requestData['type'],
                    'postal_code' => $requestData['postal_code'],
                    'prefecture_id' => $requestData['prefecture_id'],
                    'city' => $requestData['city'],
                    'address' => $requestData['address'],
                    'building' => $requestData['building'] ?? NULL,
                    'tel' => $requestData['tel'],
                    'fax' => $requestData['fax'] ?? NULL,
                    'other' => $requestData['other'] ?? NULL,
                    'created_at' => now(),
                    'created_by' => $user->id,
                    'updated_by' => $user->id
                ];
                if ($request->hasFile('image')) {
                    $companyInfoData['image'] = $request->image->storeAs(
                        'company/images',
                        'companyImage_' . $user->id . '_' . time() . '.' . $request->image->extension()
                    );
                }
                $company = Company::create($companyInfoData);
                $shippingData = Arr::only($companyInfoData, [
                    'name', 'postal_code', 'prefecture_id', 'city', 'address', 'building', 'tel', 'created_at', 'created_by',
                    'updated_by'
                ]);
                $shippingData['user_id'] = $user->id;
                $shippingData['company_id'] = $company->id;
                $shipping = CompanyShipping::create($shippingData);
                $company->shipping_id = $shipping->id;
                $company->save();
                InCharge::create([
                    'status' => 1,
                    'company_id' => $company->id,
                    'name' => $requestData['user_name'],
                    'position' => $requestData['position'],
                    'created_at' => now(),
                    'created_by' => $user->id,
                    'updated_by' => $user->id
                ]);
                $user->company_id = $company->id;
            }
            $user->save();
            DB::commit();
            return $this->sendSuccessResponse($user, 200, 'creation_successful');
        } catch (Exception $error) {
            DB::rollBack();
            return $this->sendErrorResponse('internal_server_error', 500, [$error->getMessage()]);
        }
    }

    /**
     * User My Page Info
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function myPageInfo(Request $request)
    {
        $user = $request->user();
        $company = Company::find($user->company_id ?? 0);
        $userInfo = UserInfo::find($user->user_info_id ?? 0);
        $response = [];

        if ($company && ($company->type != Company::TYPE_INDIVIDUAL)) {
            $address = $company;
            $shippings = CompanyShippingRepository::companyShippings($user->company_id)->limit(3)->get();
            $inCharges = InchargeRepository::companyIncharge($user->company_id)->limit(5)->get();
            $response = (new UserMyPageInfoResource($user, $company, $userInfo,  $address, $shippings, $inCharges))->resolve();
        } else {
            $address = $userInfo;
            $shippings = UserShippingRepository::userShippings($user->id)->limit(3)->get();
            $inCharges = collect([]);
            $response = (new UserMyPageInfoResource($user, $company, $userInfo, $address, $shippings, $inCharges))->resolve();
        }

        return $this->sendSuccessResponse($response, 200, 'request_successful');
    }

    /**
     * User Info Update Images
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserInfoImage(Request $request)
    {
        $validator = $this->validator($request->all(), [
            'image' => 'required|image'
        ]);
        $validator->validate();

        $user = $request->user();
        $company = Company::find($user->company_id);
        $userInfo = UserInfo::find($user->user_info_id);

        if ($request->hasFile('image')) {
            $img = Image::make($request->file('image'));
            $this->resizeImage($img);
            $time = time();
            $tempFilePath = public_path() . "/tempImages/{$request->user()->id}_{$time}.jpg";
            $img->save($tempFilePath, 80, 'jpg');

            $image = Storage::putFileAs(
                "/users/{$user->id}",
                $tempFilePath,
                'profile_' . $user->id . '.jpg'
            );
            unlink($tempFilePath);

            if ($company && ($company->type != Company::TYPE_INDIVIDUAL)) {
                $company->image = $image;
                $company->save();
            } else if ($userInfo) {
                $userInfo->image = $image;
                $userInfo->save();
            } else {
                Storage::delete($image);
            }
        }

        return $this->sendSuccessResponse(
            [],
            200,
            'request_successful'
        );
    }

    /**
     * Update User Info API
     *
     * @param \App\Http\Requests\UpdateUserInfoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserInfo(UpdateUserInfoRequest $request)
    {
        $user = $request->user();
        $company = Company::find($user->company_id);
        $userInfo = UserInfo::findOrNew($user->user_info_id);
        $params = $request->safe()->all();

        if ($company && ($company->type != Company::TYPE_INDIVIDUAL)) {
            $company->fill($params);
            $company->name = $params['company_name'];
            $company->updated_by = $user->id;
            $company->save();
        } else {
            $userInfo->fill($params);
            $userInfo->updated_by = $user->id;
            $userInfo->save();
        }
        return $this->sendSuccessResponse([], 200, 'request_successful');
    }
}
