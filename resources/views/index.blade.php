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
    <!-- Bar chart -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    Doanh thu theo tháng
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="bar-chart" style="height: 300px;"></div>
            </div>
        </div>
    </div>

    <!-- Line chart -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    Line Chart
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="line-chart" style="height: 300px;"></div>
            </div>
        </div>
    </div>

    <!-- Donut chart -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="far fa-chart-bar"></i>
                    Donut Chart
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="donut-chart" style="height: 300px;"></div>
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
        // BAR CHART
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

        // LINE CHART
        //LINE randomly generated data
        var sin = [],
            cos = []
        for (var i = 0; i < 14; i += 0.5) {
            sin.push([i, Math.sin(i)])
            cos.push([i, Math.cos(i)])
        }
        var line_data1 = {
            data: sin,
            color: '#3c8dbc'
        }
        var line_data2 = {
            data: cos,
            color: '#00c0ef'
        }
        $.plot('#line-chart', [line_data1, line_data2], {
            grid: {
                hoverable: true,
                borderColor: '#f3f3f3',
                borderWidth: 1,
                tickColor: '#f3f3f3'
            },
            series: {
                shadowSize: 0,
                lines: {
                    show: true
                },
                points: {
                    show: true
                }
            },
            lines: {
                fill: false,
                color: ['#3c8dbc', '#f56954']
            },
            yaxis: {
                show: true
            },
            xaxis: {
                show: true
            }
        })
        //Initialize tooltip on hover
        $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
            position: 'absolute',
            display: 'none',
            opacity: 0.8
        }).appendTo('body')
        $('#line-chart').bind('plothover', function(event, pos, item) {

            if (item) {
                var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2)

                $('#line-chart-tooltip').html(item.series.label + ' of ' + x + ' = ' + y)
                    .css({
                        top: item.pageY + 5,
                        left: item.pageX + 5
                    })
                    .fadeIn(200)
            } else {
                $('#line-chart-tooltip').hide()
            }

        })

        // DONUT CHART
        var donutData = [{
                label: 'Series2',
                data: 30,
                color: '#3c8dbc'
            },
            {
                label: 'Series3',
                data: 20,
                color: '#0073b7'
            },
            {
                label: 'Series4',
                data: 50,
                color: '#00c0ef'
            }
        ]
        $.plot('#donut-chart', donutData, {
            series: {
                pie: {
                    show: true,
                    radius: 1,
                    innerRadius: 0.5,
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
    });
</script>
@endsection