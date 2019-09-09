<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\AdminController;

use App\Services\ServiceStatistics;
use Illuminate\Http\Request;
use DB;

class StatisticsController extends AdminController
{

    public function highchartsMonthlyAmount(){
        $monthlyAmount = ServiceStatistics::highchartsMonthlyAmount();
        return $this->sendResponse($monthlyAmount);
    }

    public function highchartsMonthlyAmountCallbacks(){
        $monthlyAmount = ServiceStatistics::highchartsMonthlyAmountCallbacks();
        return $this->sendResponse($monthlyAmount);
    }

    public function fullCalendar(Request $request)
    {
        $start = $request->input('start');
        $end   = $request->input('end');

        $calendar = ServiceStatistics::fullCalendar($start, $end);

        return  $this->sendResponse($calendar);
    }

}