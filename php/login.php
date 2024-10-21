<?php
session_start();

// Set Content-Type to JSON
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_adoption";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $conn->connect_error
    ]);
    exit();
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize POST data
    $user_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $user_password = $_POST['password']; // Passwords should not be sanitized to avoid altering characters

    // Validate email format
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid email format."
        ]);
        exit();
    }

    // Prepare and execute SQL statement
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            "status" => "error",
            "message" => "Database error: " . $conn->error
        ]);
        exit();
    }

    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($user_password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phn'] = $user['phn'];

            echo json_encode([
                "status" => "success",
                "message" => "Successfully logged in!"
            ]);
            exit();
        } else {
            // Invalid password
            echo json_encode([
                "status" => "error",
                "message" => "Invalid password."
            ]);
            exit();
        }
    } else {
        // No user found with that email
        echo json_encode([
            "status" => "error",
            "message" => "No user found with that email."
        ]);
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
