<?php
session_start();
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header('Location: /admin/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - LuxeStep</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        terracotta: { 500: '#e07a5f', 600: '#d05e42' }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 h-screen flex items-center justify-center">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">WEAR. <span class="text-terracotta-500">Admin</span></h1>
            <p class="text-gray-500 mt-2">Secure Access Portal</p>
        </div>

        <form id="adminLoginForm" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" id="email"
                    class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-terracotta-500 focus:border-transparent outline-none transition"
                    placeholder="admin@wear.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password"
                    class="mt-1 block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-terracotta-500 focus:border-transparent outline-none transition"
                    placeholder="••••••••">
            </div>

            <button type="submit"
                class="w-full bg-gray-900 text-white py-3 rounded-lg font-bold hover:bg-terracotta-600 transition duration-300 shadow-md">
                Access Dashboard
            </button>
        </form>
    </div>

    <script>
        document.getElementById('adminLoginForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            fetch('/admin/api/auth_login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '/admin/index.php';
                    } else {
                        alert('Access Denied: ' + data.message);
                    }
                });
        });
    </script>
</body>

</html>