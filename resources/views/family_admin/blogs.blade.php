@extends('family_admin.main')
@section('content')
<div class="content-wrapper">
    @include('global.content_head', [
        'title' => 'Quản lý bài viết'
    ])
    <style>
        .wrap-avatar-img {
            width: 100px;
            height: 100px;
            overflow: hidden;
        }

        .wrap-avatar-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .table td{
            vertical-align: middle;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <form class="row" action="{{route('family_admin.blogs')}}" method="get" enctype="multipart/form-data">
                        <div class="form-group col-md-3">
                            <label for="">Tên blogs</label>
                            <input type="text" class="form-control" name="keyword" value="{{$inputed['keyword'] ?? null}}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Từ ngày</label>
                            <input type="text" class="form-control" name="from_date" value="{{$inputed['from_date'] ?? null}}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="">Đến ngày</label>
                            <input type="text" class="form-control" name="to_date" value="{{$inputed['to_date'] ?? null}}">
                        </div>
                        <div class="form-group col-md-3 pt-2">
                            <button type="submit" class="btn button-color-template mt-4"><i class="far fa-search"></i> Tìm kiếm</button>
                        </div>
                        <div class="form-group col-md-2 pt-2 text-right">
                            <a href="{{route('family_admin.create_blog_view')}}" class="btn button-color-template mt-4">+ Blog mới</a>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-header-template">
                                <th>Ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Ngày tạo & tác giả</th>
                                <th>Thao tác</th>
                            </thead>
                            <tbody>
                                @if(sizeof($blogs) == 0)
                                <tr>
                                    <td colspan="5">
                                        <div class="alert text-center">Chưa có bài viết nào.</div>
                                    </td>
                                </tr>
                                @endif
                                @foreach($blogs as $blog)
                                <tr>
                                    <td>
                                        <div class="wrap-avatar-img bg-secondary">
                                            <img loading="lazy" src="{{route('get_blog_avatar_image', $blog->avatar)}}" alt="">
                                        </div>
                                    </td>
                                    <td>{{$blog->title}}</td>
                                    <td>
                                        <div>{{$blog->created_at}}</div>
                                        <div>{{$blog->user->full_name}}</div>
                                    </td>
                                    <td>
                                        <a href="{{route('family_member.blog_detail', $blog->id)}}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-book-reader"></i> Xem</a>
                                        <a href="{{route('family_admin.edit_blog_view', $blog->id)}}" class="btn btn-sm btn-warning"><i class="far fa-edit"></i> Sửa</a>
                                        <button data-toggle="modal" data-target="#delete-event-modal" data-id="{{$blog->id}}" class="btn btn-sm btn-danger delete-event"><i class="fas fa-trash"></i> Xóa</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-md-4 wrap-paginate-default">{{$blogs->appends($inputed)->onEachSide(1)->render('pagination::default')}}</div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="delete-event-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc muốn xoá blog này ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6 text-center">
                                    <button class="btn btn-sm btn-secondary w-100" data-dismiss="modal">Không</button>
                                </div>
                                <div class="col-6 text-center">
                                    <form action="{{route('family_admin.delete_blog')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" id="delete-event-id">
                                        <button class="btn btn-sm button-color-template w-100">Đồng ý</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $( "[name=from_date]" ).datepicker({
            dayNamesMin: [ "T2", "T3", "T4", "T5", "T6", "T7", "CN" ],
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            dateFormat: "yy-mm-dd",
        });
        $( "[name=to_date]" ).datepicker({
            dayNamesMin: [ "T2", "T3", "T4", "T5", "T6", "T7", "CN" ],
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            dateFormat: "yy-mm-dd",
        });
        $('.delete-event').click(function(){
            $('#delete-event-id').val($(this).attr('data-id'));
        });

        
    </script>
</div>
@endsection