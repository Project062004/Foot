<?php
session_start();
// Enforce Admin Access
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: /admin/login.php');
    exit;
}
require_once __DIR__ . '/../../src/Config/Database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->connect();

// Fetch Pending Approvals
$stmt = $conn->prepare("SELECT * FROM users WHERE account_type = 'wholesale' AND is_verified = 0 ORDER BY created_at DESC");
$stmt->execute();
$pendingUsers = $stmt->fetchAll();

// Mock Stats (In real app, run COUNT(*) queries)
$totalRevenue = 245890;
$totalOrders = 1234;
$totalProducts = 156;
$totalCustomers = 2891;

// Fetch Recent Orders Mock
$recentOrders = [
    ['id' => 'ORD-001', 'customer' => 'Priya M.', 'total' => '2,098', 'status' => 'Delivered', 'date' => 'Dec 10'],
    ['id' => 'ORD-002', 'customer' => 'Sneha K.', 'total' => '1,299', 'status' => 'In Transit', 'date' => 'Dec 9'],
    ['id' => 'ORD-003', 'customer' => 'Ananya S.', 'total' => '3,599', 'status' => 'Pending', 'date' => 'Dec 8'],
];

require_once __DIR__ . '/../../src/Views/admin_header.php';
?>

<!-- Tab Navigation (Visual Only for Dashboard Home) -->
<div class="mb-8">
    <div class="bg-gray-200 p-1 rounded-lg inline-flex">
        <button class="px-6 py-2 bg-white rounded-md shadow-sm text-sm font-medium text-gray-900">Dashboard</button>
        <button class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-900">Orders</button>
        <button class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-900">Products</button>
        <button class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-900">Users</button>
        <button class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-900">Analytics</button>
    </div>
</div>

<!-- Pending Approvals Section -->
<div class="mb-10">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
            </path>
        </svg>
        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest">Pending Wholesale Approvals
            (<?= count($pendingUsers) ?>)</h3>
    </div>

    <?php if (count($pendingUsers) > 0): ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <?php foreach ($pendingUsers as $user): ?>
                <div class="bg-orange-50 border border-orange-100 rounded-xl p-6 shadow-sm relative">
                    <div class="absolute top-6 right-6">
                        <span
                            class="bg-white border border-gray-200 text-gray-600 text-xs px-2 py-1 rounded font-medium">Pending</span>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 font-serif mb-1">
                        <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                    </h4>
                    <p class="text-xs text-gray-500 font-mono mb-4">GST: <?= htmlspecialchars($user['gst_number'] ?? 'N/A') ?>
                    </p>

                    <div class="text-sm text-gray-600 space-y-1 mb-6">
                        <p><span class="font-bold">Contact:</span> <?= htmlspecialchars($user['first_name']) ?> .</p>
                        <p><span class="font-bold">Email:</span> <?= htmlspecialchars($user['email']) ?></p>
                        <p><span class="font-bold">Applied:</span> <?= date('M d', strtotime($user['created_at'])) ?></p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button onclick="approveUser(<?= $user['id'] ?>)"
                            class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-bold text-sm flex items-center justify-center transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Approve
                        </button>
                        <button
                            class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-bold text-sm flex items-center justify-center transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                            Reject
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl p-6 text-center text-gray-500 border border-gray-200">
            No pending approvals.
        </div>
    <?php endif; ?>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Revenue</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">₹<?= number_format($totalRevenue) ?></h3>
            </div>
            <div class="p-2 bg-gray-50 rounded-lg">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>
        <span class="text-xs text-green-600 font-bold bg-green-50 px-2 py-1 rounded">+12.5%</span>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-xs text-gray-500 font-medium">Total Orders</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1"><?= number_format($totalOrders) ?></h3>
            </div>
            <div class="p-2 bg-gray-50 rounded-lg">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
        </div>
        <span class="text-xs text-green-600 font-bold bg-green-50 px-2 py-1 rounded">+8.2%</span>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-xs text-gray-500 font-medium">Products</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1"><?= number_format($totalProducts) ?></h3>
            </div>
            <div class="p-2 bg-gray-50 rounded-lg">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <span class="text-xs text-green-600 font-bold bg-green-50 px-2 py-1 rounded">+3 new</span>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-xs text-gray-500 font-medium">Customers</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1"><?= number_format($totalCustomers) ?></h3>
            </div>
            <div class="p-2 bg-gray-50 rounded-lg">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </div>
        </div>
        <span class="text-xs text-green-600 font-bold bg-green-50 px-2 py-1 rounded">+145</span>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- Recent Orders (Span 2) -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-900">Recent Orders</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-medium">
                    <tr>
                        <th class="px-6 py-4">Order ID</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($recentOrders as $order): ?>
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-4 font-bold text-gray-900"><?= $order['id'] ?></td>
                            <td class="px-6 py-4 text-gray-600"><?= $order['customer'] ?></td>
                            <td class="px-6 py-4 font-bold text-gray-900">₹<?= $order['total'] ?></td>
                            <td class="px-6 py-4">
                                <?php
                                $color = 'gray';
                                if ($order['status'] == 'Delivered')
                                    $color = 'terracotta'; // Using brand color for primary success look
                                if ($order['status'] == 'Pending')
                                    $color = 'yellow';
                                if ($order['status'] == 'In Transit')
                                    $color = 'blue';
                                ?>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?= $color ?>-100 text-<?= $color ?>-800">
                                    <?= $order['status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-gray-500"><?= $order['date'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products (Span 1) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="font-bold text-gray-900">Top Products</h3>
        </div>
        <div class="p-6 space-y-6">
            <!-- Item 1 -->
            <div>
                <div class="flex justify-between items-end mb-1">
                    <span class="font-medium text-gray-900 text-sm">Aether Pro Runner</span>
                    <div class="text-right">
                        <span class="block text-xs font-bold text-gray-900">234 sales</span>
                        <span class="block text-[10px] text-gray-400">₹304k</span>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-terracotta-600 h-1.5 rounded-full" style="width: 85%"></div>
                </div>
            </div>
            <!-- Item 2 -->
            <div>
                <div class="flex justify-between items-end mb-1">
                    <span class="font-medium text-gray-900 text-sm">Pearl Flat</span>
                    <div class="text-right">
                        <span class="block text-xs font-bold text-gray-900">189 sales</span>
                        <span class="block text-[10px] text-gray-400">₹151k</span>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-terracotta-500 h-1.5 rounded-full" style="width: 70%"></div>
                </div>
            </div>
            <!-- Item 3 -->
            <div>
                <div class="flex justify-between items-end mb-1">
                    <span class="font-medium text-gray-900 text-sm">Obsidian Heel</span>
                    <div class="text-right">
                        <span class="block text-xs font-bold text-gray-900">156 sales</span>
                        <span class="block text-[10px] text-gray-400">₹249k</span>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-terracotta-400 h-1.5 rounded-full" style="width: 60%"></div>
                </div>
            </div>
            <!-- Item 4 -->
            <div>
                <div class="flex justify-between items-end mb-1">
                    <span class="font-medium text-gray-900 text-sm">Cognac Sandal</span>
                    <div class="text-right">
                        <span class="block text-xs font-bold text-gray-900">142 sales</span>
                        <span class="block text-[10px] text-gray-400">₹128k</span>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-terracotta-400 h-1.5 rounded-full" style="width: 50%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function approveUser(id) {
        if (!confirm('Are you sure you want to approve this wholesale account?')) return;

        fetch('/admin/api/approve_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: id })
        })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert('User Approved!');
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
    }
</script>

<?php
require_once __DIR__ . '/../../src/Views/admin_footer.php';
?>