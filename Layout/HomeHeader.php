<?php
$config = require "config.php";   // Tải mảng cấu hình từ file config.php
$baseURL = $config['baseURL'];    // Lấy giá trị 'baseURL' từ mảng cấu hình

if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous"> -->
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?= $baseURL . "/Assets/admin/css/styles.css"?> " rel="stylesheet" />
        <link href="<?= $baseURL . "/Assets/css/banner.css"?>" rel="stylesheet" />
    </head>
    <body>
        
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
            <a class="navbar-brand fw-bold" href="<?=$baseURL?>Home/index" style="font-size: 1.8rem;">ShoppingQST</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= $baseURL .'Product/index'?>">Shop it</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $baseURL .'user/contract'?>">Liên hệ</a></li>                   
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?=$baseURL . 'home/index'?>">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li>                    
                    </ul>
                    <!-- Dời phần Profile ra ngoài ul này -->
                    <div class="d-flex align-items-center">
                        <?php 
                        if (isset($_SESSION['user_id'])) {
                        ?>
                            <div class="nav-item dropdown me-3">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownProfile" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                   <i class="bi bi-person fs-4"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownProfile">
                                    <li><a class="dropdown-item" href="#!"><?= $_SESSION['username'] ?></a></li>
                                    <li><a class="dropdown-item" href="<?=$baseURL?>order/history">Lịch sử đơn hàng</a></li>
                                    <li><?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
                                        <a class= "dropdown-item" href="<?= $baseURL ?>admin/index" class="nav-link">Admin</a>
                                    <?php endif; ?></a></li>

                                    <li><hr class="dropdown-divider" /></li>
                                    <li><a class="dropdown-item" href="<?=$baseURL?>user/logout">Logout</a></li>
                                </ul>
                            </div>
                        <?php
                        } else {
                        ?>
                            <a class="btn btn-outline-primary me-3" href="<?=$baseURL?>user/login">Login</a>
                        <?php
                        }
                        ?>

                        <!-- Form giỏ hàng Cart -->
                        <form action="<?=$baseURL.'cart/index'?>" method="POST" class="d-flex">
                            <button class="btn btn-outline-dark" type="submit">
                                <i class="bi-cart-fill me-1"></i>
                                Cart
                                <span class="badge bg-dark text-white ms-1 rounded-pill">
                                    <?= array_sum(array_column($_SESSION['cart'] ?? [], 'quantity')) ?>
                                </span>
                            </button>
                        </form>
                    </div>     
                </div>
            </div>
        </nav>
        <!-- Header-->