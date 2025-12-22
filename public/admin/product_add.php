<?php
// Admin Product Add Page
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Product - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Add New Product</h1>

        <form id="addProductForm" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" name="name" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                        <option>Sports</option>
                        <option>Casual</option>
                        <option>Formal</option>
                        <option>Flats</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Retail Price (₹)</label>
                    <input type="number" name="price_retail" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Sale Mode</label>
                <select name="sale_mode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                    <option value="both">Both (Retail & Wholesale)</option>
                    <option value="retail">Retail Only</option>
                    <option value="wholesale">Wholesale Only</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2"></textarea>
            </div>

            <hr class="border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Initial Color Variant</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Color Name</label>
                    <input type="text" name="color_name" placeholder="e.g. Midnight Blue" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Hex Code</label>
                    <input type="color" name="hex_code" value="#000000"
                        class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm border p-1 cursor-pointer">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Image URL</label>
                <input type="url" name="image_url" placeholder="https://..."
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">Save
                    Product</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('addProductForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            fetch('/admin/api/add_product.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Product Added!');
                        window.location.href = '/admin/products.php';
                    } else {
                        alert('Error: ' + data.error);
                    }
                });
        });
    </script>
</body>

</html>