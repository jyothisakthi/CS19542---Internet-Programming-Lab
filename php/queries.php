<?php
session_start(); // Start the session

// Database connection
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "pet_adoption"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $query = $_POST['query'];
    $pet_type = $_POST['pet-type'];
    $phone_number = $_POST['phone']; // Assuming this is the phone number field

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO queries (query, pet_type, phone_number) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $query, $pet_type, $phone_number);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        $_SESSION['alert_message'] = 'Your query has been submitted successfully.';
    } else {
        $_SESSION['alert_message'] = 'Error: ' . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();

// Redirect back to contact page
header('Location: ../contact.html');
exit();
?>
