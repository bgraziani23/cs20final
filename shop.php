<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Cars, Used Cars, Cheap, Dealership, Selling">
    <title>Second Spin</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"   
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   
        crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<style>
    body {
        font-family: "Bebas Neue", sans-serif;
        text-align: center;
    }
    
    h1 {
        margin-top: 20px;
    }

    .title-container {
        font-family: 'Fira Sans';
    }

    .search-container {
        margin: 20px auto;
        max-width: 600px;
        display: flex;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }

        .search-input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 300px;
        }

        .filter-select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
        }

        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

    .car-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 10px;
        text-align: left;
        background-color: #f9f9f9;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .car-card:hover {
        background-color: #d4d4d4;
        transform: scale(1.05);
    }

        .car-card img {
            width: 100%;
            height: 50%;
            object-fit: cover;
        }

    .car-card h2 {
        margin: 10px 0;
    }

    .car-card p {
       font-size: 1.1rem;
    }

    .car-card .price {
        font-size: 1.2rem;
        font-weight: bold;
        color: green;
    }

    .car-box {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        justify-content: center;
        align-items: center;
    }

        .car-box-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            text-align: center;
            position: relative;
        }

        .car-box-content img {
            max-width: 100%;
            max-height: 300px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .full-listing-button {
            display: inline-block;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }

        .full-listing-button:hover {
            background: #45a049;
        }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        cursor: pointer;
        font-size: 20px;
    }
</style>
<body>
<a href="home.html" class="logo-container">
        <img src="images/logo.png">
    </a>

    <script src="navBar.js"></script>

    <!-- Normal Nav Bar -->
    <div class="nav-container">
        <br />
        <a href="home.html" class="nav-button">Home</a>
        <a href="shop.php" class="nav-button">Shop</a>
        <a href="tinder.html" class="nav-button">Tinder</a>
        <a href="carvalue.php" class="nav-button">Car Value Calculator</a>
        <a href="about.html" class="nav-button">About Us</a>
        <a href="help.html" class="nav-button">Help</a>
        <a href="reviews.html" class="nav-button">Reviews</a>
        <a href="contact.html" class="nav-button">Contact Us</a>
        <br /><br />
    </div>

    <!-- Hamburger Nav Bar -->
    <div class="nav-hamburger-container">
        <br /><a>Not showing</a><br />
    </div>

    <div class="hamburger-container">
        <button onclick="toggleMenu()">&nbsp;&equiv;&nbsp;</button>
    </div>

    <span class="hamburger-button-container-closed">
        <br /><br /><br /><br />
        <a href="home.html" class="nav-button-hamburger-closed">Home</a>
        <a href="shop.php" class="nav-button-hamburger-closed">Shop</a>
        <a href="tinder.html" class="nav-button-hamburger-closed">Tinder</a>
        <a href="carvalue.php" class="nav-button-hamburger-closed">Car Value Calculator</a>
        <a href="about.html" class="nav-button-hamburger-closed">About Us</a>
        <a href="help.html" class="nav-button-hamburger-closed">Help</a>
        <a href="reviews.html" class="nav-button-hamburger-closed">Reviews</a>
        <a href="contact.html" class="nav-button-hamburger-closed">Contact Us</a>
    </span>

    <h1>Shop</h1>

    <div class="search-container">
        <form id="searchForm" method="GET" action="shop.php">
            <input type="text" id="searchInput" name="search" class="search-input" placeholder="Search cars..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            <select id="filterSelect" name="filter" class="filter-select">
                <option value="newest" <?php echo ($_GET['filter'] ?? 'newest') === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                <option value="price_asc" <?php echo ($_GET['filter'] ?? '') === 'price_asc' ? 'selected' : ''; ?>>Price: Low to High</option>
                <option value="price_desc" <?php echo ($_GET['filter'] ?? '') === 'price_desc' ? 'selected' : ''; ?>>Price: High to Low</option>
            </select>
            <button type="submit" style="display: none;">Search</button>
        </form>
    </div>

    <div id="car-grid" class="car-grid">
        <?php
        // Database connection
        $server = "localhost";
        $userid = "umegccruvfeiy";
        $pw = "thisisapass";
        $db = "dbimljtmuxm7qy";

        // Create connection
        $conn = new mysqli($server, $userid, $pw, $db);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get search and filter parameters
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
        } else {
            $search = '';
        }
       
        if (isset($_GET['filter'])) {
            $filter = $_GET['filter'];
        } else {
            $filter = 'newest';
        }

        // Build the SQL query
        $sql = "SELECT * FROM Cars";
        
        // Add search condition if search term exists
        if (!empty($search)) {
            $searchTerm = "%$search%";
            $sql .= " WHERE Model LIKE '$searchTerm' OR Description LIKE '$searchTerm'";
        }

        // Add sorting
        if ($filter === 'price_asc') {
            $sql .= " ORDER BY Price ASC";
        } else if ($filter === 'price_desc') {
            $sql .= " ORDER BY Price DESC";
        } else {
            $sql .= " ORDER BY CarID DESC";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="car-card" onclick="showCarDetails(' . $row["CarID"] . ')">';
                echo '<img src="' . htmlspecialchars($row["Image"]) . '" alt="' . htmlspecialchars($row["Model"]) . '">';
                echo '<h2>' . htmlspecialchars($row["Model"]) . '</h2>';
                echo '<p class="price">$' . number_format($row["Price"]) . '</p>';
                echo '<p>' . number_format($row["Miles"]) . ' miles</p>';
                echo '<p>' . htmlspecialchars($row["City"]) . ', ' . htmlspecialchars($row["State"]) . '</p>';
                echo '</div>';
            }
        } else {
            echo "No cars found";
        }

        $conn->close();
        ?>
    </div>

    <div id="car-box" class="car-box">
        <div class="car-box-content">
            <span class="close-btn" onclick="closeCarBox()">&times;</span>
            <img id="box-image" src="" alt="" style="width: 100%; height: auto;">
            <h2 id="box-description"></h2>
            <p id="box-price"></p>
            <p id="box-details"></p>
            <p id="box-mileage"></p>
            <p id="box-location"></p>
            <p id="box-seller"></p>
            <a id="full-listing-link" href="#" class="full-listing-button">View Full Listing</a>
        </div>
    </div>

    <footer class="footer">
        <a href='contact.html'>Contact</a>
        <a>&nbsp;&nbsp;|&nbsp;&nbsp;</a>
        <a href='about.html'>About Us</a>
        <a>&nbsp;&nbsp;|&nbsp;&nbsp;</a>
        <a href='shop.php'>Shop</a>
        <br />
        &copy; 2025 Second Spin&trade;&nbsp;&nbsp;|&nbsp;&nbsp;All Rights Reserved
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterSelect = document.getElementById('filterSelect');
        const searchForm = document.getElementById('searchForm');

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchForm.submit();
            }
        });

        filterSelect.addEventListener('change', function() {
            searchForm.submit();
        });
    });

    function showCarDetails(carId) {
        // run a fetch function 
        fetch('get_car_details.php?id=' + carId)
            .then(response => response.json())
            .then(data => {
                document.getElementById('box-image').src = data.Image;
                document.getElementById('box-description').textContent = data.Model;
                document.getElementById('box-price').textContent = '$' + data.Price;
                document.getElementById('box-details').textContent = data.Description;
                document.getElementById('box-mileage').textContent = data.Miles + ' miles';
                document.getElementById('box-location').textContent = data.City + ', ' + data.State;
                document.getElementById('box-seller').textContent = 'Seller: ' + data.Username;
                document.getElementById('full-listing-link').href = 'car_details.php?id=' + carId;
                document.getElementById('car-box').style.display = 'flex';
            });
    }

    function closeCarBox() {
        document.getElementById('car-box').style.display = 'none';
    }

    // Close the car box when clicking outside of it
    window.onclick = function(event) {
        const carBox = document.getElementById('car-box');
        if (event.target == carBox) {
            carBox.style.display = 'none';
        }
    }

    // if press escape, close the car box
    document.addEventListener('keydown', (event) => {
        if (event.key === "Escape") {
            closeCarBox();
        }
    });
    </script>
</body>
</html> 