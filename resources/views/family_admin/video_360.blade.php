@extends('family_admin.main')
@section('content')
    <div class="content-wrapper">
        @include('global.content_head', [
            'title' => 'Video an nghỉ 360 độ',
        ])
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

            .wrap-video-360 {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-gap: 20px;
            }

            .video-item {
                width: 100%;
                height: 350px;
                position: relative;
                cursor: pointer;
            }

            .btn-remove {
                border: none;
                outline: none;
                display: block;
                position: absolute;
                right: 10px;
                top: 5px;
                color: rgb(255, 255, 255);
                font-size: 14px;
                cursor: pointer;
                background-color: rgb(159, 0, 0);
                z-index: 333;
                padding: 0 5px;
            }

            .btn-remove:hover {
                color: white!important;
            }

            .video-item .vr-360-video {
                width: 100%;
                height: 100%;
            }

            .video-item .vr-youtube-video {
                width: 100%;
                height: 100%;
            }

            #preview-360 {
                width: 100%;
                height: 350px;
                border: 1px dashed rgb(215, 215, 215);
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;
            }
            #preview-360 #container-preview {
                width: 100%;
                height: 100%;
                position: absolute;
                z-index: 3;
                display: none;
            }
            #input-file {
                width: 100%;
                height: 100%;
                position: absolute;
                left: 0;
                top: 0;
                opacity: 0;
                z-index: 2;
            }
            #btn-remove-preview {
                display: none;
            }
            #preview-iframe {
                width: 100%;
                height: 400px;
                background-image: url('https://www.youtube.com/img/desktop/yt_1200.png');
                background-size: cover;
                background-position: center center;
                border: 1px solid rgb(220, 220, 220);
                margin-top: 10px;
            }
        </style>
        <!-- TreeJS -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/three.js/105/three.js"></script>
        <!-- Panolens -->
        <script src="//cdn.jsdelivr.net/npm/panolens@0.11.0/build/panolens.min.js"></script>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        @if (sizeof($videos) < env('MAX_REST_360_VIDEO'))
                        <div class="text-right pb-3">
                            <button
                                class="btn button-color-template"
                                data-toggle="modal"
                                data-target="#add-video"
                            >Tải video lên <i class="fas fa-upload"></i></button>
                        </div>
                        @endif
                        @if (sizeof($videos) > 0)
                        <div class="wrap-video-360">
                            @foreach($videos as $video)
                            <div class="video-item" data-url="{{$video->url}}">
                                <form action="{{route('family_admin.delete_video_360', ['video_id' => $video->id])}}" method="post">
                                    @csrf
                                    <button class="btn-remove remove-video-item"><i class="fas fa-times"></i></button>
                                </form>
                                {{-- <div class="vr-360-video" data-url="{{route('get_360_video', $video->url)}}"></div> --}}
                                <div class="vr-youtube-video"></div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="alert text-center">Không có video nào</div>
                        @endif
                        <div id="wrap-paginate">
                            <div class="pt-md-4 d-flex justify-content-center">
                                {{ $videos->onEachSide(1)->render('pagination::default') }}</div>
                        </div>
                        <a href="{{route('family_admin.edit_user_view', $user_id)}}" class="btn btn-secondary"><i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="add-video" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form id="form-upload-vr-360-video" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tải lên video 360 độ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- <div id="preview-360">
                            <div class="btn-remove" id="btn-remove-preview"><i class="fas fa-times"></i></div>
                            <div id="container-preview"></div>
                            <input type="file" id="input-file" name="url">
                            <span>Kéo thả hoặc click vào đây</span>
                        </div> --}}
                        
                        <input type="text" name="url" class="form-control" id="youtube-url" placeholder="Đường dẫn youtube">
                        <i id="err_url" class="text-danger err_msg"></i>
                        <div id="preview-iframe"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button disabled id="btn-upload" type="button" class="btn button-color-template">
                            <span class="d-none loading">@include('global.loader')</span>
                            <span class="text">Tải lên</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const acceptVideoExtension = ['mp4', 'mov'];
        const maxVr360FileSize = 100000000;
        
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

        // Select file panorama
        $('#input-file').change(function(e) {
            let selectedFile = e.target.files[0];
            let extension = selectedFile.name.split('.').pop();
            let size = selectedFile.size;
            $('#btn-upload').prop('disabled', false);
            // Validate
            if (acceptVideoExtension.includes(extension) == false || size > maxVr360FileSize || selectedFile == null)
            {
                $('#btn-upload').prop('disabled', true);
                return;
            }
            $('#container-preview, #btn-remove-preview').css({'display':'inline-block'});
            let url = URL.createObjectURL(selectedFile);
            let containerPreview = document.getElementById('container-preview');
            let previewPanorama = new PANOLENS.VideoPanorama(url);
            let previewViewer = new PANOLENS.Viewer({
                container: containerPreview,
                controlBar: true,
                controlButtons: ['video']
            });
            previewViewer.add(previewPanorama);
        });
        // Remove preview video
        $('#btn-remove-preview').click(function(){
            $(this).css({'display': 'none'});
            document.getElementById('input-file').value = null;
            $('#btn-upload').prop('disabled', true);
            $('#container-preview').empty().attr('style', null).css({'display': 'none'});
        });
        // Upload file
        $('#btn-upload').click(function(e){
            e.preventDefault();
            let _this = $(this);
            _this.find('.loading').removeClass('d-none');
            _this.find('.text').addClass('d-none');
            let formData = new FormData($('#form-upload-vr-360-video')[0]);

            $.ajax({
                url: "{{ route('family_admin.create_video_360', ['user_id' => $user_id]) }}",
                type: 'POST',
                data: formData,
                cache : false,
                processData: false,
                contentType: false,
                success: function(data, textStatus, xhr) {
                    $('#add-video').modal('hide');
                    _this.find('.loading').addClass('d-none');
                    _this.find('.text').removeClass('d-none');
                    _this.prop('disabled', true);
                    //$('#btn-remove-preview').css({'display':'none'});
                    //document.getElementById('input-file').value = null;
                    //$('#container-preview').empty().attr('style', null).css({'display': 'none'});
                    location.reload();
                },
                error: function(xhr, error, errorThrown) {
                    if (xhr.status == 422) {
                        $('.err_msg').html("");
                        let resp = xhr.responseJSON.errors;
                        for (index in resp) {
                            $("#err_" + index).html(resp[index]);
                            console.log(resp[index]);
                        }
                    }
                    _this.find('.loading').addClass('d-none');
                    _this.find('.text').removeClass('d-none');
                }
            });
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

        $('#youtube-url').change(function()
        {
            const videoId = getId($(this).val());
            $('#btn-upload').prop('disabled', true);
            if (videoId != null) {
                $('#btn-upload').prop('disabled', false);
            }
            const iframeMarkup = `<iframe width="100%" height="100%" src="//www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
            $('#preview-iframe').html(iframeMarkup);
        });
    </script>
@endsection
