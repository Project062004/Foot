<?php
require_once __DIR__ . '/../src/Views/header.php';

$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-xl">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Reset Password</h2>
            <p class="mt-2 text-sm text-gray-600">
                Create a new secure password.
            </p>
        </div>
        <form class="mt-8 space-y-6" id="resetForm">
            <input type="hidden" id="token" value="<?= htmlspecialchars($token) ?>">
            <input type="hidden" id="email" value="<?= htmlspecialchars($email) ?>">

            <div class="space-y-4">
                <div>
                    <label for="password" class="sr-only">New Password</label>
                    <input id="password" name="password" type="password" required
                        class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 focus:z-10 sm:text-sm"
                        placeholder="New Password">
                </div>
                <div>
                    <label for="confirm_password" class="sr-only">Confirm Password</label>
                    <input id="confirm_password" name="confirm_password" type="password" required
                        class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 focus:z-10 sm:text-sm"
                        placeholder="Confirm New Password">
                </div>
            </div>

            <div>
                <button type="submit" id="submitBtn"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-terracotta-600 hover:bg-terracotta-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-terracotta-500 transition-all shadow-lg">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('resetForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const token = document.getElementById('token').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('confirm_password').value;
        const btn = document.getElementById('submitBtn');

        if (password !== confirm) {
            alert("Passwords do not match");
            return;
        }

        if (password.length < 6) {
            alert("Password must be at least 6 characters");
            return;
        }

        btn.disabled = true;
        btn.innerText = "Updating...";

        fetch('/api/reset_process.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ token, email, password })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Success! Your password has been updated.");
                    window.location.href = '/login.php';
                } else {
                    alert('Error: ' + data.message);
                    btn.disabled = false;
                    btn.innerText = "Reset Password";
                }
            });
    });
</script>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>