document.addEventListener('scroll', function(e) {
    if (e.target.scrollingElement.scrollTop >= 300) {
        document.getElementById('header_title').setAttribute('class', 'top_menu');
    } else {
        document.getElementById('header_title').setAttribute('class', '');
    }
});
