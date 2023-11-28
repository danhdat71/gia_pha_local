@extends('family_admin.main')
@section('content')
<div class="content-wrapper">
    @include('global.content_head', [
        'title' => 'Quản lý sự kiện'
    ])
    <section class="content">
        <div class="container-fluid">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <form class="row" action="{{route('family_admin.events')}}" method="get" enctype="multipart/form-data">
                        <div class="form-group col-md-3">
                            <label for="">Tên sự kiện</label>
                            <input type="text" class="form-control" name="keyword" value="{{$inputed['keyword'] ?? null}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Từ ngày</label>
                            <input type="text" class="form-control" name="from_date" value="{{$inputed['from_date'] ?? null}}">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="">Đến ngày</label>
                            <input type="text" class="form-control" name="to_date" value="{{$inputed['to_date'] ?? null}}">
                        </div>
                        <div class="form-group col-md-1 pt-2">
                            <button id="search" type="submit" class="btn button-color-template mt-4"><i class="far fa-search"></i> Tìm</button>
                        </div>
                        <div class="form-group col-md-2 pt-2 text-right">
                            <a href="{{route('family_admin.create_event_view')}}" class="btn button-color-template mt-4">+ Tạo sự kiện</a>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-header-template">
                                <th>#ID</th>
                                <th>Tên sự kiện</th>
                                <th>Ngày diễn ra</th>
                                <th>Số thành viên</th>
                                <th>Thao tác</th>
                            </thead>
                            <tbody>
                                @if(sizeof($events) == 0)
                                <tr>
                                    <td colspan="5">
                                        <div class="alert text-center">Chưa có sự kiện nào.</div>
                                    </td>
                                </tr>
                                @endif
                                @foreach($events as $event)
                                <tr>
                                    <td>{{$event->id}}</td>
                                    <td>{{$event->title}}</td>
                                    <td>{{date('d-m-Y', strtotime($event->date))}}</td>
                                    <td>{{$event->eventsUsers->count()}}</td>
                                    <td>
                                        <a href="{{route('family_admin.edit_event_view', ['id' => $event->id])}}" class="btn btn-sm btn-warning">Sửa</a>
                                        <button data-toggle="modal" data-target="#delete-event-modal" data-id="{{$event->id}}" class="btn btn-sm btn-danger delete-event">Xóa</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-md-4 d-flex justify-content-center">{{$events->appends($inputed)->links()}}</div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="delete-event-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc muốn xoá event này ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6 text-center">
                                    <button class="btn btn-sm btn-secondary w-100" data-dismiss="modal">Không</button>
                                </div>
                                <div class="col-6 text-center">
                                    <form action="{{route('family_admin.delete_event')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" id="delete-event-id">
                                        <button class="btn btn-sm button-color-template w-100">Đồng ý</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $( "[name=from_date]" ).datepicker({
            dayNamesMin: [ "T2", "T3", "T4", "T5", "T6", "T7", "CN" ],
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            dateFormat: "yy-mm-dd",
        });
        $( "[name=to_date]" ).datepicker({
            dayNamesMin: [ "T2", "T3", "T4", "T5", "T6", "T7", "CN" ],
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            dateFormat: "yy-mm-dd",
        });
        $('.delete-event').click(function(){
            $('#delete-event-id').val($(this).attr('data-id'));
        });
    </script>
</div>
@endsection