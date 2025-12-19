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
        <div class="text-center mb-12">
            <h1 class="text-4xl font-serif font-bold text-gray-900 mb-4">Your Wishlist</h1>
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
                <a href="/products.php"
                    class="inline-block bg-gray-900 text-white px-8 py-3 rounded-xl font-bold uppercase tracking-widest text-sm hover:bg-gray-800 transition-colors shadow-lg">
                    Browse Collection
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($wishlistProducts as $product): ?>
                    <div class="group block h-full">
                        <div
                            class="flex flex-col h-full bg-white rounded-[2rem] overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100">
                            <div class="header-card aspect-square relative p-6 bg-white flex items-center justify-center">
                                <a href="/product.php?id=<?= $product['id'] ?>" class="block w-full h-full">
                                    <img src="<?= htmlspecialchars($product['main_image'] ?: 'https://via.placeholder.com/600x800') ?>"
                                        class="w-full h-full object-contain mix-blend-multiply transform group-hover:scale-110 transition-transform duration-500">
                                </a>

                                <!-- Remove Button -->
                                <button onclick="toggleWishlist(<?= $product['id'] ?>)"
                                    class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/90 backdrop-blur flex items-center justify-center text-red-500 hover:bg-red-50 transition-all shadow-sm z-20"
                                    title="Remove">
                                    <svg class="w-5 h-5" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button>

                                <!-- View Button Overlay -->
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
                                <div class="flex items-center justify-center space-x-2">
                                    <span
                                        class="text-sm font-medium text-gray-500">₹<?= number_format($product['price_retail']) ?></span>
                                </div>
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