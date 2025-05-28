<?php include_once "Layout/HomeHeader.php" ?>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Sản phẩm nổi bật</h2>
            <p class="text-muted">Khám phá những sản phẩm được yêu thích nhất</p>
        </div>

        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php $limitedProducts = array_slice($productList, 0, 4);
            foreach ($limitedProducts as $item) : ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <a href="<?= $baseURL . 'product/detail?productid=' . $item['ProductId'] ?>">
                            <img class="card-img-top"
                                src="<?= $baseURL . 'Assets/uploads/images/' . $item['Image'] ?>"
                                alt="<?= $item['ProductName'] ?>"
                                style="cursor: pointer; transition: transform 0.2s;"
                                onmouseover="this.style.transform='scale(1.05)'"
                                onmouseout="this.style.transform='scale(1)'" />
                        </a>

                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder">
                                    <a href="<?= $baseURL . 'product/detail?productid=' . $item['ProductId'] ?>"
                                        class="text-decoration-none text-dark"
                                        style="transition: color 0.2s;"
                                        onmouseover="this.style.color='#0d6efd'"
                                        onmouseout="this.style.color='#212529'">
                                        <?= $item['ProductName'] ?>
                                    </a>
                                </h5>
                                <p class="text-muted">$<?= number_format($item['Price'], 0) ?></p>
                            </div>
                        </div>

                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto"
                                    href="<?= $baseURL . 'product/detail?productid=' . $item['ProductId'] ?>"
                                    style="transition: all 0.2s;"
                                    onmouseover="this.classList.add('btn-dark'); this.classList.remove('btn-outline-dark')"
                                    onmouseout="this.classList.add('btn-outline-dark'); this.classList.remove('btn-dark')">
                                    Chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Nút xem thêm -->
            <?php if (count($productList) > 4) : ?>
                <div class="text-center mt-4">
                    <a href="<?= $baseURL . 'product/index' ?>" class="btn btn-primary btn-lg">
                        Xem thêm
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Footer-->
<?php include_once "Layout/HomeFooter.php" ?>