<?php

namespace App\Http\Controllers\Api;


use App\Helpers\Backend\Generators;
use App\Models\Purchase;
use App\Repositories\Backend\Survey\PurchaseRepository;
use App\Traits\ApiResTypes;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Constants\StatusCodes;

class ReportController extends APIcontroller
{
    use ApiResTypes;
    protected $purchase;

    public function __construct(PurchaseRepository $purchase)
    {
        $this->purchase=$purchase;

    }


    public function daily(Request $request){


        $data = $this->purchase->MultipleRecordFetch(Purchase::class,[['day'],$request->datetime],['status',$request->status]);
        return $this->Ok($data);
    }

    public function operatingSystem(Request $request){

        $data = $this->purchase->MultipleRecordFetch(Purchase::class,[['day'],$request->os],['status',$request->status]);
        return $this->Ok($data);

    }

    public function application(Request $request){

        $data = $this->purchase->MultipleRecordFetch(Purchase::class,[['app'],$request->appID],['status',$request->status]);
        return $this->Ok($data);

    }







}
