<?php


namespace App\Repositories\Backend\Survey;

use App\Helpers\Auth\Auth;
use App\Models\Device;
use App\Models\Survey\SkipLogic;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;

class DeviceRepository extends BaseRepository
{

    
    public function model()
    {
       return Device::class;
    }


    
    public function create(array $data) : bool
    {
        
        return DB::transaction(function () use ($data) {
            $device= parent::create($data);


            if($device)
            {

                return true;
            }

            return false;
        });
    }


        public function update(Register $device, array $data)
    {



        return DB::transaction(function () use ($device, $data) {
            if ($device->update($data)) {


                return true;
            }

            return false;
        });
    }


        public function RecordExists($uid,$os,$appID,$userID) : bool
    {
        return $this->model
                ->where([['uid', $uid],['os', $os],['app_id', $appID],['user_uid', $userID]])
                ->count() > 0;
    }


    public function processDeviceData($deviceUID,$appID,$userID,$os,$data){

        if(!$this->RecordExists($deviceUID,$os,$appID,$userID)){
            return $this->create($data);

        }
        return $this->update($this->RecordFetch($this->model(),[['uid', $deviceUID],['os', $os],['app_id', $appID],['user_uid', $userID]]),$data);
    }

    }
