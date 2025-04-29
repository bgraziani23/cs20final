<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Cars, Used Cars, Cheap, Dealership, Selling">
    <title>Car Details - Second Spin</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"   
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   
        crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        .car-details-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
        }

        .car-header {
            display: flex;
            gap: 40px;
            margin-bottom: 30px;
        }

        .car-image {
            flex: 1;
            max-width: 600px;
        }

        .car-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .car-info {
            flex: 1;
        }

        .car-title {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .car-price {
            font-size: 2em;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .car-details p {
            margin: 10px 0;
            font-size: 1.1em;
        }

        .car-description, .seller-info {
            margin-top: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
        }

        .car-description h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .car-description p {
            line-height: 1.6;
            color: #666;
        }

        .seller-info h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background: #45a049;
        }
    </style>
</head>
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
        <a href="carvalcalc.html" class="nav-button">Value Calculator</a>
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
        <a href="carvalcalc.html" class="nav-button-hamburger-closed">Value Calculator</a>
        <a href="about.html" class="nav-button-hamburger-closed">About Us</a>
        <a href="help.html" class="nav-button-hamburger-closed">Help</a>
        <a href="reviews.html" class="nav-button-hamburger-closed">Reviews</a>
        <a href="contact.html" class="nav-button-hamburger-closed">Contact Us</a>
    </span>

    <div class="car-details-container">
        <?php

        // db connection
        $server = "localhost";
        $userid = "umegccruvfeiy";
        $pw = "thisisapass";
        $db = "dbimljtmuxm7qy";

        $conn = new mysqli($server, $userid, $pw, $db);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Get car ID from request
        if (isset($_GET['id'])) {
            $carId = intval($_GET['id']);
        } else {
            $carId = 0;
        }

        // if car id is not valid, fail
        if ($carId <= 0) {
            die("Invalid car ID");
        }

        // SQL query to connect username and car so we can get email of seller
        $sql = "SELECT c.*, u.email 
                FROM Cars c 
                JOIN Users u ON c.Username = u.Username 
                WHERE c.CarID = $carId";

        // Execute the query
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $car = $result->fetch_assoc();
            ?>
            <a href="shop.php" class="back-button">← Back to Shop</a>
            
            <div class="car-header">
                <div class="car-image">
                    <img src="<?php echo $car['Image']; ?>" alt="<?php echo $car['Model']; ?>">
                </div>
                <div class="car-info">
                    <h1 class="car-title"><?php echo $car['Model']; ?></h1>
                    <div class="car-price">$<?php echo $car['Price']; ?></div>
                    <div class="car-details">
                        <p><strong>Mileage:</strong> <?php echo $car['Miles']; ?> miles</p>
                        <p><strong>Location:</strong> <?php echo $car['City'] . ', ' . $car['State']; ?></p>
                        <p><strong>Seller:</strong> <?php echo $car['Username']; ?></p>
                    </div>
                </div>
            </div>

            <div class="car-description">
                <h3>Description</h3>
                <p><?php echo $car['Description']; ?></p>
            </div>

            <div class="seller-info">
                <h3>Contact Seller</h3>
                <?php
                // if email is null, set to null@null.com
                if (isset($car['email'])) {
                    $email = $car['email'];
                } else {
                    $email = 'null@null.com';
                }
                ?>
                <p>Interested in this vehicle? Contact the seller at <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a> to submit an offer or inquire about the vehicle.</p>
            </div>
            <?php
        } else {
            echo "<h1>Car not found</h1>";
            echo "<a href='shop.php' class='back-button'>← Back to Shop</a>";
        }

        $conn->close();
        ?>
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
</body>
</html> 