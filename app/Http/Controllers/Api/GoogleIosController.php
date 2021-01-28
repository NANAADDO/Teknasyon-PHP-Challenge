<?php

namespace App\Http\Controllers\Api;


use App\Constants\StatusCodes;
use App\Helpers\Backend\Generators;
use App\Traits\ApiResTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;




class GoogleIosController extends APIcontroller
{
    use ApiResTypes;


    public function verification(Request $request)
    {
        $datetime = new Carbon('now', new \DateTimeZone("UTC"));

        $receipt = $request->receipt;
        $lastValue = substr($receipt, -1);
        if(is_numeric($lastValue)) {


            if ($lastValue % 2 == 0){

        return response()->json([
            'status' => false
        ]);
    }
            else{
                return response()->json([
                    'status' => true,
                    'expire_date'=>$datetime->toDateTimeString()
                ]);

            }
            }
        else{
            return response()->json([
                'status' => false
            ]);
        }
        }
}
