<?php
require_once __DIR__ . '/../src/Views/header.php';
require_once __DIR__ . '/../src/Config/Database.php';

// Calculate Totals
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
$canCheckout = true;
$checkoutMessage = "";

// 240 Rule
if ($hasWholesale && $wholesaleTotalPairs < 240) {
    $canCheckout = false;
    $remaining = 240 - $wholesaleTotalPairs;
    $checkoutMessage = "Wholesale Requirement: You need to order at least 240 pairs. Please add $remaining more pairs.";
}

?>

<div class="bg-gray-50 min-h-screen pt-12 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-10 font-serif tracking-tight">Your Bag</h1>

        <?php if (empty($cart)): ?>
            <div class="text-center py-32 bg-white rounded-3xl shadow-sm border border-gray-100">
                <div class="mb-6">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="mt-2 text-xl font-medium text-gray-900 font-serif">Your bag is empty</h3>
                <p class="mt-1 text-gray-500">Looks like you haven't added anything yet.</p>
                <div class="mt-8">
                    <a href="/products.php"
                        class="inline-flex items-center px-8 py-3 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-gray-900 hover:bg-gray-800 transition-all duration-300">
                        Start Shopping
                    </a>
                </div>
            </div>
        <?php else: ?>

            <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
                <section class="lg:col-span-7">
                    <ul class="space-y-4">
                        <?php foreach ($cart as $key => $item): ?>
                            <li
                                class="flex flex-col sm:flex-row bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transition-shadow hover:shadow-md">
                                <div class="flex-shrink-0 relative group">
                                    <img src="<?= $item['image'] ?? 'https://via.placeholder.com/150' ?>"
                                        class="w-full h-48 sm:w-32 sm:h-32 rounded-xl object-center object-cover bg-gray-100">
                                </div>

                                <div class="mt-4 sm:mt-0 sm:ml-6 flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-lg font-bold text-gray-900 font-serif">
                                                <a href="/product.php?id=<?= $item['product_id'] ?>"
                                                    class="hover:text-terracotta-600 transition-colors">
                                                    <?= htmlspecialchars($item['name']) ?>
                                                </a>
                                            </h3>
                                            <p class="text-lg font-bold text-gray-900 font-serif">
                                                <?php if ($item['type'] == 'wholesale'): ?>
                                                    ₹<?= number_format($item['total_price']) ?>
                                                <?php else: ?>
                                                    ₹<?= number_format($item['price']) ?>
                                                <?php endif; ?>
                                            </p>
                                        </div>

                                        <div
                                            class="mt-1 flex items-center text-xs tracking-wide uppercase text-gray-500 font-bold">
                                            <span class="bg-gray-100 px-2 py-0.5 rounded text-gray-600"><?= $item['type'] ?>
                                                Order</span>
                                        </div>

                                        <?php if ($item['type'] == 'wholesale'): ?>
                                            <div class="mt-3 text-sm text-gray-600 space-y-1">
                                                <p>Total Pairs: <span
                                                        class="font-bold text-gray-900"><?= $item['total_quantity'] ?></span></p>
                                                <p>Price per Pair: ₹<?= $item['price_per_pair'] ?></p>
                                                <p>Packaging: <span class="capitalize font-medium"><?= $item['packaging'] ?></span>
                                                    <span class="text-gray-400 text-xs">(+₹<?= $item['packaging_cost'] ?>)</span>
                                                </p>
                                                <div
                                                    class="text-xs text-terracotta-600 bg-terracotta-50 inline-block px-2 py-1 rounded mt-1">
                                                    <?= count($item['colors']) ?> Colors Selected (Auto-Split)
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="mt-3 text-sm text-gray-500 flex space-x-4">
                                                <?php if (!empty($item['color_name'])): ?>
                                                    <p class="flex items-center"><span
                                                            class="w-3 h-3 rounded-full bg-gray-200 mr-2 border border-gray-300"></span>
                                                        <?= $item['color_name'] ?></p>
                                                <?php endif; ?>
                                                <?php if (!empty($item['size'])): ?>
                                                    <p class="border-l border-gray-300 pl-4">Size: <span
                                                            class="font-medium text-gray-900"><?= $item['size'] ?></span></p>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mt-4 flex justify-between items-center sm:mt-0">
                                        <?php if ($item['type'] !== 'wholesale'): ?>
                                            <div class="flex items-center space-x-3">
                                                <label class="text-sm text-gray-500">Qty</label>
                                                <select
                                                    class="rounded-lg border-gray-200 py-1.5 text-base font-medium text-gray-700 focus:outline-none focus:ring-1 focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm bg-gray-50">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                        <?php else: ?>
                                            <div></div> <!-- Spacer -->
                                        <?php endif; ?>

                                        <button onclick="removeItem(<?= $key ?>)"
                                            class="text-sm font-medium text-red-500 hover:text-red-700 transition-colors flex items-center group">
                                            <svg class="h-4 w-4 mr-1 group-hover:scale-110 transition-transform" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>

                <!-- Summary -->
                <section
                    class="mt-16 bg-white rounded-3xl shadow-lg shadow-gray-200/50 px-6 py-8 sm:p-8 lg:mt-0 lg:col-span-5 sticky top-28 border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 font-serif mb-6">Order Summary</h2>

                    <dl class="space-y-4">
                        <div class="flex items-center justify-between">
                            <dt class="text-sm text-gray-500">Subtotal</dt>
                            <dd class="text-sm font-medium text-gray-900">₹<?= number_format($grandTotal) ?></dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                            <dt class="text-sm text-gray-500">Shipping Estimate</dt>
                            <dd class="text-sm font-medium text-green-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Free
                            </dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-100 pt-6">
                            <dt class="text-xl font-bold text-gray-900 font-serif">Order Total</dt>
                            <dd class="text-xl font-bold text-gray-900 font-serif">₹<?= number_format($grandTotal) ?></dd>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 text-right">Inclusive of all taxes</p>
                    </dl>

                    <div class="mt-8">
                        <!-- 240 Rule Error -->
                        <?php if (!$canCheckout): ?>
                            <div class="rounded-xl bg-red-50 p-4 mb-4 border border-red-100">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Minimum Order Requirement</h3>
                                        <p class="mt-1 text-sm text-red-700"><?= $checkoutMessage ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button type="button" <?= !$canCheckout ? 'disabled' : '' ?>
                                onclick="window.location.href='/checkout.php'"
                                class="w-full bg-gray-900 border border-transparent rounded-full shadow-lg hover:shadow-xl py-4 px-4 text-base font-bold text-white hover:bg-gray-800 disabled:bg-gray-300 disabled:cursor-not-allowed transition-all duration-300 transform hover:-translate-y-0.5">
                                Checkout Securely
                            </button>
                        <?php else: ?>
                            <button type="button"
                                onclick="alert('Please Login to Checkout'); window.location.href='/login.php?redirect=checkout'"
                                class="w-full bg-gray-900 border border-transparent rounded-full shadow-lg hover:shadow-xl py-4 px-4 text-base font-bold text-white hover:bg-gray-800 transition-all duration-300 transform hover:-translate-y-0.5">
                                Login to Checkout
                            </button>
                        <?php endif; ?>

                        <div class="mt-6 flex justify-center space-x-4 grayscale opacity-50">
                            <!-- Trust signals / Payment Icons placeholders -->
                            <span class="h-8 w-12 bg-gray-200 rounded"></span>
                            <span class="h-8 w-12 bg-gray-200 rounded"></span>
                            <span class="h-8 w-12 bg-gray-200 rounded"></span>
                        </div>
                    </div>
                </section>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function removeItem(index) {
        if (!confirm('Are you sure you want to remove this item?')) return;
        fetch('/api/cart_remove.php', {
            method: 'POST',
            body: JSON.stringify({ index: index }),
            headers: { 'Content-Type': 'application/json' }
        }).then(() => window.location.reload());
    }
</script>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>