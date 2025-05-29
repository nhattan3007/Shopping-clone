<?php
$config = require 'config.php';
$baseURL = $config['baseURL'];
include "Layout/HomeHeader.php"
?>


<section>
    <div class="container">
        <h2 class="mb-4">🛒 Giỏ hàng của bạn</h2>

        <?php if (empty($cartItems)) : ?>
            <p>Giỏ hàng của bạn đang trống.</p>
        <?php else : ?>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalAll = 0;  
                    foreach ($cartItems as $item) :
                        $total = $item['Price'] * $item['quantity'];
                        $totalAll += $total;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($item['ProductName']) ?></td>
                            <td><?= number_format($item['Price'], 2) ?>VND</td>
                            <td><?= $item['quantity'] ?></td>
                            <td>$<?= number_format($total, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-secondary">
                        <th colspan="3" class="text-end">Tổng cộng:</th>
                        <th>$<?= number_format($totalAll, 2) ?></th>
                    </tr>
                </tbody>
            </table>

            <div class="text-end mt-3">
                <a href="<?= $baseURL ?>order/checkout" class="btn btn-success">🛍️ Tiến hành thanh toán</a>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php
include "Layout/AdminFooter.php";
?>