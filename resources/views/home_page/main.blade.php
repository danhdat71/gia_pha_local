<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sơ Đồ Gia Phả</title>
    <!-- AlertJs -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Datepicker -->
    <link rel="stylesheet" href="https://unpkg.com/js-datepicker/dist/datepicker.min.css">
    <!-- Fontawesome 5 -->
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet"
        type="text/css" />
    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- Base Url -->
    <link rel="stylesheet" href="css/base-css.css">
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    @include('home_page.social-body')

    <header>
        <div class="container">
            <div class="wrap-menu">
                <div class="wrap-logo">
                    <img src="img/fixed/logo_1.png" alt="logo_1.png">
                </div>
                <ul class="wrap-menu-items">
                    <li><a href="">Trang Chủ</a></li>
                    <li><a href="">Tài Liệu</a></li>
                    <li><a href="">Chi Phí</a></li>
                    <li><a href="{{ route('family_admin.login_view') }}">Đăng nhập</a></li>
                    <li><a class="button-1" href="#register-section">Đăng ký</a></li>
                </ul>
                <div class="wrap-menu-mobile">
                    <button class="button-toggle-mobile-menu">
                        <div class="icon-show">
                            <i class="fas fa-bars"></i>
                        </div>
                        <div class="icon-close">
                            <i class="fas fa-times"></i>
                        </div>
                    </button>
                    <div class="hamburger-mobile-menu">
                        <ul class="menu">
                            <li><a href="">Trang Chủ</a></li>
                            <li><a href="">Tài Liệu</a></li>
                            <li><a href="">Chi Phí</a></li>
                            <li><a href="{{ route('family_admin.login_view') }}">Đăng nhập</a></li>
                            <li id="register"><a href="#register-section">Đăng ký</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="section-1">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5 col-left">
                    <h1 class="main-title"><b>Xây dựng</b> hệ thống quản lý gia phả</h1>
                    <div class="sub-title">Tiện lợi, dễ sử dụng mọi lúc mọi nơi, phù hợp với mọi gia đình</div>
                    <a href="#register-section" class="button-1">Đăng ký miễn phí</a>
                </div>
                <div class="col-md-7 text-center">
                    <img src="img/fixed/family_logo_1.png" alt="family_logo_1.png">
                </div>
            </div>
        </div>
    </section>

    <section class="section-2">
        <div class="container">
            <div class="row align-items-center border-bottom-1">
                <div class="col-md-6 col-left col-image">
                    <img src="img/fixed/icon_family.png" alt="icon_family.png">
                </div>
                <div class="col-md-6 text-left">
                    <h1 class="title-1">Xây dựng & quản lý gia phả</h1>
                    <ul class="list-1">
                        <li>Hệ thống hóa thành viên trong gia phả</li>
                        <li>Khả năng mở rộng gia phả</li>
                        <li>Sử dụng cho mọi thành viên gia phả</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section-2">
        <div class="container">
            <div class="row align-items-center border-bottom-1">
                <div class="col-md-6">
                    <h1 class="title-1">Định hình thành viên</h1>
                    <ul class="list-1">
                        <li>Định hình thông tin mọi thành viên</li>
                        <li>Thông tin mọi thành viên</li>
                    </ul>
                </div>
                <div class="col-md-6 col-left col-image">
                    <img src="img/fixed/icon_family_1.png" alt="icon_family_1.png">
                </div>
            </div>
        </div>
    </section>

    <section class="section-3" id="register-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="title-2">Sẵn sàng dùng thử ?</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 m-auto">
                    <form action="" class="row" id="form-register">
                        <div class="col-md-12 col-input">
                            <label class="label-1" for="full_name">Tên gia phả <span class="text-danger">*</span></label>
                            <input class="input-1" type="text" name="title" id="title">
                            <span class="err-validate err_title"></span>
                        </div>
                        <div class="col-md-6 col-input">
                            <label class="label-1" for="full_name">Họ tên <span class="text-danger">*</span></label>
                            <input class="input-1" type="text" name="full_name" id="full_name">
                            <span class="err-validate err_full_name"></span>
                        </div>
                        <div class="col-md-6 col-input">
                            <label class="label-1" for="email">Email <span class="text-danger">*</span></label>
                            <input class="input-1" type="text" name="email" id="email">
                            <span class="err-validate err_email"></span>
                        </div>
                        <div class="col-md-6 col-input">
                            <label class="label-1" for="birthday">Sinh nhật <span class="text-danger">*</span></label>
                            <input class="input-1" type="text" id="birthday-preview" autocomplete="off">
                            <input type="hidden" name="birthday" id="birthday">
                            <span class="err-validate err_birthday"></span>
                        </div>
                        <div class="col-md-6 col-input">
                            <label class="label-1" for="gender">Giới tính <span
                                    class="text-danger">*</span></label>
                            <select name="gender" id="gender" class="input-1">
                                <option value="{{ App\Constants\Gender::MALE }}">Nam</option>
                                <option value="{{ App\Constants\Gender::FEMALE }}">Nữ</option>
                            </select>
                            <span class="err-validate err_gender"></span>
                        </div>
                        <div class="col-md-12 text-center col-button">
                            <button class="button-1">Đăng ký ngay</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <img class="w-60 h-100" src="img/fixed/icon_family_2.png" alt="icon_family_2.png">
                </div>
            </div>
        </div>
    </section>

    <footer class="border-top-1">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-footer-menu developer-team">
                    <div class="text-left"><img class="w-30" src="img/fixed/logo_1.png" alt="logo_1.png"></div>
                    <div class="text-1">Nhóm phát triển GiaPha Application</div>
                    <div class="text-1">© 2023 GiaPha, Inc.</div>
                    <div><a class="text-2" href="">Bảo mật & Điều khoản</a></div>
                </div>
                <div class="col-md-2 col-footer-menu">
                    <h5 class="title-3">Sử dụng</h5>
                    <ul class="footer-ul">
                        <li><a href="">Hướng dẫn</a></li>
                        <li><a href="">Chi phí</a></li>
                        <li><a href="{{ route('root_admin.login_view') }}">Quản trị</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-footer-menu">
                    <h5 class="title-3">Liên kết</h5>
                    <ul class="footer-ul">
                        <li><a target="_blank" href="{{ env('FACEBOOK_FANPAGE_URL') }}">Facebook</a></li>
                        <li><a target="_blank" href="{{ env('ZALO_URL') }}">Zalo</a></li>
                        <li><a target="_blank" href="mailto:{{ env('MAIL_ADMIN') }}">Gmail</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-footer-menu">
                    <h5>Liên kết</h5>
                    <div class="fb-page" data-href="https://www.facebook.com/profile.php?id=61550797722851"
                        data-tabs="timeline" data-width="" data-height="0" data-small-header="false"
                        data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                        <blockquote cite="https://www.facebook.com/facebook" class="fb-xfbml-parse-ignore"><a
                                href="https://www.facebook.com/facebook">Facebook</a></blockquote>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- AlertJs -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- datepicker -->
    <script src="https://unpkg.com/js-datepicker"></script>
    <script src="js/home.js"></script>
    <script>

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

        handleDatePicker("#birthday-preview", "#birthday", 'bl');

        $('#form-register').find('button').click(function(e) {
            e.preventDefault();
            let registerForm = new FormData($('#form-register')[0]);
            $('.err-validate').html('');
            $.ajax({
                url: "{{ route('user_register') }}",
                type: 'POST',
                data: registerForm,
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {
                    alertSuccess();
                    $('#form-register').find('input').val(null);
                },
                error: function(xhr, textStatus, errorThrown) {
                    let status = xhr.status;
                    if (status == 422) {
                        let resp = xhr.responseJSON.errors;
                        for (index in resp) {
                            $(".err_" + index).html(resp[index]);
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
