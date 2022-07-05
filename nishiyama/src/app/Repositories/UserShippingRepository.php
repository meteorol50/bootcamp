<?php

namespace App\Repositories;

use App\Models\UserShipping;
use Illuminate\Support\Facades\DB;

class UserShippingRepository extends BaseRepository {

        public static function userShippings($userId)
        {
                return UserShipping::select(['user_shippings.id as shipping_id', 'user_shippings.name', 
                                        'user_shippings.postal_code', 'user_shippings.prefecture_id',
                                                'user_shippings.city', 'user_shippings.address', 
                                                'user_shippings.building', 'user_shippings.tel',
                                                'prefectures.name as prefecture', DB::raw('0 as `default`')])
                        ->leftJoin('prefectures', 'prefectures.id', '=', 'user_shippings.prefecture_id')        
                        ->where('user_shippings.user_id', $userId)->orderBy('user_shippings.created_at', 'ASC');
        }
}