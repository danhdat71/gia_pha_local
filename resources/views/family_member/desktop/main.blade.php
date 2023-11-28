<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, AdminWrap lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, AdminWrap lite design, AdminWrap lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="AdminWrap Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>{{$pageTitle}}</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/adminwrap-lite/" />
    <!-- Font Awesome -->
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" type="text/css" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="vendor/admin-user/assets/images/favicon.png">
    <!-- Bootstrap Core CSS -->
    <link href="vendor/admin-user/assets/node_modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/admin-user/assets/node_modules/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="vendor/admin-user/assets/node_modules/morrisjs/morris.css" rel="stylesheet">
    <!--c3 CSS -->
    <link href="vendor/admin-user/assets/node_modules/c3-master/c3.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="vendor/admin-user/html/css/style.css" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="vendor/admin-user/html/css/pages/dashboard1.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="vendor/admin-user/html/css/colors/default.css" id="theme" rel="stylesheet">
    <!-- Custome template -->
    <link href="css/template.css?version={{env('CSS_VERSION')}}" id="theme" rel="stylesheet">
    <link rel="stylesheet" href="css/family-member-desktop.css?version={{env('CSS_VERSION')}}">
    <script src="vendor/admin-user/assets/node_modules/jquery/jquery.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script>
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
    </script>
</head>
<body class="fix-header fix-sidebar card-no-border template-{{$templateId}}">
    <audio autoplay loop src="{{$audioLink}}" id="audioLink"></audio>
    <div id="main-wrapper">
        @include('family_member.desktop.header')
        @include('family_member.desktop.preloader')
        @include('family_member.desktop.aside', ['currentPage' => $currentPage])
        <div
            @if ($templateId == 1)
            class="page-wrapper"
            @elseif($templateId == 2)
            class="page-wrapper bg-default-2"
            @elseif ($templateId == 3)
            class="page-wrapper bg-default-3"
            @elseif ($templateId == 4)
            class="page-wrapper bg-default-4"
            @endif
            
        >
            <div
                @if (request()->route()->getName() == 'family_member.genealogy')
                class="container-fluid genealogy-big-bg"
                @else
                class="container-fluid"
                @endif
            >
                @include('family_member.desktop.breadcrumb', ['pageTitle' => $pageTitle])
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="vendor/admin-user/assets/node_modules/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="vendor/admin-user/html/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="vendor/admin-user/html/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="vendor/admin-user/html/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="vendor/admin-user/html/js/custom.min.js"></script>
    <!--morris JavaScript -->
    <script src="vendor/admin-user/assets/node_modules/raphael/raphael-min.js"></script>
    <script src="vendor/admin-user/assets/node_modules/morrisjs/morris.min.js"></script>
    <!--c3 JavaScript -->
    <script src="vendor/admin-user/assets/node_modules/c3-master/c3.min.js"></script>
    <!-- Chart JS -->
    <script src="vendor/admin-user/html/js/dashboard1.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Background video
        let audioLink = '{{$audioLink}}';
        if (audioLink) {
            let savedCurrentTime = sessionStorage.getItem('currentTime');
            const audioPlayer = document.getElementById("audioLink");
            if (savedCurrentTime) {
                audioPlayer.currentTime = parseFloat(savedCurrentTime);
            }
            audioPlayer.ontimeupdate = function() {
                let currentTime = audioPlayer.currentTime;
                sessionStorage.setItem('currentTime', currentTime);
            };
        }
        // Datepick
        function formatDate(date)
        {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) 
                month = '0' + month;
            if (day.length < 2) 
                day = '0' + day;

            return [year, month, day].join('-');
        }
        function formatDateToDmy(date)
        {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}-${month}-${year}`;
        }
        function handleDatePicker(id, hiddenId, position = 'bl')
        {
            const configDate = {
                customDays: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
                customMonths: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                position: position,
                formatter: (input, date, instance) => {
                    // const value = date.toLocaleDateString('vi-VN');
                    input.value = formatDateToDmy(date);
                },
            }
            datepicker(id, {
                ...configDate,
                onSelect : function(instance, date) {
                    $(hiddenId).val(formatDate(date));
                }
            });
        }

        // Select 2
        $('.select-2').select2();
    </script>
</body>
</html>
