@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Định nghĩa công</h1>
        <a href="{{ route('worktypes.create') }}" class="btn btn-primary">Thêm mới</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên công</th>
                    <th>Loại công</th>
                    <th>Số giờ tối đa</th>
                    <th>Công liên kết</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($worktypes as $worktype)
                    <tr>
                        <td>{{ $worktype->id }}</td>
                        <td>{{ $worktype->name }}</td>
                        <td>{{ $worktype->type }}</td>
                        <td>{{ $worktype->max }}</td>
                        <td>{{ $worktype->parent ? $worktype->parent->name : 'None' }}</td>
                        <td>
                            <a href="{{ route('worktypes.edit', $worktype->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('worktypes.destroy', $worktype->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
