<?php include_once "Layout/HomeHeader.php" ?>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php foreach ($productList as $item) : ?>
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image -->
                        <img class="card-img-top" src="<?= $baseURL . 'Assets/uploads/images/' . $item['Image'] ?>" alt="<?= $item['ProductName'] ?>" />
                        <!-- Product details -->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name -->
                                <h5 class="fw-bolder"><?= $item['ProductName'] ?></h5>
                                <!-- Product price -->
                                <p class="text-muted">$<?= number_format($item['Price'], 0) ?></p>
                            </div>
                        </div>
                        <!-- Product actions -->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto" href="<?= $baseURL . 'product/detail' . $item['ProductId'] ?>">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- Footer-->
<?php
include_once "Layout/HomeFooter.php" ?>