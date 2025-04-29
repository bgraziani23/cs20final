<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Get car ID from request
$carId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($carId <= 0) {
    header("Location: dashboard.php");
    exit();
}

// Database connection
$server = "localhost";
$userid = "umegccruvfeiy";
$pw = "thisisapass";
$db = "dbimljtmuxm7qy";

$conn = new mysqli($server, $userid, $pw, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get car details
$username = $_SESSION['username'];
$sql = "SELECT * FROM Cars WHERE CarID = $carId AND Username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header("Location: dashboard.php");
    exit();
}

$car = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing - Second Spin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .edit-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group textarea {
            height: 150px;
            resize: vertical;
        }

        .current-image {
            max-width: 300px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .submit-btn {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-btn:hover {
            background: #45a049;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #666;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .back-btn:hover {
            background: #555;
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

    <div class="edit-container">
        <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
        <h1>Edit Listing</h1>
        
        <form action="update_listing.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="carId" value="<?php echo $carId; ?>">
            
            <div class="form-group">
                <label for="model">Model:</label>
                <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($car['Model']); ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" value="<?php echo $car['Price']; ?>" required>
            </div>

            <div class="form-group">
                <label for="miles">Miles:</label>
                <input type="number" id="miles" name="miles" value="<?php echo $car['Miles']; ?>" required>
            </div>

            <div class="form-group">
                <label for="state">State:</label>
                <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($car['State']); ?>" required>
            </div>

            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($car['City']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($car['Description']); ?></textarea>
            </div>

            <div class="form-group">
                <label>Current Image:</label>
                <img src="<?php echo htmlspecialchars($car['Image']); ?>" alt="Current car image" class="current-image">
                <label for="image">Update Image (optional):</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <button type="submit" class="submit-btn">Update Listing</button>
        </form>
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
<?php
$conn->close();
?> 