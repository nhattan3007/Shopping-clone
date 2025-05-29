<?php include "Layout/HomeHeader.php"; ?>

<body class="bg-light">
    <div class="container py-5" style="display: flex;">
        <div class="row">
            <!-- Hình ảnh sản phẩm -->
            <div class="col-md-6">
                <div class="row g-2">
                    <div class="col-12">
                        <img class="img-fluid thumbnail-img"
                            src="<?= $baseURL . 'Assets/uploads/images/' . $product['Image'] ?>"
                            alt="<?= htmlspecialchars($product['ProductName']) ?>"
                            id="main-img">
                    </div>
                </div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-6">
                <h4><?= htmlspecialchars($product['ProductName']) ?></h4>

                <p class="sale-price">Price: <?= number_format($product['Price'], 0) ?> VNĐ</p>
                <p><strong>Bảo hành:</strong> 12 tháng sau khi mua</p>
                <p><strong>Tình trạng:</strong> <span class="text-success">Còn hàng</span></p>

                <a href="#" class="text-primary">Xem chi tiết cấu hình</a>

                <!-- Nút hành động -->
                <div class="mt-4">
                    <form method="POST" action="<?= $baseURL . 'cart/add' ?>">
                        <input type="hidden" name="ProductId" value="<?= $product['ProductId'] ?>">

                        <!-- Optional: Add quantity selector -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Số lượng:</label>
                            <div class="input-group" style="width: 150px;">
                                <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
                                <input type="number" class="form-control text-center" id="quantity" name="quantity" value="1" min="1" max="99">
                                <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
                            </div>
                        </div>

                        <button type="submit" name="add_to_cart" class="btn btn-danger btn-lg w-100 mb-2">
                            <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        // Đổi hình chính khi click ảnh phụ
        document.querySelectorAll('.thumbnail-img').forEach(function(img) {
            img.addEventListener('click', function() {
                document.getElementById('main-img').src = this.src;
            });
        });

        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < 99) {
                quantityInput.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }
    </script>
</body>
<?php include "Layout/HomeFooter.php" ?>