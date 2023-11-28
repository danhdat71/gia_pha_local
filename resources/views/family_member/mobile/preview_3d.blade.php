@extends('family_member.main')
@section('content')
<!-- TreeJS -->
<script src="//cdnjs.cloudflare.com/ajax/libs/three.js/105/three.js"></script>
<!-- Fancybox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css"/>
<!-- Panolens -->
<script src="//cdn.jsdelivr.net/npm/panolens@0.11.0/build/panolens.min.js"></script>
<!-- 360 model viewer -->
<script type="module" src="https://unpkg.com/@google/model-viewer"></script>
<!-- Swiper -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<div class="root-content preview_3d">
    <div class="container-fluid">
        @if (sizeof($user->video360degrees) == 0 && sizeof($user->vr3D) == 0 && $user->rest_images == null)
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <img class="w-25" src="img/fixed/empty_media.jpg" alt="empty_media">
                    <div>Chưa có thông tin media an nghỉ...</div>
                </div>
            </div>
        </div>
        @endif
        @if (sizeof($user->video360degrees) > 0)
        <div class="card">
            <div class="card-header card-header-template"><b>Video 360 độ</b></div>
            <div class="card-body">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @foreach($user->video360degrees as $video)
                        <div class="video-item swiper-slide" data-url="{{$video->url}}">
                            <div class="vr-youtube-video"></div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
        @endif
        @if (sizeof($user->vr3D) > 0)
        <div class="card mt-3" id="card-3d">
            <div class="card-header card-header-template" id="card-header-3d"><b>3D ngữ cảnh</b></div>
            <div class="card-body" id="card-body-3d">
                <model-viewer
                    id="preview-3D"
                    src="{{route('get_vr_3d', $user->vr3D[0]->url)}}"
                    camera-controls
                    min-field-of-view="5deg"
                    interpolation-decay="200"
                    min-camera-orbit="auto auto 5%"
                >
                @foreach($user->vr3D[0]->vr3Dbuttons as $button)
                <button
                    class="btn btn-sm btn-info btn-move"
                    id="{{$button->id}}"
                    slot="hotspot-{{$button->id}}"
                    data-position="{{$button->button_x}}m {{$button->button_y}}m {{$button->button_z}}m"
                    data-to-vr-3d-id="{{$button->to_vr_3d_id}}"
                >{{$button->title}}</button>
                @endforeach
                </model-viewer>
            </div>
            <div class="card-footer" id="card-footer-3d">
                <div class="d-flex flex-row-reverse">
                    {{-- <div id="wrap-guide" class="pl-2">
                        <button class="btn btn-sm button-color-template"><i class="fas fa-book-reader"></i></button>
                    </div> --}}
                    <div id="toggle-full-screen" class="pl-2">
                        <button class="btn btn-sm button-color-template expand-3D"><i class="fas fa-expand"></i></button>
                        <button class="btn btn-sm button-color-template collapse-3D d-none"><i class="fas fa-compress"></i></button>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if ($user->rest_images)
        <div class="card mt-3">
            <div class="card-header card-header-template"><b>Hình ảnh</b></div>
            <div class="card-body">
                @php
                    $restImageUrls = explode(',', $user->rest_images);
                @endphp
                <div id="rest-images">
                    @foreach($restImageUrls as $url)
                    <a class="item fancybox" href="{{ route('get_rest_image', $url) }}">
                        <img
                            src="{{ route('get_rest_image', $url) }}"
                            alt="{{ $url }}"
                        >
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="container-fluid pt-4">
        <a href="{{route('family_member.about')}}" class="btn btn-sm btn-secondary"><i class="far fa-long-arrow-left"></i> Quay lại</a>
    </div>
</div>
<script>
    var swiper = new Swiper(".swiper", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        on: {
            slideChange: function(el) {
                $('.swiper-slide').each(function () {
                    var youtubePlayer = $(this).find('iframe').get(0);
                    if (youtubePlayer) {
                        youtubePlayer.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
                    }
              });
            }
        }
    });
    $('.fancybox').fancybox({
		transitionIn: 'elastic',
		transitionOut: 'elastic',
	});
    // Get youtube video
    function getId(url)
    {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[2].length === 11)
            ? match[2]
            : null;
    }
    function getUrl(url)
    {
        let videoId = getId(url);
        const iframeMarkup = `<iframe width="100%" height="100%" src="//www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
        return iframeMarkup;
    }
    $('.video-item').each(function(){
        let url = $(this).attr('data-url');
        let iframe = getUrl(url);
        $(this).find('.vr-youtube-video').html(iframe);
    });
    
    // Toggle fullscreen 3D
    $('#toggle-full-screen').find('.expand-3D').click(function(){
        $(this).addClass('d-none');
        $(this).closest('#toggle-full-screen').find('.collapse-3D').removeClass('d-none');
        $('#card-3d').addClass('fullscreen').removeClass('mt-3');
    });
    $('#toggle-full-screen').find('.collapse-3D').click(function(){
        $(this).addClass('d-none');
        $(this).closest('#toggle-full-screen').find('.expand-3D').removeClass('d-none');
        $('#card-3d').removeClass('fullscreen').addClass('mt-3');
    });
</script>
@stop