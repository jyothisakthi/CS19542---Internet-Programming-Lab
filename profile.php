<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

// Retrieve user details from session
$username = htmlspecialchars($_SESSION['username']);
$email = htmlspecialchars($_SESSION['email']);
$phn = htmlspecialchars($_SESSION['phn']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="style/nav-style.css">
    <link rel="stylesheet" type="text/css" href="style/style_form.css">
</head>

<body>
    <div class="navigation">
        <nav class="navbar nav-small">
            <ul class="nav-list">
                <li class="logo-hidden"><a href="index.html"><img src="img/pp.png" class="logo" alt="logo"></a></li>
                <li><a href="index.html">Home</a></li>
                <li><a href="adopt.html">Adopt</a></li>
                <li><a href="training.html">Training</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li class="acopy">
                    <div class="dropdown">
                        About
                        <div class="dropdown-content">
                            <a class="anew" href="about.html">About Us</a>
                            <a class="anew" href="success.html">Success Stories</a>
                            <a class="anew" href="ourTeam.html">Our Team</a>
                        </div>
                    </div>
                </li>
                <li><a href="login.html">Login</a></li>
                <li><a href="register.html">Register</a></li>
                <li class="active acopy">
                    <div class="dropdown">
                        You
                        <div class="dropdown-content">
                            <a class="anew" href="profile.php">Profile</a>
                            <a class="anew" href="logout.php">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>

    <div class="profile-container"> <!-- Wrapper for profile section -->
        <div class="contact">
            <div class="form">
                <h1 class="head">User Profile</h1>
                <div class="box">
                    <!-- Username field -->
                    <div class="ipbox">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" value="<?php echo $username; ?>" readonly>
                    </div>
                    <!-- Email field -->
                    <div class="ipbox">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo $email; ?>" readonly>
                    </div>
                    <!-- Phone number field -->
                    <div class="ipbox">
                        <label for="phn">Phone Number:</label>
                        <input type="text" name="phn" id="phn" value="<?php echo $phn; ?>" readonly>
                    </div>
                    <!-- Edit Profile Button -->
                    <div class="ipbox edit-button">
                        <a href="edit_profile.php" id="edit-profile-link">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
