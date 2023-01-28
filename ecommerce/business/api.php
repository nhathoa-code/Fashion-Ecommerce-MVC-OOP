<?php

$action = $_GET['action'];

switch ($action) {
    case "orders":
        require_once 'database.php';
        $db = new Database();
        $account_id = $_SESSION['account']['id'];
        $sql = "SELECT id,status,shipped_on FROM orders WHERE account_id = ?";
        if (isset($_GET['status']) && $_GET['status'] !== "tất cả") {
            $status = $_GET['status'];
            $sql .= " AND status = ?";
            echo json_encode($db->pdo_query($sql, $account_id, $status));
        } else {
            echo json_encode($db->pdo_query($sql, $account_id));
        }
        break;
    case "order_detail":
        require_once 'database.php';
        $db = new Database();
        $sql = "SELECT order_detail.*,product.name,product.id AS product_id FROM order_detail JOIN product ON order_detail.product_id = product.id WHERE order_id = ?";
        $items = $db->pdo_query($sql, $_GET['order_id']);
        foreach ($items as $key => $item) {
            $sql = "SELECT * FROM review WHERE product_id = ? AND account_id = ?";
            if ($db->pdo_query($sql, $item['product_id'], $_SESSION['account']['id'])) {
                $items[$key]['reviewed'] = true;
            } else {
                $items[$key]['reviewed'] = false;
            }
        }
        echo json_encode($items);
        break;
    case "review_detail":
        require_once 'database.php';
        $db = new Database();
        $sql = "SELECT * FROM review WHERE account_id = ? AND product_id = ?";
        $review = $db->pdo_query_one($sql, $_SESSION['account']['id'], $_GET['product_id']);
        echo json_encode($review);
        break;
    case "profile_detail":
        require_once 'database.php';
        $db = new Database();
        $sql = "SELECT * FROM profile WHERE account_id = ?";
        $profile = $db->pdo_query_one($sql, $_SESSION['account']['id']);
        echo json_encode($profile);
        break;
    case "search_order_by_id":
        require_once 'database.php';
        $db = new Database();
        $sql = "SELECT * FROM orders WHERE id = ?";
        $order = $db->pdo_query_one($sql, $_GET['order_id']);
        echo json_encode($order);
        break;
    case "search_products":
        require_once 'database.php';
        $db = new Database();
        $keywords = $_GET['keywords'];
        $sql = "SELECT * FROM product WHERE id = ? OR name like '%$keywords%'";
        $products = $db->pdo_query($sql, $keywords);
        foreach ($products as $key => $product) {
            extract($product);
            $arr = scandir("../content/images/$dir");
            $image = end($arr);
            $products[$key]['image'] = $image;
        }
        echo json_encode($products);
        break;
    default:
        echo json_encode("hello");
}
