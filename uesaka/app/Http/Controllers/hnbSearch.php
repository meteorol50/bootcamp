<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

#クラスhnbSearchで呼び出されると{"message":"Hello"}を返すメソッドSearchを定義
class hnbSearch extends Controller{
    public function Search($vin){
        $message = 'Hello';
    return response()->json([
    'message' => $message,
    'hnb' => $vin
    ]);
    }
}
