<?php

namespace App\Http\Controllers\API\Operation;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDeleteFavoriteRequest;
use App\Http\Requests\CreateProductCommentsRequest;
use App\Http\Requests\GetFavoriteInfoRequest;
use App\Http\Requests\GetPartsSameVinInfoRequest;
use App\Http\Requests\GetVehicleNoInfoRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use App\Models\CarModel;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\ProductComment;
use Exception;
use Illuminate\Support\Facades\DB;

class OperationController extends Controller
{
    /**
     * Get vehicle no info
     * @param \App\Http\Requests\GetVehicleNoInfoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getVehicleNoInfo(GetVehicleNoInfoRequest $request)
    {
        $data = CarModel::selectRaw(implode(',', [
            'SUBSTRING_INDEX(car_models.name, "-", -1) as name', 'makers.name as maker_name'
        ]))->join('cars', 'car_models.car_id', '=', 'cars.id')
            ->join('makers', 'cars.maker_id', '=', 'makers.id')
            ->join('grades', 'car_models.id', '=', 'grades.car_model_id')
            ->where([
                'car_models.car_model_designation_no' => $request->car_model_designation_no,
                'grades.classification_no' => $request->classification_no
            ])->get();
        return $this->sendSuccessResponse($data, 200, 'request_successful');
    }

    /**
     * Create or delete favorite
     * @param \App\Http\Requests\CreateDeleteFavoriteRequest $request
     * @return \Illuminate\Http\Response
     */
    public function createDeleteFavorite(CreateDeleteFavoriteRequest $request)
    {
        $requestData = $request->safe()->all();
        $data = [
            'item_id' => $requestData['item_id'],
            'user_id' => $request->user()->id
        ];
        try {
            DB::beginTransaction();
            $favoriteObject = Favorite::firstOrNew($data);
            if (isset($requestData['status'])) {
                $favoriteObject->status = $requestData['status'];
            }
            if (isset($favoriteObject->id)) {
                $favoriteObject->updated_by = $request->user()->id;
            } else {
                $favoriteObject->created_by = $request->user()->id;
            }
            $favoriteObject->save();
            DB::commit();
            return $this->sendSuccessResponse($favoriteObject, 200, 'creation_successful');
        } catch (Exception $error) {
            DB::rollBack();
            return $this->sendErrorResponse('internal_server_error', 500, [$error->getMessage()]);
        }
    }

    /**
     * Get Favorite info
     * @param \App\Http\Requests\GetFavoriteInfoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getFavoriteInfo(GetFavoriteInfoRequest $request)
    {
        $requestData = $request->safe()->all();
        $offset = $requestData['offset'] ?? 0;
        $limit = $requestData['limit'] ?? env('DEFAULT_LIST_LIMIT', 50);
        $fields = [
            'items.id as item_id', 'items.item_title', 'parts.screen_display_item', 'colors.id as color_id',
            'CONCAT(colors.main_color_code, " ", colors.sub_color_code) as color_code', 'cars_info.mileage',
            'cars_info.tire', 'items.quality_rank', 'items.sales_price', 'items.parts_no',
            $this->getAwsUriAddedLink('item_photo_info.path_to_photo_storage', 'path_to_photo_storage'), 'items.status',
            "CASE WHEN favorite.item_id = items.id THEN 1 ELSE 0 END AS favorite_flg"
        ];
        $query = Item::selectRaw(implode(',', $fields))
            ->join('favorite', 'items.id', '=', 'favorite.item_id')
            ->leftJoin('cars_info', 'items.cars_info_id', '=', 'cars_info.id')
            ->leftJoin('exterior_colors', 'cars_info.exterior_color_id', '=', 'exterior_colors.id')
            ->leftJoin('colors', 'exterior_colors.color_id', '=', 'colors.id')
            ->leftJoin('item_photo_info', 'items.id', '=', 'item_photo_info.item_id')
            ->join('parts', 'items.parts_id', '=', 'parts.id')
            ->where('favorite.user_id', $request->user()->id);
        if ($requestData['now_on_sale_flg'] == 1) {
            $query->where('items.status', 4);
        } elseif ($requestData['now_on_sale_flg'] == 0) {
            $query->whereIn('items.status', [4, 5]);
            $fields[array_search(
                "CASE WHEN favorite.item_id = items.id THEN 1 ELSE 0 END AS favorite_flg",
                $fields
            )] = "CASE WHEN 1 THEN 1 ELSE 0 END AS favorite_flg";
        }
        return $this->sendSuccessResponse(
            $query->skip($offset)->take($limit)->get(),
            200,
            'request_successful'
        );
    }

    /**
     * Get parts same vin info
     * @param \App\Http\Requests\GetPartsSameVinInfoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getPartsSameVinInfo(GetPartsSameVinInfoRequest $request)
    {
        $requestData = $request->safe()->all();
        $offset = $requestData['offset'] ?? 0;
        $limit = $requestData['limit'] ?? env('DEFAULT_LIST_LIMIT', 50);
        $query = Item::selectRaw(implode(',', [
            'items.id as item_id', 'makers.id as maker_id', 'makers.name as maker_name', 'cars.id as car_id',
            'cars.name as car_name', 'car_models.id as car_model_id', 'car_models.name as car_model_name',
            'parts.id as part_id', 'parts.name as part_name', 'colors.id as color_id',
            'CONCAT(colors.main_color_code, " ", colors.sub_color_code) as color_code', 'cars_info.mileage as mileage',
            'cars_info.tire as tire', 'items.quality_rank as quality_rank', 'items.sales_price as sales_price',
            'items.parts_no', $this->getAwsUriAddedLink('item_photo_info.path_to_photo_storage', 'path_to_photo_storage')
        ]))->leftJoin('cars_info', 'items.cars_info_id', '=', 'cars_info.id')
            ->leftJoin('car_models', 'cars_info.car_model_id', '=', 'car_models.id')
            ->leftJoin('cars', 'car_models.car_id', '=', 'cars.id')
            ->leftJoin('makers', 'cars.maker_id', '=', 'makers.id')
            ->join('parts', 'items.parts_id', '=', 'parts.id')
            ->leftJoin('exterior_colors', 'cars_info.exterior_color_id', '=', 'exterior_colors.id')
            ->leftJoin('colors', 'exterior_colors.color_id', '=', 'colors.id')
            ->leftJoin('item_photo_info', 'items.id', '=', 'item_photo_info.item_id')
            ->when(auth('api')->check(), function ($whenQuery) {
                return $whenQuery->leftJoin('cart', function ($join) {
                    $join->on('items.id', '=', 'cart.item_id')
                        ->where('cart.user_id', auth('api')->id())
                        ->whereNotIn('cart.status', [1, 2, 3]);
                });
            })->where([
                'cars_info.status' => 1,
                'items.status' => 1,
                'parts.status' => 1,
                'exterior_colors.status' => 1,
                'colors.status' => 1,
                'cars_info.id' => $request->cars_id
            ])->orderBy('parts.category_id', 'asc');
        return $this->sendSuccessResponse(
            $query->skip($offset)->take($limit)->get(),
            200,
            'request_successful'
        );
    }

    /**
     * Create product comments
     * @param \App\Http\Requests\CreateProductCommentsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function createProductComments(CreateProductCommentsRequest $request)
    {
        ProductComment::create([
            'item_id' => $request->item_id,
            'comment' => $request->comment,
            'exhibitor_flg' => $request->user()->company_id ? 1 : 0,
            'user_id' => $request->user()->id,
            'created_by' => $request->user()->id
        ]);
        return $this->sendSuccessResponse([], 200, 'creation_successful');
    }

    /**
     * Get number of products from items table with status = 4
     * @return \Illuminate\Http\Response
     */
    public function getNumberOfProducts()
    {
        return $this->sendSuccessResponse([
            'count' => Item::where('status', 4)->count()
        ], 200, 'request_successful');
    }
     /**
     * Update favourite
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function DeleteFavorite(UpdateFavoriteRequest $request)
    {
       
        try {
            $favorite = Favorite::where('id', '=', $request->favorite_id)->where('user_id', '=',  $request->user()->id)->firstOrFail();    
            $favorite->status = Favorite::DELETED;
            $favorite->updated_by = $request->user()->id;
            $favorite->save();
           
            return $this->sendSuccessResponse(
                true,
                200,
                'deletion_successful'
            );

        } catch (Exception $error) {
          
            DB::rollBack();
            return $this->sendErrorResponse('internal_server_error', 500, [$error->getMessage()]);
        }
    }
}
