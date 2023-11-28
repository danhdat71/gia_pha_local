@extends('family_member.main')
@section('content')
<div class="root-content blog-detail">
    <div class="container-fluid">
        <div class="head">
            <div class="left">
                <div class="wrap-blog-avatar">
                    <img src="{{route('get_blog_avatar_image', $blog->avatar)}}" alt="">
                </div>
            </div>
            <div class="right">
                <div class="title">{{$blog->title}}</div>
                <div class="created-at">
                    Ngày tạo: 
                    {{date('d-m-Y', strtotime($blog->created_at))}}
                </div>
                <div class="viewer-count">
                    Lượt xem: 
                    {{$blog->blogs_viewers_count}} xem
                </div>
                {{-- <div class="author">
                    <div class="wrap_img">
                        <img src="{{route('get_avatar_image', $blog->user->avatar)}}" alt="">
                    </div>
                    <div class="name">{{$blog->user->full_name}}</div>
                </div> --}}
            </div>
        </div>
        <div class="wrap-content">
            {!!$blog->content!!}
        </div>
    </div>
    <div class="container-fluid pt-4">
        <a href="{{route('family_member.blogs')}}" class="btn btn-sm btn-secondary"><i class="far fa-long-arrow-left"></i> Quay lại</a>
    </div>
</div>
@stop