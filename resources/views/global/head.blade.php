<base href="/">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gia Phả | Dashboard</title>
<link rel="icon" type="image/x-icon" href="img/fixed/logo.png">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet"
    href="vendor/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="vendor/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="vendor/adminlte/plugins/jqvmap/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="vendor/adminlte/dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="vendor/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="vendor/adminlte/plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="vendor/adminlte/plugins/summernote/summernote-bs4.min.css">
<!-- datepicker -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<!-- Datatable -->
<link rel="stylesheet" href="vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="vendor/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="vendor/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Date picker -->
<link rel="stylesheet" href="https://unpkg.com/js-datepicker/dist/datepicker.min.css">
<!-- Fancybox -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
<!-- Base template -->
<link rel="stylesheet" href="css/template.css?version={{env('CSS_VERSION')}}">
<style>
    .wrap-paginate-default li {
        display: inline-block;
        width: 30px;
        height: 30px;
        margin: 0 4px;
    }

    .wrap-paginate-default li a,
    .wrap-paginate-default li span {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        background: #e2e2e2;
        color: black;
        text-decoration: none;
    }

    .wrap-paginate-default li.active a,
    .wrap-paginate-default li.active span {
        background: white;
    }

    .wrap-paginate-default .pagination {
        justify-content: center;
        padding: 10px 0;
    }
</style>
