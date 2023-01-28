<?php
require_once __DIR__ . '/database.php';
class Order extends Database
{
    public $table = "orders";
    public $account_id, $status, $pay_status, $payment, $note, $fullname, $address, $phone_number, $email, $subtotal, $order_id, $product_id, $quantity, $unit_price, $size, $color, $id;
    public function init()
    {
        global $VIEW;
        global $orders;
        global $order_details;
        global $order;
        $action = isset($_POST['action']) ? $_POST['action'] : "";
        switch ($action) {
            case "add_order":
                $this->account_id = $_SESSION['account']['id'];
                $this->status = "Đang xử lý";
                $this->pay_status = "Chưa thanh toán";
                $this->payment = $_POST['payment'];
                $this->note = $_POST['ghi_chu'];
                $this->fullname = $_POST['ho_ten'];
                $this->address = $_POST['dia_chi'] . ", " . $_POST['phuong_xa'] . ", " . $_POST['quan_huyen'] . ", " . $_POST['tinh_thanh'];
                $this->email = $_POST['email'];
                $this->phone_number = $_POST['sdt'];
                if (isset($_POST['save_profile'])) {
                    $db = new Database();
                    $sql = "INSERT INTO profile (account_id,fullname,email,phone,address) values (?,?,?,?,?)";
                    $db->pdo_execute($sql, $_SESSION['account']['id'], $_POST['ho_ten'], $_POST['email'], $_POST['sdt'], json_encode(array("dia_chi" => $_POST['dia_chi'], "phuong_xa" => $_POST['phuong_xa'], "quan_huyen" => $_POST['quan_huyen'], "tinh_thanh" => $_POST['tinh_thanh'])));
                }
                require_once "shopping_cart.php";
                $shopping_cart = new Shopping_cart();
                $shopping_cart->account_id = $_SESSION['account']['id'];
                $amount = 0;
                foreach ($shopping_cart->get_all_items() as $item) {
                    extract($item);
                    $amount += $quantity * $unit_price;
                }
                $this->subtotal = $amount;
                $this->order_id = $this->order_insert();
                foreach ($shopping_cart->get_all_items() as $item) {
                    extract($item);
                    $this->product_id = $product_id;
                    $this->quantity = $quantity;
                    $this->unit_price = $unit_price;
                    $this->size = $size;
                    $this->color = $color;
                    $this->order_detail_insert();
                }
                $shopping_cart->clear($_SESSION['account']['id']);
                if ($_POST['payment'] == "VNPay") {
                    require_once "vnpay/vnpay_create_payment.php";
                } else {
                    header("location:../site/view/order_success.php");
                }
                break;
            case "update_status":
                $this->id = $this->order_id = $_POST['order_id'];
                $this->status = $_POST['status'];
                $this->pay_status = str_replace("Chưa thanh toán", "Đã thanh toán", $this->order_get_one()['pay_status']);
                $this->order_update_status();
                echo "Đã cập nhật trạng thái đơn hàng";
                break;
            case "cancel_order":
                $this->id = $_POST['order_id'];
                $this->order_cancel();
                echo "Hủy đơn hàng thành công";
                break;
            case "re_order":
                $this->id = $_POST['order_id'];
                $this->order_reorder();
                echo "Mua lại đơn hàng thành công";
                break;
            default:
                if (isset($_GET['page']) && $_GET['page'] == "order_detail") {
                    $this->order_id = $_GET['order_id'];
                    $order_details = $this->order_get_detail();
                    $order = $this->order_get_one($_GET['order_id']);
                    global $order_total;
                    $order_total = 0;
                    foreach ($order_details as $item) {
                        extract($item);
                        $order_total += $quantity * $unit_price;
                    }
                    $VIEW = "admin/view/order/order_detail.php";
                } else {
                    if (isset($_GET['status'])) {
                        $this->status = $_GET['status'];
                        $orders = $this->order_get_all_by_status();
                    } else {
                        $orders = $this->order_get_all();
                    }
                    $VIEW = "admin/view/order/order_list.php";
                }
        }
    }


    public function order_insert()
    {
        $sql = "INSERT INTO orders(account_id,status,pay_status,payment,note,fullname,address,email,phone_number,subtotal) values (?,?,?,?,?,?,?,?,?,?)";
        return $this->pdo_execute($sql, $this->account_id, $this->status, $this->pay_status, $this->payment, $this->note, $this->fullname, $this->address, $this->email, $this->phone_number, $this->subtotal);
    }


    public function order_detail_insert()
    {
        $sql = "INSERT INTO order_detail(order_id,product_id,color,size,quantity,unit_price) values(?,?,?,?,?,?)";
        $this->pdo_execute($sql, $this->order_id, $this->product_id, $this->color, $this->size, $this->quantity, $this->unit_price);
    }


    public function order_get_all()
    {
        $sql = "SELECT * FROM $this->table";
        return $this->pdo_query($sql);
    }

    public function order_get_all_by_status()
    {
        $sql = "SELECT * FROM $this->table WHERE status = ?";
        return $this->pdo_query($sql, $this->status);
    }

    public function order_get_all_by_account()
    {
        $sql = "SELECT id,status FROM $this->table WHERE account_id = ?";
        return $this->pdo_query($sql, $this->account_id);
    }

    public function order_get_detail()
    {
        $sql = "SELECT order_detail.*,product.name,product.id AS product_id FROM order_detail JOIN product ON order_detail.product_id = product.id WHERE order_id = ?";
        return $this->pdo_query($sql, $this->order_id);
    }

    public function order_get_one()
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        return $this->pdo_query_one($sql, $this->order_id);
    }


    public function order_cancel()
    {
        $sql = "UPDATE $this->table SET status = ? WHERE id = ?";
        $this->pdo_execute($sql, "Đã hủy", $this->id);
    }

    public function order_reorder()
    {
        $sql = "UPDATE $this->table SET status = ? WHERE id = ?";
        $this->pdo_execute($sql, "Đang xử lý", $this->id);
    }

    public function order_update_status()
    {
        $sql = "UPDATE $this->table SET status = ?, pay_status = ? ,shipped_on = ? WHERE id = ?";
        $this->pdo_execute($sql, $this->status, $this->status === "Đã giao" ? $this->pay_status : "Chưa thanh toán", $this->status === "Đã giao" ? date("Y-m-d") : null, $this->id);
    }
}


$order = new order();
$order->init();
