<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Gia Phả | {{ $pageTitle }}</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet"
        type="text/css" />
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- Style -->
    <link rel="stylesheet" href="css/family_member.css">
    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Datepicker -->
    <link rel="stylesheet" href="https://unpkg.com/js-datepicker/dist/datepicker.min.css">
    <!-- Alert -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <!-- Custome UI template -->
    <link rel="stylesheet" href="css/template.css?version={{env('CSS_VERSION')}}">
    <link rel="stylesheet" href="css/family-member-mobile.css?version={{env('CSS_VERSION')}}">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body class="template-{{$templateId}}">
    <audio autoplay loop src="{{ $audioLink }}" id="audioLink"></audio>
    @include('family_member.mobile.header')
    @yield('content')
    @include('family_member.mobile.footer')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- datepicker -->
    <script src="https://unpkg.com/js-datepicker"></script>
    <!-- Alert -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script>
        let audioLink = '{{ $audioLink }}';
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

        function handleDatePicker(id, hiddenId, position) {
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
                onSelect: function(instance, date) {
                    $(hiddenId).val(formatDate(date));
                }
            });
        }
        // Select2
        $('.select-2').select2();
        // Play audio
        $('html').click(function(){
            //document.getElementById('audioLink').play();
        });
    </script>
</body>
</html>
