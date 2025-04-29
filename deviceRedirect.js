// Function to detect if the device is mobile
function isMobileDevice() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

// Function to handle shop button click
function handleShopClick(event) {
    event.preventDefault();
    if (isMobileDevice()) {
        window.location.href = 'tinder.html';
    } else {
        window.location.href = 'shop.php';
    }
}

// Set up event listeners when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Add click handlers to all shop links
    const shopLinks = document.querySelectorAll('a[href="shop.php"]');
    shopLinks.forEach(link => {
        link.addEventListener('click', handleShopClick);
    });
}); 