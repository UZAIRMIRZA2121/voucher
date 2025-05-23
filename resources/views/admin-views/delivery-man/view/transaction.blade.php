@extends('layouts.admin.app')

@section('title',translate('messages.Delivery Man Preview'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title text-break">
                <span class="page-header-icon">
                    <img src="{{asset('assets/admin/img/delivery-man.png')}}" class="w--26" alt="">
                </span>
                <span>{{$deliveryMan['f_name'].' '.$deliveryMan['l_name']}}</span>
            </h1>
            <div class="">
                @include('admin-views.delivery-man.partials._tab_menu')
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5 mt-2">
            <div class="card-header flex-wrap py-2 border-0 gap-2">
                <div class="search--button-wrapper">
                    <h4 class="card-title">{{ translate('messages.order_transactions')}}</h4>
                    <div class="min--260">
                        <input type="date" class="form-control set-filter" placeholder="{{ translate('mm/dd/yyyy') }}" data-url="{{route('admin.users.delivery-man.preview',['id'=>$deliveryMan->id, 'tab'=> 'transaction'])}}" data-filter="date" value="{{$date}}">
                    </div>
                </div>
                <!-- Unfold -->
                <div class="hs-unfold mr-2">
                    <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40" href="javascript:;"
                        data-hs-unfold-options='{
                                "target": "#usersExportDropdown",
                                "type": "css-animation"
                            }'>
                        <i class="tio-download-to mr-1"></i> {{ translate('messages.export') }}
                    </a>

                    <div id="usersExportDropdown"
                        class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                        <span class="dropdown-header">{{ translate('messages.download_options') }}</span>
                        <a id="export-excel" class="dropdown-item" href="{{route('admin.users.delivery-man.earning-export', ['type'=>'excel','id'=>$deliveryMan->id,request()->getQueryString()])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="{{asset('assets/admin') }}/svg/components/excel.svg"
                                alt="Image Description">
                            {{ translate('messages.excel') }}
                        </a>
                        <a id="export-csv" class="dropdown-item" href="{{route('admin.users.delivery-man.earning-export', ['type'=>'csv','id'=>$deliveryMan->id,request()->getQueryString()])}}">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="{{asset('assets/admin') }}/svg/components/placeholder-csv-format.svg"
                                alt="Image Description">
                            .{{ translate('messages.csv') }}
                        </a>
                    </div>
                </div>
                <!-- End Unfold -->
            </div>
            <!-- Body -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatable"
                        class="table table-borderless table-thead-bordered table-nowrap justify-content-between table-align-middle card-table">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0">{{translate('sl')}}</th>
                                <th class="border-0">{{translate('messages.order_id')}}</th>
                                <th class="border-0">{{translate('messages.delivery_fee_earned')}}</th>
                                <th class="border-0">{{translate('messages.delivery_tips')}}</th>
                                <th class="border-0">{{translate('messages.date')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php($digital_transaction = \App\Models\OrderTransaction::where('delivery_man_id', $deliveryMan->id)
                        ->when($date, function($query)use($date){
                            return $query->whereDate('created_at', $date);
                        })->paginate(25))

                        @foreach($digital_transaction as $k=>$dt)

                            <tr>
                                <td scope="row">{{$k+$digital_transaction->firstItem()}}</td>
                                <td><a href="{{route((isset($dt->order) && $dt->order->order_type=='parcel')?'admin.parcel.order.details':'admin.order.details',[$dt->order_id,'module_id'=>$dt->order->module_id])}}">{{$dt->order_id}}</a></td>
                               <td>{{ \App\CentralLogics\Helpers::format_currency($dt->original_delivery_charge) }}</td>
                               <td>{{ \App\CentralLogics\Helpers::format_currency($dt->dm_tips) }}</td>
                                <td> {{\App\CentralLogics\Helpers::date_format($dt->created_at )   }}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Body -->
            <div class="card-footer">
                {!!$digital_transaction->links()!!}
            </div>
        </div>
        <!-- End Card -->
    </div>
@endsection

@push('script_2')

@endpush
