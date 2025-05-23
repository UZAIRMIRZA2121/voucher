@extends('layouts.admin.app')

@section('title',translate('messages.banner'))

@push('css_or_js')

@endpush

@section('content')
@php($bottom_section_banner=\App\Models\ModuleWiseBanner::where('module_id',Config::get('module.current_module_id'))->where('key','bottom_section_banner')->first())
@php($best_reviewed_section_banner=\App\Models\ModuleWiseBanner::where('module_id',Config::get('module.current_module_id'))->where('key','best_reviewed_section_banner')->first())
@php($new_arrival_section_banner=\App\Models\ModuleWiseBanner::where('module_id',Config::get('module.current_module_id'))->where('key','new_arrival_section_banner')->first())
    <div class="content container-fluid">
        <!-- Page Header -->
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
        <!-- End Page Header -->
        <div class="row g-3">
            <div class="col-lg-6 mb-3 mb-lg-2">
                <div class="card h-100">
                    <form action="{{ route('admin.promotional-banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="key" value="best_reviewed_section_banner"  hidden>
                    <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 d-flex justify-content-between">
                                    <span class="d-flex g-1">
                                        <img src="{{asset('assets/admin/img/other-banner.png')}}" class="h-85" alt="">
                                        <h3 class="form-label d-block mb-2">
                                            {{translate('Best_Reviewed_Items')}}
                                        </h3>
                                    </span>
                                    <div>
                                        <div class="blinkings">
                                            <div>
                                                <i class="tio-info-outined"></i>
                                            </div>
                                            <div class="business-notes">
                                                <h6><img src="{{asset('assets/admin/img/notes.png')}}" alt=""> {{translate('Note')}}</h6>
                                                <div>
                                                    {{translate('messages.this_banner_is_only_for_react_web.')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h3 class="form-label d-block mb-5 text-center">
                                        {{translate('Upload_Banner')}}
                                    </h3>
                                    <label class="__upload-img aspect-235-375 m-auto d-block position-relative">
                                        <div class="img">
                                            <img class="onerror-image"
                                            src="{{\App\CentralLogics\Helpers::get_full_url('promotional_banner', $best_reviewed_section_banner?->value?? '', $best_reviewed_section_banner?->storage[0]?->value ?? 'public','upload_placeholder')}}"

                                            data-onerror-image="{{asset('assets/admin/img/upload-placeholder.png')}}" alt="">
                                        </div>
                                        <div>
                                        <input type="file" name="image"  hidden>
                                    </div>
                                    @if (isset($best_reviewed_section_banner?->value))
                                    <span id="best_reviewed_section_banner" class="remove_image_button dynamic-checkbox"
                                          data-id="best_reviewed_section_banner"
                                          data-type="status"
                                          data-image-on='{{asset('assets/admin/img/modal')}}/mail-success'
                                          data-image-off="{{asset('assets/admin/img/modal')}}/mail-warning"
                                          data-title-on="{{translate('Important!')}}"
                                          data-title-off="{{translate('Warning!')}}"
                                          data-text-on="<p>{{translate('Are_you_sure_you_want_to_remove_this_image')}}</p>"
                                          data-text-off="<p>{{translate('Are_you_sure_you_want_to_remove_this_image.')}}</p>"
                                    >
                                    <i class="tio-clear"></i></span>
                                    @endif
                                    </label>

                                    <div class="text-center mt-5">
                                        <h3 class="form-label d-block mt-2">
                                        {{translate('Min_Size_for_Better_Resolution_235_x_375_px')}}
                                    </h3>
                                    <p>{{translate('image_format_:_jpg_,_png_,_jpeg_|_maximum_size:_2_MB')}}</p>

                                    </div>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary mb-2">{{translate('Submit')}}</button>
                            </div>
                        </div>
                    </form>
                    </div>

            </div>
            <div class="col-lg-6 mb-3 mb-lg-2">
                <div class="card h-100">
                    <form action="{{ route('admin.promotional-banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="key" value="new_arrival_section_banner"  hidden>
                    <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 d-flex justify-content-between">
                                    <span class="d-flex g-1">
                                        <img src="{{asset('assets/admin/img/other-banner.png')}}" class="h-85" alt="">
                                        <h3 class="form-label d-block mb-2">
                                            {{translate('New Arrivals')}}
                                        </h3>
                                    </span>
                                </div>
                                <div class="col-12">
                                    <h3 class="form-label d-block mb-5 text-center">
                                        {{translate('Upload_Banner')}}
                                    </h3>
                                    <label class="__upload-img aspect-235-375 m-auto d-block position-relative">
                                        <div class="img">
                                            <img class="onerror-image"

                                            src="{{\App\CentralLogics\Helpers::get_full_url('promotional_banner', $new_arrival_section_banner?->value?? '', $new_arrival_section_banner?->storage[0]?->value ?? 'public','upload_placeholder')}}" data-onerror-image="{{asset('assets/admin/img/upload-placeholder.png')}}" alt="">
                                        </div>
                                        <div class="">
                                        <input type="file" name="image"  hidden>
                                    </div>
                                    @if (isset($new_arrival_section_banner?->value))
                                    <span id="new_arrival_section_banner" class="remove_image_button dynamic-checkbox"
                                          data-id="new_arrival_section_banner"
                                          data-type="status"
                                          data-image-on='{{asset('assets/admin/img/modal')}}/mail-success'
                                          data-image-off="{{asset('assets/admin/img/modal')}}/mail-warning"
                                          data-title-on="{{translate('Important!')}}"
                                          data-title-off="{{translate('Warning!')}}"
                                          data-text-on="<p>{{translate('Are_you_sure_you_want_to_remove_this_image')}}</p>"
                                          data-text-off="<p>{{translate('Are_you_sure_you_want_to_remove_this_image.')}}</p>"
                                    >
                                    <i class="tio-clear"></i></span>
                                    @endif
                                    </label>

                                    <div class="text-center mt-5">
                                        <h3 class="form-label d-block mt-2">
                                        {{translate('Min_Size_for_Better_Resolution_235_x_375_px')}}
                                    </h3>
                                    <p>{{translate('image_format_:_jpg_,_png_,_jpeg_|_maximum_size:_2_MB')}}</p>

                                    </div>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary mb-2">{{translate('Submit')}}</button>
                            </div>
                        </div>
                    </form>
                    </div>

            </div>
            <div class="col-lg-6 mb-3 mb-lg-2">
                <div class="card h-100">
                    <form action="{{ route('admin.promotional-banner.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="key" value="bottom_section_banner"  hidden>
                    <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 d-flex justify-content-between">
                                    <span class="d-flex g-1">
                                        <img src="{{asset('assets/admin/img/other-banner.png')}}" class="h-85" alt="">
                                        <h3 class="form-label d-block mb-2">
                                            {{translate('Bottom_Section_Banner')}}
                                        </h3>
                                    </span>
                                </div>
                                <div class="col-12">
                                    <h3 class="form-label d-block mb-5">
                                        {{translate('Upload_Banner')}}
                                    </h3>
                                    <label class="__upload-img aspect-5-1 m-auto d-block">
                                        <div class="img">
                                            <img class="onerror-image"
                                            src="{{\App\CentralLogics\Helpers::get_full_url('promotional_banner', $bottom_section_banner?->value?? '', $bottom_section_banner?->storage[0]?->value ?? 'public','upload_placeholder')}}"
                                        data-onerror-image="{{asset('assets/admin/img/upload-placeholder.png')}}" alt="">
                                        </div>
                                        <div class="position-relative">
                                            <input type="file" name="image"  hidden>
                                            @if (isset($bottom_section_banner?->value))
                                            <span id="bottom_section_banner" class="remove_image_button dynamic-checkbox"
                                                  data-id="bottom_section_banner"
                                                  data-type="status"
                                                  data-image-on="{{asset('assets/admin/img/modal')}}/mail-success"
                                                  data-image-off="{{asset('assets/admin/img/modal')}}/mail-warning"
                                                  data-title-on="{{translate('Important!')}}"
                                                  data-title-off="{{translate('Warning!')}}"
                                                  data-text-on="<p>{{translate('Are_you_sure_you_want_to_remove_this_image')}}</p>"
                                                  data-text-off="<p>{{translate('Are_you_sure_you_want_to_remove_this_image.')}}</p>"
                                            >
                                            <i class="tio-clear"></i></span>
                                            @endif
                                        </div>
                                    </label>
                                    <div class="text-center mt-5">
                                        <h3 class="form-label d-block mt-2">
                                        {{translate('Banner_Image_Ratio_5:1')}}
                                    </h3>
                                    <p>{{translate('image_format_:_jpg_,_png_,_jpeg_|_maximum_size:_2_MB')}}</p>

                                    </div>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-3">
                                <button type="submit" class="btn btn--primary mb-2">{{translate('Submit')}}</button>
                            </div>
                        </div>
                    </form>
                    </div>

            </div>
        </div>
    </div>
    <form  id="bottom_section_banner_form" action="{{ route('admin.remove_image') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{  $bottom_section_banner?->id}}" >
        {{-- <input type="hidden" name="json" value="1" > --}}
        <input type="hidden" name="model_name" value="ModuleWiseBanner" >
        <input type="hidden" name="image_path" value="promotional_banner" >
        <input type="hidden" name="field_name" value="value" >
    </form>
    <form  id="best_reviewed_section_banner_form" action="{{ route('admin.remove_image') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{  $best_reviewed_section_banner?->id}}" >
        {{-- <input type="hidden" name="json" value="1" > --}}
        <input type="hidden" name="model_name" value="ModuleWiseBanner" >
        <input type="hidden" name="image_path" value="promotional_banner" >
        <input type="hidden" name="field_name" value="value" >
    </form>
    <form  id="new_arrival_section_banner_form" action="{{ route('admin.remove_image') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{  $new_arrival_section_banner?->id}}" >
        {{-- <input type="hidden" name="json" value="1" > --}}
        <input type="hidden" name="model_name" value="ModuleWiseBanner" >
        <input type="hidden" name="image_path" value="promotional_banner" >
        <input type="hidden" name="field_name" value="value" >
    </form>

@endsection

@push('script_2')
    <script src="{{asset('assets/admin')}}/js/view-pages/other-banners.js"></script>
        <script>
            $('#reset_btn').click(function(){
                $('#viewer').attr('src','{{asset('assets/admin/img/upload-placeholder.png')}}');
            })
        </script>
@endpush
