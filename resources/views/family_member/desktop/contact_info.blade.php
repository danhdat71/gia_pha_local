@extends('family_member.desktop.main')
@section('content')
<style>
    .icon {
        display: inline-block;
        width: 25px;
    }
</style>
<div class="row contact-info">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                @if ($contactInfo?->contact_person)
                <div class="pb-3">
                    <b><span class="icon"><i class="fas fa-user-alt"></i></span> Người liên hệ: </b>
                    <span>{{$contactInfo->contact_person ?? null}}</span>
                </div>
                @endif
                @if ($contactInfo?->position)
                <div class="pb-3">
                    <b><span class="icon"><i class="fas fa-user-tag"></i></span> Vai trò: </b>
                    <span>{{$contactInfo->position ?? null}}</span>
                </div>
                @endif
                @if ($contactInfo?->phone)
                <div class="pb-3">
                    <b><span class="icon"><i class="fas fa-phone"></i></span> Số ĐT: </b>
                    <span>{{$contactInfo->phone ?? null}}</span>
                </div>
                @endif
                @if ($contactInfo?->address)
                <div class="pb-3">
                    <b><span class="icon"><i class="fas fa-map-marker-alt"></i></span> Địa chỉ: </b>
                    <span>{{$contactInfo->address ?? null}}</span>
                </div>
                @endif

                @if($contactInfo?->contact_person == null && $contactInfo?->position == null && $contactInfo?->phone == null && $contactInfo?->address == null)
                <div class="text-center">
                    <img class="empty-data" src="img/fixed/empty_data.jpg" alt="empty_media">
                    <div class="pt-3">Chưa có thông tin liên hệ ...</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection