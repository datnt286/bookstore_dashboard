@extends('master')

@section('content')
<div class="row my-4">
    <div class="col-10">
        <h1 class="m-0">Quản lý tác giả</h1>
    </div>
    <div class="col-2 text-right">
        <button type="button" id="btn-create" class="btn btn-success mt-2" data-toggle="modal" data-target="#modal-store">
            <i class="fas fa-plus-circle"></i>
            Thêm tác giả
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="data-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tên tác giả</th>
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
                    <h4 id="modal-title" class="modal-title">Thêm tác giả</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name">Tên tác giả: </label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <div class="invalid-feedback name-error">{{ $errors->first('name') }}</div>
                        </div>
                        <div class="form-group">
                            <label>Sách:</label>
                            <select name="book_ids[]" id="book-ids" class="select2" multiple="multiple" style="width: 100%;">
                            </select>
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
        $('.select2').select2();

        var dataTable = $('#data-table').DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    text: 'Sao chép',
                },
                {
                    extend: 'excel',
                    text: 'Xuất Excel',
                    title: 'Danh sách tác giả',
                    exportOptions: {
                        columns: [0, 1]
                    },
                },
                {
                    extend: 'pdf',
                    text: 'Xuất PDF',
                    title: 'Danh sách tác giả',
                    exportOptions: {
                        columns: [0, 1]
                    },
                },
                {
                    extend: 'print',
                    text: 'In',
                },
                {
                    extend: 'colvis',
                    text: 'Hiển thị cột',
                },
                {
                    extend: 'pageLength',
                    text: 'Số dòng trên trang',
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
                url: "{{ route('author.index') }}",
                dataType: 'json',
            },
            columns: [{
                    data: 'id',
                    name: 'id',
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

        $('#btn-create').click(async function() {
            try {
                resetValidationForm();
                $('#id').val(null);
                $('#form-store').trigger('reset');
                $('#book-ids').empty();

                var response = await axios.get("{{ route('author.create') }}");
                var res = response.data;

                res.data.forEach(function(book) {
                    $('#book-ids').append('<option value="' + book.id + '">' + book.name + '</option>');
                });

                $('#modal-title').text('Thêm tác giả');
                $('#modal-store').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#data-table').on('click', '.btn-edit', async function() {
            try {
                resetValidationForm();
                id = $(this).data('id');
                var response = await axios.get("{{ route('author.show', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('#id').val(res.data.author.id);
                $('#name').val(res.data.author.name);

                $('#book-ids').empty();

                res.data.books.forEach(function(book) {
                    var selected = (res.data.author.books.map(b => b.id).includes(book.id)) ? 'selected' : '';
                    $('#book-ids').append('<option value="' + book.id + '" ' + selected + '>' + book.name + '</option>');
                });

                $('#modal-title').text('Cập nhật tác giả');
                $('#modal-store').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#btn-store').click(async function() {
            try {
                id = $('#id').val();
                var formData = new FormData($('#form-store')[0]);
                var response = await axios.post("{{ route('author.store') }}", formData);
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
                var response = await axios.get("{{ route('author.destroy', ['id' => '_id_']) }}".replace('_id_', id));
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