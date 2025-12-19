<?php
require_once __DIR__ . '/../src/Views/header.php';
?>

<!-- Hero Section -->
<section class="relative h-[85vh] bg-gray-900 flex items-center overflow-hidden">
    <!-- Slider Background (Placeholder for multiple images) -->
    <div class="absolute inset-0">
        <!-- Image 1 -->
        <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=2012&auto=format&fit=crop"
            class="w-full h-full object-cover opacity-60" alt="Hero Image">
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10" data-aos="fade-up">
        <span class="text-terracotta-500 font-bold tracking-widest uppercase text-sm mb-4 block">New Collection
            2025</span>
        <h1 class="text-5xl md:text-7xl font-bold text-white leading-tight mb-6">
            Sports Edition <br> Collection
        </h1>
        <p class="text-gray-300 text-lg md:text-xl max-w-xl mb-10 font-light">
            Engineered for performance, designed for elegance. Experience the perfect blend of comfort and style.
        </p>
        <div class="flex space-x-4">
            <a href="/products.php"
                class="bg-terracotta-500 hover:bg-terracotta-600 text-white px-8 py-4 rounded-none font-medium transition text-sm uppercase tracking-widest">
                Shop Now
            </a>
            <a href="/about.php"
                class="border border-white text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded-none font-medium transition text-sm uppercase tracking-widest">
                Explore
            </a>
        </div>
    </div>
</section>

<!-- Explore Our Collections (Redesigned) -->
<section class="py-20 bg-gray-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 font-serif mb-4" data-aos="fade-up">Explore Our
                Collections</h2>
            <p class="text-gray-500 text-lg max-w-2xl mx-auto font-light" data-aos="fade-up" data-aos-delay="100">
                From athletic performance to elegant evenings, discover footwear designed for every moment of your life.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            $collections = [
                [
                    'name' => 'Sports & Sneakers',
                    'sub' => 'Performance meets style',
                    'count' => '24 PRODUCTS',
                    'img' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=600&auto=format&fit=crop',
                    'bg' => 'bg-blue-100', // Mocking pastel blue
                    'link' => 'Sports'
                ],
                [
                    'name' => 'Sandals',
                    'sub' => 'Comfort for every occasion',
                    'count' => '18 PRODUCTS',
                    'img' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=600&auto=format&fit=crop', // Update with sandal image if avail
                    'bg' => 'bg-orange-100', // Mocking pastel peach
                    'link' => 'Women' // Example link
                ],
                [
                    'name' => 'Heels & Formal',
                    'sub' => 'Elegance redefined',
                    'count' => '15 PRODUCTS',
                    'img' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=600&auto=format&fit=crop', // Needs heel image
                    'bg' => 'bg-purple-100', // Mocking pastel purple
                    'link' => 'Formal'
                ],
                [
                    'name' => 'Flats & Casuals',
                    'sub' => 'Everyday essentials',
                    'count' => '20 PRODUCTS',
                    'img' => 'https://images.unsplash.com/photo-1535043934128-6a512064f085?q=80&w=600&auto=format&fit=crop',
                    'bg' => 'bg-green-100', // Mocking pastel green
                    'link' => 'Flats'
                ]
            ];

            // Fix images for variety
            $collections[1]['img'] = 'https://images.unsplash.com/photo-1603487742131-4160d6986ba3?q=80&w=600&auto=format&fit=crop'; // Sandal
            $collections[2]['img'] = 'https://images.unsplash.com/photo-1533867617858-e7b97e0605df?q=80&w=600&auto=format&fit=crop'; // Heels
            
            foreach ($collections as $col):
                ?>
                <div class="flex flex-col rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 group bg-white"
                    data-aos="fade-up">
                    <!-- Image Section (Top 65%) -->
                    <div class="relative h-80 overflow-hidden">
                        <img src="<?= $col['img'] ?>" alt="<?= $col['name'] ?>"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <!-- Count Badge -->
                        <div class="absolute bottom-4 left-4">
                            <span
                                class="bg-black/30 backdrop-blur-md text-white text-xs font-semibold px-3 py-1 uppercase tracking-wider rounded-sm border border-white/20">
                                <?= $col['count'] ?>
                            </span>
                        </div>
                    </div>

                    <!-- Footer Section (Bottom 35%) -->
                    <div class="<?= $col['bg'] ?> p-6 flex flex-col justify-between flex-1">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 font-serif mb-1"><?= $col['name'] ?></h3>
                            <p class="text-gray-600 text-sm mb-6 font-light"><?= $col['sub'] ?></p>
                        </div>

                        <a href="/products.php?category=<?= $col['link'] ?>"
                            class="inline-flex items-center justify-between w-full px-4 py-3 border border-gray-900/10 hover:bg-white/50 rounded transition-colors group-hover:border-gray-900/30 text-gray-800 text-sm font-medium uppercase tracking-wide">
                            Explore
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Trending Products (Glassmorphism Cards) -->
<section class="py-16 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-8" data-aos="fade-right">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Trending Now</h2>
                <p class="mt-1 text-gray-500">Hot picks from our premium collection</p>
            </div>
            <a href="/products.php"
                class="hidden sm:block text-terracotta-600 hover:text-terracotta-700 font-medium transition">View All
                &rarr;</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            // Fetch mock data if DB empty, else use DB
            require_once __DIR__ . '/../src/Config/Database.php';
            $db = new \App\Config\Database();
            $conn = $db->connect();
            // Fetch 3 trending products
            $tStmt = $conn->query("SELECT * FROM products LIMIT 3"); // Fallback simple query
            $trending = $tStmt->fetchAll();
            ?>
            <?php foreach ($trending as $product):
                // Fetch Image
                $imgStmt = $conn->prepare("SELECT image_url FROM product_colors WHERE product_id = ? LIMIT 1");
                $imgStmt->execute([$product['id']]);
                $imgUrl = $imgStmt->fetchColumn() ?: 'https://via.placeholder.com/400';
                ?>
                <!-- Collection Style Card for Product -->
                <div class="flex flex-col rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 group bg-white"
                    data-aos="fade-up">
                    <!-- Image Section (Top) -->
                    <div class="relative h-96 overflow-hidden bg-gray-100">
                        <img src="<?= $imgUrl ?>" alt="<?= $product['name'] ?>"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                        <!-- Badge -->
                        <div class="absolute bottom-4 left-4">
                            <span
                                class="bg-black/30 backdrop-blur-md text-white text-xs font-semibold px-3 py-1 uppercase tracking-wider rounded-sm border border-white/20">TRENDING</span>
                        </div>

                        <!-- Wishlist/Actions Floating -->
                        <div
                            class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-4 group-hover:translate-x-0">
                            <button onclick="toggleWishlist(<?= $product['id'] ?>)"
                                class="w-10 h-10 rounded-full bg-white text-gray-900 hover:text-red-500 flex items-center justify-center shadow-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Footer Section (Bottom) -->
                    <!-- Cycling colors for variety or sticking to one. Let's use blue-50 for trending to keep it distinct but clean -->
                    <div class="bg-blue-50/50 p-6 flex flex-col justify-between flex-1">
                        <div>
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-2xl font-bold text-gray-900 font-serif leading-tight">
                                    <?= htmlspecialchars($product['name']) ?></h3>
                                <span
                                    class="text-lg font-bold text-gray-900 whitespace-nowrap">₹<?= number_format($product['price_retail']) ?></span>
                            </div>
                            <p class="text-gray-600 text-sm mb-6 font-light line-clamp-2">
                                <?= htmlspecialchars($product['description']) ?></p>
                        </div>

                        <a href="/product.php?id=<?= $product['id'] ?>"
                            class="inline-flex items-center justify-between w-full px-4 py-3 border border-gray-900/10 hover:bg-white rounded-lg transition-all group-hover:border-gray-900/30 text-gray-900 text-sm font-bold uppercase tracking-wide bg-transparent">
                            Buy Now
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-8 text-center sm:hidden">
            <a href="/products.php" class="text-terracotta-600 font-medium hover:text-terracotta-700">View All Products
                &rarr;</a>
        </div>
    </div>
</section>

<!-- Global Scripts for Actions -->
<script>
    function toggleWishlist(id) {
        fetch('/api/wishlist.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'toggle', product_id: id })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(data.status === 'added' ? 'Added to Wishlist' : 'Removed from Wishlist');
                }
            });
    }

    function quickAddToCart(id) {
        fetch('/api/cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'add',
                product_id: id,
                type: 'retail', // Default to retail from quick add
                quantity: 1,
                color_id: null,
                size: 7
            })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Added to Cart!');
                    // Optional: Update Cart Counter logic here if we had a global listener
                } else {
                    alert('Please view product details to select Color/Size.');
                    window.location.href = '/product.php?id=' + id;
                }
            });
    }
</script>

<!-- Mini About Section -->
<section class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
            <div data-aos="fade-right">
                <span class="text-terracotta-500 font-bold tracking-widest uppercase text-xs mb-2 block">Our
                    Story</span>
                <h2 class="text-4xl font-bold text-gray-900 mb-6 font-serif">Crafting Elegance in Every Step</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    Since 2025, Wear Footwear has been at the forefront of combining athletic performance with
                    high-street fashion. Our commitment to quality ensures that every pair is a masterpiece of comfort
                    and durability.
                </p>
                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                    Whether you are a boutique retailer or a fashion-forward individual, our designs are curated to
                    elevate your journey.
                </p>
                <a href="/about.php"
                    class="text-terracotta-600 font-medium hover:text-terracotta-700 transition inline-flex items-center">
                    Read our full story <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
            <div class="mt-12 lg:mt-0 relative" data-aos="fade-left">
                <div class="absolute -top-4 -right-4 w-72 h-72 bg-terracotta-100 rounded-full opacity-50 blur-3xl">
                </div>
                <img src="https://images.unsplash.com/photo-1556906781-9a412961c28c?q=80&w=2070&auto=format&fit=crop"
                    class="relative rounded-lg shadow-2xl w-full object-cover h-[500px]" alt="Craftsmanship">
            </div>
        </div>
    </div>
</section>

<!-- Reviews Slider Section -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Customer Love</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">Trusted by over 500+ wholesale partners and thousands of happy
                customers.</p>
        </div>

        <div class="relative max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            <!-- Simple JS Slider -->
            <div id="reviews-slider" class="overflow-hidden relative min-h-[300px]">
                <!-- Slide 1 -->
                <div
                    class="review-slide absolute inset-0 transition-opacity duration-500 opacity-100 flex flex-col items-center justify-center text-center px-4">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200&auto=format&fit=crop"
                        class="w-20 h-20 rounded-full mb-6 border-4 border-white shadow-lg object-cover">
                    <p class="text-xl md:text-2xl text-gray-800 italic mb-6 leading-relaxed font-light">"The wholesale
                        ordering process is seamless. The matrix logic for sizes saved me hours of manual calculation.
                        Highly recommended for bulk buyers!"</p>
                    <h4 class="font-bold text-gray-900">Sarah Jenkins</h4>
                    <span class="text-terracotta-500 text-sm">Boutique Owner, Mumbai</span>
                </div>
                <!-- Slide 2 -->
                <div
                    class="review-slide absolute inset-0 transition-opacity duration-500 opacity-0 pointer-events-none flex flex-col items-center justify-center text-center px-4">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop"
                        class="w-20 h-20 rounded-full mb-6 border-4 border-white shadow-lg object-cover">
                    <p class="text-xl md:text-2xl text-gray-800 italic mb-6 leading-relaxed font-light">"Incredible
                        quality for the sports edition. My customers love the comfort and the design is top-notch."</p>
                    <h4 class="font-bold text-gray-900">Rahul Sharma</h4>
                    <span class="text-terracotta-500 text-sm">Retail Manager, Delhi</span>
                </div>
                <!-- Slide 3 -->
                <div
                    class="review-slide absolute inset-0 transition-opacity duration-500 opacity-0 pointer-events-none flex flex-col items-center justify-center text-center px-4">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=200&auto=format&fit=crop"
                        class="w-20 h-20 rounded-full mb-6 border-4 border-white shadow-lg object-cover">
                    <p class="text-xl md:text-2xl text-gray-800 italic mb-6 leading-relaxed font-light">"Fast delivery
                        and standard packaging is excellent. The wholesale tier pricing helps us maintain good margins."
                    </p>
                    <h4 class="font-bold text-gray-900">Priya Patel</h4>
                    <span class="text-terracotta-500 text-sm">Distributor, Gujarat</span>
                </div>
            </div>

            <!-- Controls -->
            <div class="flex justify-center mt-8 space-x-2">
                <button onclick="setSlide(0)"
                    class="w-3 h-3 rounded-full bg-terracotta-500 transition-all hover:scale-125 slide-dot"></button>
                <button onclick="setSlide(1)"
                    class="w-3 h-3 rounded-full bg-gray-300 transition-all hover:scale-125 slide-dot"></button>
                <button onclick="setSlide(2)"
                    class="w-3 h-3 rounded-full bg-gray-300 transition-all hover:scale-125 slide-dot"></button>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gray-900 relative overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1552346154-21d32810aba3?q=80&w=2070&auto=format&fit=crop"
            class="w-full h-full object-cover opacity-20" alt="Background">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="zoom-in">
        <h2 class="text-4xl text-white font-bold mb-6">Ready to Elevate Your Inventory?</h2>
        <p class="text-gray-300 text-lg mb-10 max-w-2xl mx-auto">Join our network of premium retailers. Get exclusive
            access to wholesale pricing, bulk discounts, and priority production.</p>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="/register.php?type=wholesale"
                class="bg-terracotta-500 hover:bg-terracotta-600 text-white px-8 py-4 rounded font-medium transition text-sm uppercase tracking-widest shadow-lg">Become
                a Partner</a>
            <a href="/contact.php"
                class="bg-transparent border border-white text-white hover:bg-white hover:text-gray-900 px-8 py-4 rounded font-medium transition text-sm uppercase tracking-widest">Contact
                Sales</a>
        </div>
    </div>
</section>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.review-slide');
    const dots = document.querySelectorAll('.slide-dot');

    function setSlide(index) {
        currentSlide = index;
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.remove('opacity-0', 'pointer-events-none');
                slide.classList.add('opacity-100');
            } else {
                slide.classList.add('opacity-0', 'pointer-events-none');
                slide.classList.remove('opacity-100');
            }
        });
        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.remove('bg-gray-300');
                dot.classList.add('bg-terracotta-500');
            } else {
                dot.classList.add('bg-gray-300');
                dot.classList.remove('bg-terracotta-500');
            }
        })
    }

    // Auto Play
    setInterval(() => {
        let next = (currentSlide + 1) % slides.length;
        setSlide(next);
    }, 5000);
</script>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>