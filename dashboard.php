<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
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

// Get user's profile picture
$username = $_SESSION['username'];
$userSql = "SELECT profilepic FROM Users WHERE Username = '$username'";
$userResult = $conn->query($userSql);
$userData = $userResult->fetch_assoc();
$profilePic = $userData['profilepic'] ?? 'images/default_profile.png';

// Get user's listings
$sql = "SELECT * FROM Cars WHERE Username = '$username' ORDER BY CarID DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Second Spin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .welcome-section {
            margin-bottom: 30px;
            text-align: center;
        }

        .profile-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 3px solid #4CAF50;
        }

        .create-listing-btn {
            display: inline-block;
            padding: 15px 30px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 30px;
            font-size: 1.2em;
        }

        .create-listing-btn:hover {
            background: #45a049;
        }

        .listings-section {
            margin-top: 30px;
        }

        .listing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .listing-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .listing-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .listing-card h3 {
            margin: 10px 0;
            color: #333;
        }

        .listing-card .price {
            color: #4CAF50;
            font-size: 1.2em;
            font-weight: bold;
            margin: 10px 0;
        }

        .listing-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .edit-btn, .delete-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }

        .edit-btn {
            background: #2196F3;
        }

        .delete-btn {
            background: #f44336;
        }

        .edit-btn:hover {
            background: #1976D2;
        }

        .delete-btn:hover {
            background: #d32f2f;
        }

        .no-listings {
            text-align: center;
            padding: 40px;
            background: #f9f9f9;
            border-radius: 10px;
            margin-top: 20px;
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

    <div class="dashboard-container">
        <div class="welcome-section">
            <div class="profile-section">
                <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" class="profile-picture">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            </div>
            <a href="create_listing.html" class="create-listing-btn">Create New Listing</a>
        </div>

        <div class="listings-section">
            <h2>Your Current Listings</h2>
            <?php if ($result->num_rows > 0): ?>
                <div class="listing-grid">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="listing-card">
                            <img src="<?php echo htmlspecialchars($row['Image']); ?>" alt="<?php echo htmlspecialchars($row['Model']); ?>">
                            <h3><?php echo htmlspecialchars($row['Model']); ?></h3>
                            <p class="price">$<?php echo number_format($row['Price']); ?></p>
                            <p><?php echo number_format($row['Miles']); ?> miles</p>
                            <p><?php echo htmlspecialchars($row['City'] . ', ' . $row['State']); ?></p>
                            <div class="listing-actions">
                                <a href="edit_listing.php?id=<?php echo $row['CarID']; ?>" class="edit-btn">Edit</a>
                                <button onclick="deleteListing(<?php echo $row['CarID']; ?>)" class="delete-btn">Delete</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="no-listings">
                    <h3>You haven't created any listings yet.</h3>
                    <p>Click the "Create New Listing" button above to get started!</p>
                </div>
            <?php endif; ?>
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
    function deleteListing(carId) {
        if (confirm('Are you sure you want to delete this listing? This action cannot be undone.')) {
            fetch('delete_listing.php?id=' + carId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting listing: ' + data.error);
                    }
                })
                .catch(error => {
                    alert('Error deleting listing. Please try again.');
                });
        }
    }
    </script>
</body>
</html>
<?php
$conn->close();
?> 