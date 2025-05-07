@extends('layouts.admin.app')

@section('title', translate('messages.add_new_brand'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{ asset('assets/admin/img/category.png') }}" class="w--20" alt="">
                </span>
                <span>
                    {{ translate('Group Customer Setup	') }}
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.group-customers.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                       
                        <div class="col-6">
                            @if (isset($language))
                                <div class="form-group lang_form" id="default-form">
                                    <label class="input-label"
                                        for="exampleFormControlInput1">{{ translate('messages.name') }}
                                        ({{ translate('messages.default') }})</label>
                                    <input type="text" name="name[]" value="{{ old('name.0') }}" class="form-control"
                                        placeholder="{{ translate('messages.new_brand') }}" maxlength="191">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                @foreach ($language as $key => $lang)
                                    <div class="form-group d-none lang_form" id="{{ $lang }}-form">
                                        <label class="input-label"
                                            for="exampleFormControlInput1">{{ translate('messages.name') }}
                                            ({{ strtoupper($lang) }})</label>
                                        <input type="text" name="name[]" value="{{ old('name.' . $key + 1) }}"
                                            class="form-control" placeholder="{{ translate('messages.new_brand') }}"
                                            maxlength="191">
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{ $lang }}">
                                @endforeach
                            @else
                                <div class="form-group">
                                    <label class="input-label"
                                        for="exampleFormControlInput1">{{ translate('Group Customr Name') }}</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="{{ translate('Group Customr Name') }}" value="{{ old('name') }}"
                                        maxlength="191">
                                </div>
                            @endif
                        </div>
                        <div class="col-6">
                            <label for="business_owner_id" class="form-label">Business Owner</label>
                            <select class="form-control" id="business_owner_id" name="business_owner_id" required>
                                <option value="">Select Business Owner</option>
                                @foreach ($businessOwners as $owner)
                                    <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="btn--container justify-content-end mt-3">
                        <button type="reset" id="reset_btn"
                            class="btn btn--reset">{{ translate('messages.reset') }}</button>
                        <button type="submit"
                            class="btn btn--primary">{{ isset($brand) ? translate('messages.update') : translate('messages.add') }}</button>
                    </div>

                </form>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    {{-- <h5 class="card-title">{{translate('messages.Brands')}}<span class="badge badge-soft-dark ml-2" id="itemCount">{{$businessOwners->total()}}</span></h5> --}}
                    {{-- <form  class="search-form">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch" name="search" value="{{ request()?->search ?? null }}"  type="search" class="form-control" placeholder="{{translate('messages.search_by_name')}}" aria-label="{{translate('messages.Brands')}}">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form> --}}
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "search": "#datatableSearch",
                            "entries": "#datatableEntries",
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false,
                        }'>
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0">{{ translate('sl') }}</th>
                                <th class="border-0 w--1">{{ translate('Group Customer Name') }}</th>
                                <th class="border-0 w--1">{{ translate('Bussiness Owner Name') }}</th>
                                <th class="border-0 text-center">{{ translate('messages.action') }}</th>
                            </tr>
                        </thead>
                        @php 
                            $i = 1;
                        @endphp
                        <tbody id="table-div">
                            @foreach ($groupCustomers as $key => $customer)
                                <tr>
                                    <td> {{ $i++ }}</td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            {{ Str::limit($customer['name'], 20, '...') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                           {{ $customer->businessOwner->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary"
                                                href="{{ route('admin.group-customers.edit', [$customer['id']]) }}"
                                               ><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                                href="javascript:" data-id="brand-{{ $customer['id'] }}"
                                                data-message="{{ translate('messages.Want to delete this brand') }}"
                                                title="{{ translate('messages.delete_brand') }}"><i
                                                    class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="{{ route('admin.group-customers.destroy', $customer->id) }}" method="POST" id="brand-{{ $customer->id }}">
                                                @csrf
                                                @method('DELETE')
                                           
                                            </form>
                                            
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
             @if (count($groupCustomers) !== 0)
            <hr>
            @endif
          <div class="page-area">
                {{-- {!! $businessOwners->links() !!} --}}
            </div>
            @if (count($groupCustomers) === 0)
            {{-- <div class="empty--data">
                <img src="{{asset('assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                <h5>
                    {{translate('no_data_found')}}
                </h5>
            </div> --}}
            @endif 
        </div>
    </div>
@endsection

@push('script_2')
    <script src="{{ asset('assets/admin') }}/js/view-pages/brand-index.js"></script>
    <script>
        "use strict";
        $('#reset_btn').click(function() {
            $('#viewer').attr('src', "{{ asset('assets/admin/img/upload-img.png') }}");
        })
    </script>
@endpush
