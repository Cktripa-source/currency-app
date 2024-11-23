<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not an admin
    exit;
}

// Include necessary files
include '../includes/db.php';
include '../includes/header.php';

// Fetch exchange requests with usernames
$requests_query = "
    SELECT exchange_requests.*, users.username 
    FROM exchange_requests 
    JOIN users ON exchange_requests.user_id = users.id 
    ORDER BY exchange_requests.created_at DESC";
$requests_result = $conn->query($requests_query);

// Fetch current exchange rates
$rates_query = "SELECT * FROM exchange_rates";
$rates_result = $conn->query($rates_query);

// chart make rate chart
$status_counts_query = "
    SELECT 
        status, 
        COUNT(*) as count 
    FROM exchange_requests 
    GROUP BY status";
$status_counts_result = $conn->query($status_counts_query);

// Initialize the counts for each status
$status_counts = [
    'approved' => 0,
    'pending' => 0,
    'rejected' => 0
];

// Populate the counts from the query results
while ($row = $status_counts_result->fetch_assoc()) {
    $status = strtolower($row['status']); // Ensure case-insensitivity
    $status_counts[$status] = (int)$row['count'];
}

// Calculate total transactions
$total_transactions = array_sum($status_counts);


// other selection of message 

$query = "SELECT * FROM contact_messages WHERE id ='1'";
$result = mysqli_query($conn, $query);
$message = mysqli_fetch_assoc($result);

// change rate or update it

// Start session and include database connection

// Handle form submission to update the exchange rates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new rates from the form
    $inr_to_frw = $_POST['inr_to_frw'] ?? null;
    $frw_to_inr = $_POST['frw_to_inr'] ?? null;

    // Validate and update the INR to FRW rate
    if ($inr_to_frw !== null && is_numeric($inr_to_frw)) {
        $update_inr_frw = "UPDATE exchange_rates SET rate = '$inr_to_frw' WHERE from_currency = 'INR' AND to_currency = 'FRW'";
        if (!$conn->query($update_inr_frw)) {
            $message_inr_frw = "Failed to update INR to FRW exchange rate.";
        } else {
            $message_inr_frw = "INR to FRW exchange rate updated successfully!";
        }
    }

    // Validate and update the FRW to INR rate
    if ($frw_to_inr !== null && is_numeric($frw_to_inr)) {
        $update_frw_inr = "UPDATE exchange_rates SET rate = '$frw_to_inr' WHERE from_currency = 'FRW' AND to_currency = 'INR'";
        if (!$conn->query($update_frw_inr)) {
            $message_frw_inr = "Failed to update FRW to INR exchange rate.";
        } else {
            $message_frw_inr = "FRW to INR exchange rate updated successfully!";
        }
    }
}

// Fetch the current rates for INR to FRW and FRW to INR
$inr_to_frw_rate = 0;
$frw_to_inr_rate = 0;
$rate_query = "SELECT rate, from_currency, to_currency FROM exchange_rates WHERE (from_currency = 'INR' AND to_currency = 'FRW') OR (from_currency = 'FRW' AND to_currency = 'INR')";
$result = $conn->query($rate_query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['from_currency'] == 'INR' && $row['to_currency'] == 'FRW') {
            $inr_to_frw_rate = $row['rate'];
        } elseif ($row['from_currency'] == 'FRW' && $row['to_currency'] == 'INR') {
            $frw_to_inr_rate = $row['rate'];
        }
    }
}

$conn->close();

?>
<main class="container mx-auto p-4 space-y-8">
    <!-- Notification -->
    <div
        id="notification"
        class="bg-blue-600 text-white px-4 py-3 rounded shadow-lg fixed top-5 right-5 flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0 w-11/12 max-w-md z-50"
    >
        <div>
            <h4 class="text-sm font-medium">
                <strong>New Message:</strong> Received from
                <span class="font-bold">
                    <?php 
                    echo isset($message['name']) && !empty($message['name']) 
                        ? htmlspecialchars($message['name']) 
                        : "Unknown Sender";
                    ?>
                </span>
            </h4>
            <a href="../public/cont_view.php" class="hover:underline text-white font-medium text-sm">
                View Contact Messages
            </a>
        </div>
        <button
            class="text-white font-bold bg-blue-700 hover:bg-blue-800 px-2 py-1 rounded text-sm"
            onclick="document.getElementById('notification').style.display='none';"
        >
            Close
        </button>
    </div>

    <!-- Update Exchange Rates -->
    <section>
        <h1 class="text-3xl font-bold text-center mb-6">Update Exchange Rates</h1>

        <!-- Display current rates -->
        <div class="text-center mb-4 space-y-2">
            <p class="text-lg font-semibold">Current Exchange Rates:</p>
            <p>INR to FRW: <span class="font-bold"><?php echo number_format($inr_to_frw_rate, 2); ?></span></p>
            <p>FRW to INR: <span class="font-bold"><?php echo number_format($frw_to_inr_rate, 2); ?></span></p>
        </div>

        <!-- Update Messages -->
        <div class="text-center mb-4">
            <?php if (isset($message_inr_frw)): ?>
                <p class="text-lg <?php echo strpos($message_inr_frw, 'successfully') !== false ? 'text-green-600' : 'text-red-600'; ?>">
                    <?php echo $message_inr_frw; ?>
                </p>
            <?php endif; ?>
            <?php if (isset($message_frw_inr)): ?>
                <p class="text-lg <?php echo strpos($message_frw_inr, 'successfully') !== false ? 'text-green-600' : 'text-red-600'; ?>">
                    <?php echo $message_frw_inr; ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Update Rates Form -->
        <form action="" method="POST" class="max-w-lg mx-auto bg-white p-6 rounded shadow-md space-y-4">
            <div>
                <label for="inr_to_frw" class="block text-sm font-medium text-gray-700">New Exchange Rate (INR to FRW)</label>
                <input
                    type="text"
                    name="inr_to_frw"
                    id="inr_to_frw"
                    class="w-full border-gray-300 rounded-md p-2"
                    required
                    value="<?php echo $inr_to_frw_rate; ?>"
                    placeholder="Enter INR to FRW rate"
                />
            </div>
            <div>
                <label for="frw_to_inr" class="block text-sm font-medium text-gray-700">New Exchange Rate (FRW to INR)</label>
                <input
                    type="text"
                    name="frw_to_inr"
                    id="frw_to_inr"
                    class="w-full border-gray-300 rounded-md p-2"
                    required
                    value="<?php echo $frw_to_inr_rate; ?>"
                    placeholder="Enter FRW to INR rate"
                />
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update Rates
            </button>
        </form>
    </section>
    <div class="chart-container">
    <canvas id="statusDoughnutChart"></canvas>
</div>

    <!-- Transactions Overview -->
    <section>
        <h2 class="text-2xl font-bold mb-4">Transactions Overview</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-blue-100 p-6 rounded shadow text-center">
                <h3 class="text-lg font-bold">Total Transactions</h3>
                <p class="text-3xl font-semibold"><?php echo $total_transactions; ?></p>
            </div>
            <div class="bg-green-100 p-6 rounded shadow text-center">
                <h3 class="text-lg font-bold">Approved</h3>
                <p class="text-3xl font-semibold"><?php echo $status_counts['approved']; ?></p>
            </div>
            <div class="bg-yellow-100 p-6 rounded shadow text-center">
                <h3 class="text-lg font-bold">Pending</h3>
                <p class="text-3xl font-semibold"><?php echo $status_counts['pending']; ?></p>
            </div>
            <div class="bg-red-100 p-6 rounded shadow text-center">
                <h3 class="text-lg font-bold">Rejected</h3>
                <p class="text-3xl font-semibold"><?php echo $status_counts['rejected']; ?></p>
            </div>
        </div>
    </section>

    <!-- Exchange Requests -->
    <section>
        <h2 class="text-2xl font-bold mb-4">User Exchange Requests</h2>
        <?php if ($requests_result->num_rows > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">User ID</th>
                            <th class="px-4 py-2 border">Username</th>
                            <th class="px-4 py-2 border">Amount</th>
                            <th class="px-4 py-2 border">From</th>
                            <th class="px-4 py-2 border">To</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Payment No.</th>
                            <th class="px-4 py-2 border">Screenshot</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($request = $requests_result->fetch_assoc()): ?>
                            <tr>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($request['user_id']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($request['username']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($request['amount']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($request['from_currency']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($request['to_currency']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($request['status']); ?></td>
                                <td class="px-4 py-2 border"><?php echo htmlspecialchars($request['payment_number']); ?></td>
                                <td class="px-4 py-2 border">
                                    <?php if (!empty($request['payment_screenshot'])): ?>
                                        <a href="uploads/payment_screenshots/<?php echo htmlspecialchars($request['payment_screenshot']); ?>" target="_blank" class="block">
                                            <img src="uploads/payment_screenshots/<?php echo htmlspecialchars($request['payment_screenshot']); ?>" alt="Screenshot" class="w-16 h-16 rounded shadow">
                                        </a>
                                    <?php else: ?>
                                        <span>No Screenshot</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-2 border flex justify-center space-x-2">
    <a href="approve_request.php?id=<?php echo $request['id']; ?>" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">✔</a>
    <a href="reject_request.php?id=<?php echo $request['id']; ?>" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">❌</a>
    
    <!-- Upload Button -->
    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="toggleUploadForm(<?php echo $request['id']; ?>)">
        Upload Screenshot
    </button>
</td>

<!-- Modal Form (Initially Hidden) -->
<div id="uploadModal<?php echo $request['id']; ?>" class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 z-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded shadow-lg max-w-sm w-full">
        <h2 class="text-xl font-bold mb-4">Upload Screenshot</h2>
        <form action="upload_screenshot.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
            <div class="mb-4">
                <label for="screenshot" class="block text-sm font-medium text-gray-700">Select Screenshot</label>
                <input type="file" name="screenshot" accept="image/*" required class="w-full mt-2 p-2 border rounded">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">Upload</button>
            <button type="button" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mt-4 w-full" onclick="closeUploadForm(<?php echo $request['id']; ?>)">Close</button>
        </form>
    </div>
</div>


                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">No exchange requests found.</p>
        <?php endif; ?>
    </section>
</main>


<?php include '../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const doughnutData = {
    labels: ['Approved', 'Pending', 'Rejected'],
    datasets: [
        {
            label: 'Transaction Status',
            data: [
                <?php echo $status_counts['approved']; ?>,
                <?php echo $status_counts['pending']; ?>,
                <?php echo $status_counts['rejected']; ?>
            ],
            backgroundColor: [
                'rgba(75, 192, 192, 0.6)', // Approved
                'rgba(255, 206, 86, 0.6)', // Pending
                'rgba(255, 99, 132, 0.6)'  // Rejected
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)', // Approved
                'rgba(255, 206, 86, 1)', // Pending
                'rgba(255, 99, 132, 1)'  // Rejected
            ],
            borderWidth: 1
        }
    ]
};

const doughnutConfig = {
    type: 'doughnut',
    data: doughnutData,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        const label = context.label || '';
                        const value = context.raw || 0;
                        return `${label}: ${value}`;
                    }
                }
            }
        }
    }
};

// Render Doughnut Chart
// Show the modal (upload form)
function toggleUploadForm(requestId) {
    const modal = document.getElementById(`uploadModal${requestId}`);
    modal.style.display = "flex";  // Show the modal by making it a flex container
}

// Close the modal (upload form)
function closeUploadForm(requestId) {
    const modal = document.getElementById(`uploadModal${requestId}`);
    modal.style.display = "none";  // Hide the modal
}


</script>

