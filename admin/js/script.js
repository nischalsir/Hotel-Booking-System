const  sideMenu = document.querySelector('aside');
const menuBtn = document.querySelector('#menu_bar');
const closeBtn = document.querySelector('#close_btn');


const themeToggler = document.querySelector('.theme-toggler');



menuBtn.addEventListener('click',()=>{
       sideMenu.style.display = "block"
})
closeBtn.addEventListener('click',()=>{
    sideMenu.style.display = "none"
})

themeToggler.addEventListener('click',()=>{
     document.body.classList.toggle('dark-theme-variables')
     themeToggler.querySelector('span:nth-child(1').classList.toggle('active')
     themeToggler.querySelector('span:nth-child(2').classList.toggle('active')
})

// Add this script to your ./js/script.js or include it in a <script> tag in your HTML
document.addEventListener('DOMContentLoaded', function() {
    // Function to show a notification
    function showNotification(message) {
        var notificationPlaceholder = document.getElementById('notification_placeholder');
        notificationPlaceholder.textContent = message;
        notificationPlaceholder.classList.add('show');
        setTimeout(function() {
            notificationPlaceholder.classList.remove('show');
        }, 3000);
    }

    // Example usage of the showNotification function
    // This would be triggered by some event or condition in your actual code
    showNotification('New update has been added!');
});

