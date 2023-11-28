@extends('root_admin.main')
@section('content')
    <style>
        #wrap-paginate li {
            display: inline-block;
            width: 30px;
            height: 30px;
            margin: 0 4px;
        }

        #wrap-paginate li a,
        #wrap-paginate li span {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            background: #e2e2e2;
            color: black;
            text-decoration: none;
        }

        #wrap-paginate li.active a,
        #wrap-paginate li.active span {
            background: white;
        }

        #wrap-paginate .pagination {
            justify-content: center;
            padding: 10px 0;
        }
    </style>
    <div class="content-wrapper">
        @include('global.content_head', [
            'title' => 'Người dùng chờ đăng ký',
        ])
        <section class="content">
            <div class="card">
                <div class="card-header">Danh sách người dùng chờ đăng ký</div>
                <div class="card-body">
                    <table class="table">
                        <thead class="bg-info">
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Ngày sinh</th>
                            <th>Giới tính</th>
                        </thead>
                        <tbody>
                            @foreach ($user_registers as $user_register)
                            <tr>
                                <td>{{$user_register->full_name}}</td>
                                <td>{{$user_register->email}}</td>
                                <td>{{date('d-m-Y', strtotime($user_register->birthday))}}</td>
                                <td>{{App\Constants\Gender::GENDER[$user_register->gender]}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="wrap-paginate">
                        <div class="pt-md-4 d-flex justify-content-center">{{$user_registers->onEachSide(1)->render('pagination::default')}}</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
