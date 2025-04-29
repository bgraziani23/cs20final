<?php
session_start();

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Get car ID from request
if (isset($_GET['id'])) {
    $carId = intval($_GET['id']);
} else {
    $carId = 0;
}

//if there is no car id, redirect to dashboard
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

// get username and car details
$username = $_SESSION['username'];
$sql = "SELECT * FROM Cars WHERE CarID = $carId AND Username = '$username'";
$result = $conn->query($sql);

// if car not found, redirect to dashboard
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
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        textarea {
            height: 150px;
        }

        .current-image {
            max-width: 300px;
            margin: 10px 0;
        }

        button {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
        <!-- formdata to update image -->
        <form action="update_listing.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="carId" value="<?php echo $carId; ?>">
            
            <label>Model:</label>
            <input type="text" name="model" value="<?php echo $car['Model']; ?>" required>

            <label>Price:</label>
            <input type="number" name="price" value="<?php echo $car['Price']; ?>" required>

            <label>Miles:</label>
            <input type="number" name="miles" value="<?php echo $car['Miles']; ?>" required>

            <label>State:</label>
            <input type="text" name="state" value="<?php echo $car['State']; ?>" required>

            <label>City:</label>
            <input type="text" name="city" value="<?php echo $car['City']; ?>" required>

            <label>Description:</label>
            <textarea name="description" required><?php echo $car['Description']; ?></textarea>

            <label>Current Image:</label>
            <br>
            <img src="<?php echo $car['Image']; ?>" alt="Current car image" class="current-image">

            <br />

            <label>Update Image (optional):</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit">Update Listing</button>
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