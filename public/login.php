<?php
require_once __DIR__ . '/../src/Views/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-lg shadow-[0_8px_30px_rgb(0,0,0,0.12)] relative overflow-hidden"
        data-aos="fade-up">

        <!-- Top Accent Border (Matches Image Orange) -->
        <div class="h-1.5 w-full bg-[#d05e42]"></div>

        <div class="p-8 sm:p-10">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2 font-sans tracking-tight">Sign In</h2>
                <p class="text-sm text-gray-500">Access your Retail or Wholesale account</p>
            </div>

            <!-- Tabs -->
            <div class="flex justify-center mb-8 border-b border-gray-100">
                <button id="tabMobile"
                    class="w-1/2 pb-3 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors border-b-2 border-transparent focus:outline-none">
                    Mobile OTP
                </button>
                <button id="tabEmail"
                    class="w-1/2 pb-3 text-sm font-medium text-[#d05e42] border-b-2 border-[#d05e42] focus:outline-none transition-colors">
                    Email & Password
                </button>
            </div>

            <!-- Mobile Login Form -->
            <form class="space-y-6 hidden" id="loginFormMobile" onsubmit="return false;">
                <div id="recaptcha-container" class="flex justify-center mb-2"></div>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                        <div class="flex">
                            <span
                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-200 bg-gray-50 text-gray-500 text-sm font-medium">+91</span>
                            <input id="mobile" name="mobile" type="tel" pattern="[6-9][0-9]{9}"
                                title="Enter valid 10-digit mobile number" maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                class="flex-1 appearance-none rounded-r-md border border-gray-200 px-3 py-3 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-1 focus:ring-[#d05e42] focus:border-[#d05e42] sm:text-sm transition-shadow shadow-sm"
                                placeholder="9876543210">
                        </div>
                    </div>
                </div>

                <!-- OTP Section -->
                <div id="otp_section" class="hidden animate-fade-in space-y-5 mt-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Enter OTP</label>
                        <input id="otp" name="otp" type="text" maxlength="6" inputmode="numeric"
                            class="block w-full rounded-md border border-gray-200 px-3 py-3 placeholder-gray-400 text-gray-900 text-center tracking-[0.5em] font-medium focus:outline-none focus:ring-1 focus:ring-[#d05e42] focus:border-[#d05e42] sm:text-sm shadow-sm"
                            placeholder="• • • • • •">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="button" id="sendOtpBtn"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-[#111827] hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all">
                        Send OTP
                    </button>
                    <button type="button" id="verifyBtn"
                        class="hidden w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-[#111827] hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all">
                        Verify & Login
                    </button>
                </div>
            </form>

            <!-- Email Login Form -->
            <form class="space-y-6" id="loginFormEmail" onsubmit="return false;">
                <div class="space-y-5">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="block w-full rounded-md border border-gray-200 px-3 py-3 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-1 focus:ring-[#d05e42] focus:border-[#d05e42] sm:text-sm transition-shadow shadow-sm"
                            placeholder="name@example.com">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full rounded-md border border-gray-200 px-3 py-3 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-1 focus:ring-[#d05e42] focus:border-[#d05e42] sm:text-sm transition-shadow shadow-sm"
                            placeholder="••••••••">
                    </div>
                    <div class="flex justify-end">
                        <a href="<?= $basePath ?>/forgot_password.php"
                            class="text-sm font-medium text-[#d05e42] hover:text-[#b04b32]">Forgot Password?</a>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="button" id="emailLoginBtn"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-[#111827] hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all">
                        Sign In with Password
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <a href="<?= $basePath ?>/register.php" class="text-sm font-medium text-[#d05e42] hover:text-[#b04b32]">
                    New user? Create an account
                </a>
            </div>
        </div>
    </div>
</div>

<script type="module">
    import { auth, signInWithPhoneNumber, RecaptchaVerifier } from "<?= $basePath ?>/assets/js/firebase-init.js";

    // Initialize Recaptcha (Only needed for Mobile Tab)
    window.recaptchaVerifier = new RecaptchaVerifier(auth, 'recaptcha-container', {
        'size': 'normal',
    });

    // Tab Switching Logic
    const tabMobile = document.getElementById('tabMobile');
    const tabEmail = document.getElementById('tabEmail');
    const formMobile = document.getElementById('loginFormMobile');
    const formEmail = document.getElementById('loginFormEmail');

    tabMobile.addEventListener('click', () => {
        tabMobile.classList.add('text-[#d05e42]', 'border-[#d05e42]');
        tabMobile.classList.remove('text-gray-500', 'border-transparent');

        tabEmail.classList.remove('text-[#d05e42]', 'border-[#d05e42]');
        tabEmail.classList.add('text-gray-500', 'border-transparent');

        formMobile.classList.remove('hidden');
        formEmail.classList.add('hidden');
    });

    tabEmail.addEventListener('click', () => {
        tabEmail.classList.add('text-[#d05e42]', 'border-[#d05e42]');
        tabEmail.classList.remove('text-gray-500', 'border-transparent');

        tabMobile.classList.remove('text-[#d05e42]', 'border-[#d05e42]');
        tabMobile.classList.add('text-gray-500', 'border-transparent');

        formEmail.classList.remove('hidden');
        formMobile.classList.add('hidden');
    });

    // Mobile Login Logic
    let confirmationResult;
    const sendBtn = document.getElementById('sendOtpBtn');
    const verifyBtn = document.getElementById('verifyBtn');
    const mobileInput = document.getElementById('mobile');
    const otpSection = document.getElementById('otp_section');

    sendBtn.addEventListener('click', () => {
        const mobile = mobileInput.value.trim();
        if (!/^[6-9]\d{9}$/.test(mobile)) {
            alert("Please enter a valid 10-digit Indian mobile number.");
            return;
        }

        sendBtn.disabled = true;
        sendBtn.innerText = "Checking...";

        // 1. Check with Backend if user exists
        fetch('<?= $basePath ?>/api/check_user.php', {
            method: 'POST',
            body: JSON.stringify({ mobile: mobile }),
            headers: { 'Content-Type': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (!data.exists) { // User NOT in DB
                alert("User not found! Please Create an account first.");
                sendBtn.disabled = false;
                sendBtn.innerText = "Send OTP";
                return;
            }

            // 2. User exists, proceed to Send OTP
            sendBtn.innerText = "Sending OTP...";
            const phoneNumber = "+91" + mobile;
            const appVerifier = window.recaptchaVerifier;

            signInWithPhoneNumber(auth, phoneNumber, appVerifier)
                .then((result) => {
                    confirmationResult = result;
                    otpSection.classList.remove('hidden');
                    sendBtn.classList.add('hidden');
                    verifyBtn.classList.remove('hidden');
                    mobileInput.disabled = true;
                    alert("OTP Sent!");
                }).catch((error) => {
                    console.error(error);
                    const errStr = (error.code || '') + ' ' + (error.message || '');
                    if (errStr.includes('too-many-requests') || errStr.includes('billing') || errStr.includes('quota')) {
                        alert("⚠️ Dev Mode: Firebase Limit/Billing Error.\nSwitching to Mock Logic.\n\nUse OTP: 123456");

                        // Mock Success State
                        otpSection.classList.remove('hidden');
                        sendBtn.classList.add('hidden');
                        verifyBtn.classList.remove('hidden');
                        mobileInput.disabled = true;

                        // Mock Confirmation Result
                        confirmationResult = {
                            confirm: async function (otp) {
                                if (otp === '123456') {
                                    return {
                                        user: {
                                            getIdToken: async () => 'mock_id_token_12345'
                                        }
                                    };
                                } else {
                                    throw new Error("Invalid Mock OTP");
                                }
                            }
                        };
                    } else {
                        sendBtn.disabled = false;
                        sendBtn.innerText = "Send OTP";
                        alert("Error sending OTP: " + (error.code || error.message));
                        grecaptcha.reset(window.recaptchaVerifier.widgetId);
                    }
                });
        })
        .catch(err => {
            alert("Server Error checking user status");
            sendBtn.disabled = false;
            sendBtn.innerText = "Send OTP";
        });
    });

    // Helper to get redirect param
    const urlParams = new URLSearchParams(window.location.search);
    const redirectParam = urlParams.get('redirect');

    verifyBtn.addEventListener('click', () => {
        const otp = document.getElementById('otp').value.trim();
        if (otp.length !== 6) { alert("Enter valid 6-digit OTP"); return; }
        verifyBtn.disabled = true;
        verifyBtn.innerText = "Verifying...";
        confirmationResult.confirm(otp).then((result) => {
            result.user.getIdToken().then(token => {
                fetch('<?= $basePath ?>/api/login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ mobile: mobileInput.value, id_token: token, method: 'mobile', redirect: redirectParam })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) { window.location.href = data.redirect; }
                        else { alert(data.error); verifyBtn.disabled = false; verifyBtn.innerText = "Verify & Login"; }
                    });
            });
        }).catch((error) => {
            alert("Invalid OTP");
            verifyBtn.disabled = false;
            verifyBtn.innerText = "Verify & Login";
        });
    });

    // Email Login Logic
    const emailLoginBtn = document.getElementById('emailLoginBtn');
    emailLoginBtn.addEventListener('click', () => {
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        if (!email || !password) { alert("Please fill all fields"); return; }

        emailLoginBtn.disabled = true;
        emailLoginBtn.innerText = "Signing in...";

        fetch('<?= $basePath ?>/api/login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: email, password: password, method: 'email', redirect: redirectParam })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.error);
                    emailLoginBtn.disabled = false;
                    emailLoginBtn.innerText = "Sign In with Password";
                }
            });
    });
</script>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>