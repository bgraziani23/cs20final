// Global variables
let cars = [];
let currentCarIndex = 0;
let card = null;
let initialPos = 0;
let currentPos = 0;
let isDragging = false;

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
                const carId = cars[currentCarIndex].CarID;
                window.location.href = 'car_details.php?id=' + carId;
                return;
            }
            animateSwipe(direction);
        } else {
            resetCardPosition();
        }
    } else {
        resetCardPosition();
    }
}

// Card animation functions
function resetCardPosition() {
    card.style.transition = 'transform 0.3s ease';
    card.style.transform = 'translateX(0)';
}

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
        document.getElementById('car-swipe-container').style.display = 'none';
        document.getElementById('no-cars-message').style.display = 'flex';
        return;
    }
    const car = cars[index];
    document.getElementById('car-image').src = car.Image;
    document.getElementById('car-title').innerText = `${car.Model}`;
    document.getElementById('car-details').innerText = `Price: $${car.Price}, Miles: ${car.Miles}, Location: ${car.City}, ${car.State}`;
    if (card) {
        card.style.transform = 'translateX(0)';
        card.style.opacity = '1';
    }
}

// Swipe functions
function swipe(direction) {
    if (direction === 'right' && cars[currentCarIndex]) {
        const carId = cars[currentCarIndex].CarID;
        window.location.href = 'car_details.php?id=' + carId;
        return;
    }
    animateSwipe(direction);
}

// Initial choice functions
function startSwipingAll() {
    document.getElementById('initial-choice-overlay').style.display = 'none';
    document.getElementById('page-content').classList.remove('blurred');
    document.getElementById('car-swipe-container').style.display = 'block';
    document.getElementById('no-cars-message').style.display = 'none';
    
    fetch('get_cars.php')
        .then(response => response.json())
        .then(data => {
            cars = data;
            showCar(currentCarIndex);
            setTimeout(setupCardEventListeners, 100);
        })
        .catch(error => {
            console.error('Error fetching car data:', error);
        });
}

// Preferences functions
function showPreferences() {
    document.getElementById('initial-choice-overlay').style.display = 'none';
    document.getElementById('car-swipe-container').style.display = 'none';
    document.getElementById('no-cars-message').style.display = 'none';
    
    const preferencesOverlay = document.getElementById('preferences-overlay');
    preferencesOverlay.style.display = 'block';
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
                document.getElementById('preferences-overlay').style.display = 'none';
                document.getElementById('car-swipe-container').style.display = 'block';
                document.getElementById('no-cars-message').style.display = 'none';
                document.getElementById('page-content').classList.remove('blurred');
                currentCarIndex = 0;
                showCar(currentCarIndex);
                setTimeout(setupCardEventListeners, 100);
            } else {
                document.getElementById('preferences-overlay').style.display = 'none';
                document.getElementById('no-cars-message').style.display = 'flex';
                alert('No cars found matching your preferences. Please try different criteria.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading cars. Please try again.');
        });
} 