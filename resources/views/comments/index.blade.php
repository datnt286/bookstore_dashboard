@extends('master')

@section('content')
<div class="row my-4">
    <div class="col-9">
        <h1 class="m-0">Quản lý bình luận</h1>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="data-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tên khách hàng</th>
                    <th>Tên sản phẩm</th>
                    <th>Nội dung</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                <tr>
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->customer->name }}</td>
                    <td>{{ $comment->product_name }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>
                        <div class="project-actions d-flex justify-content-between">
                            <button data-id="{{ $comment->id }}" class="btn btn-info btn-sm btn-reply mx-1"><i class="fas fa-info-circle"></i> Xem phản hồi</button>
                            <button data-id="{{ $comment->customer_id }}" class="btn btn-warning btn-sm btn-reply mx-1"><i class="fas fa-comment-slash"></i> Khoá bình luận</button>
                            <button data-id="{{ $comment->id }}" class="btn btn-danger btn-sm mx-1 btn-delete"><i class="fas fa-trash-alt"></i> Xoá</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan=5>Không có dữ liệu!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-reply">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Phản hồi bình luận</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <table class="table table-bordered replys-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tên khách hàng</th>
                                <th>Tên sản phẩm</th>
                                <th>Nội dung</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
                url: "{{ route('comment.index') }}",
                dataType: 'json',
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'customer_name'
                },
                {
                    data: 'product_name'
                },
                {
                    data: 'content'
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return '<div class="project-actions text-right">' +
                            '<button class="btn btn-info btn-sm btn-reply" data-id="' + row.id + '"><i class="fas fa-info-circle"></i> Xem phản hồi</button>' +
                            '<button class="btn btn-warning btn-sm mx-1" data-id="' + row.customer_id + '"><i class="fas fa-comment-slash"></i> Khoá bình luận</button>' +
                            '<button class="btn btn-danger btn-sm btn-delete mx-1" data-id="' + row.id + '"><i class="fas fa-trash-alt"></i> Xoá</button>' +
                            '</div>';
                    }
                }
            ]
        });

        $('#data-table').on('click', '.btn-reply', async function() {
            try {
                var id = $(this).data('id');
                var response = await axios.get("{{ route('comment.reply', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('.replys-table tbody').empty();

                if (res.success && res.data.length > 0) {
                    res.data.forEach(reply => {
                        $('.replys-table tbody').append(`
                        <tr>
                            <td class="align-middle">${reply.id}</td>
                            <td class="align-middle">${reply.customer_name}</td>
                            <td class="align-middle">${reply.product_name}</td>
                            <td class="align-middle">${reply.content}</td>
                            <td class="align-middle">
                                <button data-id="${reply.customer_id}" class="btn btn-warning btn-sm btn-reply mx-1"><i class="fas fa-comment-slash"></i> Khoá bình luận</button>
                                <button data-id="${reply.id}" class="btn btn-danger btn-sm mx-1 btn-delete"><i class="fas fa-trash-alt"></i> Xoá</button>
                            </td>
                        </tr>
                        `);
                    });
                } else {
                    $('.replys-table tbody').append('<tr><td colspan="5">Không có dữ liệu chi tiết!</td></tr>');
                }

                $('#modal-reply').modal('show');
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
                var response = await axios.get("{{ route('comment.destroy', ['id' => '_id_']) }}".replace('_id_', id));
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