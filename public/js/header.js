const menuIcon = document.querySelector('#menu-icon');
const navbar = document.querySelector('.navbar');
const themeToggle = document.querySelector('#theme-toggle');
const body = document.body;

menuIcon.addEventListener('click', () => {
    menuIcon.classList.toggle('bx-x');
    navbar.classList.toggle('open');
});

themeToggle.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    body.classList.toggle('light-mode');
});