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

// get username from global variable
$username = $_SESSION['username'];

// get profile picture from database
$userSql = "SELECT profilepic FROM Users WHERE Username = '$username'";

//grab pfp
$userResult = $conn->query($userSql);
$userData = $userResult->fetch_assoc();
$profilePic = $userData['profilepic'];

// get user listings
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

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin: 15px auto;
            border: 3px solid #4CAF50;
            display: block;
        }

        .welcome-section {
            text-align: center;
        }

        .create-listing-btn {
            display: inline-block;
            padding: 15px 30px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px auto;
        }

        .create-listing-btn:hover {
            background: #45a049;
        }

        button.create-listing-btn {
            border: none;
            outline: none;
            cursor: pointer;
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
        }

        .listing-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .listing-card .price {
            color: #4CAF50;
            font-size: 1.2em;
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
        .edit-btn:hover { 
            background: #1976D2; 
        }

        .delete-btn { 
            background: #f44336; 
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
        <a href="tinder.html" class="nav-button">Tinder</a>
        <a href="carvalue.php" class="nav-button">Car Value Calculator</a>
        <a href="about.html" class="nav-button">About Us</a>
        <a href="help.html" class="nav-button">Help</a>
        <a href="reviews.html" class="nav-button">Reviews</a>
        <a href="dashboard.php" class="nav-button">Profile</a>
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
        <a href="carmatch.html" class="nav-button-hamburger-closed">Gallery</a>
        <a href="carvalue.php" class="nav-button-hamburger-closed">Car Value Calculator</a>
        <a href="about.html" class="nav-button-hamburger-closed">About Us</a>
        <a href="help.html" class="nav-button-hamburger-closed">Help</a>
        <a href="reviews.html" class="nav-button-hamburger-closed">Reviews</a>
        <a href="dashboard.php" class="nav-button-hamburger-closed">Profile</a>
    </span>

    <div class="dashboard-container">
        <div class="welcome-section">
            <div class="profile-section">
                <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" class="profile-picture">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            </div>
            <a href="create_listing.html" class="create-listing-btn">Create New Listing</a>
            <button onclick="signOut()" class="create-listing-btn">Sign Out</button>
        </div>

        <div class="listings-section">
            <h2>Your Current Listings</h2>
            <?php 
            if ($result->num_rows > 0) {
                echo '<div class="listing-grid">';
                while($row = $result->fetch_assoc()) {
                    echo '<div class="listing-card">';
                    echo '<img src="' . $row['Image'] . '" alt="' . $row['Model'] . '">';
                    echo '<h3>' . $row['Model'] . '</h3>';
                    echo '<p class="price">$' . $row['Price'] . '</p>';
                    echo '<p>' . $row['Miles'] . ' miles</p>';
                    echo '<p>' . $row['City'] . ', ' . $row['State'] . '</p>';
                    echo '<div class="listing-actions">';
                    echo '<a href="edit_listing.php?id=' . $row['CarID'] . '" class="edit-btn">Edit</a>';
                    echo '<button onclick="deleteListing(' . $row['CarID'] . ')" class="delete-btn">Delete</button>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<div class="no-listings">';
                echo '<h3>You haven\'t created any listings yet.</h3>';
                echo '<p>Click the "Create New Listing" button above to get started!</p>';
                echo '</div>';
            }
            ?>
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

        // to delete listing, confirm and then run delete_listing.php with id
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

    function signOut() {
        fetch('signout.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'login.html';
                } else {
                    alert('Error signing out: ' + data.error);
                }
            })
            .catch(error => {
                alert('Error signing out.');
            });
    }
    </script>
</body>
</html>
<?php
$conn->close();
?> 