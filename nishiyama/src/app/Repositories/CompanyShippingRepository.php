<?php

namespace App\Repositories;

use App\Models\CompanyShipping;
use Illuminate\Support\Facades\DB;

class CompanyShippingRepository extends BaseRepository {

        public static function companyShippings($companyId)
        {
                return CompanyShipping::select(['company_shippings.id as shipping_id', 'company_shippings.name', 
                                                'company_shippings.postal_code', 'company_shippings.prefecture_id',
                                                'company_shippings.city', 'company_shippings.address', 
                                                'company_shippings.building', 'company_shippings.tel', 
                                                'prefectures.name as prefecture', DB::raw('1 as `default`')])
                ->leftJoin('prefectures', 'prefectures.id', '=', 'company_shippings.prefecture_id')
                ->where('company_shippings.company_id', $companyId)
                ->orderBy('company_shippings.created_at', 'ASC');
        }
}