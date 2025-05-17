<?php 
include "Layout/AdminHeader.php";
include "Layout/Slidebar.php";?>
    <h2 class="text-center mb-3 mt-2">
        Quản lý Đơn Hàng (Admin)
    </h2>
    <div class="card">
        <div class="cardbody">
            <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($orders as $order):?>
                         <tr>
                            <td><?= $order['OrderId'] ?></td>
                            <td><?= htmlspecialchars($order['FullName']) ?></td>
                            <td><?= $order['OrderDate'] ?></td>
                            <td><?= number_format($order['TotalAmount'], 0) ?>$</td>
                            <td><?= ucwords(strtolower($order['Status'])) ?></td>
                            <td> <form method="post" action="<?= $baseURL ?>order/updateStatus" class="d-flex gap-1">
                            <input type="hidden" name="order_id" value="<?= $order['OrderId'] ?>">
                            <select name="status" class="form-select form-select-sm">
                                        <option value="" selected></option>                            
                                        <option value="Đặt hàng" >Đặt hàng</option>
                                        <option value="Đang xử lý" >Đang xử lý</option>
                                        <option value="Đã giao hàng" >Đã giao hàng</option>
                                        <option value="Đã hủy" >Đã hủy</option>
                            </select>
                            <button class="btn btn-sm btn-primary mt-1">Cập nhật</button>
                        </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>

<?php
include "Layout/AdminFooter.php";
?>