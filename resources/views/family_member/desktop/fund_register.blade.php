@extends('family_member.desktop.main')
@section('content')
<!-- Date picker -->
<link rel="stylesheet" href="https://unpkg.com/js-datepicker/dist/datepicker.min.css">
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Alert -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<div class="row fund-register">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                <form id="event-register-form" class="container-fluid">
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
                        <label>Ảnh minh chứng</label>
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
                    <div class="text-center">
                        <button id="register" class="btn button-color-template w-25">Đăng ký</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Datepicker -->
<script src="https://unpkg.com/js-datepicker"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Alert -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', function(){
        handleDatePicker('#date', '#date-post');
    });

    $('#register').click(function(e){
        e.preventDefault();
        let registerForm = $('#event-register-form');
        let formData = new FormData(registerForm[0]);

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
                    registerForm.find('input, textarea').val("");
                    registerForm.find('img').attr('src', 'img/fixed/default_blog.png');
                    registerForm.find('.btn-remove').addClass('d-none');
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
</script>
@endsection