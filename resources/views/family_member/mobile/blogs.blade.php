@extends('family_member.main')
@section('content')
<div class="root-content blogs">
    <div class="container-fluid">
        <div class="wrap-tab-button">
            <a class="tab-button" href="{{route('family_member.events')}}">Sự kiện</a>
            <a class="tab-button active" href="{{route('family_member.blogs')}}">Tin tức</a>
        </div>
        @if (sizeof ($blogs) == 0)
        <div class="text-center pt-5">
            <img class="empty-data" src="img/fixed/empty_data.jpg" alt="empty_data">
            <div class="empty-data-text">Chưa có bài viết nào ...</div>
        </div>
        @endif
        <div class="wrap-event-items">
            @foreach ($blogs as $blog)
            <a href="{{route('family_member.blog_detail', $blog->id)}}" class="blog-item">
                <div class="left">
                    <div class="wrap-avatar">
                        <img src="{{route('get_blog_avatar_image', $blog->avatar)}}" alt="">
                    </div>
                </div>
                <div class="right">
                    <div class="title">{{$blog->title}}</div>
                    <div class="viewer-count">{{$blog->blogs_viewers_count}} lượt xem</div>
                    <div class="author">
                        <div class="wrap-img">
                            <img
                                @if ($blog->user->avatar)
                                src="{{route('get_avatar_image', $blog->user->avatar)}}"
                                @else
                                src="img/fixed/default_avatar_1.png"    
                                @endif
                                alt=""
                            >
                        </div>
                        <div class="name">{{$blog->user->full_name}}</div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div id="wrap-paginate">
            {{$blogs->onEachSide(1)->render('pagination::default')}}
        </div>
    </div>
</div>
@stop
