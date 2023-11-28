<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng nhập</title>
    <link rel="icon" type="image/x-icon" href="img/fixed/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <link rel="stylesheet" href="css/auth_family_member.css?version={{env('CSS_VERSION')}}">
</head>
<body>
    <div class="container register">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="img/fixed/logo.png" alt="logo" />
                <h3>Welcome</h3>
                <p class="sub-title">Quên mật khẩu</p>
            </div>
            <div class="col-md-9 register-right">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">Quên mật khẩu</h3>
                        <form class="row register-form" action="{{route('reset_password_request')}}" method="post">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Địa chỉ email *" name="email" value="{{old('email')}}">
                                    @error('email')
                                        <div style="font-size: 13px; padding-top: 2px;"><i class="text-danger">{{$message}}</i></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                @if($errors->has('message'))
                                    <i class="text-danger">{{$errors->first()}}</i>
                                @endif
                            </div>
                            <div class="col-md-12">
                                @if(session('message'))
                                {{session('message')}}
                                @endif
                            </div>
                            <div class="col-md-12">
                                <input type="submit" class="btnRegister" value="Lấy mã" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
