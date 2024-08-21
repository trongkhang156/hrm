@extends('layouts.admin')

@section('title')
    {{ __('Manage attendance') }}
@endsection

@section('header')
  <div class="d-flex align-items-center justify-content-between mb-4">
    <h1 class="h3">{{ __('Tải dữ liệu vân tay & Chấm công theo ngày') }}</h1>
  </div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">TẢI DỮ LIỆU MÁY CHẤM CÔNG</div>
                <div class="card-body">
                    <form action="{{ route('attendance.process') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="startDate">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                        </div>
                        <div class="form-group">
                            <label for="endDate">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Lấy dữ liệu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

