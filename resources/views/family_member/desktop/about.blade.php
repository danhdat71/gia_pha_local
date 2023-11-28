@extends('family_member.desktop.main')
@section('content')
<div class="row about">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-header card-header-template">
                <div class="text-title-2">Mô Tả Gia Phả</div>
            </div>
            <div class="card-body font-template-default">
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
    </div>

    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-header card-header-template">
                <div class="text-title-2">Cửu Huyền Thất Tổ</div>
            </div>
            <div class="card-body">
                @if (sizeof ($leaveMembers) == 0)
                <div class="text-center">
                    <img class="empty-data" src="img/fixed/empty_data.jpg" alt="empty_data">
                    <div class="empty-data-text">Chưa có thông tin cửu huyền ...</div>
                </div>
                @endif
                <div class="wrap-list">
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
</div>
@endsection