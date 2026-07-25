<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function kiosk()
    {
        return view('attendance.kiosk');
    }

    public function manage()
    {
        $students = collect([
            (object)['id'=>1,'student_number'=>'2026001','name'=>'Juan Dela Cruz','status'=>'Present'],
            (object)['id'=>2,'student_number'=>'2026002','name'=>'Maria Santos','status'=>'Absent'],
        ]);
        return view('attendance.manage', compact('students'));
    }

    public function reports()
    {
        $summary = [
            'today_total' => 24,
            'present' => 20,
            'absent' => 4,
            'last_scan' => '2026-05-09 09:12:34'
        ];
        return view('attendance.reports', compact('summary'));
    }
}
