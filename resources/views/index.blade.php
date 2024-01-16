@extends('master')

@section('content')
<div class="row mt-3">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                @php
                $formattedRevenue = number_format($totalRevenue, 0, '.', '.');
                @endphp
                <h3>{{ $formattedRevenue }} ₫</h3>

                <p>Tổng doanh thu</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalOrders }}</h3>

                <p>Hoá đơn mới</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalCustomers }}</h3>

                <p>Khách hàng mới</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalQuantity }}</h3>

                <p>Sản phẩm đã bán</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-book"></i>
            </div>
            <a href="#" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="far fa-chart-bar"></i>
            Doanh thu theo tháng
        </h3>
    </div>
    <div class="card-body">
        <div id="bar-chart" style="height: 300px;"></div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-book"></i>
                    Sách bán chạy tháng này
                </h3>
            </div>
            <div class="card-body">
                <table id="data-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng đã bán</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bestsellers as $bestseller)
                        <tr>
                            <td>{{ $bestseller->id }}</td>
                            <td>
                                <img src="uploads/images/{{ $bestseller->image }}" alt="Hình ảnh" class="img img-thumbnail" style="max-width: 100px; max-height: 100px;">
                            </td>
                            <td>{{ $bestseller->name }}</td>
                            <td>{{ $bestseller->total_quantity_sold_this_month }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan=3>Không có dữ liệu!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')
@if(session('message'))
<script>
    $(document).ready(function() {
        Toast.fire({
            icon: 'success',
            title: "{{ session('message') }}"
        });
    });
</script>
@endif

<script>
    $(document).ready(function() {
        var bar_data = {
            data: [
                [1, 10],
                [2, 8],
                [3, 4],
                [4, 13],
                [5, 17],
                [6, 9],
                [7, 10],
                [8, 8],
                [9, 4],
                [10, 13],
                [11, 17],
                [12, 9],
            ],
            bars: {
                show: true
            }
        }
        $.plot('#bar-chart', [bar_data], {
            grid: {
                borderWidth: 1,
                borderColor: '#f3f3f3',
                tickColor: '#f3f3f3'
            },
            series: {
                bars: {
                    show: true,
                    barWidth: 0.5,
                    align: 'center',
                },
            },
            colors: ['#3c8dbc'],
            xaxis: {
                ticks: [
                    [1, 'Tháng 1'],
                    [2, 'Tháng 2'],
                    [3, 'Tháng 3'],
                    [4, 'Tháng 4'],
                    [5, 'Tháng 5'],
                    [6, 'Tháng 6'],
                    [7, 'Tháng 7'],
                    [8, 'Tháng 8'],
                    [9, 'Tháng 9'],
                    [10, 'Tháng 10'],
                    [11, 'Tháng 11'],
                    [12, 'Tháng 12'],
                ]
            }
        })
    });
</script>
@endsection