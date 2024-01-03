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
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->total }}</td>
                    @switch($order->status)
                    @case(1)
                    <td>Chờ xác nhận</td>
                    @break
                    @case(2)
                    <td>Đã xác nhận</td>
                    @break
                    @case(3)
                    <td>Đang giao</td>
                    @break
                    @case(4)
                    <td>Đã giao</td>
                    @break
                    @case(5)
                    <td>Đã huỷ</td>
                    @break
                    @endswitch
                    <td>
                        <div class="project-actions d-flex justify-content-between">
                            <input type="hidden" class="order-status" value="{{ $order->status }}">
                            <button data-id="{{ $order->id }}" class="btn btn-info btn-sm btn-detail mx-1"><i class="fas fa-info-circle"></i> Chi tiết</button>
                            <button data-id="{{ $order->id }}" data-status="2" class="btn btn-success btn-sm mx-1 btn-update-status">Duyệt đơn</button>
                            <button data-id="{{ $order->id }}" data-status="5" class="btn btn-danger btn-sm mx-1 btn-update-status">Huỷ đơn</button>
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
                targets: [6],
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

        $('.btn-update-status').each(function() {
            var status = $(this).data('status');
            var orderStatus = $(this).closest('tr').find('.order-status').val();

            switch (orderStatus) {
                case '1':
                    $(this).text('Duyệt đơn').data('status', 1);
                    break;
                case '2':
                    $(this).text('Vận chuyển').data('status', 2).removeClass('btn-success').addClass('btn-warning');
                    break;
                case '3':
                case '4':
                case '5':
                    $(this).text('Đã ' + (orderStatus === '3' ? 'giao' : 'hủy')).addClass('disabled').attr('disabled', 'disabled');
                    break;
                default:
                    break;
            }
        });

        $('#data-table').on('click', '.btn-detail', async function() {
            try {
                var id = $(this).data('id');
                var response = await axios.get("{{ route('order.show', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;

                $('.details-table tbody').empty();

                if (res.success && res.data.length > 0) {
                    res.data.forEach(detail => {
                        $('.details-table tbody').append(`
                        <tr>
                            <td>${detail.id}</td>
                            <td>${detail.product_name}</td>
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

        $('#data-table').on('click', '.btn-update-status', async function() {
            try {
                var id = $(this).data('id');
                var status = $(this).data('status');
                var response = await axios.post("{{ route('order.update-status', ['id' => '_id_', 'status' => '_status_']) }}".replace('_id_', id).replace('_status_', status));
                var res = response.data;

                switch (status) {
                    case 2:
                        $(this).closest('tr').find('td:eq(5)').text('Đã xác nhận');
                        $(this).data('status', 3).removeClass('btn-success').addClass('btn-warning').text('Vận chuyển');
                        break;
                    case 3:
                        $(this).closest('tr').find('td:eq(5)').text('Đang giao');
                        break;
                    case 5:
                        $(this).closest('tr').find('td:eq(5)').text('Đã huỷ');
                        break;
                    default:
                        break;
                }

                if (status === 3 || status === 5) {
                    $(this).addClass('disabled').attr('disabled', 'disabled');
                }

                handleSuccess(res);
            } catch (error) {
                handleError(error);
            }
        });
    });
</script>
@endsection