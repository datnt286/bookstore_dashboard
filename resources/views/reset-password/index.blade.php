<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quên mật khẩu</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
</head>

<body class="hold-transition login-page">

    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('/img/preloader-logo.png') }}" alt="Logo" height="60" width="60">
    </div>

    <div class="login-box" style="width: 432px;">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <span class="h1">Quên mật khẩu</span>
            </div>
            <div class="card-body">
                <form id="form-reset-password">
                    @csrf
                    <div class="row">
                        <div class="col-md-9">
                            <div class="input-group mb-3">
                                <input type="text" name="email" id="email" class="form-control" placeholder="Nhập email của bạn">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" id="btn-reset-password" class="btn btn-primary">
                                Xác nhận
                            </button>
                        </div>
                    </div>
                </form>
                <div class="d-flex justify-content-center">
                    Trở lại trang
                    <a href="{{ route('login') }}" class="ml-1">
                        Đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- Axios -->
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
            });

            $('#btn-reset-password').click(async function(event) {
                event.preventDefault();

                try {
                    var formData = new FormData($('#form-reset-password')[0]);
                    var response = await axios.post("{{ route('handle-reset-password') }}", formData);
                    var res = response.data;

                    Toast.fire({
                        title: res.message,
                        icon: 'success',
                    });
                } catch (error) {
                    console.error('Lỗi: ', error);
                    Toast.fire({
                        title: error.response.data.message,
                        icon: 'error',
                    });
                }
            });
        });
    </script>
</body>

</html>