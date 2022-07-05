<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    const STATUS_SUSPENDED = 0;
    const STATUS_VALID = 1;
    const STATUS_EMAIL_AUTH_IN_PROGRESS = 2;

    const MANAGEMENT_NON_ADMIN = 0;
    const MANAGEMENT_ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'is_management', 'email', 'company_id', 'user_info_id', 'verification_code', 'expired_at', 'verified_at',
        'crypted_password', 'salt', 'access_token', 'reset_password_token', 'reset_password_expired_at', 'last_login_at',
        'login_times', 'withdraw_count', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'access_token',
        'reset_password_token',
        'crypted_password',
        'verification_code'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'verified_at' => 'datetime',
        'reset_password_expired_at' => 'datetime',
        'expired_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    /**
     * The attributes that company or user info data.
     *
     * @var array
     */
    // 【TODO:不要かも】
    protected $user_detail = [
        'name' => '',
        'type' => '',
        'image' => '',
        'prefecture_id' => '',
        'city' => '',
        'address' => '',
        'building' => '',
        'tel' => '',
        'other' => ''
    ];

    /**
     * Relation that must always be loaded.
     *
     * @var array
     */
    protected $with = ['company','userInfo'];


    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    // protected $with = ['userInfo'];

    public function userShippings()
    {
        return $this->hasMany(UserShipping::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function userInfo()
    {
        return $this->belongsTo(UserInfo::class);
    }

    /**
     * Validation rules for current model
     *
     * @return Collection
     */
    public static function rules()
    {
        return collect([
            'email' => 'required|string|email',
            'verification_code' => 'required|string|max:5'
        ]);
    }

    /**
     * Get user type
     *
     * @return integer
     */
    public function getUserType()
    {
        if ($this->user_info_id) {
            return 3;
        } else {
            return $this->company->type;
        };
    }

    /**
     * Get user type name
     *
     * @return string
     */
    public function getUserTypeName()
    {
        if ($this->user_info_id) {
            return '個人';
        } elseif ($this->company->type === 1) {
            return '法人';
        } else {
            return '個人事業主';
        };
    }

    /**
     * Check company
     *
     * @return boolean
     */
    public function isCompany()
    {
        if ($this->user_info_id) {
            return false;
        } else true;
    }

    /**
     * Get image
     *
     * @return boolean
     */
    public function getImage()
    {
        // dump('■model');
        if ($this->user_info_id) {
            return $this->userInfo->image;
        } else {
            return $this->company->image;
        };
    }

    /**
     * Get image
     *
     * @return boolean
     */
    public function getName()
    {
        if ($this->user_info_id) {
            return $this->userInfo->name;
        } else {
            return $this->company->name;
        };
    }

    /**
     * Get tel
     *
     * @return boolean
     */
    public function getTel()
    {
        if ($this->user_info_id) {
            return $this->userInfo->tel;
        } else {
            return $this->company->tel;
        };
    }

    /**
     * Get other
     *
     * @return boolean
     */
    public function getOther()
    {
        if ($this->user_info_id) {
            return $this->userInfo->other;
        } else {
            return $this->company->other;
        };
    }

    /**
     * Get company or user_info
     *
     * @return boolean
     */
    public function getCompanyOrUserInfo()
    // 【TODO：不要かも】
    {
        if ($this->user_info_id) {
            $this->user_detail['name']          =   $this->user_info->name;
            $this->user_detail['type']          =   $this->user_info->type;
            $this->user_detail['image']         =   $this->user_info->image;
            $this->user_detail['prefecture_id'] =   $this->user_info->prefecture_id;
            // 【TODO：都道府県名も取得する。】
            $this->user_detail['city']          =   $this->user_info->city;
            $this->user_detail['address']       =   $this->user_info->address;
            $this->user_detail['building']      =   $this->user_info->building;
            $this->user_detail['tel']           =   $this->user_info->tel;
            $this->user_detail['other']         =   $this->user_info->other;
            $this->user_detail['name']          =   $this->user_info->name;
        } else {
        };
    }

}
