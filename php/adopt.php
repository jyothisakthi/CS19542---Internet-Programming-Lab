<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); // Start the session

// Database connection
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "pet_adoption"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $_POST['firstName'];
    $emailId = $_POST['email_id'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];
    $phone = $_POST['phone'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO adopt (first_name, email_id, street, city, state, pincode, phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("sssssss", $firstName, $emailId, $street, $city, $state, $pincode, $phone);
        $stmt->execute(); // Execute the statement
        $stmt->close(); // Close the prepared statement
    }

    // Redirect to adopt.html in the parent directory
    header("Location: ../adopt.html?success=true");
    exit(); // Make sure to call exit after redirection
}

// Close connection
$conn->close();
?>
