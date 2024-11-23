<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'currency-app');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch available currencies from exchange_rates table
$query = "SELECT DISTINCT from_currency, to_currency FROM exchange_rates";
$result = mysqli_query($conn, $query);

// Prepare an array of unique currencies
$currencies = [];
while ($row = mysqli_fetch_assoc($result)) {
    $currencies[] = $row['from_currency'];
    $currencies[] = $row['to_currency'];
}
$currencies = array_unique($currencies);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function convertCurrency(event) {
            event.preventDefault(); // Prevent form submission

            // Fetch form data
            const fromCurrency = document.getElementById('from_currency').value;
            const toCurrency = document.getElementById('to_currency').value;
            const amount = parseFloat(document.getElementById('amount').value);

            if (!fromCurrency || !toCurrency || isNaN(amount) || amount <= 0) {
                alert('Please fill in all fields correctly.');
                return;
            }

            // Perform the calculation (simulate server-side logic)
            const rates = <?php
                // Fetch rates as a JavaScript object
                $rateQuery = "SELECT from_currency, to_currency, rate FROM exchange_rates";
                $rateResult = mysqli_query($conn, $rateQuery);
                $rates = [];
                while ($rateRow = mysqli_fetch_assoc($rateResult)) {
                    $rates[$rateRow['from_currency']][$rateRow['to_currency']] = $rateRow['rate'];
                }
                echo json_encode($rates);
            ?>;

            if (!rates[fromCurrency] || !rates[fromCurrency][toCurrency]) {
                alert('Exchange rate not found!');
                return;
            }

            const rate = rates[fromCurrency][toCurrency];
            const convertedAmount = (amount * rate).toFixed(2);

            // Display the result in a centered prompt
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = `
                <div class="fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 z-50">
                    <div class="bg-white p-6 rounded shadow-lg text-center">
                        <h2 class="text-xl font-bold mb-4">Converted Amount</h2>
                        <p class="text-2xl font-semibold">${convertedAmount} ${toCurrency}</p>
                        <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700" onclick="closeResult()">Close</button>
                    </div>
                </div>
            `;
        }

        function closeResult() {
            document.getElementById('result').innerHTML = '';
        }
    </script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-6 rounded shadow-lg md:w-2/3 w-full">
        <h1 class="text-center text-2xl font-bold mb-4">Currency Converter</h1>
        <form id="converterForm" onsubmit="convertCurrency(event)" class="space-y-4">
            <div>
                <label for="from_currency" class="block text-sm font-medium text-gray-700">From Currency</label>
                <select id="from_currency" name="from_currency" required class="w-full border border-gray-300 p-2 rounded">
                    <option value="">Select Currency</option>
                    <?php foreach ($currencies as $currency): ?>
                        <option value="<?php echo $currency; ?>"><?php echo $currency; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="to_currency" class="block text-sm font-medium text-gray-700">To Currency</label>
                <select id="to_currency" name="to_currency" required class="w-full border border-gray-300 p-2 rounded">
                    <option value="">Select Currency</option>
                    <?php foreach ($currencies as $currency): ?>
                        <option value="<?php echo $currency; ?>"><?php echo $currency; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" step="0.01" id="amount" name="amount" required class="w-full border border-gray-300 p-2 rounded">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-700">Convert</button>
        </form>
    </div>

    <!-- Result Modal -->
    <div id="result"></div>
</body>
</html>
