<?php


namespace App\Repositories\Backend\Survey;

use App\Helpers\Auth\Auth;
use App\Models\Purchase;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;

class PurchaseRepository extends BaseRepository
{

    
    public function model()
    {
       return Purchase::class;
    }


    
    public function create(array $data) : bool
    {
        
        return DB::transaction(function () use ($data) {
            $purchase= parent::create($data);


            if($purchase)
            {

                return true;
            }

            return false;
        });
    }


        public function update(Purchase $purchase, array $data)
    {



        return DB::transaction(function () use ($purchase, $data) {
            if ($purchase->update($data)) {


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


    public function processPurchaseData($purchaseUID,$appID,$userID,$os,$data){

        if(!$this->RecordExists($purchaseUID,$os,$appID,$userID)){
            return $this->create($data);

        }
        return $this->update($this->model(),$data);
    }

    }
