@extends('master')

@section('content')
<div class="row my-4">
    <div class="col-9">
        <h1 class="m-0">Quản lý khách hàng</h1>
    </div>
    <div class="col-3 text-right">
        <button type="button" id="btn-create" class="btn btn-success mt-2" data-toggle="modal" data-target="#modal-store">
            <i class="fas fa-plus-circle"></i>
            Thêm khách hàng
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="data-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tên đăng nhập</th>
                    <th>Tên khách hàng</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-store">
    <form id="form-store">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">Thêm khách hàng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="username">Tên đăng nhập:</label>
                            <input type="text" name="username" id="username" class="form-control">
                            <div class="invalid-feedback username-error">{{ $errors->first('username') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu:</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <div class="invalid-feedback password-error">{{ $errors->first('password') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="name">Tên khách hàng:</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <div class="invalid-feedback name-error">{{ $errors->first('name') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Điện thoại:</label>
                            <input type="text" name="phone" id="phone" class="form-control">
                            <div class="invalid-feedback phone-error">{{ $errors->first('phone') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" name="email" id="email" class="form-control">
                            <div class="invalid-feedback email-error">{{ $errors->first('email') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ:</label>
                            <input type="text" name="address" id="address" class="form-control">
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
                <h4 class="modal-title">Thông tin khách hàng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-group">
                        <span class="text-lg font-weight-bold">Tên đăng nhập: </span>
                        <span id="username-detail" class="text-lg"></span>
                    </div>
                    <div class="form-group">
                        <span class="text-lg font-weight-bold">Tên khách hàng: </span>
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
        var dataTable = $('#data-table').DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
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
                url: "{{ route('customer.index') }}",
                dataType: 'json',
            },
            columns: [{
                    data: 'id'
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
                    data: 'address'
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return '<div class="project-actions text-right">' +
                            '<button class="btn btn-info btn-sm btn-detail" data-id="' + row.id + '" data-toggle="modal" data-target="#modal-detail"><i class="fas fa-info-circle"></i> Chi tiết</button>' +
                            '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' + row.id + '" data-toggle="modal" data-target="#modal-store"><i class="fas fa-edit"></i> Cập nhật</button>' +
                            '<button class="btn btn-danger btn-sm btn-delete" data-id="' + row.id + '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' +
                            '</div>';
                    }
                }
            ]
        });

        var id = null;

        $('#btn-create').click(function() {
            resetValidationForm();
            id = null;
            $('#id').val(null);
            $('#form-store').trigger('reset');
            $('#username').prop('readonly', false);
            $('#modal-title').text('Thêm khách hàng');
            $('#modal-store').modal('show');
        });

        $('#data-table').on('click', '.btn-edit', async function() {
            try {
                resetValidationForm();
                id = $(this).data('id');
                var response = await axios.get("{{ route('customer.show', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('#id').val(res.data.id);
                $('#username').val(res.data.username);
                $('#password').val('');
                $('#name').val(res.data.name);
                $('#phone').val(res.data.phone);
                $('#email').val(res.data.email);
                $('#address').val(res.data.address);
                $('#username').prop('readonly', true);
                $('#modal-title').text('Cập nhật khách hàng');
                $('#modal-store').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#btn-store').click(async function() {
            try {
                var formData = new FormData($('#form-store')[0]);

                if (id) {
                    var url = `{{ route('customer.update', ['id' => '_id_']) }}`.replace('_id_', id);
                } else {
                    var url = "{{ route('customer.store') }}";
                }

                var response = await axios.post(url, formData);
                var res = response.data;

                $('#modal-store').modal('hide');
                $('#form-store').trigger('reset');
                dataTable.draw();
                handleSuccess(res);
            } catch (error) {
                handleError(error);
            }
        });

        $('#data-table').on('click', '.btn-detail', async function() {
            try {
                var id = $(this).data('id');
                var response = await axios.get("{{ route('customer.show', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('#username-detail').text(res.data.username);
                $('#name-detail').text(res.data.name);
                $('#phone-detail').text(res.data.phone);
                $('#email-detail').text(res.data.email);
                $('#address-detail').text(res.data.address);
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
                var response = await axios.get("{{ route('customer.destroy', ['id' => '_id_']) }}".replace('_id_', id));
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