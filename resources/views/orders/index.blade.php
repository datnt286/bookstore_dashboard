@extends('master')

@section('content')
<div class="row my-4">
    <div class="col-9">
        <h1 class="m-0">Quản lý hoá đơn</h1>
    </div>
    <div class="col-3 text-right">
        <a type="button" href="{{ route('order.create') }}" class="btn btn-success mt-2">
            <i class="fas fa-plus-circle"></i>
            Thêm hoá đơn
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="data-table" class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Tên khách hàng</th>
                    <th>Điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Tổng tiền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->total }}</td>
                    <td>
                        <div class="project-actions text-right">
                            <button data-id="{{ $order->id }}" class="btn btn-info btn-sm btn-detail mx-1"><i class="fas fa-info-circle"></i> Chi tiết</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan=6>Không có dữ liệu!</td>
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
                <h4 class="modal-title">Chi tiết hoá đơn</h4>
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
                var order_id = $(this).data('id');
                var response = await axios.get("{{ route('order.show', ['id' => '_id_']) }}".replace('_id_', order_id));
                var res = response.data;

                $('.details-table tbody').empty();

                if (res.success && res.data.length > 0) {
                    res.data.forEach(detail => {
                        $('.details-table tbody').append(`
                            <tr>
                                <td>${detail.id}</td>
                                <td>${detail.book_id}</td>
                                <td>${detail.price}</td>
                                <td>${detail.quantity}</td>
                                <td>${detail.price * detail.quantity}</td>
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