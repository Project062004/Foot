<?php
require_once __DIR__ . '/../src/Views/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-xl" data-aos="fade-up">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Forgot Password?</h2>
            <p class="mt-2 text-sm text-gray-600">
                Enter your email address and we'll send you a link to reset your password.
            </p>
        </div>
        <form class="mt-8 space-y-6" id="forgotForm">
            <div>
                <label for="email" class="sr-only">Email password</label>
                <input id="email" name="email" type="email" autocomplete="email" required
                    class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 focus:z-10 sm:text-sm"
                    placeholder="Email Address">
            </div>

            <div>
                <button type="submit" id="submitBtn"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-terracotta-600 hover:bg-terracotta-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-terracotta-500 transition-all shadow-lg">
                    Send Reset Link
                </button>
            </div>

            <div class="text-center">
                <a href="/login.php" class="font-medium text-terracotta-600 hover:text-terracotta-500 text-sm">
                    &larr; Back to Login
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('forgotForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const btn = document.getElementById('submitBtn');

        btn.disabled = true;
        btn.innerText = "Sending...";

        fetch('/api/send_reset.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // In a real app, this would be an email. 
                    // In dev, we alert the link for easy testing.
                    alert("✅ Password Reset Link Generated!\n\n(Since we can't send emails from localhost, click OK to be redirected to the link)\n\n" + data.mock_link);
                    window.location.href = data.mock_link;
                } else {
                    alert('Error: ' + data.message);
                    btn.disabled = false;
                    btn.innerText = "Send Reset Link";
                }
            });
    });
</script>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>