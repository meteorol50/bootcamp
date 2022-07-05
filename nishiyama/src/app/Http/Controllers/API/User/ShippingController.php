<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterShippingRequest;
use App\Http\Requests\UpdateShippingRequest;
use App\Models\Company;
use App\Models\CompanyShipping;
use App\Models\UserInfo;
use App\Models\UserShipping;
use App\Repositories\CompanyShippingRepository;
use App\Repositories\UserShippingRepository;
use Illuminate\Http\Request;

class ShippingController extends Controller
{

    /**
     * Shipping Register API
     *
     * @param \App\Http\Requests\RegisterShippingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function registerShipping(RegisterShippingRequest $request)
    {
        $user = $request->user();
        $company = Company::find($user->company_id);
        $shipping = new UserShipping();
        if ($company && ($company->type != Company::TYPE_INDIVIDUAL)) {
            $shipping = new CompanyShipping();
            $shipping->company_id = $company->id;
        } else {
            $shipping->user_id = $user->id;
        }
        $shipping->fill($request->all());
        $shipping->created_by = $user->id;
        $shipping->updated_by = $user->id;
        $shipping->save();

        return $this->sendSuccessResponse([], 200, 'request_successful');
    }

    /**
     * Shipping update API
     *
     * @param \App\Http\Requests\UpdateShippingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updateShipping(UpdateShippingRequest $request)
    {
        $user = $request->user();
        $params = $request->safe()->all();
        $company = Company::find($user->company_id);
        $shipping = null;
        if ($company && ($company->type != Company::TYPE_INDIVIDUAL)) {
            $shipping = CompanyShipping::where('company_id', $company->id)
                ->where('id', $params['shipping_id'])->first();
            if (!$shipping) {
                return $this->sendErrorResponse('unauthorised_shipping_update', 400);
            }
        } else {
            $shipping = UserShipping::where('user_id', $user->id)
                ->where('id', $params['shipping_id'])->first();
            if (!$shipping) {
                return $this->sendErrorResponse('unauthorised_shipping_update', 400);
            }
        }
        $shipping->fill($request->all());
        $shipping->updated_by = $user->id;
        $shipping->save();

        return $this->sendSuccessResponse([], 200, 'request_successful');
    }

    /**
     * Shipping list API
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function listShipping(Request $request)
    {
        $user = $request->user();

        $limit = ($request->has('limit') && $request->limit > 0) ? $request->limit : self::LIMIT;
        $offset = ($request->has('offset') && $request->offset > 0) ? $request->offset : self::OFFSET;

        $company = Company::find($user->company_id ?? 0);
        $userInfo = UserInfo::find($user->user_info_id ?? 0);
        $response = [];

        if ($company && ($company->type != Company::TYPE_INDIVIDUAL)) {
            $shippings = CompanyShippingRepository::companyShippings($user->company_id)
                ->limit($limit)->offset($offset)->get();
            $response['shipping'] = $shippings;
        } else {
            $shippings = UserShippingRepository::userShippings($user->id)
                ->limit($limit)->offset($offset)->get();
            $response['shipping'] = $shippings;
        }

        return $this->sendSuccessResponse($response, 200, 'request_successful');
    }
}
