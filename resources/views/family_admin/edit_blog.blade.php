@extends('family_admin.main')
@section('content')
<div class="content-wrapper">
    @include('global.content_head', [
        'title' => 'Sửa bài viết'
    ])
    <style>
        #check-all *{
            cursor: pointer;
            user-select: none;
        }
        #check-all-input {
            width: 18px;
            height: 18px;
        }
        .check-member {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        #member-join-table .wrap-img {
            width: 50px;
            height: 50px;
        }
        #member-join-table .wrap-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .w-20 {
            width: 20%!important;
        }
        #member-join-table tr {
            cursor: pointer;
        }
        #member-join-table tr:hover {
            background: rgba(8, 8, 8, 0.144)!important;
        }

        .preview-img {
            width: 200px;
            height: 200px;
        }

        .preview-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @media screen and (max-width: 768px) {
            #member-join-table_wrapper .col-gender,
            #member-join-table_wrapper .col-age {
                display: none;   
            }
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form id="create-blog" action="" class="row" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$blog->id}}">
                        <div class="form-group col-md-12">
                            <label for="title">Tiêu đề <span class="text-danger">(*)</span></label>
                            <input type="text" name="title" class="form-control" id="title" value="{{$blog->title}}">
                            <i class="text-danger validate_msg" id="err_title"></i>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="avatar">Ảnh đại diện</label>
                            <input
                                type="file"
                                name="avatar"
                                class="form-control"
                                id="avatar"
                                accept="image/*"
                            >
                            <label for="avatar">
                                <div class="preview-img mt-3">
                                    <img
                                        @if ($blog->avatar)
                                        src="{{route('get_blog_avatar_image', $blog->avatar)}}"
                                        @else
                                        src="img/fixed/default_blog.png"
                                        @endif
                                        alt=""
                                    >
                                </div>
                            </label>
                            <div><i class="text-danger validate_msg" id="err_avatar"></i></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="avatar">Trạng thái hiện</label>
                            <div class="d-flex">
                                <div class="item pr-3">
                                    <label for="is_not_visible">Ẩn</label>
                                    <input
                                        value="0"
                                        type="radio"
                                        id="is_not_visible"
                                        name="is_visible"
                                        @if($blog->is_visible == 0)
                                        checked
                                        @endif
                                    >
                                </div>
                                <div class="item">
                                    <label for="is_visible">Hiện</label>
                                    <input
                                        value="1"
                                        type="radio"
                                        id="is_visible"
                                        name="is_visible"
                                        @if($blog->is_visible == 1)
                                        checked
                                        @endif
                                    >
                                </div>
                            </div>
                            <i class="text-danger validate_msg" id="err_is_visible"></i>
                        </div>
                        <div class="col-md-12 pt-2">
                            <label for="content">Chi tiết sự kiện</label>
                            <textarea name="content" id="content">{{$blog->content}}</textarea>
                            <i class="text-danger validate_msg" id="err_content"></i>
                        </div>
                        <div class="col-md-12 pt-3 text-right">
                            <button id="upload" class="btn button-color-template">Cập nhật blog</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        let editor = CKEDITOR.replace('content', configCkeditor);
        $( "[name=date]" ).datepicker({
            dayNamesMin: [ "T2", "T3", "T4", "T5", "T6", "T7", "CN" ],
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            dateFormat: "yy-mm-dd",
        });

        $("#avatar").change(function(e){
            let avatar = e.target.files[0];
            let avatarBlogUrl = URL.createObjectURL(avatar);
            $('.preview-img').find('img').attr('src', avatarBlogUrl);
        });

        // Ajax create
        $('#upload').click(function(e){
            e.preventDefault();
            let formData = new FormData($('#create-blog')[0]);
            formData.append('content', CKEDITOR.instances['content'].getData());
            $.ajax({
                url: "{{ route('family_admin.edit_blog') }}",
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
                        location.href = '{{route("family_admin.blogs")}}';
                    }
                }
            });
        });
    </script>
</div>
@endsection