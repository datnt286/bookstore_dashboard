@extends('master')

@section('content')
<div class="row my-4">
    <div class="col-9">
        <h1 class="m-0">Quản lý hoá đơn nhập</h1>
    </div>
    <div class="col-3 text-right">
        <a type="button" href="{{ route('goods-recevied-note.create') }}" class="btn btn-success mt-2">
            <i class="fas fa-plus-circle"></i>
            Thêm hoá đơn nhập
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="data-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nhà cung cấp</th>
                    <th>Tên admin</th>
                    <th>Ngày lập</th>
                    <th>Tổng tiền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($goodsReceviedNotes as $goodsReceviedNote)
                <tr>
                    <td>{{ $goodsReceviedNote->id }}</td>
                    <td>{{ $goodsReceviedNote->supplier->name }}</td>
                    <td>{{ $goodsReceviedNote->admin->name }}</td>
                    <td>{{ $goodsReceviedNote->create_date }}</td>
                    <td>{{ $goodsReceviedNote->total }}</td>
                    <td>
                        <div class="project-actions text-right">
                            <button data-id="{{ $goodsReceviedNote->id }}" class="btn btn-info btn-sm btn-detail mx-1"><i class="fas fa-info-circle"></i> Chi tiết</button>
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

<div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chi tiết hoá đơn nhập</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <table class="table table-bordered details-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá nhập</th>
                                <th>Giá bán</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
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
        $('#data-table').DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            searching: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    text: 'Sao chép',
                },
                {
                    extend: 'excel',
                    text: 'Xuất Excel',
                    title: 'Danh sách hoá đơn nhập',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                },
                {
                    extend: 'pdf',
                    text: 'Xuất PDF',
                    title: 'Danh sách hoá đơn nhập',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
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
            columns: [
                null,
                null,
                null,
                null,
                {
                    data: 'total',
                    render: function(data, type, row) {
                        return parseFloat(data).toLocaleString() + ' ₫';
                    }
                },
                null
            ],
            columnDefs: [{
                targets: [5],
                orderable: false
            }],
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
        }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

        $('#data-table').on('click', '.btn-detail', async function() {
            try {
                var id = $(this).data('id');
                var response = await axios.get("{{ route('goods-recevied-note.show', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('.details-table tbody').empty();

                if (res.success && res.data.length > 0) {
                    res.data.forEach(detail => {
                        $('.details-table tbody').append(`
                        <tr>
                            <td class="align-middle">${detail.id}</td>
                            <td class="align-middle">
                                <div style="display: flex; align-items: center;">
                                    <img src="${detail.product_image}" alt="Hình ảnh" style="max-width: 80px; max-height: 120px; margin-right: 10px;" />
                                    <span style="max-height: 60px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        ${detail.product_name}
                                    </span>
                                </div>
                            </td>
                            <td class="align-middle">${detail.import_price.toLocaleString() + ' ₫'}</td>
                            <td class="align-middle">${detail.price.toLocaleString() + ' ₫'}</td>
                            <td class="align-middle">${detail.quantity}</td>
                            <td class="align-middle">${(detail.import_price * detail.quantity).toLocaleString() + ' ₫'}</td>
                        </tr>
                        `);
                    });
                } else {
                    $('.details-table tbody').append('<tr><td colspan="5">Không có dữ liệu chi tiết!</td></tr>');
                }

                $('#modal-detail').modal('show');
            } catch (error) {
                handleError(error);
            }
        });
    });
</script>
@endsection