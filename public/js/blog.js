//Login form focus
if (document.querySelector('.sublist.login')) {
    if(/active/.test(document.querySelector('.sublist.login').className)) {
        document.getElementById('login').focus();
    }
}

//Menu sublist effects
document.querySelectorAll('#head_menu .sublist_menu:not(#display_menu)').forEach(function (aElt) {
    aElt.addEventListener('click', function () {
        if (/active/.test(aElt.parentNode.querySelector('.sublist').className)) {
            aElt.className = aElt.className.replace(' active', '');
            aElt.parentNode.querySelector('.sublist').className = aElt.parentNode.querySelector('.sublist').className.replace(' active', '');
        } else {
            document.querySelectorAll('#head_menu li .active').forEach(function (menuElt) {
                menuElt.className = menuElt.className.replace(' active', '');
            });
            aElt.className += ' active';
            aElt.parentNode.querySelector('.sublist').className += ' active';
        }
    });
});


//Menu display for small device
document.getElementById('display_menu').addEventListener('click', function () {
    if (/active/.test(document.querySelector('#menu_button>ul').className)) {
        document.querySelector('#menu_button>ul').className = document.querySelector('#menu_button>ul').className.replace(' active', '');
        document.getElementById('display_menu').className = document.getElementById('display_menu').className.replace(' active', '');
    } else {
        document.getElementById('display_menu').className += ' active';
        document.querySelector('#menu_button>ul').className += ' active';
    }
});
