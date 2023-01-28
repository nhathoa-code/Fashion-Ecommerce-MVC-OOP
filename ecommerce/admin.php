<?php
include_once "config.php";
$page = isset($_GET['page']) ? $_GET['page'] : "";
$_SESSION['admin_url'] = $_SERVER['REQUEST_URI'];
switch ($page) {
    case "category":
        require_once "business/category.php";
        $category = new category();
        $category->init();
        break;
    case "size_type":
        require_once "business/size_type.php";
        $size_type = new SizeType();
        $size_type->init();
        break;
    case "size_type_value":
        require_once "business/size_type_value.php";
        $size_type_value = new SizeTypeValue();
        $size_type_value->init();
        break;
    case "product_color":
        require_once "business/product_color.php";
        $product_color = new ProductColor();
        $product_color->init();
        break;
    case "product_list":
        $VIEW = "admin/view/product/product_list.php";
        require_once "business/product.php";
        $product = new product();
        $total_products = count($product->product_get_all());
        $products_per_page = 5;
        $current_page = isset($_GET['current_page']) ? $_GET['current_page'] : 1;
        $products = $product->product_get_limit($products_per_page, $current_page);
        break;
    case "add_product_form":
        $VIEW = "admin/view/product/product_add_form.php";
        break;
    case "product_edit_form":
        require_once "business/product.php";
        $product = new product();
        $product->init();
        break;
    case "order_list":
        require_once "business/order.php";
        break;
    case "order_detail":
        require_once "business/order.php";
        break;
    case "review":
        require_once "business/review.php";
        break;
    case "review_detail":
        require_once "business/review.php";
        break;
    case "slider_list":
        require_once "business/slider.php";
        $slider = new Slider();
        $slider->init();
        break;
    case "statistic":
        require_once "business/statistic.php";
        $statistic = new Statistic();
        $VIEW = "admin/index.php";
        break;
    default:
        header("location:?page=statistic");
}

include_once "admin/layout.php";
