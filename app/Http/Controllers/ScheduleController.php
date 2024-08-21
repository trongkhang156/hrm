<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleDetail;
use Illuminate\Http\Request;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;


class ScheduleController extends Controller
{
   
    public function index()
    {
        $schedules = Schedule::all();
        return view('admin.schedule.index', compact('schedules'));
    }

   
    public function create()
    {
        return view('admin.schedule.create');
    }

   
    public function store(StoreScheduleRequest $request)
    {
        Schedule::create($request->all());
        return back()->with('success', 'Schedule created successfully');
    }

  
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $scheduleDetails = ScheduleDetail::where('id_ca', $id)->get();
        
        $workTypes = getWorkTypesForDropdown(); 

        return view('admin.schedule.edit', compact('schedule', 'scheduleDetails', 'workTypes'));
    }

  
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->title = $request->input('title');
        $schedule->time_in = $request->input('time_in');
        $schedule->time_out = $request->input('time_out');
    
        // Chuyển đổi số phút thành định dạng H:i:s
        $breakTimeMinutes = (int) $request->input('break_time');
        $hours = intdiv($breakTimeMinutes, 60);
        $minutes = $breakTimeMinutes % 60;
        $schedule->break_time = sprintf('%02d:%02d:%02d', $hours, $minutes, 0);
    
        $schedule->save();
    
        return redirect()->route('schedule.index')->with('success', 'Schedule updated successfully.');
    }
    


   
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Schedule deleted successfully');
    }

    public function storeDetail(Request $request)
{

    ScheduleDetail::create([
        
        'id_ca' => $request->id_ca,
        'is_overtime' => $request->is_overtime,
        'starttime' => $request->starttime,
        'endtime' => $request->endtime,
        'isthrough_newday' => $request->isthrough_newday,
        'idcong' => $request->work_type_id,
       
    ]);

    return redirect()->route('schedule.edit', $request->schedule_id)
                     ->with('success', 'Schedule detail added successfully.');
}


   
    public function destroydetail(Request $request)
    {
        $scheduleDetail = ScheduleDetail::findOrFail($request->input('id'));
        $scheduleDetail->delete();
        return response()->json(['message' => 'Schedule detail deleted successfully']);
    }
}
