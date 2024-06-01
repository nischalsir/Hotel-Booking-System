document.addEventListener('DOMContentLoaded', () => {
    function loadHTML(elementId, filePath, callback) {
        fetch(filePath)
            .then(response => {
                if (!response.ok) throw new Error(`Failed to load ${filePath}`);
                return response.text();
            })
            .then(data => {
                document.getElementById(elementId).innerHTML = data;
                if (callback) callback();
            })
            .catch(error => {
                console.error(error);
            });
    }

    loadHTML('header-include', '../includes/header.html', () => {
        highlightActiveLink();
    });
    loadHTML('footer-include', '../includes/footer.html');

    function highlightActiveLink() {
        const path = window.location.pathname.split("/").pop();
        const links = {
            "index.html": "home-link",
            "about.html": "about-link",
            "services.html": "services-link",
            "features.html": "features-link",
            "contact.html": "contact-link",
        };

        const activeLinkId = links[path];
        if (activeLinkId) {
            document.getElementById(activeLinkId).classList.add("active");
        }
    }
});
