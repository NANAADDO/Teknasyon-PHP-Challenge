<?php

namespace App\Http\Controllers\Api;


use App\Helpers\Backend\Generators;
use App\Models\Register;
use App\Models\User;
use App\Repositories\Backend\Survey\DeviceRepository;
use App\Repositories\Backend\Survey\RegisterRepository;
use App\Traits\ApiResTypes;
use Illuminate\Http\Request;


class RegisterController extends APIcontroller
{

    use ApiResTypes;
    protected $register;
    protected $device;


    public function __construct(RegisterRepository $register, DeviceRepository $device)
    {
        $this->register = $register;
        $this->device=$device;
    }


    public function register(Request $request){
        $token =Generators::UidVersion3();
        $data = $request->all();
        $deviceUID=$data['uid'];
        $os = $data['os'];
        $userUID = $data['userUID'];
        $appID = $data['appID'];
         $data['app_id']=$appID;
        $data['client_token']=$token;
        $data['user_uid']=$userUID;
        /****CHECKING TO SEE IF DEVICE BELONGING TO USER ACCOUNT ALREADY EXIST
         IN THE REGISTER TABLE*************/
        if($this->register->RecordExists($deviceUID,$os,$userUID)) {
            //return $this->Ok($this->register->RecordExists($deviceUID,$os,$userUID));

            /*********GETTING THE DEVICE INFO IN THE REGISTER TABLE ***********/
            $RegiatratioDeviceInfo = $this->register->RecordFetch(Register::class, [['user_uid', $userUID],
                ['uid', $deviceUID], ['os', $os]]);

            /*******GENERATING A NEW TOKEN AND UPDATING THE EXISTING RECORDS
             * WHEN THERE IS A CALL TO THE  REGISTER API*************/
            $this->register->update($RegiatratioDeviceInfo, $data);

            /*************PROCESSING THE DEVICE INFO INTO THE DEVICE TABLE**************/
            if($this->device->processDeviceData($deviceUID, $appID, $userUID, $os, $data)){
                return $this->Ok(["client_token"=>''.$token.'']);

            }

        }
        else{
            /***********REGISTERING DEVICE AND GENERATING TOKEN IF DOES NOT EXIST IN THE REGISTER TABLE*********/
            if($this->register->create($data)){

                /*************PROCESSING THE DEVICE INFO INTO THE DEVICE TABLE**************/
                if($this->device->processDeviceData($deviceUID,$appID,$userUID,$os,$data)){
                    return $this->Ok(["client_token"=>''.$token.'']);

                }

            }

        }




    }


}
