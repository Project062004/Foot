<?php
require_once __DIR__ . '/../src/Views/header.php';
require_once __DIR__ . '/../src/Config/Database.php';

// Database connection
$db = new \App\Config\Database();
$conn = $db->connect();

// Image Pool from User
$pimages = [
    'https://i.pinimg.com/1200x/cf/84/62/cf846211edde03312ecfc36dc89747c1.jpg',
    'https://i.pinimg.com/1200x/6d/ae/65/6dae65a3e10973731bf889f145bba4b9.jpg',
    'https://i.pinimg.com/1200x/e8/e0/c2/e8e0c2eeb4a01257d513346f5ef818c8.jpg',
    'https://i.pinimg.com/1200x/33/e8/64/33e864fd9a5dfc5afddea68dcb45bceb.jpg',
    'https://i.pinimg.com/736x/cd/1c/15/cd1c150002fbe12f955fa318932f2deb.jpg',
    'https://i.pinimg.com/1200x/65/a4/d7/65a4d7a7323c31ede79ff17974d0feb0.jpg',
    'https://i.pinimg.com/1200x/df/75/5b/df755b70f839864e965e595fc462f032.jpg',
    'https://i.pinimg.com/1200x/46/57/65/46576503a6b3749b4e86dfb86ed47a51.jpg',
    'https://i.pinimg.com/1200x/8f/33/47/8f3347d0c15ffe9b80e622faa0e8d730.jpg',
    'https://i.pinimg.com/1200x/db/3b/7e/db3b7e5846df257ae5b79578b73e53fb.jpg',
    'https://i.pinimg.com/736x/05/6b/62/056b6279a31e5a5aba3f1c1dfa160a19.jpg'
];
?>

<!-- Hero Section -->
<section id="hero-slider" class="relative h-[90vh] bg-gray-900 overflow-hidden">
    <!-- Slides Container -->
    <div class="relative w-full h-full">
        <!-- Slide 0: Video Ad -->
        <div
            class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100 flex items-center justify-center bg-black">
            <!-- Video Wrapper for Object-Cover-like fill -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <iframe id="hero-video-iframe"
                    src="https://www.youtube.com/embed/HbL-3vC_9aU?autoplay=1&mute=1&controls=0&loop=0&playlist=HbL-3vC_9aU&showinfo=0&rel=0&iv_load_policy=3&modestbranding=1&playsinline=1&enablejsapi=1"
                    class="absolute top-1/2 left-1/2 w-[300%] h-[300%] transform -translate-x-1/2 -translate-y-1/2 opacity-90"
                    style="min-width: 100%; min-height: 100%; width: 177.77vh; height: 56.25vw;" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 via-transparent to-transparent"></div>
            </div>
        </div>

        <!-- Slide 1 -->
        <div
            class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 pointer-events-none flex items-center justify-center">
            <div class="absolute inset-0">
                <img src="<?= $pimages[0] ?>"
                    class="w-full h-full object-cover opacity-60 transform scale-105 animate-slow-zoom"
                    alt="New Collection">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            </div>
            <div class="relative z-10 text-center max-w-4xl px-4">
                <span
                    class="text-terracotta-400 font-bold tracking-[0.2em] uppercase text-sm md:text-base mb-6 block animate-fade-in-up">
                    New Arrivals 2025
                </span>
                <h1
                    class="text-5xl md:text-7xl lg:text-8xl font-serif font-bold text-white leading-none mb-8 animate-fade-in-up delay-100">
                    Step Into <br> <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-terracotta-300 to-terracotta-600">Luxury</span>
                </h1>
                <p
                    class="text-gray-200 text-lg md:text-xl font-light mb-10 max-w-2xl mx-auto animate-fade-in-up delay-200">
                    Discover our latest collection of premium handcrafted footwear. Where comfort meets timeless
                    elegance.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up delay-300">
                    <a href="/products.php?sort=newest"
                        class="px-10 py-4 bg-terracotta-600 hover:bg-terracotta-700 text-white font-medium uppercase tracking-widest text-sm transition-all transform hover:scale-105 shadow-xl hover:shadow-terracotta-500/20">
                        Shop Collection
                    </a>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div
            class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 pointer-events-none flex items-center justify-center">
            <div class="absolute inset-0">
                <img src="<?= $pimages[1] ?>" class="w-full h-full object-cover opacity-60" alt="Sale">
                <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/50 to-transparent"></div>
            </div>
            <div class="relative z-10 text-left max-w-7xl w-full px-6 sm:px-12">
                <div class="max-w-2xl">
                    <span
                        class="inline-block py-1 px-3 border border-white/30 rounded-full text-white text-xs font-bold tracking-wider mb-6 backdrop-blur-sm">
                        LIMITED TIME OFFER
                    </span>
                    <h1 class="text-6xl md:text-8xl font-serif font-bold text-white leading-tight mb-6">
                        End of <br> Season Sale
                    </h1>
                    <div class="text-4xl md:text-5xl font-bold text-terracotta-500 mb-8">
                        Up to 50% OFF
                    </div>
                    <p class="text-gray-300 text-lg mb-10 font-light border-l-4 border-terracotta-500 pl-6">
                        Exclusive discounts on our best-selling sneakers and formals. <br>Don't miss out on these
                        premium styles.
                    </p>
                    <a href="/products.php?sort=price_low"
                        class="inline-flex items-center px-8 py-4 bg-white text-gray-900 hover:bg-gray-100 font-bold uppercase tracking-widest text-sm transition-colors">
                        Shop The Sale
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div
            class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 pointer-events-none flex items-center justify-center">
            <div class="absolute inset-0">
                <img src="<?= $pimages[2] ?>" class="w-full h-full object-cover opacity-70" alt="Adventure">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/20 to-black/90"></div>
            </div>
            <div class="relative z-10 text-center px-4 mt-auto mb-20 md:mb-32">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 uppercase tracking-tighter">
                    Built for the <span class="text-terracotta-500">Bold</span>
                </h1>
                <p class="text-xl text-gray-200 font-serif italic mb-8">
                    "Fashion that keeps up with your pace."
                </p>
                <div class="flex justify-center space-x-6">
                    <a href="/products.php?category=Sports"
                        class="text-white border-b-2 border-terracotta-500 pb-1 hover:text-terracotta-400 transition-colors text-lg">Shop
                        Sports</a>
                    <a href="/products.php?category=Casual"
                        class="text-white border-b-2 border-white pb-1 hover:text-gray-300 transition-colors text-lg">Shop
                        Casual</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Arrows -->
    <button onclick="changeHeroSlide('prev')"
        class="absolute top-1/2 left-4 md:left-8 transform -translate-y-1/2 w-12 h-12 border border-white/20 hover:bg-white hover:text-gray-900 text-white rounded-full flex items-center justify-center transition-all z-20">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
    <button onclick="changeHeroSlide('next')"
        class="absolute top-1/2 right-4 md:right-8 transform -translate-y-1/2 w-12 h-12 border border-white/20 hover:bg-white hover:text-gray-900 text-white rounded-full flex items-center justify-center transition-all z-20">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Indicators -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
        <button onclick="goToHeroSlide(0)"
            class="hero-dot w-3 h-3 rounded-full bg-terracotta-500 transition-all hover:bg-terracotta-400 ring-2 ring-transparent hover:ring-white"></button>
        <button onclick="goToHeroSlide(1)"
            class="hero-dot w-3 h-3 rounded-full bg-white/50 transition-all hover:bg-white ring-2 ring-transparent hover:ring-white"></button>
        <button onclick="goToHeroSlide(2)"
            class="hero-dot w-3 h-3 rounded-full bg-white/50 transition-all hover:bg-white ring-2 ring-transparent hover:ring-white"></button>
        <button onclick="goToHeroSlide(3)"
            class="hero-dot w-3 h-3 rounded-full bg-white/50 transition-all hover:bg-white ring-2 ring-transparent hover:ring-white"></button>
    </div>
</section>

<!-- Custom Styles & Scripts for Hero (inline to ensure they load) -->
<style>
    @keyframes slow-zoom {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.1);
        }
    }

    .animate-slow-zoom {
        animation: slow-zoom 20s infinite alternate linear;
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .delay-100 {
        animation-delay: 0.1s;
    }

    .delay-200 {
        animation-delay: 0.2s;
    }

    .delay-300 {
        animation-delay: 0.3s;
    }

    /* Hide scrollbar */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    // YouTube API Integration for Hero Slider
    var player;
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('hero-video-iframe', {
            events: {
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerStateChange(event) {
        // If playing, clear the interval (stop auto-slide)
        if (event.data == YT.PlayerState.PLAYING) {
            clearInterval(heroInterval);
        }
        // If ended, go to next slide
        if (event.data == YT.PlayerState.ENDED) {
            changeHeroSlide('next');
            // Allow auto-slide to resume for other slides
            resetHeroTimer();
        }
    }

    // Hero Slider Logic
    let currentHeroIndex = 0;
    const heroSlides = document.querySelectorAll('.hero-slide');
    const heroDots = document.querySelectorAll('.hero-dot');
    let heroInterval;

    function updateHeroClasses() {
        heroSlides.forEach((slide, i) => {
            if (i === currentHeroIndex) {
                slide.classList.remove('opacity-0', 'pointer-events-none');
                slide.classList.add('opacity-100', 'z-10');
                const animateEls = slide.querySelectorAll('.animate-fade-in-up');
                animateEls.forEach(el => {
                    el.style.animation = 'none';
                    el.offsetHeight;
                    el.style.animation = null;
                });

                // If we land on the video slide (0), try to play video
                if (i === 0 && player && typeof player.playVideo === 'function') {
                    player.playVideo();
                }
            } else {
                slide.classList.add('opacity-0', 'pointer-events-none');
                slide.classList.remove('opacity-100', 'z-10');

                // If leaving video slide, pause it
                if (i === 0 && player && typeof player.pauseVideo === 'function') {
                    player.pauseVideo();
                }
            }
        });
        heroDots.forEach((dot, i) => {
            if (i === currentHeroIndex) {
                dot.classList.remove('bg-white/50');
                dot.classList.add('bg-terracotta-500');
            } else {
                dot.classList.add('bg-white/50');
                dot.classList.remove('bg-terracotta-500');
            }
        });
    }

    function changeHeroSlide(dir) {
        if (dir === 'next') {
            currentHeroIndex = (currentHeroIndex + 1) % heroSlides.length;
        } else {
            currentHeroIndex = (currentHeroIndex - 1 + heroSlides.length) % heroSlides.length;
        }
        updateHeroClasses();
        resetHeroTimer();
    }

    function goToHeroSlide(index) {
        currentHeroIndex = index;
        updateHeroClasses();
        resetHeroTimer();
    }

    function resetHeroTimer() {
        clearInterval(heroInterval);
        // Do NOT auto-slide if we are on the video slide (index 0)
        // The YouTube API 'ENDED' event will handle the transition
        if (currentHeroIndex !== 0) {
            heroInterval = setInterval(() => changeHeroSlide('next'), 6000);
        }
    }

    // Start initial timer logic (will check index 0 and likely hold)
    resetHeroTimer();

    // Load YouTube API
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
</script>

<!-- 1. New Arrivals Section -->
<section class="py-20 bg-gray-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Centered Header with Navigation Below -->
        <div class="flex flex-col items-center text-center mb-12" data-aos="fade-down">
            <span class="text-terracotta-600 font-bold uppercase tracking-wider text-xs block mb-3">Fresh Drops</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 font-serif mb-6">New Arrivals</h2>

            <!-- Navigation Buttons Centered -->
            <div class="flex space-x-4">
                <button
                    class="swiper-button-prev-new w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-900 hover:text-white transition-all shadow-sm hover:shadow-lg bg-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="swiper-button-next-new w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-900 hover:text-white transition-all shadow-sm hover:shadow-lg bg-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Scrollable Container -->
        <div class="flex overflow-x-auto space-x-8 pb-10 scrollbar-hide snap-x snap-mandatory px-4 min-h-[300px]"
            id="new-arrivals-container">
            <?php
            // Fetch Newest
            $nStmt = $conn->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 8");
            $newArrivals = $nStmt->fetchAll();
            $ni = 0;
            foreach ($newArrivals as $product):
                $imgUrl = $pimages[($ni++ + 3) % count($pimages)];
                ?>
                <div class="min-w-[300px] md:min-w-[340px] snap-start flex-shrink-0 group">
                    <!-- Card Container with Text Inside -->
                    <a href="/product.php?id=<?= $product['id'] ?>"
                        class="block h-full bg-white rounded-[2rem] overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col">
                        <div class="relative h-[320px] p-2 bg-gray-50/50 flex items-center justify-center">
                            <img src="<?= $imgUrl ?>"
                                class="w-full h-full object-contain mix-blend-multiply transition-transform duration-700 group-hover:scale-110">

                            <span
                                class="absolute top-5 left-5 bg-white/95 backdrop-blur text-gray-900 text-[10px] font-bold px-3 py-1.5 uppercase tracking-widest rounded-full shadow-sm">NEW</span>

                            <!-- Wishlist -->
                            <button onclick="event.preventDefault(); toggleWishlist(<?= $product['id'] ?>, this)"
                                class="absolute top-5 right-5 w-10 h-10 rounded-full bg-white/90 backdrop-blur hover:bg-white flex items-center justify-center text-gray-400 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100 translate-x-3 group-hover:translate-x-0 shadow-sm hover:shadow-md z-10 border border-gray-100">
                                <svg class="w-5 h-5"
                                    fill="<?= in_array($product['id'], $_SESSION['wishlist'] ?? []) ? 'currentColor' : 'none' ?>"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-6 text-center mt-auto bg-white border-t border-gray-50">
                            <h3
                                class="text-xl font-bold text-gray-900 font-serif leading-tight mb-2 group-hover:text-terracotta-600 transition-colors">
                                <?= htmlspecialchars($product['name']) ?>
                            </h3>
                            <div class="flex items-center justify-center space-x-3">
                                <p class="text-xs text-gray-500 uppercase tracking-widest font-medium">
                                    <?= htmlspecialchars($product['category']) ?>
                                </p>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span
                                    class="text-base font-bold text-gray-900">₹<?= number_format($product['price_retail']) ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        document.querySelector('.swiper-button-next-new').addEventListener('click', () => {
            document.getElementById('new-arrivals-container').scrollBy({ left: 340, behavior: 'smooth' });
        });
        document.querySelector('.swiper-button-prev-new').addEventListener('click', () => {
            document.getElementById('new-arrivals-container').scrollBy({ left: -340, behavior: 'smooth' });
        });
    </script>
</section>

<!-- 2. Trending Section -->
<section class="py-20 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Centered Header with Navigation -->
        <div class="flex flex-col items-center text-center mb-12" data-aos="fade-down">
            <span class="text-terracotta-600 font-bold uppercase tracking-wider text-xs block mb-3">Most Loved</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 font-serif mb-6">Trending Now</h2>

            <div class="flex space-x-4">
                <button
                    class="swiper-button-prev-trending w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-900 hover:text-white transition-all shadow-sm hover:shadow-lg bg-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="swiper-button-next-trending w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-900 hover:text-white transition-all shadow-sm hover:shadow-lg bg-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Scrollable Container -->
        <div class="flex overflow-x-auto space-x-8 pb-10 scrollbar-hide snap-x snap-mandatory px-4 min-h-[300px]"
            id="trending-container">
            <?php
            // Fetch Trending
            $tStmt = $conn->query("SELECT * FROM products ORDER BY RAND() LIMIT 8");
            $trending = $tStmt->fetchAll();
            $ti = 0;
            foreach ($trending as $product):
                $imgUrl = $pimages[($ti++ + 6) % count($pimages)];
                ?>
                <div class="min-w-[300px] md:min-w-[340px] snap-start flex-shrink-0 group">
                    <!-- Card Container with Text Inside -->
                    <a href="/product.php?id=<?= $product['id'] ?>"
                        class="block h-full bg-white rounded-[2rem] overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col">
                        <div class="relative h-[320px] p-2 bg-white flex items-center justify-center">
                            <img src="<?= $imgUrl ?>"
                                class="w-full h-full object-contain mix-blend-multiply transition-transform duration-700 group-hover:scale-110">

                            <span
                                class="absolute top-5 left-5 bg-terracotta-500 text-white text-[10px] font-bold px-3 py-1.5 uppercase tracking-widest rounded-full shadow-sm">HOT</span>

                            <!-- Wishlist -->
                            <button onclick="event.preventDefault(); toggleWishlist(<?= $product['id'] ?>, this)"
                                class="absolute top-5 right-5 w-10 h-10 rounded-full bg-white/90 backdrop-blur hover:bg-white flex items-center justify-center text-gray-400 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100 translate-x-3 group-hover:translate-x-0 shadow-sm hover:shadow-md z-10 border border-gray-100">
                                <svg class="w-5 h-5"
                                    fill="<?= in_array($product['id'], $_SESSION['wishlist'] ?? []) ? 'currentColor' : 'none' ?>"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <div class="p-6 text-center mt-auto bg-white border-t border-gray-50">
                            <h3
                                class="text-xl font-bold text-gray-900 font-serif leading-tight mb-2 group-hover:text-terracotta-600 transition-colors">
                                <?= htmlspecialchars($product['name']) ?>
                            </h3>
                            <div class="flex items-center justify-center space-x-3">
                                <p class="text-xs text-gray-500 uppercase tracking-widest font-medium">
                                    <?= htmlspecialchars($product['category']) ?>
                                </p>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span
                                    class="text-base font-bold text-gray-900">₹<?= number_format($product['price_retail']) ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        document.querySelector('.swiper-button-next-trending').addEventListener('click', () => {
            document.getElementById('trending-container').scrollBy({ left: 340, behavior: 'smooth' });
        });
        document.querySelector('.swiper-button-prev-trending').addEventListener('click', () => {
            document.getElementById('trending-container').scrollBy({ left: -340, behavior: 'smooth' });
        });
    </script>
</section>

<!-- 3. Explore Our Collections -->
<section class="py-24 bg-gray-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="text-center mb-20">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 font-serif mb-4" data-aos="fade-up">Explore Our
                Collections</h2>
            <p class="text-gray-500 text-lg max-w-2xl mx-auto font-light" data-aos="fade-up" data-aos-delay="100">
                Curated styles for every occasion. Experience the perfect blend of comfort and luxury.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            $collections = [
                [
                    'name' => 'Sports & Sneakers',
                    'sub' => 'Performance meets style',
                    'count' => '24 PRODUCTS',
                    'img' => $pimages[4],
                    'bg' => 'bg-blue-50',
                    'btn_bg' => 'bg-blue-100/50',
                    'link' => 'Sports'
                ],
                [
                    'name' => 'Sandals',
                    'sub' => 'Comfort for every occasion',
                    'count' => '18 PRODUCTS',
                    'img' => $pimages[5],
                    'bg' => 'bg-orange-50',
                    'btn_bg' => 'bg-orange-100/50',
                    'link' => 'Women'
                ],
                [
                    'name' => 'Heels & Formal',
                    'sub' => 'Elegance redefined',
                    'count' => '15 PRODUCTS',
                    'img' => $pimages[6],
                    'bg' => 'bg-purple-50',
                    'btn_bg' => 'bg-purple-100/50',
                    'link' => 'Formal'
                ],
                [
                    'name' => 'Flats & Casuals',
                    'sub' => 'Everyday essentials',
                    'count' => '20 PRODUCTS',
                    'img' => $pimages[7],
                    'bg' => 'bg-green-50',
                    'btn_bg' => 'bg-green-100/50',
                    'link' => 'Flats'
                ]
            ];

            foreach ($collections as $col):
                ?>
                <!-- Soft Card -->
                <div class="flex flex-col rounded-[2.5rem] overflow-hidden bg-white shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-gray-200/80 transition-all duration-300 transform hover:-translate-y-2 group h-[500px]"
                    data-aos="fade-up">

                    <!-- Image Area (Top) -->
                    <div class="relative h-[60%] overflow-hidden">
                        <img src="<?= $col['img'] ?>" alt="<?= $col['name'] ?>"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute bottom-6 left-6">
                            <span
                                class="bg-gray-900/80 backdrop-blur-md text-white text-[10px] font-bold px-4 py-2 uppercase tracking-widest rounded-lg shadow-lg">
                                <?= $col['count'] ?>
                            </span>
                        </div>
                    </div>

                    <!-- Content Area (Bottom) -->
                    <div class="<?= $col['bg'] ?> p-8 flex flex-col justify-between flex-1 relative">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 font-serif mb-2 leading-tight"><?= $col['name'] ?>
                            </h3>
                            <p class="text-gray-600 text-sm font-medium tracking-wide"><?= $col['sub'] ?></p>
                        </div>
                        <a href="/products.php?category=<?= $col['link'] ?>"
                            class="flex items-center justify-between w-full px-6 py-4 <?= $col['btn_bg'] ?> hover:bg-white border border-gray-900/5 hover:border-gray-900/10 rounded-2xl transition-all duration-300 group-hover:shadow-md text-gray-900 text-xs font-bold uppercase tracking-[0.15em]">
                            Explore
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform text-gray-700"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

<!-- 4. Mini About Section -->
<section class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-20 items-center">
            <div data-aos="fade-right">
                <span class="text-terracotta-500 font-bold tracking-widest uppercase text-xs mb-3 block">Our
                    Story</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-8 font-serif leading-tight">Crafting Elegance
                    in Every Step</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-6 font-light">
                    Since 2025, Wear Footwear has been at the forefront of combining athletic performance with
                    high-street fashion. Our commitment to quality ensures that every pair is a masterpiece of comfort
                    and durability.
                </p>
                <a href="/about.php"
                    class="text-terracotta-600 font-bold hover:text-terracotta-700 transition inline-flex items-center text-sm uppercase tracking-widest">
                    Read our full story <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
            <div class="mt-16 lg:mt-0 relative" data-aos="fade-left">
                <div
                    class="relative rounded-[3rem] overflow-hidden shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-700">
                    <img src="<?= $pimages[8] ?>" class="w-full object-cover h-[500px]" alt="Craftsmanship">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. Reviews Cards Section (Slider Style) -->
<section class="py-20 bg-gray-50 border-t border-gray-100 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Centered Header with Navigation -->
        <div class="flex flex-col items-center text-center mb-12" data-aos="fade-down">
            <span class="text-terracotta-600 font-bold uppercase tracking-wider text-xs block mb-3">Testimonials</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 font-serif mb-6">Customer Love</h2>
            <div class="w-20 h-1.5 bg-terracotta-500 rounded-full mb-6"></div>

            <div class="flex space-x-4">
                <button
                    class="swiper-button-prev-reviews w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-900 hover:text-white transition-all shadow-sm hover:shadow-lg bg-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="swiper-button-next-reviews w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center hover:bg-gray-900 hover:text-white transition-all shadow-sm hover:shadow-lg bg-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex overflow-x-auto space-x-8 pb-10 scrollbar-hide px-4 min-h-[350px]" id="reviews-container">
            <!-- Review 1 -->
            <div class="w-[300px] md:w-[340px] snap-start flex-shrink-0 group">
                <div
                    class="block h-full bg-white rounded-[2rem] overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col">
                    <!-- Top Section: Profile (Reduced Height) -->
                    <div
                        class="relative h-[220px] bg-gray-50/50 flex flex-col items-center justify-center text-center p-6">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200&auto=format&fit=crop"
                            class="w-20 h-20 rounded-full object-cover mb-3 ring-4 ring-white shadow-sm">
                        <h4 class="font-bold text-gray-900 text-lg font-serif">Sarah Jenkins</h4>
                        <span class="text-terracotta-600 text-[10px] uppercase tracking-wide font-bold mt-1">Boutique
                            Owner</span>
                        <div class="flex items-center space-x-1 mt-3">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg class="w-3.5 h-3.5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <!-- Bottom Section: Review Text -->
                    <div
                        class="p-6 text-center mt-auto bg-white border-t border-gray-50 flex items-center justify-center flex-1">
                        <p class="text-gray-600 italic leading-relaxed font-light text-sm line-clamp-4">"The wholesale
                            ordering process is seamless. The matrix logic for sizes saved me hours of manual
                            calculation. Highly recommended!"</p>
                    </div>
                </div>
            </div>

            <!-- Review 2 -->
            <div class="w-[300px] md:w-[340px] snap-start flex-shrink-0 group">
                <div
                    class="block h-full bg-white rounded-[2rem] overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col">
                    <div class="relative h-[220px] bg-white flex flex-col items-center justify-center text-center p-6">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop"
                            class="w-20 h-20 rounded-full object-cover mb-3 ring-4 ring-gray-100 shadow-sm">
                        <h4 class="font-bold text-gray-900 text-lg font-serif">Rahul Sharma</h4>
                        <span class="text-terracotta-600 text-[10px] uppercase tracking-wide font-bold mt-1">Retail
                            Manager</span>
                        <div class="flex items-center space-x-1 mt-3">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg class="w-3.5 h-3.5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div
                        class="p-6 text-center mt-auto bg-white border-t border-gray-50 flex items-center justify-center flex-1">
                        <p class="text-gray-600 italic leading-relaxed font-light text-sm line-clamp-4">"Incredible
                            quality for the sports edition. My customers love the comfort and the design is top-notch.
                            Will definitely restock soon."</p>
                    </div>
                </div>
            </div>

            <!-- Review 3 -->
            <div class="w-[300px] md:w-[340px] snap-start flex-shrink-0 group">
                <div
                    class="block h-full bg-white rounded-[2rem] overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col">
                    <div
                        class="relative h-[220px] bg-gray-50/50 flex flex-col items-center justify-center text-center p-6">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=200&auto=format&fit=crop"
                            class="w-20 h-20 rounded-full object-cover mb-3 ring-4 ring-white shadow-sm">
                        <h4 class="font-bold text-gray-900 text-lg font-serif">Priya Patel</h4>
                        <span
                            class="text-terracotta-600 text-[10px] uppercase tracking-wide font-bold mt-1">Distributor</span>
                        <div class="flex items-center space-x-1 mt-3">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg class="w-3.5 h-3.5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div
                        class="p-6 text-center mt-auto bg-white border-t border-gray-50 flex items-center justify-center flex-1">
                        <p class="text-gray-600 italic leading-relaxed font-light text-sm line-clamp-4">"Fast delivery
                            and standard packaging is excellent. The wholesale tier pricing helps us maintain good
                            margins in a competitive market."</p>
                    </div>
                </div>
            </div>

            <!-- Review 4 -->
            <div class="w-[300px] md:w-[340px] snap-start flex-shrink-0 group">
                <div
                    class="block h-full bg-white rounded-[2rem] overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col">
                    <div class="relative h-[220px] bg-white flex flex-col items-center justify-center text-center p-6">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop"
                            class="w-20 h-20 rounded-full object-cover mb-3 ring-4 ring-gray-100 shadow-sm">
                        <h4 class="font-bold text-gray-900 text-lg font-serif">Ananya Gupta</h4>
                        <span class="text-terracotta-600 text-[10px] uppercase tracking-wide font-bold mt-1">Fashion
                            Blogger</span>
                        <div class="flex items-center space-x-1 mt-3">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg class="w-3.5 h-3.5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div
                        class="p-6 text-center mt-auto bg-white border-t border-gray-50 flex items-center justify-center flex-1">
                        <p class="text-gray-600 italic leading-relaxed font-light text-sm line-clamp-4">"Absolutely in
                            love with the heels collection. They are my go-to for every event now. Comfort and style at
                            its best."</p>
                    </div>
                </div>
            </div>

            <!-- Review 5 -->
            <div class="w-[300px] md:w-[340px] snap-start flex-shrink-0 group">
                <div
                    class="block h-full bg-white rounded-[2rem] overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 border border-gray-100 flex flex-col">
                    <div
                        class="relative h-[220px] bg-gray-50/50 flex flex-col items-center justify-center text-center p-6">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=200&auto=format&fit=crop"
                            class="w-20 h-20 rounded-full object-cover mb-3 ring-4 ring-white shadow-sm">
                        <h4 class="font-bold text-gray-900 text-lg font-serif">Mike Ross</h4>
                        <span class="text-terracotta-600 text-[10px] uppercase tracking-wide font-bold mt-1">Gym
                            Owner</span>
                        <div class="flex items-center space-x-1 mt-3">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <svg class="w-3.5 h-3.5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div
                        class="p-6 text-center mt-auto bg-white border-t border-gray-50 flex items-center justify-center flex-1">
                        <p class="text-gray-600 italic leading-relaxed font-light text-sm line-clamp-4">"The sports
                            shoes are incredibly durable. Perfect for heavy workouts and they look great too. highly
                            recommend!"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('.swiper-button-next-reviews').addEventListener('click', () => {
            document.getElementById('reviews-container').scrollBy({ left: 372, behavior: 'smooth' });
        });
        document.querySelector('.swiper-button-prev-reviews').addEventListener('click', () => {
            document.getElementById('reviews-container').scrollBy({ left: -372, behavior: 'smooth' });
        });
    </script>
</section>

<!-- Global Scripts for Actions -->
<script>
    // Inline script removed in favor of global footer script
    // Just in case, if toggleWishlist is missing, it will use the one from footer.php
</script>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>

<script>

</script>