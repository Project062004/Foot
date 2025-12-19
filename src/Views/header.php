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

    <!-- Navbar -->
    <nav class="fixed w-full z-50 top-0 transition-all duration-300 bg-white/70 backdrop-blur-xl border-b border-white/20 shadow-sm"
        id="main-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-bold tracking-tighter text-gray-900">
                        WEAR<span class="text-terracotta-500">.</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-12">
                    <a href="/"
                        class="text-sm font-medium text-gray-900 hover:text-terracotta-500 transition-colors uppercase tracking-wide">Home</a>
                    <a href="/products.php"
                        class="text-sm font-medium text-gray-500 hover:text-terracotta-500 transition-colors uppercase tracking-wide">Products</a>
                    <a href="/about.php"
                        class="text-sm font-medium text-gray-500 hover:text-terracotta-500 transition-colors uppercase tracking-wide">About</a>
                    <a href="/contact.php"
                        class="text-sm font-medium text-gray-500 hover:text-terracotta-500 transition-colors uppercase tracking-wide">Contact</a>
                </div>

                <!-- Icons -->
                <div class="flex items-center space-x-6">
                    <button class="text-gray-400 hover:text-terracotta-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    <a href="/wishlist.php"
                        class="text-gray-400 hover:text-terracotta-500 transition-colors hidden sm:block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </a>
                    <a href="/cart.php" class="text-gray-400 hover:text-terracotta-500 transition-colors relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 bg-terracotta-500 text-white text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center">0</span>
                    </a>
                    <a href="/profile.php" class="text-gray-400 hover:text-terracotta-500 transition-colors">
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
    <main class="pt-20 min-h-screen">