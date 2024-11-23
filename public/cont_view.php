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

// Fetch messages from the database
$query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php include "../includes/header.php" ?>

    <main class="container mx-auto p-6 md:my-40 my-40">
    <!-- Display success or error messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="bg-green-500 text-white px-4 py-2 rounded my-4">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']); // Clear the message
            ?>
        </div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="bg-red-500 text-white px-4 py-2 rounded my-4">
            <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']); // Clear the error
            ?>
        </div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-10 py-2 border">Name</th>
                        <th class="px-10 py-2 border">Email</th>
                        <th class="px-10 py-2 border">Message</th>
                        <th class="px-10 py-2 border">Date</th>
                        <th class="px-10 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-gray-300">
                            <td class="px-2 border"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td class="px-2 border"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="px-2 border"><?php echo nl2br(htmlspecialchars(substr($row['message'], 0, 50))); ?>...</td>
                            <td class="px-2 border"><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td class="px-2 border text-center">
                                <!-- View Message -->
                                <button 
                                    onclick="window.location='view_message.php?id=<?php echo $row['id']; ?>';" 
                                    class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700"
                                >
                                    View
                                </button>
                                <!-- Delete Message -->
                                <form action="delete_message.php" method="POST" class="inline">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button 
                                        type="submit" 
                                        class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-700"
                                        onclick="return confirm('Are you sure you want to delete this message?');"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center">No messages found.</p>
    <?php endif; ?>
</main>

<?php include "../includes/footer.php" ?>
</body>
</html>
