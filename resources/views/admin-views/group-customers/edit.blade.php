@extends('layouts.admin.app')

@section('title',translate('messages.Update brand'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="{{asset('assets/admin/img/edit.png')}}" class="w--20" alt="">
                </span>
                <span>
                    {{translate('messages.Brand_Update')}}
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.businessowners.update',[$businessOwner['id']])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Use PUT or PATCH for updates -->
                    <div class="row">
                        <div class="col-6">
                            @if (isset($language))
                                <div class="form-group lang_form" id="default-form">
                                    <label class="input-label" for="exampleFormControlInput1">{{translate('messages.name')}} ({{ translate('messages.default') }})</label>
                                    <input type="text" name="name[]" class="form-control" placeholder="{{translate('messages.new_brand')}}" maxlength="191" value="{{$brand?->getRawOriginal('name')}}">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                @foreach($language as $lang)
                                    <?php
                                        if(count($businessOwner['translations'])){
                                            $translate = [];
                                            foreach($businessOwner['translations'] as $t)
                                            {
                                                if($t->locale == $lang && $t->key=="name"){
                                                    $translate[$lang]['name'] = $t->value;
                                                }
                                            }
                                        }
                                    ?>
                                    <div class="form-group d-none lang_form" id="{{$lang}}-form">
                                        <label class="input-label" for="exampleFormControlInput1">{{translate('messages.name')}} ({{strtoupper($lang)}})</label>
                                        <input type="text" name="name[]" class="form-control" placeholder="{{translate('messages.new_brand')}}" maxlength="191" value="{{$translate[$lang]['name']??''}}">
                                    </div>
                                    <input type="hidden" name="lang[]" value="{{$lang}}">
                                @endforeach
                            @else
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlInput1">{{translate('messages.name')}}</label>
                                    <input type="text" name="name" class="form-control" placeholder="{{translate('messages.new_brand')}}" value="{{$businessOwner['name']}}" maxlength="191">
                                </div>
                                {{-- <input type="hidden" name="lang[]" value="{{$lang}}"> --}}
                            @endif
                        </div>
                       
                    </div>
                    <div class="btn--container justify-content-end mt-3">
                        <button type="reset" id="reset_btn" class="btn btn--reset">{{translate('messages.reset')}}</button>
                        <button type="submit" class="btn btn--primary">{{translate('messages.update')}}</button>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection

@push('script_2')
   
    <script>
    
    </script>
@endpush
