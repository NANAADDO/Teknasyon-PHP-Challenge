<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Backend\Generators;
use App\Models\Purchase;
use App\Models\User;
use App\Repositories\Backend\Survey\RegisterRepository;
use App\Traits\ApiResTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends APIcontroller
{
    use ApiResTypes;


    public function verifyAccount(Request $request)
    {

    $username = request()->header('username');
    $password = request()->header('password');
      $data=$request->all();
      $data['password']=$password;
      $data['username']=$username;
      $data['user_uid']=Generators::Uid();

        $user =  \Auth::attempt(['username'=>$username,'password'=>$password]);
        $uid = Auth::user()->user_uid;
        $os = Auth::user()->platform;
        if($user){
            if($os==$request->platform){
              $subscriptions = Purchase::where([['uid',$request->uid],['os',$os],['user_uid',$request->userUID]])->get();

                return $this->Ok(['userUID'=>$uid,'listSubscriptions'=>$subscriptions]);
            }
            return $this->Unauthorized();
        }
        else{
            return $this->Unauthorized();

        }

    }


    public function BIlogin(Request $request)
    {
        //
        if(!$request->has('email','password')){
            return [false ,'invalid_credentials.',401];
        }
        $credentials = $request->only('email','password');


        try{
            $user =  \Auth::attempt($credentials);
            if(!$user)
            {
                return [false ,'invalid_credentials',401];
            }
        }
        catch (JWTException $ex ){

            return [false, 'could_log_in',500];
        }

             $user = auth()->user();
            return [true,$user];

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


}
