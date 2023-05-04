<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng nhập</title>
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
<section >
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <h4 class="mb-5">Chào mừng bạn đã tới trang đăng nhập của chúng tôi!</h4>

                        <hr class="my-4">

                        <a href="{{route('google.redirect')}}" class="btn btn-lg btn-block btn-primary" style="background-color: #dd4b39; border: none;"
                                ><i class="fab fa-google me-2"></i> Tiếp tục đăng nhập với Google</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="{{asset('lib/bootstrap-4.0.0/dist/js/bootstrap.min.js')}}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    console.log('Hello World!')
</script>
</body>
</html>
