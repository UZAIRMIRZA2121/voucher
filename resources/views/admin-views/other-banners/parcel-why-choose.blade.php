@extends('layouts.admin.app')

@section('title',translate('messages.banner'))

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="{{asset('assets/admin/img/3rd-party.png')}}" class="w--26" alt="">
            </span>
            <span>
                {{translate('messages.Other_Promotional_Content_Setup')}}
            </span>
        </h1>
    </div>
    <div class="mb-4 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            @include('admin-views.other-banners.partial.parcel-links')
        </div>
    </div>
    @php($language=\App\Models\BusinessSetting::where('key','language')->first())
    @php($language = $language->value ?? null)
    @php($defaultLang = str_replace('_', '-', app()->getLocale()))
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <div class="card mb-3">
                <div class="card-body">
                    @if($language)
                        <ul class="nav nav-tabs mb-4 border-0">
                            <li class="nav-item">
                                <a class="nav-link lang_link active"
                                href="#"
                                id="default-link">{{translate('messages.default')}}</a>
                            </li>
                            @foreach (json_decode($language) as $lang)
                                <li class="nav-item">
                                    <a class="nav-link lang_link"
                                        href="#"
                                        id="{{ $lang }}-link">{{ \App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')' }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                        <form action="{{ route('admin.promotional-banner.why-choose-store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                @if ($language)
                                <div class="col-6">
                                    <div class="row lang_form default-form">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">{{translate('Title')}} ({{ translate('messages.default') }})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                                            <img src="{{asset('assets/admin/img/info-circle.svg')}}" alt="">
                                                        </span></label>
                                                <input type="text"  maxlength="80" name="title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">{{translate('messages.Short_Description')}} ({{ translate('messages.default') }})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_short_description_within_100_characters') }}">
                                                            <img src="{{asset('assets/admin/img/info-circle.svg')}}" alt="">
                                                        </span></label>
                                                <textarea type="text"  maxlength="100" name="short_description[]" class="form-control" rows="3" {{translate('messages.short_description_here...')}}> </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                    @foreach(json_decode($language) as $lang)
                                    <div class="row d-none lang_form" id="{{$lang}}-form1">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">{{translate('Title')}} ({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                                    <img src="{{asset('assets/admin/img/info-circle.svg')}}" alt="">
                                                </span></label>
                                                <input type="text"  maxlength="80" name="title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">{{translate('messages.Short_Description')}} ({{strtoupper($lang)}})<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_short_description_within_100_characters') }}">
                                                    <img src="{{asset('assets/admin/img/info-circle.svg')}}" alt="">
                                                </span></label>
                                                <textarea type="text"  maxlength="100" name="short_description[]" class="form-control" rows="3" {{translate('messages.short_description_here...')}}> </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                    @endforeach

                                </div>

                                @else
                                <div class="col-sm-6">
                                    <label class="form-label">{{translate('Title')}}<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="{{ translate('Write_the_title_within_80_characters') }}">
                                                <img src="{{asset('assets/admin/img/info-circle.svg')}}" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="80" name="title[]" class="form-control" placeholder="{{translate('messages.title_here...')}}">
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                @endif
                                <div class="col-sm-6">
                                    <div class="ml-5">
                                        <div>

                                            <label class="form-label">{{translate('image (1:1)')}}</label>
                                        </div>
                                        <label class="upload-img-3 m-0">
                                            <div class="img">
                                                <img src="{{asset('assets/admin/img/aspect-1.png')}}" alt="" class="img__aspect-1 min-w-187px max-w-187px">
                                            </div>
                                              <input type="file"  name="image" hidden>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-3">
                                <button type="reset" class="btn btn--reset">{{translate('Reset')}}</button>
                                <button type="submit" class="btn btn--primary mb-2">{{translate('Submit')}}</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body p-0">
                        <!-- Table -->
                        <div class="table-responsive datatable-custom">
                            <table id="columnSearchDatatable"
                                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                    data-hs-datatables-options='{
                                        "order": [],
                                        "orderCellsTop": true,
                                        "paging":false

                                    }'>
                                <thead class="thead-light">
                                <tr>
                                    <th class="border-0">{{translate('sl')}}</th>
                                    <th class="border-0">{{translate('Title')}}</th>
                                    <th class="border-0">{{translate('messages.Short_Description')}}</th>
                                    <th class="border-0">{{translate('Image')}}</th>
                                    <th class="border-0">{{translate('Status')}}</th>
                                    <th class="text-center border-0">{{translate('messages.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($banners as $key=>$banner)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            <div class="text--title" title="{{$banner->title}}">
                                                {{ strlen($banner->title) > 30 ? substr($banner->title, 0, 30).'...' : $banner->title }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text--title" title="{{$banner->short_description}}">
                                                {{ strlen($banner->short_description) > 40 ? substr($banner->short_description, 0, 40).'...' : $banner->short_description }}
                                            </div>
                                        </td>
                                        <td>
                                            <img  src="{{ $banner->image_full_url ?? asset('/public/assets/admin/img/upload-3.png')}}"
                                            data-onerror-image="{{asset('assets/admin/img/upload-3.png')}}" class="__size-105 onerror-image" alt="">
                                        </td>
                                        <td>
                                            <label class="toggle-switch toggle-switch-sm">
                                                <input type="checkbox" class="toggle-switch-input dynamic-checkbox"
                                                       data-id="status-{{$banner->id}}"
                                                       data-type="status"
                                                       data-image-on="{{asset('assets/admin/img/modal')}}/this-criteria-on.png"
                                                       data-image-off="{{asset('assets/admin/img/modal')}}/this-criteria-off.png"
                                                       data-title-on="{{translate('messages.Want_to_enable')}} <strong>{{translate('this_feature?')}}"
                                                       data-title-off="{{translate('messages.Want_to_disable')}} <strong>{{translate('this_feature?')}}"
                                                       data-text-on="<p>{{translate('If_yes,_it_will_be_available_on_this_module.')}}</p>"
                                                       data-text-off="<p>{{translate('If_yes,_it_will_be_hidden_from_this_module.')}}</p>"
                                                       id="status-{{$banner->id}}" {{$banner->status?'checked':''}}>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <form action="{{route('admin.promotional-banner.why-choose-status-update',[$banner->id,$banner->status?0:1])}}" method="get" id="status-{{$banner->id}}_form">
                                            </form>
                                        </td>

                                        <td>
                                            <div class="btn--container justify-content-center">
                                                <a class="btn action-btn btn--primary btn-outline-primary" href="{{route('admin.promotional-banner.why-choose-edit',[$banner['id']])}}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a class="btn action-btn btn--danger btn-outline-danger form-alert-title" href="javascript:"
                                                data-id="criteria-{{$banner['id']}}" data-title="{{ translate('Want_to_delete_this_feature_?') }}" data-message="{{translate('If_yes,_It_will_be_removed_from_this_list_and_this_module.')}}" title="{{translate('messages.delete_criteria')}}"><i class="tio-delete-outlined"></i>
                                                </a>
                                                <form action="{{route('admin.promotional-banner.why-choose-delete',[$banner['id']])}}" method="post" id="criteria-{{$banner['id']}}">
                                                    @csrf @method('delete')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <!-- End Table -->
                    </div>
                    @if(count($banners) === 0)
                    <div class="empty--data">
                        <img src="{{asset('assets/admin/svg/illustrations/sorry.svg')}}" alt="public">
                        <h5>
                            {{translate('no_data_found')}}
                        </h5>
                    </div>
                    @endif
                </div>
        </div>
    </div>
</div>
@endsection
@push('script_2')
    <script src="{{asset('assets/admin')}}/js/view-pages/other-banners.js"></script>
@endpush
