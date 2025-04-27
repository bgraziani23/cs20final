
   // Get cars objects from json file
   function loadCars() {
        $.get("cars.json", function(data) {
            const carObjects = data.map(car => ({
                    carname: car.carname,
                    price: car.price,
                    image: car.image,
                    description: car.description,
                    details: car.details,
                    location: car.location,
                    mileage: car.mileage 
            }));
            displayCars(carObjects);
        })
    }
    
    // Make cars in the main-page grid
    function displayCars(cars) {
        const carGrid = document.getElementById('car-grid');
        carGrid.innerHTML = '';
    
        cars.forEach(car => {
            const carCard = document.createElement('div');
            carCard.classList.add('car-card');
            carCard.innerHTML = `
                <img src="${car.image}" alt="${car.description}">
                <h2>${car.carname}</h2>
                <p class="price">${car.price}</p>
            `;
    
            carCard.addEventListener('click', () => openCar(car));
            carGrid.appendChild(carCard);
        });
    }
    
    // Setup clickable cars
    function openCar(car) {
        const box = document.getElementById('car-box');
        document.getElementById('box-image').src = car.image;
        document.getElementById('box-description').textContent = car.carname;
        document.getElementById('box-price').textContent = `Price: ${car.price}`;
        document.getElementById('box-details').textContent = car.details || 'More details not available.';
        document.getElementById('box-location').textContent = car.location;
        document.getElementById('box-mileage').textContent = car.mileage;
        box.style.display = 'flex';
    }
    
    // Functionality to close the car-card
    function closeCar() {
        document.getElementById('car-box').style.display = 'none';
    }
    
    // If you click outside the box, close the box
    document.getElementById('car-box').addEventListener('click', (event) => {
        if (event.target.classList.contains('car-box')) {
            closeCar();
        }
    });

    // Listener: hit escape, close the box
    document.addEventListener('keydown', (event) => {
        if (event.key === "Escape") {
            closeCar();
        }
    });

    // Listener: click x button, close box
    document.getElementsByClassName('close-btn')[0].addEventListener('click', closeCar);
    
    // Load cars onto page and read json when page is loaded
    window.onload = loadCars;
    