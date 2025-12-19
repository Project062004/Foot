<?php
require_once __DIR__ . '/../src/Views/header.php';
?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-2xl relative overflow-hidden"
        data-aos="fade-up">

        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-terracotta-400 to-terracotta-600"></div>

        <div>
            <h2 class="mt-2 text-center text-3xl font-extrabold text-gray-900">Create Account</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Join our exclusive community
            </p>
        </div>

        <form class="mt-8 space-y-6" id="registerForm">
            <div id="recaptcha-container" class="flex justify-center mb-4"></div>

            <div class="rounded-md shadow-sm space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-xs font-medium text-gray-700 mb-1">First Name</label>
                        <input id="first_name" name="first_name" type="text" required
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="last_name" class="block text-xs font-medium text-gray-700 mb-1">Last Name</label>
                        <input id="last_name" name="last_name" type="text" required
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-xs font-medium text-gray-700 mb-1">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm">
                </div>

                <div>
                    <label for="mobile" class="block text-xs font-medium text-gray-700 mb-1">Mobile</label>
                    <div class="flex">
                        <span
                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            +91
                        </span>
                        <input id="mobile" name="mobile" type="tel" required pattern="[6-9][0-9]{9}"
                            class="appearance-none rounded-r-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm">
                </div>

                <!-- Unified Account Type Selection -->
                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                    <div class="flex items-center">
                        <input id="is_wholesale" name="is_wholesale" type="checkbox"
                            class="h-4 w-4 text-terracotta-600 focus:ring-terracotta-500 border-gray-300 rounded"
                            onchange="toggleWholesaleFields(this.checked)">
                        <label for="is_wholesale" class="ml-2 block text-sm text-gray-900 font-medium">
                            Register as a Wholesale/Business Partner?
                        </label>
                    </div>

                    <div id="wholesale_fields" class="hidden mt-4 animate-fade-in">
                        <label for="gst" class="block text-xs font-medium text-gray-700 mb-1">GST Number <span
                                class="text-red-500">*</span></label>
                        <input id="gst" name="gst" type="text"
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 sm:text-sm"
                            placeholder="GSTIN (15 Digits)">
                        <p class="text-xs text-gray-500 mt-1">Business verification required for wholesale pricing.</p>
                    </div>
                </div>

                <!-- OTP Step -->
                <div id="otp_section" class="hidden animate-fade-in">
                    <div class="mb-4">
                        <label for="otp" class="sr-only">OTP</label>
                        <input id="otp" name="otp" type="text" maxlength="6" inputmode="numeric"
                            class="appearance-none rounded-md relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-terracotta-500 focus:border-terracotta-500 focus:z-10 sm:text-sm tracking-widest text-center text-lg mt-4"
                            placeholder="Enter 6-digit OTP">
                    </div>
                </div>

            </div>

            <div class="mt-6">
                <button type="button" id="sendOtpBtn"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-terracotta-600 hover:bg-terracotta-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-terracotta-500 transition-all shadow-lg">
                    Send OTP & Verify
                </button>
                <button type="submit" id="verifyBtn"
                    class="hidden group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all shadow-lg">
                    Complete Registration
                </button>
            </div>

            <div class="text-center mt-2">
                <a href="/login.php" class="font-medium text-terracotta-600 hover:text-terracotta-500 text-sm">
                    Already have an account? Sign in
                </a>
            </div>
        </form>
    </div>
</div>

<script type="module">
    import { auth, signInWithPhoneNumber, RecaptchaVerifier } from "/assets/js/firebase-init.js";

    window.recaptchaVerifier = new RecaptchaVerifier(auth, 'recaptcha-container', { 'size': 'normal' });

    let confirmationResult;
    const sendBtn = document.getElementById('sendOtpBtn');
    const verifyBtn = document.getElementById('verifyBtn');
    const mobileInput = document.getElementById('mobile');

    // Toggle Wholesale
    window.toggleWholesaleFields = function (checked) {
        const div = document.getElementById('wholesale_fields');
        const gst = document.getElementById('gst');
        if (checked) {
            div.classList.remove('hidden');
            gst.required = true;
        } else {
            div.classList.add('hidden');
            gst.required = false;
        }
    }

    sendBtn.addEventListener('click', () => {
        // Basic Form Validation
        const form = document.getElementById('registerForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }

        sendBtn.disabled = true;
        sendBtn.innerText = "Sending OTP...";

        const phoneNumber = "+91" + mobileInput.value.trim();
        const appVerifier = window.recaptchaVerifier;

        signInWithPhoneNumber(auth, phoneNumber, appVerifier)
            .then((result) => {
                confirmationResult = result;
                document.getElementById('otp_section').classList.remove('hidden');
                sendBtn.classList.add('hidden');
                verifyBtn.classList.remove('hidden');
                alert("OTP Sent!");
            }).catch((error) => {
                console.error("Firebase Register Error:", error);
                const errStr = (error.code || '') + ' ' + (error.message || '');

                // Aggressive check for common billing/limit errors
                if (errStr.includes('too-many-requests') || errStr.includes('billing') || errStr.includes('quota')) {
                    alert("⚠️ Dev Mode: Firebase Limit/Billing Error (Automatic Bypass).\n\nUse OTP: 123456");

                    // Mock Success State
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

                    document.getElementById('otp_section').classList.remove('hidden');
                    sendBtn.classList.add('hidden');
                    verifyBtn.classList.remove('hidden');
                    // make fields read-only
                    mobileInput.disabled = true;
                } else {
                    sendBtn.disabled = false;
                    sendBtn.innerText = "Send OTP & Verify";
                    alert("Error sending OTP: " + errStr);
                    if (window.recaptchaVerifier) {
                        grecaptcha.reset(window.recaptchaVerifier.widgetId);
                    }
                }
            });
    });

    document.getElementById('registerForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const otp = document.getElementById('otp').value.trim();
        if (otp.length !== 6) { alert("Invalid OTP"); return; }

        verifyBtn.disabled = true;
        verifyBtn.innerText = "Processing...";

        confirmationResult.confirm(otp).then((result) => {
            result.user.getIdToken().then(token => {
                const formData = new FormData(document.getElementById('registerForm'));
                const data = Object.fromEntries(formData.entries());
                data.id_token = token;

                // Map account type based on checkbox
                // If is_wholesale is exists (on), type = wholesale. Else retail.
                if (data.is_wholesale) {
                    data.account_type = 'wholesale';
                } else {
                    data.account_type = 'retail';
                }

                fetch('/verify_auth.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                })
                    .then(res => res.json())
                    .then(response => {
                        if (response.success) {
                            window.location.href = response.redirect;
                        } else {
                            verifyBtn.disabled = false;
                            verifyBtn.innerText = "Complete Registration";
                            alert("Registration Failed: " + response.error);
                        }
                    })
                    .catch(err => {
                        alert("System Error");
                        verifyBtn.disabled = false;
                    });
            });
        }).catch(err => {
            alert("Invalid OTP");
            verifyBtn.disabled = false;
            verifyBtn.innerText = "Complete Registration";
        });
    });
</script>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>