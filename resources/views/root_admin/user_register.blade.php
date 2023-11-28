@extends('root_admin.main')
@section('content')
    <div class="content-wrapper">
        @include('global.content_head', [
            'title' => 'Đăng ký',
        ])
        <style>
            #refresh-password {
                position: absolute;
                right: 13px;
                top: 36px;
            }

            .wrap-themes {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr 1fr;
                grid-gap: 25px;
            }

            .wrap-themes .theme {
                cursor: pointer;
                text-align: center;
            }

            .wrap-themes .theme .title {
                padding: 10px 0 0 0;
            }

            .wrap-themes .theme .wrap-img {
                aspect-ratio: 16/9;
                border-radius: 10px;
                overflow: hidden;
            }

            .wrap-themes .theme .wrap-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        </style>
        <section class="content">
            <form method="post" action="{{route('root_admin.user_register')}}" class="container-fluid">
                @if (session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
                @endif
                @csrf
                <div class="card">
                    <div class="card-header">Thông tin người dùng</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">Email <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">
                                @error("email")
                                    <div><i class="text-danger">{{ $message }}</i></div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="full_name">Họ tên <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="{{old('full_name')}}">
                                @error("full_name")
                                    <div><i class="text-danger">{{ $message }}</i></div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
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
                            <div class="form-group col-md-4 position-relative">
                                <label for="pass">Mật khẩu <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" id="pass" name="pass" value="{{old('pass')}}">
                                <span class="btn btn-sm btn-success" id="refresh-password">Làm mới</span>
                                @error("pass")
                                    <div><i class="text-danger">{{ $message }}</i></div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="full_name">Giới tính <span class="text-danger">(*)</span></label>
                                <div class="d-flex align-items-center pt-1">
                                    <div class="pr-3">
                                        <label for="male">Nam</label>
                                        <input
                                            @if (old('gender') == null || old('gender') == App\Constants\Gender::MALE)
                                            checked
                                            @endif
                                            type="radio"
                                            id="male"
                                            name="gender"
                                            value="{{App\Constants\Gender::MALE}}"
                                        >
                                    </div>
                                    <div>
                                        <label for="female">Nữ</label>
                                        <input
                                            @if (old('gender') == App\Constants\Gender::FEMALE)
                                            checked
                                            @endif
                                            type="radio"
                                            id="female"
                                            name="gender"
                                            value="{{App\Constants\Gender::FEMALE}}"
                                        >
                                    </div>
                                </div>
                                @error("gender")
                                    <div><i class="text-danger">{{ $message }}</i></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Dùng thử</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="trial_month">Thời hạn <span class="text-danger">*</span></label>
                                <select id="trial_month" name="trial_month" class="form-control">
                                    <option value="3">3 tháng</option>
                                    <option value="6">6 tháng</option>
                                </select>
                                @error("trial_month")
                                    <div><i class="text-danger">{{ $message }}</i></div>
                                @enderror
                                <div class="d-flex pt-2 align-items-center">
                                    <div class="pr-2">
                                        <label>Ngày bắt đầu</label>
                                        <input class="form-control" type="text" disabled value="{{date('d-m-Y', strtotime(date('Y-m-d')))}}">
                                    </div>
                                    <div class="pl-2">
                                        <label>Ngày hết hạn</label>
                                        <input
                                            id="preview-expired-at"
                                            class="form-control"
                                            type="text"
                                            disabled
                                            value="{{date('d-m-Y', strtotime(date('Y-m-d') . "+3 months"))}}"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="trial_member">Giới hạn thành viên (người) <span class="text-danger">*</span></label>
                                <select id="trial_member" name="trial_member" class="form-control">
                                    <option value="10">10 thành viên</option>
                                    <option value="20">20 thành viên</option>
                                    <option value="30">30 thành viên</option>
                                </select>
                                @error("trial_member")
                                    <div><i class="text-danger">{{ $message }}</i></div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Thông tin gia phả</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="family_tree_title">Tiêu đề gia phả <span class="text-danger">(*)</span></label>
                                <input id="family_tree_title" type="text" class="form-control" name="title" id="family_tree_title" value="{{old('title')}}">
                                @error("title")
                                    <div><i class="text-danger">{{ $message }}</i></div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="domain">Tên miền</label>
                                <input type="text" class="form-control" name="domain" id="domain" value="{{old('domain')}}">
                                @error("domain")
                                    <div><i class="text-danger">{{ $message }}</i></div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Giao diện gia phả</label>
                                <input
                                    type="hidden"
                                    name="template_id"
                                    id="template_id"
                                    value="{{old('template_id') ?? 1}}"
                                >
                                <div class="wrap-themes">
                                    <div class="theme">
                                        <div class="wrap-img">
                                            <img src="img/fixed/template_1.jpg" alt="">
                                        </div>
                                        <div class="title">Giao diện 1</div>
                                        <div>
                                            <input
                                                data-id="1"
                                                type="radio"
                                                @if (old('template_id') == 1 OR old('template_id') == null)
                                                checked
                                                @endif
                                            >
                                        </div>
                                    </div>
                                    <div class="theme">
                                        <div class="wrap-img">
                                            <img src="img/fixed/template_2.jpg" alt="">
                                        </div>
                                        <div class="title">Giao diện 2</div>
                                        <div>
                                            <input
                                                data-id="2"
                                                type="radio"
                                                @if (old('template_id') == 2)
                                                checked
                                                @endif
                                            >
                                        </div>
                                    </div>
                                    <div class="theme">
                                        <div class="wrap-img">
                                            <img src="img/fixed/template_3.jpg" alt="">
                                        </div>
                                        <div class="title">Giao diện 3</div>
                                        <div>
                                            <input
                                                data-id="3"
                                                type="radio"
                                                @if (old('template_id') == 3)
                                                checked
                                                @endif
                                            >
                                        </div>
                                    </div>
                                    <div class="theme">
                                        <div class="wrap-img">
                                            <img src="img/fixed/template_4.jpg" alt="">
                                        </div>
                                        <div class="title">Giao diện 4</div>
                                        <div>
                                            <input
                                                data-id="4"
                                                type="radio"
                                                @if (old('template_id') == 4)
                                                checked
                                                @endif
                                            >
                                        </div>
                                    </div>
                                </div>
                                @error('template_id')
                                    <i class="text-danger">{{$message}}</i>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-12 text-right pb-3">
                    <button class="btn btn-info">Đăng ký</button>
                </div>
            </form>
        </section>
    </div>
    <script>
        $('.wrap-themes').find('.theme').click(function(){
            $('.theme input').prop('checked', false);
            $(this).find('input').prop('checked', true);
            let id = $(this).find('input').attr('data-id');
            $('#template_id').val(id);
        });

        function makeid(length) {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            let counter = 0;
            while (counter < length) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
            counter += 1;
            }
            return result;
        }

        @if(old('pass') == null)
            $('#pass').val(makeid(8));
        @endif
        $('#refresh-password').click(function(){
            $('#pass').val(makeid(8));
        });

        @if (old('title') == null)
        $('#family_tree_title').val('Gia phả ' + makeid(10));
        @endif

        // Expired at time
        $('#trial_month').change(function(){
            let monthAddNum = $(this).val();
            $.ajax({
                url: "{{ route('common.add_month') }}",
                type: 'POST',
                data: {
                    month_to_add : monthAddNum
                },
                success: function(data) {
                    $('#preview-expired-at').val(data.data);
                }
            });
        });
        
    </script>
@endsection
