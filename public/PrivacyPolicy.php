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
    <title>Privacy Policy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
<?php include '../includes/header.php'; ?>
   
    
    <main class="container mx-auto p-6  md:my-24 my-40">
    <div class="bg-blue-600 text-white p-4 shadow-md">
        <h1 class="text-3xl font-bold text-center mb-6">Privacy Policy</h1>
    </div>
        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Introduction</h2>
            <p class="text-gray-700">
                Welcome to our currency exchange application. Your privacy is of utmost importance to us. This Privacy Policy outlines how we collect, use, and protect your personal information when you use our services.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Information We Collect</h2>
            <p class="text-gray-700">
                We collect the following types of information when you use our services:
            </p>
            <ul class="list-disc pl-5 text-gray-700">
                <li><strong>Personal Information:</strong> This includes your name, email address, and any other information you provide when creating an account or contacting us.</li>
                <li><strong>Transaction Data:</strong> Information related to currency exchange requests, payment methods, amounts, and other transaction-related details.</li>
                <li><strong>Usage Data:</strong> Data about how you use the application, including your browsing activity, location, and device information.</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">How We Use Your Information</h2>
            <p class="text-gray-700">
                We use the information we collect for the following purposes:
            </p>
            <ul class="list-disc pl-5 text-gray-700">
                <li>To provide and improve our services, including processing your currency exchange requests.</li>
                <li>To communicate with you, including sending updates, promotional emails, or customer support responses.</li>
                <li>To monitor and analyze the usage of our application, ensuring a better user experience.</li>
                <li>To comply with legal obligations and resolve any disputes that may arise.</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">How We Protect Your Information</h2>
            <p class="text-gray-700">
                We implement industry-standard security measures to protect your personal information. These include encryption, secure data storage, and limiting access to authorized personnel only. However, no data transmission over the internet is 100% secure, and we cannot guarantee the absolute security of your information.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Sharing Your Information</h2>
            <p class="text-gray-700">
                We do not sell or share your personal information with third parties except in the following cases:
            </p>
            <ul class="list-disc pl-5 text-gray-700">
                <li><strong>With Service Providers:</strong> We may share your information with third-party service providers that help us process transactions or provide customer support.</li>
                <li><strong>For Legal Reasons:</strong> We may disclose your information if required by law, such as in response to a subpoena or legal process.</li>
                <li><strong>In the Event of a Merger or Acquisition:</strong> If our company undergoes a merger or acquisition, your information may be transferred to the new owner.</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Your Rights and Choices</h2>
            <p class="text-gray-700">
                You have the following rights regarding your personal information:
            </p>
            <ul class="list-disc pl-5 text-gray-700">
                <li><strong>Access and Update:</strong> You can access and update your personal information through your account settings.</li>
                <li><strong>Data Deletion:</strong> You may request that we delete your personal information, subject to certain legal exceptions.</li>
                <li><strong>Opt-Out:</strong> You can opt-out of receiving promotional emails by following the unsubscribe instructions in the email.</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Cookies and Tracking Technologies</h2>
            <p class="text-gray-700">
                We use cookies and similar tracking technologies to enhance your experience on our site. These technologies help us analyze user behavior, customize content, and improve our services.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold mb-4">Changes to This Privacy Policy</h2>
            <p class="text-gray-700">
                We may update this Privacy Policy from time to time. We will notify you of any significant changes by posting the new Privacy Policy on this page. You are encouraged to review this page periodically to stay informed of any updates.
            </p>
                </section>

    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
