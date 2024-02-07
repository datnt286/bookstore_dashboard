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
                    <th>Tổng thanh toán</th>
                    <th>Hình thức thanh toán</th>
                    <th>Trạng thái thanh toán</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
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
                                <th>Sản phẩm</th>
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
                    title: 'Danh sách hoá đơn',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                },
                {
                    extend: 'pdf',
                    text: 'Xuất PDF',
                    title: 'Danh sách hoá đơn',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
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
                url: "{{ route('order.index') }}",
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
                    data: 'phone',
                    name: 'phone',
                },
                {
                    data: 'address',
                    name: 'address',
                },
                {
                    data: 'total_payment',
                    name: 'total_payment',
                    render: function(data, type, row) {
                        return data.toLocaleString() + ' ₫';
                    }
                },
                {
                    data: 'payment_method',
                    name: 'payment_method',
                    render: function(data, type, row) {
                        switch (data) {
                            case 1:
                                return 'Thanh toán khi nhận hàng';
                            case 2:
                                return 'Thanh toán Paypal';
                            case 3:
                                return 'Thanh toán tại cửa hàng';
                            default:
                                return 'Phương thức thanh toán không xác định';
                        }
                    }
                },
                {
                    data: 'payment_status',
                    name: 'payment_status',
                    render: function(data, type, row) {
                        if (data === 1) {
                            return '<span class="badge badge-success">Đã thanh toán</span>';
                        } else {
                            return '<span class="badge badge-warning">Chưa thanh toán</span>';
                        }
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        switch (data) {
                            case 1:
                                return '<span class="badge badge-info">Chờ xác nhận</span>';
                            case 2:
                                return '<span class="badge badge-primary">Đã xác nhận</span>';
                            case 3:
                                return '<span class="badge badge-warning">Đang giao</span>';
                            case 4:
                                return '<span class="badge badge-success">Đã giao</span>';
                            case 5:
                                return '<span class="badge badge-danger">Đã huỷ</span>';
                            default:
                                return '';
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        var buttons = '<div class="project-actions text-right">' +
                            '<button class="btn btn-secondary btn-sm btn-detail" data-id="' + row.id + '"><i class="fas fa-info-circle"></i> Chi tiết</button>';

                        switch (row.status) {
                            case 1:
                                buttons += '<button class="btn btn-info btn-sm btn-update-status mx-1" data-id="' + row.id + '" data-status="2"><i class="fas fa-edit"></i> Xác nhận</button>';
                                buttons += '<button class="btn btn-danger btn-sm btn-update-status" data-id="' + row.id + '" data-status="5"><i class="fas fa-trash-alt"></i> Huỷ đơn</button>';
                                break;
                            case 2:
                                buttons += '<button class="btn btn-primary btn-sm btn-update-status mx-1" data-id="' + row.id + '" data-status="3"><i class="fas fa-truck"></i> Giao hàng</button>';
                                buttons += '<button class="btn btn-danger btn-sm btn-update-status" data-id="' + row.id + '" data-status="5"><i class="fas fa-trash-alt"></i> Huỷ đơn</button>';
                                break;
                            case 3:
                                buttons += '<button class="btn btn-warning btn-sm btn-update-status mx-1" data-id="' + row.id + '" data-status="4" disabled><i class="fas fa-spinner"></i> Đang giao</button>';
                                buttons += '<button class="btn btn-danger btn-sm btn-update-status" data-id="' + row.id + '" data-status="5"><i class="fas fa-trash-alt"></i> Huỷ đơn</button>';
                                break;
                            case 4:
                                buttons += '<button class="btn btn-success btn-sm btn-update-status mx-1" data-id="' + row.id + '" data-status="4" disabled><i class="fas fa-check-circle"></i> Đã giao</button>';
                                buttons += '<button class="btn btn-danger btn-sm btn-update-status" data-id="' + row.id + '" data-status="5" disabled><i class="fas fa-trash-alt"></i> Huỷ đơn</button>';
                                break;
                            case 5:
                                buttons += '<button class="btn btn-danger btn-sm btn-update-status mx-1" data-id="' + row.id + '" data-status="5" disabled><i class="fas fa-trash-alt"></i> Đã huỷ</button>';
                                buttons += '<button class="btn btn-danger btn-sm btn-update-status" data-id="' + row.id + '" data-status="5" disabled><i class="fas fa-trash-alt"></i> Huỷ đơn</button>';
                                break;
                            default:
                                break;
                        }

                        buttons += '</div>';

                        return buttons;
                    }
                },
            ],
            order: [
                [0, 'desc']
            ],
        });

        $('#data-table').on('click', '.btn-detail', async function() {
            try {
                var id = $(this).data('id');
                var response = await axios.get("{{ route('order.show', ['id' => '_id_']) }}".replace('_id_', id));
                var res = response.data;
                var total = 0;

                $('.details-table tbody').empty();

                if (res.success && res.data.length > 0) {
                    res.data.forEach(detail => {
                        total += detail.price * detail.quantity;
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
                            <td class="align-middle">${detail.price.toLocaleString() + ' ₫'}</td>
                            <td class="align-middle">${detail.quantity}</td>
                            <td class="align-middle">${(detail.price * detail.quantity).toLocaleString() + ' ₫'}</td>
                        </tr>
                    `);
                    });

                    $('.details-table tbody').append(`
                        <tr>
                            <td colspan="4" class="align-middle text-right"><strong>Tổng thành tiền:</strong></td>
                            <td class="align-middle">${total.toLocaleString() + ' ₫'}</td>
                        </tr>
                    `);
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
                var response = await axios.get("{{ route('order.update-status', ['id' => '_id_', 'status' => '_status_']) }}".replace('_id_', id).replace('_status_', status));
                var res = response.data;

                dataTable.draw();
                handleSuccess(res);
            } catch (error) {
                handleError(error);
            }
        });
    });
</script>
@endsection