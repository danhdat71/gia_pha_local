@extends('family_member.desktop.main')
@section('content')
<div class="row blogs">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                <div class="wrap-tab-button">
                    <a class="tab-button" href="{{route('family_member.events')}}">Sự kiện</a>
                    <a class="tab-button active" href="{{route('family_member.blogs')}}">Tin tức</a>
                </div>
                
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
                @if (sizeof($blogs) == 0)
                <div class="alert text-center">Chưa có bài viết</div>
                @endif
                <div id="wrap-paginate">
                    {{$blogs->onEachSide(1)->render('pagination::default')}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection