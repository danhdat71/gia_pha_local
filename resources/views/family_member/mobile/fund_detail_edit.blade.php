@extends('family_member.main')
@section('content')
<div class="root-content fund-detail-edit">
    <form id="update-fund-form" class="container-fluid">
        <input type="hidden" name="id" value="{{$fund->id}}">
        <input type="hidden" name="is_del_proof" id="is_del_proof" value="0">
        <div class="col-md-12">
            <h4 class="text-center pt-3 pb-2 text-uppercase">Chi tiết quỹ</h4>
        </div>
        <div class="form-group">
            <label for="fund_type">Loại thu chi <span class="text-danger">(*)</span></label>
            <select
                name="fund_type"
                id="fund_type"
                class="form-control"
                @if ($fund->status == App\Constants\Fund::FUND_OK)
                disabled
                @endif
            >
                @foreach(App\Constants\Fund::FUND_TYPE as $key => $value)
                <option
                    value="{{$key}}"
                    @if ($key == $fund->fund_type)
                    selected
                    @endif
                >{{$value}}</option>
                @endforeach
            </select>
            <i class="text-danger text-small d-block pt-1 err_msg" id="err_fund_type"></i>
        </div>
        <div class="form-group">
            <label for="event_id">Sự kiện</label>
            <select
                name="event_id"
                id="event_id"
                class="select-2 w-100 input-group"
                @if ($fund->status == App\Constants\Fund::FUND_OK)
                disabled
                @endif
            >
                <option value="">Không theo sự kiện</option>
                @foreach($events as $event)
                <option
                    value="{{$event->id}}"
                    @if ($fund->event_id == $event->id)
                    selected
                    @endif
                >{{$event->title}}</option>
                @endforeach
            </select>
            <i class="text-danger text-small d-block pt-1 err_msg" id="err_event_id"></i>
        </div>
        <div class="form-group">
            <label for="date">Thời điểm <span class="text-danger">(*)</span></label>
            <input
                id="date"
                type="text"
                class="date form-control"
                autocomplete="off"
                value="{{date('d-m-Y', strtotime($fund->date))}}"
                @if ($fund->status == App\Constants\Fund::FUND_OK)
                disabled
                @endif
            />
            <input type="hidden" name="date" id="date-post" value="{{$fund->date}}">
            <i class="text-danger text-small d-block pt-1 err_msg" id="err_date"></i>
        </div>
        <div class="form-group">
            <label for="description">Mô tả <span class="text-danger">(*)</span></label>
            <textarea
                name="description"
                class="form-control"
                rows="5"
                @if ($fund->status == App\Constants\Fund::FUND_OK)
                disabled
                @endif
            >{{$fund->description}}</textarea>
            <i class="text-danger text-small d-block pt-1 err_msg" id="err_description"></i>
        </div>
        <div class="form-group">
            <label for="description">Ảnh minh chứng</label>
            @if ($fund->status != App\Constants\Fund::FUND_OK)
            <label
                for="edit-fund-file"
                class="preview-image cursor-pointer d-block"
            >
                <img
                    id="edit-fund-preview"
                    class="img-cover"
                    @if ($fund->proof)
                    src="{{route('get_proof', $fund->proof)}}"
                    @else
                    src="img/fixed/default_blog.png"
                    @endif
                    alt=""
                >
                <input
                    id="edit-fund-file"
                    type="file"
                    class="d-none input-fund-file"
                    accept="image/*"
                    name="proof"
                >
                <button
                    @if ($fund->proof)
                    class="btn-remove"
                    @else
                    class="btn-remove d-none"
                    @endif
                ><i class="fas fa-times"></i></button>
            </label>
            <div><i class="validate_msg text-danger" id="err_proof"></i></div>
            @else
            <div class="preview-image cursor-pointer d-block">
                <img
                    id="edit-fund-preview"
                    class="img-cover"
                    @if ($fund->proof)
                    src="{{route('get_proof', $fund->proof)}}"
                    @else
                    src="img/fixed/default_blog.png"
                    @endif
                    alt=""
                >
            </div>
            @endif
        </div>
    </form>
    <div class="container-fluid">
        <div class="row pt-3">
            <div class="col-4">
                <a href="{{route('family_member.funds')}}" class="btn btn-secondary w-100"><i class="far fa-long-arrow-left"></i> Quay lại</a>
            </div>
            @if ($fund->status != App\Constants\Fund::FUND_OK)
            <div class="col-3">
                <form action="{{route('family_member.fund_delete')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$fund->id}}">
                    <button href="{{route('family_member.fund_delete')}}" class="btn text-danger w-100">Xóa</button>
                </form>
            </div>
            <div class="col-5">
                <button id="update" class="btn button-color-template w-100">Cập nhật</button>
            </div>
            @endif
        </div>
    </div>
</div>
<script>
    window.addEventListener('DOMContentLoaded', function(){
        handleDatePicker('#date', '#date-post', 'bl');
    });

    let updateFundForm = $('#update-fund-form');

    $('#update').click(function(e){
        e.preventDefault();
        let formData = new FormData(updateFundForm[0]);

        $.ajax({
            url: "{{ route('family_member.fund_update') }}",
            type: 'POST',
            data: formData,
            cache : false,
            processData: false,
            contentType: false,
            success: function(data, textStatus, xhr) {
                $('html').scrollTop(0);
                $('.err_msg').html("");
                if (data.status == false) {
                    let resp = data.errors;
                    for (index in resp) {
                        $("#err_" + index).html(resp[index]);
                        console.log(index);
                    }
                } else {
                    alertify.success(data.messages);
                }
            },
        });
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

    updateFundForm.find('.btn-remove').click(function(){
        updateFundForm.find('#is_del_proof').val(1);
    });
</script>
@stop