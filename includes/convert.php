<main class="container mx-auto p-4">

<h1 class="text-4xl font-bold text-center mb-4 text-blue-700">Currency Exchange Converter</h1>

<!-- Conversion Form -->
<form action="" method="POST" class="space-y-4 bg-white p-4 md:p-10 rounded shadow-md">
    <div class="flex space-x-4">
        <!-- From Currency -->
        <div class="w-1/2">
            <label for="from_currency" class="block text-sm font-medium text-gray-700">From Currency</label>
            <select name="from_currency" id="from_currency" class="w-full border-gray-300 rounded-md border p-2 font-bold">
                <option value="FRW">FRW</option>
                <option value="INR">INR</option>
                <!-- Add more currencies here -->
            </select>
        </div>

        <!-- To Currency -->
        <div class="w-1/2">
            <label for="to_currency" class="block text-sm font-medium text-gray-700">To Currency</label>
            <select name="to_currency" id="to_currency" class="w-full border-gray-300 rounded-md border p-2 font-bold">
                <option value="INR">INR</option>
                <option value="FRW">FRW</option>
                <!-- Add more currencies here -->
            </select>
        </div>
    </div>

    <!-- Amount -->
    <div>
        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
        <input type="number" name="amount" id="amount" class="w-full border-gray-300 rounded-md border p-2 font-bold" required>
    </div>

    <button type="submit" class="bg-blue-600 text-white font-bold px-6 py-2 rounded hover:bg-blue-700 w-full">Convert</button>
</form>

<?php
// Handle form submission and currency conversion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from_currency = $_POST['from_currency'];
    $to_currency = $_POST['to_currency'];
    $amount = $_POST['amount'];

    // Check if the rate exists
    if (isset($rates[$from_currency][$to_currency])) {
        $rate = $rates[$from_currency][$to_currency];
        $converted_amount = $amount * $rate;

        // Display the conversion result
        echo "<div class='mt-8 text-center p-2 border bg-green-100 rounded-md'>
                <h2 class='text-2xl font-bold text-green-600'>Conversion Result</h2>
                <p class='text-lg'>${amount} ${from_currency} = " . round($converted_amount, 2) . " ${to_currency}</p>
              </div>";
    } else {
        echo "<div class='mt-8 text-center text-red-600 p-2 border bg-red-100 rounded-md'>
                <p class='text-lg'>Sorry, the conversion rate for ${from_currency} to ${to_currency} is not available.</p>
              </div>";
    }
}
?>

</main>