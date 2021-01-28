<?php

namespace App\Helpers\Backend;

use Illuminate\Support\Facades\DB;

class  Report {


    protected static $country_table = 'country_c';


    public static  function get_country_admin_level($countryID){

        $resp = DB::table(self::$country_table)->select('admin_level')->where('id',$countryID)->first();

        if(!empty($resp)){

            $data  =$resp->admin_level;
        }
        else{

            $data = 0;
        }

        return $data;

    }

    public static  function validate_data($data){

        if(isset($data)){

            return $data;

        }
        else{
            return '';
        }
    }
}
