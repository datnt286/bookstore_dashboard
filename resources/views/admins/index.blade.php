@extends('master')

@section('content')
<div class="row my-4">
    <div class="col-10">
        <h1 class="m-0">Quản lý admin</h1>
    </div>
    <div class="col-2 text-right">
        <button type="button" id="btn-create" class="btn btn-success mt-2" data-toggle="modal" data-target="#modal-create">
            <i class="fas fa-plus-circle"></i>
            Thêm admin
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="data-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Ảnh đại diện</th>
                    <th>Tên đăng nhập</th>
                    <th>Họ tên</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-store">
    <form id="form-store" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">Thêm admin</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group text-center">
                            <label for="avatar" class="form-label d-block">Ảnh đại diện:</label>
                            <div>
                                <img id="avatar-preview" src="{{ asset('img/default-avatar.jpg') }}" alt="Ảnh đại diện" class="img img-thumbnail my-2" style="max-width: 100px; max-height: 100px;">
                            </div>
                            <input type="file" name="avatar" id="avatar" class="d-none" required>
                            <div class="invalid-feedback avatar-error">{{ $errors->first('avatar') }}</div>
                            <label for="avatar" class="btn btn-secondary font-weight-normal mt-2">
                                Chọn ảnh
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="username">Tên đăng nhập: </label>
                            <input type="text" name="username" id="username" class="form-control" required>
                            <div class="invalid-feedback username-error">{{ $errors->first('username') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu: </label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            <div class="invalid-feedback password-error">{{ $errors->first('password') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="name">Họ tên: </label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <div class="invalid-feedback name-error">{{ $errors->first('name') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Điện thoại: </label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                            <div class="invalid-feedback phone-error">{{ $errors->first('phone') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email: </label>
                            <input type="text" name="email" id="email" class="form-control" required>
                            <div class="invalid-feedback email-error">{{ $errors->first('email') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ: </label>
                            <input type="text" name="address" id="address" class="form-control" required>
                            <div class="invalid-feedback address-error">{{ $errors->first('address') }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i>
                        Huỷ
                    </button>
                    <button type="button" id="btn-store" class="btn btn-primary">
                        <i class="fas fa-check"></i>
                        Lưu
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thông tin admin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="text-center">
                        <div class="form-group">
                            <span class="text-lg font-weight-bold">Ảnh đại diện:</span>
                        </div>
                        <div class="form-group">
                            <img id="avatar-detail-preview" src="{{ asset('img/default-avatar.jpg') }}" alt="Ảnh đại diện" class="img img-thumbnail mb-3" style="max-width: 100px; max-height: 100px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="text-lg font-weight-bold">Tên đăng nhập: </span>
                        <span id="username-detail" class="text-lg"></span>
                    </div>
                    <div class="form-group">
                        <span class="text-lg font-weight-bold">Họ tên: </span>
                        <span id="name-detail" class="text-lg"></span>
                    </div>
                    <div class="form-group">
                        <span class="text-lg font-weight-bold">Điện thoại: </span>
                        <span id="phone-detail" class="text-lg"></span>
                    </div>
                    <div class="form-group">
                        <span class="text-lg font-weight-bold">Email: </span>
                        <span id="email-detail" class="text-lg"></span>
                    </div>
                    <div class="form-group">
                        <span class="text-lg font-weight-bold">Địa chỉ: </span>
                        <span id="address-detail" class="text-lg"></span>
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
        bsCustomFileInput.init();

        var dataTable = $('#data-table').DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            searching: true,
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    text: 'Sao chép'
                },
                {
                    extend: 'excel',
                    text: 'Xuất Excel'
                },
                {
                    extend: 'pdf',
                    text: 'Xuất PDF'
                },
                {
                    extend: 'print',
                    text: 'In'
                },
                {
                    extend: 'colvis',
                    text: 'Hiển thị cột'
                },
                {
                    extend: 'pageLength',
                    text: 'Số dòng trên trang'
                }
            ],
            language: {
                search: "Tìm kiếm:",
                processing: "Đang xử lý...",
                lengthMenu: "Hiển thị _MENU_ mục",
                info: "Hiển thị _START_ đến _END_ trong _TOTAL_ mục",
                infoEmpty: "Hiển thị 0 đến 0 trong 0 mục",
                infoFiltered: "(được lọc từ _MAX_ mục)",
                paginate: {
                    first: 'Trang đầu',
                    previous: 'Trang trước',
                    next: 'Trang sau',
                    last: 'Trang cuối'
                },
            },
            ajax: {
                type: 'GET',
                url: "{{ route('admin.index') }}",
                dataType: 'json',
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'avatar',
                    render: function(data, type, row) {
                        return '<img src="uploads/admins/' + row.avatar + '" alt="Ảnh đại diện" class="img img-thumbnail" style="max-width: 100px; max-height: 100px;">';
                    }
                },
                {
                    data: 'username'
                },
                {
                    data: 'name'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'email'
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return '<div class="project-actions text-right">' +
                            '<button class="btn btn-info btn-sm btn-detail" data-id="' + row.id + '" data-toggle="modal" data-target="#modal-detail"><i class="fas fa-info-circle"></i> Chi tiết</button>' +
                            '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' + row.id + '" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-edit"></i> Cập nhật</button>' +
                            '<button class="btn btn-danger btn-sm btn-delete" data-id="' + row.id + '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' +
                            '</div>';
                    }
                }
            ]
        });

        var id = null;
        var avatar = null;
        var formData = new FormData($('#form-store')[0]);

        $('#btn-create').click(function() {
            id = null;
            resetForm();
            $('#id').val(null);
            $('#form-store').trigger('reset');
            $('#avatar-preview').attr('src', 'img/default-avatar.jpg');
            $('#username').prop('readonly', false);
            $('#modal-title').text('Thêm admin');
            $('#modal-store').modal('show');
        });

        $('#data-table').on('click', '.btn-edit', async function() {
            try {
                resetForm();
                id = $(this).data('id');
                var response = await axios.get("{{ route('admin.show', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('#id').val(res.data.id);
                $('#username').val(res.data.username);
                $('#password').val('');
                $('#name').val(res.data.name);
                $('#phone').val(res.data.phone);
                $('#email').val(res.data.email);
                $('#address').val(res.data.address);
                $('#avatar-preview').attr('src', 'uploads/admins/' + res.data.avatar);
                $('#username').prop('readonly', true);
                $('#modal-title').text('Cập nhật admin');
                $('#modal-store').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#avatar').change(function(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#avatar-preview').attr('src', e.target.result);

                    var formData = new FormData($('#form-store')[0]);
                    formData.set('avatar', input.files[0]);
                }

                reader.readAsDataURL(input.files[0]);
            }

            if ($(this).hasClass('is-invalid')) {
                $(this).removeClass('is-invalid');
                var errorClassName = $(this).attr('name') + '-error';
                $('.' + errorClassName).text('');
            }
        });

        $('#btn-store').click(async function() {
            try {
                var formData = new FormData($('#form-store')[0]);

                if (id) {
                    var url = `{{ route('admin.update', ['id' => '_id_']) }}`.replace('_id_', id);
                } else {
                    var url = "{{ route('admin.store') }}";
                }

                var response = await axios.post(url, formData);
                var res = response.data;

                $('#modal-store').modal('hide');
                $('#form-store').trigger('reset');
                dataTable.draw();
                handleSuccess(res);
            } catch (error) {
                if (error.response.status === 422) {
                    var errors = error.response.data.errors;

                    Object.keys(errors).forEach(function(key) {
                        $('#' + key).addClass('is-invalid');
                        $('.' + key + '-error').text(errors[key][0]);
                    });
                } else {
                    handleError(error);
                }
            }
        });

        $('#data-table').on('click', '.btn-detail', async function() {
            try {
                var id = $(this).data('id');
                var response = await axios.get(`{{ route('admin.show', ['id' => '_id_']) }}`.replace('_id_', id));
                var res = response.data;

                $('#username-detail').text(res.data.username);
                $('#name-detail').text(res.data.name);
                $('#phone-detail').text(res.data.phone);
                $('#email-detail').text(res.data.email);
                $('#address-detail').text(res.data.address);
                $('#avatar-detail-preview').attr('src', 'uploads/admins/' + res.data.avatar);
                $('#modal-detail').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#data-table').on('click', '.btn-delete', function() {
            id = $(this).data('id');
            $('#modal-delete').modal('show');
        });

        $('#btn-confirm-delete').click(async function() {
            try {
                var response = await axios.get("{{ route('admin.destroy', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('#modal-delete').modal('hide');
                dataTable.draw();
                handleSuccess(res);
            } catch (error) {
                handleError(error);
            }
        });
    });
</script>
@endsection