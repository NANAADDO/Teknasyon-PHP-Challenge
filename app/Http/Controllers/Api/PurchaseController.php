<?php

namespace App\Http\Controllers\Api;


use App\Helpers\Backend\Generators;
use App\Models\Purchase;
use App\Models\User;
use App\Repositories\Backend\Survey\DeviceRepository;
use App\Repositories\Backend\Survey\RegisterRepository;
use App\Traits\ApiResTypes;
use Illuminate\Http\Request;


class PurchaseController extends APIcontroller
{
    use ApiResTypes;
    protected $purchase;


    public function __construct(RegisterRepository $purchase)
    {
        $this->purchase = $purchase;

    }


    public function index(Request $request){
        $token =Generators::UidVersion3();
        $data = $request->all();



        }







}
