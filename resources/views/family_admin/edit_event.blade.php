@extends('family_admin.main')
@section('content')
<div class="content-wrapper">
    @include('global.content_head', [
        'title' => 'Quản lý sự kiện'
    ])
    <style>
        #check-all *{
            cursor: pointer;
            user-select: none;
        }
        #check-all-input {
            width: 18px;
            height: 18px;
        }
        .check-member {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        #member-join-table .wrap-img {
            width: 50px;
            height: 50px;
        }
        #member-join-table .wrap-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .w-20 {
            width: 20%!important;
        }
        #member-join-table tr {
            cursor: pointer;
        }
        #member-join-table tr:hover {
            background: rgba(8, 8, 8, 0.144)!important;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header card-header-template">Sửa sự kiện</div>
                <div class="card-body">
                    <form action="{{ route('family_admin.edit_event') }}" class="row" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$event->id}}">
                        <div class="form-group col-md-8">
                            <label for="title">Tiêu đề <span class="text-danger">(*)</span></label>
                            <input type="text" name="title" class="form-control" id="title" value="{{old('title', $event->title)}}">
                            @error("title")
                                <div><i class="text-danger">{{ $message }}</i></div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="date">Ngày diễn ra <span class="text-danger">(*)</span></label>
                            <input
                                type="text"
                                class="form-control"
                                id="date-preview"
                                value="{{old('date', date('d-m-Y', strtotime($event->date)))}}"
                            >
                            <input id="date" name="date" type="hidden" value="{{old('date', $event->date)}}">
                            @error("date")
                                <div><i class="text-danger">{{ $message }}</i></div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Mô tả ngắn <span class="text-danger">(*)</span></label>
                            <textarea name="description" rows="3" class="form-control">{{old('description', $event->description)}}</textarea>
                            @error("description")
                                <div><i class="text-danger">{{ $message }}</i></div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="is_year_loop">Lặp hằng năm</label>
                                    <div class="d-flex align-items-center">
                                        <div class="wrap-check-box pr-3">
                                            <label for="loop_yes">Lặp</label>
                                            <input
                                                value="1"
                                                type="radio" 
                                                name="is_year_loop"
                                                id="loop_yes"
                                                @if (old('is_year_loop', $event->is_year_loop) == 1)
                                                checked
                                                @endif
                                            >
                                        </div>
                                        <div class="wrap-check-box">
                                            <label for="loop_no">Không lặp</label>
                                            <input
                                                value="0"
                                                type="radio"
                                                name="is_year_loop"
                                                id="loop_no"
                                                @if (old('is_year_loop', $event->is_year_loop) == 0)
                                                checked
                                                @endif
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div
                                    @if (old('is_year_loop', $event->is_year_loop) == 1)
                                    class="col-md-2 col-loop-at"
                                    @else
                                    class="col-md-2 col-loop-at d-none"
                                    @endif
                                >
                                    <label for="noti_day_before">Thông báo trước <i>ngày diễn ra</i></label>
                                    <div class="input-group">
                                        <input
                                            id="noti_day_before"
                                            type="text"
                                            class="form-control text-center"
                                            onkeypress="return (event.charCode !=8 && event.charCode ==0 || ( event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)))"
                                            maxlength="2"
                                            name="noti_day_before"
                                            @if ($event->noti_before)
                                            value="{{old('noti_day_before', explode('|', $event->noti_before)[0])}}"
                                            @endif
                                        >
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">ngày</span>
                                        </div>
                                    </div>
                                    @error("noti_day_before")
                                        <div><i class="text-danger">{{ $message }}</i></div>
                                    @enderror
                                </div>
                                <div
                                    @if (old('is_year_loop', $event->is_year_loop) == 1)
                                    class="col-md-2 col-loop-at"
                                    @else
                                    class="col-md-2 col-loop-at d-none"
                                    @endif
                                >
                                    <label for="noti_time_before">Thông báo lúc</label>
                                    <input
                                        id="noti_time_before"
                                        type="time"
                                        class="form-control text-center"
                                        name="noti_time_before"
                                        @if ($event->noti_before)
                                        value="{{old('noti_time_before', explode('|', $event->noti_before)[1])}}"
                                        @endif
                                    >
                                    @error("noti_time_before")
                                        <div><i class="text-danger">{{ $message }}</i></div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="date">Thời gian sự kiện</label>
                            <div>
                                <div id="wrap-event-time">
                                    @php
                                        if (old('event_times') == null) {
                                            $eventTimes = $event->eventTimes()->get()->toArray();
                                        } else {
                                            $eventTimes = old('event_times');
                                        }
                                    @endphp
                                    @foreach($eventTimes as $key => $eventTime)
                                        <div class="row align-items-center pb-1 pt-1 event-time-item" data-index="{{$key}}">
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center">
                                                    <input type="time" class="form-control" name="event_times[{{$key}}][start_at]" value="{{$eventTime['start_at']}}">
                                                    <span class="pl-1 pr-1">~</span>
                                                    <input type="time" class="form-control" name="event_times[{{$key}}][end_at]" value="{{$eventTime['end_at']}}">
                                                </div>
                                                @error("event_times.$key.start_at")
                                                    <div><i class="text-danger">{{ $message }}</i></div>
                                                @enderror
                                                @error("event_times.$key.end_at")
                                                    <div><i class="text-danger">{{ $message }}</i></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-7">
                                                <textarea placeholder="Mô tả" class="form-control" name="event_times[{{$key}}][description]">{{$eventTime['description']}}</textarea>
                                                @error("event_times.$key.description")
                                                    <i class="text-danger">{{ $message }}</i>
                                                @enderror
                                            </div>
                                            <div class="col-md-1">
                                                <button class="btn btn-danger btn-sm delete-time-event">Xóa</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button id="add-event-times" class="btn btn-sm button-color-template">+ Thêm thời gian sự kiện</button>
                                @error("event_times")
                                    <div><i class="text-danger">{{ $message }}</i></div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="">Thành viên tham dự <span class="text-danger">(*)</span></label>
                            <div class="p-2">
                                @php
                                    $joinMembers = '';
                                    if (old('join_members') != null) {
                                        $memberChecked = explode(',', old('join_members'));
                                        $memberChecked = array_map(function ($value) {
                                            return ['id' => (int) $value];
                                        }, $memberChecked);
                                        $joinMembers = old('join_members');
                                    } else {
                                        $memberChecked = $event->eventsUsers()->get()->toArray();
                                        $joinMembers = $event->eventsUsers()->pluck('event_user.user_id')->implode(',');
                                    }
                                @endphp
                                <input type="hidden" name="join_members" id="join_members" value="{{$joinMembers}}">
                                <div class="table-responsive text-nowrap">
                                    <table class="w-100" id="member-join-table">
                                        <thead>
                                            <th class="pl-2 pr-2 pb-2 w-20 text-left">Ảnh đại diện</th>
                                            <th class="pl-2 pr-2 pb-2 w-20 text-left">Tên thành viên</th>
                                            <th class="pl-2 pr-2 pb-2 w-20 text-left">Tuổi</th>
                                            <th class="pl-2 pr-2 pb-2 w-20 text-left">Giới tính</th>
                                            <th class="pl-2 pr-2 pb-2 w-20 text-left">
                                                <div class="d-flex align-items-center" id="check-all">
                                                    <div class="pr-2"><label for="check-all-input">Chọn tất cả</label></div>
                                                    <div><input type="checkbox" id="check-all-input"></div>
                                                </div>
                                            </th>
                                        </thead>
                                        <tbody>
                                            @foreach($members as $key => $member)
                                            <tr>
                                                <td class="text-left pl-2">
                                                    <div class="wrap-img">
                                                        <img
                                                            @if($member->avatar)
                                                            src="{{route('get_avatar_image', $member->avatar)}}"
                                                            @else
                                                            src="img/fixed/default_avatar_1.png"
                                                            @endif
                                                            alt="{{$member->avatar}}">
                                                    </div>
                                                </td>
                                                <td class="text-left pl-2"><b>{{$member->full_name}}</b></td>
                                                <td class="text-left pl-2">1</td>
                                                <td class="text-left pl-2">
                                                    @if ($member['gender'] == App\Constants\Gender::MALE)
                                                    Nam
                                                    @else
                                                    Nữ
                                                    @endif
                                                </td>
                                                <td class="text-center pl-2">
                                                    <input
                                                        data-id={{$member->id}}
                                                        type="checkbox"
                                                        class="check-member"
                                                        @php
                                                            $search = collect($memberChecked)->search(function($value) use($member) {
                                                                return $value['id'] === $member->id;
                                                            });
                                                        @endphp
                                                        @if ($search !== false)
                                                        checked
                                                        @endif
                                                    >
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @error("join_members")
                                        <div><i class="text-danger">{{ $message }}</i></div>
                                    @enderror
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-12 pt-2">
                            <label for="detail">Chi tiết sự kiện</label>
                            <textarea name="detail" id="detail">{{old('detail', $event->detail)}}</textarea>
                            @error("detail")
                                <div><i class="text-danger">{{ $message }}</i></div>
                            @enderror
                        </div>
                        <div class="col-md-12 pt-3 text-right">
                            <button class="btn button-color-template">Cập nhật sự kiện</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        let editor = CKEDITOR.replace('detail', configCkeditor);
        handleDatePicker('#date-preview', '#date', 'bl');
        $('#member-join-table').DataTable({
            scrollY: '350px',
            scrollCollapse: true,
            paging: false,
            language : {
                emptyTable : "Hiện chưa có thành viên trong gia phả",
                infoEmpty: "",
                info: ""
            }
        });
        $('#check-all *, #member-join-table tr input').click(function(e){
            e.stopPropagation();
            setJoinMemberIds();
        });
        $('#check-all input').change(function(){
            let isCheckedAll = $(this).is(':checked');
            $('#member-join-table tr input').prop('checked', isCheckedAll);
            setJoinMemberIds();
        })
        $( "[name=date]" ).datepicker({
            dayNamesMin: [ "T2", "T3", "T4", "T5", "T6", "T7", "CN" ],
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            dateFormat: "yy-mm-dd",
        });
        $('#member-join-table tr').click(function(e){
            let isChecked = $(this).find('input').is(":checked");
            $(this).find('input').prop('checked', !isChecked);
            setJoinMemberIds();
        });
        let beginIndexET = 0;
        $('#add-event-times').click(function(e){
            e.preventDefault();
            if ($('.event-time-item').length > 0){
                beginIndexET = parseInt($('.event-time-item:last-child').attr('data-index')) + 1;
            }
            let item = `
                <div class="row align-items-center pb-1 pt-1 event-time-item" data-index="${beginIndexET}">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <input type="time" class="form-control" name="event_times[${beginIndexET}][start_at]">
                            <span class="pl-1 pr-1">~</span>
                            <input type="time" class="form-control" name="event_times[${beginIndexET}][end_at]">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <textarea placeholder="Mô tả" class="form-control" name="event_times[${beginIndexET}][description]"></textarea>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-danger btn-sm delete-time-event">Xóa</button>
                    </div>
                </div>
            `;
            $('#wrap-event-time').append(item);
        });
        $('#wrap-event-time').on('click', '.delete-time-event', function(e){
            e.preventDefault();
            $(this).closest('.event-time-item').remove();
        });

        function setJoinMemberIds()
        {
            var checkboxArray = [];
            $('.check-member:checked').each(function() {
                checkboxArray.push($(this).attr('data-id'));
            });
            $('#join_members').val(checkboxArray);
        }

        $('.wrap-check-box').find('input').change(function(){
            let value = parseInt($(this).val());
            if (value == {{App\Constants\Status::VALUE_TRUE}}) {
                $('.col-loop-at').removeClass('d-none');
            } else {
                $('.col-loop-at').addClass('d-none');
                $('.col-loop-at').find('input').val('');
            }
        });
    </script>
</div>
@endsection