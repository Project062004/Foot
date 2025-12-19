</main>

<!-- Mega Footer -->
<footer class="bg-gray-900 text-white pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-1">
                <a href="/" class="text-2xl font-bold tracking-tighter text-white mb-6 block">
                    WEAR<span class="text-terracotta-500">.</span>
                </a>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    Premium footwear for the modern woman. Combining comfort, style, and luxury in every step.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <!-- Links -->
            <div>
                <h4 class="text-lg font-semibold mb-6">Shop</h4>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-terracotta-500 transition">New Arrivals</a></li>
                    <li><a href="#" class="hover:text-terracotta-500 transition">Best Sellers</a></li>
                    <li><a href="#" class="hover:text-terracotta-500 transition">Sports Edition</a></li>
                    <li><a href="#" class="hover:text-terracotta-500 transition">Casual Collection</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-6">Support</h4>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-terracotta-500 transition">Track Order</a></li>
                    <li><a href="#" class="hover:text-terracotta-500 transition">Returns & Exchange</a></li>
                    <li><a href="#" class="hover:text-terracotta-500 transition">Customer Care</a></li>
                    <li><a href="#" class="hover:text-terracotta-500 transition">Size Guide</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div>
                <h4 class="text-lg font-semibold mb-6">Stay Updated</h4>
                <p class="text-gray-400 text-sm mb-4">Subscribe to our newsletter for exclusive offers and updates.</p>
                <form action="#" class="flex flex-col space-y-3">
                    <input type="email" placeholder="Enter your email"
                        class="bg-gray-800 border border-gray-700 text-white px-4 py-3 rounded focus:outline-none focus:border-terracotta-500 transition text-sm">
                    <button type="submit"
                        class="bg-terracotta-500 hover:bg-terracotta-600 text-white px-4 py-3 rounded font-medium transition text-sm uppercase tracking-wide">Subscribe</button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-500 text-xs">&copy; 2025 Wear Footwear. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0 text-gray-500 text-xs">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="#" class="hover:text-white transition">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Hide Scrollbar Global Utility */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 50
    });

    // Global Toast Notification
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-5 left-1/2 transform -translate-x-1/2 px-6 py-3 rounded shadow-lg text-white text-sm font-medium z-[100] transition-all duration-300 opacity-0 translate-y-4 ${type === 'error' ? 'bg-red-500' : 'bg-gray-900'}`;
        toast.innerText = message;
        document.body.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.remove('opacity-0', 'translate-y-4');
        });

        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-4');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Global Wishlist Toggle
    function toggleWishlist(id, btn = null) {
        // Stop propagation if event exists (handled by caller usually but safe to check)
        if (window.event) window.event.preventDefault();

        fetch('/api/wishlist.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'toggle', product_id: id })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Determine action based on status
                    const isAdded = data.status === 'added';
                    showToast(isAdded ? 'Added to Wishlist' : 'Removed from Wishlist');

                    // Update Button State if btn is passed
                    if (btn) {
                        const svg = btn.querySelector('svg');
                        if (svg) {
                            svg.setAttribute('fill', isAdded ? 'currentColor' : 'none');
                            // Add a little pop animation
                            btn.classList.add('scale-125');
                            setTimeout(() => btn.classList.remove('scale-125'), 200);
                        }
                    }

                    // If on wishlist page, reload to remove item
                    if (window.location.pathname.includes('/wishlist.php') && !isAdded) {
                        setTimeout(() => window.location.reload(), 500);
                    }

                } else {
                    showToast('Please Login to use Wishlist', 'error');
                    // Optional: Redirect to login
                    // window.location.href = '/login.php?redirect=' + encodeURIComponent(window.location.pathname);
                }
            })
            .catch(err => {
                console.error(err);
                showToast('Something went wrong', 'error');
            });
    }
</script>
</body>

</html>