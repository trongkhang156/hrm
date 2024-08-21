@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Thêm mới công</h1>
        <form action="{{ route('worktypes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Tên công</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="type">Loại công</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="N">N</option>
                    <option value="P">P</option>
                </select>
            </div>
            <div class="form-group">
                <label for="max">Số giờ tối đa</label>
                <input type="number" name="max" id="max" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="parent_id">Công liên kết</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <option value="">None</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
