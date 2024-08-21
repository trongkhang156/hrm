<?php

namespace App\Http\Controllers;

use App\Models\ShiftSchedule;
use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Http\Request;


use App\Models\Datamita;
use Carbon\Carbon;

class ShiftScheduleController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', now()->month);
        $selectedYear = $request->input('year', now()->year);
        
        $shiftSchedules = ShiftSchedule::whereYear('shift_date', $selectedYear)
                                        ->whereMonth('shift_date', $selectedMonth)
                                        ->get();
                                        
        $shifts = Schedule::all();
        $employees = Employee::all();
    
        return view('admin.shiftschedule.index', compact('shiftSchedules', 'employees', 'selectedMonth', 'selectedYear', 'shifts'));
    }
    

    
    public function store(Request $request)
    {
        $schedules = $request->input('schedule', []);
    
        foreach ($schedules as $employeeId => $dates) {
            foreach ($dates as $date => $shiftId) {
                if (!empty($shiftId)) {
                    // Check if the schedule entry exists
                    $existingSchedule = ShiftSchedule::where('id_employees', $employeeId)
                        ->where('shift_date', $date)
                        ->first();
    
                    if ($existingSchedule) {
                        // Update existing schedule
                        $existingSchedule->id_ca = $shiftId;
                        $existingSchedule->save();
                    } else {
                        // Create new schedule
                        ShiftSchedule::create([
                            'id_employees' => $employeeId,
                            'shift_date' => $date,
                            'id_ca' => $shiftId,
                        ]);
                    }
                }
            }
        }
    
        return redirect()->route('shiftschedule.index')->with('success', 'Shift schedules saved successfully!');
    }
    
    public function show($id)
    {
        return response()->json(ShiftSchedule::findOrFail($id));
    }

    public function destroy($id)
    {
        ShiftSchedule::findOrFail($id)->delete();
        return response()->json(['message' => 'Schedule deleted successfully']);
    }
    
}
