@extends('master')

@section('content')
<h1 class="text-center my-4">Thông tin tài khoản</h1>

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
                <form id="form-account" enctype="multipart/form-data">
                    @csrf
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-4">
                            <div class="card-body box-profile text-center ml-4">
                                <img id="avatar-preview" src="{{ asset('uploads/admins/' . $admin->avatar) }}" alt="Ảnh đại diện" class="profile-user-img img-fluid img-circle d-block" style="width: 100px; height: 100px; object-fit: cover;">
                                <input type="file" name="avatar" id="avatar" class="d-none">
                                <div class="invalid-feedback avatar-error">{{ $errors->first('avatar') }}</div>
                                <label for="avatar" id="btn-change-avatar" class="btn btn-secondary my-3 font-weight-normal">
                                    Chọn ảnh
                                </label>
                                <h3 class="profile-username">{{ $admin->name }}</h3>
                                <p class="text-muted">Admin</p>
                            </div>
                        </div>
                        <div class="col-md-8 mt-4">
                            <input type="hidden" name="id" id="id" value="{{ $admin->id }}">
                            <div class="row ml-2 my-6">
                                <label for="username" class="col-md-3 mt-2">Tên đăng nhập: </label>
                                <div class="col-md-6">
                                    <input type="text" name="username" id="username" value="{{ $admin->username }}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row ml-2 my-4">
                                <label for="name" class="col-md-3 mt-2">Họ tên: </label>
                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" value="{{ $admin->name }}" class="form-control">
                                    <div class="invalid-feedback name-error">{{ $errors->first('name') }}</div>
                                </div>
                            </div>
                            <div class="row ml-2 my-4">
                                <label for="phone" class="col-md-3 mt-2">Điện thoại: </label>
                                <div class="col-md-6">
                                    <input type="text" name="phone" id="phone" value="{{ $admin->phone }}" class="form-control">
                                    <div class="invalid-feedback phone-error">{{ $errors->first('phone') }}</div>
                                </div>
                            </div>
                            <div class="row ml-2 my-4">
                                <label for="email" class="col-md-3 mt-2">Email: </label>
                                <div class="col-md-6">
                                    <input type="text" name="email" id="email" value="{{ $admin->email }}" class="form-control">
                                    <div class="invalid-feedback email-error">{{ $errors->first('email') }}</div>
                                </div>
                            </div>
                            <div class="row ml-2 my-2">
                                <label for="address" class="col-md-3 mt-2">Địa chỉ: </label>
                                <div class="col-md-6">
                                    <textarea name="address" id="address" class="form-control">{{ $admin->address }}</textarea>
                                    <div class="invalid-feedback address-error">{{ $errors->first('address') }}</div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" id="btn-update-account" class="btn btn-primary mt-3">
                                    <i class="fas fa-check"></i> Lưu
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="change-password" class="tab-pane">
                <form id="form-change-password">
                    @csrf
                    <div class="row d-flex justify-content-center my-4">
                        <label for="old-password" class="col-md-2 mt-2">Mật khẩu cũ: </label>
                        <div class="col-md-5">
                            <input type="password" name="old_password" id="old-password" class="form-control">
                            <div class="invalid-feedback old-password-error">{{ $errors->first('old_password') }}</div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center my-4">
                        <label for="new-password" class="col-md-2 mt-2">Mật khẩu mới: </label>
                        <div class="col-md-5">
                            <input type="password" name="new_password" id="new-password" class="form-control">
                            <div class="invalid-feedback new-password-error">{{ $errors->first('new_password') }}</div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center my-2">
                        <label for="re-enter-password" class="col-md-2">Nhập lại mật khẩu: </label>
                        <div class="col-md-5">
                            <input type="password" name="re_enter_password" id="re-enter-password" class="form-control">
                            <div class="invalid-feedback re-enter-password-error">{{ $errors->first('re_enter_password') }}</div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div id="alert-message" class="col-md-7">
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox text-center my-2">
                        <input type="checkbox" id="show-password" class="custom-control-input">
                        <label for="show-password" class="custom-control-label">Hiện mật khẩu</label>
                    </div>
                    <div class="text-center">
                        <button type="button" id="btn-change-password" class="btn btn-primary mt-3">
                            <i class="fas fa-check"></i> Lưu
                        </button>
                    </div>
                </form>
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

        function clearValidationStyles(input) {
            if (input.hasClass('is-invalid')) {
                input.removeClass('is-invalid');
                var errorClassName = input.attr('name') + '-error';
                $('.' + errorClassName).text('');
            }
        }

        $('#form-account input').on('input', function() {
            clearValidationStyles($(this));
        });

        $('#form-change-password input').on('input', function() {
            clearValidationStyles($(this));
        });

        $('#form-account textarea').on('input', function() {
            clearValidationStyles($(this));
        });

        $('#btn-update-account').click(async function() {
            try {
                var formData = new FormData();

                formData.append('id', $('#id').val());
                formData.append('name', $('#name').val());
                formData.append('phone', $('#phone').val());
                formData.append('email', $('#email').val());
                formData.append('address', $('#address').val());

                if ($('#avatar')[0].files[0]) {
                    formData.append('avatar', $('#avatar')[0].files[0]);
                }

                var response = await axios.post("{{ route('update-account') }}", formData);
                var res = response.data;

                handleSuccess(res);
            } catch (error) {
                handleError(error);
            }
        });

        $('#btn-change-password').click(async function() {
            try {
                var formData = new FormData();

                formData.append('old_password', $('#old-password').val());
                formData.append('new_password', $('#new-password').val());
                formData.append('re_enter_password', $('#re-enter-password').val());

                var response = await axios.post("{{ route('change-password') }}", formData);
                var res = response.data;

                handleSuccess(res);
            } catch (error) {
                if (error.response.status === 401) {
                    var errorMessage = error.response.data.message;
                    var alertElement = $('<div class="alert alert-danger" role="alert"></div>').text(errorMessage);
                    $('#alert-message').html(alertElement);
                } else {
                    $('#alert-message').empty();
                    handleError(error);
                }
            }
        });
    })
</script>
@endsection