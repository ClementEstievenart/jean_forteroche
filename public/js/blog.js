document.addEventListener('scroll', function(e) {
    console.log(e.target.scrollingElement.scrollTop);
    if (e.target.scrollingElement.scrollTop >= 300) {
        document.getElementById('header_title').setAttribute('class', 'top_menu');
    } else {
        document.getElementById('header_title').setAttribute('class', '');
    }
});
