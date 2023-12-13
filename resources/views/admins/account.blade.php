@extends('master')

@section('content')
<h1 class="text-center my-4">Thông tin tài khoản</h1>

<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile text-center">
                <img id="avatar-preview" src="{{ asset('uploads/admins/' . Auth::user()->avatar) }}" alt="Ảnh đại diện" class="profile-user-img img-fluid img-circle d-block" style="max-width: 100px; max-height: 100px;">
                <label for="avatar" id="btn-change-avatar" class="btn btn-secondary my-3 font-weight-normal">
                    Chọn ảnh
                </label>
                <h3 class="profile-username">{{ Auth::user()->name }}</h3>
                <p class="text-muted">Admin</p>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card card-primary card-outline" style="min-height: 490px;">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="#account" class="nav-link active" data-toggle="tab">Tài khoản</a></li>
                    <li class="nav-item"><a href="#change-password" class="nav-link" data-toggle="tab">Đổi mật khẩu</a></li>
                </ul>
            </div>

            <div class="card-body align-middle">
                <div class="tab-content">
                    <div id="account" class="active tab-pane">
                        <form id="form-account" method="POST" action="{{ route('update-account') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="admin_id" id="admin-id" value="{{ $admin->id }}">
                            <input type="file" name="avatar" id="avatar" class="d-none">
                            <div class="row d-flex justify-content-center my-4">
                                <label for="username" class="col-md-2">Tên đăng nhập: </label>
                                <input type="text" name="username" id="username" value="{{ $admin->username }}" class="form-control col-md-5" readonly>
                            </div>
                            <div class="row d-flex justify-content-center my-4">
                                <label for="name" class="col-md-2">Họ tên: </label>
                                <input type="text" name="name" id="name" value="{{ $admin->name }}" class="form-control col-md-5">
                            </div>
                            <div class="row d-flex justify-content-center my-4">
                                <label for="phone" class="col-md-2">Điện thoại: </label>
                                <input type="text" name="phone" id="phone" value="{{ $admin->phone }}" class="form-control col-md-5">
                            </div>
                            <div class="row d-flex justify-content-center my-4">
                                <label for="email" class="col-md-2">Email: </label>
                                <input type="text" name="email" id="email" value="{{ $admin->email }}" class="form-control col-md-5">
                            </div>
                            <div class="row d-flex justify-content-center my-2">
                                <label for="address" class="col-md-2">Địa chỉ: </label>
                                <input type="text" name="address" id="address" value="{{ $admin->address }}" class="form-control col-md-5">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fas fa-check"></i> Lưu
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="change-password" class="tab-pane">
                        <form id="form-change-password" method="POST" action="{{ route('change-password') }}">
                            @csrf
                            <div class="row d-flex justify-content-center my-4">
                                <label for="old-password" class="col-md-2">Mật khẩu cũ: </label>
                                <input type="password" name="old_password" id="old-password" class="form-control col-md-5">
                            </div>
                            <div class="row d-flex justify-content-center my-4">
                                <label for="new-password" class="col-md-2">Mật khẩu mới: </label>
                                <input type="password" name="new_password" id="new-password" class="form-control col-md-5">
                            </div>
                            <div class="row d-flex justify-content-center my-2">
                                <label for="re-enter-password" class="col-md-2">Nhập lại mật khẩu: </label>
                                <input type="password" name="re_enter_password" id="re-enter-password" class="form-control col-md-5">
                            </div>
                            <div class="custom-control custom-checkbox text-center my-2">
                                <input type="checkbox" id="show-password" class="custom-control-input">
                                <label for="show-password" class="custom-control-label">Hiện mật khẩu</label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="fas fa-check"></i> Lưu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')
<script>
    $(document).ready(function() {
        $('#avatar').change(function(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#avatar-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        });

        $('#show-password').change(function() {
            if ($(this).is(':checked')) {
                $('#old-password').attr('type', 'text');
                $('#new-password').attr('type', 'text');
                $('#re-enter-password').attr('type', 'text');
            } else {
                $('#old-password').attr('type', 'password');
                $('#new-password').attr('type', 'password');
                $('#re-enter-password').attr('type', 'password');
            }
        });
    })
</script>

@if(session('message'))
<script>
    $(document).ready(function() {
        setTimeout(function() {
            Toast.fire({
                icon: 'success',
                title: "{{ session('message') }}"
            });
        }, 600);
    });
</script>
@endif
@endsection