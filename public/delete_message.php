<?php
session_start();

// Ensure the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'currency-app');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the delete request was sent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Ensure the ID is an integer

    // Prepare the DELETE query
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Message deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete message.";
    }
    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request.";
}

// Redirect back to the contact messages page
header("Location: contact_messages.php");
exit;
?>
