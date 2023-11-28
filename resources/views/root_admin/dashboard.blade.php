@extends('root_admin.main')
@section('content')
    <div class="content-wrapper">
        @include('global.content_head', [
            'title' => 'Dashboard',
        ])
        <section class="content">
            <div class="container-fluid">
                <label>Hệ thống</label>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-microchip"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">CPU Traffic</span>
                                <span class="info-box-number">
                                    <span>123</span>
                                    (123 <small>123</small>)
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hdd"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Bộ nhớ</span>
                                <span class="info-box-number">123 GB</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="far fa-hdd"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Bộ nhớ trống</span>
                                <span class="info-box-number">123 GB</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="far fa-hdd"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Chiếm dụng</span>
                                <span class="info-box-number">123 GB</span>
                            </div>
                        </div>
                    </div>
                </div>
                <label>Ứng dụng</label>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User mới</h3>
                                <div class="card-tools">
                                    <span class="badge badge-danger">123 người mới</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <ul class="users-list clearfix">
                                    <li class="p-4">
                                        <img
                                            src="img/fixed/default_avatar_1.png"
                                            alt=""
                                        >
                                        <a class="users-list-name pt-2" href="#">Nguyễn Văn A</a>
                                        {{-- $user->created_at->diffForHumans() --}}
                                        <span class="users-list-date">1 ngày trước</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer text-center">
                                <a href="">Xem toàn bộ</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-5">
                        <div class="info-box mb-3 bg-warning">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Tổng thành viên cây</span>
                                <span class="info-box-number">123 người</span>
                            </div>
                        </div>
                        <div class="info-box mb-3 bg-success">
                            <span class="info-box-icon"><i class="fas fa-male"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Tổng thành viên nam</span>
                                <span class="info-box-number">1 người</span>
                            </div>
                        </div>
                        <div class="info-box mb-3 bg-info">
                            <span class="info-box-icon"><i class="fas fa-female"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Tổng thành viên nữ</span>
                                <span class="info-box-number">1 người</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title">Sự kiện sắp diễn ra</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive text-nowrap">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>Thứ tự</th>
                                                <th>Tiêu đề</th>
                                                <th>Ngày diễn ra</th>
                                                <th>Số thành viên</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    <div class="pb-2">Không có sự kiện sắp diễn ra</div>
                                                    <a href="" class="btn btn-sm btn-info">Tạo sự kiện</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#1</td>
                                                <td>Sự kiện test</td>
                                                <td>12-12-2023</td>
                                                <td><span class="badge badge-success">123 người</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
