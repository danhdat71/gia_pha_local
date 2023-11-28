@extends('family_member.main')
@section('content')
<div class="root-content funds">
    <div class="container-fluid">
        <h4 class="d-block p-2 text-center">Quỹ thu chi</h4>
        <form class="row pb-3" method="get" action="{{route('family_member.funds')}}">
            <div class="col-6">
                {{-- <label>Từ ngày</label> --}}
                <input
                    id="date-from-preview"
                    type="text"
                    class="date form-control"
                    autocomplete="off"
                    @if (isset($inputed['date_from']))
                    value="{{date('d-m-Y', strtotime($inputed['date_from']))}}"
                    @endif
                    placeholder="Từ ngày"
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
            <div class="col-6">
                {{-- <label>Đến ngày</label> --}}
                <input
                    id="date-to-preview"
                    type="text"
                    class="date form-control"
                    autocomplete="off"
                    @if (isset($inputed['date_to']))
                    value="{{date('d-m-Y', strtotime($inputed['date_to']))}}"
                    @endif
                    placeholder="Đến ngày"
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
            <div class="col-6 pt-2">
                {{-- <label>Sự kiện</label> --}}
                <select name="event_id" class="w-100 select-2">
                    <option value="">Sự kiện</option>
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
            <div class="col-6">
                <button class="btn button-color-template btn-search w-100">Tìm kiếm</button>
            </div>
        </form>
        @if (sizeof($funds) == 0)
        <div class="text-center pt-4 pb-4">
            <img class="empty-data" src="img/fixed/empty_data.jpg" alt="empty_data">
            <div class="empty-data-text">Chưa có mục quỹ thu chi nào <a href="{{route('family_member.fund_register')}}">Đi đăng ký</a></div>
        </div>
        @endif
        <div class="wrap-event-items">
            @foreach ($funds as $fund)
            <a href="{{route('family_member.fund_detail', ['id' => $fund->id])}}" class="event-item">
                <div class="left">
                    <div class="wrap-time box-bg-template">
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
    <div class="container-fluid pt-4">
        <a href="{{route('family_member.profile_index')}}" class="btn btn-sm btn-secondary"><i class="far fa-long-arrow-left"></i> Quay lại</a>
    </div>
    <script>
        window.addEventListener('DOMContentLoaded', function(){
            handleDatePicker('#date-from-preview', '#date-from', 'bl');
            handleDatePicker('#date-to-preview', '#date-to', 'br');
        });
    </script>
</div>
@stop