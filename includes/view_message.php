<?php
include '../includes/auth.php';  // Ensure the user is authenticated
include '../includes/db.php';    // Database connection

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid message ID");
}

$message_id = intval($_GET['id']);

// Fetch message from the database
$query = "SELECT * FROM contact_messages WHERE id = $message_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Message not found");
}

$message = mysqli_fetch_assoc($result);
?>
<main class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg border border-gray-300">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <div>
                <p class="text-lg font-semibold text-gray-700">
                    <?php echo htmlspecialchars($message['name']); ?>
                </p>
                <p class="text-sm text-gray-500">
                    <?php echo htmlspecialchars($message['email']); ?>
                </p>
            </div>
            <p class="text-sm text-gray-400">
                <?php echo date("F j, Y, g:i a", strtotime($message['created_at'])); ?>
            </p>
        </div>
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-2">Message:</h3>
            <p class="bg-gray-100 p-4 rounded-lg text-gray-800 leading-relaxed shadow-inner">
                <?php echo nl2br(htmlspecialchars($message['message'])); ?>
            </p>
        </div>
    </div>
</main>
