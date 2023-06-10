<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng nhập thành công</title>
    <link rel="icon" type="image/png" size="32x32" href="{{asset('media/logo/salon_icon_x32.png')}}">
    <link rel="icon" type="image/png" size="16x16" href="{{asset('media/logo/salon_icon_x16.png')}}">

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

    window.close();

    // Swal.fire({
    //     icon: "success",
    //     title: "Thành công",
    //     text: "Đăng nhập thành công!",
    //     showConfirmButton: false,
    //     allowOutsideClick: false,
    // })

</script>
</body>
</html>
