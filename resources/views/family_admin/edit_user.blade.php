@extends('family_admin.main')
@section('content')
<div class="content-wrapper">
    @include('global.content_head', [
        'title' => 'Sửa thông tin của ' . $member->full_name
    ])
    <section class="content">
        <style>
            .wrap-input-avatar {
                position: relative;
                width: 150px;
                height: 150px;
            }

            .wrap-input-avatar input,
            .wrap-input-avatar img {
                position: absolute;
                width: 100%;
                height: 100%;
            }

            .wrap-input-avatar img {
                object-fit: cover;
            }

            .wrap-input-avatar input {
                z-index: 2;
                opacity: 0;
            }

            .btn-remove {
                width: 25px;
                height: 25px;
                background: red;
                position: absolute;
                right: 0;
                top: 0;
                transform: translate(50%, -50%);
                font-size: 13px;
                display: flex;
                justify-content: center;
                align-items: center;
                color: white;
                border-radius: 999px;
                cursor: pointer;
            }

            .wrap-rest-images,
            .wrap-cert-images {
                display: flex;
                flex-wrap: wrap;
                padding: 10px 0;
            }

            .wrap-rest-images .wrap-img,
            .wrap-cert-images .wrap-img {
                float: left;
                width: 200px;
                height: 150px;
                overflow: hidden;
                margin: 5px;
                position: relative;
                cursor: pointer;
            }

            .wrap-rest-images .wrap-img img,
            .wrap-cert-images .wrap-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .wrap-rest-images .wrap-img:hover span,
            .wrap-cert-images .wrap-img:hover span {
                transform: translateY(0%);
            }

            .wrap-rest-images .wrap-img span,
            .wrap-cert-images .wrap-img span {
                display: inline-block;
                position: absolute;
                text-align: center;
                bottom: 0;
                left: 0;
                color: white;
                padding: 5px 0;
                width: 100%;
                background: rgba(255, 0, 0, 0.555);
                cursor: pointer;
                transform: translateY(100%);
                cursor: pointer;
            }
        </style>
        <form id="user-update" class="container-fluid" action="{{route('family_admin.edit_user')}}" method="post" enctype="multipart/form-data">
            @csrf
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="row">  
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><b>Thông tin chung</b></div>
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="id" value="{{$member->id}}">
                                <div class="form-group col-md-6">
                                    <label for="full_name">Họ tên <span class="text-danger">(*)</span></label>
                                    <input class="form-control" type="text" name="full_name" id="full_name" value="{{$member->full_name}}">
                                    <i class="text-danger validate_msg" id="err_full_name"></i>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="role_name">Tên vai trò <span class="text-danger">(*)</span></label>
                                    <input class="form-control" type="text" name="role_name" id="role_name" value="{{$member->role_name}}">
                                    <i class="text-danger validate_msg" id="err_role_name"></i>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="avatar">Ảnh đại diện</label>
                                    <div class="wrap-input-avatar">
                                        <input class="form-control" type="file" name="avatar" id="avatar" accept="image/*">
                                        <input type="hidden" name="avatar_name" id="avatar_name" value="{{$member->avatar}}">
                                        <img
                                            @if ($member->avatar)
                                            src="{{route('get_avatar_image', $member->avatar)}}"
                                            @else
                                            src="img/fixed/default_avatar.png"
                                            @endif
                                            alt="avatar_name"
                                        />
                                        <div
                                            @if ($member->avatar)
                                            class="btn-remove"
                                            @else
                                            class="btn-remove d-none"
                                            @endif
                                        ><i class="fas fa-times"></i></div>
                                    </div>
                                    <i class="text-danger validate_msg" id="err_avatar"></i>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="born_day">Ngày sinh</label>
                                            <input id="born_day" type="text" class="form-control" name="born_day" maxlength="2" value="{{old('born_day', $member->born_day)}}">
                                            @error("born_day")
                                                <div><i class="text-danger">{{ $message }}</i></div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="born_month">Tháng sinh</label>
                                            <input id="born_month" type="text" class="form-control" name="born_month" maxlength="2" value="{{old('born_month', $member->born_month)}}">
                                            @error("born_month")
                                                <div><i class="text-danger">{{ $message }}</i></div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="born_year">Năm sinh</label>
                                            <input type="text" class="form-control" name="born_year" id="born_year" maxlength="4" value="{{old('born_year', $member->born_year)}}">
                                            @error("born_year")
                                                <div><i class="text-danger">{{ $message }}</i></div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Địa chỉ</label>
                                    <input class="form-control" type="text" name="address" id="address" value="{{old('address', $member->address)}}">
                                    <i class="text-danger validate_msg" id="err_address"></i>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="domicile">Nguyên quán</label>
                                    <input class="form-control" type="text" name="domicile" id="domicile" value="{{old('domicile', $member->domicile)}}">
                                    <i class="text-danger validate_msg" id="err_domicile"></i>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="phone">Số điện thoại</label>
                                    <input class="form-control" type="text" name="phone" id="phone" value="{{old('phone', $member->phone)}}">
                                    <i class="text-danger validate_msg" id="err_phone"></i>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="cccd_number">Mã căn cước</label>
                                    <input type="text" class="form-control" name="cccd_number" id="cccd_number" value="{{old('cccd_number', $member->cccd_number)}}">
                                    <i class="text-danger validate_msg" id="err_cccd_number"></i>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cccd_image_before">Mặt trước CCCD</label>
                                    <div class="wrap-cccd">
                                        <img
                                            @if (!empty($member->userInfo->cccd_image_before))
                                            src={{route('get_cccd_image', $member->userInfo->cccd_image_before)}}
                                            @else
                                            src="img/fixed/before_cccd_default.jpg"
                                            @endif
                                            alt="before"
                                            class="w-100"
                                        >
                                        <input type="file" class="form-control" name="cccd_image_before" id="cccd_image_before">
                                    </div>
                                    <i class="text-danger validate_msg" id="err_cccd_image_before"></i>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cccd_image_after">Mặt sau CCCD</label>
                                    <div class="wrap-cccd">
                                        <img
                                            @if (!empty($member->userInfo->cccd_image_after))
                                            src={{route('get_cccd_image', $member->userInfo->cccd_image_after)}}
                                            @else
                                            src="img/fixed/after_cccd_default.jpg"
                                            @endif
                                            alt="before"
                                            class="w-100"
                                        >
                                        <input type="file" class="form-control" name="cccd_image_after" id="cccd_image_after">
                                    </div>
                                    <i class="text-danger validate_msg" id="err_cccd_image_after"></i>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="email">Email</label>
                                    <input disabled class="form-control" type="text" id="email" value="{{$member->email}}">
                                    <i class="text-danger validate_msg" id="err_email"></i>
                                </div>
                                @if ( !empty($member->position_index) )
                                <div class="form-group col-md-12 position_index">
                                    <label for="position_index">Thứ tự</label>
                                    <input id="position_index" class="form-control" type="text" name="position_index" id="position_index" value="{{old('position_index', $member->position_index)}}">
                                    <i class="text-danger validate_msg" id="err_position_index"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><b>Thông tin khác</b></div>
                        <div class="card-body row">
                            <div class="col-md-6 form-group">
                                <label for="job">Nghề nghiệp / Chuyên môn</label>
                                <input class="form-control" type="text" name="job" id="job" value="{{old('job', $member->userInfo->job)}}">
                                <i class="text-danger validate_msg" id="err_job"></i>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="position">Chức vụ</label>
                                <input class="form-control" type="text" name="position" id="position" value="{{old('position', $member->userInfo->position)}}">
                                <i class="text-danger validate_msg" id="err_position"></i>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="organization">Cơ quan</label>
                                <input class="form-control" type="text" name="organization" id="organization" value="{{old('organization', $member->userInfo->organization)}}">
                                <i class="text-danger validate_msg" id="err_organization"></i>
                            </div>
                            {{-- <div class="col-md-12 form-group">
                                <label for="cert_images">Chứng chỉ</label>
                                <input
                                    class="form-control"
                                    type="file"
                                    name="cert_images[]"
                                    id="cert_images"
                                    accept="image/*"
                                    multiple
                                >
                                <div class="wrap-certificates">
                                    @if (session('cert_images'))
                                        @foreach(explode(",", session('cert_images')) as $image)
                                            <div class="wrap-img" data-old-name={{$image}}>
                                                <img src="{{route('get_cert_image', $image)}}" alt="{{$image}}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <input
                                    type="hidden"
                                    name="cert_image_names"
                                    @if (session('cert_images'))
                                        value="{{session('cert_images')}}"
                                    @endif
                                >
                                <i class="text-danger validate_msg" id="err_cert_images"></i>
                            </div> --}}
                            <div class="form-group col-md-12">
                                <label for="cert_images">Chứng chỉ</label>
                                <input
                                    class="form-control"
                                    type="file"
                                    name="cert_images[]"
                                    id="cert_images"
                                    accept="image/*"
                                    multiple
                                >
                                <div class="wrap-cert-images">
                                    @if ($member->userInfo->cert_images)
                                        @php
                                            $cert_images = explode(",", $member->userInfo->cert_images);   
                                        @endphp
                                        @foreach($cert_images as $image)
                                            <div class="wrap-img" data-image-name="{{$image}}">
                                                <span><i class="fas fa-trash"></i></span>
                                                <img src="{{route('get_cert_image', $image)}}" alt="{{$image}}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <input
                                    type="hidden"
                                    name="cert_image_names"
                                    value="{{$member->userInfo->cert_images}}"
                                >
                                <input
                                    type="hidden"
                                    name="del_cert_image_names"
                                    id="del_cert_image_names"
                                    value=""
                                >
                                <i class="text-danger validate_msg" id="err_cert_images"></i>
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="leave_day">Ngày mất</label>
                                        <input id="leave_day" type="text" class="form-control" name="leave_day" maxlength="2" value="{{old('leave_day', $member->userInfo->leave_day)}}">
                                        @error("leave_day")
                                            <div><i class="text-danger">{{ $message }}</i></div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="leave_month">Tháng mất</label>
                                        <input id="leave_month" type="text" class="form-control" name="leave_month" maxlength="2" value="{{old('leave_month', $member->userInfo->leave_month)}}">
                                        @error("leave_month")
                                            <div><i class="text-danger">{{ $message }}</i></div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="leave_year">Năm mất</label>
                                        <input type="text" class="form-control" name="leave_year" id="leave_year" maxlength="4" value="{{old('leave_year', $member->userInfo->leave_year)}}">
                                        @error("leave_year")
                                            <div><i class="text-danger">{{ $message }}</i></div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="rest_place">Vị trí an nghỉ</label>
                                <input class="form-control" type="text" name="rest_place" id="rest_place" value="{{old('rest_place', $member->userInfo->rest_place)}}">
                                <i class="text-danger validate_msg" id="err_rest_place"></i>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lat">Latitude</label>
                                <input class="form-control" type="text" name="lat" id="lat" value="{{old('lat', $member->userInfo->lat)}}">
                                <i class="text-danger validate_msg" id="err_lat"></i>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="long">Longitude</label>
                                <input class="form-control" type="text" name="long" id="long" value="{{old('long', $member->userInfo->long)}}">
                                <i class="text-danger validate_msg" id="err_long"></i>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="rest_images">Hỉnh ảnh an nghỉ</label>
                                <input
                                    class="form-control"
                                    type="file"
                                    name="rest_images[]"
                                    id="rest_images"
                                    accept="image/*"
                                    multiple
                                >
                                <div class="wrap-rest-images">
                                    @if ($member->userInfo->rest_images)
                                        @php
                                            $rest_images = explode(",", $member->userInfo->rest_images);   
                                        @endphp
                                        @foreach($rest_images as $image)
                                            <div class="wrap-img" data-image-name="{{$image}}">
                                                <span><i class="fas fa-trash"></i></span>
                                                <img src="{{route('get_rest_image', $image)}}" alt="{{$image}}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <input
                                    type="hidden"
                                    name="rest_image_names"
                                    value="{{$member->userInfo->rest_images}}"
                                >
                                <input
                                    type="hidden"
                                    name="del_rest_image_names"
                                    id="del_rest_image_names"
                                    value=""
                                >
                                <i class="text-danger validate_msg" id="err_rest_images"></i>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="video_360_url">3D & VR 360 an nghỉ</label>
                                <div>
                                    <a href="{{route('family_admin.index_video_360', $member->id)}}" class="btn btn-info"><i class="fas fa-vr-cardboard"></i> Video an nghỉ 360</a>
                                    <a href="{{route('family_admin.index_vr_3d', $member->id)}}" class="btn btn-success"><i class="fas fa-door-open"></i> Nơi an nghỉ 3D</a>
                                </div>
                            </div>
                            {{-- <div class="form-group col-md-12">
                                <label for="video_360_url">Video 360 độ</label>
                                <input class="form-control" type="file" name="video_360_url" id="video_360_url" accept="video/*">
                                <input
                                    type="hidden"
                                    name="video_name"
                                    id="video_name"
                                    value="{{$member->userInfo->video_360_url}}"
                                >
                                <div class="wrap-video mt-4 position-relative">
                                    <video
                                        controls
                                        autoplay
                                        @if ($member->userInfo->video_360_url)
                                        src="{{route('get_360_video', $member->userInfo->video_360_url)}}"
                                        class="w-100"
                                        @else
                                        class="d-none w-100"
                                        @endif
                                    >
                                    </video>
                                    
                                    <div
                                        @if($member->userInfo->video_360_url)
                                        class="btn-remove"
                                        @else
                                        class="btn-remove d-none"
                                        @endif
                                    ><i class="fas fa-times"></i></div>
                                </div>
                                <i class="text-danger validate_msg" id="err_avatar"></i>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <b>Thông tin tiểu sử</b>
                        </div>
                        <div class="card-body">
                            <div class="form-group col-md-12">
                                <label for="story">Tiểu sử</label>
                                <textarea name="story" id="story">{{$member->userInfo->story}}</textarea>
                                <i class="text-danger validate_msg" id="err_story"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-right pb-3">
                    <a href="{{route('family_admin.genealogy')}}" class="btn btn-secondary"><i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>
                    <button class="btn button-color-template" id="update">Cập nhật thông tin</button>
                </div>
            </div>
        </form>
    </section>
    <script>
        let editor = CKEDITOR.replace('story', configCkeditor);
        $( "[name=birthday]" ).datepicker({
            dayNamesMin: [ "T2", "T3", "T4", "T5", "T6", "T7", "CN" ],
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            dateFormat: "yy-mm-dd",
        });
        $( "[name=leaveday]" ).datepicker({
            dayNamesMin: [ "T2", "T3", "T4", "T5", "T6", "T7", "CN" ],
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            dateFormat: "yy-mm-dd",
        });

        $('.wrap-input-avatar input').change(function(event) {
            var file = event.target.files[0];
            let url = 'img/fixed/default_avatar.png';
            if (file) {
                url = URL.createObjectURL(file);
            }
            $('.wrap-input-avatar img').attr('src', url);
            $('.wrap-input-avatar .btn-remove').removeClass('d-none');
        });
        $('.wrap-input-avatar .btn-remove').click(function(){
            document.getElementById('avatar').value = "";
            $('.wrap-input-avatar img').attr('src', "img/fixed/default_avatar.png");
            $(this).addClass('d-none');
            $('#avatar_name').val('');
        });

        $('.wrap-cccd').find('input').change(function(){
            var file = event.target.files[0];
            var reader = new FileReader();
            let _this = $(this);

            reader.onload = function(e) {
                _this.closest('.form-group').find('img').attr('src', e.target.result);
            };

            reader.readAsDataURL(file);
        });

        // Handle select rest image
        let rest_images_file = [];
        let file_rests = null;
        $('#rest_images').change(function(e){
            rest_images_file = e.target.files;
            let dataTransferRest = new DataTransfer();
            for (var i = 0; i < rest_images_file.length; i++) {
                dataTransferRest.items.add(rest_images_file[i]);
            }

            file_rests = dataTransferRest;
            document.getElementById('rest_images').files = file_rests.files;
            
            let restFileInput = document.getElementById('rest_images').files;
            let dom = ``;
            for (var i = 0; i < restFileInput.length; i++) {
                let url = URL.createObjectURL(restFileInput[i]);
                dom += `
                    <div class="wrap-img" data-fe-name="${restFileInput[i].name}">
                        <span><i class="fas fa-trash"></i></span>
                        <img src="${url}"/>    
                    </div>
                `;
            }
            
            $('.wrap-rest-images').append(dom);
        });

        // Delete rest image
        $('.wrap-rest-images').on('click', '.wrap-img span', function(){
            let feName = $(this).closest('.wrap-img').attr('data-fe-name');
            let deleteImageName = $(this).closest('.wrap-img').attr('data-image-name');

            if (deleteImageName != undefined) {
                let del_rest_image_names_val = $('#del_rest_image_names').val();
                if (del_rest_image_names_val == "") {
                    $('#del_rest_image_names').val(deleteImageName);
                } else {
                    $('#del_rest_image_names').val(del_rest_image_names_val + "," + deleteImageName);
                }
            } else {
                let i = 0;
                for(let item of file_rests.files) {
                    if (feName == item.name) {
                        file_rests.items.remove(i);
                        document.getElementById('rest_images').files = file_rests.files;
                    }
                    i++;
                }
            }
            
            $(this).closest('.wrap-img').remove();
        });

        // Handle select cert image
        let cert_images_file = [];
        let file_certs = null;
        $('#cert_images').change(function(e){
            cert_images_file = e.target.files;
            let dataTransferCert = new DataTransfer();
            for (var i = 0; i < cert_images_file.length; i++) {
                dataTransferCert.items.add(cert_images_file[i]);
            }

            file_certs = dataTransferCert;
            document.getElementById('cert_images').files = file_certs.files;
            
            let certFileInput = document.getElementById('cert_images').files;
            let dom = ``;
            for (var i = 0; i < certFileInput.length; i++) {
                let url = URL.createObjectURL(certFileInput[i]);
                dom += `
                    <div class="wrap-img" data-fe-name="${certFileInput[i].name}">
                        <span><i class="fas fa-trash"></i></span>
                        <img src="${url}"/>    
                    </div>
                `;
            }
            
            $('.wrap-cert-images').append(dom);
        });

        // Delete cert image
        $('.wrap-cert-images').on('click', '.wrap-img span', function(){
            let feName = $(this).closest('.wrap-img').attr('data-fe-name');
            let deleteImageName = $(this).closest('.wrap-img').attr('data-image-name');

            if (deleteImageName != undefined) {
                let del_cert_image_names_val = $('#del_cert_image_names').val();
                if (del_cert_image_names_val == "") {
                    $('#del_cert_image_names').val(deleteImageName);
                } else {
                    $('#del_cert_image_names').val(del_cert_image_names_val + "," + deleteImageName);
                }
            } else {
                let i = 0;
                for(let item of file_certs.files) {
                    if (feName == item.name) {
                        file_certs.items.remove(i);
                        document.getElementById('cert_images').files = file_certs.files;
                    }
                    i++;
                }
            }
            
            $(this).closest('.wrap-img').remove();
        });

        // Change video
        $('#video_360_url').change(function(e){
            $(this).closest('div').find('video').removeClass('d-none');
            $(this).closest('div').find('.btn-remove').removeClass('d-none');
            let url = URL.createObjectURL(e.target.files[0]);
            $('.wrap-video video').attr('src', url);
        });

        // Delete video
        $('.wrap-video .btn-remove').click(function(){
            document.getElementById('video_360_url').value = "";
            $('.wrap-video video').attr('src', "").addClass('d-none');
            $(this).addClass('d-none');
            $('#video_name').val('');
        });

        // Ajax update
        $('#update').click(function(e){
            e.preventDefault();
            let formData = new FormData($('#user-update')[0]);
            formData.append('story', CKEDITOR.instances['story'].getData());
            $.ajax({
                url: "{{ route('family_admin.edit_user') }}",
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
    </script>
</div>
@endsection