@extends('family_member.desktop.main')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/js-datepicker/dist/datepicker.min.css">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<div class="row mypage">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                <div class="head">
                    <div class="left image">
                        <label for="avatar">
                            <div class="wrap-avatar">
                                <img
                                    @if ($myInfo->avatar)
                                    src="{{route('get_avatar_image', $myInfo->avatar)}}"
                                    @else
                                    src="img/fixed/default_avatar_1.png"
                                    @endif
                                    alt=""
                                    loading="lazy"
                                >
                                <div class="edit"><i class="fas fa-pen"></i></div>
                                <div
                                    @if ($myInfo->avatar)
                                    class="btn-remove"
                                    @else
                                    class="btn-remove d-none"
                                    @endif                                    
                                ><i class="fas fa-times"></i></div>
                            </div>
                        </label>
                        <input type="file" class="hide" id="avatar" name="avatar">
                    </div>
                    <div class="right">
                        <div class="wrap-input wrap-input-full-name">
                            <div class="wrap-input-group">
                                <input name="full_name" type="text" class="label border-focus" value="{{$myInfo->full_name}}" spellcheck="false">
                            </div>
                            <div class="edit-small"><i class="fas fa-pen"></i></div>
                        </div>
                        <div class="wrap-input">
                            <div class="wrap-input-group">
                                <input name="role_name" type="text" class="label" value="{{$myInfo->role_name}}" spellcheck="false">
                            </div>
                            <div class="edit-small"><i class="fas fa-pen"></i></div>
                        </div>
                        <div class="wrap-input wrap-all-birthday">
                            <span>Sinh nhật: </span>
                            <div class="d-flex align-items-center wrap-birthday">
                                <input name="born_day" type="text" class="input-birthday" value="{{$myInfo->born_day}}" maxlength="2">
                                <span class="divide">/</span>
                                <input name="born_month" type="text" class="input-birthday" value="{{$myInfo->born_month}}" maxlength="2">
                                <span class="divide">/</span>
                                <input name="born_year" type="text" class="input-birthday" value="{{$myInfo->born_year}}" maxlength="4">
                            </div>
                            <div class="edit-small"><i class="fas fa-pen"></i></div>
                        </div>
                    </div>
                </div>
                <b class="d-block title-info pt-2 pb-2">Thông tin chung</b>
                <div class="wrap-input mb-3">
                    <b class="label-left"><span class="icon"><i class="fal fa-envelope"></i></span> Email:</b>
                    <input disabled type="text" class="label" value="{{$myInfo->email}}">
                </div>
                <div class="wrap-input mb-3">
                    <b class="label-left"><span class="icon"><i class="fas fa-mobile-alt"></i></span> ĐT:</b>
                    <span class="wrap-input-group">
                        <input name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" type="text" class="label" value="{{$myInfo->phone}}" spellcheck="false">
                    </span>
                    <div class="edit-small"><i class="fas fa-pen"></i></div>
                </div>
                <div class="wrap-input mb-3">
                    <b class="label-left"><span class="icon"><i class="fas fa-map-marked"></i></span> Địa chỉ:</b>
                    <span class="wrap-input-group">
                        <input name="address" type="text" class="label" value="{{$myInfo->address}}" spellcheck="false">
                    </span>
                    <div class="edit-small"><i class="fas fa-pen"></i></div>
                </div>
                <div class="wrap-input mb-3">
                    <b class="label-left"><span class="icon"><i class="far fa-address-card"></i></span> Nguyên quán:</b>
                    <span class="wrap-input-group">
                        <input name="domicile" type="text" class="label" value="{{$myInfo->domicile}}" spellcheck="false">
                    </span>
                    <div class="edit-small"><i class="fas fa-pen"></i></div>
                </div>
                <div class="wrap-input mb-3">
                    <b class="label-left"><span class="icon"><i class="far fa-id-card"></i></span> Căn cước:</b>
                    <span class="wrap-input-group">
                        <input name="cccd_number" type="text" class="label" value="{{$myInfo->cccd_number}}" spellcheck="false">
                    </span>
                    <div class="edit-small"><i class="fas fa-pen"></i></div>
                </div>
                <div class="wrap-cccd-imgs">
                    <div class="wrap-cccd-img image">
                        <div
                            @if ($myInfo->userInfo->cccd_image_before)
                            class="remove-cccd-image-btn"
                            @else
                            class="remove-cccd-image-btn d-none"
                            @endif
                            class="remove-cccd-image-btn"
                            data-field="cccd_image_before"
                        ><i class="far fa-times"></i></div>
                        <label for="cccd_image_before">
                            <img
                                @if ($myInfo->userInfo->cccd_image_before)
                                src="{{route('get_cccd_image', $myInfo->userInfo->cccd_image_before)}}"
                                @else
                                src="img/fixed/before_cccd_default.jpg"
                                @endif
                                alt=""
                                loading="lazy"
                            >
                        </label>
                        <input type="file" class="hide" id="cccd_image_before" name="cccd_image_before">
                    </div>
                    <div class="wrap-cccd-img image">
                        <div
                            @if ($myInfo->userInfo->cccd_image_after)
                            class="remove-cccd-image-btn"
                            @else
                            class="remove-cccd-image-btn d-none"
                            @endif
                            data-field="cccd_image_after"
                        ><i class="far fa-times"></i></div>
                        <label for="cccd_image_after">
                            <img
                                @if ($myInfo->userInfo->cccd_image_after)
                                src="{{route('get_cccd_image', $myInfo->userInfo->cccd_image_after)}}"
                                @else
                                src="img/fixed/after_cccd_default.jpg"
                                @endif
                                alt=""
                                loading="lazy"
                            >
                        </label>
                        <input type="file" class="hide" id="cccd_image_after" name="cccd_image_after">
                    </div>
                </div>
        
                <b class="d-block title-info pt-2 pb-2">Thông tin khác</b>
                <div class="wrap-input mb-3">
                    <b class="label-left"><span class="icon"><i class="fas fa-briefcase"></i></span> Nghề nghiệp:</b>
                    <span class="wrap-input-group">
                        <input name="job" type="text" class="label" value="{{$myInfo->userInfo->job}}" spellcheck="false">
                    </span>
                    <div class="edit-small"><i class="fas fa-pen"></i></div>
                </div>
                <div class="wrap-input mb-3">
                    <b class="label-left"><span class="icon"><i class="fas fa-user-tag"></i></span> Chức vụ:</b>
                    <span class="wrap-input-group">
                        <input name="position" type="text" class="label" value="{{$myInfo->userInfo->position}}" spellcheck="false">
                    </span>
                    <div class="edit-small"><i class="fas fa-pen"></i></div>
                </div>
                <div class="wrap-input mb-3">
                    <b class="label-left"><span class="icon"><i class="fas fa-building"></i></span> Tổ chức:</b>
                    <span class="wrap-input-group">
                        <input name="organization" type="text" class="label" value="{{$myInfo->userInfo->organization}}" spellcheck="false">
                    </span>
                    <div class="edit-small"><i class="fas fa-pen"></i></div>
                </div>
                <div class="wrap-input mb-3">
                    <b class="label-left"><span class="icon"><i class="fas fa-tombstone-alt"></i></span> Nơi an nghỉ:</b>
                    <span class="wrap-input-group">
                        <input name="rest_place" type="text" class="label" value="{{$myInfo->userInfo->rest_place}}" spellcheck="false">
                    </span>
                    <div class="edit-small"><i class="fas fa-pen"></i></div>
                </div>
        
                <b class="d-block title-info pt-2 pb-2">HÌNH ẢNH CHỨNG CHỈ</b>
                <div class="wrap-image-list cert-images">
                    @php
                        $cert_images = [];
                        if ($myInfo->userInfo->cert_images) {
                            $cert_images = explode(',', $myInfo->userInfo->cert_images);
                        }
                    @endphp
                    @foreach ($cert_images as $image)
                    <div data-image-name="{{$image}}" class="wrap-image-main">
                        <div class="item-image">
                            <img src="{{route('get_cert_image', $image)}}" alt="" loading="lazy">
                        </div>
                        <div class="remove"><i class="far fa-times"></i></div>
                    </div>
                    @endforeach
                    <label for="cert-image-input" class="add-more-image add-more-cert">
                        <i class="far fa-plus"></i>
                    </label>
                </div>
                <input class="hide" type="file" id="cert-image-input" name="cert_image" accept="image/*">
        
                <b class="d-block title-info pt-2 pb-2">HÌNH ẢNH AN NGHỈ</b>
                <div class="wrap-image-list rest-images">
                    @php
                        $rest_images = [];
                        if ($myInfo->userInfo->rest_images) {
                            $rest_images = explode(',', $myInfo->userInfo->rest_images);
                        }
                    @endphp
                    @foreach ($rest_images as $image)
                    <div data-image-name="{{$image}}" class="wrap-image-main">
                        <div class="item-image">
                            <img src="{{route('get_rest_image', $image)}}" alt="" loading="lazy">
                        </div>
                        <div class="remove"><i class="far fa-times"></i></div>
                    </div>
                    @endforeach
                    <label for="rest-image-input" class="add-more-image add-more-rest">
                        <i class="far fa-plus"></i>
                    </label>
                </div>
                <input class="hide" type="file" id="rest-image-input" name="rest_image" accept="image/*">
            </div>
        </div>
    </div>
</div>
<!-- Modal delete cert image -->
<div class="modal fade" id="delete-cert-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc muốn xoá ảnh này ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 text-center">
                        <button class="btn btn-sm btn-secondary w-100" data-bs-dismiss="modal">Không</button>
                    </div>
                    <div class="col-6 text-center">
                        <button id="confirm-delete-cert" class="btn btn-sm btn-success w-100">Đồng ý</button>
                        <input type="hidden" id="cert-image-name">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal delete rest image -->
<div class="modal fade" id="delete-rest-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc muốn xoá ảnh này ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 text-center">
                        <button class="btn btn-sm btn-secondary w-100" data-bs-dismiss="modal">Không</button>
                    </div>
                    <div class="col-6 text-center">
                        <button id="confirm-delete-rest" class="btn btn-sm btn-success w-100">Đồng ý</button>
                        <input type="hidden" id="rest-image-name">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://unpkg.com/js-datepicker"></script>
<script>
    if(!alertify.myAlert){
        //define a new dialog
        alertify.dialog('myAlert',function(){
            return{
            main:function(message){
                this.message = message;
            },
            setup:function(){
                return { 
                    buttons:[{text: "cool!", key:27/*Esc*/}],
                    focus: { element:0 }
                };
            },
            prepare:function(){
                this.setContent(this.message);
            }
        }});
    }
    $('.wrap-input').find('input').change(function(){
        let name = $(this).attr('name');
        let value = $(this).val();
        let formData = new FormData();
        formData.append(name, value);
        $.ajax({
            url: "{{ route('family_member.update_profile') }}",
            type: 'POST',
            data: formData,
            cache : false,
            processData: false,
            contentType: false,
            success: function(data, textStatus, xhr) {
                console.log(data.errors);
                if (data.status == false) {
                    alertify.error(data.errors[name][0]);
                }
            },
        });
    });

    let birthday = '{{$myInfo->birthday}}';
    let leaveday = '{{$myInfo->userInfo->leaveday ?? "1970-01-01"}}';
    

    // Handle cert images
    let _thisCertRemover = null;
    $('.cert-images').on('click', '.remove', function(){
        _thisCertRemover = $(this);
        let imageName = _thisCertRemover.closest('.wrap-image-main').attr('data-image-name');
        $('#cert-image-name').val(imageName);
        $('#delete-cert-modal').modal('show');
    });

    $('#confirm-delete-cert').click(function(){
        $.ajax({
            url: "{{ route('family_member.remove_cert_image') }}",
            type: 'POST',
            data: {
                cert_image : $('#cert-image-name').val()
            },
            success: function(data) {
                $('#delete-cert-modal').modal('hide');
                _thisCertRemover.closest('.wrap-image-main').remove();
            }
        });
    });

    $('#cert-image-input').change(function(e){
        if (e.target.files[0] != undefined) {
            let formData = new FormData();
            formData.append('cert_image', e.target.files[0]);
            let url = URL.createObjectURL(e.target.files[0]);
            $('.add-more-cert').remove();

            $.ajax({
                url: "{{ route('family_member.add_cert_image') }}",
                type: 'POST',
                data: formData,
                cache : false,
                processData: false,
                contentType: false,
                success: function(data) {
                    let domItem = `
                    <div data-image-name="${data.messages.cert_image}" class="wrap-image-main">
                        <div class="item-image">
                            <img src="${url}" alt="">
                        </div>
                        <div class="remove"><i class="far fa-times"></i></div>
                    </div>
                    <label for="cert-image-input" class="add-more-image add-more-cert">
                        <i class="far fa-plus"></i>
                    </label>
                    `;
                    $('.cert-images').append(domItem);
                }
            });
        }
    });

    // Handle rest images
    let _thisRestRemover = null;
    $('.rest-images').on('click', '.remove', function(){
        _thisRestRemover = $(this);
        let imageName = _thisRestRemover.closest('.wrap-image-main').attr('data-image-name');
        $('#rest-image-name').val(imageName);
        $('#delete-rest-modal').modal('show');
    });

    $('#confirm-delete-rest').click(function(){
        $.ajax({
            url: "{{ route('family_member.remove_rest_image') }}",
            type: 'POST',
            data: {
                rest_image : $('#rest-image-name').val()
            },
            success: function(data) {
                $('#delete-rest-modal').modal('hide');
                _thisRestRemover.closest('.wrap-image-main').remove();
            }
        });
    });

    $('#rest-image-input').change(function(e){
        if (e.target.files[0] != undefined) {
            let formData = new FormData();
            formData.append('rest_image', e.target.files[0]);
            let url = URL.createObjectURL(e.target.files[0]);
            $('.add-more-rest').remove();

            $.ajax({
                url: "{{ route('family_member.add_rest_image') }}",
                type: 'POST',
                data: formData,
                cache : false,
                processData: false,
                contentType: false,
                success: function(data) {
                    let domItem = `
                    <div data-image-name="${data.messages.rest_image}" class="wrap-image-main">
                        <div class="item-image">
                            <img src="${url}" alt="">
                        </div>
                        <div class="remove"><i class="far fa-times"></i></div>
                    </div>
                    <label for="rest-image-input" class="add-more-image add-more-rest">
                        <i class="far fa-plus"></i>
                    </label>
                    `;
                    $('.rest-images').append(domItem);
                }
            });
        }
    });

    // Remove avatar
    $('.wrap-avatar .btn-remove').click(function(e){
        e.preventDefault();
        $('.wrap-avatar').find('img').attr('src', 'img/fixed/default_avatar_1.png');
        $(this).addClass('d-none');
        let formData = new FormData();
        formData.append('del_avatar', '1');

        $.ajax({
            url: "{{ route('family_member.update_profile') }}",
            type: 'POST',
            data: formData,
            cache : false,
            processData: false,
            contentType: false,
            success: function(data, textStatus, xhr) {
                console.log(data.errors);
                if (data.status == false) {
                    alertify.error(data.errors[name][0]);
                }
            },
        });
    });

    // Handle image avatar, cccd
    $('#avatar, #cccd_image_before, #cccd_image_after').change(function(e){
        let file = e.target.files[0];
        let name = $(this).attr('name');
        let src = URL.createObjectURL(file);
        $(this).closest('.image').find('img').attr('src', src);
        $(this).closest('div').find('.btn-remove, .remove-cccd-image-btn').removeClass('d-none');
        $(this).val('');
        let formData = new FormData();
        formData.append(name, file);

        $.ajax({
            url: "{{ route('family_member.update_profile') }}",
            type: 'POST',
            data: formData,
            cache : false,
            processData: false,
            contentType: false,
            success: function(data, textStatus, xhr) {
                console.log(data.errors);
                if (data.status == false) {
                    alertify.error(data.errors[name][0]);
                }
            },
        });
    });

    // Remove CCCD
    $('.remove-cccd-image-btn').click(function(){
        let field = $(this).attr('data-field');
        let _this = $(this);
        if (field == 'cccd_image_before') {
            _this.closest('.wrap-cccd-img').find('img').attr('src', 'img/fixed/before_cccd_default.jpg');
        } else {
            _this.closest('.wrap-cccd-img').find('img').attr('src', 'img/fixed/after_cccd_default.jpg');
        }
        _this.addClass('d-none');
        $.ajax({
            url: "{{route('family_member.remove_cccd_image')}}",
            type: 'POST',
            data: {
                field : field,
            },
            success: function(data, textStatus, xhr) {
            },
        });
    });
</script>
@endsection