@extends('family_member.main')
@section('content')
@php
    $template = $templateId;
    $familyTitle = $family_tree->title;
@endphp
<div class="root-content genealogy genealogy-big-bg">
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
    <div class="container-fluid">
        <div id="tree"></div>
        <div id="none-member"></div>
    </div>
    <div class="modal fade" id="option" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 900px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tuỳ chọn</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="wrap-button-modal">
                        <div class="option-button-wrapper">
                            <button class="option-button" id="add-member-view">
                                <div><a href="" id="show-detail-user">Chi tiết</a></div>
                            </button>
                        </div>
                        <div class="option-button-wrapper">
                            <button class="option-button" id="edit-member-view">
                                <div><a data-id="" href="#" id="show-child">Con cái</a></div>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="vendor/lodash.min.js"></script>
<script src="vendor/d3.v4.min.js"></script>
<script src="vendor/dTree.min.js"></script>
<script>
    let data = {!! json_encode($members, JSON_UNESCAPED_SLASHES) !!};
    let template = '{{$templateId}}';
</script>
<script src="js/genealogy_config.js?version={{env('JS_VERSION')}}"></script>
<script>
    let tree = null;
    function renderTree(data)
    {
        $('#tree').empty();
        tree = dTree.init(data, {
            target: "#tree",
            debug: false,
            width: customeNode.width,
            height: customeNode.height,
            nodeWidth: customeNode.nodeWidth,
            callbacks: {
                nodeClick: function(name, extra, id) {
                    // console.log(this);
                    // let x = parseInt(this.attributes.x.value) + 50;
                    // let y = parseInt(this.attributes.y.value) + 350;
                    // tree.zoomTo(x, y, 1);
                },
                nodeRenderer: function(name, x, y, height, width, extra, id, nodeClass, textClass, textRenderer) {
                    function renderDetailUserButton(extra)
                    {
                        let url = `{{ route("family_member.detail_user") }}?id=${extra.id}`;
                        return `
                            <a
                                style="font-size: 7px;"
                                href="${url}"
                                class="button"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="Xem chi tiết thành viên"
                            ><i class="fas fa-info-circle"></i> Chi tiết</a>
                        `;
                    }
                    function renderLoadMoreChildButton(extra)
                    {
                        if (extra.is_main == true && extra.child_count > 0) {
                            return `<button
                                        style="font-size: 7px; cursor:pointer;"
                                        data-marriage-id="${extra?.marriage_id}"
                                        data-id="${extra?.id}"
                                        class="button show-child"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="Xem chi tiết thành viên"
                                    ><i class="fas fa-caret-down"></i> Con cái</button>
                                `;
                        }

                        return '';
                    }
                    return `
                        <div
                            data-id="${extra?.id}"
                            class="node tree-node-item nodeText"
                            id="node-${id}"
                            style="height: ${customeNode.nodeHeight}px; cursor:pointer;"
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
                                ${renderDetailUserButton(extra)}
                                ${renderLoadMoreChildButton(extra)}
                            </div>
                        </div>
                    `;
                },
                nodeHeightSeperation: function(nodeWidth, nodeMaxHeight) {
                    return customeNode.nodeSpacingY;
                },
            },
        });
    }
    renderTree(data);
    // Default zoom to page visit
    tree.zoomTo(
        customeNode.defaultShowZoomTo.x,
        customeNode.defaultShowZoomTo.y,
        customeNode.defaultShowZoomTo.z
    );


    function findNestedObj(entireObj, keyToFind, valToFind)
    {
        let foundObj;
        JSON.stringify(entireObj, (_, nestedValue) => {
            if (nestedValue && nestedValue[keyToFind] === valToFind) {
                foundObj = nestedValue;
            }
            return nestedValue;
        });
        return foundObj;
    };
    function appendChild(treeData, parentId, childData)
    {
        let find = findNestedObj(treeData, "node_user_id", parentId);
        if (find) {
            find.marriages[0].children = childData;
        }
    }

    $('#tree').on('click', '.show-child', function(e){
        e.preventDefault();
        let parent_marriage_id = $(this).attr('data-marriage-id');
        let id = $(this).attr('data-id');
        let _this = $(this);
        $.ajax({
            url: "{{ route('family_member.genealogy_loadmore') }}",
            type: 'POST',
            data: {
                parent_marriage_id : parent_marriage_id
            },
            success: function(result, textStatus, xhr) {
                console.log(result.data[0]);
                appendChild(data, parseInt(id), result.data[0]);
                renderTree(data);
                // Zoom to expand node
                let foreignObject = _this.closest('foreignObject');
                let x = parseInt(foreignObject.attr('x')) + 50;
                let y = parseInt(foreignObject.attr('y')) + 350;
                tree.zoomTo(x, y, 1);
            },
        });
    });
</script>
@stop