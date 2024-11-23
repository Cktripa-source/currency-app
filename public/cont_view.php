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

// Fetch all messages from the database
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
    <!-- Include the header -->
    <?php include "../includes/header.php"; ?>

    <main class="container mx-auto p-6 md:my-20 my-40 ">
        <h1 class="text-2xl font-bold mb-4">Contact Messages</h1>

        <!-- Display success or error messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']); // Clear the message
                ?>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']); // Clear the error
                ?>
            </div>
        <?php endif; ?>

        <!-- Check if messages exist -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Message</th>
                            <th class="px-4 py-2 border">Date</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['email']); ?></td>
                                <td class="px-4 py-2 border"><?php echo nl2br(htmlspecialchars(substr($row['message'], 0, 50))); ?>...</td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td class="px-4 py-2 border text-center">
                                    <!-- View Message -->
                                    <button 
                                        onclick="toggleViewModal(<?php echo $row['id']; ?>);" 
                                        class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700">
                                        View
                                    </button>

                                    <!-- Delete Message -->
                                    <form action="delete_message.php" method="POST" class="inline">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button 
                                            type="submit" 
                                            class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-700"
                                            onclick="return confirm('Are you sure you want to delete this message?');">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal for Viewing the Full Message -->
                            <div id="viewModal<?php echo $row['id']; ?>" 
                                 class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex justify-center items-center">
                                <div class="bg-white p-6 rounded shadow-lg max-w-sm w-full relative">
                                    <button 
                                        class="absolute top-2 right-4 text-3xl font-bold text-gray-700 hover:text-red-800" 
                                        onclick="closeViewModal(<?php echo $row['id']; ?>)">
                                        &times;
                                    </button>
                                    <h2 class="text-xl font-bold mb-2">Message Details</h2>
                                    <p><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                                    <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                                    <p><strong>Message:</strong></p>
                                    <p class="bg-gray-100 p-4 rounded-lg shadow-inner mt-2">
                                        <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                                    </p>
                                    <p class="mt-4 text-sm text-gray-500">Sent on: <?php echo $row['created_at']; ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">No messages found.</p>
        <?php endif; ?>
    </main>

    <!-- Include the footer -->
    <?php include "../includes/footer.php"; ?>

    <script>
        // JavaScript for toggling the view modal
        function toggleViewModal(id) {
            const modal = document.getElementById(`viewModal${id}`);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeViewModal(id) {
            const modal = document.getElementById(`viewModal${id}`);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</body>
</html>
