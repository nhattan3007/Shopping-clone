<?php require "Layout/HomeHeader.php";
// var_dump($productList);
    $config = require 'config.php';
    $baseURL = $config['baseURL'];  
    
        ?>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php foreach ($productList as $product): ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="<?=$baseURL.'Assets/uploads/img`/'.$product['Image']?>" alt="<?=$product['Image']?>" />
                                <!-- Product details -->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?php echo ($product['ProductName']); ?></h5>
                                    <!-- Product price-->
                                    <?php echo ($product['Price']);?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <form method="post" action="<?=$baseURL .'Cart/add'?>" class="text-center mb-lg-2">
                            <input type="hidden" name="ProductId" value="<?= $product['ProductId'] ?>">
                            <button type="submit" class=" btn-outline-light p4 mt-auto btn btn-primary btn-sm">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <?php require "Layout/HomeFooter.php" ?>
