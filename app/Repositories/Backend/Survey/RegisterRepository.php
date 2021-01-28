<?php

namespace App\Repositories\Backend\Survey;

use App\Models\Register;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;

class RegisterRepository extends BaseRepository
{


    public function model()
    {
       return Register::class;
    }


    public function create(array $data) : bool
    {
        return DB::transaction(function () use ($data) {
            $register= parent::create($data);


            if($register)
            {

                return true;
            }

            return false;
        });
    }


    public function update(Register $register, array $data)
    {



        return DB::transaction(function () use ($register, $data) {
            if ($register->update($data)) {


                return true;
            }

          return false;
        });
    }


    public function RecordExists($uid,$os) : bool
    {
        return $this->model
                ->where('uid', $uid)->where('os', $os)
                ->count() > 0;
    }

}
