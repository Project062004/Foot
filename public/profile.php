<?php
session_start();
require_once __DIR__ . '/../src/Views/header.php';

if (!isset($_SESSION['user_id'])) {
    // Redirect to register/login if not logged in
    echo "<script>window.location.href='/register.php';</script>";
    exit;
}
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 min-h-[60vh]">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg" data-aos="fade-up">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">User Profile</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and application status.</p>
            </div>
            <a href="/logout.php" class="text-sm text-red-600 hover:text-red-800">Logout</a>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Full name</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <?= htmlspecialchars($_SESSION['user_name']) ?></dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Account Type</dt>
                    <dd
                        class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 uppercase font-bold text-terracotta-600">
                        <?= htmlspecialchars($_SESSION['account_type']) ?></dd>
                </div>
                <!-- More details can be fetched from DB -->
            </dl>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>