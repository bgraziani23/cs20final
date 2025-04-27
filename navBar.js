function toggleMenu() {
    // Get the elements with the specified class names
    let elemsClosed = document.getElementsByClassName("nav-button-hamburger-closed");
    let elemsOpen = document.getElementsByClassName("nav-button-hamburger-open");
    // If there are no closed elements, they must be open
    if (elemsClosed.length == 0) {
        // Change each class to the closed class
        for (let i = 0; i < 7; i++) {
            elemsOpen[0].className = "nav-button-hamburger-closed";
        }
    }
    // Otherwise, the elements must be closed
    else {
        // Change each class to the open class
        for (let i = 0; i < 7; i++) {
            elemsClosed[0].className = "nav-button-hamburger-open";
        }
    }

    // Get the elements with the specified class names
    let elemsHamClosed = document.getElementsByClassName("hamburger-button-container-closed");
    let elemsHamOpen = document.getElementsByClassName("hamburger-button-container-open");
    // If there are no closed elements, they must be open
    if (elemsHamClosed.length == 0) {
        // Change the first element's class to the closed version (there is only one element)
        elemsHamOpen[0].className = "hamburger-button-container-closed";
    }
    // Otherwise, the elements must be closed
    else {
        // Change the first element's class to the closed version (there is only one element)
        elemsHamClosed[0].className = "hamburger-button-container-open";
    }
}