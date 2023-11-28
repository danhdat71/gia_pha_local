@extends('family_member.main')
@section('content')
<div class="root-content about">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-template"><b>MÔ TẢ GIA PHẢ</b></div>
            <div class="card-body">
                @if ($familyTreeInfo->description == null || str_replace(" ", "", $familyTreeInfo->description) == "")
                <div class="text-center">
                    <img class="empty-data" src="img/fixed/empty_data.jpg" alt="empty_data">
                    <div class="empty-data-text">Chưa có thông tin mô tả ...</div>
                </div>
                @else
                {!!$familyTreeInfo->description!!}
                @endif
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header card-header-template"><b>CỬU HUYỀN</b></div>
            <div class="card-body">
                @if (sizeof ($leaveMembers) == 0)
                <div class="text-center">
                    <img class="empty-data" src="img/fixed/empty_data.jpg" alt="empty_data">
                    <div class="empty-data-text">Chưa có thông tin cửu huyền ...</div>
                </div>
                @endif
                @foreach ($leaveMembers as $member)
                    <div class="card-1">
                        <div class="wrap-image">
                            <img
                                @if ($member->avatar)
                                src="{{route('get_avatar_image', $member->avatar)}}"
                                @else
                                src="img/fixed/default_avatar_1.png"
                                @endif
                                alt=""
                            >
                        </div>
                        <div class="full_name">{{$member->full_name}}</div>
                        <div class="role_name">{{$member->role_name}}</div>
                        <div class="pb-1 info-item">{{$member->extra['birthday']}}</div>
                        <div class="pb-1 info-item">{{$member->extra['leaveday']}}</div>
                        @if ($member->rest_place)
                        <div class="pb-1 info-item">Nơi an nghỉ : {{$member->rest_place}}</div>
                        @endif
                        <div class="wrap-button pt-3">
                            <a href="{{route('family_member.detail_user')}}?id={{$member->id}}" class="btn-1">Chi tiết</a>
                            <a href="{{route('family_member.detail_user_panorama', $member->id)}}" class="btn-2">Thực tế ảo</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@stop