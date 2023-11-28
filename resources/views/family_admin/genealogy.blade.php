@extends('family_admin.main')
@section('content')
    @php
        $template = $templateId;
        $familyTitle = $family_tree->title;
    @endphp
    <div class="content-wrapper genealogy-big-bg">
        @include('global.content_head', [
            'title' => 'Cây gia phả',
        ])
        @if ($template == 1)
            <section class="title text-center pt-2 pb-2">
                <div class="wrap-main-title ml-5 mr-5">
                    <div class="wrap-title-text">
                        <div>Phả Đồ</div>
                        <div>{{$familyTitle}}</div>
                    </div>
                    <img src="img/fixed/title_bg_default.png" alt="title_bg_default">
                </div>
            </section>
        @elseif ($template == 2)
            <section class="big-title-family-name">
                <img class="dragon-left dragon-img" src="img/fixed/rong_2.png" alt="rong_1">
                <div class="wrap-main-title">
                    <div class="wrap-title-text">
                        <div>Phả Đồ Tộc</div>
                        <div class="family-name">{{$familyTitle}}</div>
                    </div>
                    <img class="border-title-img" src="img/fixed/title_bg_1.png" alt="title_bg_1">
                </div>
                <img class="dragon-right dragon-img" src="img/fixed/rong_1.png" alt="rong_1">
            </section>
        @elseif ($template == 3)
            <section class="title text-center pt-2 pb-2">
                <div class="d-flex align-items-center wrap-title">
                    <img class="dragon-left" src="img/fixed/thu_phap_trai_1.png" alt="thu_phap_trai_1">
                    <div class="wrap-main-title ml-5 mr-5">
                        <div class="wrap-title-text">
                            <div>{{$familyTitle}}</div>
                        </div>
                        <img src="img/fixed/title_bg_4.png" alt="title_bg_1">
                    </div>
                    <img class="dragon-right" src="img/fixed/thu_phap_phai_1.png" alt="thu_phap_phai_1">
                </div>
                <div class="wrap-main-title-mobile m-auto">
                    <div class="wrap-title-text">
                        <div>{{$familyTitle}}</div>
                    </div>
                    <img src="img/fixed/title_bg_4.png" alt="title_bg_1">
                </div>
            </section>
        @elseif ($template == 4)
            <section class="title text-center pt-2 pb-2">
                <div class="d-flex align-items-center justify-content-between flex-dragon">
                    <div class="dragon-item">
                        <img class="dragon-img" src="img/fixed/rong_2_left.png" alt="rong_2_left">
                    </div>
                    <div class="family-title-main">
                        <div class="family-title-text">
                            <div>{{$familyTitle}}</div>
                        </div>
                        <img src="img/fixed/title_bg_5.png" alt="title_bg_5">
                    </div>
                    <div class="dragon-item">
                        <img class="dragon-img" src="img/fixed/rong_2_right.png" alt="rong_2_right">
                    </div>
                </div>
            </section>
        @endif
        <section class="content">
            <div class="container-fluid">
                <div id="tree"></div>
            </div>
            {{-- Modal Confirm Delete Member --}}
            <div class="modal fade" id="confirm-delete-member-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc muốn xóa thành viên này ?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-sm w-100 btn-secondary" data-dismiss="modal">Hủy</button>
                                </div>
                                <form class="col-6" id="form-delete-member" method="post">
                                    @csrf
                                    <button class="btn btn-sm w-100 btn-danger">Xóa</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="vendor/lodash.min.js"></script>
    <script src="vendor/d3.v4.min.js"></script>
    <script src="vendor/dTree.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        let data = {!! json_encode($members, JSON_UNESCAPED_SLASHES) !!};
        let template = '{{$templateId}}';
        console.log(data);
    </script>
    <script src="js/genealogy_config.js"></script>
    <script>
        $( "[name=birthday]" ).datepicker({
            dayNamesMin: [ "T2", "T3", "T4", "T5", "T6", "T7", "CN" ],
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            dateFormat: "yy-mm-dd",
        });

        const tree = dTree.init(data, {
            target: "#tree",
            debug: false,
            width: customeNode.width,
            height: customeNode.height,
            nodeWidth: customeNode.nodeWidth,
            callbacks: {
                nodeClick: function(name, extra, id) {
                    // console.log(this);
                    // let x = parseInt(this.attributes.x.value) + 50;
                    // let y = parseInt(this.attributes.y.value) + 250;
                    // tree.zoomTo(x, y, 1);
                },
                nodeRightClick: function(name, extra, id) {
                    console.log(id);
                },
                nodeRenderer: function(name, x, y, height, width, extra, id, nodeClass, textClass, textRenderer) {

                    function renderAddMemberButton(extra)
                    {
                        let url = '{{ route("family_admin.add_user_view", ":from_member") }}';
                        url = url.replace(':from_member', extra.id);
                        let button = ``;
                        if (extra?.is_main == 1) {
                            button = `
                                <a
                                    href="${url}"
                                    class="button"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="Tạo mới thành viên"
                                ><i class="fas fa-user-plus"></i></a>
                            `;
                        }
                        return button;
                    }
                    function renderDeleteButton(extra)
                    {
                        let button = `
                            <button
                                class="button button-delete-member"
                                data-id="${extra.id}"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="Xóa thành viên này"
                            ><i class="fas fa-trash-alt"></i></button>`;

                        // Case spouse parent or main parent has child
                        if (extra.child_count > 0) {
                            button = '';
                        }

                        // Case main parent and has marriages
                        if (extra.is_main && extra.spouse_count > 0) {
                            button = '';
                        }

                        // Case main parent only a member in family
                        if (extra.is_main && extra.spouse_count == 0 && extra.child_count == 0 && !extra.has_parent) {
                            button = '';
                        }


                        return button;
                    }
                    function renderEditUserButton(extra)
                    {
                        let url = '{{ route("family_admin.edit_user_view", ":id") }}';
                        url = url.replace(':id', extra.id);

                        return `
                        <a
                            href="${url}"
                            class="button"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Sửa thông tin thành viên"
                        ><i class="far fa-user-edit"></i></a>`;
                    }
                    function renderDetailUserButton(extra)
                    {
                        let url = '{{ route("family_admin.detail_user", ":id") }}';
                        url = url.replace(':id', extra.id);

                        return `
                            <a
                                href="${url}"
                                class="button"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="Xem chi tiết thành viên"
                            ><i class="fas fa-info-circle"></i></a>
                        `;
                    }

                    return `
                        <div
                            data-id=""
                            class="node tree-node-item nodeText"
                            id="node-${id}"
                            style="height: ${customeNode.nodeHeight}px;"
                        >
                            <div class="node-top">
                                <div class="wrap-image">
                                    <img src="${extra.full_avatar_node ? extra.full_avatar_node : 'img/fixed/default_avatar_1.png'}" loading="lazy" />
                                </div>
                            </div>
                            <div class="wrap-node-content">
                                <div class="node-role-name">${extra?.role_name}</div>
                                <div class="node-full-name">${extra?.full_name}</div>
                                <div class="node-birthday">${extra?.birthday}</div>
                                <div class="node-leaveday">${extra?.leaveday}</div>
                            </div>

                            <div class="button-bar-node-item">
                                ${renderAddMemberButton(extra)}
                                ${renderEditUserButton(extra)}
                                ${renderDeleteButton(extra)}
                                ${renderDetailUserButton(extra)}
                            </div>
                        </div>
                    `;
                },
                nodeHeightSeperation: function(nodeWidth, nodeMaxHeight) {
                    return customeNode.nodeSpacingY;
                },
            },
        });
        // Default zoom to page visit
        tree.zoomTo(
            customeNode.defaultShowZoomTo.x,
            customeNode.defaultShowZoomTo.y,
            customeNode.defaultShowZoomTo.z
        );

        // Confirm delete member
        $('#tree').on('click', '.button-delete-member', function(){
            $('#confirm-delete-member-modal').modal('show');
            let id = $(this).attr('data-id');

            let url = '{{ route("family_admin.delete_user", ":id") }}';
            url = url.replace(':id', id);
            $('#form-delete-member').attr('action', url);
        });
    </script>
@endsection
