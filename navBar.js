function toggleMenu() {
    // Get the elements with the specified class names
    let elemsClosed = document.getElementsByClassName("nav-button-hamburger-closed");
    let elemsOpen = document.getElementsByClassName("nav-button-hamburger-open");

    // Toggle between open and closed hamburger items
    if (elemsClosed.length == 0) {
        for (let i = 0; i < 7; i++) {
            elemsOpen[0].className = "nav-button-hamburger-closed";
        }
    } else {
        for (let i = 0; i < 7; i++) {
            elemsClosed[0].className = "nav-button-hamburger-open";
        }
    }

    // Toggle hamburger container visibility
    let elemsHamClosed = document.getElementsByClassName("hamburger-button-container-closed");
    let elemsHamOpen = document.getElementsByClassName("hamburger-button-container-open");

    if (elemsHamClosed.length == 0) {
        elemsHamOpen[0].className = "hamburger-button-container-closed";
    } else {
        elemsHamClosed[0].className = "hamburger-button-container-open";
    }
}

// ===============================
// Login/Profile Button Logic
// ===============================

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

window.addEventListener('DOMContentLoaded', () => {
    const username = getCookie('username');

    const authLink = document.getElementById('auth-button');
    const authLinkHamburger = document.getElementById('auth-button-hamburger');

    if (username) {
        if (authLink) {
            authLink.href = 'dashboard.php';
            authLink.textContent = 'Profile';
        }
        if (authLinkHamburger) {
            authLinkHamburger.href = 'dashboard.php';
            authLinkHamburger.textContent = 'Profile';
        }
    } else {
        if (authLink) {
            authLink.href = 'login.html';
            authLink.textContent = 'Login';
        }
        if (authLinkHamburger) {
            authLinkHamburger.href = 'login.html';
            authLinkHamburger.textContent = 'Login';
        }
    }
});
