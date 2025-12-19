<?php
session_start();
// Mock Order Placement
// Clear Cart
$_SESSION['cart'] = [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex flex-col items-center justify-center min-h-screen text-center px-4">
    <div class="bg-white p-10 rounded-lg shadow-xl max-w-md w-full">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
            <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Order Confirmed!</h2>
        <p class="text-gray-500 mb-8">
            Thank you for your order. We have received your request and will process it shortly.
            <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'wholesale'): ?>
                <br><span class="text-xs text-terracotta-600 mt-2 block">Wholesale orders are subject to production
                    timelines.</span>
            <?php endif; ?>
        </p>
        <div class="space-y-4">
            <a href="/products.php"
                class="block w-full bg-gray-900 text-white font-bold py-3 px-4 rounded hover:bg-gray-800 transition">Continue
                Shopping</a>
            <a href="/profile.php"
                class="block w-full bg-gray-100 text-gray-900 font-bold py-3 px-4 rounded hover:bg-gray-200 transition">View
                Orders</a>
        </div>
    </div>
</body>

</html>