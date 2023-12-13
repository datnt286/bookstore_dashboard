@extends('master')

@section('content')
<div class="row my-4">
    <div class="col-10">
        <h1 class="m-0">Quản lý nhà xuất bản</h1>
    </div>
    <div class="col-2 text-right">
        <button type="button" id="btn-create" class="btn btn-success mt-2" data-toggle="modal" data-target="#modal-store">
            <i class="fas fa-plus-circle"></i>
            Thêm nhà xuất bản
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="data-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tên nhà xuất bản</th>
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
                    <h4 id="modal-title" class="modal-title">Thêm nhà xuất bản</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name">Tên nhà xuất bản: </label>
                            <input type="text" name="name" id="name" class="form-control">
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
                url: "{{ route('publisher.index') }}",
                dataType: 'json',
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return '<div class="project-actions text-right">' +
                            '<button class="btn btn-primary btn-sm btn-edit mx-1" data-id="' + row.id + '" data-toggle="modal" data-target="#modal-store"><i class="fas fa-edit"></i> Cập nhật</button>' +
                            '<button class="btn btn-danger btn-sm btn-delete" data-id="' + row.id + '" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash-alt"></i> Xoá</button>' +
                            '</div>';
                    }
                }
            ]
        });

        var id = null;

        $('#btn-create').click(function() {
            $('#id').val(null);
            $('#form-store').trigger('reset');
            $('#modal-title').text('Thêm nhà xuất bản');
            $('#modal-store').modal('show');
        });

        $('#data-table').on('click', '.btn-edit', async function() {
            try {
                id = $(this).data('id');
                var response = await axios.get("{{ route('publisher.show', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('#id').val(res.data.id);
                $('#name').val(res.data.name);
                $('#modal-title').text('Cập nhật nhà xuất bản');
                $('#modal-store').modal('show');
            } catch (error) {
                handleError(error);
            }
        });

        $('#btn-store').click(async function() {
            try {
                var formData = new FormData($('#form-store')[0]);
                var response = await axios.post("{{ route('publisher.store') }}", formData);
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
                var response = await axios.get("{{ route('publisher.destroy', ['id' => '_id_']) }}".replace('_id_', id));
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