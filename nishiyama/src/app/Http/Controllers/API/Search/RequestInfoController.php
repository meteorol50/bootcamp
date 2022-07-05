<?php

namespace App\Http\Controllers\API\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestInfoRequest;
use App\Models\RequestInfo;
use App\Models\ProductComment;
use App\Http\Requests\ProductCommentsRequest;

class RequestInfoController extends Controller
{
    //
    /**
     * Get prefecture info
     *
     * @param \App\Http\Requests\RequestInfoRequest
     * @return \Illuminate\Http\Response
     */
    public function requestInfoCreate(RequestInfoRequest $request)
    {
        $user = $request->user();

         $requestData = $request->all();

        $requestinfo = RequestInfo::create([
            'confirm_request_contents' =>  $requestData['confirm_request_contents'] ?? '',
            'parts_id' =>  $requestData['parts_id'],
            'vehicle_no' => $requestData['vehicle_no'] ?? '',
            'car_model_designation_no' => $requestData['car_model_designation_no'] ?? '',
            'classification_classification_no' => $requestData['classification_classification_no'] ?? '',
            'car_models_name' => $requestData['car_models_name'] ?? '',
            'model_year_month' =>  $requestData['model_year_month'] ?? '',
            'request_for_parts' =>  $requestData['request_for_parts'] ?? '',
            'request_memo' =>  $requestData['request_memo'] ?? '',
            'user_id' => $request->user()->id,
            'status' => RequestInfo::ACTIVE,
            'created_at' => now(),
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id
        ]);

        return $this->sendSuccessResponse([],200, 'creation_successful');

    }

    /**
     * Get Product Comments API
     *
     * @param \App\Http\Requests\ProductCommentsRequest $request
     * @return \Illuminate\Http\Response
     */

    public function getProductComments(ProductCommentsRequest $request)
    {

        $requestData = $request->safe()->all();        
        $offset = $requestData['offset'] ?? 0;
        $limit = $requestData['limit'] ?? env('DEFAULT_LIST_LIMIT', 50);
        $item_id=$requestData['item_id'];

         $fields = [
            'product_comments.item_id as item_id', 'product_comments.id as id', 'companies.name as exhibitor_user_name', 'product_comments.comment','product_comments.status','product_comments.created_at','product_comments.created_by'
        ];

        $query = ProductComment::selectRaw(implode(',', $fields))
            ->join('users', 'users.id', '=', 'product_comments.user_id')
            ->Join('companies', 'companies.id', '=', 'users.company_id')            
            ->where('product_comments.status', '=', 1)
            ->where('product_comments.item_id', $item_id);
       
        return $this->sendSuccessResponse($query->skip($offset)->take($limit)->get(),200, 'request_successful');

    }
}
