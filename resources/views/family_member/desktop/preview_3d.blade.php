@extends('family_member.desktop.main')
@section('content')

<!-- TreeJS -->
<script src="//cdnjs.cloudflare.com/ajax/libs/three.js/105/three.js"></script>
<!-- Fancybox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<!-- Panolens -->
<script src="//cdn.jsdelivr.net/npm/panolens@0.11.0/build/panolens.min.js"></script>
<!-- 360 model viewer -->
<script type="module" src="https://unpkg.com/@google/model-viewer"></script>
<div class="preview-3d-desktop">
    @if (sizeof($user->video360degrees) == 0 && sizeof($user->vr3D) == 0 && $user->rest_images == null)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img class="w-25" src="img/fixed/empty_media.jpg" alt="empty_media">
                        <div>Chưa có thông tin media an nghỉ...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (sizeof($user->video360degrees) > 0)
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="pb-3"><b>Video 360 độ</b></div>
                    <div class="row">
                        <div class="col-12">
                            <div id="big-youtube-viewer" data-url="{{$user->video360degrees[0]->url}}"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div id="preview-other-panorama">
                                @foreach($user->video360degrees as $video)
                                <div class="video-item" data-url="{{$video->url}}">
                                    <div class="vr-youtube-video"></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (sizeof($user->vr3D) > 0)
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body" id="card-model-3D">
                    <div class="pb-3"><b>3D ngữ cảnh</b></div>
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
            </div>
        </div>
    </div>
    @endif
    @if ($user->rest_images)
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="pb-3"><b>Hình ảnh</b></div>
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
        </div>
    </div>
    @endif
</div>

<script>

    // @if (sizeof($user->video360degrees) > 0)
    // let container = document.querySelector('#panorama-container');
    // let panoramaView = new PANOLENS.VideoPanorama('{{route("get_360_video", $user->video360degrees[0]->url)}}');
    // let bigViewer = new PANOLENS.Viewer({
    //   container: container
    // });
    // bigViewer.add(panoramaView);
    // @endif

    // Render video list
    // let videoItems = document.querySelectorAll('.video-item');
    // for (let i = 0; i < videoItems.length; i++) {
    //     let videoItem = videoItems[i].querySelector('.vr-360-video');
    //     let url = videoItem.getAttribute('data-url');
    //     let panorama = new PANOLENS.VideoPanorama(url);
    //     let viewer = new PANOLENS.Viewer({
    //         container: videoItem,
    //         autoRotate: true,
    //         autoRotateSpeed: 0.4,
    //         controlBar: true,
    //         controlButtons: ['video']
    //     });
    //     viewer.add(panorama);
    // }

    // Preview big panorama
    // $('.vr-360-video').click(function(){
    //     let url = $(this).attr('data-url');
    //     $('#panorama-container').empty()
    //     let containerPreview = document.getElementById('panorama-container');
    //     let previewPanorama = new PANOLENS.VideoPanorama(url);
    //     let previewViewer = new PANOLENS.Viewer({
    //         container: containerPreview
    //     });
    //     previewViewer.add(previewPanorama);
    // })

    // Fanxibox
    $('.fancybox').fancybox({
		transitionIn: 'elastic',
		transitionOut: 'elastic',
	});

    // Move 3D
    const vr3Ds = @json($user->vr3D);
    $('#card-model-3D').on('click', '.btn-move', function(){
        let toVr3DId = $(this).attr('data-to-vr-3d-id');
        let index = vr3Ds.findIndex(function(item) {
            return item.id == toVr3DId;
        });
        if (index != -1) {
            let renderItem = vr3Ds[index];
            let renderItemButtons = renderItem.vr3_dbuttons;
            $('#preview-3D').find('button').remove();
            $('#preview-3D').attr('src', renderItem.full_link);
            for (let i = 0; i < renderItemButtons.length; i++) {
                let button = renderItemButtons[i];
                let buttonDOM = `<button
                    class="btn btn-sm btn-info btn-move"
                    id="${button.id}"
                    slot="hotspot-${button.id}"
                    data-position="${button.button_x}m ${button.button_y}m ${button.button_z}m"
                    data-to-vr-3d-id="${button.to_vr_3d_id}"
                >${button.title}</button>`;
                $('#preview-3D').append(buttonDOM);
            }
        }
    });

    // Get youtube video
    let bigIframeUrl = $('#big-youtube-viewer').attr('data-url');
    $('#big-youtube-viewer').append(getUrl(bigIframeUrl));
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
    
</script>
@endsection