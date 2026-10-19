<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function pay(Request $request)
    {
        $type = ($request->input('employmentType', ''));
        $tier = ($request->input('positionTier', ''));
        $absent = (int) $request->input('daysAbsent', 0);
        $late = (int) $request->input('minutesLate', 0);
        $ot = (float) $request->input('overtimeHours', 0);
 
        if ($type === 'cos' || $type === 'contract of service') {
            $monthly = 18000.00; $sss = $phil = $pagibig = 0.0;
        } elseif ($type === 'Regular') {
            if ($tier === 'Senior') {
                $monthly = 40000.00; $sss = 1800.00; $phil = 1000.00; $pagibig = 200.00;
            } else {
                $monthly = 25000.00; $sss = 1125.00; $phil = 625.00; $pagibig = 200.00;
            }
        } else {
            return response()->json(['error' => 'Invalid employment_type'], 400);
        }
 
        $days_present = max(0, 22 - $absent);
        $daily = $monthly / 22.0;
        $hourly = $daily / 8.0;
        $late_ded = ($hourly / 60.0) * $late;
        $absent_ded = $daily * $absent;
        $ot_pay = $ot * ($hourly * 1.25);
        $gross = $monthly - $late_ded - $absent_ded + $ot_pay;
        $total_ded = $sss + $phil + $pagibig;
        $net = $gross - $total_ded;
 
        $r = fn($v) => round((float) $v, 2);
 
        return response()->json([
            'daysAbsent' => $absent,
            'employmentType' => $type,
            'positionTier' => $tier,
            'baseSalary' => $r($monthly),
            'daysPresent' => $days_present,
            'dailyRate' => $r($daily),
            'lateDeduction' => $r($late_ded),
            'absentDeduction' => $r($absent_ded),
            'overtimePayl' => $r($ot_pay),
            'grossPay' => $r($gross),
            'sss' => $r($sss),
            'philhealth' => $r($phil),
            'pagibig' => $r($pagibig),
            'totalDeductions' => $r($total_ded),
            'netPay' => $r($net),
        ]);
    }
}
