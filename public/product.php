<?php
require_once __DIR__ . '/../src/Views/header.php';
require_once __DIR__ . '/../src/Config/Database.php';

use App\Config\Database;

$db = new Database();
$conn = $db->connect();

// Get Product ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;

// Fetch Product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $id]);
$product = $stmt->fetch();

if (!$product) {
    echo "<div class='text-center py-20'>Product not found</div>";
    require_once __DIR__ . '/../src/Views/footer.php';
    exit;
}

// Fetch Colors
$stmt = $conn->prepare("SELECT * FROM product_colors WHERE product_id = :id");
$stmt->execute(['id' => $id]);
$colors = $stmt->fetchAll();

// Fetch Wholesale Tiers
$tiersStmt = $conn->prepare("SELECT * FROM wholesale_tiers ORDER BY min_pairs ASC");
$tiersStmt->execute();
$tiers = $tiersStmt->fetchAll();

// User Logic
$isWholesale = (isset($_SESSION['account_type']) && $_SESSION['account_type'] === 'wholesale');

// Calculate Discount
$oldPrice = $product['price_retail'];
if ($product['discount_percent'] > 0) {
    $oldPrice = $product['price_retail'] * (100 / (100 - $product['discount_percent']));
}

// Fetch Specs
$specs = json_decode($product['specs'] ?? '[]', true);

// Fetch Reviews
$stmt = $conn->prepare("SELECT * FROM reviews WHERE product_id = :id ORDER BY created_at DESC");
$stmt->execute(['id' => $id]);
$reviews = $stmt->fetchAll();
$avgRating = 0;
if (count($reviews) > 0) {
    $sum = array_sum(array_column($reviews, 'rating'));
    $avgRating = round($sum / count($reviews), 1);
}

// Fetch Similar Products (Same Category)
$stmt = $conn->prepare("SELECT p.*, (SELECT image_url FROM product_colors pc WHERE pc.product_id = p.id LIMIT 1) as main_image FROM products p WHERE category = :cat AND id != :id LIMIT 10");
$stmt->execute(['cat' => $product['category'], 'id' => $id]);
$similarProducts = $stmt->fetchAll();

// Fetch Recommended (Bestsellers)
$stmt = $conn->prepare("SELECT p.*, (SELECT image_url FROM product_colors pc WHERE pc.product_id = p.id LIMIT 1) as main_image FROM products p WHERE is_bestseller = 1 AND id != :id LIMIT 10");
$stmt->execute(['id' => $id]);
$recommendedProducts = $stmt->fetchAll();
?>

<div class="bg-white min-h-screen pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Breadcrumbs -->
        <nav class="flex mb-8 text-xs font-medium uppercase tracking-widest text-gray-500">
            <a href="<?= $basePath ?>/"
                class="hover:text-gray-900 border-b border-transparent hover:border-gray-900 transition-colors">Home</a>
            <span class="mx-3 text-gray-300">|</span>
            <a href="<?= $basePath ?>/products.php"
                class="hover:text-gray-900 border-b border-transparent hover:border-gray-900 transition-colors"><?= htmlspecialchars($product['category']) ?></a>
            <span class="mx-3 text-gray-300">|</span>
            <span class="text-gray-900"><?= htmlspecialchars($product['name']) ?></span>
        </nav>

        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">

            <!-- Left: Gallery (Grid) - Col Span 7 -->
            <div class="lg:col-span-7 grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 lg:gap-6">
                <?php if (!empty($colors)): ?>
                    <?php foreach ($colors as $index => $color): ?>
                        <div onclick="openZoomModal(<?= $index ?>)"
                            class="cursor-pointer relative w-full aspect-[4/5] overflow-hidden rounded-[2rem] bg-gray-100 group shadow-sm hover:shadow-lg transition-shadow duration-300">
                            <img src="<?= $color['image_url'] ?>"
                                class="w-full h-full object-cover transform scale-100 group-hover:scale-105 transition-transform duration-1000 ease-out">
                            <?php if ($index === 0): ?>
                                <!-- Wishlist Absolute on First Image -->
                                <button onclick="event.stopPropagation(); toggleWishlist(<?= $product['id'] ?>)"
                                    class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/90 backdrop-blur flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-white transition-all shadow-md z-10">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div
                        class="col-span-2 w-full h-[600px] bg-gray-100 rounded-[2.5rem] flex items-center justify-center text-gray-300">
                        No Image Available
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right: Sticky Sidebar Details - Col Span 5 -->
            <div class="lg:col-span-5 mt-10 lg:mt-0 relative mb-10">
                <div class="sticky top-24">

                    <h1 class="text-3xl lg:text-4xl font-serif font-bold text-gray-900 mb-2 leading-tight">
                        <?= htmlspecialchars($product['name']) ?>
                    </h1>
                    <p
                        class="text-gray-500 text-sm mb-6 uppercase tracking-widest font-medium border-b border-gray-100 pb-6">
                        <?= htmlspecialchars($product['category']) ?> Collection
                    </p>

                    <!-- Rating Summary -->
                    <a href="#reviews" class="flex items-center space-x-2 mb-6 group cursor-pointer block w-fit">
                        <div class="flex text-yellow-500 text-sm">
                            <?php for ($i = 1; $i <= 5; $i++)
                                echo $i <= $avgRating ? '★' : '☆'; ?>
                        </div>
                        <span
                            class="text-sm text-gray-500 group-hover:text-gray-900 group-hover:underline transition-all">
                            <?= $avgRating ?> (<?= count($reviews) ?> Reviews)
                        </span>
                    </a>

                    <!-- Price Block -->
                    <div class="flex items-center space-x-4 mb-8">
                        <span
                            class="text-3xl font-bold text-gray-900">₹<?= number_format($product['price_retail']) ?></span>
                        <?php if ($product['discount_percent'] > 0): ?>
                            <span
                                class="text-xl text-gray-400 line-through font-light">₹<?= number_format($oldPrice) ?></span>
                            <span class="text-sm font-bold text-terracotta-600 bg-terracotta-50 px-2 py-1 rounded">
                                (<?= $product['discount_percent'] ?>% OFF)
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- TABS for Retail vs Wholesale -->
                    <div class="border-b border-gray-200 mb-8">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button onclick="switchTab('retail')" id="tab-retail"
                                class="border-gray-900 text-gray-900 whitespace-nowrap py-4 px-1 border-b-2 font-bold text-xs uppercase tracking-widest transition-colors">
                                Retail
                            </button>
                            <button onclick="switchTab('wholesale')" id="tab-wholesale"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-xs uppercase tracking-widest transition-colors">
                                Wholesale (B2B)
                            </button>
                            <button onclick="switchTab('sample')" id="tab-sample"
                                class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-xs uppercase tracking-widest transition-colors">
                                Sample
                            </button>
                        </nav>
                    </div>

                    <!-- RETAIL SELECTOR -->
                    <div id="panel-retail" class="space-y-8 animate-fade-in-up">
                        <!-- Color Swatches -->
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4">Select Color</h3>
                            <div class="flex flex-wrap gap-3">
                                <?php foreach ($colors as $color): ?>
                                    <label
                                        class="group relative p-0.5 rounded-full cursor-pointer focus:outline-none ring-2 ring-transparent hover:ring-gray-300 transition-all">
                                        <input type="radio" name="retail-color" value="<?= $color['id'] ?>"
                                            class="sr-only peer">
                                        <span
                                            class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center peer-checked:ring-2 peer-checked:ring-gray-900 peer-checked:ring-offset-2">
                                            <span class="w-8 h-8 rounded-full"
                                                style="background-color: <?= $color['hex_code'] ?>;"></span>
                                        </span>
                                        <span
                                            class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-xs text-gray-900 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap bg-white px-2 py-1 shadow-sm rounded border border-gray-100"><?= $color['color_name'] ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Size Selector -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Select Size (UK)
                                </h3>
                                <a href="#" class="text-xs text-terracotta-600 underline">Size Guide</a>
                            </div>
                            <div class="grid grid-cols-5 gap-3">
                                <?php foreach ([7, 8, 9, 10, 11] as $size): ?>
                                    <label
                                        class="group relative border border-gray-200 rounded-md py-3 px-4 flex items-center justify-center text-sm font-bold hover:border-gray-900 cursor-pointer bg-white text-gray-900 transition-all">
                                        <input type="radio" name="retail-size" value="<?= $size ?>" class="sr-only peer">
                                        <span class="peer-checked:text-white"></span>
                                        <div
                                            class="absolute inset-0 border-2 border-gray-900 rounded-md opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none">
                                        </div>
                                        <div
                                            class="absolute inset-0 bg-gray-900 opacity-0 peer-checked:opacity-100 transition-opacity rounded-[3px] m-[2px] -z-10">
                                        </div>
                                        <span class="relative z-10 peer-checked:text-white"><?= $size ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Add to Cart Button -->
                        <div class="pt-6 border-t border-gray-100">
                            <button onclick="addToCartRoot('retail')"
                                class="w-full bg-gray-900 hover:bg-black text-white py-5 rounded-xl font-bold uppercase tracking-widest text-sm shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">Add
                                to Bag</button>
                            <div class="mt-4 flex items-center justify-center space-x-2 text-xs text-gray-500">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Free Delivery on orders above ₹999</span>
                            </div>
                        </div>
                    </div>

                    <!-- WHOLESALE SELECTOR -->
                    <div id="panel-wholesale" class="hidden space-y-6 animate-fade-in-up">
                        <!-- Instructions -->
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <p class="text-sm text-blue-800">Placing a <strong>Bulk Order</strong>? Select colors and
                                distribute sizes.</p>
                        </div>

                        <!-- Pack Size Buttons -->
                        <div>
                            <label class="block text-xs font-bold text-gray-900 uppercase tracking-wide mb-2">Pack
                                Size</label>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <button onclick="setPackSize(60, this)"
                                    class="pack-btn px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium hover:border-gray-900 focus:outline-none transition-all">60
                                    pairs</button>
                                <button onclick="setPackSize(120, this)"
                                    class="pack-btn px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium hover:border-gray-900 focus:outline-none transition-all">120
                                    pairs</button>
                                <button onclick="setPackSize(180, this)"
                                    class="pack-btn px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium hover:border-gray-900 focus:outline-none transition-all">180
                                    pairs</button>
                                <button onclick="setPackSize(240, this)"
                                    class="pack-btn px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium hover:border-gray-900 focus:outline-none transition-all">240
                                    pairs</button>
                            </div>

                            <!-- Custom & Auto Split -->
                            <div class="flex gap-2">
                                <input type="number" id="ws-custom-qty" placeholder="Custom quantity"
                                    class="flex-1 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:ring-gray-900 focus:border-gray-900 outline-none"
                                    oninput="wsState.packSize = parseInt(this.value)||0; renderWholesaleMatrix()">
                                <button onclick="autoSplit()"
                                    class="bg-gray-100 text-gray-900 px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-200 transition-colors">Auto
                                    Split</button>
                            </div>
                        </div>

                        <!-- Color Selection -->
                        <div>
                            <label class="block text-xs font-bold text-gray-900 uppercase tracking-wide mb-2">Color
                                Mix</label>
                            <div class="space-y-2">
                                <?php foreach ($colors as $color): ?>
                                    <label
                                        class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 bg-white transition-all select-none"
                                        onclick="toggleColor(this, '<?= $color['id'] ?>', '<?= $color['color_name'] ?>')">
                                        <input type="checkbox" class="hidden ws-color-check" value="<?= $color['id'] ?>">
                                        <div class="h-6 w-6 rounded-full border border-gray-200 shrink-0"
                                            style="background-color: <?= $color['hex_code'] ?>;"></div>
                                        <span
                                            class="text-sm font-medium text-gray-900 flex-1"><?= $color['color_name'] ?></span>
                                        <div class="check-icon hidden text-green-600">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Matrix & Distribution (Dynamic) -->
                        <div>
                            <label class="block text-xs font-bold text-gray-900 uppercase tracking-wide mb-2">Size &
                                Color Distribution</label>
                            <div id="ws-matrix-container"
                                class="bg-gray-50 rounded-lg p-4 max-h-60 overflow-y-auto border border-gray-100">
                                <p class="text-sm text-gray-400 italic text-center py-4">Select a pack size and colors
                                    to start distributing.</p>
                            </div>
                        </div>

                        <!-- Summary Dashboard -->
                        <div class="pt-6 border-t border-gray-100 bg-gray-50 -mx-4 px-4 pb-4 -mb-4 rounded-b-lg">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <span
                                        class="block text-[10px] uppercase tracking-wider text-gray-500 font-bold">Pack
                                        Size</span>
                                    <span class="text-sm font-medium text-gray-900" id="ws-summary-pack">-</span>
                                </div>
                                <div>
                                    <span
                                        class="block text-[10px] uppercase tracking-wider text-gray-500 font-bold">Distributed</span>
                                    <span class="text-sm font-bold text-gray-900" id="ws-summary-dist">- / -</span>
                                </div>
                                <div>
                                    <span
                                        class="block text-[10px] uppercase tracking-wider text-gray-500 font-bold">Price
                                        per Pair</span>
                                    <span class="text-sm font-medium text-gray-900" id="ws-summary-price-pair">₹0</span>
                                </div>
                                <div>
                                    <span
                                        class="block text-[10px] uppercase tracking-wider text-gray-500 font-bold">Total
                                        Price</span>
                                    <span class="text-lg font-bold text-gray-900" id="ws-summary-total">₹0</span>
                                </div>
                            </div>
                            <button onclick="addToCartRoot('wholesale')" id="ws-add-btn"
                                class="w-full bg-gray-900 text-white py-4 rounded-xl font-bold uppercase tracking-widest text-sm opacity-50 cursor-not-allowed shadow-lg hover:shadow-xl transition-all"
                                disabled>Add Wholesale Order</button>
                        </div>
                    </div>
                    <div id="panel-sample" class="hidden space-y-6 animate-fade-in-up">
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                            <h3 class="font-bold text-yellow-800 text-sm">Sample Order</h3>
                            <p class="text-yellow-700 text-xs mt-1">Order 1 pair to test quality. 20% Discount applied.
                            </p>
                        </div>
                        <select id="sample-color" class="block w-full border-gray-200 rounded-lg py-3 px-4">
                            <option>Select Color</option>
                            <?php foreach ($colors as $c)
                                echo "<option value='{$c['id']}'>{$c['color_name']}</option>"; ?>
                        </select>
                        <select id="sample-size" class="block w-full border-gray-200 rounded-lg py-3 px-4">
                            <option>Select Size</option>
                            <?php foreach ([7, 8, 9, 10, 11] as $s)
                                echo "<option value='$s'>$s</option>"; ?>
                        </select>
                        <button onclick="addToCartRoot('sample')"
                            class="w-full bg-gray-900 text-white py-5 rounded-xl font-bold uppercase tracking-widest text-sm hover:shadow-xl hover:-translate-y-1 transition-all">Order
                            Sample</button>
                    </div>

                    <!-- Description & Specs -->
                    <div class="mt-10 border-t border-gray-200">
                        <!-- Description -->
                        <div class="py-4 border-b border-gray-100">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wide mb-2">Description</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                <?= nl2br(htmlspecialchars($product['description'])) ?>
                            </p>
                        </div>

                        <!-- Material & Care (New) -->
                        <div class="py-4 border-b border-gray-100">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wide mb-2">Material & Care
                            </h3>
                            <p class="text-xs text-gray-500 mb-2"><strong>Upper:</strong> Premium Synthetic Leather /
                                Microfiber</p>
                            <p class="text-xs text-gray-500 mb-2"><strong>Sole:</strong> Anti-slip Rubber Sole provided
                                cushioned comfort.</p>
                            <p class="text-xs text-gray-500"><strong>Care:</strong> Wipe with a clean, dry cloth to
                                remove dust. Use a branded shoe cleaner for stains.</p>
                        </div>

                        <!-- Dynamic Specs (Always Visible) -->
                        <div class="py-4 border-b border-gray-100">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wide mb-4">Product
                                Specifications</h3>
                            <dl class="divide-y divide-gray-100">
                                <?php if (!empty($specs)): ?>
                                    <?php foreach ($specs as $key => $val): ?>
                                        <div class="flex justify-between py-2">
                                            <dt class="text-xs text-gray-500 uppercase tracking-wider font-medium">
                                                <?= htmlspecialchars($key) ?>
                                            </dt>
                                            <dd class="text-sm font-bold text-gray-900"><?= htmlspecialchars($val) ?></dd>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="py-2 text-sm text-gray-400 italic">No additional specifications available.
                                    </div>
                                <?php endif; ?>
                            </dl>
                        </div>

                        <!-- Delivery (Expanded) -->
                        <div class="py-4 border-b border-gray-100">
                            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wide mb-2">Delivery & Returns
                            </h3>
                            <ul class="list-disc list-inside text-xs text-gray-500 space-y-1">
                                <li><strong>Dispatch:</strong> Within 24 Hours</li>
                                <li><strong>Delivery:</strong> 3-5 Business Days across India</li>
                                <li><strong>Returns:</strong> Easy 7-day return policy if unworn.</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Grid -->

    </div>

    <!-- Ratings & Reviews Section -->
    <div id="reviews" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-100">
        <h2 class="text-2xl font-serif font-bold text-gray-900 mb-8">Ratings & Reviews</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Rating Box -->
            <div class="bg-gray-50 rounded-2xl p-8 text-center h-fit">
                <div class="text-5xl font-bold text-gray-900 mb-2"><?= $avgRating ?></div>
                <div class="flex justify-center text-yellow-500 mb-2 text-xl">
                    <?php for ($i = 1; $i <= 5; $i++)
                        echo $i <= $avgRating ? '★' : '☆'; ?>
                </div>
                <p class="text-sm text-gray-500">Based on <?= count($reviews) ?> Reviews</p>
                <button
                    class="mt-6 w-full py-3 border border-gray-900 rounded-xl text-sm font-bold hover:bg-gray-900 hover:text-white transition-all">Write
                    a Review</button>
            </div>

            <!-- Reviews List -->
            <div class="md:col-span-2 space-y-8">
                <?php if (empty($reviews)): ?>
                    <p class="text-gray-500 italic">No reviews yet. Be the first to review!</p>
                <?php else: ?>
                    <?php foreach ($reviews as $rev): ?>
                        <div class="border-b border-gray-100 pb-8 last:border-0 last:pb-0">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-bold text-gray-900"><?= htmlspecialchars($rev['user_name']) ?></h4>
                                <span class="text-xs text-gray-400"><?= date('M d, Y', strtotime($rev['created_at'])) ?></span>
                            </div>
                            <div class="flex text-yellow-500 text-xs mb-3">
                                <?php for ($i = 1; $i <= 5; $i++)
                                    echo $i <= $rev['rating'] ? '★' : '☆'; ?>
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed"><?= htmlspecialchars($rev['comment']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Similar Products Slider (Smaller Cards) -->


    <!-- Similar Products Slider (New Card Design) -->
    <?php if (!empty($similarProducts)): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-100">
            <div class="flex justify-between items-end mb-8">
                <h2 class="text-2xl font-serif font-bold text-gray-900">Similar Products</h2>
                <a href="<?= $basePath ?>/products.php"
                    class="text-sm font-bold border-b border-gray-900 pb-0.5 hover:text-gray-600 hover:border-gray-600 transition-colors">View
                    All</a>
            </div>

            <div id="similar-products-container" class="flex space-x-6 overflow-x-auto pb-8 scrollbar-hide px-2">
                <?php foreach ($similarProducts as $sim): ?>
                    <div class="min-w-[220px] w-[220px] snap-start group h-full">
                        <a href="<?= $basePath ?>/product.php?id=<?= $sim['id'] ?>"
                            class="flex flex-col h-full bg-white rounded-[1.5rem] overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                            <div class="aspect-[5/6] bg-gray-50 relative flex items-center justify-center overflow-hidden">
                                <img src="<?= $sim['main_image'] ?>" alt="<?= htmlspecialchars($sim['name']) ?>"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500 ease-out">
                            </div>
                            <div class="p-4 mt-auto">
                                <h3
                                    class="text-base font-bold text-gray-900 mb-2 leading-tight group-hover:text-gray-600 transition-colors line-clamp-2">
                                    <?= htmlspecialchars($sim['name']) ?>
                                </h3>
                                <p class="text-sm text-gray-900 font-bold">₹<?= number_format($sim['price_retail']) ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Recommended Products Slider (New Card Design) -->
    <?php if (!empty($recommendedProducts)): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-gray-50 rounded-t-[3rem] mt-8">
            <div class="flex justify-between items-end mb-8">
                <h2 class="text-2xl font-serif font-bold text-gray-900">Recommended For You</h2>
            </div>

            <div id="recommended-products-container" class="flex space-x-6 overflow-x-auto pb-8 scrollbar-hide px-2">
                <?php foreach ($recommendedProducts as $rec): ?>
                    <div class="min-w-[220px] w-[220px] snap-start group h-full">
                        <a href="<?= $basePath ?>/product.php?id=<?= $rec['id'] ?>"
                            class="flex flex-col h-full bg-white rounded-[1.5rem] overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                            <div class="aspect-[5/6] bg-gray-50 relative flex items-center justify-center overflow-hidden">
                                <img src="<?= $rec['main_image'] ?>" alt="<?= htmlspecialchars($rec['name']) ?>"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500 ease-out">
                            </div>
                            <div class="p-4 mt-auto">
                                <h3
                                    class="text-base font-bold text-gray-900 mb-2 leading-tight group-hover:text-gray-600 transition-colors line-clamp-2">
                                    <?= htmlspecialchars($rec['name']) ?>
                                </h3>
                                <p class="text-sm text-gray-900 font-bold">₹<?= number_format($rec['price_retail']) ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- Full Screen Zoom Modal -->
<div id="zoomModal" class="fixed inset-0 z-[100] bg-white hidden transition-opacity duration-300 opacity-0">
    <div class="absolute inset-0 flex items-center justify-center h-full w-full">
        <button onclick="closeZoomModal()" class="absolute top-6 right-8 text-gray-500 hover:text-gray-900 z-50">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="relative w-full h-full flex flex-col md:flex-row">
            <div class="hidden md:flex flex-col w-24 h-full overflow-y-auto border-r border-gray-100 p-4 space-y-4">
                <?php foreach ($colors as $index => $color): ?>
                    <img src="<?= $color['image_url'] ?>" onclick="jumpToSlide(<?= $index ?>)"
                        class="w-full h-24 object-cover rounded cursor-pointer opacity-60 hover:opacity-100 transition-opacity modal-thumb"
                        data-index="<?= $index ?>">
                <?php endforeach; ?>
            </div>
            <div class="flex-1 relative bg-gray-50 flex items-center justify-center p-4 overflow-hidden"
                id="zoomContainer" onmousemove="handleZoomMove(event)" onmouseleave="resetZoom()">

                <button onclick="changeSlide(-1)"
                    class="absolute left-4 md:left-10 p-2 rounded-full bg-white/80 hover:bg-white text-gray-800 transition-colors z-20 shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>

                <img id="modalMainImg" src=""
                    class="max-h-full max-w-full object-contain transition-transform duration-100 ease-linear origin-center"
                    style="cursor: crosshair;">

                <button onclick="changeSlide(1)"
                    class="absolute right-4 md:right-10 p-2 rounded-full bg-white/80 hover:bg-white text-gray-800 transition-colors z-20 shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script>
    const WHOLESALE_TIERS = <?= json_encode($tiers) ?>;
    const PRODUCT_ID = <?= $id ?>;
    const GALLERY_IMAGES = <?= json_encode(array_column($colors, 'image_url')) ?>;
    let currentSlide = 0;

    // --- ZOOM LOGIC ---
    function openZoomModal(index) {
        currentSlide = index;
        updateModalImage();
        const modal = document.getElementById('zoomModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            document.body.style.overflow = 'hidden';
        }, 10);
    }

    function closeZoomModal() {
        const modal = document.getElementById('zoomModal');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            resetZoom();
        }, 300);
    }

    function changeSlide(step) {
        currentSlide += step;
        if (currentSlide < 0) currentSlide = GALLERY_IMAGES.length - 1;
        if (currentSlide >= GALLERY_IMAGES.length) currentSlide = 0;
        updateModalImage();
    }

    function jumpToSlide(index) {
        currentSlide = index;
        updateModalImage();
    }

    function updateModalImage() {
        const img = document.getElementById('modalMainImg');
        img.src = GALLERY_IMAGES[currentSlide];
        resetZoom();

        document.querySelectorAll('.modal-thumb').forEach(t => {
            t.classList.remove('opacity-100', 'ring-2', 'ring-gray-900');
            t.classList.add('opacity-60');
            if (parseInt(t.dataset.index) === currentSlide) {
                t.classList.remove('opacity-60');
                t.classList.add('opacity-100', 'ring-2', 'ring-gray-900');
            }
        });
    }

    function handleZoomMove(e) {
        const container = document.getElementById('zoomContainer');
        const img = document.getElementById('modalMainImg');

        // Calculate percentages
        const rect = container.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const xPercent = (x / rect.width) * 100;
        const yPercent = (y / rect.height) * 100;

        img.style.transformOrigin = `${xPercent}% ${yPercent}%`;
        img.style.transform = "scale(2)"; // 2x Zoom level
    }

    function resetZoom() {
        const img = document.getElementById('modalMainImg');
        if (img) {
            img.style.transform = "scale(1)";
            img.style.transformOrigin = "center center";
        }
    }

    document.addEventListener('keydown', function (e) {
        if (document.getElementById('zoomModal').classList.contains('hidden')) return;
        if (e.key === 'Escape') closeZoomModal();
        if (e.key === 'ArrowLeft') changeSlide(-1);
        if (e.key === 'ArrowRight') changeSlide(1);
    });

    // --- TAB LOGIC ---
    function switchTab(tab) {
        ['retail', 'wholesale', 'sample'].forEach(t => {
            document.getElementById('panel-' + t)?.classList.add('hidden');
            document.getElementById('tab-' + t)?.classList.remove('border-gray-900', 'text-gray-900', 'font-bold');
            document.getElementById('tab-' + t)?.classList.add('border-transparent', 'text-gray-500', 'font-medium');
        });
        document.getElementById('panel-' + tab)?.classList.remove('hidden');
        document.getElementById('tab-' + tab)?.classList.add('border-gray-900', 'text-gray-900', 'font-bold');
        document.getElementById('tab-' + tab)?.classList.remove('border-transparent', 'text-gray-500', 'font-medium');
    }

    // --- WHOLESALE LOGIC ---
    let wsState = {
        selectedColors: [],
        packSize: 0,
        manualQty: false,
        distribution: {} // Key format: "colorId_size" -> quantity
    };

    function toggleColor(el, id, name) {
        const checkIcon = el.querySelector('.check-icon');
        const exists = wsState.selectedColors.find(c => c.id == id);

        if (exists) {
            wsState.selectedColors = wsState.selectedColors.filter(c => c.id != id);
            el.classList.remove('ring-1', 'ring-gray-900', 'bg-gray-50');
            checkIcon.classList.add('hidden');
            // Clear distribution for this color
            for (const key in wsState.distribution) {
                if (key.startsWith(`${id}_`)) {
                    delete wsState.distribution[key];
                }
            }
        } else {
            wsState.selectedColors.push({ id, name });
            el.classList.add('ring-1', 'ring-gray-900', 'bg-gray-50');
            checkIcon.classList.remove('hidden');
        }
        renderWholesaleMatrix();
    }

    function setPackSize(size, btnEl) {
        wsState.packSize = size;
        wsState.manualQty = false;
        wsState.distribution = {}; // Clear distribution when pack size changes

        // Update UI buttons
        document.querySelectorAll('.pack-btn').forEach(b => {
            b.classList.remove('bg-gray-800', 'text-white', 'border-gray-800');
            b.classList.add('bg-white', 'text-gray-900', 'border-gray-200');
        });
        if (btnEl) {
            btnEl.classList.remove('bg-white', 'text-gray-900', 'border-gray-200');
            btnEl.classList.add('bg-gray-800', 'text-white', 'border-gray-800');
        }

        document.getElementById('ws-custom-qty').value = size;
        renderWholesaleMatrix();
    }

    function handleDistInput(el) {
        const key = `${el.dataset.color}_${el.dataset.size}`;
        wsState.distribution[key] = parseInt(el.value) || 0;
        updateWholesaleSummary();
    }

    function autoSplit() {
        const customVal = parseInt(document.getElementById('ws-custom-qty').value);
        if (!customVal || customVal <= 0) return;

        wsState.packSize = customVal;
        wsState.distribution = {}; // Clear existing distribution before auto-splitting

        // Find visible inputs
        const inputs = document.querySelectorAll('.ws-size-input');
        if (inputs.length === 0) return;

        const perInput = Math.floor(customVal / inputs.length);
        let remainder = customVal % inputs.length;

        inputs.forEach(inp => {
            let val = perInput;
            if (remainder > 0) { val++; remainder--; }

            // Update DOM and State
            inp.value = val;
            const key = `${inp.dataset.color}_${inp.dataset.size}`;
            wsState.distribution[key] = val;
        });

        updateWholesaleSummary();
    }

    function renderWholesaleMatrix() {
        const container = document.getElementById('ws-matrix-container');
        container.innerHTML = '';

        if (wsState.selectedColors.length === 0) {
            container.innerHTML = '<p class="text-sm text-gray-400 italic text-center py-8 bg-white rounded-lg border border-dashed border-gray-300">Select at least one color above to see distribution options.</p>';
            updateWholesaleSummary();
            return;
        }

        const sizes = [7, 8, 9, 10, 11];
        let html = '<div class="space-y-6">';

        wsState.selectedColors.forEach(color => {
            html += `
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                <!-- Color Header -->
                <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-900">${color.name}</span>
                    <span class="text-[10px] text-gray-500">5 Sizes Available</span>
                </div>
                <div class="p-2 space-y-1">`;

            sizes.forEach(size => {
                const key = `${color.id}_${size}`;
                const val = wsState.distribution[key] || 0;

                html += `
                <div class="flex items-center justify-between py-2 px-2 hover:bg-gray-50 rounded group transition-colors">
                    <div class="flex items-center space-x-3">
                         <div class="w-8 h-8 rounded bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-700">
                            ${size}
                         </div>
                         <div class="flex flex-col">
                            <span class="text-xs font-medium text-gray-900">UK Size ${size}</span>
                            <span class="text-[10px] text-gray-400">In Stock</span>
                         </div>
                    </div>
                    <div class="flex items-center">
                        <input type="number" min="0" placeholder="0"
                            class="ws-size-input w-20 border border-gray-200 rounded-md px-3 py-1.5 text-sm text-center font-medium focus:ring-1 focus:ring-gray-900 outline-none transition-shadow" 
                            data-color="${color.id}" data-size="${size}" value="${val}" oninput="handleDistInput(this)">
                    </div>
                </div>`;
            });

            html += `</div></div>`;
        });
        html += '</div>';
        container.innerHTML = html;

        // Auto-distribute if pack size is set and existing total is 0
        if (wsState.packSize > 0) {
            const inputs = document.querySelectorAll('.ws-size-input');
            let currentTotal = 0;
            inputs.forEach(i => currentTotal += parseInt(i.value) || 0);
            // Use logic: if total visible quantity is 0, then auto split.
            // But we just rendered from State. If state was empty (all 0), we split.
            if (currentTotal === 0) {
                autoSplit();
            } else {
                updateWholesaleSummary();
            }
        } else {
            updateWholesaleSummary();
        }
    }

    function updateWholesaleSummary() {
        // Calculate based on DOM inputs to specificially reflect what is VISIBLE and ACTIVE
        const inputs = document.querySelectorAll('.ws-size-input');
        let totalPairs = 0;
        inputs.forEach(inp => totalPairs += parseInt(inp.value) || 0);

        // Find Tier Price
        let tierPrice = 650; // Base wholesale price fallback
        let applicableTier = WHOLESALE_TIERS[0];

        for (let i = 0; i < WHOLESALE_TIERS.length; i++) {
            if (totalPairs >= parseInt(WHOLESALE_TIERS[i].min_pairs)) {
                applicableTier = WHOLESALE_TIERS[i];
            }
        }
        if (applicableTier) tierPrice = parseFloat(applicableTier.price_per_pair);

        const totalPrice = totalPairs * tierPrice;

        // Update DOM
        const target = wsState.packSize > 0 ? wsState.packSize : '-';
        const colorClass = totalPairs === wsState.packSize ? 'text-green-600' : (totalPairs > wsState.packSize ? 'text-red-500' : 'text-orange-500');

        document.getElementById('ws-summary-dist').innerHTML = `<span class="${colorClass}">${totalPairs}</span> / ${target}`;
        document.getElementById('ws-summary-pack').innerText = target + ' pairs';
        document.getElementById('ws-summary-price-pair').innerText = '₹' + tierPrice;
        document.getElementById('ws-summary-total').innerText = '₹' + totalPrice.toLocaleString('en-IN');

        const btn = document.getElementById('ws-add-btn');
        // Enable if total > 0
        if (totalPairs > 0) {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    function addToCartRoot(type) {
        let payload = { product_id: PRODUCT_ID, type: type };

        if (type === 'retail') {
            const color = document.querySelector('input[name="retail-color"]:checked')?.value;
            const size = document.querySelector('input[name="retail-size"]:checked')?.value;
            if (!color || !size) { alert('Please select color and size'); return; }
            payload.color_id = color;
            payload.size = size;
            payload.quantity = 1;

        } else if (type === 'wholesale') {
            // Collect distribution from STATE or DOM?
            // DOM is safer for "what you see is what you get"
            const inputs = document.querySelectorAll('.ws-size-input');
            let items = [];
            let totalQty = 0;

            inputs.forEach(inp => {
                const q = parseInt(inp.value) || 0;
                if (q > 0) {
                    items.push({
                        color_id: inp.dataset.color,
                        size: inp.dataset.size,
                        quantity: q
                    });
                    totalQty += q;
                }
            });

            if (totalQty === 0) return;

            payload.total_quantity = totalQty;
            payload.breakdown = items;
            payload.packaging = 'box'; // Default or add selector

        } else if (type === 'sample') {
            payload.color_id = document.getElementById('sample-color').value;
            payload.size = document.getElementById('sample-size').value;
            payload.quantity = 1;
        }

        fetch('<?= $basePath ?>/api/cart.php', {
            method: 'POST',
            body: JSON.stringify(payload),
            headers: { 'Content-Type': 'application/json' }
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast('Added to bag successfully');
                    if (typeof updateCartBadge === 'function') {
                        updateCartBadge(data.count);
                    }
                } else {
                    showToast(data.error, 'error');
                }
            })
            .catch(err => {
                showToast('Something went wrong', 'error');
            });
    }
</script>

<?php require_once __DIR__ . '/../src/Views/footer.php'; ?>