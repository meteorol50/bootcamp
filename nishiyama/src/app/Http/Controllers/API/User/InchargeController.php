<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInchargeRequest;
use App\Http\Requests\DeleteInchargeRequest;
use App\Http\Requests\ListRequest;
use App\Http\Requests\UpdateInchargeRequest;
use App\Models\InCharge;

class InchargeController extends Controller
{

    /**
     * Create incharge
     *
     * @param \App\Http\Requests\CreateInchargeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function registerIncharge(CreateInchargeRequest $request)
    {
        $incharge = InCharge::create([
            'status' => InCharge::ACTIVE,
            'company_id' => $request->user()->company_id,
            'name' => $request->name,
            'position' => $request->position,
            'created_at' => now(),
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id
        ]);
        return $this->sendSuccessResponse($incharge, 200, 'creation_successful');
    }

    /**
     * Delete in charge
     *
     * @param \App\Http\Requests\DeleteInchargeRequest $request
     * @param \Illuminate\Http\Response
     */
    public function deleteIncharge(DeleteInchargeRequest $request) {
        $inCharge = InCharge::find($request->incharge_id);
        if ($inCharge->company_id != $request->user()->company_id) {
            return $this->sendErrorResponse('cannot_delete_incharge', 403);
        }
        $inCharge->status = InCharge::DELETED;
        $inCharge->updated_by = $request->user()->id;
        $inCharge->save();
        return $this->sendSuccessResponse([], 200, 'deletion_successful');
    }

    /**
     * List in charges
     *
     * @param \App\Http\Requests\ListRequest $request
     * @param \Illuminate\Http\Response
     */
    public function listIncharges(ListRequest $request) {
        $requestData = $request->safe()->all();
        $sortOrder = $requestData['sort_order'] ?? 'desc';
        $orderBy = $requestData['order_by'] ?? 'in_charges.id';
        $query = InCharge::where([
            'company_id' => $request->user()->company_id,
            'status' => InCharge::ACTIVE
        ])->when(isset($requestData['search']), function ($searchQuery) use ($requestData) {
            return $searchQuery->where('in_charges.name', 'like', "%{$requestData['search']}%");
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
     * Update in charge
     *
     * @param \App\Http\Requests\UpdateInchargeRequest $request
     * @param \Illuminate\Http\Response
     */
    public function updateIncharge(UpdateInchargeRequest $request) {
        $inCharge = InCharge::find($request->incharge_id);
        if ($inCharge->company_id != $request->user()->company_id) {
            return $this->sendErrorResponse('cannot_edit_incharge', 403);
        }
        if ($inCharge->status != InCharge::ACTIVE) {
            return $this->sendErrorResponse('incharge_deleted', 403);
        }
        $inCharge->name = $request->name;
        $inCharge->position = $request->position;
        $inCharge->updated_by = $request->user()->id;
        $inCharge->save();
        return $this->sendSuccessResponse($inCharge);
    }
}
