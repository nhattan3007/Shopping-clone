<?php include "Layout/HomeHeader.php"; ?>

<div class="container mt-5 mb-5">
    <div class="text-center">
        <div class="alert alert-success">
            <h2>✅ Đặt hàng thành công!</h2>
            <p>Cảm ơn bạn đã mua hàng. Đơn hàng của bạn đang được xử lý.</p>
        </div>
        <a href="<?= $baseURL ?>" class="btn btn-primary">Tiếp tục mua sắm</a>
        <a href="<?= $baseURL ?>checkout/history" class="btn btn-info">Xem lịch sử đơn hàng</a>
    </div>
</div>

<?php include "Layout/HomeFooter.php"; ?>