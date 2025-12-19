<?php
session_start();
require_once __DIR__ . '/../src/Views/header.php';
require_once __DIR__ . '/../src/Config/Database.php';

use App\Config\Database;

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='/login.php';</script>";
    exit;
}

$db = new Database();
$conn = $db->connect();

// Fetch User Details
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

// Fetch Recent Orders
$oStmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :uid ORDER BY created_at DESC LIMIT 5");
$oStmt->execute(['uid' => $_SESSION['user_id']]);
$orders = $oStmt->fetchAll();

?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Welcome Header -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div data-aos="fade-right">
                <h1 class="text-4xl font-serif font-bold text-gray-900">
                    Welcome, <?= htmlspecialchars($user['first_name']) ?>
                </h1>
                <p class="text-gray-500 mt-2">Manage your profile and track your orders.</p>
            </div>
            <div data-aos="fade-left">
                <a href="/logout.php"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-colors">
                    Sign Out
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Profile Card -->
            <div class="lg:col-span-1" data-aos="fade-up">
                <div class="bg-white rounded-[2rem] shadow-lg p-8 overflow-hidden relative">
                    <div
                        class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-terracotta-400 to-terracotta-600">
                    </div>

                    <div class="flex items-center space-x-4 mb-8">
                        <div
                            class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-2xl font-bold text-terracotta-600">
                            <?= substr($user['first_name'], 0, 1) ?>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">
                                <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h2>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-terracotta-100 text-terracotta-800 capitalize">
                                <?= htmlspecialchars($user['account_type']) ?> Account
                            </span>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wide">Contact
                                Info</label>
                            <div class="mt-2 flex items-center text-sm text-gray-900">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <?= htmlspecialchars($user['email']) ?>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-900">
                                <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                +91 <?= htmlspecialchars($user['mobile']) ?>
                            </div>
                        </div>

                        <?php if ($user['account_type'] === 'wholesale'): ?>
                            <div class="pt-4 border-t border-gray-100">
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wide">Business
                                    Details</label>
                                <div class="mt-2 text-sm text-gray-900">
                                    <span class="font-medium">GST No:</span>
                                    <?= htmlspecialchars($user['gst_number'] ?? 'N/A') ?>
                                </div>
                                <div class="mt-2 text-sm">
                                    <span class="font-medium">Status:</span>
                                    <span class="text-green-600 font-bold">Verified Partner</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Order History -->
            <div class="lg:col-span-2" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-[2rem] shadow-lg p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 font-serif">Order History</h3>

                    <?php if (empty($orders)): ?>
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">You haven't placed any orders yet.</p>
                            <a href="/products.php" class="text-terracotta-600 hover:text-terracotta-700 font-bold">Start
                                Shopping &rarr;</a>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm whitespace-nowrap">
                                <thead
                                    class="uppercase tracking-wider border-b border-gray-100 text-gray-400 font-medium text-xs">
                                    <tr>
                                        <th scope="col" class="px-6 py-4">Order ID</th>
                                        <th scope="col" class="px-6 py-4">Date</th>
                                        <th scope="col" class="px-6 py-4">Status</th>
                                        <th scope="col" class="px-6 py-4 text-right">Total</th>
                                        <th scope="col" class="px-6 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr class="hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                                            <td class="px-6 py-4 font-medium text-gray-900">
                                                #<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?>
                                            </td>
                                            <td class="px-6 py-4 text-gray-500">
                                                <?= date('M d, Y', strtotime($order['created_at'])) ?>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                <?php
                                                switch ($order['status']) {
                                                    case 'completed':
                                                        echo 'bg-green-100 text-green-800';
                                                        break;
                                                    case 'pending':
                                                        echo 'bg-yellow-100 text-yellow-800';
                                                        break;
                                                    case 'cancelled':
                                                        echo 'bg-red-100 text-red-800';
                                                        break;
                                                    default:
                                                        echo 'bg-gray-100 text-gray-800';
                                                }
                                                ?> capitalize">
                                                    <?= $order['status'] ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right font-bold text-gray-900">
                                                ₹<?= number_format($order['total_amount']) ?>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="#"
                                                    class="text-terracotta-600 hover:text-terracotta-900 font-medium text-xs uppercase tracking-wide">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>