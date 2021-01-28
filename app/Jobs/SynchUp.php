<?php

namespace App\Jobs;

use App\Helpers\General\SynchData;
use App\Models\Queuetest;
use App\Repositories\Backend\Survey\SurveySynchupRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SynchUp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 protected $survey;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $formdata;
    public function __construct(array  $formdata)
    {

        $this->formdata = $formdata;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SurveySynchupRepository $survey)

    {

        $dat = $this->formdata;

        foreach ($dat['data'] as $val) {
            $combine = array();
            $plot_data = [];
            $diagnostic_data = [];
            $observation_data = [];
            $farmer_baseline_data = [];
            $gps_point_data=[];
            $farm_baseline_c = [];
            $farm = [];
            $farmer = [];
            //LOGGINNG FARMER DATA RECEIVED
            $family_member_data = [];
                Log::info('Data Index :'.json_encode($val));
            if (!empty($val['farmer_c'])) {
                $farmer = $val['farmer_c'];
                foreach ($val['farmer_c'] as $value) {
                    if (SynchData::check_variable_data($value['answer']) != 1) {
                       if($value['field_name'] == 'household_gps_lat_c,household_gps_long_c'){
                          $split =  SynchData::split_gps($value['field_name']);
                           $split_answers =  SynchData::split_gps($value['answer']);
                           $combine[$split[0]] = $split_answers[0];
                           $combine[$split[1]] = $split_answers[1];

                       }

                        $combine[$value['field_name']] = $value['answer'];
                    }
                }
                $combine['birthday_c'] = $combine['birthday_c'] . '-01-01';
            }
            else{

               $farmer =[];
            }
                //$combine['birthday_c'] = $combine['birthday_c'] . '-01-01';
               // Log::info(json_encode($combine));
                if (!empty($val['farm_c'])) {
                    $farm = $val['farm_c'];
                    foreach ($val['farm_c'] as $value) {
                        if (SynchData::check_variable_data($value['answer']) != 1) {
                            $combine[$value['field_name']] = $value['answer'];
                        }
                    }
                }
                else{

                    $farm = [];
                }

                if (!empty($val['farmer_baseline_c'])) {
                    foreach ($val['farmer_baseline_c'] as $value) {
                        if (SynchData::check_variable_data($value['answer']) != 1) {
                            $farmer_baseline_data[$value['field_name']] = $value['answer'];
                        }
                    }
                }


            if (!empty($val['farm_baseline_c'])) {
                foreach ($val['farm_baseline_c'] as $value) {
                    if (SynchData::check_variable_data($value['answer']) != 1) {
                        $farm_baseline_data[$value['field_name']] = $value['answer'];
                    }
                }
            }
            else{
                $farm_baseline_data = [];

            }
                if (!empty($val['plot_c'])) {
                    $plot_data = $val['plot_c'];
                    $diagnostic_data = $val['diagnostic_monitoring_c'];
                    $observation_data = $val['observation_c'];
                } else {

                    $plot_data = [];
                    $diagnostic_data = [];
                    $observation_data = [];
                }

                if (!empty($val['gps_point_c'])) {
                   $gps_point_data = $val['gps_point_c'];

                }

            if (!empty($val['family_member_c'])) {
                        $family_member_data = $val['family_member_c'];
            }

            $combine['start_date_c'] = $dat['submission']['Start__c'];
            $combine['surveyor_id'] = $dat['submission']['Surveyor__c'];
            $combine['respondent_id'] = $val['external_id'];
            $data = [$combine, $plot_data, $diagnostic_data, $observation_data, $farmer_baseline_data, $farm,$farm_baseline_data,$farmer,$gps_point_data,$family_member_data];

            if ($survey->surveyExist($val['external_id']) > 0) {

                $res = $survey->updateById($val['external_id'], $data);
                $action = 'data update received on modifications: ';
            } else {
                $res = $survey->create($data);
                $action = 'data created received on insertion: ';
            }
            Log::info($action . json_encode($res));
        }
    }

}
