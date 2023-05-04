<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lỗi đăng nhập</title>
    <link
        rel="stylesheet"
        href="{{asset('lib/bootstrap-4.0.0/dist/css/bootstrap.min.css')}}"
        type="text/css"
    />
    <script src="{{asset('lib/jquery/jquery-3.6.4.min.js')}}"></script>
    <script
        src="{{asset('lib/font-awesome-web/fontawesome.js')}}" crossorigin="anonymous"></script>

</head>
<body style="background-color: #FFCC33FF">
<script src="{{asset('lib/bootstrap-4.0.0/dist/js/bootstrap.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        icon: "Error",
        title: "Lỗi đăng nhập",
        text: "Đã bị lỗi vui lòng đăng nhập lại!",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Đóng",
        allowOutsideClick: false,
    }).then((result) => {
        if (result.isConfirmed) {
            window.close();
        }
    });
</script>
</body>
</html>
