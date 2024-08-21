@extends('layouts.admin')

@section('title', 'Manage Shift Schedules')

@section('header')
    <h1 class="h3 mb-3">Manage Shift Schedules</h1>
@endsection

@section('content')
<section class="row mt-4">
    <div class="col-12">
        <form action="{{ route('shiftschedule.index') }}" method="get" class="d-flex justify-content-between align-items-center mb-3">
            <div class="row w-100 g-3">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="month">{{ __('Chọn tháng') }}</label>
                        <select name="month" id="month" class="form-control">
                            @foreach(range(1, 12) as $month)
                                <option value="{{ $month }}" @if($month == $selectedMonth) selected @endif>
                                    {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="year">{{ __('Chọn năm') }}</label>
                        <select name="year" id="year" class="form-control">
                            @foreach(range(date('Y') - 5, date('Y') + 5) as $year)
                                <option value="{{ $year }}" @if($year == $selectedYear) selected @endif>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-secondary w-100">
                        {{ __('Tìm') }}
                    </button>
                </div>
            </div>
        </form>

        <form action="{{ route('shiftschedule.store') }}" method="post">
            @csrf
            <div class="card flex-fill">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Shift Schedules') }}</h5>
                </div>
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    @for ($i = 1; $i <= 31; $i++)
                                        <th>{{ $i }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $employee)
                                <tr id="schedule-row-{{ $employee->id }}">
                                    <td>{{ $employee->id }}</td>
                                    @for ($i = 1; $i <= 31; $i++)
                                        @php
                                            $date = \Carbon\Carbon::create($selectedYear, $selectedMonth, $i)->format('Y-m-d');
                                            $schedule = $shiftSchedules->firstWhere(function ($schedule) use ($employee, $date) {
                                                return $schedule->id_employees == $employee->id && \Carbon\Carbon::parse($schedule->shift_date)->format('Y-m-d') == $date;
                                            });
                                        @endphp
                                        <td>
                                            <select name="schedule[{{ $employee->id }}][{{ $date }}]" class="form-control-sm">
                                                <option value="">{{ __('None') }}</option>
                                                @foreach($shifts as $shift)
                                                    <option value="{{ $shift->id }}" @if($schedule && $schedule->id_ca == $shift->id) selected @endif>{{ $shift->title }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    @endfor
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="align-middle me-1" data-feather="save"></i>
                        <span class="ps-1">{{ __('Save') }}</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
