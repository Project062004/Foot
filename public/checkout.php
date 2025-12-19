<?php
require_once __DIR__ . '/../src/Views/header.php';

// Redirect if cart empty
if (empty($_SESSION['cart'])) {
    echo "<script>window.location.href = '/cart.php';</script>";
    exit;
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = '/login.php?redirect=checkout';</script>";
    exit;
}
?>

<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-4">
            <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
        </div>

        <form class="space-y-6" action="/place_order.php" method="POST">
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Shipping Information</h3>
                        <p class="mt-1 text-sm text-gray-500">Use a permanent address where you can receive mail.</p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" value="<?= $_SESSION['user_name'] ?? '' ?>"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm">
                            </div>

                            <div class="col-span-6">
                                <label class="block text-sm font-medium text-gray-700">Street address</label>
                                <input type="text"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">ZIP / Postal code</label>
                                <input type="text"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Payment</h3>
                        <p class="mt-1 text-sm text-gray-500">Secure payment options.</p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <fieldset>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input id="push-everything" name="payment_method" type="radio" checked
                                        class="focus:ring-terracotta-500 h-4 w-4 text-terracotta-600 border-gray-300">
                                    <label for="push-everything" class="ml-3 block text-sm font-medium text-gray-700">
                                        UPI / Net Banking
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="push-email" name="payment_method" type="radio"
                                        class="focus:ring-terracotta-500 h-4 w-4 text-terracotta-600 border-gray-300">
                                    <label for="push-email" class="ml-3 block text-sm font-medium text-gray-700">
                                        Credit / Debit Card
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="push-nothing" name="payment_method" type="radio"
                                        class="focus:ring-terracotta-500 h-4 w-4 text-terracotta-600 border-gray-300">
                                    <label for="push-nothing" class="ml-3 block text-sm font-medium text-gray-700">
                                        Cash on Delivery (Retail Only)
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-terracotta-600 border border-transparent rounded-md shadow-sm py-3 px-10 text-base font-medium text-white hover:bg-terracotta-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-terracotta-500">
                    Place Order
                </button>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>