<!doctype html>
<html class="no-js" lang="">


<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home 1 || 69 Fashion</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <?php if (isset($_GET['page']) && ($_GET['page'] === "account/order_history" || $_GET['page'] === "account/profile" || $_GET['page'] === "account/change_pass")) : ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <style>
            .nav a {
                color: #666666
            }
        </style>
    <?php else : ?>
        <!-- bootstrap v3.3.6 css -->
        <link rel="stylesheet" href="<?php echo $CONTENT_SITE_PATH ?>/css/bootstrap.min.css">
        <style>
            .pro-rating a i {
                font-size: 20px !important;
            }
        </style>
    <?php endif ?>
    <!-- animate css -->
    <link rel="stylesheet" href="<?php echo $CONTENT_SITE_PATH ?>/css/animate.css">
    <!-- jquery-ui.min css -->
    <link rel="stylesheet" href="<?php echo $CONTENT_SITE_PATH ?>/css/jquery-ui.min.css">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="<?php echo $CONTENT_SITE_PATH ?>/css/meanmenu.min.css">
    <!-- nivo slider css -->
    <link rel="stylesheet" href="<?php echo $CONTENT_SITE_PATH ?>/lib/css/nivo-slider.css" />
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="<?php echo $CONTENT_SITE_PATH ?>/css/owl.carousel.css">
    <!-- Simple Lence css -->
    <link rel="stylesheet" href="<?php echo $CONTENT_SITE_PATH ?>/css/jquery.simpleLens.css">
    <!-- font-awesome css -->
    <link rel="stylesheet" href="<?php echo $CONTENT_SITE_PATH ?>/css/font-awesome.min.css">
    <!-- fontello css -->
    <link rel="stylesheet" href="<?php echo $CONTENT_SITE_PATH ?>/css/fontello.css">
    <!-- latofonts css -->
    <link rel="stylesheet" href="<?php echo $CONTENT_SITE_PATH ?>/css/latofonts.css">
    <!-- style css -->
    <link rel="stylesheet" href="<?php echo $CONTENT_SITE_PATH ?>/style.css">
    <!-- responsive css -->
    <link rel="stylesheet" href="<?php echo $CONTENT_SITE_PATH ?>/css/responsive.css">
    <!-- modernizr js -->
    <script src="<?php echo $CONTENT_SITE_PATH ?>/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>

    <!-- HEADER-AREA START -->
    <header class="header-area">
        <!-- Header-Top Start -->
        <div class="header-top hidden-xs">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-3">
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-9 offset-md-5">
                        <div class="header-top-right">
                            <div class="header-search">
                                <form action="<?php echo $ROOT_URL ?>/search">
                                    <input class="top-search" type="text" name="q" autocomplete="off" placeholder="Tìm kiếm...">
                                    <button type="submit"><i class="pe-7s-search"></i></button>
                                </form>
                            </div>
                            <?php if (isset($_SESSION['account'])) : ?>
                                <?php
                                require_once __DIR__ . "/../../business/database.php";
                                $db = new Database();
                                $sql = "SELECT username FROM profile WHERE account_id = ?";
                                $result = $db->pdo_query_column($sql, $_SESSION['account']['id']);
                                ?>
                                <ul class="top-menu">
                                    <li><a href="<?php echo $ROOT_URL ?>/account/profile"><span><i class="pe-7s-user"></i></span><?php echo $result ? $result[0] : "Tài Khoản" ?></a></li>
                                </ul>
                                <ul class="top-menu">
                                    <li><a href="<?php echo $ROOT_URL ?>/sign-out"><span></span>Đăng Xuất</a></li>
                                </ul>
                            <?php else : ?>
                                <ul class="top-menu">
                                    <li><a href="<?php echo $ROOT_URL ?>/forgot-password"><span><i class="pe-7s-key"></i></span>Quên Mật Khẩu</a></li>
                                </ul>
                                <ul class="top-menu">
                                    <li><a href="<?php echo $ROOT_URL ?>/sign-in"><span><i class="pe-7s-key"></i></span>Đăng Nhập</a></li>
                                </ul>
                                <ul class="top-menu">
                                    <li><a href="<?php echo $ROOT_URL ?>/register"><span><i class="pe-7s-lock"></i></span>Đăng Ký</a></li>
                                </ul>
                            <?php endif ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header-Top End -->
        <!-- Header Start -->
        <div class="header">
            <div class="container">
                <div class="row">
                    <!-- Logo Start -->
                    <div class="col-md-2 col-sm-6">
                        <div class="logo" style="height:130px;line-height:65px">
                            <a href="<?php echo $ROOT_URL ?>">VNH-Ecommerce</a>
                        </div>
                    </div>
                    <!-- Logo End -->
                    <!-- MainMenu Start -->
                    <?php include_once __DIR__ . "/menu.php"; ?>
                    <!-- MainMenu End -->
                    <!-- Cart-Total Start -->
                    <?php if (isset($_SESSION['account']) && $_SERVER["REQUEST_URI"] !== "$ROOT_URL/checkout") : ?>
                        <?php
                        require_once "./business/shopping_cart.php";
                        $cart = new Shopping_cart();
                        $cart->account_id = $_SESSION['account']['id'];
                        $items = $cart->get_all_items();
                        $total_items = 0;
                        $subtotal = 0;
                        foreach ($items as $item) {
                            $total_items += $item['quantity'];
                            $subtotal += $item['quantity'] * $item['unit_price'];
                        }

                        ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="cart-total">
                                <ul>
                                    <li>
                                        <a href="<?php echo $ROOT_URL ?>/shopping-cart">
                                            <span class="cart-icon"><i class="pe-7s-cart"></i><sup><?php echo $total_items >= 10 ? $total_items : "0" . $total_items ?></sup></span>
                                            <span class="cart-brief"><?php echo number_format($subtotal, 0, "", ".") . " đ" ?></span>
                                        </a>
                                        <div class="mini-cart-content">
                                            <div class="mini-cart-body">
                                                <?php if (count($items) > 0) : ?>
                                                    <?php foreach ($items as $item) : ?>
                                                        <?php
                                                        $db = new Database();
                                                        $sql = "SELECT name,slug FROM product WHERE id = ?";
                                                        $product_info = $db->pdo_query_one($sql, $item['product_id']);
                                                        ?>
                                                        <div class="cart-img-details">
                                                            <div class="cart-img-photo">
                                                                <a href="<?php echo "$ROOT_URL/product/{$product_info['slug']}" ?>"><img src="<?php echo preg_replace("/\/colors\//", "/color_images/", $item['color']) ?>"></a>
                                                            </div>
                                                            <div class="cart-img-content">
                                                                <h4><a href="<?php echo "$ROOT_URL/product/{$product_info['slug']}" ?>"><?php echo $product_info['name'] ?></a></h4>
                                                                <span><?php echo number_format($item['unit_price'], 0, "", ".") . " x " . $item['quantity'] . " (size: " . $item['size'] . ")"  ?></span>
                                                            </div>
                                                            <div class="pro-del" data-id="<?php echo $item['id'] ?>">
                                                                <a href="javascript:void(0)"><i class="pe-7s-trash"></i></a>
                                                            </div>
                                                        </div>

                                                    <?php endforeach ?>
                                                <?php else : ?>
                                                    <h3>Không có sản phẩm trong giỏ hàng!</h3>
                                                <?php endif ?>
                                            </div>
                                            <?php if (count($items) > 0) : ?>
                                                <div class="cart-inner-bottom">
                                                    <a href="<?php echo $ROOT_URL ?>/shopping-cart" class="cart-button-top cart-left">Xem Giỏ Hàng</a>
                                                    <a href="<?php echo $ROOT_URL ?>/checkout" class="cart-button-top">Thanh Toán</a>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>
                    <!-- Cart-Total End -->
                </div>
            </div>
        </div>
        <!-- Header END -->
    </header>
    <!-- HEADER-AREA END -->
    <?php if (isset($_SESSION['account'])) : ?>
        <script>
            const items = <?php echo json_encode($items) ?>;
        </script>
    <?php endif ?>