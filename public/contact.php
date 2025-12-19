<?php
require_once __DIR__ . '/../src/Views/header.php';
?>

<div class="min-h-screen bg-white">
    <!-- Header -->
    <div class="bg-gray-50 py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Contact Us</h2>
            <p class="mt-4 text-lg text-gray-500">
                Have a question about wholesale, returns, or just want to say hi? We'd love to hear from you.
            </p>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Form -->
            <div class="bg-white rounded-lg p-0" data-aos="fade-right">
                <form action="#" method="POST" class="grid grid-cols-1 gap-y-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="full_name" id="full_name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-terracotta-500 focus:ring-terracotta-500 sm:text-sm py-3 px-4 border">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-terracotta-500 focus:ring-terracotta-500 sm:text-sm py-3 px-4 border">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea id="message" name="message" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-terracotta-500 focus:ring-terracotta-500 sm:text-sm py-3 px-4 border"></textarea>
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-terracotta-600 hover:bg-terracotta-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-terracotta-500 transition-all">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info -->
            <div data-aos="fade-left">
                <div class="bg-gray-50 rounded-lg p-8 h-full border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Get in Touch</h3>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-terracotta-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 text-base text-gray-500">
                                <p>123 Industrial Estate, Phase 2</p>
                                <p>Mumbai, Maharashtra 400001</p>
                                <p>India</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-terracotta-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3 text-base text-gray-500">
                                <p>+91 98765 43210</p>
                                <p class="text-sm">Mon-Sat 10am to 6pm</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-terracotta-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3 text-base text-gray-500">
                                <p>support@wearfootwear.com</p>
                                <p>wholesale@wearfootwear.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Map Placeholder -->
                    <div class="mt-8 h-48 bg-gray-200 rounded-lg overflow-hidden relative">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d241317.11609823277!2d72.74109995!3d19.08219785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c6306644edc1%3A0x5da4ed8f8d648c69!2sMumbai%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1640000000000!5m2!1sen!2sin"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>