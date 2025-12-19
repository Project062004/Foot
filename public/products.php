<?php
require_once __DIR__ . '/../src/Views/header.php';
require_once __DIR__ . '/../src/Config/Database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->connect();

// --- 1. Filter Logic ---
$category = $_GET['category'] ?? 'All';
$sort = $_GET['sort'] ?? 'newest';
$search = $_GET['q'] ?? '';
$minPrice = isset($_GET['min_price']) ? (int) $_GET['min_price'] : 0;
$maxPrice = isset($_GET['max_price']) ? (int) $_GET['max_price'] : 10000;

// Base Query
$sql = "SELECT p.*, 
        (SELECT image_url FROM product_colors pc WHERE pc.product_id = p.id LIMIT 1) as main_image,
        (SELECT hex_code FROM product_colors pc WHERE pc.product_id = p.id LIMIT 1) as main_color
        FROM products p WHERE 1=1";

$params = [];

// Apply Filters
if ($category !== 'All') {
    $sql .= " AND category = :cat";
    $params['cat'] = $category;
}

if ($search) {
    $sql .= " AND (name LIKE :search OR description LIKE :search)";
    $params['search'] = "%$search%";
}

if ($minPrice > 0) {
    $sql .= " AND price_retail >= :min_price";
    $params['min_price'] = $minPrice;
}

if ($maxPrice < 10000) {
    $sql .= " AND price_retail <= :max_price";
    $params['max_price'] = $maxPrice;
}

// Apply Sorting
switch ($sort) {
    case 'price_low':
        $sql .= " ORDER BY price_retail ASC";
        break;
    case 'price_high':
        $sql .= " ORDER BY price_retail DESC";
        break;
    case 'name_asc':
        $sql .= " ORDER BY name ASC";
        break;
    default: // newest
        $sql .= " ORDER BY created_at DESC";
        break;
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Fetch Categories
$catStmt = $conn->query("SELECT DISTINCT category FROM products ORDER BY category ASC");
$dbCategories = $catStmt->fetchAll(PDO::FETCH_COLUMN);

?>

<!-- Main Content Wrapper -->
<div class="bg-gray-50 min-h-screen pb-20">

    <!-- Hero / Page Title -->
    <div class="relative bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-gray-900 mb-4 animate-fade-in">
                <?= $category === 'All' ? 'Our Collection' : htmlspecialchars($category) ?>
            </h1>
            <p class="text-gray-500 text-lg max-w-2xl font-light">
                Discover our curated range of premium footwear, handcrafted for the modern lifestyle.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Mobile Filter Button & Search -->
        <div class="lg:hidden flex flex-col gap-4 mb-8">
            <form action="" method="GET" class="relative w-full">
                <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Search..."
                    class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-terracotta-500">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </form>
            <button onclick="document.getElementById('mobileFilters').classList.remove('translate-x-full')"
                class="flex items-center justify-center space-x-2 w-full bg-gray-900 text-white py-3 rounded-lg font-medium text-sm hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                <span>Filter & Sort</span>
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">

            <!-- Sidebar (Desktop) -->
            <div class="hidden lg:block w-64 flex-shrink-0 space-y-10">

                <!-- Search -->
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Search</h3>
                    <form action="" method="GET" class="relative">
                        <input type="text" name="q" value="<?= htmlspecialchars($search) ?>"
                            placeholder="Find your style..."
                            class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-md text-sm focus:outline-none focus:border-terracotta-500 transition-colors">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <?php if ($category !== 'All'): ?>
                            <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Categories -->
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Categories</h3>
                    <div class="space-y-2">
                        <a href="?category=All&sort=<?= $sort ?>"
                            class="flex items-center justify-between text-sm group cursor-pointer">
                            <span
                                class="<?= $category === 'All' ? 'font-bold text-terracotta-600' : 'text-gray-600 group-hover:text-gray-900' ?>">All
                                Products</span>
                        </a>
                        <?php foreach ($dbCategories as $cat): ?>
                            <a href="?category=<?= urlencode($cat) ?>&sort=<?= $sort ?>"
                                class="flex items-center justify-between text-sm group cursor-pointer">
                                <span
                                    class="<?= $category === $cat ? 'font-bold text-terracotta-600' : 'text-gray-600 group-hover:text-gray-900' ?>">
                                    <?= htmlspecialchars($cat) ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Sort -->
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Sort By</h3>
                    <form id="sortFormDesktop" class="space-y-2">
                        <?php
                        $sortOptions = [
                            'newest' => 'Newest Arrivals',
                            'price_low' => 'Price: Low to High',
                            'price_high' => 'Price: High to Low',
                            'name_asc' => 'Name: A to Z'
                        ];
                        foreach ($sortOptions as $key => $label): ?>
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="sort" value="<?= $key ?>" <?= $sort === $key ? 'checked' : '' ?>
                                    onchange="updateSort(this.value)"
                                    class="h-4 w-4 text-terracotta-600 border-gray-300 focus:ring-terracotta-500">
                                <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900"><?= $label ?></span>
                            </label>
                        <?php endforeach; ?>
                    </form>
                </div>

                <!-- Clear Filters -->
                <?php if ($category !== 'All' || $search || $sort !== 'newest'): ?>
                    <a href="/products.php"
                        class="block text-center text-xs font-bold text-terracotta-600 hover:text-terracotta-800 uppercase tracking-widest border-t pt-4 border-gray-200">
                        Clear All Filters
                    </a>
                <?php endif; ?>
            </div>


            <!-- Product Grid Area -->
            <div class="flex-1">
                <div class="flex items-center justify-between mb-6 pb-2 border-b border-gray-200">
                    <p class="text-sm text-gray-500 font-medium">Showing <?= count($products) ?> results</p>
                </div>

                <?php if (empty($products)): ?>
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                        <p class="text-gray-500 mt-2 max-w-sm">We couldn't find exactly what you're looking for. Try
                            adjusting your search or filters.</p>
                        <a href="/products.php"
                            class="mt-6 px-6 py-2 bg-gray-900 text-white text-sm font-medium rounded hover:bg-gray-800 transition-colors">View
                            All Products</a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-10 gap-x-6">
                        <?php foreach ($products as $product): ?>
                            <div class="group relative flex flex-col" data-aos="fade-up">
                                <!-- Image Wrapper -->
                                <div class="relative w-full aspect-[4/5] bg-gray-100 overflow-hidden rounded-sm mb-4">
                                    <a href="/product.php?id=<?= $product['id'] ?>" class="block w-full h-full">
                                        <img src="<?= htmlspecialchars($product['main_image'] ?: 'https://via.placeholder.com/600x800') ?>"
                                            class="w-full h-full object-cover object-center transform group-hover:scale-105 transition-transform duration-700 ease-out"
                                            loading="lazy">
                                    </a>

                                    <!-- Tags -->
                                    <div class="absolute top-3 left-3 flex flex-col gap-2">
                                        <?php if ($product['is_new']): ?>
                                            <span
                                                class="bg-white/90 backdrop-blur text-gray-900 text-[10px] font-bold px-2 py-1 uppercase tracking-widest shadow-sm">New</span>
                                        <?php endif; ?>
                                        <?php if ($product['discount_percent'] > 0): ?>
                                            <span
                                                class="bg-terracotta-600 text-white text-[10px] font-bold px-2 py-1 uppercase tracking-widest shadow-sm">
                                                -<?= $product['discount_percent'] ?>%
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Wishlist Button -->
                                    <button onclick="toggleWishlist(<?= $product['id'] ?>, this)"
                                        class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white/80 backdrop-blur flex items-center justify-center text-gray-400 hover:text-terracotta-600 hover:bg-white transition-all shadow-sm z-10">
                                        <svg class="w-4 h-4"
                                            fill="<?= in_array($product['id'], $_SESSION['wishlist'] ?? []) ? 'currentColor' : 'none' ?>"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                            </path>
                                        </svg>
                                    </button>

                                    <!-- Quick Action (Bottom Fade) -->
                                    <div
                                        class="absolute inset-x-0 bottom-0 p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none group-hover:pointer-events-auto">
                                        <a href="/product.php?id=<?= $product['id'] ?>"
                                            class="block w-full text-center bg-white/95 backdrop-blur text-gray-900 text-xs font-bold uppercase tracking-widest py-3 hover:bg-gray-900 hover:text-white transition-colors shadow-lg">
                                            View Details
                                        </a>
                                    </div>
                                </div>

                                <!-- Info -->
                                <div class="flex flex-col flex-1">
                                    <h3 class="text-sm font-medium text-gray-900 mb-1">
                                        <a href="/product.php?id=<?= $product['id'] ?>">
                                            <?= htmlspecialchars($product['name']) ?>
                                        </a>
                                    </h3>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-2 font-medium">
                                        <?= htmlspecialchars($product['category']) ?>
                                    </p>

                                    <div class="flex items-center space-x-2 mt-auto">
                                        <span
                                            class="text-sm font-bold text-gray-900">₹<?= number_format($product['price_retail']) ?></span>
                                        <?php if ($product['discount_percent'] > 0):
                                            $oldPrice = $product['price_retail'] * (1 + ($product['discount_percent'] / 100));
                                            ?>
                                            <span class="text-xs text-gray-400 line-through">₹<?= number_format($oldPrice) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Filters Drawer -->
<div id="mobileFilters"
    class="fixed inset-0 z-[60] transform translate-x-full transition-transform duration-300 lg:hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50"
        onclick="document.getElementById('mobileFilters').classList.add('translate-x-full')"></div>

    <!-- Drawer -->
    <div class="relative w-[300px] max-w-[80%] h-full bg-white ml-auto flex flex-col shadow-xl">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-serif font-bold text-gray-900">Filters & Sort</h2>
            <button onclick="document.getElementById('mobileFilters').classList.add('translate-x-full')"
                class="text-gray-400 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-5 space-y-8">
            <!-- Mobile Sort -->
            <div>
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-3">Sort By</h3>
                <div class="space-y-2">
                    <?php foreach ($sortOptions as $key => $label): ?>
                        <label class="flex items-center">
                            <input type="radio" name="mobile_sort" value="<?= $key ?>" <?= $sort === $key ? 'checked' : '' ?>
                                onchange="updateSort(this.value)"
                                class="h-4 w-4 text-terracotta-600 focus:ring-terracotta-500 border-gray-300">
                            <span class="ml-3 text-sm text-gray-600"><?= $label ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Mobile Categories -->
            <div>
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-3">Category</h3>
                <div class="space-y-2">
                    <a href="?category=All&sort=<?= $sort ?>"
                        class="block text-sm py-1 <?= $category === 'All' ? 'text-terracotta-600 font-bold' : 'text-gray-600' ?>">All
                        Products</a>
                    <?php foreach ($dbCategories as $cat): ?>
                        <a href="?category=<?= urlencode($cat) ?>&sort=<?= $sort ?>"
                            class="block text-sm py-1 <?= $category === $cat ? 'text-terracotta-600 font-bold' : 'text-gray-600' ?>"><?= htmlspecialchars($cat) ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="p-5 border-t border-gray-100">
            <a href="/products.php"
                class="block w-full py-3 bg-gray-100 text-gray-900 text-center text-sm font-bold uppercase rounded hover:bg-gray-200 transition-colors">Clear
                All</a>
        </div>
    </div>
</div>

<script>
    // Include AOS Init if not already global (Header usually has it)
    if (typeof AOS !== 'undefined') {
        AOS.init();
    }

    function updateSort(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', value);
        window.location.href = url.toString();
    }

    // Toggle Wishlist Logic
    function toggleWishlist(id, btn) {
        fetch('/api/wishlist.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'toggle', product_id: id })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Toggle Fill
                    const svg = btn.querySelector('svg');
                    if (data.status === 'added') {
                        svg.setAttribute('fill', 'currentColor');
                    } else {
                        svg.setAttribute('fill', 'none');
                    }

                    // Show condensed notification
                    showToast(data.status === 'added' ? 'Added to Wishlist' : 'Removed from Wishlist');
                } else {
                    showToast('Please login to use wishlist', 'error');
                }
            })
            .catch(err => console.error(err));
    }

    // Simple Toast Notification for feedback
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-5 left-1/2 transform -translate-x-1/2 px-6 py-3 rounded shadow-lg text-white text-sm font-medium z-50 transition-all duration-300 opacity-0 translate-y-4 ${type === 'error' ? 'bg-red-500' : 'bg-gray-900'}`;
        toast.innerText = message;
        document.body.appendChild(toast);

        // Animate In
        requestAnimationFrame(() => {
            toast.classList.remove('opacity-0', 'translate-y-4');
        });

        // Remove after 3s
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-4');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
</script>

<?php require_once __DIR__ . '/../src/Views/footer.php'; ?>