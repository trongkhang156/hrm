@extends('layouts.admin')

@section('title')
    {{ __('Edit Schedule') }}
@endsection

@section('header')
  <h1 class="h3 mb-3">Update Schedule</h1>
@endsection

@section('content')
  <section class="row">
    <div class="col-12 d-flex align-items-center justify-content-center">
      <div class="col-6">
        <form action="{{ Auth::user()->role->slug === 'super-admin' ? route('schedule.update', $schedule->id) : ( Auth::user()->role->slug === 'administrator' ? route('admin.schedule.update', $schedule->id) : route('moderator.schedule.update', $schedule->id) ) }}" method="post">
          @csrf
          @method('put')
          <div class="card flex-fill">
            <div class="card-header">
              <h5 class="card-title mb-0">{{ __('Update Schedule') }}</h5>
            </div>
            <div class="card-body py-0">
              <div class="row g-3">
                <div class="col-12">
                  <input type="text" name="title" class="form-control" id="title" placeholder="{{ __('Title') }}" value="{{ $schedule->title }}" required />
                </div>
                <div class="col-12">
                    <input type="time" name="time_in" class="form-control" id="time_in" placeholder="{{ __('Time In') }}" value="{{ $schedule->time_in }}" required />
                </div>
                <div class="col-12">
                    <input type="time" name="time_out" class="form-control" id="time_out" placeholder="{{ __('Time Out') }}" value="{{ $schedule->time_out }}" required />
                </div>
                <div class="col-12">
                  <input type="number" name="break_time" class="form-control" id="break_time" placeholder="{{ __('Break Time (minutes)') }}" value="{{ old('break_time', $schedule->break_time) }}" required />
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-6 d-grid">
                  <a href="{{ Auth::user()->role->slug === 'super-admin' ? route('schedule.index') : (Auth::user()->role->slug === 'administrator' ? route('admin.schedule.index') : route('moderator.schedule.index')) }}" class="btn btn-outline-secondary">
                    <i class="align-middle me-1" data-feather="arrow-left"></i>
                    <span class="ps-1">{{ __('Discard') }}</span>
                  </a>
                </div>
                <div class="col-6 d-grid">
                  <button type="submit" class="btn btn-outline-secondary">
                    <i class="align-middle me-1" data-feather="check"></i>
                    <span class="ps-1">{{ __('Update') }}</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Schedules Detail Management -->
  <section class="row mt-4">
    <div class="col-12">
      <div class="card flex-fill">
        <div class="card-header">
          <h5 class="card-title mb-0">{{ __('Schedule Details') }}</h5>
        </div>
        <div class="card-body py-0">
        <form id="scheduleDetailForm" action="{{ route('schedule.storedetail') }}" method="post">
    @csrf
    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}" />
    <div class="row g-3 mb-3">

        <div class="col-md-2">
            <input type="hidden" name="id_ca" value="{{ $schedule->id }}" class="form-control"/>
            <input type="time" name="starttime" class="form-control" placeholder="{{ __('Start Time') }}" required />
        </div>
        <div class="col-md-2">
            <input type="time" name="endtime" class="form-control" placeholder="{{ __('End Time') }}" required />
        </div>
        <div class="col-md-2 d-flex align-items-center">
            <input type="checkbox" name="isthrough_newday" id="isthrough_newday" value="1" class="form-check-input" />
            <label for="isthrough_newday" class="form-check-label ms-2">{{ __('Through New Day') }}</label>
        </div>
        <div class="col-md-2 d-flex align-items-center">
            <input type="checkbox" name="is_overtime" id="is_overtime" value="1" class="form-check-input" />
            <label for="is_overtime" class="form-check-label ms-2">{{ __('Overtime') }}</label>
        </div>
        <div class="col-md-2">
            <select name="work_type_id" class="form-select" required>
                <option value="" disabled selected>{{ __('Select Work Type') }}</option>
                @foreach($workTypes as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-outline-secondary">
        <i class="align-middle me-1" data-feather="plus"></i>
        <span class="ps-1">{{ __('Add Detail') }}</span>
    </button>
</form>



          <table class="table mt-3">
            <thead>
              <tr>
                <th style="display:none">Id_ca</th>
                <th>Công</th>
                <th>Giờ bắt đầu</th>
                <th>Giờ kết thúc</th>
                <th>Qua ngày mới</th>
                <th>Sử dụng</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($scheduleDetails as $detail)
              <tr id="detail-row-{{ $detail->id }}">
                
                <td style="display:none">{{ $detail->id_ca }}</td>
                <td>
                    <select name="work_type_id" class="form-control">
                        @foreach($workTypes as $id => $name)
                            <option value="{{ $id }}" {{ $detail->idcong == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>{{ $detail->starttime }}</td>
                <td>{{ $detail->endtime }}</td>
                <td>{{ $detail->isthrough_newday ? 'No' : 'Yes' }}</td>
                <td>{{ $detail->isdelete ? 'No' : 'Yes' }}</td>
                <td>
                  <button class="btn btn-outline-secondary btn-sm" onclick="editDetail({{ $detail->id }})">
                    <i class="align-middle me-1" data-feather="edit"></i>
                    {{ __('Edit') }}
                  </button>
                  <button class="btn btn-outline-secondary btn-sm" onclick="deleteRow({{ $detail->id }})">Delete</button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
<script>
    function deleteRow(id) {
        if (confirm('Are you sure you want to delete this row?')) {
            $.ajax({
                url: '{{ route("schedule.destroydetail") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                success: function (response) {
                    document.getElementById(`detail-row-${id}`).remove();
                    showAlert('success', 'Dữ liệu đã được xóa thành công!');
                },
                error: function (response) {
                    showAlert('error', 'Có lỗi xảy ra khi xóa dữ liệu!');
                }
            });
        }
    }

    function editDetail(id) {
        // Implement the edit functionality
    }
</script>
@endsection
