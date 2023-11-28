@extends('family_admin.main')
@section('content')
<div class="content-wrapper">
    <style>
        .gender-item-radio {
            cursor: pointer;
        }

        #male_gender, #female_gender {
            width: 17px;
            height: 17px;
        }

        .wrap-input-avatar {
            position: relative;
            width: 150px;
            height: 150px;
            overflow: hidden;
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

        .wrap-rest-images {
            display: flex;
            flex-wrap: wrap;
            padding: 10px 0;
        }

        .wrap-rest-images .wrap-img,
        .wrap-certificates .wrap-img {
            float: left;
            width: 200px;
            height: 150px;
            overflow: hidden;
            margin: 5px;
            position: relative;
            cursor: pointer;
        }

        .wrap-rest-images .wrap-img img,
        .wrap-certificates .wrap-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .wrap-rest-images .wrap-img:hover span,
        .wrap-certificates .wrap-img:hover span {
            transform: translateY(0%);
        }

        .wrap-rest-images .wrap-img span,
        .wrap-certificates .wrap-img span {
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
    @include('global.content_head', [
        'title' => 'Thêm thành viên từ ' . $fromMember->full_name
    ])
    <section class="content">
        <form action="{{route('family_admin.add_user')}}" method="post" enctype="multipart/form-data" class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><strong>THÔNG TIN CHUNG</strong></div>
                        <div class="card-body">
                            <div class="row">
                                @csrf
                                <input type="hidden" name="from_member_id" value="{{$fromMember->id}}">
                                <div class="form-group col-12">
                                    <label for="relation">Mối quan hệ</label>
                                    <select class="form-control" name="relation" id="relation">
                                        @if ($fromMember->is_main)
                                            <option
                                                value="{{\App\Constants\Relation::COUPLE}}"
                                                @if (old('relation') != null && old('relation') == \App\Constants\Relation::COUPLE)
                                                selected
                                                @endif
                                            >
                                            @if ($fromMember->gender == \App\Constants\Gender::MALE)
                                            {{'Vợ'}}
                                            @else
                                            {{'Chồng'}}
                                            @endif
                                        @endif
                                        </option>
                                        @if ($fromMember->spouses_count > 0)
                                        <option
                                            value="{{\App\Constants\Relation::CHILD}}"
                                            @if (old('relation') != null && old('relation') == \App\Constants\Relation::CHILD)
                                            selected
                                            @endif
                                        >Con cái</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fullname">Họ tên <span class="text-danger">(*)</span></label>
                                    <input class="form-control" type="text" name="fullname" id="fullname" value="{{old('fullname')}}">
                                    @error('fullname')
                                        <i class="text-danger">{{$message}}</i>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="role_name">Tên vai trò <span class="text-danger">(*)</span></label>
                                    <input class="form-control" type="text" name="role_name" id="role_name" value="{{old('role_name')}}">
                                    @error('role_name')
                                        <i class="text-danger">{{$message}}</i>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="avatar">Ảnh đại diện</label>
                                    <div class="wrap-input-avatar">
                                        <input class="form-control" type="file" name="avatar" id="avatar" accept="image/*">
                                        <input
                                            type="hidden"
                                            name="avatar_name"
                                            @if (session('avatar_name'))
                                            value="{{session('avatar_name')}}"
                                            @endif
                                        >
                                        <img
                                            @if (session('avatar_name'))
                                            src="{{route('get_avatar_image', session('avatar_name'))}}"
                                            @else
                                            src="img/fixed/default_avatar.png"
                                            @endif
                                            alt=""
                                        >
                                    </div>
                                    @error('avatar')
                                        <i class="text-danger">{{$message}}</i>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="born_day">Ngày sinh</label>
                                            <input id="born_day" type="text" class="form-control" name="born_day" maxlength="2" value="{{old('born_day')}}">
                                            @error("born_day")
                                                <div><i class="text-danger">{{ $message }}</i></div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="born_month">Tháng sinh</label>
                                            <input id="born_month" type="text" class="form-control" name="born_month" maxlength="2" value="{{old('born_month')}}">
                                            @error("born_month")
                                                <div><i class="text-danger">{{ $message }}</i></div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="born_year">Năm sinh</label>
                                            <input type="text" class="form-control" name="born_year" id="born_year" maxlength="4" value="{{old('born_year')}}">
                                            @error("born_year")
                                                <div><i class="text-danger">{{ $message }}</i></div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Địa chỉ</label>
                                    <input class="form-control" type="text" name="address" id="address" value="{{old('address')}}">
                                    @error('address')
                                        <i class="text-danger">{{$message}}</i>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Nguyên quán</label>
                                    <input class="form-control" type="text" name="domicile" id="domicile" value="{{old('domicile')}}">
                                    @error('domicile')
                                        <i class="text-danger">{{$message}}</i>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="phone">Số điện thoại</label>
                                    <input class="form-control" type="text" name="phone" id="phone" value="{{old('phone')}}">
                                    @error('phone')
                                        <i class="text-danger">{{$message}}</i>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="cccd_number">Mã căn cước</label>
                                    <input type="text" class="form-control" name="cccd_number" id="cccd_number" value="{{old('cccd_number')}}">
                                    @error('cccd_number')
                                        <i class="text-danger">{{$message}}</i>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cccd_image_before">Mặt trước CCCD</label>
                                    <div class="wrap-cccd">
                                        <img
                                            @if (session('cccd_image_before_name'))
                                            src={{route('get_cccd_image', session('cccd_image_before_name'))}}
                                            @else
                                            src="img/fixed/before_cccd_default.jpg"
                                            @endif
                                            alt="before"
                                            class="w-100"
                                        >
                                        <input type="file" class="form-control" name="cccd_image_before" id="cccd_image_before" accept="image/*">
                                        <input
                                            type="hidden"
                                            name="cccd_image_before_name"
                                            @if (session('cccd_image_before_name'))
                                            value={{session('cccd_image_before_name')}}
                                            @endif
                                        >
                                    </div>
                                    @error('cccd_image_before')
                                        <i class="text-danger">{{$message}}</i>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cccd_image_after">Mặt sau CCCD</label>
                                    <div class="wrap-cccd">
                                        <img
                                            @if (session('cccd_image_after_name'))
                                            src={{route('get_cccd_image', session('cccd_image_after_name'))}}
                                            @else
                                            src="img/fixed/before_cccd_default.jpg"
                                            @endif
                                            alt="after"
                                            class="w-100"
                                        >
                                        <input type="file" class="form-control" name="cccd_image_after" id="cccd_image_after" accept="image/*">
                                        <input
                                            type="hidden"
                                            name="cccd_image_after_name"
                                            @if (session('cccd_image_after_name'))
                                            value={{session('cccd_image_after_name')}}
                                            @endif
                                        >
                                    </div>
                                    @error('cccd_image_after')
                                        <i class="text-danger">{{$message}}</i>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="email">Email <span class="text-danger">(*)</span></label>
                                    <input class="form-control" type="text" name="email" id="email" value="{{old('email')}}">
                                    @error('email')
                                        <i class="text-danger">{{$message}}</i>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4 d-none position_index">
                                    <label for="position_index">Thứ tự <span class="text-danger">(*)</span></label>
                                    <input id="position_index" class="form-control" type="text" name="position_index" id="position_index" value="{{old('position_index')}}">
                                    @error('position_index')
                                        <i class="text-danger">{{$message}}</i>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2 gender d-none">
                                    <label for="">Giới tính</label>
                                    <div class="d-flex align-items-center pt-2">
                                        <div class="d-flex align-items-center pr-4">
                                            <label class="m-0 pr-2" for="male_gender">Nam</label>
                                            <input
                                                id="male_gender"
                                                name="gender"
                                                type="radio"
                                                value="{{\App\Constants\Gender::MALE}}"
                                                @if (old('gender') == null || old('gender') != null && old('gender') == \App\Constants\Gender::MALE)
                                                checked
                                                @endif
                                            >
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label class="m-0 pr-2" for="female_gender">Nữ</label>
                                            <input
                                                id="female_gender"
                                                name="gender"
                                                type="radio"
                                                value="{{\App\Constants\Gender::FEMALE}}"
                                                @if (old('gender') != null && old('gender') == \App\Constants\Gender::FEMALE)
                                                checked
                                                @endif
                                            >
                                        </div>
                                    </div>
                                    @error('gender')
                                        <i class="text-danger">{{$message}}</i>
                                    @enderror
                                </div>
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
                                <input class="form-control" type="text" name="job" id="job" value="{{old('job')}}">
                                @error('job')
                                    <i class="text-danger">{{$message}}</i>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="position">Chức vụ</label>
                                <input class="form-control" type="text" name="position" id="position" value="{{old('position')}}">
                                @error('position')
                                    <i class="text-danger">{{$message}}</i>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="organization">Cơ quan</label>
                                <input class="form-control" type="text" name="organization" id="organization" value="{{old('organization')}}">
                                @error('organization')
                                    <i class="text-danger">{{$message}}</i>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
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
                                @error('cert_images')
                                    <i class="text-danger">{{$message}}</i>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="leave_day">Ngày mất</label>
                                        <input id="leave_day" type="text" class="form-control" name="leave_day" maxlength="2" value="{{old('leave_day')}}">
                                        @error("leave_day")
                                            <div><i class="text-danger">{{ $message }}</i></div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="leave_month">Tháng mất</label>
                                        <input id="leave_month" type="text" class="form-control" name="leave_month" maxlength="2" value="{{old('leave_month')}}">
                                        @error("leave_month")
                                            <div><i class="text-danger">{{ $message }}</i></div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="leave_year">Năm mất</label>
                                        <input type="text" class="form-control" name="leave_year" id="leave_year" maxlength="4" value="{{old('leave_year')}}">
                                        @error("leave_year")
                                            <div><i class="text-danger">{{ $message }}</i></div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="rest_place">Vị trí an nghỉ</label>
                                <input class="form-control" type="text" name="rest_place" id="rest_place" value="{{old('rest_place')}}">
                                @error('rest_place')
                                    <i class="text-danger">{{$message}}</i>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lat">Latitude</label>
                                <input class="form-control" type="text" name="lat" id="lat" value="{{old('lat')}}">
                                @error('lat')
                                    <i class="text-danger">{{$message}}</i>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="long">Longitude</label>
                                <input class="form-control" type="text" name="long" id="long" value="{{old('long')}}">
                                @error('long')
                                    <i class="text-danger">{{$message}}</i>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="rest_images">Hình ảnh an nghỉ</label>
                                <input
                                    class="form-control"
                                    type="file"
                                    name="rest_images[]"
                                    id="rest_images"
                                    accept="image/*"
                                    multiple
                                >
                                <div class="wrap-rest-images">
                                    @if (session('rest_images'))
                                        @foreach(explode(",", session('rest_images')) as $image)
                                            <div class="wrap-img" data-old-name={{$image}}>
                                                <img src="{{route('get_rest_image', $image)}}" alt="{{$image}}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <input
                                    type="hidden"
                                    name="rest_image_names"
                                    @if (session('rest_images'))
                                        value="{{session('rest_images')}}"
                                    @endif
                                >
                                @error('address')
                                    <i class="text-danger">{{$message}}</i>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="video_360_url">Video 360 độ</label>
                                <input id="select-video" class="form-control" type="file" name="video_360_url" accept="video/*">
                                <video
                                    @if (session('video_name'))
                                    class="w-100 mt-1"
                                    @else
                                    class="w-100 mt-1 d-none"
                                    @endif
                                    id="preview-video"
                                    @if (session('video_name'))
                                    src="{{route('get_360_video', session('video_name'))}}"
                                    @endif
                                    autoplay
                                    controls
                                ></video>
                                <input
                                    type="hidden"
                                    name="video_name"
                                    @if (session('video_name'))
                                    value="{{session('video_name')}}"
                                    @endif
                                >
                                @error('video_360_url')
                                    <i class="text-danger">{{$message}}</i>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Thông tin tiểu sử</div>
                        <div class="card-body">
                            <div class="form-group col-md-12">
                                <label for="story">Tiểu sử</label>
                                <textarea name="story" id="story">{{old('story')}}</textarea>
                                @error('story')
                                    <i class="text-danger">{{$message}}</i>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="text-right pb-3">
                        <a href="{{route('family_admin.genealogy')}}" class="btn btn-secondary"><i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>
                        <button class="btn button-color-template">Thêm thành viên</button>
                    </div>
                </div>
            </div>
        </div>
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
        let relation = {{old('relation', 1)}};
        $('#relation').on('change', function(){
            relation = $(this).val();
            initRelationForm();
        });

        initRelationForm();

        function initRelationForm() {
            if (relation == 2) {
                //$('.child_with').removeClass('d-none');
                $('.position_index').removeClass('d-none');
                $('.gender').removeClass('d-none');
            } else {
                //$('.child_with').addClass('d-none');
                $('.position_index').addClass('d-none');
                $('.gender').addClass('d-none');
            }
        }

        // Handle avatar input
        $('.wrap-input-avatar input').change(function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.wrap-input-avatar img').attr('src', e.target.result);
            };

            reader.readAsDataURL(file);
        });

        // Handle cccd image input
        $('.wrap-cccd').find('input').change(function(){
            var file = event.target.files[0];
            var reader = new FileReader();
            let _this = $(this);

            reader.onload = function(e) {
                _this.closest('.form-group').find('img').attr('src', e.target.result);
            };

            reader.readAsDataURL(file);
        });

        // Handle rest image input
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
            renderImageRestUI();
        });

        $('.wrap-rest-images').on('click', '.wrap-img span', function(){
            let index = $(this).closest('.wrap-img').attr('data-index');
            file_rests.items.remove(index);
            document.getElementById('rest_images').files = file_rests.files;
            renderImageRestUI();      
        });

        function renderImageRestUI()
        {
            let restFileInput = document.getElementById('rest_images').files;
            let dom = ``;
            for (var i = 0; i < restFileInput.length; i++) {
                let url = URL.createObjectURL(restFileInput[i]);
                dom += `
                    <div class="wrap-img" data-index="${i}">
                        <span><i class="fas fa-trash"></i></span>
                        <img src="${url}"/>    
                    </div>
                `;
            }
            $('.wrap-rest-images').html(dom);
        }


        // Handle certificates image
        let certificate_files = [];
        let file_certificate = null;
        $('#cert_images').change(function(e){
            certificate_files = e.target.files;
            const dataTransferCert = new DataTransfer();
            for (var i = 0; i < certificate_files.length; i++) {
                dataTransferCert.items.add(certificate_files[i]);
            }

            file_certificate = dataTransferCert;
            document.getElementById('cert_images').files = file_certificate.files;
            renderImageCertUI();
        });

        $('.wrap-certificates').on('click', '.wrap-img span', function(){
            let index = $(this).closest('.wrap-img').attr('data-index');
            file_certificate.items.remove(index);
            document.getElementById('cert_images').files = file_certificate.files;
            renderImageCertUI();      
        });

        function renderImageCertUI()
        {
            let certFileInput = document.getElementById('cert_images').files;
            let dom = ``;
            for (var i = 0; i < certFileInput.length; i++) {
                let url = URL.createObjectURL(certFileInput[i]);
                dom += `
                    <div class="wrap-img" data-index="${i}">
                        <span><i class="fas fa-trash"></i></span>
                        <img src="${url}"/>    
                    </div>
                `;
            }
            $('.wrap-certificates').html(dom);
        }

        // Handle video
        $('#select-video').change(function(e){
            if(e.target.files[0]) {
                let url = URL.createObjectURL(e.target.files[0]);
                $('#preview-video').removeClass('d-none').attr('src', url);
            } else  {
                $('#preview-video').addClass('d-none').attr('src', '');
            }
        });
        
    </script>
</div>
@endsection