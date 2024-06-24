document.querySelector('.menu-toggle').addEventListener('click', function() {
    const nav = document.querySelector('.header_nav--nav');
    nav.classList.add('open');
    console.log(nav.classList.contains('open'));
});

document.addEventListener('click', function(event) {
    const nav = document.querySelector('.header_nav--nav');
    const menuBtn = document.querySelector('.menu-toggle');
    const isClickInsideMenu = nav.contains(event.target);
    const isClickInsideButton = menuBtn.contains(event.target);

    if (!isClickInsideMenu && !isClickInsideButton) {
        nav.classList.remove('open');
    }
});
