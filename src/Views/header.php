<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$wishlistCount = count($_SESSION['wishlist'] ?? []);
$cartCount = count($_SESSION['cart'] ?? []);

// Define base path dynamically
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$basePath = ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;
// Ensure no trailing slash unless it's empty (which it won't be if we check above correctly, but for safety)
$basePath = rtrim($basePath, '/\\');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeFoot | Premium Footwear</title>
    <!-- <link href="/assets/css/styles.css" rel="stylesheet"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        terracotta: {
                            50: '#fdf8f6',
                            100: '#fbeee9',
                            200: '#f8dccf',
                            300: '#f2c1ad',
                            400: '#ea9f82',
                            500: '#e07a5f',
                            600: '#d05e42',
                            700: '#ad4932',
                            800: '#8e3e2d',
                            900: '#733529',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        blob: "blob 7s infinite"
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        blob: {
                            "0%": { transform: "translate(0px, 0px) scale(1)" },
                            "33%": { transform: "translate(30px, -50px) scale(1.1)" },
                            "66%": { transform: "translate(-20px, 20px) scale(0.9)" },
                            "100%": { transform: "translate(0px, 0px) scale(1)" }
                        }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Firebase SDKs -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import { getAuth, signInWithPhoneNumber, RecaptchaVerifier } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";
    </script>
</head>

<body
    class="bg-[#fafafa] text-gray-800 font-sans antialiased selection:bg-terracotta-200 selection:text-terracotta-900">

    <!-- Top Utility Bar (Van Heusen Style) -->
    <!-- Top Utility Bar Removed -->

    <!-- Main Navbar -->
    <nav class="sticky w-full z-50 top-0 transition-all duration-300 bg-gray-900 shadow-lg text-white" id="main-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center pr-8">
                    <a href="<?= $basePath ?>/" class="flex items-center">
                        <img src="<?= $basePath ?>/assets/images/logo.png" alt="WEAR."
                            class="h-20 w-auto object-contain">
                    </a>
                </div>

                <!-- Desktop Menu (Bold & Uppercase) -->
                <div class="hidden lg:flex space-x-8 items-center">
                    <a href="<?= $basePath ?>/"
                        class="text-xs font-bold text-gray-300 hover:text-white hover:text-terracotta-500 transition-colors uppercase tracking-[0.15em]">Home</a>
                    <a href="<?= $basePath ?>/products.php"
                        class="text-xs font-bold text-gray-300 hover:text-white hover:text-terracotta-500 transition-colors uppercase tracking-[0.15em]">Products</a>
                    <a href="<?= $basePath ?>/about.php"
                        class="text-xs font-bold text-gray-300 hover:text-white hover:text-terracotta-500 transition-colors uppercase tracking-[0.15em]">About</a>
                    <a href="<?= $basePath ?>/contact.php"
                        class="text-xs font-bold text-gray-300 hover:text-white hover:text-terracotta-500 transition-colors uppercase tracking-[0.15em]">Contact</a>
                </div>

                <!-- Animated Search Bar (Smaller Width) -->
                <div class="hidden md:flex flex-1 max-w-[280px] mx-6">
                    <form action="<?= $basePath ?>/products.php" method="GET" class="w-full relative group">
                        <div
                            class="relative w-full bg-gray-800/50 rounded-full h-9 flex items-center overflow-hidden transition-all duration-300 focus-within:ring-1 focus-within:ring-terracotta-500 focus-within:bg-gray-800 border border-gray-700">

                            <!-- Icon -->
                            <div
                                class="pl-4 flex items-center pointer-events-none text-gray-500 group-focus-within:text-terracotta-500">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <!-- Scrolling Placeholder -->
                            <div id="search-placeholder-wrapper"
                                class="absolute left-0 right-4 h-full flex items-center pointer-events-none overflow-hidden text-[10px] text-gray-500 transition-opacity duration-200 pl-10">
                                <span class="mr-1 font-medium text-gray-500">Search for</span>
                                <div style="height: 24px;" class="overflow-hidden relative flex-1">
                                    <div id="search-scroller"
                                        class="flex flex-col transition-transform duration-500 ease-in-out">
                                        <span style="height: 24px; line-height: 24px;"
                                            class="block font-bold text-gray-400">Running Shoes</span>
                                        <span style="height: 24px; line-height: 24px;"
                                            class="block font-bold text-gray-400">Leather Boots</span>
                                        <span style="height: 24px; line-height: 24px;"
                                            class="block font-bold text-gray-400">Party Heels</span>
                                        <span style="height: 24px; line-height: 24px;"
                                            class="block font-bold text-gray-400">Sneakers</span>
                                        <span style="height: 24px; line-height: 24px;"
                                            class="block font-bold text-gray-400">Formal Loafers</span>
                                        <span style="height: 24px; line-height: 24px;"
                                            class="block font-bold text-gray-400">Casual Flats</span>
                                        <span style="height: 24px; line-height: 24px;"
                                            class="block font-bold text-gray-400">Flip Flops</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Input -->
                            <input type="text" name="search" id="search-input"
                                class="w-full bg-transparent border-none h-full py-0 pl-10 pr-4 text-xs font-medium text-white focus:ring-0 placeholder-transparent z-10"
                                placeholder="" autocomplete="off">
                        </div>
                    </form>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const scroller = document.getElementById('search-scroller');
                            const input = document.getElementById('search-input');
                            const wrapper = document.getElementById('search-placeholder-wrapper');

                            if (input && wrapper && scroller) {
                                input.addEventListener('input', () => {
                                    wrapper.style.opacity = input.value ? '0' : '1';
                                });
                                input.addEventListener('focus', () => {
                                    wrapper.classList.add('opacity-40');
                                });
                                input.addEventListener('blur', () => {
                                    if (!input.value) {
                                        wrapper.style.opacity = '1';
                                        wrapper.classList.remove('opacity-40');
                                    }
                                });

                                // Clone first element for seamless loop
                                const firstClone = scroller.firstElementChild.cloneNode(true);
                                scroller.appendChild(firstClone);

                                let idx = 0;
                                const itemHeight = 24; // Exact 24px
                                const total = scroller.children.length;

                                setInterval(() => {
                                    idx++;
                                    scroller.style.transition = 'transform 0.5s ease-in-out';
                                    scroller.style.transform = `translateY(-${idx * itemHeight}px)`;

                                    // Reset seamlessly when reaching the clone
                                    if (idx === total - 1) {
                                        setTimeout(() => {
                                            scroller.style.transition = 'none';
                                            idx = 0;
                                            scroller.style.transform = `translateY(0)`;
                                        }, 500); // 500ms matches transition duration
                                    }
                                }, 2500);
                            }
                        });
                    </script>
                </div>

                <!-- Icons -->
                <div class="flex items-center space-x-5">
                    <!-- Mobile Search Trigger -->
                    <button class="md:hidden text-gray-300 hover:text-terracotta-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <a href="<?= $basePath ?>/wishlist.php"
                        class="text-gray-300 hover:text-terracotta-600 transition-colors hidden sm:block relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span id="wishlist-count"
                            class="absolute -top-1 -right-1 bg-terracotta-500 text-white text-[9px] font-bold h-3.5 w-3.5 rounded-full flex items-center justify-center <?= $wishlistCount > 0 ? '' : 'hidden' ?>"><?= $wishlistCount ?></span>
                    </a>
                    <a href="<?= $basePath ?>/cart.php"
                        class="text-gray-300 hover:text-terracotta-600 transition-colors relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span id="cart-count"
                            class="absolute -top-1 -right-1 bg-terracotta-500 text-white text-[9px] font-bold h-3.5 w-3.5 rounded-full flex items-center justify-center <?= $cartCount > 0 ? '' : 'hidden' ?>"><?= $cartCount ?></span>
                    </a>
                    <a href="<?= $basePath ?>/profile.php"
                        class="text-gray-300 hover:text-terracotta-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <main class="min-h-screen">