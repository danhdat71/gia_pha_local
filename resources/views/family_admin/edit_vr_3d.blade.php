@extends('family_admin.main')
@section('content')
    <div class="content-wrapper">
        @include('global.content_head', [
            'title' => 'Tạo ngữ cảnh An Nghỉ 3D',
        ])
        <style>
            #wrap-preview-3D {
                width: 100%;
                height: 500px;
                overflow: hidden;
                transition: .3s;
                border: 1px solid #cdcdcd;
                position: relative;
            }
            #preview-3D {
                width: 100%;
                height: 100%;
                overflow: hidden;
            }
            #vr3d-guide {
                position: absolute;
                bottom: 0;
                left: 0;
                z-index: 10;
                padding: 10px;
                backdrop-filter: blur(10px);
            }

            .wrap-button-option {
                border: 1px dashed rgb(201, 201, 201);
                padding: 10px;
                margin-bottom: 10px;
            }

            input[type="range"] {
                -webkit-appearance: none;
                -moz-appearance: none;
                border-radius: 26px;
                height: 3px;
                cursor: pointer;
            }

            input[type="range"]::-webkit-slider-thumb {
                -webkit-appearance: none;
                -moz-appearance: none;
                width: 20px;
                height: 20px;
                border: 1px solid rgb(0, 53, 73);
                border-radius: 50%;
                background: rgb(0, 53, 73);
                box-shadow: 1px 2px 3px rgba(0, 0, 0, 0.6);
            }

            /* width */
            .scroll-bar-1::-webkit-scrollbar {
                width: 5px;
            }

            /* Track */
            .scroll-bar-1::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 999px;
            }

            /* Handle */
            .scroll-bar-1::-webkit-scrollbar-thumb {
                background: #bababa;
                border-radius: 999px;
            }

            /* Handle on hover */
            .scroll-bar-1::-webkit-scrollbar-thumb:hover {
                background: #858585;
            }

            #wrap-button {
                max-height: 500px;
                overflow-y: scroll;
                overflow-x: hidden;
            }
        </style>
        <!-- TreeJS -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/three.js/105/three.js"></script>
        <!-- 3D model viewer -->
        <script type="module" src="https://unpkg.com/@google/model-viewer"></script>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form action="" id="form-store-vr-3d">
                            <div class="row pb-2">
                                <div class="col-md-4">
                                    <label class="d-block" for="title">Tiêu đề ngữ cảnh <span class="text-danger">*</span></label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{$vr3D->title}}">
                                    <div class="text-danger font-italic err_msg" data-key="title"></div>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-md-4">
                                    <label class="d-block" for="vr-3d-file">Chọn file ngữ cảnh (.glb, .gltf) <span class="text-danger">*</span></label>
                                    <input type="file" id="vr-3d-file" name="vr_3d_file">
                                    <div class="text-danger font-italic err_msg" data-key="vr_3d_file"></div>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-12">
                                    <div id="wrap-preview-3D">
                                        <model-viewer
                                            id="preview-3D"
                                            src="{{route('get_vr_3d', $vr3D->url)}}"
                                            camera-controls
                                            min-field-of-view="5deg"
                                            interpolation-decay="200"
                                            min-camera-orbit="auto auto 5%"
                                        >
                                        @foreach($vr3D->vr3Dbuttons as $button)
                                        <button class="btn btn-sm btn-info" id="{{$button->id}}" slot="hotspot-${buttonId}" data-position="{{$button->button_x}}m {{$button->button_y}}m {{$button->button_z}}m">{{$button->title}}</button>
                                        @endforeach
                                        </model-viewer>
                                        <div id="vr3d-guide">
                                            <div class="text-sm"><i>Cuộn chuột để phóng to, thu nhỏ</i></div>
                                            <div class="text-sm"><i>Đè giữ chuột trái và di chuột để xoay quanh vật thể</i></div>
                                            <div class="text-sm"><i>Đè giữ chuột phải và di chuột để di chuyển vật thể</i></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-md-12 text-right">
                                    @if (sizeof($vr_3ds) > 0)
                                    <button
                                        id="add-button"
                                        class="btn btn-info"
                                    >+ Thêm nút di chuyển ngữ cảnh</button>
                                    @endif
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-md-7">
                                    <div id="wrap-button" class="scroll-bar-1">
                                        @foreach ($vr3D->vr3Dbuttons as $button)
                                        <div class="wrap-button-option" data-id="{{$button->id}}">
                                            <div class="form-group">
                                                <label for="">Tên nút <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control input-rename-button" value="{{$button->title}}" name="buttons[{{$button->id}}][title]">
                                                <div class="text-sm text-danger font-italic err_msg" data-key="buttons.{{$button->id}}.title"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Chiều ngang (x) <span class="text-danger">*</span></label>
                                                <input type="range" class="form-control input-x" min="-100" max="100" step="0.000000000000001" value="{{$button->button_x}}" name="buttons[{{$button->id}}][button_x]">
                                                <div class="text-sm text-danger font-italic" id="err_button_x"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Chiều cao (y)<span class="text-danger">*</span></label>
                                                <input type="range" class="form-control input-y" min="-100" max="100" step="0.000000000000001" value="{{$button->button_y}}" name="buttons[{{$button->id}}][button_y]">
                                                <div class="text-sm text-danger font-italic" id="err_button_y"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Chiều dọc (z)<span class="text-danger">*</span></label>
                                                <input type="range" class="form-control input-z" min="-100" max="100" step="0.000000000000001" value="{{$button->button_z}}" name="buttons[{{$button->id}}][button_z]">
                                                <div class="text-sm text-danger font-italic" id="err_button_z"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Ngữ cảnh cần dịch chuyển tới <span class="text-danger">*</span></label>
                                                <select class="form-control select-to-vr-3d" name="buttons[{{$button->id}}][to_vr_3d_id]">
                                                    @foreach($vr_3ds as $vr3DSelect)
                                                    <option
                                                        value="{{$vr3DSelect->id}}"
                                                        @if ($vr3DSelect->id == $button->to_vr_3d_id)
                                                        selected
                                                        @endif
                                                    >{{$vr3DSelect->title}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="text-sm text-danger font-italic err_msg" data-key="buttons.{{$button->id}}.to_vr_3d_id"></div>
                                            </div>
                                            <div class="text-right">
                                                <button class="btn btn-sm btn-success recovery-button-item"><i class="fas fa-undo-alt"></i> Khôi phục</button>
                                                <button class="btn btn-sm btn-danger remove-button-item"><i class="far fa-trash-alt"></i> Xóa</button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="col-md-12 text-right">
                                    <a href="{{route('family_admin.index_vr_3d', $user_id)}}" class="btn btn-info"><i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>
                                    <button class="btn btn-success" id="submit-save-all-btn">Lưu toàn bộ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        const wrapButtons = $('#wrap-button');
        const previewVr3D = $('#preview-3D');
        const submitSave = $('#submit-save-all-btn');
        const addButton = $('#add-button');
        const acceptFileExtension = ['glb', 'gltf'];
        const vr3ds = @json($vr_3ds);

        //Choice file
        $('#vr-3d-file').change(function(e){
            let file3D = e.target.files[0];
            let fileExtension = file3D.name.split('.').pop();
            wrapButtons.empty();
            previewVr3D.empty();
            $('#err_vr_3d_file').text('');
            if (file3D) {
                if (acceptFileExtension.includes(fileExtension) == false) {
                    submitSave.prop('disabled', true);
                    $('#err_vr_3d_file').text('Định dạng file không hỗ trợ !');
                    return;
                }
                submitSave.prop('disabled', false);
                addButton.prop('disabled', false);
                let src = URL.createObjectURL(file3D);
                previewVr3D.attr('src', src);
            }
        });

        // Add button
        addButton.click(function(e) {
            e.preventDefault();
            let id = getId();
            wrapButtons.append(itemButtonDom(id, vr3ds));
            previewVr3D.append(vr3DbuttonDom(id));
        });
        // Remove button
        wrapButtons.on('click', '.remove-button-item', function(e) {
            e.preventDefault();
            $(this).closest('.wrap-button-option').remove();
        });
        // Move button
        wrapButtons.on('input', '.input-x', function(e) {
            let value = $(this).val();
            let buttonId = $(this).closest('.wrap-button-option').attr('data-id');
            let dataPosition = $(`#${buttonId}`).attr('data-position');
            let {x, y, z} = getPostionValue(dataPosition);
            let buttonName = $(`#${buttonId}`).text();
            let strPostion = `${value}m ${y}m ${z}m`;
            rerenderVr3dDom(buttonId, strPostion, buttonName);
        });
        wrapButtons.on('input', '.input-y', function(e) {
            let value = $(this).val();
            let buttonId = $(this).closest('.wrap-button-option').attr('data-id');
            let dataPosition = $(`#${buttonId}`).attr('data-position');
            let buttonName = $(`#${buttonId}`).text();
            let {x, y, z} = getPostionValue(dataPosition);
            let strPostion = `${x}m ${value}m ${z}m`;
            rerenderVr3dDom(buttonId, strPostion, buttonName);
        });
        wrapButtons.on('input', '.input-z', function(e) {
            let value = $(this).val();
            let buttonId = $(this).closest('.wrap-button-option').attr('data-id');
            let dataPosition = $(`#${buttonId}`).attr('data-position');
            let buttonName = $(`#${buttonId}`).text();
            let {x, y, z} = getPostionValue(dataPosition);
            let strPostion = `${x}m ${y}m ${value}m`;
            rerenderVr3dDom(buttonId, strPostion, buttonName);
        });
        // Rename button
        wrapButtons.on('input', '.input-rename-button', function(){
            let buttonId = $(this).closest('.wrap-button-option').attr('data-id');
            let value = $(this).val();
            let dataPosition = $(`#${buttonId}`).attr('data-position');
            let {x, y, z} = getPostionValue(dataPosition);
            let strPostion = `${x}m ${y}m ${z}m`;
            rerenderVr3dDom(buttonId, strPostion, value);
        });
        // Remove button
        wrapButtons.on('click', '.remove-button-item', function(e){
            e.preventDefault();
            let buttonId = $(this).closest('.wrap-button-option').attr('data-id');
            $(this).closest('.wrap-button-option').remove();
            $(`#${buttonId}`).remove();
        });
        wrapButtons.on('click', '.recovery-button-item', function(e){
            e.preventDefault();
            let buttonId = $(this).closest('.wrap-button-option').attr('data-id');
            let strPostion = `0m 0m 0m`;
            rerenderVr3dDom(buttonId, strPostion, buttonId);
            $(this).closest('.wrap-button-option').find('input[type="range"]').val(0);
            $(this).closest('.wrap-button-option').find('input[type="text"]').val(buttonId);
        });

        function getPostionValue(dataPosition)
        {
            let valueX = dataPosition.split(' ')[0].split('m')[0];
            let valueY = dataPosition.split(' ')[1].split('m')[0];
            let valueZ = dataPosition.split(' ')[2].split('m')[0];

            return {
                'x' : valueX,
                'y' : valueY,
                'z' : valueZ
            };
        }

        function rerenderVr3dDom(buttonId, position, buttonName = 'Nút di chuyển')
        {
            let buttonDom = `<button class="btn btn-sm btn-info" id="${buttonId}" slot="hotspot-${buttonId}" data-position="${position}">
                ${buttonName}
            </button>`;
            $(`#${buttonId}`).remove();
            previewVr3D.append(buttonDom);
        };

        function vr3DbuttonDom(buttonId)
        {
            return `<button class="btn btn-sm btn-info" id="${buttonId}" slot="hotspot-${buttonId}" data-position="0m 0m 0m">
                ${buttonId}
            </button>`;
        };

        function itemButtonDom(buttonId, vr3Ds = [])
        {
            let options = ``;
            for (let i = 0; i < vr3Ds.length; i++) {
                let vr3d = vr3Ds[i];
                options += `<option value="${vr3d.id}">${vr3d.title}</option>`;
            }
            return `<div class="wrap-button-option" data-id="${buttonId}">
                <div class="form-group">
                    <label for="">Tên nút <span class="text-danger">*</span></label>
                    <input type="text" class="form-control input-rename-button" value="${buttonId}" name="buttons[${buttonId}][title]">
                    <div class="text-sm text-danger font-italic err_msg" data-key="buttons.${buttonId}.title"></div>
                </div>
                <div class="form-group">
                    <label for="">Chiều ngang (x) <span class="text-danger">*</span></label>
                    <input type="range" class="form-control input-x" min="-100" max="100" step="0.000000000000001" value="0" name="buttons[${buttonId}][button_x]">
                    <div class="text-sm text-danger font-italic" id="err_button_x"></div>
                </div>
                <div class="form-group">
                    <label for="">Chiều cao (y)<span class="text-danger">*</span></label>
                    <input type="range" class="form-control input-y" min="-100" max="100" step="0.000000000000001" value="0" name="buttons[${buttonId}][button_y]">
                    <div class="text-sm text-danger font-italic" id="err_button_y"></div>
                </div>
                <div class="form-group">
                    <label for="">Chiều dọc (z)<span class="text-danger">*</span></label>
                    <input type="range" class="form-control input-z" min="-100" max="100" step="0.000000000000001" value="0" name="buttons[${buttonId}][button_z]">
                    <div class="text-sm text-danger font-italic" id="err_button_z"></div>
                </div>
                <div class="form-group">
                    <label for="">Ngữ cảnh cần dịch chuyển tới <span class="text-danger">*</span></label>
                    <select class="form-control select-to-vr-3d" name="buttons[${buttonId}][to_vr_3d_id]">
                        ${options}
                    </select>
                    <div class="text-sm text-danger font-italic err_msg" data-key="buttons.${buttonId}.to_vr_3d_id"></div>
                </div>
                <div class="text-right">
                    <button class="btn btn-sm btn-success recovery-button-item"><i class="fas fa-undo-alt"></i> Khôi phục</button>
                    <button class="btn btn-sm btn-danger remove-button-item"><i class="far fa-trash-alt"></i> Xóa</button>
                </div>
            </div>`
        };

        function getId(length = 20)
        {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            let counter = 0;
            while (counter < length) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
                counter += 1;
            }
            return result;
        }

        // Submit store
        submitSave.click(function(e){
            e.preventDefault();
            let formData = new FormData($('#form-store-vr-3d')[0]);
            $('.err_msg').text('');
            $.ajax({
                url: "{{ route('family_admin.update_vr_3d', $vr3D->id) }}",
                type: 'POST',
                data: formData,
                cache : false,
                processData: false,
                contentType: false,
                success: function(result) {
                    location.href = `family-admin/{{$user_id}}/user-vr/vr-3d`;
                },
                error: function(xhr) {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    if (xhr.status == 422) {
                        let errors = xhr.responseJSON.errors;
                        // Validate buttons
                        let errorKeys = Object.keys(errors);
                        errorKeys.map(function(item, index) {
                            console.log(item);
                            $(`div[data-key='${item}']`).text( errors[item] );
                        });
                    }
                    
                }
            });
        })
    </script>
@endsection
