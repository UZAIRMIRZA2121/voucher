
@foreach($conversations as $conv)
@php($user= $conv->sender_type == 'vendor' ? $conv->receiver :  $conv->sender)
@if (isset($user ) && $conv->last_message)
    @php($unchecked=($conv->last_message->sender_id == $user->id) ? $conv->unread_message_count : 0)
    <div
        class="chat-user-info d-flex border-bottom p-3 align-items-center customer-list {{$unchecked ? 'conv-active' : ''}}"
        onclick="viewConvs('{{route('vendor.message.view',['conversation_id'=>$conv->id,'user_id'=>$user->id])}}','customer-{{$user->id}}','{{ $conv->id }}','{{ $user->id }}')"
        id="customer-{{$user->id}}">
        <div class="chat-user-info-img d-none d-md-block">
            <img class="avatar-img onerror-image"
                 data-onerror-image="{{asset('assets/admin/img/160x160/img1.jpg')}}"
                 src="{{ $user['image_full_url'] }}"
                    alt="Image Description">
        </div>

        <div class="chat-user-info-content">
            <h5 class="mb-0 d-flex justify-content-between">
                <span class=" mr-3">{{$user['f_name'].' '.$user['l_name']}}</span> <span
                    class="{{$unchecked ? 'badge badge-info' : ''}}">{{$unchecked ? $unchecked : ''}}</span>
                    <small>{{date(config('timeformat'),strtotime($conv->last_message->created_at))}}</small>
            </h5>
            <small>{{ $user['phone'] }}</small>
            <div class="text-title">{{ Str::limit($conv->last_message->message ??'', 35, '...') }}</div>
        </div>
    </div>
@else
    <div
        class="chat-user-info d-flex border-bottom p-3 align-items-center customer-list">
        <div class="chat-user-info-img d-none d-md-block">
            <img class="avatar-img"
                    src='{{asset('assets/admin/img/160x160/img1.jpg')}}'
                    alt="Image Description">
        </div>
        <div class="chat-user-info-content">
            <h5 class="mb-0 d-flex justify-content-between">
                <span class=" mr-3">{{translate('messages.user_not_found')}}</span>
            </h5>
        </div>
    </div>
@endif
@endforeach
<script src="{{asset('assets/admin')}}/js/view-pages/common.js"></script>