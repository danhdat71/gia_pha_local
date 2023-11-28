@extends('family_member.desktop.main')
@section('content')
<!-- Date picker -->
<link rel="stylesheet" href="https://unpkg.com/js-datepicker/dist/datepicker.min.css">
<style>
    
</style>
<div class="row funds">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                <form method="get" action="{{route('family_member.funds')}}" class="wrap-filter pb-5">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Từ ngày</label>
                            <input
                                id="date-from-preview"
                                type="text"
                                class="date form-control"
                                autocomplete="off"
                                @if (isset($inputed['date_from']))
                                value="{{date('d-m-Y', strtotime($inputed['date_from']))}}"
                                @endif
                            />
                            <input
                                type="hidden"
                                name="date_from"
                                id="date-from"
                                @if (isset($inputed['date_from']))
                                value="{{$inputed['date_from']}}"
                                @endif
                            >
                        </div>
                        <div class="col-md-3">
                            <label>Đến ngày</label>
                            <input
                                id="date-to-preview"
                                type="text"
                                class="date form-control"
                                autocomplete="off"
                                @if (isset($inputed['date_to']))
                                value="{{date('d-m-Y', strtotime($inputed['date_to']))}}"
                                @endif
                            />
                            <input
                                type="hidden"
                                name="date_to"
                                id="date-to"
                                @if (isset($inputed['date_to']))
                                value="{{$inputed['date_to']}}"
                                @endif
                            >
                        </div>
                        <div class="col-md-3">
                            <label>Sự kiện</label>
                            <select name="event_id" class="w-100 select-2">
                                <option value="">Tất cả</option>
                                <option
                                    value="-1"
                                    @if (isset($inputed['event_id']) && $inputed['event_id'] == -1)
                                    selected
                                    @endif
                                >Không có</option>
                                @foreach ($events as $event)
                                <option
                                    value="{{$event->id}}"
                                    @if (isset($inputed['event_id']) && $inputed['event_id'] == $event->id)
                                    selected
                                    @endif
                                >{{$event->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn button-color-template btn-search"><i class="far fa-search"></i></button>
                        </div>
                    </div>
                </form>
                @if (sizeof($funds) == 0)
                <div class="text-center">Chưa có mục quỹ thu chi nào <a href="{{route('family_member.fund_register')}}">Đi đăng ký</a></div>
                @endif
                <div class="wrap-event-items">
                    @foreach ($funds as $fund)
                    <a href="{{route('family_member.fund_detail', ['id' => $fund->id])}}" class="event-item">
                        <div class="left">
                            <div class="wrap-time">
                                <div>{{date('d', strtotime($fund->date))}}</div>
                                <div>{{date('m-Y', strtotime($fund->date))}}</div>
                            </div>
                        </div>
                        <div class="center">
                            <div class="title">{{$fund->description}}</div>
                            <div class="desc-1">{{App\Constants\Fund::FUND_TYPE[$fund->fund_type]}}</div>
                            <div class="desc-1">{{App\Constants\Fund::FUND_STATUS[$fund->status]}}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div id="wrap-paginate">
                    {{$funds->onEachSide(1)->render('pagination::default')}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Datepicker -->
<script src="https://unpkg.com/js-datepicker"></script>
<script>
    window.addEventListener('DOMContentLoaded', function(){
        handleDatePicker('#date-from-preview', '#date-from');
        handleDatePicker('#date-to-preview', '#date-to');
    });
</script>
@endsection