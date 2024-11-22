

<section class="bg-center bg-no-repeat bg-[url('https://flowbite.s3.amazonaws.com/docs/jumbotron/conference.jpg')] bg-gray-700 bg-blend-multiply">
    <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">We invest in the world’s potential</h1>
        <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">Here at Flowbite we focus on markets where technology, innovation, and capital can unlock long-term value and drive economic growth.</p>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
            <a href="#" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                Get started
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
            <a href="#" class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                Learn more
            </a>  
        </div>
    </div>
    <main class="container mx-auto p-4">

    <h1 class="text-3xl font-semibold text-center mb-8">Currency Exchange Converter</h1>

    <!-- Conversion Form -->
    <form action="" method="POST" class="space-y-4 bg-white p-6 rounded shadow-md">
        <div class="flex space-x-4">
            <!-- From Currency -->
            <div class="w-1/2">
                <label for="from_currency" class="block text-sm font-medium text-gray-700">From Currency</label>
                <select name="from_currency" id="from_currency" class="w-full border-gray-300 rounded-md">
                    <option value="INR">INR</option>
                    <option value="FRW">FRW</option>
                    <!-- Add more currencies here -->
                </select>
            </div>

            <!-- To Currency -->
            <div class="w-1/2">
                <label for="to_currency" class="block text-sm font-medium text-gray-700">To Currency</label>
                <select name="to_currency" id="to_currency" class="w-full border-gray-300 rounded-md">
                    <option value="INR">INR</option>
                    <option value="FRW">FRW</option>
                    <!-- Add more currencies here -->
                </select>
            </div>
        </div>

        <!-- Amount -->
        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
            <input type="number" name="amount" id="amount" class="w-full border-gray-300 rounded-md" required>
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
            echo "<div class='mt-8 text-center'>
                    <h2 class='text-2xl font-semibold'>Conversion Result</h2>
                    <p class='text-lg'>${amount} ${from_currency} = " . round($converted_amount, 2) . " ${to_currency}</p>
                  </div>";
        } else {
            echo "<div class='mt-8 text-center text-red-600'>
                    <p class='text-lg'>Sorry, the conversion rate for ${from_currency} to ${to_currency} is not available.</p>
                  </div>";
        }
    }
    ?>

</main>

</section>
