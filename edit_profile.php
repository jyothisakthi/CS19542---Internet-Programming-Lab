<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_adoption";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = htmlspecialchars($_POST['username']);
    $new_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $new_phn = htmlspecialchars($_POST['phn']);

    // Update user information
    $sql = "UPDATE users SET username = ?, email = ?, phn = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $new_username, $new_email, $new_phn, $_SESSION['user_id']);

    if ($stmt->execute()) {
        // Update session variables
        $_SESSION['username'] = $new_username;
        $_SESSION['email'] = $new_email;
        $_SESSION['phn'] = $new_phn;

        echo "<script>alert('Profile updated successfully!'); window.location.href = 'profile.php';</script>";
        exit();
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

// Fetch current user data
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_adoption";

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT username, email, phn FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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

    <div class="profile-container">
        <div class="contact">
            <div class="form">
                <h1 class="head">Edit Profile</h1>
                <form action="edit_profile.php" method="POST">
                    <div class="box">
                        <div class="ipbox">
                        <label for="">Username:</label>
                            <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
                           
                        </div>
                        <div class="ipbox">
                        <label for="">Email:</label>
                            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
                            
                        </div>
                        <div class="ipbox">
                        <label for="">Phone Number:</label>
                            <input type="text" name="phn" value="<?php echo $user['phn']; ?>" required>
                            
                        </div>
                    </div>
                    <div class="submit">
                        <input type="submit" name="submit" value="Update Profile">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
