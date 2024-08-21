<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShiftSchedule;
use App\Models\Datamita;
use App\Models\ScheduleDetail;
use App\Models\Employee;
use Carbon\Carbon;
use Log;

class WorkHoursController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->input('year', Carbon::now()->year);
        $selectedMonth = $request->input('month', Carbon::now()->month);
        $employees = Employee::with('designation')->get();
        $workHours = $this->calculateWorkHoursForMonth($selectedYear, $selectedMonth);

        return view('admin.work_hours.index', compact('workHours', 'selectedYear', 'selectedMonth', 'employees'));
    }

    public function calculate(Request $request)
    {
        $selectedYear = $request->input('year', Carbon::now()->year);
        $selectedMonth = $request->input('month', Carbon::now()->month);

        return redirect()->route('work_hours.index', ['year' => $selectedYear, 'month' => $selectedMonth]);
    }

    protected function calculateWorkHoursForMonth($year, $month)
    {
        $shiftSchedules = ShiftSchedule::with(['employee', 'schedule'])
            ->whereYear('shift_date', $year)
            ->whereMonth('shift_date', $month)
            ->get();

        $workHours = [];

        foreach ($shiftSchedules as $shiftSchedule) {
            $workDetails = $this->calculateWorkDetails($shiftSchedule);
            $shiftDate = Carbon::parse($shiftSchedule->shift_date)->format('Y-m-d');

            $workHours[$shiftSchedule->employee->id][$shiftDate] = $workDetails;
        }

        Log::info('Work Hours Calculated', ['workHours' => $workHours]);

        return $workHours;
    }

    protected function calculateWorkDetails($shiftSchedule)
    {
        $datamitas = Datamita::where('MaChamCong', $shiftSchedule->id_employees)
                              ->whereDate('NgayCham', $shiftSchedule->shift_date)
                              ->orderBy('GioCham', 'asc')
                              ->get();
    
        if ($datamitas->isEmpty()) {
            return [['id_cong' => '-', 'cong_name' => '', 'hours' => '', 'time_logs' => [], 'shift_date' => '']];
        }
    
        $scheduleDetails = ScheduleDetail::with('worktype')->where('id_ca', $shiftSchedule->id_ca)->get();
        $workDetails = [];
        $timeLogs = $datamitas->pluck('GioCham')->map(fn($time) => Carbon::parse($time)->format('d/m/Y H:i'))->toArray();
        $dayCheckInOut = Carbon::parse($datamitas->first()->NgayCham)->format('Y-m-d');
    
        foreach ($scheduleDetails as $detail) {
            $totalWorkHours = 0;
            $breakTime = $detail->break_time ?? '00:00:00';
            $breakTime = Carbon::parse($breakTime);
    
            $startTime = Carbon::createFromFormat('Y-m-d H:i:s', "$dayCheckInOut {$detail->starttime}");
            $endTime = Carbon::createFromFormat('Y-m-d H:i:s', "$dayCheckInOut {$detail->endtime}");
            $breakTimeMinutes = $breakTime->hour * 60 + $breakTime->minute;
            $breakTimeHours = $breakTimeMinutes / 60;
    
            $checkIns = $datamitas->filter(fn($item) => $item->MaSoMay % 2 !== 0)->pluck('GioCham')->map(fn($time) => Carbon::parse($time));
            $checkOuts = $datamitas->filter(fn($item) => $item->MaSoMay % 2 === 0)->pluck('GioCham')->map(fn($time) => Carbon::parse($time));
    
            if ($checkIns->isNotEmpty() && $checkOuts->isNotEmpty()) {
                $totalWorkHours = $this->calculateWorkHours($checkIns, $checkOuts, $startTime, $endTime, $breakTimeHours);
            }
    
            $maxHours = $detail->worktype->max;
            $totalWorkHours = $totalWorkHours > $maxHours ? $maxHours : $totalWorkHours;
    
            $workDetails[$detail->worktype->id] = [
                'id_cong' => $detail->idcong,
                'cong_name' => $detail->worktype->name,
                'hours' => round($totalWorkHours, 2),
            ];
        }
    
        $workDetails = array_values($workDetails);
    
        if (empty($workDetails)) {
            $workDetails[] = [
                'id_cong' => '-',
                'cong_name' => '',
                'hours' => '',
            ];
        }
    
        return ['work_details' => $workDetails, 'time_logs' => $timeLogs, 'shift_date' => $dayCheckInOut];
    }
    

    private function calculateWorkHours($checkIns, $checkOuts, $startTime, $endTime, $breakTimeHours)
    {
        $firstCheckIn = $checkIns->first();
        $lastCheckOut = $checkOuts->last();
        
        $firstCheckIn = $firstCheckIn < $startTime ? $startTime : $firstCheckIn;
        $lastCheckOut = $lastCheckOut < $endTime ? $lastCheckOut : $endTime;

        if ($firstCheckIn->lt($lastCheckOut)) {
            $interval = $lastCheckOut->diff($firstCheckIn);
            $totalWorkHours = $interval->h + ($interval->i / 60) - $breakTimeHours;
        } else {
            $totalWorkHours = 0;
        }

        return $totalWorkHours;
    }
}


