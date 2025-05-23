@extends('layouts.admin.app')

@section('title', translate('messages.order_report'))

@push('css_or_js')
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('assets/admin/img/report/report.png')}}" class="w--22" alt="">
                </span>
                <span>
                    {{ translate('messages.order_report') }}
                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <div class="card mb-20">
            <div class="card-body">
                <h4 class="">{{ translate('Search Data') }}</h4>
                <form action="{{ route('admin.transactions.report.set-date') }}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <select name="module_id" class="form-control js-select2-custom set-filter" data-url="{{ url()->full() }}" data-filter="module_id"
                                title="{{ translate('messages.select_modules') }}">
                                <option value="" {{ !request('module_id') ? 'selected' : '' }}>
                                    {{ translate('messages.all_modules') }}</option>
                                @foreach (\App\Models\Module::notParcel()->get() as $module)
                                    <option value="{{ $module->id }}"
                                        {{ request('module_id') == $module->id ? 'selected' : '' }}>
                                        {{ $module['module_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select name="zone_id" class="form-control js-select2-custom set-filter" data-url="{{ url()->full() }}" data-filter="zone_id" id="zone">
                                <option value="all">{{ translate('messages.All_Zones') }}</option>
                                @foreach (\App\Models\Zone::orderBy('name')->get() as $z)
                                    <option value="{{ $z['id'] }}"
                                        {{ isset($zone) && $zone->id == $z['id'] ? 'selected' : '' }}>
                                        {{ $z['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select name="store_id"
                                data-placeholder="{{ translate('messages.select_store') }}"
                                class="js-data-example-ajax form-control set-filter" data-url="{{ url()->full() }}" data-filter="store_id">
                                @if (isset($store))
                                    <option value="{{ $store->id }}" selected>{{ $store->name }}</option>
                                @else
                                    <option value="all" selected>{{ translate('messages.all_stores') }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select name="customer_id"
                                data-placeholder="{{ translate('messages.select_customer') }}"
                                class="js-data-example-ajax-2 form-control set-filter" data-url="{{ url()->full() }}" data-filter="customer_id">
                                @if (isset($customer))
                                    <option value="{{ $customer->id }}" selected>{{ $customer->f_name . ' ' .$customer->l_name }}</option>
                                @else
                                    <option value="all" selected>{{ translate('messages.all_customers') }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select class="form-control set-filter" data-url="{{ url()->full() }}" data-filter="filter" name="filter">
                                <option value="all_time" {{ isset($filter) && $filter == 'all_time' ? 'selected' : '' }}>
                                    {{ translate('messages.All Time') }}</option>
                                <option value="this_year" {{ isset($filter) && $filter == 'this_year' ? 'selected' : '' }}>
                                    {{ translate('messages.This Year') }}</option>
                                <option value="previous_year"
                                    {{ isset($filter) && $filter == 'previous_year' ? 'selected' : '' }}>
                                    {{ translate('messages.Previous Year') }}</option>
                                <option value="this_month"
                                    {{ isset($filter) && $filter == 'this_month' ? 'selected' : '' }}>
                                    {{ translate('messages.This Month') }}</option>
                                <option value="this_week" {{ isset($filter) && $filter == 'this_week' ? 'selected' : '' }}>
                                    {{ translate('messages.This Week') }}</option>
                                <option value="custom" {{ isset($filter) && $filter == 'custom' ? 'selected' : '' }}>
                                    {{ translate('messages.Custom') }}</option>
                            </select>
                        </div>
                        @if (isset($filter) && $filter == 'custom')
                            <div class="col-sm-6 col-md-3">

                                <input type="date" name="from" id="from_date" class="form-control"
                                    placeholder="{{ translate('Start Date') }}"
                                    {{ session()->has('from_date') ? 'value=' . session('from_date') : '' }} required>

                            </div>
                            <div class="col-sm-6 col-md-3">

                                <input type="date" name="to" id="to_date" class="form-control"
                                    placeholder="{{ translate('End Date') }}"
                                    {{ session()->has('to_date') ? 'value=' . session('to_date') : '' }} required>

                            </div>
                        @endif
                        <div class="col-sm-6 col-md-3 ml-auto">
                            <button type="submit"
                                class="btn btn-primary btn-block h--45px">{{ translate('Filter') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @php
            $from = session('from_date') . ' 00:00:00';
            $to = session('to_date') . ' 23:59:59';
        @endphp
        <div class="mb-20">
            <div class="row g-4">
                <div class="col-lg-3">
                    <a class="__card-1 h-100" href="#">
                        <img src="{{asset('assets/admin/img/report/new/total.png')}}" class="icon" alt="report/new">
                        <h3 class="title">{{$orders->total()}}</h3>
                        <h6 class="subtitle">{{translate('messages.total_orders')}}</h6>
                    </a>
                </div>
                <div class="col-lg-9">
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-4">
                            <a class="__card-2 __bg-1" href="#">
                            <h4 class="title">{{$total_progress_count}}</h4>
                            <span class="subtitle">{{translate('messages.in_progress_orders')}} <span data-toggle="tooltip" data-placement="right" data-original-title="{{translate('Including accepted and processing orders')}}"><img src="{{asset('assets/admin/img/info-circle.svg')}}" alt="{{translate('messages.in_progress_orders')}}"></span></span>
                            <img src="{{asset('assets/admin/img/report/new/progress-report.png')}}" alt="report/new" class="card-icon">
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <a class="__card-2 __bg-2" href="#">
                            <h4 class="title">{{$total_on_the_way_count}}</h4>
                            <span class="subtitle">{{translate('messages.on_the_way')}}</span>
                            <img src="{{asset('assets/admin/img/report/new/on-the-way.png')}}" alt="report/new" class="card-icon">
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <a class="__card-2 __bg-3" href="#">
                            <h4 class="title">{{$total_delivered_count}}</h4>
                            <span class="subtitle">{{ translate('messages.delivered_orders') }}</span>
                            <img src="{{asset('assets/admin/img/report/new/delivered.png')}}" alt="report/new" class="card-icon">
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <a class="__card-2 __bg-4" href="#">
                            <h4 class="title">{{$total_failed_count}}</h4>
                            <span class="subtitle">{{translate('messages.failed_orders')}}</span>
                            <img src="{{asset('assets/admin/img/report/new/failed.png')}}" alt="report/new" class="card-icon">
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <a class="__card-2 __bg-5" href="#">
                            <h4 class="title">{{$total_refunded_count}}</h4>
                            <span class="subtitle">{{translate('messages.refunded_orders')}}</span>
                            <img src="{{asset('assets/admin/img/report/new/refunded.png')}}" alt="report/new" class="card-icon">
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <a class="__card-2 __bg-6" href="#">
                            <h4 class="title">{{$total_canceled_count}}</h4>
                            <span class="subtitle">{{translate('messages.canceled_orders')}}</span>
                            <img src="{{asset('assets/admin/img/report/new/canceled.png')}}" alt="report/new" class="card-icon">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Stats -->
        <!-- Card -->
        <div class="card mt-3">
            <!-- Header -->
            <div class="card-header border-0 py-2">
                <div class="search--button-wrapper">
                    <h3 class="card-title">
                        {{ translate('messages.Total Orders') }} <span
                            class="badge badge-soft-secondary" id="countItems">{{ $orders->total() }}</span>
                    </h3>
                    <form class="search-form">
                        <!-- Search -->
                        <div class="input--group input-group input-group-merge input-group-flush">
                            <input name="search" type="search" class="form-control" value="{{request()->query('search')}}" placeholder="{{ translate('Search by Order ID') }}">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <!-- Static Export Button -->
                    <div class="hs-unfold ml-3">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle btn export-btn font--sm"
                            href="javascript:;"
                            data-hs-unfold-options="{
                                &quot;target&quot;: &quot;#usersExportDropdown&quot;,
                                &quot;type&quot;: &quot;css-animation&quot;
                            }"
                            data-hs-unfold-target="#usersExportDropdown" data-hs-unfold-invoker="">
                            <i class="tio-download-to mr-1"></i> {{ translate('export') }}
                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right hs-unfold-content-initialized hs-unfold-css-animation animated hs-unfold-reverse-y hs-unfold-hidden">

                            <span class="dropdown-header">{{ translate('download_options') }}</span>
                            <a id="export-excel" class="dropdown-item"
                                href="{{ route('admin.transactions.report.order-report-export', ['type' => 'excel', request()->getQueryString()]) }}">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('assets/admin/svg/components/excel.svg') }}"
                                    alt="Image Description">
                                {{ translate('messages.excel') }}
                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="{{ route('admin.transactions.report.order-report-export', ['type' => 'csv', request()->getQueryString()]) }}">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{asset('assets/admin/svg/components/placeholder-csv-format.svg') }}"
                                    alt="Image Description">
                                .{{ translate('messages.csv') }}
                            </a>

                        </div>
                    </div>
                    <!-- Static Export Button -->
                </div>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless middle-align __txt-14px">
                        <thead class="thead-light white--space-false">
                            <tr>
                                <th class="border-top border-bottom">{{ translate('messages.sl') }}</th>
                                <th class="border-top border-bottom">{{ translate('messages.order_id') }}</th>
                                <th class="border-top border-bottom">{{ translate('messages.store') }}</th>
                                <th class="border-top border-bottom">{{ translate('messages.customer_name') }}</th>
                                <th class="border-top border-bottom">{{ translate('messages.total_item_amount') }}</th>
                                <th class="border-top border-bottom">{{ translate('messages.item_discount') }}</th>
                                <th class="border-top border-bottom">{{ translate('messages.coupon_discount') }}</th>
                                <th class="border-top border-bottom">{{ translate('messages.referral_discount') }}</th>
                                <th class="border-top border-bottom">{{ translate('messages.discounted_amount') }}</th>
                                <th class="border-top border-bottom text-center">{{ translate('messages.tax') }}</th>
                                <th class="border-top border-bottom text-center">{{ translate('messages.delivery_charge') }}</th>
                                <th class="border-top border-bottom text-center">{{ \App\CentralLogics\Helpers::get_business_data('additional_charge_name')??translate('messages.additional_charge') }}</th>
                                <th class="border-top border-bottom text-center">{{ translate('messages.extra_packaging_amount') }}</th>
                                <th class="border-top border-bottom">{{ translate('messages.order_amount') }}</th>
                                <th class="border-top border-bottom">{{ translate('messages.amount_received_by') }}</th>
                                <th class="border-top border-bottom">{{ translate('messages.payment_method') }}</th>
                                <th class="border-top border-bottom">{{ translate('messages.order_status') }}</th>
                                <th class="border-top border-bottom text-center">{{ translate('messages.action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody id="set-rows">
                            @foreach ($orders as $key => $order)
                                <tr class="status-{{ $order['order_status'] }} class-all">
                                    <td class="">
                                        {{ $key + $orders->firstItem() }}
                                    </td>
                                    <td class="table-column-pl-0">
                                        <a
                                            href="{{ route('admin.order.details', ['id' => $order['id'],'module_id'=>$order['module_id']]) }}">{{ $order['id'] }}</a>
                                    </td>
                                    <td  class="text-capitalize">
                                        @if($order->store)
                                            {{Str::limit($order->store->name,25,'...')}}
                                        @else
                                            <label class="badge badge-danger">{{ translate('messages.invalid') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->is_guest)
                                        @php($customer_details = json_decode($order['delivery_address'],true))
                                        <strong>{{$customer_details['contact_person_name']}}</strong>
                                        <div>{{$customer_details['contact_person_number']}}</div>

                                        @elseif ($order->customer)
                                        <a class="text-body text-capitalize"
                                            href="{{ route('admin.users.customer.view', [$order['user_id']]) }}">
                                            <strong>{{ $order->customer['f_name'] . ' ' . $order->customer['l_name'] }}</strong>
                                        </a>
                                        @else
                                            <label class="badge badge-danger">{{ translate('messages.invalid_customer_data') }}</label>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-right mw--85px">
                                            <div>
                                                {{ \App\CentralLogics\Helpers::number_format_short($order['order_amount'] - $order->additional_charge - $order['dm_tips']-$order['total_tax_amount']-$order['delivery_charge']+$order['coupon_discount_amount'] + $order['store_discount_amount'] + $order['ref_bonus_amount'] - $order['extra_packaging_amount'] +$order['flash_admin_discount_amount'] +$order['flash_store_discount_amount'] ) }}
                                            </div>
                                            @if ($order->payment_status == 'paid')
                                                <strong class="text-success">
                                                    {{ translate('messages.paid') }}
                                                </strong>
                                            @else
                                                <strong class="text-danger">
                                                    {{ translate('messages.unpaid') }}
                                                </strong>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center mw--85px">
                                        {{ \App\CentralLogics\Helpers::number_format_short($order->details()->sum(DB::raw('discount_on_item * quantity')) + $order['flash_admin_discount_amount'] +$order['flash_store_discount_amount'] ) }}
                                    </td>
                                    <td class="text-center mw--85px">
                                        {{ \App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount']) }}
                                    </td>
                                    <td class="text-center mw--85px">
                                        {{ \App\CentralLogics\Helpers::number_format_short($order['ref_bonus_amount']) }}
                                    </td>
                                    <td class="text-center mw--85px">
                                        {{ \App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount'] + $order['store_discount_amount'] + $order['ref_bonus_amount'])  }}
                                    </td>
                                    <td class="text-center mw--85px white-space-nowrap">
                                        {{ \App\CentralLogics\Helpers::number_format_short($order['total_tax_amount']) }}
                                    </td>
                                    <td class="text-center mw--85px">
                                        {{ \App\CentralLogics\Helpers::number_format_short($order['delivery_charge']) }}
                                    </td>
                                    <td class="text-center mw--85px">
                                        {{ \App\CentralLogics\Helpers::number_format_short($order['additional_charge']) }}
                                    </td>
                                    <td class="text-center mw--85px">
                                        {{ \App\CentralLogics\Helpers::number_format_short($order['extra_packaging_amount']) }}
                                    </td>
                                    <td>
                                        <div class="text-right mw--85px">
                                            <div>
                                                {{ \App\CentralLogics\Helpers::number_format_short($order['order_amount']) }}
                                            </div>
                                            @if ($order->payment_status == 'paid')
                                                <strong class="text-success">
                                                    {{ translate('messages.paid') }}
                                                </strong>
                                            @else
                                                <strong class="text-danger">
                                                    {{ translate('messages.unpaid') }}
                                                </strong>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center mw--85px text-capitalize">
                                        {{isset($order->transaction) ? $order->transaction->received_by : translate('messages.not_received_yet')}}
                                    </td>
                                    <td class="text-center mw--85px text-capitalize">
                                            {{ translate(str_replace('_', ' ', $order['payment_method'])) }}
                                    </td>
                                    <td class="text-center mw--85px text-capitalize">
                                        @if($order['order_status']=='pending')
                                                <span class="badge badge-soft-info">
                                                  {{translate('messages.pending')}}
                                                </span>
                                            @elseif($order['order_status']=='confirmed')
                                                <span class="badge badge-soft-info">
                                                  {{translate('messages.confirmed')}}
                                                </span>
                                            @elseif($order['order_status']=='processing')
                                                <span class="badge badge-soft-warning">
                                                  {{translate('messages.processing')}}
                                                </span>
                                            @elseif($order['order_status']=='picked_up')
                                                <span class="badge badge-soft-warning">
                                                  {{translate('messages.out_for_delivery')}}
                                                </span>
                                            @elseif($order['order_status']=='delivered')
                                                <span class="badge badge-soft-success">
                                                  {{translate('messages.delivered')}}
                                                </span>
                                            @elseif($order['order_status']=='failed')
                                                <span class="badge badge-soft-danger">
                                                  {{translate('messages.payment_failed')}}
                                                </span>
                                            @elseif($order['order_status']=='handover')
                                                <span class="badge badge-soft-danger">
                                                  {{translate('messages.handover')}}
                                                </span>
                                            @elseif($order['order_status']=='canceled')
                                                <span class="badge badge-soft-danger">
                                                  {{translate('messages.canceled')}}
                                                </span>
                                            @elseif($order['order_status']=='accepted')
                                                <span class="badge badge-soft-danger">
                                                  {{translate('messages.accepted')}}
                                                </span>
                                            @elseif($order['order_status']=='refund_request_canceled')
                                                <span class="badge badge-soft-danger">
                                                  {{translate('messages.refund_request_canceled')}}
                                                </span>
                                            @else
                                                <span class="badge badge-soft-danger">
                                                  {{str_replace('_',' ',$order['order_status'])}}
                                                </span>
                                            @endif

                                    </td>


                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn"
                                                href="{{ route('admin.order.details', ['id' => $order['id'],'module_id'=>$order['module_id']]) }}">
                                                <i class="tio-invisible"></i>
                                            </a>
                                            <a class="ml-2 btn btn-sm btn--primary btn-outline-primary action-btn"
                                                href="{{ route('admin.transactions.order.generate-invoice', ['id' => $order['id']]) }}">
                                                <i class="tio-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->


            </div>
            <!-- End Body -->
            @if (count($orders) !== 0)
                <hr>
            @endif
            <div class="page-area">
                {!! $orders->links() !!}
            </div>
            @if (count($orders) === 0)
                <div class="empty--data">
                    <img src="{{asset('assets/admin/svg/illustrations/sorry.svg') }}" alt="public">
                    <h5>
                        {{ translate('no_data_found') }}
                    </h5>
                </div>
            @endif
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script')
@endpush

@push('script_2')
    <script src="{{asset('assets/admin') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{asset('assets/admin') }}/vendor/chartjs-chart-matrix/dist/chartjs-chart-matrix.min.js">
    </script>
    <script src="{{asset('assets/admin') }}/js/hs.chartjs-matrix.js"></script>
    <script src="{{asset('assets/admin') }}/js/view-pages/admin-reports.js"></script>

    <script>
        "use strict";
        $(document).on('ready', function() {
            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '{{ url('/') }}/admin/store/get-stores',
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            // all:true,
                            @if (isset($zone))
                                zone_ids: [{{ $zone->id }}],
                            @endif
                            @if (request('module_id'))
                                module_id: {{ request('module_id') }},
                            @endif
                            page: params.page
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    __port: function(params, success, failure) {
                        let $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });

            $('.js-data-example-ajax-2').select2({
                ajax: {
                    url: '{{ url('/') }}/admin/customer/select-list',
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            // all:true,
                            @if (isset($zone))
                                zone_ids: [{{ $zone->id }}],
                            @endif
                            @if (request('module_id'))
                                module_id: {{ request('module_id') }},
                            @endif
                            @if (request('store_id'))
                                store_id: {{ request('store_id') }},
                            @endif
                            page: params.page
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    __port: function(params, success, failure) {
                        let $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });
        });

            $('#search-form').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.report.search_order_report')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#countItems').html(data.count);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush

