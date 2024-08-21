<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Datamita; 

class AttendanceController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', today()->month);
        $selectedYear = $request->input('year', today()->year);
    
        $employees = Employee::all(); // Lấy danh sách nhân viên từ database
    
        return view('admin.attendance.index', compact('employees', 'selectedMonth', 'selectedYear'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $employees = Employee::all();
        return view('admin.attendance.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request)
    {
        //
        Attendance::create($request->all());
        return back()->with('success', 'user crated successfully');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $attendance = Attendance::findOrFail($id);
        $employees = Employee::all();
        return view('admin.attendance.edit', compact(['employees', 'attendance']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
        $attendance->update($request->all());
        return back()->with('success', 'user updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
        // $attendance->delete();
        // return back()->with('success', 'user deleted successfully');
    }

    public function report(Attendance $attendance, Request $request) {
        $year = $request->input('year');
        $month = $request->input('month');

        $daysInMonth = Carbon::create($year, $month)->daysInMonth;


        $employees = Employee::all();

        $userAttendanceData = [];

        foreach ($employees as $employee) {
            $userAttendanceData[$employee->id] = [
                'present' => 0,
                'absent' => 0,
            ];
           
            
            // $attendances = $employee->attendances->where('date', 'like', "$year-$month%");
            $attendances = $employee->attendances->filter(function ($attendance) use ($year, $month)
             {
                return Carbon::parse($attendance->date)->year == $year &&
                       Carbon::parse($attendance->date)->month == $month;
            });

            foreach ($attendances as $attendance) {
                if ($attendance->status === '1') {
                    $userAttendanceData[$employee->id]['present']++;
                } elseif ($attendance->status === '0') {
                    $userAttendanceData[$employee->id]['absent']++;
                }
            }

            $date = Carbon::parse($attendance->date);
            $year = $date->year;
            $month = $date->month;
            $day = $date->day;
        }

        // $attendanceData = Employee::select('employees.firstname', 'employees.lastname', 'attendances.date', 'attendances.checkin_time')
        //     ->leftJoin('attendances', function ($join) use ($year, $month) {
        //         $join->on('employees.id', '=', 'attendances.employee_id')
        //             ->whereYear('attendances.date', $year)
        //             ->whereMonth('attendances.date', $month);
        //     })
        //     ->orderBy('employees.firstname')
        //     ->orderBy('attendances.date')
        //     ->get();

        return view('admin.attendance.report', compact('attendance', 'employees', 'daysInMonth', 'userAttendanceData', 'date'));
        // return view('admin.attendance.report');
    // }
    }

    public function barcode() {
        return view('admin.attendance.barcode');
    }
    public function process(Request $request)
    {
        // Lấy startDate và endDate từ request
        $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d H:i:s');
        $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d H:i:s');
    
        // Lấy dữ liệu từ bảng checkinout trên kết nối sqlsrv
        $getMita = DB::connection('sqlsrv')
            ->table('checkinout')
            ->whereBetween('NgayCham', [$startDate, $endDate])
            ->get();
    
        foreach ($getMita as $mita) {
            // Kiểm tra dữ liệu đã tồn tại trong Datamita
            $exists = Datamita::where('MaChamCong', $mita->MaChamCong)
                ->where('NgayCham', $mita->NgayCham)
                ->where('GioCham', $mita->GioCham)
                ->exists();
    
            if (!$exists) {
                // Nếu dữ liệu chưa tồn tại, thêm mới vào Datamita
                Datamita::create([
                    'MaChamCong' => $mita->MaChamCong,
                    'NgayCham' => $mita->NgayCham,
                    'GioCham' => $mita->GioCham,
                    'KieuCham' => $mita->KieuCham,
                    'NguonCham' => $mita->NguonCham,
                    'MaSoMay' => $mita->MaSoMay,
                    'TenMay' => $mita->TenMay,
                ]);
            }
        }
    
        $dataMitAs = Datamita::all(); 
        return view('admin.attendance.showdata', compact('dataMitAs'));
    }
    
    
    public function savemita(Request $request)
    {
        $data = $request->input('data');

        foreach ($data as $item) {
            $datamita = Datamita::findOrFail($item['id']);
            $datamita->update([
                'MaChamCong' => $item['MaChamCong'],
                'NgayCham' => $item['NgayCham'],
                'GioCham' => $item['GioCham'],
                'KieuCham' => $item['KieuCham'],
                'NguonCham' => $item['NguonCham'],
                'MaSoMay' => $item['MaSoMay'],
                'TenMay' => $item['TenMay'],
            ]);
        }

        return response()->json(['message' => 'Cập nhật dữ liệu thành công']);
    }
    public function deleteMita(Request $request)
    {
        
            $id =   $request->input('id');
            $dataMita = DataMita::findOrFail($id);
            $dataMita->delete();
            return response()->json(['message' => 'Xóa dữ liệu thành công']);
        
    }
    public function showdata()
    {
    // Lấy dữ liệu từ bảng Datamita
    $dataMitAs = Datamita::all();

    // Chuyển hướng đến view 'showdata' với dữ liệu đã lấy
    return view('admin.attendance.showdata', compact('dataMitAs'));
    }



}
