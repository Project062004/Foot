<?php
require_once __DIR__ . '/../src/Views/header.php';
?>

<!-- About Hero -->
<div class="relative bg-gray-900 py-32 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1600185365926-3a2ce3cdb9eb?q=80&w=2050&auto=format&fit=crop"
            class="w-full h-full object-cover opacity-30" alt="About Hero">
    </div>
    <div class="relative max-w-7xl mx-auto text-center" data-aos="fade-up">
        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">We Craft Confidence</h1>
        <p class="mt-6 max-w-3xl mx-auto text-xl text-gray-300">
            More than just a manufacturing brand. We are the architects of modern comfort.
        </p>
    </div>
</div>

<!-- Values Section -->
<div class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center mb-16" data-aos="fade-up">
            <h2 class="text-base text-terracotta-600 font-semibold tracking-wide uppercase">Our Values</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Designed for the Modern Era
            </p>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                We believe in sustainable manufacturing, ethical sourcing, and delivering luxury at an accessible price
                point for both retail and wholesale partners.
            </p>
        </div>

        <div class="mt-10">
            <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                <div class="relative" data-aos="fade-up" data-aos-delay="100">
                    <dt>
                        <div
                            class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-terracotta-500 text-white">
                            <!-- Icon -->
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                </path>
                            </svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Premium Materials</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        We source the finest leathers and breathable fabrics to ensure longevity and comfort in every
                        pair.
                    </dd>
                </div>

                <div class="relative" data-aos="fade-up" data-aos-delay="200">
                    <dt>
                        <div
                            class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-terracotta-500 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Wholesale Experts</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        Our B2B platform is optimized for bulk orders with transparent tiered pricing and factory-direct
                        distribution logic.
                    </dd>
                </div>

                <div class="relative" data-aos="fade-up" data-aos-delay="300">
                    <dt>
                        <div
                            class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-terracotta-500 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                </path>
                            </svg>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">Innovative Design</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">
                        Blending sports functionality with high-fashion aesthetics. We create trends, we don't just
                        follow them.
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="bg-terracotta-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 gap-8 md:grid-cols-4 text-center">
            <div data-aos="zoom-in">
                <span class="block text-4xl font-bold text-terracotta-600">30+</span>
                <span class="mt-1 block text-base text-gray-500">Years Experience</span>
            </div>
            <div data-aos="zoom-in" data-aos-delay="100">
                <span class="block text-4xl font-bold text-terracotta-600">500+</span>
                <span class="mt-1 block text-base text-gray-500">Wholesale Partners</span>
            </div>
            <div data-aos="zoom-in" data-aos-delay="200">
                <span class="block text-4xl font-bold text-terracotta-600">10k+</span>
                <span class="mt-1 block text-base text-gray-500">Orders Delivered</span>
            </div>
            <div data-aos="zoom-in" data-aos-delay="300">
                <span class="block text-4xl font-bold text-terracotta-600">4.9</span>
                <span class="mt-1 block text-base text-gray-500">Average Rating</span>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../src/Views/footer.php';
?>