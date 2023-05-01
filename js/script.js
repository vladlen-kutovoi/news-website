document.addEventListener('DOMContentLoaded', function () {
  toggleMobileMenu();
});

function toggleMobileMenu() {
  const NAV = document.querySelector('.header__nav');
  const MENU_BUTTON = NAV.querySelector('.menu-button');
  const LINK = NAV.querySelectorAll('A');

  MENU_BUTTON.addEventListener('click', function () {
    NAV.classList.toggle('header__nav_active');
    document.body.classList.toggle('no-scroll');
  });

  LINK.forEach(item => {
    item.addEventListener('click', function () {
      NAV.classList.remove('header__nav_active');
      document.body.classList.remove('no-scroll');
    });
  });
  window.addEventListener('resize', function () {
    if (window.innerWidth > 992) {
      document.body.classList.remove('no-scroll');
    }
  })
}