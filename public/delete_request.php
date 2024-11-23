<?php
session_start();
include '../includes/db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not an admin
    exit;
}

// Get the request ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Update the record to hide it from the admin's view
    $query = "UPDATE exchange_requests SET hidden_from_admin = 1 WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        header('Location: admin.php'); // Redirect back to dashboard
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    header('Location: admin.php'); // Redirect if no ID is provided
    exit;
}
?>
