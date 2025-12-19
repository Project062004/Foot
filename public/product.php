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
$isLoggedIn = isset($_SESSION['user_id']);

?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumbs -->
    <nav class="flex mb-8 text-sm text-gray-500">
        <a href="/" class="hover:text-terracotta-500">Home</a>
        <span class="mx-2">/</span>
        <a href="/products.php" class="hover:text-terracotta-500">Products</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900"><?= htmlspecialchars($product['name']) ?></span>
    </nav>

    <div class="lg:grid lg:grid-cols-2 lg:gap-x-12">
        <!-- Image Gallery -->
        <div class="product-gallery" data-aos="fade-right">
            <div class="aspect-w-4 aspect-h-5 bg-gray-100 overflow-hidden rounded-lg mb-4">
                <img id="mainImage" src="<?= !empty($colors) ? $colors[0]['image_url'] : '' ?>"
                    class="w-full h-full object-cover object-center" alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
            <!-- Thumbnails -->
            <div class="grid grid-cols-4 gap-4">
                <?php foreach ($colors as $color): ?>
                    <button onclick="changeImage('<?= $color['image_url'] ?>')"
                        class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-lg overflow-hidden hover:opacity-75 focus:ring-2 focus:ring-terracotta-500">
                        <img src="<?= $color['image_url'] ?>" class="w-full h-full object-cover">
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Product Info -->
        <div class="mt-10 lg:mt-0" data-aos="fade-left">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 mb-2">
                <?= htmlspecialchars($product['name']) ?></h1>
            <p class="text-gray-500 mb-6"><?= htmlspecialchars($product['category']) ?></p>

            <p class="text-gray-700 mb-8 leading-relaxed"><?= htmlspecialchars($product['description']) ?></p>

            <!-- TABS -->
            <div class="border-b border-gray-200 mb-8">
                <nav class="-mb-px flex space-x-8">
                    <button onclick="switchTab('retail')" id="tab-retail"
                        class="border-terracotta-500 text-terracotta-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                        Retail
                    </button>
                    <?php if ($isWholesale): ?>
                        <button onclick="switchTab('wholesale')" id="tab-wholesale"
                            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                            Wholesale (B2B)
                        </button>
                        <button onclick="switchTab('sample')" id="tab-sample"
                            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                            Order Sample
                        </button>
                    <?php else: ?>
                        <div class="py-4 px-1 text-xs text-gray-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            Login as Wholesale to access B2B
                        </div>
                    <?php endif; ?>
                </nav>
            </div>

            <!-- RETAIL PANEL -->
            <div id="panel-retail" class="block">
                <div class="mb-6">
                    <p class="text-3xl font-bold text-gray-900">₹<?= number_format($product['price_retail']) ?></p>
                    <?php if ($product['discount_percent'] > 0): ?>
                        <p class="text-sm text-green-600 font-semibold"><?= $product['discount_percent'] ?>% OFF</p>
                    <?php endif; ?>
                </div>

                <!-- Retail Colors -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-4">Select Color</h3>
                    <div class="flex space-x-3">
                        <?php foreach ($colors as $color): ?>
                            <label
                                class="relative -m-0.5 p-0.5 rounded-full flex items-center justify-center focus:outline-none ring-gray-400 cursor-pointer">
                                <input type="radio" name="retail-color" value="<?= $color['id'] ?>" class="sr-only"
                                    aria-labelledby="color-choice-0-label">
                                <span
                                    class="h-8 w-8 bg-white border border-gray-200 rounded-full flex items-center justify-center p-0.5 hover:ring-2 ring-offset-1 ring-terracotta-500 transition-all"
                                    style="background-color: <?= $color['hex_code'] ?>;"
                                    title="<?= $color['color_name'] ?>"></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Retail Sizes -->
                <div class="mb-8 pl-1">
                    <h3 class="text-sm font-medium text-gray-900 mb-4">Select Size</h3>
                    <div class="grid grid-cols-5 gap-3 sm:grid-cols-8">
                        <?php foreach ([7, 8, 9, 10, 11] as $size): ?>
                            <label
                                class="group relative border rounded-md py-3 px-4 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 cursor-pointer bg-white shadow-sm text-gray-900">
                                <input type="radio" name="retail-size" value="<?= $size ?>" class="sr-only">
                                <span id="size-choice-<?= $size ?>-label"><?= $size ?></span>
                                <span
                                    class="pointer-events-none absolute -inset-px rounded-md ring-2 ring-transparent group-hover:ring-terracotta-400"
                                    aria-hidden="true"></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <button onclick="addToCartRoot('retail')"
                    class="w-full bg-terracotta-600 border border-transparent rounded-md py-4 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-terracotta-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-terracotta-500 transition-all shadow-lg hover:shadow-xl">
                    Add to Cart
                </button>
            </div>

            <!-- WHOLESALE PANEL (Logic Rich) -->
            <?php if ($isWholesale): ?>
                <div id="panel-wholesale" class="hidden">
                    <!-- Tiers Display -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
                        <h4 class="font-bold text-gray-900 text-sm mb-3">Wholesale Pricing Tiers</h4>
                        <div class="grid grid-cols-4 gap-2 text-center text-xs">
                            <?php foreach ($tiers as $tier): ?>
                                <div class="bg-white p-2 rounded shadow-sm border border-gray-100">
                                    <div class="font-bold text-terracotta-600"><?= $tier['min_pairs'] ?>+ Pairs</div>
                                    <div class="text-gray-900">₹<?= $tier['price_per_pair'] ?></div>
                                    <div class="text-gray-400 text-xxs"><?= $tier['delivery_days'] ?> Days</div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Step 1: Quantity -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Quantity (Pairs)</label>
                        <select id="ws-qty"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-terracotta-500 focus:border-terracotta-500 text-sm py-3"
                            onchange="calculateWholesale()">
                            <option value="">Select Quantity</option>
                            <option value="60">60 Pairs</option>
                            <option value="120">120 Pairs</option>
                            <option value="180">180 Pairs</option>
                            <option value="240">240 Pairs</option>
                        </select>
                    </div>

                    <!-- Step 2: Multi-Color Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Colors (Multi-Select)</label>
                        <div class="grid grid-cols-2 gap-3" id="ws-colors-container">
                            <?php foreach ($colors as $color): ?>
                                <div class="relative flex items-center p-3 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 cursor-pointer"
                                    onclick="toggleColor(this, '<?= $color['id'] ?>', '<?= $color['color_name'] ?>')">
                                    <div class="h-6 w-6 rounded-full border border-gray-200 mr-3"
                                        style="background-color: <?= $color['hex_code'] ?>;"></div>
                                    <span class="text-sm font-medium text-gray-900"><?= $color['color_name'] ?></span>
                                    <input type="checkbox" value="<?= $color['id'] ?>" class="hidden ws-color-check">
                                    <div class="absolute top-2 right-2 hidden check-icon text-terracotta-600">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <p id="ws-color-error" class="text-red-500 text-xs mt-2 hidden"></p>
                    </div>

                    <!-- Step 3: Matrix Output -->
                    <div id="ws-matrix"
                        class="hidden mb-6 bg-white border border-gray-200 rounded-lg overflow-hidden animate-fade-in shadow-sm">
                        <div class="bg-gray-100 px-4 py-2 border-b border-gray-200">
                            <h4 class="font-bold text-gray-800 text-sm">Order Distribution</h4>
                        </div>
                        <div class="p-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Color
                                        </th>
                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Total
                                        </th>
                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Size 7
                                        </th>
                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Size 8
                                        </th>
                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Size 9
                                        </th>
                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Size
                                            10</th>
                                        <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Size
                                            11</th>
                                    </tr>
                                </thead>
                                <tbody id="ws-matrix-body" class="bg-white divide-y divide-gray-200">
                                    <!-- Generated via JS -->
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 bg-yellow-50 text-xs text-yellow-800 border-t border-yellow-100">
                            * Distribution is automatically calculated to be equal across 5 sizes.
                        </div>
                    </div>

                    <!-- Step 4: Packaging -->
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Packaging Preference</label>
                        <select id="ws-packaging"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-terracotta-500 focus:border-terracotta-500 text-sm py-3">
                            <option value="polybag">Polybag (Free)</option>
                            <option value="box">Box Packaging (+₹10/pair)</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-terracotta-50 rounded-lg mb-4">
                        <span class="text-sm font-medium text-terracotta-800">Total Calculation</span>
                        <span class="text-xl font-bold text-terracotta-700" id="ws-total-price">₹0</span>
                    </div>

                    <button onclick="addToCartRoot('wholesale')" id="ws-add-btn"
                        class="w-full bg-gray-900 border border-transparent rounded-md py-4 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-gray-800 focus:outline-none transition-all shadow-lg opacity-50 cursor-not-allowed"
                        disabled>
                        Add Wholesale Order
                    </button>
                </div>

                <!-- SAMPLE PANEL -->
                <div id="panel-sample" class="hidden">
                    <div class="p-6 bg-blue-50 rounded-lg mb-6 border border-blue-100">
                        <h3 class="text-blue-900 font-bold mb-2">Sample Request</h3>
                        <p class="text-blue-700 text-sm">Order a single pair to verify quality. Discounted rate applied.</p>
                    </div>

                    <!-- Reuse logic for single selection but label strictly sample -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Color</label>
                        <select id="sample-color" class="block w-full border-gray-300 rounded-md shadow-sm py-2">
                            <?php foreach ($colors as $color): ?>
                                <option value="<?= $color['id'] ?>"><?= $color['color_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Size</label>
                        <select id="sample-size" class="block w-full border-gray-300 rounded-md shadow-sm py-2">
                            <?php foreach ([7, 8, 9, 10, 11] as $size): ?>
                                <option value="<?= $size ?>"><?= $size ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button onclick="addToCartRoot('sample')"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded transition-all shadow">
                        Request Sample (₹<?= number_format($product['price_retail'] * 0.8) ?>)
                    </button>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
    const WHOLESALE_TIERS = <?= json_encode($tiers) ?>;
    const PRODUCT_ID = <?= $id ?>;

    // UI Logic
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }

    function switchTab(tab) {
        ['retail', 'wholesale', 'sample'].forEach(t => {
            const el = document.getElementById('panel-' + t);
            if (el) {
                if (t === tab) el.classList.remove('hidden');
                else el.classList.add('hidden');
            }
            const btn = document.getElementById('tab-' + t);
            if (btn) {
                if (t === tab) {
                    btn.classList.add('border-terracotta-500', 'text-terracotta-600');
                    btn.classList.remove('border-transparent', 'text-gray-500');
                } else {
                    btn.classList.remove('border-terracotta-500', 'text-terracotta-600');
                    btn.classList.add('border-transparent', 'text-gray-500');
                }
            }
        });
    }

    // Wholesale Logic
    let selectedColors = [];

    function toggleColor(el, id, name) {
        const checkbox = el.querySelector('input');
        const icon = el.querySelector('.check-icon');

        if (selectedColors.some(c => c.id === id)) {
            selectedColors = selectedColors.filter(c => c.id !== id);
            el.classList.remove('ring-2', 'ring-terracotta-500', 'bg-terracotta-50');
            icon.classList.add('hidden');
        } else {
            selectedColors.push({ id, name });
            el.classList.add('ring-2', 'ring-terracotta-500', 'bg-terracotta-50');
            icon.classList.remove('hidden');
        }
        calculateWholesale();
    }

    function calculateWholesale() {
        const qty = parseInt(document.getElementById('ws-qty').value) || 0;
        const matrixEl = document.getElementById('ws-matrix');
        const errorEl = document.getElementById('ws-color-error');
        const btn = document.getElementById('ws-add-btn');
        const priceEl = document.getElementById('ws-total-price');

        if (qty === 0 || selectedColors.length === 0) {
            matrixEl.classList.add('hidden');
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            priceEl.innerText = '₹0';
            return;
        }

        // Logic Check 1: Divisible by colors
        const pairsPerColor = qty / selectedColors.length;
        if (qty % selectedColors.length !== 0) {
            errorEl.innerText = `Total quantity (${qty}) must be divisible by number of selected colors (${selectedColors.length}).`;
            errorEl.classList.remove('hidden');
            matrixEl.classList.add('hidden');
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }

        // Logic Check 2: Divisible by 5 sizes
        const perSize = pairsPerColor / 5;
        if (pairsPerColor % 5 !== 0) {
            errorEl.innerText = `Pairs per color (${pairsPerColor}) must be divisible by 5 sizes. Increase total quantity or adjust colors.`;
            errorEl.classList.remove('hidden');
            matrixEl.classList.add('hidden');
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }

        // Valid
        errorEl.classList.add('hidden');
        matrixEl.classList.remove('hidden');
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');

        // Draw Matrix
        const tbody = document.getElementById('ws-matrix-body');
        tbody.innerHTML = '';

        selectedColors.forEach(color => {
            const row = `
                <tr>
                    <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900">${color.name}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 text-center">${pairsPerColor}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 text-center">${perSize}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 text-center">${perSize}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 text-center">${perSize}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 text-center">${perSize}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 text-center">${perSize}</td>
                </tr>
            `;
            tbody.innerHTML += row;
        });

        // Price Calc
        // Find tier
        let price = 0;
        // WHOLESALE_TIERS is sorted ASC
        // We find the highest tier that is <= qty
        let tierPrice = 0;
        for (let t of WHOLESALE_TIERS) {
            if (qty >= t.min_pairs) {
                tierPrice = parseFloat(t.price_per_pair);
            }
        }

        // Packaging
        const packaging = document.getElementById('ws-packaging').value;
        const packagingCost = (packaging === 'box') ? 10 : 0;

        const total = qty * (tierPrice + packagingCost);
        priceEl.innerText = '₹' + total.toLocaleString('en-IN') + ` (@ ₹${tierPrice}/pair)`;
    }

    // Add Event Listener to Packaging to update price
    document.getElementById('ws-packaging')?.addEventListener('change', calculateWholesale);


    function addToCartRoot(type) {
        let payload = {
            product_id: PRODUCT_ID,
            type: type
        };

        if (type === 'retail') {
            const color = document.querySelector('input[name="retail-color"]:checked')?.value;
            const size = document.querySelector('input[name="retail-size"]:checked')?.value;
            if (!color || !size) { alert('Please select color and size'); return; }
            payload.color_id = color;
            payload.size = size;
            payload.quantity = 1;

        } else if (type === 'wholesale') {
            const qty = document.getElementById('ws-qty').value;
            const packaging = document.getElementById('ws-packaging').value;
            if (!qty || selectedColors.length === 0) return;

            payload.total_quantity = qty;
            payload.colors = selectedColors.map(c => c.id);
            payload.packaging = packaging;

            // Re-calculate split for backend verification
            // The backend should trust validation but re-verify

        } else if (type === 'sample') {
            payload.color_id = document.getElementById('sample-color').value;
            payload.size = document.getElementById('sample-size').value;
            payload.quantity = 1;
        }

        // Send to API
        fetch('/api/cart.php', {
            method: 'POST',
            body: JSON.stringify(payload),
            headers: { 'Content-Type': 'application/json' }
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update badge
                    // document.querySelector('.badge').innerText ..
                    alert('Added to Cart!');
                    window.location.href = '/cart.php';
                } else {
                    alert(data.error || 'Failed to add');
                }
            })
            .catch(err => alert('Error adding to cart'));
    }

</script>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>