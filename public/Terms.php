<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
<?php include '../includes/header.php'; ?>
    <main class="container mx-auto md:my-24 my-40 p-6">
    <div class="bg-blue-600 text-white p-4 shadow-md">
        <h1 class="text-3xl font-bold text-center mb-6">Terms & Conditions</h1>
    </div>
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Introduction</h2>
            <p class="text-gray-700">
                Welcome to our currency exchange application. These Terms & Conditions govern your access to and use of our services. By using our website or mobile app, you agree to comply with and be bound by these Terms. Please read them carefully.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Acceptance of Terms</h2>
            <p class="text-gray-700">
                By accessing or using our platform, you accept and agree to be bound by these Terms & Conditions. If you do not agree with these terms, you are not authorized to use the services.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Changes to the Terms</h2>
            <p class="text-gray-700">
                We reserve the right to update, modify, or change these Terms at any time. We will notify you of any significant changes by posting the updated Terms & Conditions on this page. You are encouraged to review this page periodically.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">User Responsibilities</h2>
            <p class="text-gray-700">
                As a user of our services, you agree to:
            </p>
            <ul class="list-disc pl-5 text-gray-700">
                <li>Provide accurate and up-to-date information when creating an account or making transactions.</li>
                <li>Comply with all applicable laws, regulations, and guidelines related to currency exchange transactions.</li>
                <li>Ensure that your payment method is legitimate and authorized for use in currency exchange transactions.</li>
                <li>Not engage in fraudulent, illegal, or unethical activities while using the platform.</li>
                <li>Not share your account credentials (e.g., username, password) with anyone to protect your account from unauthorized access.</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Account Suspension and Termination</h2>
            <p class="text-gray-700">
                We reserve the right to suspend or terminate your account at any time if we determine that you have violated these Terms & Conditions or engaged in illegal or fraudulent activities. If your account is terminated, you will not be entitled to a refund for any fees or transactions.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Transaction Fees</h2>
            <p class="text-gray-700">
                Our platform may charge transaction fees for currency exchange. These fees will be displayed at the time of the transaction and are subject to change. By using our service, you agree to pay any applicable fees as outlined in the transaction process.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Dispute Resolution</h2>
            <p class="text-gray-700">
                In the event of a dispute between you and us regarding the use of our services, we encourage you to first contact our customer support team to resolve the issue. If the dispute cannot be resolved through customer support, you agree to submit the dispute to binding arbitration, as outlined in our arbitration policy.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Limitation of Liability</h2>
            <p class="text-gray-700">
                Our company is not liable for any loss, damage, or harm arising from your use of our platform, including but not limited to financial losses, system errors, or downtime. We are also not responsible for any third-party services or websites linked to or integrated with our platform.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Privacy and Data Collection</h2>
            <p class="text-gray-700">
                Our Privacy Policy explains how we collect, use, and protect your personal data. By using our services, you agree to the practices described in our Privacy Policy.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Governing Law</h2>
            <p class="text-gray-700">
                These Terms & Conditions are governed by and construed in accordance with the laws of [Your Country], without regard to its conflict of law principles. Any legal action or proceeding related to these Terms shall be exclusively brought in the courts of [Your Country].
            </p>
        </section>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
