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

<div class="row">
    <div class="col-md-6">
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
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    Doanh thu theo thể loại
                </h3>
            </div>
            <div class="card-body">
                <div id="donut-chart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
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
                            <th>#</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng đã bán</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bestsellers as $bestseller)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="uploads/images/{{ $bestseller->image }}" alt="Hình ảnh" class="img img-thumbnail" style="max-width: 100px; max-height: 100px;">
                            </td>
                            <td>{{ $bestseller->name }}</td>
                            <td>{{ $bestseller->total_quantity_sold_this_month }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan=4>Không có dữ liệu!</td>
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
        async function monthlyRevenue() {
            try {
                var res = await axios.get("{{ route('get-monthly-revenue') }}");
                var revenueStats = res.data.data;

                var barData = {
                    data: [
                        [1, revenueStats.revenueMonth1],
                        [2, revenueStats.revenueMonth2],
                        [3, revenueStats.revenueMonth3],
                        [4, revenueStats.revenueMonth4],
                        [5, revenueStats.revenueMonth5],
                        [6, revenueStats.revenueMonth6],
                    ],
                    bars: {
                        show: true
                    }
                }
                $.plot('#bar-chart', [barData], {
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
                        ]
                    }
                })
            } catch (error) {
                handleError(error);
            }
        }

        async function revenueByCategory() {
            try {
                var res = await axios.get("{{ route('get-revenue-by-category') }}");
                var revenueStats = res.data.data;

                var pieData = [{
                        label: 'Sách tự lực',
                        data: revenueStats.revenue_self_helf,
                        color: '#28a745'
                    },
                    {
                        label: 'Truyện tranh',
                        data: revenueStats.revenue_manga,
                        color: '#00c0ef'
                    },
                    {
                        label: 'Sách giáo khoa',
                        data: revenueStats.revenue_textbook,
                        color: '#ffc107'
                    }
                ]
                $.plot('#donut-chart', pieData, {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            label: {
                                show: true,
                                radius: 2 / 3,
                                formatter: labelFormatter,
                                threshold: 0.1
                            }
                        }
                    },
                    legend: {
                        show: false
                    }
                })
            } catch (error) {
                handleError(error);
            }
        }

        monthlyRevenue();
        revenueByCategory();

        function labelFormatter(label, series) {
            return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">' +
                label +
                '<br>' +
                Math.round(series.percent) + '%</div>'
        }
    });
</script>
@endsection