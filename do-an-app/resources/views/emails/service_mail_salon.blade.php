<!DOCTYPE html>
<html>
<head>
    <title>Hóa đơn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 30px 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            margin: 30px;
        }

        .info {
            width: 40%;
        }

        .status {
            width: 50%;
            text-align: right;
        }

        .table-container {
            margin: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: auto;
            font-size: 16px;
            text-align: center;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            text-align: center;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
        }

        th {
            background-color: #f8f9fa;
            text-transform: uppercase;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: #868e96;
        }

        td {
            font-size: 14px;
            font-weight: 500;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-right: 30px;
        }
        .status-appointment, .total-service {
            padding: 10px 10px 10px 10px;
            background-color: #FFCC33;
            border-radius: 5px;

        }
    </style>
</head>
<body>
<h1>Cảm ơn đã đặt lịch cho chúng tôi!!!</h1>

<div class="container">
    <div class="info">
        <h2>Thông tin khách hàng</h2>
        <p>Tên: {{$customer->fullname}}</p>
        <p>Điện thoại: {{$phone}}</p>
    </div>

    <div class="status">
        <h2>Thông tin lịch hẹn</h2>
        <p>Tên salon: <b>{{$salon->name}}</b></p>
        <p>Ngày hẹn: {{\App\Helpers\HandleDateTimePickerHelper::formatDD_MM_YY_Default($date)}}</p>
        <p>Khung giờ: {{$timeSlot}}</p>
        <p>Nhân viên tiếp nhận: <b>{{$employee}}</b></p>
        <p>Trạng thái: <b class="status-appointment">{{$status}}</b></p>
        <p>Địa chỉ salon: <b>{{$salon->address}}, {{$salon->location['address']}}</b></p>
        <p>Thanh toán: <b class="status-appointment">{{$payment_status}}</b></p>
    </div>
</div>

<table>
    <thead>
    <tr>
        <th>Số thứ tự</th>
        <th>Tên dịch vụ</th>
        <th>Giá dịch vụ</th>
    </tr>
    </thead>
    <tbody>
    @foreach($services as $index => $service)
        <tr>
            <td>{{$index + 1}}</td>
            <td>{{$service->name}}</td>
            <td>{{$service->price}}</td>
        </tr>
    @endforeach

    </tbody>
</table>

<div class="total">
    <p>Tổng tiền: <b class="total-service">{{$price}} VNĐ</b></p>
</div>
</body>
</html>
