@extends('family_member.main')
@section('content')
<div class="root-content events">
    <div class="container-fluid">
        <div class="wrap-tab-button">
            <a class="tab-button active" href="{{route('family_member.events')}}">Sự kiện</a>
            <a class="tab-button" href="{{route('family_member.blogs')}}">Tin tức</a>
        </div>
        @if (sizeof ($events) == 0)
        <div class="text-center pt-5">
            <img class="empty-data" src="img/fixed/empty_data.jpg" alt="empty_data">
            <div class="empty-data-text">Chưa có sự kiện nào ...</div>
        </div>
        @endif
        <div class="wrap-event-items">
            @foreach ($events as $event)
            <a
                @if ($event->events_viewers_count > 0)
                style="opacity: 0.5;"
                @endif
                href="{{route('family_member.event_detail', $event->id)}}" class="event-item">
                <div class="left">
                    <div class="wrap-time box-bg-template">
                        <div>{{date('d', strtotime($event->date))}}</div>
                        <div>{{date('m-Y', strtotime($event->date))}}</div>
                    </div>
                </div>
                <div class="right">
                    <div class="title">{{$event->title}}</div>
                    <div class="guest-count">{{$event->eventsUsers()->count()}} khách mời</div>
                </div>
            </a>
            @endforeach
        </div>
        <div id="wrap-paginate">
            {{$events->onEachSide(1)->render('pagination::default')}}
        </div>
    </div>
</div>
@stop
