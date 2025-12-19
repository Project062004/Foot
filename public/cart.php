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

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

    <?php if (empty($cart)): ?>
        <div class="text-center py-20 bg-gray-50 rounded-lg">
            <p class="text-gray-500 mb-4">Your cart is empty.</p>
            <a href="/products.php" class="text-terracotta-600 hover:text-terracotta-500 font-medium">Continue Shopping</a>
        </div>
    <?php else: ?>

        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            <section class="lg:col-span-7">
                <ul class="border-t border-b border-gray-200 divide-y divide-gray-200">
                    <?php foreach ($cart as $key => $item): ?>
                        <li class="flex py-6 sm:py-10">
                            <div class="flex-shrink-0">
                                <img src="<?= $item['image'] ?? 'https://via.placeholder.com/150' ?>"
                                    class="w-24 h-24 rounded-md object-center object-cover sm:w-48 sm:h-48">
                            </div>

                            <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                                <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                    <div>
                                        <div class="flex justify-between">
                                            <h3 class="text-sm">
                                                <a href="/product.php?id=<?= $item['product_id'] ?>"
                                                    class="font-medium text-gray-700 hover:text-gray-800">
                                                    <?= htmlspecialchars($item['name']) ?>
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="mt-1 flex text-sm">
                                            <p class="text-gray-500 capitalize"><?= $item['type'] ?> Order</p>
                                        </div>

                                        <?php if ($item['type'] == 'wholesale'): ?>
                                            <div class="mt-2 text-sm text-gray-500">
                                                <p>Total Pairs: <span
                                                        class="font-bold text-gray-900"><?= $item['total_quantity'] ?></span></p>
                                                <p>Price/Pair: ₹<?= $item['price_per_pair'] ?></p>
                                                <p>Packaging: <span class="capitalize"><?= $item['packaging'] ?></span>
                                                    (+₹<?= $item['packaging_cost'] ?>)</p>
                                                <p class="text-xs text-terracotta-600 mt-1">Colors: <?= count($item['colors']) ?>
                                                    Selected (Auto-Split)</p>
                                            </div>
                                        <?php else: ?>
                                            <div class="mt-2 text-sm text-gray-500">
                                                <p>Color: <?= $item['color_name'] ?? 'N/A' ?></p>
                                                <p>Size: <?= $item['size'] ?? 'N/A' ?></p>
                                            </div>
                                        <?php endif; ?>

                                        <p class="mt-4 font-medium text-gray-900">
                                            <?php if ($item['type'] == 'wholesale'): ?>
                                                ₹<?= number_format($item['total_price']) ?>
                                            <?php else: ?>
                                                ₹<?= number_format($item['price']) ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>

                                    <div class="mt-4 sm:mt-0 sm:pr-9">
                                        <?php if ($item['type'] !== 'wholesale'): ?>
                                            <label class="sr-only">Quantity</label>
                                            <select
                                                class="max-w-full rounded-md border border-gray-300 py-1.5 text-base leading-5 font-medium text-gray-700 text-left shadow-sm focus:outline-none focus:ring-1 focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                            </select>
                                        <?php endif; ?>

                                        <div class="absolute top-0 right-0">
                                            <button onclick="removeItem(<?= $key ?>)"
                                                class="-m-2 p-2 inline-flex text-gray-400 hover:text-gray-500">
                                                <span class="sr-only">Remove</span>
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <!-- Summary -->
            <section
                class="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5 border border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>

                <dl class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Subtotal</dt>
                        <dd class="text-sm font-medium text-gray-900">₹<?= number_format($grandTotal) ?></dd>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                        <dt class="text-sm text-gray-600">Shipping Estimate</dt>
                        <dd class="text-sm font-medium text-green-600">Free</dd>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                        <dt class="text-base font-bold text-gray-900">Order Total</dt>
                        <dd class="text-base font-bold text-gray-900">₹<?= number_format($grandTotal) ?></dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <!-- 240 Rule Error -->
                    <?php if (!$canCheckout): ?>
                        <div class="rounded-md bg-red-50 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Checkout Unavailable</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p><?= $checkoutMessage ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <button type="button" <?= !$canCheckout ? 'disabled' : '' ?>
                        onclick="window.location.href='/checkout.php'"
                        class="w-full bg-terracotta-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-terracotta-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-terracotta-500 disabled:bg-gray-400 disabled:cursor-not-allowed transition-all">
                        Proceed to Checkout
                    </button>
                </div>
            </section>
        </div>
    <?php endif; ?>
</div>

<script>
    function removeItem(index) {
        if (!confirm('Remove this item?')) return;
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