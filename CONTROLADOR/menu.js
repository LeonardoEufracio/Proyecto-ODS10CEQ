function toggleMenu() {
  document.getElementById("dropdown-menu").classList.toggle("show");
}

window.onclick = function (e) {
  if (!e.target.closest('.user-dropdown')) {
    const menu = document.getElementById("dropdown-menu");
    if (menu.classList.contains('show')) {
      menu.classList.remove('show');
    }
  }
};


