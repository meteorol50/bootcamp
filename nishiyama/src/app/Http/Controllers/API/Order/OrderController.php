<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Controllers\Controller;

use App\Http\Requests\CreateCartInfo;
use App\Http\Requests\UpdateCartInfoRequest;
use App\Models\RequestInfo;
use App\Models\Cart;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
   /**
     * Create order cart
     * @param \App\Http\Requests\CreateCartInfo $request
     * @return \Illuminate\Http\Response
     */
    public function CreateCartInfo(CreateCartInfo $request)
    {
        Cart::create([
            'item_id' => $request->item_id,
            'vehicle_no' => $request->vehicle_no,
            'user_id' => $request->user()->id,
            'status' => $request->status,
            'created_at' => now(),
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id
        ]);
        return $this->sendSuccessResponse([], 200, 'creation_successful');
    }
     /**
     * Update cart
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function UpdateCartInfo(UpdateCartInfoRequest $request)
    {
       
        try {            
            $user_id =  $request->user()->id;
            $Cart = Cart::where('user_id',$user_id)->firstOrFail();             
            $Cart->status = $request->status;
            $Cart->item_id = $request->item_id;
            $Cart->save();
            return $this->sendSuccessResponse(
                true,
                200,
                'update_successful'
            );

        } catch (Exception $error) {          
            DB::rollBack();
            return $this->sendErrorResponse('internal_server_error', 500, [$error->getMessage()]);
        }
    }

    
}
