@extends('master')

@section('content')
<div class="row my-4">
    <div class="col-10">
        <h1 class="m-0">Quản lý thể loại</h1>
    </div>
    <div class="col-2 text-right">
        <button type="button" id="btn-create" class="btn btn-success mt-2" data-toggle="modal" data-target="#modal-store">
            <i class="fas fa-plus-circle"></i>
            Thêm thể loại
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="data-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Hình ảnh</th>
                    <th>Thể loại</th>
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
                    <h4 id="modal-title" class="modal-title">Thêm thể loại</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group text-center">
                            <label for="image" class="form-label d-block">Hình ảnh:</label>
                            <div>
                                <img id="image-preview" src="{{ asset('img/default-image.jpg') }}" alt="Hình ảnh" class="img img-thumbnail my-2" style="max-width: 100px; max-height: 100px;">
                            </div>
                            <input type="file" name="image" id="image" class="d-none">
                            <div class="invalid-feedback image-error">{{ $errors->first('image') }}</div>
                            <label for="image" class="btn btn-secondary font-weight-normal mt-2">
                                Chọn ảnh
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="name">Thể loại: </label>
                            <input type="text" name="name" id="name" class="form-control">
                            <div class="invalid-feedback name-error">{{ $errors->first('name') }}</div>
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
                url: "{{ route('category.index') }}",
                dataType: 'json',
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<img src="uploads/categories/' + row.image + '" alt="Hình ảnh" class="img img-thumbnail" style="max-width: 100px; max-height: 100px;">';
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                }
            ]
        });

        var id = null;
        var image = null;
        var formData = new FormData($('#form-store')[0]);

        $('#btn-create').click(function() {
            resetValidationForm();
            id = null;
            $('#id').val(null);
            $('#form-store').trigger('reset');
            $('#image-preview').attr('src', 'img/default-image.jpg');
            $('#modal-title').text('Thêm thể loại');
            $('#modal-store').modal('show');
        });

        $('#data-table').on('click', '.btn-edit', async function() {
            try {
                resetValidationForm();
                id = $(this).data('id');
                var response = await axios.get("{{ route('category.show', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('#id').val(res.data.id);
                $('#name').val(res.data.name);
                $('#image-preview').attr('src', 'uploads/categories/' + res.data.image);
                $('#modal-title').text('Cập nhật thể loại');
                $('#modal-store').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#image').change(function(event) {
            var input = event.target;

            $(this).removeClass('is-invalid');
            $('.image-error').text('');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result);

                    formData.set('image', input.files[0]);
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
                id = $('#id').val();
                var formData = new FormData($('#form-store')[0]);

                if (id) {
                    var url = `{{ route('category.update', ['id' => '_id_']) }}`.replace('_id_', id);
                } else {
                    var url = "{{ route('category.store') }}";
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

        $('#data-table').on('click', '.btn-delete', function() {
            id = $(this).data('id');
            $('#modal-delete').modal('show');
        });

        $('#btn-confirm-delete').click(async function() {
            try {
                var response = await axios.get("{{ route('category.destroy', ['id' => '_id_']) }}".replace('_id_', id));
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