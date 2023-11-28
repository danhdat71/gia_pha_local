@extends('family_admin.main')
@section('content')
    <div class="content-wrapper">
        @include('global.content_head', [
            'title' => '3D an nghỉ',
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

            .wrap-vr-3d {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr 1fr;
                grid-gap: 20px;
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

            .btn-edit {
                position: absolute;
                z-index: 333;
                right: 10px;
                bottom: 5px;
            }

            .item-3D {
                width: 100%;
                height: 300px;
                position: relative;
                border: 1px solid #e7e7e7;
            }

            .item-3D .model-3d {
                width: 100%;
                height: 100%;
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
                        @if ($size_of_vr_3d <= env('MAX_VR_3D'))
                        <div class="text-right pb-3">
                            <a
                                href="{{route('family_admin.create_vr_3d', $user_id)}}"
                                class="btn button-color-template"
                            >Tải file lên <i class="fas fa-upload"></i></a>
                        </div>
                        @endif
                        @if (sizeof($vr3Ds) > 0)
                            <div class="wrap-vr-3d">
                            @foreach($vr3Ds as $vr3D)
                            <div class="item-3D">
                                <form action="{{route('family_admin.delete_vr_3d', $vr3D->id)}}" method="post">
                                    @csrf
                                    <button class="btn-remove"><i class="fas fa-times"></i></button>
                                </form>
                                <model-viewer
                                    class="model-3d"
                                    src="{{route('get_vr_3d', $vr3D->url)}}"
                                    camera-controls
                                    min-field-of-view="5deg"
                                    interpolation-decay="200"
                                    min-camera-orbit="auto auto 5%"
                                ></model-viewer>
                                <a href="{{route('family_admin.edit_vr_3d', $vr3D->id)}}" class="btn-edit btn-sm btn-warning"><i class="fas fa-edit"></i> Tùy chỉnh</a>
                                <div class="p-2 text-center">{{$vr3D->title}}</div>
                            </div>
                            @endforeach
                            </div>
                        @else
                        <div class="alert text-center">Không có 3D nào</div>
                        @endif
                        <div id="wrap-paginate">
                            <div class="pt-md-4 d-flex justify-content-center">
                                {{ $vr3Ds->onEachSide(1)->render('pagination::default') }}</div>
                        </div>
                        <div class="pt-3">
                            <a href="{{route('family_admin.edit_user_view', $user_id)}}" class="btn btn-secondary"><i class="fas fa-long-arrow-alt-left"></i> Quay lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        
    </script>
@endsection
