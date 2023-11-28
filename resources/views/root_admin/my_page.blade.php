@extends('root_admin.main')
@section('content')
<div class="content-wrapper">
    @include('global.content_head', [
        'title' => 'Đổi mật khẩu'
    ])
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header"><b>Đổi mật khẩu</b></div>
                <div class="card-body">
                    <form class="row" action="{{route('root_admin.update_password')}}" method="post">
                        @csrf
                        <div class="form-group col-md-12">
                            <label for="old_password">Mật khẩu cũ <span class="text-danger">(*)</span></label>
                            <input type="password" class="form-control" name="old_password" id="old_password">
                            @error('old_password')
                                <div style="padding-top: 2px;"><i class="text-danger">{{$message}}</i></div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="password">Mật khẩu mới <span class="text-danger">(*)</span></label>
                            <input type="password" class="form-control" name="password" id="password">
                            @error('password')
                                <div style="padding-top: 2px;"><i class="text-danger">{{$message}}</i></div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="re_password">Nhắc lại mật khẩu mới <span class="text-danger">(*)</span></label>
                            <input type="password" class="form-control" name="re_password" id="re_password">
                            @error('re_password')
                                <div style="padding-top: 2px;"><i class="text-danger">{{$message}}</i></div>
                            @enderror
                        </div>
                        @if(session()->has('message'))
                            <div class="alert alert-info w-100" role="alert">{{session('message')}}</div>
                        @endif
                        <div class="col-12 text-right">
                            <button class="btn btn-success">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection