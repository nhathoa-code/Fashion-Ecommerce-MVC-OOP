<?php
require_once "config.php";
$page = isset($_GET['page']) ? $_GET['page'] : "";
if ($page !== "sign-out" && $page !== "sign-in" && $page !== "retrieve-success") {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
}
switch ($page) {
    case "single":
        require_once "business/product.php";
        require_once "business/review.php";
        $product_ob = new product();
        $review = new review();
        $product_ob->slug = isset($_GET['slug']) ? $_GET['slug'] : "";
        $product = $product_ob->product_get_one_by_slug();
        if (!$product) {
            die("không tìm thấy sản phẩm nào !");
        }
        $product_ob->id = $product['id'];
        $sizes = $product_ob->product_get_size_type_values();
        $reviews = $review->reviews_get_all_by_product($product['id']);
        extract($product);
        $VIEW = "site/view/single.php";
        break;
    case "shopping-cart":
        if (!isset($_SESSION['account'])) {
            header("location:$ROOT_URL/sign-in");
            break;
        }
        $VIEW = "site/view/shopping_cart.php";
        break;
    case "checkout":
        if (!isset($_SESSION['account'])) {
            header("location:$ROOT_URL/sign-in");
            break;
        }
        require_once "business/shopping_cart.php";
        $shopping_cart = new Shopping_cart();
        $shopping_cart->account_id = $_SESSION['account']['id'];
        $items = $shopping_cart->get_all_items();
        $VIEW = "site/view/checkout.php";
        break;
    case "register":
        if (isset($_SESSION['account'])) {
            header("location:$ROOT_URL");
            break;
        }
        $VIEW = "site/view/register.php";
        break;
    case "sign-in":
        if (isset($_SESSION['account'])) {
            header("location:$ROOT_URL");
            break;
        }
        $VIEW = "site/view/sign-in.php";
        break;
    case "sign-out":
        unset($_SESSION['account']);
        header("location:" . $_SESSION['url']);
        break;
    case "forgot-password":
        if (isset($_SESSION['account'])) {
            header("location:$ROOT_URL");
            break;
        }
        $VIEW = "site/view/forgot_password.php";
        break;
    case "activate":
        require "site/view/activate.php";
        exit;
    case "retrieve-password":
        if (isset($_SESSION['account'])) {
            header("location:$ROOT_URL");
            break;
        }
        require_once "business/account.php";
        $account = new Account();
        $account->token = isset($_GET['token']) ? $_GET['token'] : "";
        if (!$account->check_token()) {
            die("Token không hợp lệ !");
        }
        $VIEW = "site/view/retrieve_password.php";
        break;
    case "retrieve-success":
        $VIEW = "site/view/retrieve_success.php";
        break;
    case "account/profile":
        if (!isset($_SESSION['account'])) {
            header("location:$ROOT_URL/sign-in");
            break;
        }
        $VIEW = "site/view/profile.php";
        break;
    case "account/order_history":
        if (!isset($_SESSION['account'])) {
            header("location:$ROOT_URL/sign-in");
            break;
        }
        $VIEW = "site/view/order_history.php";
        break;
    case "account/change_pass":
        if (!isset($_SESSION['account'])) {
            header("location:$ROOT_URL/sign-in");
            break;
        }
        $VIEW = "site/view/change_pass.php";
        break;
    case "shop":
        require_once "business/category.php";
        require_once "business/review.php";
        $categories = explode("/", $_GET['category']);
        $category = new category();
        $review_ob = new review();
        $category_id = 0;
        for ($i = 0; $i < count($categories); $i++) {
            if ($i == 0) {
                $sql = "SELECT * FROM category WHERE slug = ?";
                $cat = $category->pdo_query_one($sql, $categories[$i]);
            } else {
                $sql = "SELECT * FROM category WHERE slug = ? AND parent_id = ?";
                $cat = $category->pdo_query_one($sql, $categories[$i], $category_id);
            }
            if (!$cat) {
                $VIEW = "site/view/not-found.php";
                break;
            }
            $category_id = $cat['category_id'];
        }
        if (!$cat) {
            break;
        }
        require_once "business/product.php";
        $product = new product();
        $products = $product->product_get_by_category($category_id);
        $VIEW = "site/view/shop.php";
        break;
    case "search":
        require_once "business/product.php";
        require_once "business/review.php";
        $product = new product();
        $review_ob = new review();
        $q = isset($_GET['q']) ? $_GET['q'] : "";
        $products = $product->search_products($q);
        $VIEW = "site/view/search.php";
        break;
    default:
        require_once "business/product.php";
        require_once "business/slider.php";
        require_once "business/review.php";
        $review_ob = new review();
        $product_ob = new product();
        $slider = new Slider();
        $products = $product_ob->get_featured_products();
        $sliders = $slider->slider_get_all();
        $VIEW = "site/view/index.php";
}

include_once "site/layout.php";
