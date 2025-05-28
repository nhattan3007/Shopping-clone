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
                    <form method="POST" action="<?= $baseURL . 'Cart/add' ?>">
                        <input type="hidden" name="ProductId" value="<?= $product['ProductId'] ?>">
                        <button type="submit" name="add_to_cart" class="btn btn-danger btn-lg w-100 mb-2">Mua ngay</button>
                    </form>
                    <p class="text-center text-muted">Giao tận nơi hoặc nhận ở cửa hàng</p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary w-50">TRẢ GÓP QUA THẺ TÍN DỤNG</button>
                        <button class="btn btn-info text-white w-50">TRẢ GÓP QUA CÔNG TY TÀI CHÍNH</button>
                    </div>
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
    </script>
</body>
<?php include "Layout/HomeFooter.php" ?>