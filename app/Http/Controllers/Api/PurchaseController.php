<?php

namespace App\Http\Controllers\Api;


use App\Helpers\Backend\Generators;
use App\Models\Device;
use App\Models\Purchase;
use App\Models\Register;
use App\Models\User;
use App\Repositories\Backend\Survey\DeviceRepository;
use App\Repositories\Backend\Survey\PurchaseRepository;
use App\Repositories\Backend\Survey\RegisterRepository;
use App\Traits\ApiResTypes;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Constants\StatusCodes;

class PurchaseController extends APIcontroller
{
    use ApiResTypes;
    protected $purchase;
    protected $register;
    protected $device;
    const StatusActive = 1;

    public function __construct(RegisterRepository $register, DeviceRepository $device,PurchaseRepository $purchase)
    {
        $this->register = $register;
        $this->device = $device;
        $this->purchase=$purchase;

    }


    public function index(Request $request){


        $token = $request->client_token;
        $reciept=$request->receipt;
        $registerInfo = $this->register->RecordFetch(Register::class, [['client_token', $token]]);
        $os=$registerInfo->os;
        $User_uid=$registerInfo->user_uid;
        $uid=$registerInfo->uid;
        $device = $this->device->RecordFetch(Device::class,['uid',$registerInfo->uid]);
        $response = Http::post('http://127.0.0.1:8000/api/verification/googleios', ['receipt' => $request->receipt,'os'=>$os]);
        $result = json_decode($response->body(), true);
        if ($result["status"] == "false") {

            $this->FailedContentCustomize('Verification Process Failed!!',StatusCodes::OK);
        }
        else{
            $puchaseData = [];
            $puchaseData['reciept']=$reciept;
            $puchaseData['user_uid']=$User_uid;
            $puchaseData['expire_date']=$result["expire_date"];
            $puchaseData['os']=$os;
            $puchaseData=$device->app_id;
            $puchaseData['status']=self::StatusActive;
            if($this->purchase->create($puchaseData)){
                $this->SuccessContentCustomize('Verification Process Successful!!', StatusCodes::OK);
            }
            else {
                $this->FailedContentCustomize('Verification Process Failed!!',StatusCodes::OK);
            }



        }



    }







}
