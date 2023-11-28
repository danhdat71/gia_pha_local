<!DOCTYPE html>
<html lang="en">

<head>
    @include('global.head')
</head>

<body class="hold-transition sidebar-mini layout-fixed" id="main">
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <div class="wrapper">
        @include('global.preloader')
        @include('root_admin.navbar')
        @include('root_admin.sidebar')
        @include('global.js_vendor')
        @yield('content')
    </div>
</body>
</html>