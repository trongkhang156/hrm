<!-- resources/views/worktypes/edit.blade.php -->

@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Chỉnh sửa công</h1>
        <form action="{{ route('worktypes.update', $worktype->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Tên công</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $worktype->name }}" required>
            </div>
            <div class="form-group">
                <label for="type">Loại công</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="N" {{ $worktype->type == 'N' ? 'selected' : '' }}>N</option>
                    <option value="P" {{ $worktype->type == 'P' ? 'selected' : '' }}>P</option>
                </select>
            </div>
            <div class="form-group">
                <label for="max">Số giờ tối đa</label>
                <input type="number" name="max" id="max" class="form-control" value="{{ $worktype->max }}" required>
            </div>
            <div class="form-group">
                <label for="parent_id">Công liên kết</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="">None</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}" {{ $worktype->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
@endsection
