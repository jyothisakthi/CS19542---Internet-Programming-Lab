<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded credentials for example
    $valid_username = "jyothi";
    $valid_password = "qwerty";

    if ($username === $valid_username && $password === $valid_password) {
        // Successful login
        $_SESSION['admin_logged_in'] = true;
        echo json_encode(["status" => "success", "message" => "Login successful! Redirecting..."]);
        exit();
    } else {
        // Invalid login
        echo json_encode(["status" => "error", "message" => "Invalid username or password."]);
    }
} else {
    // Invalid request method
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
