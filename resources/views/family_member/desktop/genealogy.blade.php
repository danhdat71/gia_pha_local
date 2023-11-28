@extends('family_member.desktop.main')
@section('content')
@php
    $template = $templateId;
    $familyTitle = $family_tree->title;
@endphp
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
<script src="vendor/lodash.min.js"></script>
<script src="vendor/d3.v4.min.js"></script>
<script src="vendor/dTree.min.js"></script>
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100 card-genealogy">
            <div class="card-body">
                <div id="tree"></div>
            </div>
        </div>
    </div>
</div>
<script>
    let data = {!! json_encode($members, JSON_UNESCAPED_SLASHES) !!};
    let template = '{{$templateId}}';
</script>
<script src="js/genealogy_config.js?version={{env('JS_VERSION')}}"></script>
<script>
    const tree = dTree.init(data, {
        target: "#tree",
        debug: false,
        width: customeNode.width,
        height: customeNode.height,
        nodeWidth: customeNode.nodeWidth,
        callbacks: {
            nodeRenderer: function(name, x, y, height, width, extra, id, nodeClass, textClass, textRenderer) {
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

    $('#tree').on('click', '.tree-node-item', function() {
        let id = $(this).attr('data-id');
        location.href = `{{route('family_member.detail_user')}}?id=${id}`;
    });
</script>
@endsection