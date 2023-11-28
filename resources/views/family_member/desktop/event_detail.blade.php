@extends('family_member.desktop.main')
@section('content')
    <div class="row event-detail">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card p-3">
                <div class="head">
                    <div class="left">
                        <div class="wrap-time box-bg-template">
                            <div>{{ date('d', strtotime($event->date)) }}</div>
                            <div>{{ date('m-Y', strtotime($event->date)) }}</div>
                        </div>
                    </div>
                    <div class="right">
                        <div class="title">{{ $event->title }}</div>
                        <div class="loop">
                            @if ($event->is_year_loop)
                                Sự kiện diễn ra hằng năm
                            @else
                                Sự kiện diễn ra 1 lần
                            @endif
                        </div>
                        <div class="author">
                            <div class="wrap_img">
                                <img @if ($event->user->avatar) src="{{ route('get_avatar_image', $event->user->avatar) }}"
                                    @else
                                    src="img/fixed/default_avatar_1.png" @endif
                                    alt="
                                ">
                            </div>
                            <div class="name">{{ $event->user->full_name }}</div>
                        </div>
                    </div>
                </div>
                <b class="pb-3 pt-3 d-block text-title-3">Các thành viên tham dự:</b>
                @if (sizeof($event->eventsUsers) < 1)
                    Chưa có thành viên nào ...
                @endif
                <div class="wrap-joiner">
                    @foreach ($event->eventsUsers as $member)
                        <div class="item">
                            <div class="wrap-img">
                                <img @if ($member->avatar) src="{{ route('get_avatar_image', $member->avatar) }}"
                                    @else
                                    src="img/fixed/default_avatar_1.png" @endif
                                    alt="">
                            </div>
                            <div class="wrap-name">
                                <span>{{ $member->full_name }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <b class="pb-3 pt-3 d-block text-title-3">Lịch trình sự kiện:</b>
                <ul class="timeline">
                    @foreach($event->eventTimes as $key => $event)
                    <li>
                        <div
                            @if ($key % 2 == 0)
                            class="direction-r"
                            @else
                            class="direction-l"
                            @endif
                            
                        >
                            <div class="flag-wrapper">
                                <span class="hexa"></span>
                                <span class="time-wrapper"><span class="time">{{$event->start_at}} - {{$event->end_at}}</span></span>
                            </div>
                            <div class="desc">{{$event->description}}</div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <b class="pt-4 pb-3 d-block text-title-3">Chi tiết sự kiện:</b>
                <div class="wrap-content">
                    {!! $event->detail ?? 'Chưa có thông tin chi tiết...' !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="{{route('family_member.events')}}" class="btn btn-secondary"><i class="far fa-long-arrow-left"></i> Quay lại</a>
        </div>
    </div>
@endsection
