<?php
session_start();

// Include necessary files (DB connection, header, footer)
include '../includes/db.php';
include '../includes/header.php';
include '../includes/hello.php';

// Fetch user registration data
$user_trend_query = "
    SELECT DATE(created_at) AS registration_date, COUNT(*) AS user_count
    FROM users
    GROUP BY DATE(created_at)
    ORDER BY registration_date ASC
";
$user_trend_result = $conn->query($user_trend_query);

$dates = [];
$user_counts = [];
if ($user_trend_result->num_rows > 0) {
    while ($row = $user_trend_result->fetch_assoc()) {
        $dates[] = $row['registration_date'];
        $user_counts[] = $row['user_count'];
    }
}

// Encode data as JSON for JavaScript
$datesJSON = json_encode($dates);
$userCountsJSON = json_encode($user_counts);
?>
<main class="container mx-auto p-4 my-20">
    <!-- Chart Section -->
    <div class="bg-white p-6 rounded shadow-md mb-8">
        <h2 class="text-2xl font-semibold text-center mb-4">User Registration Trend</h2>
        <canvas id="userGrowthChart" class="w-full"></canvas>
    </div>
</main>

<!-- Include Footer -->
<?php include '../includes/footer.php'; ?>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data from PHP
    const labels = <?php echo $datesJSON; ?>;
    const userCounts = <?php echo $userCountsJSON; ?>;

    // Chart Configuration
    const data = {
        labels: labels,
        datasets: [{
            label: 'Number of Users',
            data: userCounts,
            borderColor: '#4F46E5',
            backgroundColor: 'rgba(79, 70, 229, 0.5)',
            tension: 0.4,
            fill: true,
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Users'
                    },
                    beginAtZero: true,
                }
            }
        }
    };

    // Initialize Chart
    new Chart(
        document.getElementById('userGrowthChart'),
        config
    );
</script>
