<?php
session_start();

// Include necessary files (DB connection, header, footer)
include '../includes/db.php';
include '../includes/header.php';
include '../includes/hello.php';

// Fetch exchange rates from the database (for conversion)
$rates_query = "SELECT * FROM exchange_rates";
$rates_result = $conn->query($rates_query);
$rates = [];
if ($rates_result->num_rows > 0) {
    while ($rate = $rates_result->fetch_assoc()) {
        $rates[$rate['from_currency']][$rate['to_currency']] = $rate['rate'];
    }
}

?>
<main class="container mx-auto p-4">
    <!-- Chart Section -->
    <div class="bg-white p-6 rounded shadow-md mb-8">
        <h2 class="text-2xl font-semibold text-center mb-4">Exchange Rate Trend</h2>
        <canvas id="trendChart" class="w-full"></canvas>
    </div>

</main>

<!-- Include Footer -->
<?php include '../includes/footer.php'; ?>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sample Data for Trend Chart (Replace with real data)
    const labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"];
    const data = {
        labels: labels,
        datasets: [{
            label: 'Exchange Rate Trend',
            data: [100, 120, 110, 140, 150, 130, 160], // Example data
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
                        text: 'Months'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Exchange Rate'
                    },
                    beginAtZero: true,
                }
            }
        }
    };

    // Initialize Chart
    const trendChart = new Chart(
        document.getElementById('trendChart'),
        config
    );
</script>
