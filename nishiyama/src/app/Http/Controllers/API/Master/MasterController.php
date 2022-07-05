<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartListRequest;
use App\Models\Parts;
use App\Http\Requests\CarModelsListRequest;
use App\Http\Requests\CarsListRequest;
use App\Http\Requests\ListRequest;
use App\Http\Requests\MakersListRequest;
use App\Http\Requests\VerifyTokenRequest;
use App\Models\Car;
use App\Http\Requests\ExteriorColorInfoRequest;
use App\Models\CarModel;
use App\Models\ExteriorColor;
use App\Models\Maker;
use App\Models\Prefecture;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class MasterController extends Controller
{
    /**
     * Get prefecture info
     * @param \App\Http\Requests\PartListRequest
     * @return \Illuminate\Http\Response
     */
    public function getPartsInfo(PartListRequest $request)
    {
        $requestData = $request->safe()->all();
        $query = Parts::selectRaw(implode(',', [
            'parts.id', 'parts_categories.id category_id', 'parts_categories.name category_name', 'parts.name',
            'parts.parts_image_file_path', 'parts_categories.core_return_flag', 'parts.disp_num', 'parts.status'
        ]))->join('parts_categories', 'parts_categories.id', '=', 'parts.category_id')
            ->where('parts.status', 1)->where('parts_categories.status', 1);
        return $this->sendSuccessResponse(
            $query->get(),
            200,
            'request_successful'
        );
    }

    /**
     * Get prefecture data
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getPrefectureData(Request $request)
    {
        $request->validate(['pincode' => 'required|string|max:8|regex:' . config('regex.pincode')]);
        $url = 'https://zipcloud.ibsnet.co.jp/api/search';
        $params = ['zipcode' => $request->pincode];
        $response = $this->getDataFromUrl($url, $params, 'GET', 'JSON');
        if ($response['status'] && $response['statusCode'] == 200) {
            if (empty($response['content']['results'])) {
                return $this->sendErrorResponse('no_data', 404);
            }
            $addressData = reset($response['content']['results']);
            $prefecture = Prefecture::select('id')->where('name', $addressData['address1'])->first();
            if (!$prefecture) {
                return $this->sendErrorResponse('not_found', 404);
            }
            return $this->sendSuccessResponse([
                'prefecture_id' => $prefecture->id,
                'prefecture_name' => $addressData['address1'],
                'municipality' => $addressData['address2'],
                'building_name' => $addressData['address3'],
                'zipcode' => str_replace('-', '', $request->pincode)
            ]);
        }
        return $this->sendErrorResponse('internal_server_error', 500);
    }

    /**
     * Get prefecture info
     *
     * @param \App\Http\Requests\ListRequest
     * @return \Illuminate\Http\Response
     */
    public function getPrefectureInfo(ListRequest $request)
    {
        $requestData = $request->safe()->all();
        $sortOrder = $requestData['sort_order'] ?? 'desc';
        $orderBy = $requestData['order_by'] ?? 'prefectures.id';
        $query = Prefecture::select([
            'prefectures.id', 'prefectures.name'
        ])->when(isset($requestData['search']), function ($searchQuery) use ($requestData) {
            return $searchQuery->where('prefectures.name', 'like', "%{$requestData['search']}%");
        })->orderBy($orderBy, $sortOrder);
        if (isset($requestData['paginate']) && $requestData['paginate']) {
            $offset = $requestData['offset'] ?? 0;
            $limit = $requestData['limit'] ?? env('DEFAULT_LIST_LIMIT', 50);
            $query->skip($offset)->take($limit);
        }
        return $this->sendSuccessResponse(
            $query->get(),
            200,
            'request_successful'
        );
    }

    /**
     * Verify token
     * @param \App\Http\Requests\VerifyTokenRequest
     * @return \Illuminate\Http\Response
     */
    public function verifyToken(VerifyTokenRequest $request)
    {
        $data = Crypt::decryptString($request->token);
        $data = json_decode($data);
        if ($request->type == 'resetPassword') {
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
            return $this->sendSuccessResponse([]);
        }
    }

    /**
     * List makers
     * @param \App\Http\Requests\MakersListRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getMakersInfo(MakersListRequest $request)
    {
        $requestData = $request->safe()->all();
        $awsUri = $this->generateAwsPath();
        $query = Maker::selectRaw(implode(',', [
            'id', 'name', "CONCAT(\"{$awsUri}\", maker_logo_path) as maker_logo_path", 'disp_num', 'status'
        ]));
        if (isset($requestData['id'])) {
            $query->where('id', $requestData['id']);
        }
        if (isset($requestData['status'])) {
            $query->where('status', $requestData['status']);
        }
        if (isset($requestData['search'])) {
            $query->where('name', 'like', "%{$requestData['search']}%");
        }
        $offset = $requestData['offset'] ?? 0;
        $limit = $requestData['limit'] ?? env('DEFAULT_LIST_LIMIT', 50);
        return $this->sendSuccessResponse(
            $query->skip($offset)->take($limit)->get(),
            200,
            'request_successful'
        );
    }

    /**
     * Get cars info
     * @param \App\Http\Requests\CarsListRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getCarsInfo(CarsListRequest $request)
    {
        $requestData = $request->safe()->all();
        $query = Car::selectRaw(implode(',', [
            'cars.id', 'makers.id as maker_id', 'makers.name as maker_name', 'cars.name', 'cars.status'
        ]))->join('makers', 'cars.maker_id', '=', 'makers.id');
        if (isset($requestData['maker_id'])) {
            $query->where('cars.maker_id', $requestData['maker_id']);
        }
        if (isset($requestData['id'])) {
            $query->where('cars.id', $requestData['id']);
        }
        if (isset($requestData['name'])) {
            $query->where('cars.name', 'like', "%{$requestData['name']}%");
        }
        if (isset($requestData['status'])) {
            $query->where('cars.status', $requestData['status']);
        }
        $offset = $requestData['offset'] ?? 0;
        $limit = $requestData['limit'] ?? env('DEFAULT_LIST_LIMIT', 50);
        return $this->sendSuccessResponse(
            $query->skip($offset)->take($limit)->get(),
            200,
            'request_successful'
        );
    }

    /**
     * Get cars model info
     * @param \App\Http\Requests\CarModelsListRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getCarModelsInfo(CarModelsListRequest $request)
    {
        $requestData = $request->safe()->all();
        $query = CarModel::selectRaw(implode(',', [
            'car_models.id', /*'makers.id as maker_id', 'makers.name as maker_name', 'cars.id as car_id', 'cars.name as car_name',*/
            'car_models.name', 'car_models.car_model_designation_no', 'car_models.model_from_year', 'car_models.model_from_month',
            'car_models.model_to_year', 'car_models.model_to_month', 'car_models.status'
        ]))->join('cars', 'car_models.car_id', '=', 'cars.id')->join('makers', 'cars.maker_id', '=', 'makers.id');
        if (isset($requestData['car_id'])) {
            $query->where('car_models.car_id', $requestData['car_id']);
        }
        if (isset($requestData['model_from_year'])) {
            $query->where('car_models.model_from_year', '>=', $requestData['model_from_year']);
        }
        if (isset($requestData['model_from_month'])) {
            $query->where('car_models.model_from_month', '>=', $requestData['model_from_month']);
        }
        if (isset($requestData['model_to_year'])) {
            $query->where('car_models.model_to_year', '<=', $requestData['model_to_year']);
        }
        if (isset($requestData['model_to_month'])) {
            $query->where('car_models.model_to_month', '<=', $requestData['model_to_month']);
        }
        if (isset($requestData['name'])) {
            $query->where('car_models.name', 'like', "%{$requestData['name']}%");
        }
        if (isset($requestData['car_model_designation_no'])) {
            $query->where('car_models.car_model_designation_no', $requestData['car_model_designation_no']);
        }
        if (isset($requestData['status'])) {
            $query->where('car_models.status', $requestData['status']);
        }
        if (isset($requestData['paginate']) && $requestData['paginate']) {
            $offset = $requestData['offset'] ?? 0;
            $limit = $requestData['limit'] ?? env('DEFAULT_LIST_LIMIT', 50);
            $query->skip($offset)->take($limit);
        }
        return $this->sendSuccessResponse(
            $query->get(),
            200,
            'request_successful'
        );
    }

    /**
     * Get Exterior colors info
     * @param \App\Http\Requests\ExteriorColorInfoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function getExteriorColorsInfo(ExteriorColorInfoRequest $request)
    {
        $requestData = $request->safe()->all();
        $query = ExteriorColor::selectRaw(implode(',', [
            'exterior_colors.id', 'makers.id as maker_id', 'makers.name as maker_name', 'cars.id as car_id',
            'cars.name as car_name', 'car_models.id as car_model_id', 'car_models.name as car_model_name',
            'colors.main_color_code', 'colors.main_color_name', 'colors.sub_color_code', 'colors.sub_color_name',
            'exterior_colors.status', 'grades.name as grade_name', 'grades.classification_no as grade_classification_no'
        ]))->join('colors', 'exterior_colors.color_id', '=', 'colors.id')
            ->join('car_models', 'exterior_colors.car_model_id', '=', 'car_models.id')
            ->leftJoin('grades', 'car_models.id', '=', 'grades.car_model_id')
            ->join('makers', 'colors.maker_id', '=', 'makers.id')
            ->join('cars', 'car_models.car_id', '=', 'cars.id');
        if (isset($requestData['maker_id'])) {
            $query->where('makers.id', $requestData['maker_id']);
        }
        if (isset($requestData['car_id'])) {
            $query->where('cars.id', $requestData['car_id']);
        }
        if (isset($requestData['car_model_id'])) {
            $query->where('car_models.id', $requestData['car_model_id']);
        }
        if (isset($requestData['car_model_designation_no'])) {
            $query->where('car_models.car_model_designation_no', $requestData['car_model_designation_no']);
        }
        if (isset($requestData['classification_no'])) {
            $query->where('grades.classification_no', $requestData['classification_no']);
        }
        if (isset($requestData['status'])) {
            $query->where('exterior_colors.status', $requestData['status']);
        }
        $offset = $requestData['offset'] ?? 0;
        $limit = $requestData['limit'] ?? env('DEFAULT_LIST_LIMIT', 50);
        return $this->sendSuccessResponse(
            $query->skip($offset)->take($limit)->get(),
            200,
            'request_successful'
        );
    }
}
