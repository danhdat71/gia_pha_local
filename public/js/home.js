function alertSuccess() {
    if (!alertify.alertSuccess) {
        alertify.dialog('alertSuccess', function factory() {
            return {
                build: function () {
                    var errorHeader = '<span class="fas fa-check-circle" '
                        + 'style="vertical-align:middle;color:rgb(0, 183, 0);">'
                        + '</span> Đăng ký thành công !';
                    this.setHeader(errorHeader);
                }
            };
        }, true, 'alert');
    }
    alertify
        .alertSuccess("Tài khoản của bạn sẽ có hiệu lực trong vòng 5-15 phút. Vui lòng check gmail để xác nhận !");
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let isShowMenu = false;
$('.button-toggle-mobile-menu').click(function(){
    if (isShowMenu == false) {
        $('.hamburger-mobile-menu').slideDown(400);
        $(this).find('.icon-show').hide();
        $(this).find('.icon-close').show();
        $('body').addClass('disable-scroll');
        isShowMenu = true;
    } else {
        $('.hamburger-mobile-menu').slideUp(400);
        $(this).find('.icon-show').show();
        $(this).find('.icon-close').hide();
        $('body').removeClass('disable-scroll');
        isShowMenu = false;
    }
});

$('.wrap-menu-mobile').find('#register').click(function(){
    $('.hamburger-mobile-menu').slideUp(200);
    $('.button-toggle-mobile-menu').find('.icon-show').show();
    $('.button-toggle-mobile-menu').find('.icon-close').hide();
    $('body').removeClass('disable-scroll');
    isShowMenu = false;
});