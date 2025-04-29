// Global variables
let cars = [];
let currentCarIndex = 0;
let card = null;
let initialPos = 0;
let currentPos = 0;
let isDragging = false;

// Utility functions
function setElementVisibility(elementId, display) {
    const element = document.getElementById(elementId);
    if (element) {
        element.style.display = display;
    }
}

function navigateToCarDetails(carId) {
    window.location.href = 'car_details.php?id=' + carId;
}

function handleError(error, message) {
    console.error('Error:', error);
    alert(message);
}

function resetCard() {
    if (card) {
        card.style.transition = 'transform 0.3s ease';
        card.style.transform = 'translateX(0)';
        card.style.opacity = '1';
    }
}

// Initialize card event listeners
function setupCardEventListeners() {
    card = document.getElementById('car-card');
    if (!card) return;

    // Remove existing event listeners
    card.removeEventListener('touchstart', handleTouchStart);
    card.removeEventListener('touchmove', handleTouchMove);
    card.removeEventListener('touchend', handleTouchEnd);

    // Add new event listeners
    card.addEventListener('touchstart', handleTouchStart, { passive: true });
    card.addEventListener('touchmove', handleTouchMove, { passive: true });
    card.addEventListener('touchend', handleTouchEnd);
}

// Touch event handlers
function handleTouchStart(e) {
    e.preventDefault();
    initialPos = e.touches[0].clientX;
    isDragging = false;
    card.style.transition = 'none';
}

function handleTouchMove(e) {
    if (!isDragging && Math.abs(e.touches[0].clientX - initialPos) > 10) {
        isDragging = true;
    }
    if (isDragging) {
        currentPos = e.touches[0].clientX;
        const deltaX = currentPos - initialPos;
        card.style.transform = `translateX(${deltaX}px)`;
    }
}

function handleTouchEnd() {
    if (isDragging) {
        const deltaX = currentPos - initialPos;
        if (Math.abs(deltaX) > 100) {
            const direction = deltaX > 0 ? 'right' : 'left';
            if (direction === 'right' && cars[currentCarIndex]) {
                navigateToCarDetails(cars[currentCarIndex].CarID);
                return;
            }
            animateSwipe(direction);
        } else {
            resetCard();
        }
    } else {
        resetCard();
    }
}

// Card animation functions
function animateSwipe(direction) {
    card.style.transition = 'transform 0.3s ease, opacity 0.3s ease';
    card.style.transform = `translateX(${direction === 'right' ? 1000 : -1000}px)`;
    card.style.opacity = '0';
    setTimeout(() => {
        currentCarIndex++;
        showCar(currentCarIndex);
    }, 300);
}

// Car display functions
function showCar(index) {
    if (index >= cars.length) {
        setElementVisibility('car-swipe-container', 'none');
        setElementVisibility('no-cars-message', 'flex');
        return;
    }
    const car = cars[index];
    document.getElementById('car-image').src = car.Image;
    document.getElementById('car-title').innerText = `${car.Model}`;
    document.getElementById('car-details').innerText = `Price: $${car.Price}, Miles: ${car.Miles}, Location: ${car.City}, ${car.State}`;
    resetCard();
}

// Swipe functions
function swipe(direction) {
    if (direction === 'right' && cars[currentCarIndex]) {
        navigateToCarDetails(cars[currentCarIndex].CarID);
        return;
    }
    animateSwipe(direction);
}

// Initial choice functions
function startSwipingAll() {
    setElementVisibility('initial-choice-overlay', 'none');
    setElementVisibility('car-swipe-container', 'block');
    setElementVisibility('no-cars-message', 'none');
    document.getElementById('page-content').classList.remove('blurred');
    
    fetch('get_cars.php')
        .then(response => response.json())
        .then(data => {
            cars = data;
            showCar(currentCarIndex);
            setTimeout(setupCardEventListeners, 100);
        })
        .catch(error => handleError(error, 'Error fetching car data'));
}

// Preferences functions
function showPreferences() {
    setElementVisibility('initial-choice-overlay', 'none');
    setElementVisibility('car-swipe-container', 'none');
    setElementVisibility('no-cars-message', 'none');
    setElementVisibility('preferences-overlay', 'block');
}

function submitPreferences(event) {
    event.preventDefault();
    
    const preferences = {
        minPrice: document.getElementById('min-price').value,
        maxPrice: document.getElementById('max-price').value,
        minMileage: document.getElementById('min-mileage').value,
        maxMileage: document.getElementById('max-mileage').value,
        state: document.getElementById('state').value
    };
    
    const params = new URLSearchParams();
    for (const [key, value] of Object.entries(preferences)) {
        if (value) {
            params.append(key, value);
        }
    }
    
    fetch('get_filtered_cars.php?' + params.toString())
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            cars = data;
            if (cars.length > 0) {
                setElementVisibility('preferences-overlay', 'none');
                setElementVisibility('car-swipe-container', 'block');
                setElementVisibility('no-cars-message', 'none');
                document.getElementById('page-content').classList.remove('blurred');
                currentCarIndex = 0;
                showCar(currentCarIndex);
                setTimeout(setupCardEventListeners, 100);
            } else {
                setElementVisibility('preferences-overlay', 'none');
                setElementVisibility('no-cars-message', 'flex');
                alert('No cars found matching your preferences. Please try different criteria.');
            }
        })
        .catch(error => handleError(error, 'Error loading cars. Please try again.'));
} 