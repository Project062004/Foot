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

        <!-- Header -->
        <div class="mb-12 text-center md:text-left">
            <h1 class="text-4xl font-serif font-bold text-gray-900 mb-2">Your Wishlist</h1>
            <p class="text-gray-500">Save your favorites for later.</p>
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
                <a href="<?= $basePath ?>/products.php"
                    class="inline-block bg-gray-900 text-white px-8 py-3 rounded-xl font-bold uppercase tracking-widest text-sm hover:bg-gray-800 transition-colors shadow-lg">
                    Browse Collection
                </a>
            </div>
        <?php else: ?>

            <!-- List View Container (Only Option) -->
            <div class="space-y-6">
                <?php foreach ($wishlistProducts as $product): ?>
                    <div
                        class="group bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 flex flex-col sm:flex-row">
                        <!-- Image -->
                        <div
                            class="sm:w-64 h-64 sm:h-auto relative bg-gray-50 p-6 flex-shrink-0 flex items-center justify-center">
                            <a href="<?= $basePath ?>/product.php?id=<?= $product['id'] ?>" class="block w-full h-full">
                                <img src="<?= htmlspecialchars($product['main_image'] ?: 'https://via.placeholder.com/600x800') ?>"
                                    class="w-full h-full object-contain mix-blend-multiply transform group-hover:scale-105 transition-transform duration-500">
                            </a>
                        </div>

                        <!-- Details -->
                        <div class="p-6 sm:p-8 flex-1 flex flex-col justify-center">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">
                                        <?= htmlspecialchars($product['category']) ?>
                                    </div>
                                    <h3 class="text-2xl font-serif font-bold text-gray-900 mb-2">
                                        <a href="<?= $basePath ?>/product.php?id=<?= $product['id'] ?>"
                                            class="hover:text-terracotta-600 transition"><?= htmlspecialchars($product['name']) ?></a>
                                    </h3>
                                </div>
                                <button onclick="toggleWishlist(<?= $product['id'] ?>)"
                                    class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50"
                                    title="Remove from Wishlist">
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
                                <a href="<?= $basePath ?>/product.php?id=<?= $product['id'] ?>"
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
    if (typeof AOS !== 'undefined') {
        AOS.init();
    }
</script>

<?php require_once __DIR__ . '/../src/Views/footer.php'; ?>