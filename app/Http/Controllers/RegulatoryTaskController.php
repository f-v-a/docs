<?php

namespace App\Http\Controllers;

use App\Models\RegulatoryTask;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use Illuminate\Http\Request;

class RegulatoryTaskController extends Controller
{
    public static function findNextDay($start_date, $end_date, $periodicity, $today = false)
    {
//        $realTime = 'https://yandex.com/time/sync.json?geo=213';
        $dates = [];
        $interval = DateInterval::createFromDateString("{$periodicity} day");
        $nextDays = new DatePeriod($start_date, $interval, empty($end_date)
            ? $end_date = Carbon::create(new \DateTime($start_date))->addDays($periodicity) : $end_date);
        foreach ($nextDays as $nextDay) {
            if (count($dates) < 2) {
                if ($nextDay < now()) {
                    continue;
                } else {
                    $dates[] = $nextDay->isoFormat("Do MMMM YYYY");
                }
            } else {
                break;
            }
        }
        return ($today) ? $dates[0] ?? (!$start_date ?: $start_date->isoFormat("Do MMMM YYYY"))
            : $dates[1] ?? ($end_date ? $end_date->isoFormat("Do MMMM YYYY") : $end_date);
    }

    public static function findToday($start_date, $end_date, $periodicity): bool
    {
        $interval = DateInterval::createFromDateString("{$periodicity} day");
        $nextDays = new DatePeriod($start_date, $interval, empty($end_date)
            ? Carbon::create(new \DateTime($start_date))->addYears(3) : $end_date);
        foreach ($nextDays as $nextDay) {
            if ($nextDay < now()) {
                continue;
            } else {
                $date = date_sub($nextDay, date_interval_create_from_date_string("{$periodicity} days")) == Carbon::today();
                break;
            }
        }

        return (bool)$date;
    }

    public static function changeDaysToMonth($periodicity)
    {
        $countDaysInMonth = date('t', mktime(0, 0, 0, date("m", time())));

        return ($periodicity >= $countDaysInMonth) ? floor($periodicity / $countDaysInMonth) . " мес " . (
            ($periodicity % $countDaysInMonth == 0) ? "" : $periodicity % $countDaysInMonth . " дн ") : $periodicity . " дн";
    }

//    public static function showWeekDays($daysNumber = null, $arrayType = false)
//    {
//        $weekDays = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
//        foreach ($weekDays as $key => $weekDay) {
//            foreach (explode(",", $daysNumber) as $dayNumber) {
//                if ($key + 1 == $dayNumber) {
//                    $selectedDays[] = $weekDay;
//                }
//            }
//        }
//        return implode(', ', $selectedDays);
//    }
//
//    public static function findNextWeek($start_date, $end_date, $periodicity, $today = false, $daysNumber = null)
//    {
//        $dates = [];
//        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
//        $daysToArray = explode(',', $daysNumber);
//        $nextDays = CarbonPeriod::between($start_date, $end_date);
//
//        foreach ($nextDays as $nextDay) {
//            foreach ($weekDays as $key => $weekDay) {
//                foreach ($daysToArray as $day) {
//                    if (count($dates) < count($daysToArray) - 1 && $key + 1 == $day) {
//                        if (Carbon::parse($nextDay)->modify("{$weekDay}") <= now()) {
//                            continue;
//                        } else {
//                            foreach ($daysToArray as $days) {
//                                if ($days != max($daysToArray)) {
//                                    $dates[] = Carbon::parse($nextDays->current())->modify("{$weekDay}")->isoFormat('Do MMMM YYYY');
//                                }
//                                $nextDays->skip(10);
//                            }
//                        }
//                    }
//                }
//            }
//        }
//        dd($dates);
//        return ($today) ? $dates[0] : $dates[1] ?? $end_date->isoFormat('Do MMMM YYYY');
//    }

    public function index(Request $request)
    {
        if(!empty($request->get('sort'))) {
            $regulatories = RegulatoryTask::orderBy('id', $request->get('sort'))->get();
        }
        if(!empty($request->get('status'))) {
            $regulatories = RegulatoryTask::where('status',$request->get('status'))->get();
        }
        if(empty($request->get('sort')) && empty($request->get('status'))) {
            $regulatories = RegulatoryTask::orderBy('id', 'asc')->get();
        }

        return view("incidents.regulatory", compact("regulatories"));
    }
}
