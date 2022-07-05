<?php

namespace App\Repositories;

use App\Models\InCharge;

class InchargeRepository extends BaseRepository {

        public static function companyIncharge($companyId)
        {
                return InCharge::select(["id as in_charge_id", "name", "position"])
                ->where('company_id', $companyId)->orderBy('created_at', 'ASC');
        }
}