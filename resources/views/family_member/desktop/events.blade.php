@extends('family_member.desktop.main')
@section('content')
<div class="row events">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                <div class="wrap-tab-button">
                    <a class="tab-button active" href="{{route('family_member.events')}}">Sự kiện</a>
                    <a class="tab-button" href="{{route('family_member.blogs')}}">Tin tức</a>
                </div>
                
                <div class="wrap-event-items">
                    @foreach ($events as $event)
                    <a
                        @if ($event->events_viewers_count > 0)
                        style="opacity: 0.8;"
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
                @if (sizeof($events) == 0)
                <div class="alert text-center">Chưa có sự kiện</div>
                @endif
                <div id="wrap-paginate">
                    {{$events->onEachSide(1)->render('pagination::default')}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection