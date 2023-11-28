@extends('root_admin.main')
@section('content')
<div class="content-wrapper">
    @include('global.content_head', [
        'title' => 'Danh sách người dùng'
    ])
    <style>
        .wrap-avatar-img {
            width: 50px;
            height: 50px;
            overflow: hidden;
            border-radius: 999px;
        }

        .wrap-avatar-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .table td{
            vertical-align: middle;
        }

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
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <form class="row" action="{{route('root_admin.users')}}" method="get" enctype="multipart/form-data">
                        <div class="form-group col-md-3">
                            <label for="keyword">Tên user</label>
                            <input type="text" class="form-control" name="keyword" id="keyword" value="{{$inputed['keyword'] ?? null}}">
                        </div>
                        <div class="form-group col-md-2 pt-0 pt-md-2">
                            <button type="submit" class="btn btn-info mt-0 mt-md-4">Tìm kiếm</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="bg-info">
                                <th>Ảnh</th>
                                <th>Tên user</th>
                                <th>Email</th>
                                <th>Domain</th>
                                <th>Thao tác</th>
                            </thead>
                            <tbody>
                                @if (sizeof($users) == 0)
                                <tr><td colspan="3">Không có người dùng nào</td></tr>
                                @endif
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="wrap-avatar-img">
                                            <img
                                                @if ($user->avatar)
                                                src="{{route('get_avatar_image', $user->avatar)}}"
                                                @else
                                                src="img/fixed/default_avatar_1.png"
                                                @endif
                                                alt=""
                                            >
                                        </div>
                                    </td>
                                    <td class="col-event-date">{{$user->full_name}}</td>
                                    <td class="col-event-date">{{$user->email}}</td>
                                    <td class="col-event-date">{{$user->familyTree->domain ?? 'default'}}</td>
                                    <td class="col-event-date">
                                        <a href="{{route('root_admin.edit_user', $user->id)}}" class="btn btn-sm btn-warning">Chỉnh sửa</a>
                                        @if ($user->familyTree->is_approve_trial == App\Constants\Status::VALUE_FALSE)
                                        <a href="{{route('root_admin.approve_trial_view', $user->family_tree_id)}}" class="btn btn-sm btn-info">Trial</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="wrap-paginate">
                        <div class="pt-md-4 d-flex justify-content-center">{{$users->onEachSide(1)->appends($inputed)->render('pagination::default')}}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection