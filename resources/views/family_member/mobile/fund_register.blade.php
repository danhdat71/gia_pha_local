@extends('family_member.main')
@section('content')
<!-- Alert -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<div class="root-content fund-register">
    <form id="event-register-form" class="container-fluid">
        <div class="col-md-12">
            <h4 class="text-center pt-3 pb-2 text-uppercase">Đăng ký quỹ</h4>
        </div>
        <div class="form-group">
            <label for="fund_type">Loại thu chi <span class="text-danger">(*)</span></label>
            <select name="fund_type" id="fund_type" class="form-control">
                @foreach(App\Constants\Fund::FUND_TYPE as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
            <i class="text-danger text-small d-block pt-1 err_msg" id="err_fund_type"></i>
        </div>
        <div class="form-group">
            <label for="event_id">Sự kiện</label>
            <select name="event_id" id="event_id" class="select-2 w-100 input-group">
                <option value="">Không theo sự kiện</option>
                @foreach($events as $event)
                <option value="{{$event->id}}">{{$event->title}}</option>
                @endforeach
            </select>
            <i class="text-danger text-small d-block pt-1 err_msg" id="err_event_id"></i>
        </div>
        <div class="form-group">
            <label for="date">Thời điểm <span class="text-danger">(*)</span></label>
            <input id="date" type="text" class="date form-control" autocomplete="off" />
            <input type="hidden" name="date" id="date-post">
            <i class="text-danger text-small d-block pt-1 err_msg" id="err_date"></i>
        </div>
        <div class="form-group">
            <label for="description">Mô tả <span class="text-danger">(*)</span></label>
            <textarea name="description" class="form-control" rows="5"></textarea>
            <i class="text-danger text-small d-block pt-1 err_msg" id="err_description"></i>
        </div>
        <div class="form-group">
            <label for="description">Ảnh minh chứng</label>
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
        <div class="row">
            <div class="col-4">
                <a href="{{route('family_member.profile_index')}}" class="btn btn-secondary w-100"><i class="far fa-long-arrow-left"></i> Trở lại</a>
            </div>
            <div class="col-8">
                <button id="register" class="btn button-color-template w-100">Đăng ký</button>
            </div>
        </div>
    </form>
</div>
<!-- Alert -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>

    window.addEventListener('DOMContentLoaded', function(){
        handleDatePicker('#date', '#date-post', 'bl');
    });

    $('#register').click(function(e){
        e.preventDefault();
        let formRegister = $('#event-register-form');
        let formData = new FormData(formRegister[0]);

        $.ajax({
            url: "{{ route('family_member.fund_register') }}",
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
                    formRegister.find('input, textarea').val("");
                    formRegister.find('img').attr('src', 'img/fixed/default_blog.png');
                    formRegister.find('.btn-remove').addClass('d-none');
                }
            },
        });
    });

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }

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
</script>
@stop