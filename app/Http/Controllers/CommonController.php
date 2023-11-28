<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CommonController extends Controller
{
    public function addMonth(Request $request)
    {
        $start = Carbon::now();
        if ($request->month_start) {
            $start = Carbon::createFromFormat('d-m-Y', $request->month_start);
        }
        $result = $start->addMonths($request->month_to_add)->format('d-m-Y');
        return $this->successData($result);
    }
}
