<?php
require_once __DIR__ . '/../src/Views/header.php';

// Redirect if cart empty
if (empty($_SESSION['cart'])) {
    echo "<script>window.location.href = '" . $basePath . "/cart.php';</script>";
    exit;
}

// Ensure Login
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = '" . $basePath . "/login.php?redirect=' + encodeURIComponent(window.location.pathname);</script>";
    exit;
}

// Calculate Totals (Same logic as Cart)
$cart = $_SESSION['cart'] ?? [];
$retailTotal = 0;
$wholesaleTotalPairs = 0;
$wholesaleTotalAmount = 0;
$hasWholesale = false;

foreach ($cart as $item) {
    if ($item['type'] === 'retail' || $item['type'] === 'sample') {
        $retailTotal += $item['price'] * $item['quantity'];
    } elseif ($item['type'] === 'wholesale') {
        $hasWholesale = true;
        $wholesaleTotalPairs += $item['total_quantity'];
        $wholesaleTotalAmount += $item['total_price'];
    }
}

$grandTotal = $retailTotal + $wholesaleTotalAmount;

// Check consistency (240 Rule Removed)
// if ($hasWholesale && $wholesaleTotalPairs < 240) { ... }
?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-10 text-center md:text-left">
            <h1 class="text-4xl font-serif font-bold text-gray-900">Secure Checkout</h1>
            <p class="text-gray-500 mt-2">Complete your order securely.</p>
        </div>

        <form action="<?= $basePath ?>/place_order.php" method="POST"
            class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">

            <!-- LEFT COLUMN: FORMS -->
            <section class="lg:col-span-7 space-y-8">

                <!-- Shipping Info -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span
                            class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm mr-3">1</span>
                        Shipping Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Full
                                Name</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900 transition-all font-medium">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Phone
                                Number</label>
                            <input type="tel" name="phone" placeholder="+91 98765 43210" required
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900 transition-all font-medium">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Email
                                Address</label>
                            <input type="email" value="<?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>" readonly
                                class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-3 text-gray-500 cursor-not-allowed">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Street
                                Address</label>
                            <input type="text" name="address"
                                placeholder="Flat, House no., Building, Company, Apartment" required
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900 transition-all font-medium">
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">City</label>
                            <input type="text" name="city" required
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900 transition-all font-medium">
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Pincode</label>
                            <input type="text" name="pincode" required
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-900 transition-all font-medium">
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span
                            class="w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm mr-3">2</span>
                        Payment Method
                    </h2>

                    <div class="space-y-4">
                        <label
                            class="relative flex items-center justify-between p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-gray-900 transition-all bg-gray-50 group">
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="upi" checked
                                    class="text-gray-900 focus:ring-gray-900 h-5 w-5 border-gray-300">
                                <span class="ml-3 font-bold text-gray-900">UPI / Net Banking</span>
                            </div>
                            <!-- Icon placeholder -->
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-gray-900" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </label>

                        <label
                            class="relative flex items-center justify-between p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-gray-900 transition-all bg-white group">
                            <div class="flex items-center">
                                <input type="radio" name="payment_method" value="card"
                                    class="text-gray-900 focus:ring-gray-900 h-5 w-5 border-gray-300">
                                <span class="ml-3 font-bold text-gray-900">Credit / Debit Card</span>
                            </div>
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-gray-900" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </label>

                        <?php if (!$hasWholesale): ?>
                            <label
                                class="relative flex items-center justify-between p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-gray-900 transition-all bg-white group">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_method" value="cod"
                                        class="text-gray-900 focus:ring-gray-900 h-5 w-5 border-gray-300">
                                    <span class="ml-3 font-bold text-gray-900">Cash on Delivery</span>
                                </div>
                                <span class="text-xs font-bold bg-green-100 text-green-800 px-2 py-1 rounded">Retail
                                    Only</span>
                            </label>
                        <?php endif; ?>
                    </div>
                </div>

            </section>

            <!-- RIGHT COLUMN: SUMMARY -->
            <section class="lg:col-span-5 mt-10 lg:mt-0">
                <div class="sticky top-24">
                    <div class="bg-white rounded-[2rem] shadow-lg border border-gray-100 p-8 overflow-hidden relative">
                        <!-- Decorative top pattern -->
                        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-gray-900 to-gray-700"></div>

                        <h2 class="text-xl font-bold text-gray-900 mb-6 font-serif">Order Summary</h2>

                        <div class="max-h-80 overflow-y-auto scrollbar-hide space-y-4 mb-6 pr-2">
                            <?php foreach ($cart as $item): ?>
                                <div class="flex items-start py-2 border-b border-gray-50 last:border-0">
                                    <img src="<?= $item['image'] ?>"
                                        class="w-16 h-16 rounded-lg object-cover bg-gray-50 border border-gray-100">
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-sm font-bold text-gray-900 line-clamp-1">
                                            <?= htmlspecialchars($item['name']) ?>
                                        </h3>
                                        <p class="text-xs text-gray-500 mb-1">
                                            <?php if ($item['type'] == 'retail'): ?>
                                                Size: <?= $item['size'] ?> | Color: <?= htmlspecialchars($item['color_name']) ?>
                                            <?php elseif ($item['type'] == 'wholesale'): ?>
                                                Wholesale (<?= $item['total_quantity'] ?> Pairs)
                                            <?php endif; ?>
                                        </p>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-500">Qty: <?= $item['quantity'] ?? 1 ?></span>
                                            <span class="font-bold text-gray-900">
                                                ₹<?= number_format($item['type'] == 'wholesale' ? $item['total_price'] : $item['price'] * $item['quantity']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="space-y-3 pt-6 border-t border-gray-100 mb-6">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal</span>
                                <span>₹<?= number_format($grandTotal) ?></span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Shipping Ref.</span>
                                <span class="text-green-600 font-bold">FREE</span>
                            </div>
                            <div
                                class="flex justify-between text-xl font-bold text-gray-900 pt-3 border-t border-dashed border-gray-200">
                                <span>Total</span>
                                <span>₹<?= number_format($grandTotal) ?></span>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-gray-900 hover:bg-black text-white py-4 rounded-xl font-bold uppercase tracking-widest text-sm shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                            Place Order
                        </button>

                        <div
                            class="mt-6 flex justify-center space-x-4 opacity-50 grayscale hover:grayscale-0 transition-all">
                            <!-- Simple placeholders specifically asked for Trust Signals -->
                            <img src="https://cdn-icons-png.flaticon.com/512/196/196578.png" class="h-8" title="Visa">
                            <img src="https://cdn-icons-png.flaticon.com/512/196/196566.png" class="h-8"
                                title="Mastercard">
                            <img src="https://cdn-icons-png.flaticon.com/512/196/196565.png" class="h-8" title="PayPal">
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="<?= $basePath ?>/cart.php"
                            class="text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Bag
                        </a>
                    </div>
                </div>
            </section>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../src/Views/footer.php'; ?>