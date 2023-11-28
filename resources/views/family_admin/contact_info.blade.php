@extends('family_admin.main')
@section('content')
    <div class="content-wrapper">
        @include('global.content_head', [
            'title' => 'Thông tin liên hệ',
        ])
        <style>
            #btn-remove-audio-link {
                margin-top: 32px;
            }
        </style>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-template">Thông tin liên hệ</div>
                            <div class="card-body">
                                <form action="{{route('family_admin.contact_info_update')}}" method="post" class="row">
                                    @csrf
                                    <div class="col-md-12">
                                        @if(session('message_1'))
                                        <div class="alert table-header-template">{{session('message_1')}}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Số điện thoại</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="phone"
                                                id="phone"
                                                value="{{old('phone', $info->phone ?? null)}}"
                                            >
                                            @error('phone')
                                                <i class="text-danger">{{$message}}</i>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Địa chỉ email</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="email"
                                                id="email"
                                                value="{{old('email', $info->email ?? null)}}"
                                            >
                                            @error('email')
                                                <i class="text-danger">{{$message}}</i>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="contact_person">Người liên hệ</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="contact_person"
                                                id="contact_person"
                                                value="{{old('contact_person', $info->contact_person ?? null)}}"
                                            >
                                            @error('contact_person')
                                                <i class="text-danger">{{$message}}</i>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="position">Chức vụ</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="position"
                                                id="position"
                                                value="{{old('position', $info->position ?? null)}}"
                                            >
                                            @error('position')
                                                <i class="text-danger">{{$message}}</i>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Địa chỉ</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                name="address"
                                                id="address"
                                                value="{{old('address', $info->address ?? null)}}"
                                            >
                                            @error('address')
                                                <i class="text-danger">{{$message}}</i>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <button class="btn button-color-template">Cập nhật</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-template">Thông tin gia phả</div>
                            <div class="card-body">
                                <form id="form-family-tree-config" action="{{route('family_admin.family_tree_info_update')}}" method="post" class="row">
                                    @csrf
                                    <div class="col-md-12">
                                        @if(session('message_2'))
                                        <div class="alert table-header-template">{{session('message_2')}}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title">Tiêu đề gia phả</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Trần Nguyễn Lê"
                                                name="title"
                                                id="title"
                                                value="{{old('title', $familyTreeInfo->title)}}"
                                            >
                                            <i class="text-danger err_title"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="background-audio">Nhạc nền <a href=""><i>Xem quyền và trách nhiệm</i></a></label>
                                                    <input
                                                        type="file"
                                                        class="form-control"
                                                        name="audio_link"
                                                        id="background-audio"
                                                        accept="audio/*"
                                                    >
                                                    <i class="text-danger err_audio_link"></i>
                                                </div>
                                                <div class="col-md-5">
                                                    <audio
                                                        class="mt-4 w-100"
                                                        controls
                                                        autoplay
                                                        loop
                                                        id="background-audio-listen"
                                                        @if ($familyTreeInfo->audio_link)
                                                        src="{{$familyTreeInfo->audio_link}}"
                                                        @endif
                                                    ></audio>
                                                </div>
                                                <div class="col-md-1 text-right">
                                                    <input type="hidden" name="is_del_audio_link" id="is_del_audio_link">
                                                    @if ($familyTreeInfo->audio_link)
                                                    <button
                                                        id="btn-remove-audio-link"
                                                        class="btn btn-danger btn-sm"
                                                    >Gỡ âm thanh</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="description">Giới thiệu gia phả</label>
                                        <textarea id="description" name="description">{{old('description', $familyTreeInfo->description)}}</textarea>
                                        <i class="text-danger err_description"></i>
                                    </div>
                                    <div class="col-md-12 text-right pt-2">
                                        <button id="update-family-tree-config" class="btn button-color-template">Cập nhật</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        let editor = CKEDITOR.replace('description', configCkeditor);

        $('#background-audio').change(function(e){
            let file = e.target.files[0];
            let url = URL.createObjectURL(file);
            $('#is_del_audio_link').attr('value', 0);
            $('#background-audio-listen').attr('src', url);
        });

        $('#update-family-tree-config').click(function(e){
            e.preventDefault();
            let data = new FormData($('#form-family-tree-config')[0]);
            data.append('description', CKEDITOR.instances['description'].getData());
            $.ajax({
                url: "{{ route('family_admin.family_tree_info_update') }}",
                type: 'POST',
                data: data,
                cache : false,
                processData: false,
                contentType: false,
                success: function(data) {
                    location.reload();
                },
                error: function (res, stt, error) {
                    let status = res.status;
                    let resp = res.responseJSON.errors;
                    $('.text-danger').html("");
                    if (status == 422) {
                        for (index in resp) {
                            $(".err_" + index).html(resp[index]);
                        }
                    }
                }
            });
        });

        $('#btn-remove-audio-link').click(function(e){
            e.preventDefault();
            $('#is_del_audio_link').attr('value', 1);
            document.getElementById('background-audio-listen').src = '';
        })
    </script>
@endsection
