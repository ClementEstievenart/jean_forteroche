document.addEventListener('scroll', function(e) {
    if (e.target.scrollingElement.scrollTop >= 300) {
        document.querySelector('.site_title.header').setAttribute('class', 'site_title header no_display');
        document.querySelector('.site_title.top_menu').setAttribute('class', 'site_title top_menu');
    } else {
        document.querySelector('.site_title.header').setAttribute('class', 'site_title header');
        document.querySelector('.site_title.top_menu').setAttribute('class', 'site_title top_menu no_display');
    }
});

document.querySelectorAll('.sublist.login input').forEach(function (inputElt) {
    inputElt.addEventListener('focus', function (e) {
        e.target.parentNode.parentNode.setAttribute('class', 'sublist login active');
    });
});

document.querySelectorAll('.sublist.login input').forEach(function (inputElt) {
    inputElt.addEventListener('blur', function (e) {
        e.target.parentNode.parentNode.setAttribute('class', 'sublist login');
    });
});
