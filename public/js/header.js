document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    const sunIcon = document.getElementById('sun_icon');
    const moonIcon = document.getElementById('moon_icon');
    const header = document.querySelector('.header_navigation');

    function toggleTheme() {
        const isDarkMode = body.classList.contains('dark-mode');

        if (isDarkMode) {
            sunIcon.classList.add('spin');
            moonIcon.classList.add('spin-reverse');
        } else {
            sunIcon.classList.add('spin-reverse');
            moonIcon.classList.add('spin');
        }

        body.classList.toggle('dark-mode');
        header.classList.toggle('dark-mode');

        setTimeout(() => {
            sunIcon.classList.remove('spin', 'spin-reverse');
            moonIcon.classList.remove('spin', 'spin-reverse');
        }, 500); // Match this duration with the CSS animation duration
    }

    sunIcon.addEventListener('click', toggleTheme);
    moonIcon.addEventListener('click', toggleTheme);
});
