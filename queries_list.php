<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.html');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_adoption";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the queries table
$sql = "SELECT id, query, pet_type, phone_number, created_at FROM queries"; // Adjust the columns as per your table structure
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queries Report</title>
    <link rel="stylesheet" type="text/css" href="style/nav-style.css">
    <link rel="stylesheet" type="text/css" href="style/style_form.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            color: white;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:hover {
            background-color: black;
        }
        .nav-list {
            text-align: center;
            margin-top: 20px;
        }
    </style>
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
                <li class="active"><a href="admin.html">Admin</a></li>
            </ul>
        </nav>
    </div>

<br><br>
<h1 style="text-align: center; color: white;">Queries Report</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Query</th>
            <th>Pet Type</th>
            <th>Phone Number</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["id"]) . "</td>
                        <td>" . htmlspecialchars($row["query"]) . "</td>
                        <td>" . htmlspecialchars($row["pet_type"]) . "</td>
                        <td>" . htmlspecialchars($row["phone_number"]) . "</td>
                        <td>" . htmlspecialchars($row["created_at"]) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No queries found</td></tr>";
        }

        $conn->close();
        ?>
    </tbody>
</table>

<div class="nav-list">
    <a href="admin.html">Back to Admin Panel</a>
</div>

</body>
</html>
