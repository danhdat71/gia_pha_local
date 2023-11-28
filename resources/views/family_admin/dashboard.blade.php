@extends('family_admin.main')
@section('content')
    <div class="content-wrapper">
        @include('global.content_head', [
            'title' => 'Tổng quan gia phả',
        ])
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-7">
                        <div class="card">
                            <div class="card-header card-header-template">
                                <h3 class="card-title">Gia đình tôi</h3>
                                <div class="card-tools">
                                    <span class="badge badge-danger">Người mới</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <ul class="users-list clearfix">
                                    @if (sizeof($familyMembers) == 0)
                                    <div class="alert">Chưa có thành viên gia đình nào</div>
                                    @endif
                                    @foreach($familyMembers as $familyMember)
                                    <li class="p-4">
                                        <img
                                            loading="lazy"
                                            @if($familyMember->avatar)
                                            src="{{route('get_avatar_image', $familyMember->avatar)}}"
                                            @else
                                            src="img/fixed/default_avatar_1.png"
                                            @endif
                                            alt=""
                                        >
                                        <a class="users-list-name pt-2" href="{{route('family_admin.detail_user', $familyMember->id)}}">{{$familyMember->full_name}}</a>
                                        <span class="users-list-date">{{$familyMember->f_relationship}}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{route('family_admin.genealogy')}}">Xem toàn bộ</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-5">
                        <div
                            @if ($templateId != 3)
                            class="info-box mb-3 card-header-template"
                            @else
                            class="info-box mb-3"
                            @endif
                        >
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Tổng thành viên cây</span>
                                <span class="info-box-number">{{$totalMember}} người</span>
                            </div>
                        </div>
                        <div
                            @if ($templateId != 3)
                            class="info-box mb-3 card-header-template"
                            @else
                            class="info-box mb-3"
                            @endif
                        >
                            <span class="info-box-icon"><i class="fas fa-male"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Tổng thành viên nam</span>
                                <span class="info-box-number">{{$totalMan}} người</span>
                            </div>
                        </div>
                        <div
                            @if ($templateId != 3)
                            class="info-box mb-3 card-header-template"
                            @else
                            class="info-box mb-3"
                            @endif
                        >
                            <span class="info-box-icon"><i class="fas fa-female"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Tổng thành viên nữ</span>
                                <span class="info-box-number">{{$totalWoman}} người</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Sự kiện sắp diễn ra</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive text-nowrap">
                                    <table class="table m-0">
                                        <thead class="table-header-template">
                                            <tr>
                                                <th>Thứ tự</th>
                                                <th>Tiêu đề</th>
                                                <th>Ngày diễn ra</th>
                                                <th>Số thành viên</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (sizeof($events) == 0)
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    <div class="pb-2">Không có sự kiện sắp diễn ra</div>
                                                    <a href="" class="btn btn-sm button-color-template">Tạo sự kiện</a>
                                                </td>
                                            </tr>
                                            @endif
                                            @foreach($events as $key => $event)
                                            <tr>
                                                <td>#{{$key + 1}}</td>
                                                <td>{{$event->title}}</td>
                                                <td>{{date('d-m-Y', strtotime($event->date))}}</td>
                                                <td><span class="badge badge-success">{{$event->eventsUsers->count()}} người</span></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
