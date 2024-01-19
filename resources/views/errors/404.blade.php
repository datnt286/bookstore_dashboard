<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Not Found</title>

    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="not-found d-flex justify-content-center align-items-center">
        <div class="not-found-wrapper">
            <img class="not-found-image" src="{{ asset('/img/not-found.jpg') }}" alt="NOT FOUND" />
            <h2 class="mt-3">Không tìm thấy trang</h2>
            <p class="text-center mt-3">Trang bạn tìm kiếm không tồn tại!</p>
            <p class="text-center mt-3">
                Quay lại
                <a href="{{ route('/') }}" class="not-found-link">
                    Trang chủ
                </a>
            </p>
        </div>
    </div>
</body>

</html>