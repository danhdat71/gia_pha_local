@extends('family_member.main')
@section('content')
<style>
    .icon {
        display: inline-block;
        width: 25px;
    }
</style>
<div class="root-content">
    
    @if($contactInfo?->contact_person == null && $contactInfo?->position == null && $contactInfo?->phone == null && $contactInfo?->address == null)
    <div class="text-center pt-5">
        <img class="empty-data" src="img/fixed/empty_data.jpg" alt="empty_media">
        <div class="pt-3">Chưa có thông tin liên hệ ...</div>
    </div>
    @else
    <div class="container-fluid">
        <div class="text-center pt-3 pb-3">
            <h4>Thông Tin Liên Hệ</h4>
        </div>
        <div class="pb-3">
            <b><span class="icon"><i class="fas fa-user-alt"></i></span> Người liên hệ: </b>
            <span>{{$contactInfo->contact_person ?? null}}</span>
        </div>
        <div class="pb-3">
            <b><span class="icon"><i class="fas fa-user-tag"></i></span> Vai trò: </b>
            <span>{{$contactInfo->position ?? null}}</span>
        </div>
        <div class="pb-3">
            <b><span class="icon"><i class="fas fa-phone"></i></span> Số ĐT: </b>
            <span>{{$contactInfo->phone ?? null}}</span>
        </div>
        <div class="pb-3">
            <b><span class="icon"><i class="fas fa-map-marker-alt"></i></span> Địa chỉ: </b>
            <span>{{$contactInfo->address ?? null}}</span>
        </div>
    </div>
    @endif

    <div class="container-fluid pt-4">
        <a href="{{route('family_member.profile_index')}}" class="btn btn-sm btn-secondary"><i class="far fa-long-arrow-left"></i> Quay lại</a>
    </div>
</div>
@stop