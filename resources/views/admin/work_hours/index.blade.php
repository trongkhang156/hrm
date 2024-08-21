@extends('layouts.admin')

@section('title')
    {{ __('Calculate Work Hours') }}
@endsection

@section('header')
@endsection

@section('content')
    <section class="row">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-10">
                <form action="{{ route('work_hours.calculate') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <label for="year" class="form-label">{{ __('Năm') }}</label>
                            <select id="year" name="year" class="form-select">
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" @if ($i == $selectedYear) selected @endif>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col">
                            <label for="month" class="form-label">{{ __('Tháng') }}</label>
                            <select id="month" name="month" class="form-select">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" @if ($i == $selectedMonth) selected @endif>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tính công</button>
                </form>
               
                <div class="mt-5">
                    <table class="table table-hover my-0 table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">Tên nhân viên</th>
                                <th scope="col">Chức vụ</th>
                                <th scope="col">Mã nhân viên</th>
                                @php
                                    $dates = [];
                                    $daysInMonth = \Carbon\Carbon::create($selectedYear, $selectedMonth)->daysInMonth;
                                    
                                    for ($i = 1; $i <= $daysInMonth; ++$i) {
                                        $dates[] = $i;
                                    }
                                @endphp
                                @foreach ($dates as $date)
                                    <th scope="col">{{ $date }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->employe_name . ' ' . $employee->lastname }}</td>
                                    <td>{{ $employee->designation->title }}</td>
                                    <td>{{ $employee->id }}</td>
                                    @foreach ($dates as $date)
                                        @php
                                            $currentDate = \Carbon\Carbon::create($selectedYear, $selectedMonth, $date)->format('Y-m-d');
                                            $details = $workHours[$employee->id][$currentDate]['work_details'] ?? [['cong_name' => '', 'hours' => '']];
                                            $timeLogs = $workHours[$employee->id][$currentDate]['time_logs'] ?? [];
                                            $shiftDate = $workHours[$employee->id][$currentDate]['shift_date'] ?? '';
                                        @endphp
                                        <td>
                                            @if (!empty($timeLogs))
                                                @foreach ($timeLogs as $log)
                                                    {{ $log }}<br>
                                                @endforeach
                                            @endif
                                            @foreach ($details as $detail)
                                                {{ $detail['cong_name'] }}: {{ $detail['hours'] }}<br>
                                            @endforeach
                                           
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
