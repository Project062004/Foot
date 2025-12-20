<?php
require_once __DIR__ . '/../src/Views/header.php';
require_once __DIR__ . '/../src/Config/Database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->connect();

$wishlistIds = $_SESSION['wishlist'] ?? [];
$wishlistProducts = [];

if (!empty($wishlistIds)) {
    // Sanitize IDs
    $ids = array_map('intval', $wishlistIds);
    $inQuery = implode(',', $ids);

    // Fetch Products with Main Image
    $sql = "SELECT p.*, 
            (SELECT image_url FROM product_colors pc WHERE pc.product_id = p.id LIMIT 1) as main_image 
            FROM products p WHERE id IN ($inQuery)";

    $stmt = $conn->query($sql);
    $wishlistProducts = $stmt->fetchAll();
}
?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header & Toggle -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-12">
            <div class="text-center md:text-left mb-6 md:mb-0">
                <h1 class="text-4xl font-serif font-bold text-gray-900 mb-2">Your Wishlist</h1>
                <p class="text-gray-500">Save your favorites for later.</p>
            </div>

            <div class="flex items-center bg-white rounded-lg p-1 shadow-sm border border-gray-100">
                <button onclick="setView('grid')" id="btn-grid"
                    class="p-2 rounded-md text-gray-900 bg-gray-100 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                </button>
                <button onclick="setView('list')" id="btn-list"
                    class="p-2 rounded-md text-gray-400 hover:text-gray-900 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <?php if (empty($wishlistProducts)): ?>
            <div class="text-center py-20 bg-white rounded-[2.5rem] shadow-sm">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Your wishlist is empty</h3>
                <p class="text-gray-500 mb-8">Start exploring our collection to find your perfect pair.</p>
                <a href="/products.php"
                    class="inline-block bg-gray-900 text-white px-8 py-3 rounded-xl font-bold uppercase tracking-widest text-sm hover:bg-gray-800 transition-colors shadow-lg">
                    Browse Collection
                </a>
            </div>
        <?php else: ?>

            <!-- Grid View Container -->
            <div id="view-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($wishlistProducts as $product): ?>
                    <div class="group block h-full">
                        <div
                            class="flex flex-col h-full bg-white rounded-[2rem] overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100">
                            <div class="header-card aspect-square relative p-6 bg-white flex items-center justify-center">
                                <a href="/product.php?id=<?= $product['id'] ?>" class="block w-full h-full">
                                    <img src="<?= htmlspecialchars($product['main_image'] ?: 'https://via.placeholder.com/600x800') ?>"
                                        class="w-full h-full object-contain mix-blend-multiply transform group-hover:scale-110 transition-transform duration-500">
                                </a>

                                <button onclick="toggleWishlist(<?= $product['id'] ?>)"
                                    class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/90 backdrop-blur flex items-center justify-center text-red-500 hover:bg-red-50 transition-all shadow-sm z-20"
                                    title="Remove">
                                    <svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button>

                                <a href="/product.php?id=<?= $product['id'] ?>"
                                    class="absolute inset-x-0 bottom-5 mx-5 bg-gray-900 hover:bg-gray-800 text-white py-3 rounded-xl text-xs font-bold uppercase tracking-widest shadow-lg translate-y-[150%] group-hover:translate-y-0 transition-transform duration-300 text-center z-10">
                                    View Product
                                </a>
                            </div>

                            <div class="p-5 pt-0 mt-auto text-center border-t border-gray-50">
                                <h3 class="text-lg font-bold text-gray-900 font-serif mb-1 leading-tight truncate">
                                    <a href="/product.php?id=<?= $product['id'] ?>"
                                        class="hover:text-terracotta-600 transition"><?= htmlspecialchars($product['name']) ?></a>
                                </h3>
                                <!-- Short Desc -->
                                <p class="text-xs text-gray-500 mb-2 line-clamp-1">
                                    <?= substr(htmlspecialchars($product['description']), 0, 50) ?>...</p>

                                <div class="flex items-center justify-center space-x-2">
                                    <span
                                        class="text-lg font-bold text-gray-900">₹<?= number_format($product['price_retail']) ?></span>
                                    <?php if ($product['discount_percent'] > 0): ?>
                                        <span
                                            class="text-sm text-gray-400 line-through">₹<?= number_format($product['price_retail'] * (100 / (100 - $product['discount_percent']))) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- List View Container -->
            <div id="view-list" class="hidden space-y-6">
                <?php foreach ($wishlistProducts as $product): ?>
                    <div
                        class="group bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 flex flex-col sm:flex-row">
                        <!-- Image -->
                        <div
                            class="sm:w-64 h-64 sm:h-auto relative bg-gray-50 p-6 flex-shrink-0 flex items-center justify-center">
                            <a href="/product.php?id=<?= $product['id'] ?>" class="block w-full h-full">
                                <img src="<?= htmlspecialchars($product['main_image'] ?: 'https://via.placeholder.com/600x800') ?>"
                                    class="w-full h-full object-contain mix-blend-multiply transform group-hover:scale-105 transition-transform duration-500">
                            </a>
                        </div>

                        <!-- Details -->
                        <div class="p-6 sm:p-8 flex-1 flex flex-col justify-center">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">
                                        <?= htmlspecialchars($product['category']) ?></div>
                                    <h3 class="text-2xl font-serif font-bold text-gray-900 mb-2">
                                        <a href="/product.php?id=<?= $product['id'] ?>"
                                            class="hover:text-terracotta-600 transition"><?= htmlspecialchars($product['name']) ?></a>
                                    </h3>
                                </div>
                                <button onclick="toggleWishlist(<?= $product['id'] ?>)"
                                    class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50">
                                    <svg class="w-6 h-6" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            <p class="text-gray-600 mb-6 line-clamp-2"><?= htmlspecialchars($product['description']) ?></p>

                            <div class="flex items-center justify-between mt-auto">
                                <div class="flex items-center space-x-3">
                                    <span
                                        class="text-2xl font-bold text-gray-900">₹<?= number_format($product['price_retail']) ?></span>
                                    <?php if ($product['discount_percent'] > 0): ?>
                                        <span
                                            class="text-base text-gray-400 line-through">₹<?= number_format($product['price_retail'] * (100 / (100 - $product['discount_percent']))) ?></span>
                                        <span
                                            class="text-xs font-bold text-terracotta-600 bg-terracotta-50 px-2 py-1 rounded"><?= $product['discount_percent'] ?>%
                                            OFF</span>
                                    <?php endif; ?>
                                </div>
                                <a href="/product.php?id=<?= $product['id'] ?>"
                                    class="bg-gray-900 hover:bg-gray-800 text-white px-8 py-3 rounded-xl font-bold uppercase tracking-widest text-sm shadow-md transition-all transform hover:-translate-y-0.5">
                                    View Product
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>
</div>

<script>
    function setView(view) {
        const gridView = document.getElementById('view-grid');
        const listView = document.getElementById('view-list');
        const btnGrid = document.getElementById('btn-grid');
        const btnList = document.getElementById('btn-list');

        if (view === 'grid') {
            gridView.classList.remove('hidden');
            listView.classList.add('hidden');

            btnGrid.classList.add('bg-gray-100', 'text-gray-900');
            btnGrid.classList.remove('text-gray-400');

            btnList.classList.remove('bg-gray-100', 'text-gray-900');
            btnList.classList.add('text-gray-400');
        } else {
            gridView.classList.add('hidden');
            listView.classList.remove('hidden');

            btnList.classList.add('bg-gray-100', 'text-gray-900');
            btnList.classList.remove('text-gray-400');

            btnGrid.classList.remove('bg-gray-100', 'text-gray-900');
            btnGrid.classList.add('text-gray-400');
        }
    }

    if (typeof AOS !== 'undefined') {
        AOS.init();
    }
</script>

<?php require_once __DIR__ . '/../src/Views/footer.php'; ?>