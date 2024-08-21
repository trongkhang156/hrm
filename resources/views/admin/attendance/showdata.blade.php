<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataMita Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
            border-radius: 8px 8px 0 0;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            cursor: pointer;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
            display: inline-block;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn.save {
            background-color: #28a745;
        }

        .btn.save:hover {
            background-color: #218838;
        }

        .btn.delete {
            background-color: #dc3545;
        }

        .btn.delete:hover {
            background-color: #c82333;
        }

        .btn.close {
            background-color: #6c757d;
        }

        .btn.close:hover {
            background-color: #5a6268;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .edit-input {
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 8px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .alert {
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
            border: 1px solid transparent;
            transition: opacity 0.3s ease;
        }

        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-color: #bee5eb;
        }

        .fixed-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Dữ liệu từ máy chấm công</h2>
        <div id="message" class="alert" style="display: none;"></div>

        <table>
            <thead>
                <tr>
                    <th style="display:none">ID</th>
                    <th>Mã chấm công</th>
                    <th>Ngày chấm công</th>
                    <th>Giờ chấm công</th>
                    <th>KieuCham</th>
                    <th>NguonCham</th>
                    <th>MaSoMay</th>
                    <th>TenMay</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataMitAs as $dataMita)
                <tr id="row-{{ $dataMita->id }}">
                    <td style="display:none">{{ $dataMita->id }}</td>
                    <td><input type="text" name="MaChamCong_{{ $dataMita->id }}" class="edit-input" value="{{ $dataMita->MaChamCong }}"></td>
                    <td><input type="text" name="NgayCham_{{ $dataMita->id }}" class="edit-input" value="{{ $dataMita->NgayCham }}"></td>
                    <td><input type="text" name="GioCham_{{ $dataMita->id }}" class="edit-input" value="{{ $dataMita->GioCham }}"></td>
                    <td><input type="text" name="KieuCham_{{ $dataMita->id }}" class="edit-input" value="{{ $dataMita->KieuCham }}"></td>
                    <td><input type="text" name="NguonCham_{{ $dataMita->id }}" class="edit-input" value="{{ $dataMita->NguonCham }}"></td>
                    <td><input type="text" name="MaSoMay_{{ $dataMita->id }}" class="edit-input" value="{{ $dataMita->MaSoMay }}"></td>
                    <td><input type="text" name="TenMay_{{ $dataMita->id }}" class="edit-input" value="{{ $dataMita->TenMay }}"></td>
                    <td><button class="btn delete" onclick="deleteRow({{ $dataMita->id }})">Delete</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="fixed-buttons">
        <button class="btn save" onclick="saveAllData()">Save All</button>
        <button class="btn close" onclick="window.location.href='{{ route('attendance.index') }}'">Close</button>
    </div>

    <script>
        function saveAllData() {
            var rows = document.querySelectorAll('tbody tr');
            var data = [];

            rows.forEach(row => {
                var id = row.id.split('-')[1];
                var inputs = row.querySelectorAll('input');
                var rowData = {};

                inputs.forEach(input => {
                    var name = input.name.split('_')[0];
                    rowData[name] = input.value;
                });

                rowData['id'] = id;
                data.push(rowData);
            });

            $.ajax({
                url: '{{ route("attendance.savemita") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    data: data
                },
                success: function (response) {
                    showAlert('success', 'Dữ liệu đã được cập nhật thành công!');
                },
                error: function (xhr) {
                    showAlert('error', 'Lỗi khi cập nhật dữ liệu!');
                }
            });
        }

        function deleteRow(id) {
            if (confirm('Are you sure you want to delete this row?')) {
                $.ajax({
                    url: '{{ route("attendance.deletemita") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function (response) {
                        document.getElementById(`row-${id}`).remove();
                        showAlert('success', 'Dữ liệu đã được xóa thành công!');
                    },
                    error: function (xhr) {
                        showAlert('error', 'Lỗi khi xóa dữ liệu!');
                    }
                });
            }
        }

        function showAlert(type, message) {
            var alert = document.getElementById('message');
            alert.className = `alert ${type}`;
            alert.textContent = message;
            alert.style.display = 'block';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html>
