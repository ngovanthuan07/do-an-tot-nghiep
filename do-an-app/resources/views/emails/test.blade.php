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
    </style>
</head>
<body>
<h1>Hóa đơn</h1>

<div class="container">
    <div class="info">
        <h2>Thông tin khách hàng</h2>
        <p>Tên: Nguyễn Văn A</p>
        <p>Địa chỉ: 123 Nguyễn Trãi, Quận 5, TP. HCM</p>
        <p>Điện thoại: 0901234567</p>
    </div>

    <div class="status">
        <h2>Tình trạng</h2>
        <p>Ngày đặt: 01/05/2023</p>
        <p>Ngày hẹn: 10/05/2023</p>
        <p>Trạng thái: Đã xác nhận</p>
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
    <tr>
        <td>1</td>
        <td>Cắt tóc</td>
        <td>100.000 đ</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Gội đầu</td>
        <td>50.000 đ</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Nhuộm tóc</td>
        <td>300.000 đ</td>
    </tr>
    </tbody>
</table>

<div class="total">
    <p>Tổng tiền: 450.000 VNĐ</p>
</div>

<script>
    // Không cần JavaScript cho phần này
</script>
</body>
</html>
