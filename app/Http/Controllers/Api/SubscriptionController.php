<?php

namespace App\Http\Controllers\Api;


use App\Helpers\Backend\Generators;
use App\Models\Device;
use App\Models\Purchase;
use App\Models\Register;
use App\Models\User;
use App\Repositories\Backend\Survey\PurchaseRepository;
use App\Repositories\Backend\Survey\RegisterRepository;
use App\Traits\ApiResTypes;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Constants\StatusCodes;


class SubscriptionController extends APIcontroller
{
    use ApiResTypes;

    protected $register;
    protected $purchase;

    public function __construct(RegisterRepository $register, PurchaseRepository $purchase)
    {
        $this->register = $register;
        $this->purchase = $purchase;
    }

    public function checkSubscription(Request $request){
        $token = $request->client_token;
        $registerInfo = $this->register->RecordFetch(Register::class, [['client_token', $token]]);
        if(!isset($registerInfo)){

            return $this->FailedContentCustomize('Incorrect Token/Device Details Not Found!!',StatusCodes::NOT_FOUND);
        }
        $User_uid=$registerInfo->user_uid;
        $uid=$registerInfo->uid;
        $subscription = $this->purchase->RecordFetch(Purchase::class,[['uid',$registerInfo->uid],['user_uid',$User_uid]]);

        if(!isset($subscription)){

            return $this->FailedContentCustomize('No Subscription Details Found!!',StatusCodes::NOT_FOUND);
        }

        else{

               return  $this->SuccessContentCustomize(['status'=>$subscription->status], StatusCodes::OK);

        }

    }

}
