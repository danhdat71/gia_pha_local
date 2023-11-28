// Config
isBlackTheme = localStorage.getItem('isBlackTheme') != "" ? localStorage.getItem('isBlackTheme') : '0';
isFixed = localStorage.getItem('isFixed') != "" ? localStorage.getItem('isFixed') : '0';
isSideBarCollapse = localStorage.getItem('isSideBarCollapse') != "" ? localStorage.getItem('isSideBarCollapse') : '0';

$('.control-sidebar').on('click', '.os-content div', function(){
    if ($(this).find('span').text() == 'Dark Mode') {
        if ($(this).find('input').is(':checked')) {
            localStorage.setItem('isBlackTheme', '1');
        } else {
            localStorage.setItem('isBlackTheme', '0');
        }
    } else if ($(this).find('span').text() == 'Fixed') {
        if ($(this).find('input').is(':checked')) {
            localStorage.setItem('isFixed', '1');
        } else {
            localStorage.setItem('isFixed', '0');
        }
    }
});

$('#pushmenu').click(function(){
    if (isSideBarCollapse == 1) {
        localStorage.setItem('isSideBarCollapse', '0');
    } else {
        localStorage.setItem('isSideBarCollapse', '1');
    }
});

// Init
if (isBlackTheme == '1') {
    $('#main').addClass('dark-mode');
}

if (isFixed == '1') {
    $('#main').addClass('layout-fixed');
}

if (isSideBarCollapse == '1') {
    $('#main').addClass('sidebar-collapse');
}