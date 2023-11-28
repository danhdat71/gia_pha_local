<h2>Thư mời tham gia sự kiện</h2>

<div>Sự kiện: {{$title}}</div>
<div>Mô tả: {{$description}}</div>
<div>Ngày diễn ra: {{$date}}</div>

<div>
    <div>Thời gian:</div>
    @foreach ($eventTimes as $eventTime)
    <div>
        <span>{{$eventTime->start_at}} - {{$eventTime->end_at}}:</span>
        <span>{{$eventTime->description}}</span>
    </div>
    @endforeach
</div>
