@php use App\CentralLogics\Helpers; @endphp
@extends('layouts.admin.app')

@section('title',translate('messages.customer_wallet_report'))

@section('content')
    @php
        $from = session('from_date');
        $to = session('to_date');
    @endphp
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="{{asset('assets/admin/img/icons/wallet.png')}}" class="w--26" alt="">
                </span>
                <span>
                     {{translate('messages.customer_wallet_report')}}
                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <span>{{translate('messages.filter_options')}}</span>
                </h4>

                <form action="{{route('admin.users.customer.wallet.set-date')}}" method="post">
                    @csrf
                    <div class="row justify-content-end align-items-end g-3">
                        <div class="col-lg-4">
                            <label class="text-dark text-capitalize"
                                   for="add-fund-type">{{translate('messages.add_fund_type')}}</label>
                            @php
                                $transaction_status=request()->get('transaction_type');
                            @endphp
                            <select name="transaction_type" id="add-fund-type" data-url="{{ url()->full() }}"
                                    data-filter="transaction_type" class="form-control set-filter js-select2-custom"
                                    title="{{translate('messages.select_transaction_type')}}">
                                <option value="all">{{translate('messages.All_transactions')}}</option>
                                <option
                                    value="add_fund_by_admin" {{isset($transaction_status) && $transaction_status=='add_fund_by_admin'?'selected':''}} >{{translate('messages.add_fund_by_admin')}}</option>
                                <option
                                    value="add_fund" {{isset($transaction_status) && $transaction_status=='add_fund'?'selected':''}}>{{translate('messages.add_fund_by_customer')}}</option>
                                <option
                                    value="order_refund" {{isset($transaction_status) && $transaction_status=='order_refund'?'selected':''}}>{{translate('messages.refund_order')}}</option>
                                <option
                                    value="loyalty_point" {{isset($transaction_status) && $transaction_status=='loyalty_point'?'selected':''}}>{{translate('messages.customer_loyalty_point')}}</option>
                                <option
                                    value="order_place" {{isset($transaction_status) && $transaction_status=='order_place'?'selected':''}}>{{translate('messages.order_place')}}</option>
                                <option
                                    value="CashBack" {{isset($transaction_status) && $transaction_status=='CashBack'?'selected':''}}>{{translate('messages.CashBack')}}</option>
                                <option
                                    value="referrer" {{isset($transaction_status) && $transaction_status=='referrer'?'selected':''}}>{{translate('messages.Referrer')}}</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="text-dark text-capitalize"
                                   for="customer">{{translate('messages.customer')}}</label>
                            <select id='customer' name="customer_id" data-url="{{ url()->full() }}"
                                    data-filter="customer_id"
                                    data-placeholder="{{translate('messages.select_customer')}}"
                                    class="js-data-example-ajax form-control set-filter"
                                    title="{{translate('messages.select_customer')}}">
                                @if (request()->get('customer_id') && $customer_info = \App\Models\User::find(request()->get('customer_id')))
                                    <option value="{{$customer_info->id}}"
                                            selected>{{$customer_info->f_name.' '.$customer_info->l_name}}
                                        ({{$customer_info->phone}})
                                    </option>
                                @endif
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="text-dark text-capitalize"
                                   for="filter">{{translate('messages.duration')}}</label>
                            <select class="form-control set-filter js-select2-custom" name="filter"
                                    data-url="{{ url()->full() }}" data-filter="filter">
                                <option
                                    value="all_time" {{ isset($filter) && $filter == 'all_time' ? 'selected' : '' }}>
                                    {{ translate('messages.All Time') }}</option>
                                <option
                                    value="this_year" {{ isset($filter) && $filter == 'this_year' ? 'selected' : '' }}>
                                    {{ translate('messages.This Year') }}</option>
                                <option value="previous_year"
                                    {{ isset($filter) && $filter == 'previous_year' ? 'selected' : '' }}>
                                    {{ translate('messages.Previous Year') }}</option>
                                <option value="this_month"
                                    {{ isset($filter) && $filter == 'this_month' ? 'selected' : '' }}>
                                    {{ translate('messages.This Month') }}</option>
                                <option
                                    value="this_week" {{ isset($filter) && $filter == 'this_week' ? 'selected' : '' }}>
                                    {{ translate('messages.This Week') }}</option>
                                <option value="custom" {{ isset($filter) && $filter == 'custom' ? 'selected' : '' }}>
                                    {{ translate('messages.Custom') }}</option>
                            </select>
                        </div>
                        @if (isset($filter) && $filter == 'custom')
                            <div class="col-lg-4">

                                <input type="date" name="from" id="from_date" class="form-control"
                                       placeholder="{{ translate('Start Date') }}"
                                       {{ session()->has('from_date') ? 'value=' . session('from_date') : '' }} required>

                            </div>
                            <div class="col-lg-4">

                                <input type="date" name="to" id="to_date" class="form-control"
                                       placeholder="{{ translate('End Date') }}"
                                       {{ session()->has('to_date') ? 'value=' . session('to_date') : '' }} required>

                            </div>
                        @endif
                        <div class="col-lg-4">
                            <div class="btn--container justify-content-end">
                                <button type="reset" class="btn btn--reset location-reload-to-base"
                                        data-url="{{url()->full()}}">{{translate('messages.reset')}}</button>
                                <button type="submit" class="btn btn--primary">{{translate('messages.filter')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row g-3 h-100">
                            @php
                                $credit = $data[0]->total_credit;
                                $debit = $data[0]->total_debit;
                                $add_fund_total = $data[0]->add_fund_total;
                                $order_refund_total = $data[0]->order_refund_total;
                                $loyalty_point_total = $data[0]->loyalty_point_total;
                                $order_place_total = $data[0]->total_debit;
                                $balance = $credit - $debit;
                            @endphp

                                <!--Debit earned-->
                            <div class="col-6">
                                <div
                                    class="color-card flex-column align-items-center justify-content-center color-6 h-100">
                                    <div class="img-box">
                                        <img class="resturant-icon w--30"
                                             src="{{asset('assets/admin/img/customer-loyality/1.png')}}"
                                             alt="dashboard">
                                    </div>
                                    <div class="d-flex flex-column align-items-center">
                                        <h2 class="title"> {{Helpers::format_currency($debit)}} </h2>
                                        <div class="subtitle">{{translate('messages.debit')}}</div>
                                    </div>
                                </div>
                            </div>
                            <!--Debit earned End-->

                            <!--credit earned-->
                            <div class="col-6">
                                <div
                                    class="color-card flex-column align-items-center justify-content-center color-4 h-100">
                                    <div class="img-box">
                                        <img class="resturant-icon w--30"
                                             src="{{asset('assets/admin/img/customer-loyality/2.png')}}"
                                             alt="dashboard">
                                    </div>
                                    <div class="d-flex flex-column align-items-center">
                                        <h2 class="title"> {{Helpers::format_currency($credit)}} </h2>
                                        <div class="subtitle">{{translate('messages.credit')}}</div>
                                    </div>
                                </div>
                            </div>
                            <!--credit earned end-->

                            <!--balance earned-->
{{--                            <div class="col-sm-4">--}}
{{--                                <div--}}
{{--                                    class="color-card flex-column align-items-center justify-content-center color-2 h-100">--}}
{{--                                    <div class="img-box">--}}
{{--                                        <img class="resturant-icon w--30"--}}
{{--                                             src="{{asset('assets/admin/img/customer-loyality/3.png')}}"--}}
{{--                                             alt="dashboard">--}}
{{--                                    </div>--}}
{{--                                    <div class="d-flex flex-column align-items-center">--}}
{{--                                        <h2 class="title">{{Helpers::format_currency($balance)}} </h2>--}}
{{--                                        <div class="subtitle">{{translate('messages.balance')}}</div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <!--balance earned end-->
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body" id="fund-statistics-board">
                                <h5 class="text-center text-capitalize">{{translate('messages.fund_statistics')}}</h5>
                                <div class="position-relative pie-chart">
                                    <div id="doughnut-pie"></div>
                                    <!-- Total Orders -->
                                    <div class="total--orders">
                                        <h4 class="text-uppercase mb-1">{{Helpers::number_format_short($add_fund_total+$order_refund_total+$loyalty_point_total+$order_place_total)}}</h4>
                                        <span class="text-capitalize">{{translate('messages.total')}}</span>
                                    </div>
                                    <!-- Total Orders -->
                                </div>
                                <div class="d-flex flex-wrap justify-content-center mt-4">
                                    <div class="chart--label">
                                        <span class="indicator chart-bg-1"></span>
                                        <span class="info">
                                            {{translate('messages.Fund added by Admin')}} ({{Helpers::format_currency($add_fund_total)}})
                                        </span>
                                    </div>
                                    <div class="chart--label">
                                        <span class="indicator chart-bg-3"></span>
                                        <span class="info">
                                            {{translate('messages.Order Refund')}} ({{Helpers::format_currency($order_refund_total)}})
                                        </span>
                                    </div>
                                    <div class="chart--label">
                                        <span class="indicator chart-bg-1"></span>
                                        <span class="info">
                                            {{translate('messages.Loyalty Point')}} ({{Helpers::format_currency($loyalty_point_total)}})
                                        </span>
                                    </div>
                                    <div class="chart--label">
                                        <span class="indicator chart-bg-3"></span>
                                        <span class="info">
                                            {{translate('messages.Order place')}} ({{Helpers::format_currency($order_place_total)}})
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="card mt-3">
            <!-- Header -->
            <div class="card-header flex-wrap gap-3 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title">
                        <span class="card-header-icon">
                            <i class="tio-dollar-outlined"></i>
                        </span>
                        {{translate('transactions')}} &nbsp;
                        <span class="badge badge-soft-secondary"> {{ $transactions->total() }}</span>
                    </h5>

                    <div class="min--260">
                        <form action="{{ route('admin.users.customer.wallet.report') }}" method="get"
                              class="search-form theme-style">
                            <div class="input-group input--group">
                                <input type="search" name="search" class="form-control"
                                       placeholder="{{translate('ex_: search_by_customer_name')}}"
                                       aria-label="{{translate('messages.search')}}" value="{{request()?->search}}">
                                <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                            </div>
                        </form>

                    </div>
                    @if(request()->get('search'))
                        <button type="reset" class="btn btn--primary ml-2 location-reload-to-base"
                                data-url="{{url()->full()}}">{{translate('messages.reset')}}</button>
                    @endif
                </div>
                <!-- Unfold -->
                <div class="hs-unfold">
                    <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40"
                       href="javascript:;"
                       data-hs-unfold-options='{
                                "target": "#usersExportDropdown",
                                "type": "css-animation"
                            }'>
                        <i class="tio-download-to mr-1"></i> {{ translate('messages.export') }}
                    </a>

                    <div id="usersExportDropdown"
                         class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                        <span class="dropdown-header">{{ translate('messages.download_options') }}</span>
                        <a id="export-excel" class="dropdown-item"
                           href="{{route('admin.users.customer.wallet.export', ['type'=>'excel',request()->getQueryString()])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                 src="{{asset('assets/admin') }}/svg/components/excel.svg"
                                 alt="Image Description">
                            {{ translate('messages.excel') }}
                        </a>
                        <a id="export-csv" class="dropdown-item"
                           href="{{route('admin.users.customer.wallet.export', ['type'=>'csv',request()->getQueryString()])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                 src="{{asset('assets/admin') }}/svg/components/placeholder-csv-format.svg"
                                 alt="Image Description">
                            .{{ translate('messages.csv') }}
                        </a>
                    </div>
                </div>
                <!-- End Unfold -->
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatable"
                           class="table table-thead-bordered table-align-middle card-table table-nowrap">
                        <thead class="thead-light">
                        <tr>
                            <th class="border-0">{{translate('sl')}}</th>
                            <th class="border-0">{{translate('messages.transaction_id')}}</th>
                            <th class="border-0">{{translate('messages.customer_info')}}</th>
                            <th class="border-0">{{translate('messages.credit')}}</th>
                            <th class="border-0">{{translate('messages.debit')}}</th>
                            <th class="border-0">{{translate('messages.bonus')}}</th>
                            <th class="border-0">{{translate('messages.balance')}}</th>
                            <th class="border-0">{{translate('messages.transaction_type')}}</th>
                            <th class="border-0">{{translate('messages.reference')}}</th>
                            <!-- <th>{{translate('messages.admin_bonus')}}</th> -->
                            <th class="border-0">{{translate('messages.created_at')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $k=>$wt)
                            <tr scope="row">
                                <td>{{$k+$transactions->firstItem()}}</td>
                                <td>{{$wt->transaction_id}}</td>
                                <td title="{{$wt?->user?->f_name.' '.$wt?->user?->l_name}}"><a class="text-dark"
                                                                                               href="{{route('admin.users.customer.view',['user_id'=>$wt->user_id])}}">{{Str::limit($wt->user?$wt->user->f_name.' '.$wt->user->l_name:translate('messages.not_found'),20,'...')}}</a>
                                </td>
                                <td>{{Helpers::format_currency($wt->credit)}}</td>
                                <td>{{Helpers::format_currency($wt->debit)}}</td>
                                <td>{{Helpers::format_currency($wt->admin_bonus)}}</td>
                                <td>{{Helpers::format_currency($wt->balance)}}</td>
                                <td>
                                    <span class="badge badge-soft-{{$wt->transaction_type=='order_refund'
                                        ?'danger'
                                        :($wt->transaction_type=='loyalty_point'?'warning'
                                            :($wt->transaction_type=='order_place'
                                                ?'info'
                                                :'success'))
                                        }}">
                                        {{ translate('messages.'.$wt->transaction_type)}}
                                    </span>
                                </td>
                                <td class="text-capitalize"> {{  $wt->reference? str_replace('_' , ' ',$wt->reference) : translate('messages.N/A') }}</td>

                                <td>
                                    <span class="d-block">{{Helpers::date_format($wt['created_at'])}}</span>
                                    <span
                                        class="d-block">{{Helpers::time_format($wt['created_at'])}}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Body -->
            @if(count($transactions) !== 0)
                <hr>
            @endif
            <div class="page-area">
                {!! $transactions->withQueryString()->links() !!}
            </div>
            @if(count($transactions) === 0)
                <div class="empty--data">
                    <img src="{{asset('assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                    <h5>
                        {{translate('no_data_found')}}
                    </h5>
                </div>
            @endif
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script')
    <!-- Apex Charts -->
    <script src="{{asset('assets/admin/js/apex-charts/apexcharts.js')}}"></script>
    <!-- Apex Charts -->
@endpush

@push('script')
    <script>
        "use strict";
        let options;
        let chart;
        options = {
            series: [{{$add_fund_total}}, {{$order_refund_total}}, {{$loyalty_point_total}}, {{$order_place_total}}],
            chart: {
                width: 180,
                type: 'donut',
            },
            labels: [
                '{{ translate('Admin Add Fund') }}',
                '{{ translate('Order Refund') }}',
                '{{ translate('Loyalty Point') }}',
                '{{ translate('Order place') }}'
            ],
            dataLabels: {
                enabled: false,
                style: {
                    colors: ['#0F4A4A', '#3F6E6E', '#6F9292', '#9FB7B7']
                }
            },
            // responsive: [{
            //     breakpoint: 1650,
            //     options: {
            //         chart: {
            //             width: 250
            //         },
            //     }
            // }],
            colors: ['rgba(0, 0, 0, 0.90)'],
            fill: {
                colors: ['#0F4A4A', '#3F6E6E', '#6F9292', '#9FB7B7']
            },
            legend: {
                show: false
            },
        };

        chart = new ApexCharts(document.querySelector("#doughnut-pie"), options);
        chart.render();
    </script>
@endpush

@push('script_2')
    <script src="{{asset('assets/admin')}}/vendor/chart.js/dist/Chart.min.js"></script>
    <script
        src="{{asset('assets/admin')}}/vendor/chartjs-chart-matrix/dist/chartjs-chart-matrix.min.js"></script>
    <script src="{{asset('assets/admin')}}/js/hs.chartjs-matrix.js"></script>

    <script>
        $(document).on('ready', function () {
            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '{{route('admin.users.customer.select-list')}}',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            all: true,
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    __port: function (params, success, failure) {
                        var $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });

            // INITIALIZATION OF FLATPICKR
            // =======================================================
            $('.js-flatpickr').each(function () {
                $.HSCore.components.HSFlatpickr.init($(this));
            });


            // INITIALIZATION OF NAV SCROLLER
            // =======================================================
            $('.js-nav-scroller').each(function () {
                new HsNavScroller($(this)).init()
            });


            // INITIALIZATION OF DATERANGEPICKER
            // =======================================================
            $('.js-daterangepicker').daterangepicker();

            $('.js-daterangepicker-times').daterangepicker({
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                locale: {
                    format: 'M/DD hh:mm A'
                }
            });

            var start = moment();
            var end = moment();

            function cb(start, end) {
                $('#js-daterangepicker-predefined .js-daterangepicker-predefined-preview').html(start.format('MMM D') + ' - ' + end.format('MMM D, YYYY'));
            }

            $('#js-daterangepicker-predefined').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);


            // INITIALIZATION OF CHARTJS
            // =======================================================
            $('.js-chart').each(function () {
                $.HSCore.components.HSChartJS.init($(this));
            });

            var updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));

            // Call when tab is clicked
            $('[data-toggle="chart"]').click(function (e) {
                let keyDataset = $(e.currentTarget).attr('data-datasets')

                // Update datasets for chart
                updatingChart.data.datasets.forEach(function (dataset, key) {
                    dataset.data = updatingChartDatasets[keyDataset][key];
                });
                updatingChart.update();
            })


            // INITIALIZATION OF MATRIX CHARTJS WITH CHARTJS MATRIX PLUGIN
            // =======================================================
            function generateHoursData() {
                var data = [];
                var dt = moment().subtract(365, 'days').startOf('day');
                var end = moment().startOf('day');
                while (dt <= end) {
                    data.push({
                        x: dt.format('YYYY-MM-DD'),
                        y: dt.format('e'),
                        d: dt.format('YYYY-MM-DD'),
                        v: Math.random() * 24
                    });
                    dt = dt.add(1, 'day');
                }
                return data;
            }

            $.HSCore.components.HSChartMatrixJS.init($('.js-chart-matrix'), {
                data: {
                    datasets: [{
                        label: 'Commits',
                        data: generateHoursData(),
                        width: function (ctx) {
                            var a = ctx.chart.chartArea;
                            return (a.right - a.left) / 70;
                        },
                        height: function (ctx) {
                            var a = ctx.chart.chartArea;
                            return (a.bottom - a.top) / 10;
                        }
                    }]
                },
                options: {
                    tooltips: {
                        callbacks: {
                            title: function () {
                                return '';
                            },
                            label: function (item, data) {
                                var v = data.datasets[item.datasetIndex].data[item.index];

                                if (v.v.toFixed() > 0) {
                                    return '<span class="font-weight-bold">' + v.v.toFixed() + ' hours</span> on ' + v.d;
                                } else {
                                    return '<span class="font-weight-bold">No time</span> on ' + v.d;
                                }
                            }
                        }
                    },
                    scales: {
                        xAxes: [{
                            position: 'bottom',
                            type: 'time',
                            offset: true,
                            time: {
                                unit: 'week',
                                round: 'week',
                                displayFormats: {
                                    week: 'MMM'
                                }
                            },
                            ticks: {
                                "labelOffset": 20,
                                "maxRotation": 0,
                                "minRotation": 0,
                                "fontSize": 12,
                                "fontColor": "rgba(22, 52, 90, 0.5)",
                                "maxTicksLimit": 12,
                            },
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            type: 'time',
                            offset: true,
                            time: {
                                unit: 'day',
                                parser: 'e',
                                displayFormats: {
                                    day: 'ddd'
                                }
                            },
                            ticks: {
                                "fontSize": 12,
                                "fontColor": "rgba(22, 52, 90, 0.5)",
                                "maxTicksLimit": 2,
                            },
                            gridLines: {
                                display: false
                            }
                        }]
                    }
                }
            });


            // INITIALIZATION OF CLIPBOARD
            // =======================================================
            $('.js-clipboard').each(function () {
                var clipboard = $.HSCore.components.HSClipboard.init(this);
            });


            // INITIALIZATION OF CIRCLES
            // =======================================================
            $('.js-circle').each(function () {
                var circle = $.HSCore.components.HSCircles.init($(this));
            });
        });
    </script>

    <script>
        $('#from_date,#to_date').change(function () {
            let fr = $('#from_date').val();
            let to = $('#to_date').val();
            if (fr != '' && to != '') {
                if (fr > to) {
                    $('#from_date').val('');
                    $('#to_date').val('');
                    toastr.error('Invalid date range!', Error, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            }

        })
    </script>
@endpush
