<?php

namespace App\Http\Controllers\Parts;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetItemDetailInfoRequest;
use App\Http\Requests\GetItemListInfoRequest;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class PartsController extends Controller
{
    /**
     * Get item list info
     * @param \App\Http\Requests\GetItemListInfoRequest $request
     * @return \Illuminate\Http\Response
     * TODO: Finish API
     */
    public function getItemListInfo(GetItemListInfoRequest $request)
    {
        $requestData = $request->safe()->all();
        $offset = $requestData['offset'] ?? 0;
        $limit = $requestData['limit'] ?? env('DEFAULT_LIST_LIMIT', 50);
        $fields = [
            'items.id as item_id', 'items.item_title', 'makers.id as maker_id', 'makers.name as maker_name',
            'cars.id as car_id', 'cars.name as car_name', 'car_models.id as car_model_id',
            'car_models.name as car_model_name', 'parts.id as parts_id', 'parts.name as parts_name',
            'parts.screen_display_item as screen_display_item', 'colors.id as color_id',
            'CONCAT(colors.main_color_code," ",colors.sub_color_code) as color_code', 'cars_info.mileage', 'cars_info.tire',
            $this->getQualityRanksSqlCaseStatement(), 'items.sales_price', 'items.parts_no',
            $this->getAwsUriAddedLink('item_photo_info.path_to_photo_storage', 'path_to_photo_storage'), 'items.status',
            'CASE WHEN ' . (auth('api')->check() ? 'favorite.id>' : '') . '0 THEN 1 ELSE 0 END as favorite_flg'
        ];
        $joinsInfo = [
            'cars_info' => ['leftJoin', [['items.cars_info_id', '=', 'cars_info.id']]],
            'car_models' => ['leftJoin', [['cars_info.car_model_id', '=', 'car_models.id']], ['car_models.id' => $request->car_model_id]],
            'cars' => ['leftJoin', [['cars.id', '=', 'car_models.car_id']], ['cars.id' => $request->car_id]],
            'makers' => ['leftJoin', [['makers.id', '=', 'cars.maker_id']], ['makers.id' => $request->maker_id]],
            'parts' => ['leftJoin', [['parts.id', '=', 'items.parts_id']]],
            'item_photo_info' => ['leftJoin', [['item_photo_info.item_id', '=', 'items.id']]],
            'exterior_colors' => ['leftJoin', [['cars_info.exterior_color_id', '=', 'exterior_colors.id']]],
            'colors' => ['leftJoin', [['colors.id', '=', 'exterior_colors.color_id']]]
        ];
        $whereInfo = [
            'items.parts_id' => $request->parts_id,
            'cars_info.exterior_color_id' => $request->color_id
        ];
        if (isset($requestData['quality_rank'])) {
            $whereInfo['items.quality_rank'] = $this->parseQualityRanks($request->quality_rank);
        }
        if (isset($requestData['rebuilt_new_outside'])) {
            $whereInfo['items.parts_classification'] = [0, 1];
        }
        if ($request->on_sale_flg) {
            $whereInfo['items.status'] = 4;
        }
        if ($request->parts_no_match_flg) {
            $whereInfo['car_models.car_model_designation_no'] = $request->car_model_designation_no;
            $whereInfo['grades.classification_no'] = $request->classification_no;
            $whereInfo['cars_info.vehicle_no'] = $request->vehicle_no;
        }
        if (isset($requestData['car_model_designation_no'], $requestData['classification_no'], $requestData['vehicle_no'])) {
            $whereInfo['makers.status'] = 1;
            $whereInfo['cars.status'] = 1;
            $whereInfo['car_models.status'] = 1;
            $joinsInfo['grades'] = ['leftJoin', [['car_models.id', '=', 'grades.car_model_id']]];
        }
        $conditionalWhereInfo = [
            ['items.sales_price', '>=', $request->lower_price_limit],
            ['items.sales_price', '<=', $request->price_limit],
            ['cars_info.mileage', '>=', $request->mileage_lower_limit],
            ['cars_info.mileage', '<=', $request->mileage_upper_limit]
        ];
        if (auth('api')->check()) {
            $joinsInfo['favorite'] = [
                'leftJoin',
                [['favorite.item_id', '=', 'items.id']],
                ['favorite.status' => 1, 'favorite.user_id' => auth('api')->id()]
            ];
        }
        $query = Item::selectRaw(implode(',', $fields));
        $this->generateJoinQuery($joinsInfo, $query);
        $this->addWhereEqualsDataToQuery($query, $whereInfo);
        $this->addConditionalWhereDataToQuery($query, $conditionalWhereInfo);
        $query->dd();
        return $this->sendSuccessResponse([
            'count' => $query->count(),
            'items' => $query->skip($offset)->take($limit)->get()
        ], 200, 'request_successful');
    }

    /**
     * Get item detail info
     * @param \App\Http\Requests\GetItemDetailInfoRequest
     * @return \Illuminate\Http\Response
     * TODO: Complete partial API based on clarifications
     */
    public function getItemDetailInfo(GetItemDetailInfoRequest $request)
    {
        $fields = [
            'items.id as item_id', /*'makers.id as maker_id', 'makers.name as maker_name', */ 'cars.id as car_id',
            'cars.name as car_name', 'car_models.id as car_model_id', 'car_models.name as car_model_name',
            'parts.id as parts_id', 'parts.name as parts_name', 'COUNT(favorite.id) as favorite_count',
            '(items.sales_price+items.shipping_rates) as total_price', 'items.sales_price', 'items.shipping_rates',
            'items.parts_no', 'items.parts_manufacturer_parts_no', 'items.quality_rank',
            'parts_categories.core_return_flag', 'items.guarantee', 'items.guarantee_contents',
            'CONCAT(items.parts_infomation,"、",items.remark_1,"、",items.remark_2) as parts_infomation',
            'items.injury_information as parts_condition', 'cars_info.exterior_color_id',
            'CONCAT(colors.main_color_code," ",colors.sub_color_code) as color_code',
            'CONCAT(colors.main_color_name," ",colors.sub_color_name) as color_name', 'cars_info.car_model_id',
            'car_models.name as car_model_name', 'cars_info.full_model_car_model', 'cars_info.grade_id',
            'grades.name as grade_name', 'cars_info.vehicle_no',
            'CONCAT(cars_info.model_year," / ",cars_info.model_month) as model_year',
            'CONCAT(cars_info.car_model_designation_no,"-",cars_info.classification_no) as distinctive_model_number',
            'cars_info.vehicle_type', 'engines.name as engine_name', 'cars_info.transmission_model',
            'cars_info.drive_method', 'cars_info.engine_displacement', 'cars_info.interior_color_id',
            'colors_interior.main_color_name as interior_color_name', 'colors_interior.main_color_code as interior_color_no',
            'cars_info.mileage', 'items.registration_date', 'items.shipping_from_prefecture_id',
            'prefectures.name as prefectures_name', 'items.shipping_cutoff_time', 'items.scheduled_delivery_date'
        ];
        $joinsInfo = [
            'cars_info' => ['leftJoin', [['items.cars_info_id', '=', 'cars_info.id']], ['cars_info.status' => 1]],
            // 'makers' => ['leftJoin', ''],
            'car_models' => ['leftJoin', [['cars_info.car_model_id', '=', 'car_models.id']]],
            'cars' => ['leftJoin', [['cars.id', '=', 'car_models.car_id']], ['cars.status' => 1]],
            'grades' => ['leftJoin', [['cars_info.grade_id', '=', 'grades.id']], ['grades.status' => 1]],
            'engines' => ['leftJoin', [['engines.id', '=', 'cars_info.engine_id']], ['engines.status' => 1]],
            'parts' => ['leftJoin', [['parts.id', '=', 'items.parts_id']]],
            'parts_categories' => ['leftJoin', [['parts_categories.id', '=', 'parts.category_id']]],
            'exterior_colors' => ['leftJoin', [['exterior_colors.id', '=', 'cars_info.exterior_color_id']], ['exterior_colors.status' => 1]],
            'colors' => ['leftJoin', [['exterior_colors.color_id', '=', 'colors.id']]],
            'interior_colors' => ['leftJoin', [['interior_colors.id', '=', 'cars_info.interior_color_id']], ['interior_colors.status' => 1]],
            'colors as colors_interior' => ['leftJoin', [['colors_interior.id', '=', 'interior_colors.color_id']]],
            'prefectures' => ['leftJoin', [['prefectures.id', '=', 'items.shipping_from_prefecture_id']]]
        ];
        if (auth('api')->check()) {
            $joinsInfo['favorite'] = [
                'leftJoin',
                [['favorite.item_id', '=', 'items.id']],
                ['favorite.status' => 1, 'favorite.user_id' => auth('api')->id()]
            ];
        }
        DB::statement('SET sql_mode = ""');
        $query = Item::selectRaw(implode(',', $fields));
        $this->generateJoinQuery($joinsInfo, $query);
        $data = $query->get();
        DB::statement('SET sql_mode = "only_full_group_by"');
        if ($data->count() == 1 && is_null($data->first()->item_id)) {
            $data = collect();
        }
        return $this->sendSuccessResponse($data, 200, 'request_successful');
    }
}
