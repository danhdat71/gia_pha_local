@extends('family_admin.main')
@section('content')
<div class="content-wrapper">
    @include('global.content_head', [
        'title' => 'Quản lý thu chi'
    ])
    <style>
        @media screen and (max-width: 576px) {
            .wid-confirm {
                width: 120px;
            }
        }

        .wrap-avatar-img {
            width: 100px;
            height: 100px;
            overflow: hidden;
        }

        .wrap-avatar-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .table td{
            vertical-align: middle;
        }

        .select2-container .select2-selection--single {
            height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .text-content {
            white-space: pre;
        }

        .preview-image {
            aspect-ratio: 16/9;
            border: 1px dashed rgb(196, 196, 196);
            position: relative;
        }

        .img-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cursor-pointer {
            cursor: pointer;
        }
        
        .btn-remove {
            width: 25px;
            height: 25px;
            position: absolute;
            right: 5px;
            top: 5px;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: rgb(189, 0, 0);
            cursor: pointer;
            background: transparent;
            border: none;
            outline: none;
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
                <div class="card-header">
                    <form class="row" action="{{route('family_admin.funds')}}" method="get" enctype="multipart/form-data">
                        <div class="form-group col-md-2">
                            <label for="">Từ ngày</label>
                            <input type="text" class="form-control" name="from_date" value="{{$inputed['from_date'] ?? null}}" autocomplete="off">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Đến ngày</label>
                            <input type="text" class="form-control" name="to_date" value="{{$inputed['to_date'] ?? null}}" autocomplete="off">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Thành viên</label>
                            <select class="select-2 w-100 input-group" name="user_id" id="">
                                <option value="">Tất cả</option>
                                <option
                                    value="-1"
                                    @if (isset($inputed['user_id']) && $inputed['user_id'] == -1)
                                    selected
                                    @endif
                                >Ngoài gia đình</option>
                                @foreach ($users as $user)
                                <option
                                    value="{{$user->id}}"
                                    @if (isset($inputed['user_id']) && $inputed['user_id'] == $user->id)
                                    selected
                                    @endif
                                >{{$user->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Sự kiện</label>
                            <select class="select-2 w-100 input-group" name="event_id">
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
                        <div class="form-group col-md-2 pt-2">
                            <button type="submit" class="btn button-color-template mt-4"><i class="far fa-search"></i> Tìm</button>
                        </div>
                        <div class="form-group col-md-2 pt-2 text-right">
                            <div data-toggle="modal" data-target="#create-fund-modal" class="btn button-color-template mt-4">+ Thêm mới</div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table text-nowrap">
                            <thead class="table-header-template">
                                <th>Họ tên</th>
                                <th>Loại</th>
                                <th>Mô tả</th>
                                <th>Sự kiện</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </thead>
                            <tbody>
                                @if(sizeof($funds) == 0)
                                <tr>
                                    <td colspan="6">
                                        <div class="alert text-center">Chưa có phiếu thu chi nào.</div>
                                    </td>
                                </tr>
                                @endif
                                @foreach($funds as $fund)
                                <tr>
                                    <td>
                                        @if ($fund->user)
                                        {{$fund->user->full_name}}
                                        @else
                                        <div class="text-danger font-italic">Ngoài gia đình</div>
                                        @endif
                                    </td>
                                    <td>{{App\Constants\Fund::FUND_TYPE[$fund->fund_type]}}</td>
                                    <td class="text-content">{{$fund->description}}</td>
                                    <td>
                                        @if ($fund->event)
                                        {{$fund->event->title}}
                                        @else
                                        <div class="text-danger font-italic">Không có</div>
                                        @endif
                                    </td>
                                    <td>
                                        <select data-id="{{$fund->id}}" class="form-control wid-confirm change-status">
                                            <option 
                                                value="{{App\Constants\Fund::FUND_CONFIRM}}"
                                                @if ($fund->status == App\Constants\Fund::FUND_CONFIRM)
                                                selected
                                                @endif
                                            >Chưa duyệt</option>
                                            <option
                                                value="{{App\Constants\Fund::FUND_OK}}"
                                                @if ($fund->status == App\Constants\Fund::FUND_OK)
                                                selected
                                                @endif
                                            >Đã duyệt</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button
                                            data-date="{{$fund->date}}"
                                            data-event_id="{{$fund->event_id ?? ""}}"
                                            data-user_id="{{$fund->user_id}}"
                                            data-description="{{$fund->description}}"
                                            data-fund_type="{{$fund->fund_type}}"
                                            data-id="{{$fund->id}}"
                                            @if ($fund->proof)
                                            data-proof="{{route('get_proof', $fund->proof)}}"
                                            @else
                                            data-proof=""
                                            @endif
                                            data-toggle="modal"
                                            data-target="#edit-fund-modal"
                                            class="btn btn-sm btn-warning edit-fund"
                                        >Sửa</button>
                                        <button data-toggle="modal" data-target="#delete-fund-modal" data-id="{{$fund->id}}" class="btn btn-sm btn-danger delete-fund">Xóa</button>
                                        @if ($fund->proof)
                                        <a
                                            data-src="{{route('get_proof', $fund->proof)}}"
                                            class="btn btn-info btn-sm fancybox"
                                            data-fancybox="proof"
                                        >
                                            <i class="fas fa-image"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-md-4 d-flex justify-content-center">{{$funds->appends($inputed)->links()}}</div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="delete-fund-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc muốn xoá thu chi này ?</h5>
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
                                    <form action="{{route('family_admin.delete_fund')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" id="delete-fund-id">
                                        <button class="btn btn-sm button-color-template w-100">Đồng ý</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Create fund -->
            <div class="modal fade" id="create-fund-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tạo phiếu thu chi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form id="create-fund-form" action="" method="post" class="row">
                                <div class="form-group col-12">
                                    <label class="d-block" for="">Thành viên</label>
                                    <select style="width: 100%;" class="select-2 input-group w-100" name="user_id" id="">
                                        <option value="">Không có thành viên</option>
                                        @foreach ($users as $user)
                                        <option
                                            value="{{$user->id}}"
                                        >{{$user->full_name}}</option>
                                        @endforeach
                                    </select>
                                    <div><i class="validate_msg text-danger" id="err_user_id"></i></div>
                                </div>
                                <div class="form-group col-12">
                                    <label class="d-block" for="">Sự kiện</label>
                                    <select style="width: 100%;" class="select-2 input-group" name="event_id" id="">
                                        <option value="">Không sự kiện</option>
                                        @foreach ($events as $event)
                                        <option
                                            value="{{$event->id}}"
                                        >{{$event->title}}</option>
                                        @endforeach
                                    </select>
                                    <div><i class="validate_msg text-danger" id="err_event_id"></i></div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="">Mô tả <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                    <div><i class="validate_msg text-danger" id="err_description"></i></div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="">Ngày tạo <span class="text-danger">*</span></label>
                                    <input autocomplete="off" type="text" class="form-control" name="date" value="">
                                    <div><i class="validate_msg text-danger" id="err_date"></i></div>
                                </div>

                                <div class="form-group col-12">
                                    <label for="">Loại thu chi <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center">
                                        <div class="item pr-3">
                                            <label for="collect">Thu</label>
                                            <input type="radio" id="collect" value="1" name="fund_type">
                                        </div>
                                        <div class="item">
                                            <label for="spend">Chi</label>
                                            <input type="radio" id="spend" value="2" name="fund_type">
                                        </div>
                                    </div>
                                    <div><i class="validate_msg text-danger" id="err_fund_type"></i></div>
                                </div>

                                <div class="form-group col-12">
                                    <label for="">Ảnh minh chứng</label>
                                    <label for="create-fund-file" class="preview-image cursor-pointer d-block">
                                        <img class="img-cover" src="img/fixed/default_blog.png" alt="">
                                        <input
                                            id="create-fund-file"
                                            type="file"
                                            class="d-none input-fund-file"
                                            accept="image/*"
                                            name="proof"
                                        >
                                        <button class="btn-remove d-none"><i class="fas fa-times"></i></button>
                                    </label>
                                    <div><i class="validate_msg text-danger" id="err_proof"></i></div>
                                </div>
                                
                                <div class="col-6 text-center">
                                    <button class="btn btn-sm btn-secondary w-100" data-dismiss="modal">Hủy</button>
                                </div>
                                <div class="col-6 text-center">
                                    <button id="create-fund" class="btn btn-sm button-color-template w-100">Tạo</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit fund -->
            <div class="modal fade" id="edit-fund-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sửa phiếu thu chi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form id="edit-fund-form" action="" method="post" class="row">
                                <input type="hidden" name="id" value="" id="id">
                                <input type="hidden" id="is_del_proof" name="is_del_proof" value="0">
                                <div class="form-group col-12">
                                    <label for="">Mô tả <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control" rows="3" id="description"></textarea>
                                    <div><i class="validate_msg text-danger" id="edit_err_description"></i></div>
                                </div>

                                <div class="form-group col-12">
                                    <label class="d-block" for="">Sự kiện</label>
                                    <select style="width: 100%;" class="select-2 input-group" name="event_id" id="fund_event">
                                        <option value="">Không sự kiện</option>
                                        @foreach ($events as $event)
                                        <option
                                            value="{{$event->id}}"
                                        >{{$event->title}}</option>
                                        @endforeach
                                    </select>
                                    <div><i class="validate_msg text-danger" id="edit_err_event_id"></i></div>
                                </div>

                                <div class="form-group col-12">
                                    <label for="">Ngày tạo <span class="text-danger">(*)</span></label>
                                    <input autocomplete="off" type="text" class="form-control" name="date" value="" id="date_edit">
                                    <div><i class="validate_msg text-danger" id="err_date"></i></div>
                                </div>

                                <div class="form-group col-12">
                                    <label for="">Loại thu chi <span class="text-danger">(*)</span></label>
                                    <div class="d-flex align-items-center">
                                        <div class="item pr-3">
                                            <label for="collect_edit">Thu</label>
                                            <input type="radio" id="collect_edit" value="1" name="fund_type">
                                        </div>
                                        <div class="item">
                                            <label for="spend_edit">Chi</label>
                                            <input class="fund_type" type="radio" id="spend_edit" value="2" name="fund_type">
                                        </div>
                                    </div>
                                    <div><i class="validate_msg text-danger" id="edit_err_fund_type"></i></div>
                                </div>

                                <div class="form-group col-12">
                                    <label for="">Ảnh minh chứng</label>
                                    <label for="edit-fund-file" class="preview-image cursor-pointer d-block">
                                        <img id="edit-fund-preview" class="img-cover" src="img/fixed/default_blog.png" alt="">
                                        <input
                                            id="edit-fund-file"
                                            type="file"
                                            class="d-none input-fund-file"
                                            accept="image/*"
                                            name="proof"
                                        >
                                        <button class="btn-remove d-none"><i class="fas fa-times"></i></button>
                                    </label>
                                    <div><i class="validate_msg text-danger" id="err_proof"></i></div>
                                </div>
                                
                                <div class="col-6 text-center">
                                    <button class="btn btn-sm btn-secondary w-100" data-dismiss="modal">Hủy</button>
                                </div>
                                <div class="col-6 text-center">
                                    <button id="edit-fund" class="btn btn-sm btn-success w-100">Cập nhật</button>
                                </div>
                            </form>
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
        $( "[name=date]" ).datepicker({
            dayNamesMin: [ "T2", "T3", "T4", "T5", "T6", "T7", "CN" ],
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            dateFormat: "yy-mm-dd",
        });
        $('.delete-fund').click(function(){
            $('#delete-fund-id').val($(this).attr('data-id'));
        });

        $('#create-fund').click(function(e){
            e.preventDefault();
            let formData = new FormData($('#create-fund-form')[0]);
            $.ajax({
                url: "{{ route('family_admin.create_fund') }}",
                type: 'POST',
                data: formData,
                cache : false,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('html').scrollTop(0);
                    $('.validate_msg').html("");
                    if (data.status == false) {
                        let resp = data.errors;
                        for (index in resp) {
                            $("#err_" + index).html(resp[index]);
                            console.log(index);
                        }
                    } else {
                        location.reload();
                    }
                }
            });
        });

        $('#edit-fund').click(function(e){
            e.preventDefault();
            let formData = new FormData($('#edit-fund-form')[0]);
            $.ajax({
                url: "{{ route('family_admin.edit_fund') }}",
                type: 'POST',
                data: formData,
                cache : false,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('html').scrollTop(0);
                    $('.validate_msg').html("");
                    if (data.status == false) {
                        let resp = data.errors;
                        for (index in resp) {
                            $("#edit_err_" + index).html(resp[index]);
                            console.log(index);
                        }
                    } else {
                        location.reload();
                    }
                }
            });
        });

        $('.change-status').change(function(e){
            $.ajax({
                url: "{{ route('family_admin.fund_status') }}",
                type: 'POST',
                data: {
                    id : $(this).attr('data-id'),
                    status : $(this).val(),
                },
                success: function(data) {
                }
            });
        });

        $('.edit-fund').click(function(){
            $('#id').val($(this).attr('data-id'));
            $("#fund_user").select2("val", $(this).attr('data-user_id'));
            $("#fund_event").select2("val", $(this).attr('data-event_id'));
            $('#description').val($(this).attr('data-description'));
            $('#date_edit').val($(this).attr('data-date'));
            let proofImg = $(this).attr('data-proof');

            if (proofImg) {
                $('#edit-fund-preview').attr('src', proofImg);
                $('#edit-fund-modal').find('.btn-remove').removeClass('d-none');
            } else {
                $('#edit-fund-preview').attr('src', 'img/fixed/default_blog.png');
                $('#edit-fund-modal').find('.btn-remove').addClass('d-none');
            }
            

            if ($(this).attr('data-fund_type') == 1) {
                $('#collect_edit').prop('checked', true);
            } else {
                $('#spend_edit').prop('checked', true);
            }
        });

        $('.input-fund-file').change(function(e){
            let file = e.target.files[0];
            let url = 'img/fixed/default_blog.png';
            let label = $(this).closest('label');
            if (file) {
                url = URL.createObjectURL(file);
            }

            label.find('img').attr('src', url);
            label.find('.btn-remove').removeClass('d-none');
        });

        $('.btn-remove').click(function(e){
            e.preventDefault();
            let label = $(this).closest('label');
            label.find('input').val('');
            label.find('img').attr('src', 'img/fixed/default_blog.png');
            $(this).addClass('d-none');
        });

        let editFundModal = $('#edit-fund-modal');
        editFundModal.find('.btn-remove').click(function(){
            editFundModal.find('#is_del_proof').val(1);
        });
    </script>
</div>
@endsection