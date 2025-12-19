<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeStep Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        terracotta: { 50: '#fdf8f6', 100: '#fbeee9', 500: '#e07a5f', 600: '#d05e42', 900: '#733529' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-active {
            background-color: #f3f4f6;
            color: #e07a5f;
            border-right: 3px solid #e07a5f;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col z-10">
            <!-- Brand -->
            <div class="h-16 flex items-center px-8 border-b border-gray-100">
                <span class="text-xl font-bold text-terracotta-600">LuxeStep <span
                        class="text-gray-400 font-normal">Admin</span></span>
            </div>

            <!-- Check current page for active state -->
            <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

            <!-- Nav -->
            <nav class="flex-1 px-4 py-6 space-y-1">
                <a href="/admin/index.php"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors <?= $currentPage == 'index.php' ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-50 hover:text-terracotta-500' ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Dashboard
                </a>
                <a href="/admin/orders.php"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors <?= $currentPage == 'orders.php' ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-50 hover:text-terracotta-500' ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Orders
                </a>
                <a href="/admin/products.php"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors <?= $currentPage == 'products.php' ? 'active sidebar-active' : 'text-gray-600 hover:bg-gray-50 hover:text-terracotta-500' ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Products
                </a>
                <a href="/admin/users.php"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors <?= $currentPage == 'users.php' ? 'sidebar-active' : 'text-gray-600 hover:bg-gray-50 hover:text-terracotta-500' ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    Customers
                </a>
                <a href="#"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors text-gray-600 hover:bg-gray-50 hover:text-terracotta-500">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    Analytics
                </a>
            </nav>

            <!-- User Profile Snippet (Bottom Sidebar) -->
            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-full bg-terracotta-100 flex items-center justify-center text-terracotta-600 font-bold text-xs">
                        AD</div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Admin User</p>
                        <p class="text-xs text-gray-500">View Profile</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Section -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            <!-- Top Header -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10">
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Global Search -->
                <div class="relative w-64 hidden sm:block">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text"
                        class="w-full bg-gray-100 text-sm rounded-md pl-10 pr-4 py-2 focus:outline-none focus:ring-1 focus:ring-terracotta-500 transition-colors"
                        placeholder="Search...">
                </div>

                <div class="flex items-center gap-4">
                    <button
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-terracotta-600 text-white text-xs font-bold shadow-md hover:bg-terracotta-700 transition">
                        AD
                    </button>
                </div>
            </header>

            <!-- Content Srcoll Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 scroll-smooth">