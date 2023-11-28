let customeNode = {};

console.log('width', window.screen.width);

if (template == 1) {
    if (window.screen.width >= 500) {
        customeNode = {
            width: 1200,
            height: 800,
            nodeWidth: 150,
            nodeHeight: 125,
            nodeSpacingY: 165,
            defaultShowZoomTo : {
                x : 0,
                y : 470,
                z : 1,
            }
        }
    } else {
        customeNode = {
            width: 800,
            height: 1200,
            nodeWidth: 150,
            nodeHeight: 125,
            nodeSpacingY: 165,
            defaultShowZoomTo : {
                x : 0,
                y : 370,
                z : 2,
            }
        }
    }
}

else if (template == 2) {
    if (window.screen.width >= 500) {
        customeNode = {
            width: 1200,
            height: 800,
            nodeWidth: 120,
            nodeHeight: 125,
            nodeSpacingY: 165,
            defaultShowZoomTo : {
                x : 0,
                y : 470,
                z : 1,
            }
        }
    } else {
        customeNode = {
            width: 800,
            height: 1200,
            nodeWidth: 150,
            nodeHeight: 125,
            nodeSpacingY: 165,
            defaultShowZoomTo : {
                x : 0,
                y : 370,
                z : 2,
            }
        }
    }
}

else if (template == 3) {
    if (window.screen.width >= 500) {
        customeNode = {
            width: 1200,
            height: 800,
            nodeWidth: 120,
            nodeHeight: 125,
            nodeSpacingY: 165,
            defaultShowZoomTo : {
                x : 0,
                y : 470,
                z : 1,
            }
        }
    } else {
        customeNode = {
            width: 800,
            height: 1200,
            nodeWidth: 150,
            nodeHeight: 125,
            nodeSpacingY: 165,
            defaultShowZoomTo : {
                x : 0,
                y : 370,
                z : 2,
            }
        }
    }
}

else if (template == 4) {
    if (window.screen.width >= 500) {
        customeNode = {
            width: 1200,
            height: 800,
            nodeWidth: 200,
            nodeHeight: 75,
            nodeSpacingY: 120,
            defaultShowZoomTo : {
                x : 0,
                y : 465,
                z : 1,
            }
        }
    } else {
        customeNode = {
            width: 800,
            height: 1200,
            nodeWidth: 200,
            nodeHeight: 75,
            nodeSpacingY: 120,
            defaultShowZoomTo : {
                x : 0,
                y : 350,
                z : 1.7,
            }
        }
    }
}