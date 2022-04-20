<?php

namespace App\Http\Controllers;

use App\Models\RegulatoryTask;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;

class RegulatoryTaskController extends Controller
{
    // private function isDate($str)
    // {
    //     return is_numeric(strtotime($str));
    // }

    // private function findInterval($datas): array
    // {
    //     foreach ($datas as $data) {
    //         $interval = DateInterval::createFromDateString("{$data->periodicity} day");
    //         $datesArray = [];
    //         if ($this->isDate($data->end_date)) {
    //             $dateRange = new DatePeriod(new DateTime($data->start_date), $interval, new DateTime($data->end_date));
    //         } else {
    //             $dateRange = new DatePeriod(new DateTime($data->start_date), $interval, Carbon::now()->addYear(10));
    //         }
    //         foreach ($dateRange as $date) {
    //             array_push($datesArray, $date->format('Y-m-d'));
    //         }
    //     }
    //     return $datesArray;
    // }

    public function index()
    {

        // $regulars = RegulatoryTask::where('mode', 'день')
        //     ->where('id', 1)
        //     ->get();
        // dd($regulars);
        // $dat = $this->findInterval($regulars);

        return view('incidents.regulatory');
    }
}
