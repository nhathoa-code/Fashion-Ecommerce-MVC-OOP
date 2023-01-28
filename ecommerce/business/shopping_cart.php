<?php
require_once __DIR__ . '/database.php';
class Shopping_cart extends Database
{
    public $table = "shopping_cart";
    public $id, $name, $description, $category_id, $account_id, $product_id, $quantity, $unit_price, $size, $color;
    public function init()
    {
        $action = isset($_POST['action']) ? $_POST['action'] : "";
        switch ($action) {
            case "add_cart_item":
                if (!isset($_SESSION['account'])) {
                    echo "not signed in";
                } else {
                    $this->account_id = $_SESSION['account']['id'];
                    $this->product_id = $_POST['item_info']['product_id'];
                    $this->quantity = (int) $_POST['item_info']['quantity'];
                    $this->unit_price = (int) $_POST['item_info']['unit_price'];
                    $this->size = $_POST['item_info']['size'];
                    $this->color = $_POST['item_info']['color'];
                    if ($this->is_item_existed()) {
                        $this->id = $this->is_item_existed()['id'];
                        $this->item_increase_quantity($this->quantity);
                        echo json_encode(array("message" => "Đã cập nhật số lượng sản phẩm", "id" => $this->id));
                    } else {
                        $id = $this->cart_add_item();
                        echo json_encode(array("message" => "Sản phẩm đã được thêm vào giỏ hàng", "id" => $id));
                    }
                }
                break;
            case "delete_cart_item":
                $this->id = $_POST['id'];
                $this->delete_item();
                echo "Đã xóa sản phẩm khỏi giỏ hàng";
                break;
            case "update_item_quantity":
                $this->id = $_POST['id'];
                $this->item_update_quantity($_POST['quantity']);
                break;
        }
    }


    public function cart_add_item()
    {
        $sql = "INSERT INTO $this->table (account_id,product_id,quantity,unit_price,size,color) VALUES (?,?,?,?,?,?)";
        return $this->pdo_execute($sql, $this->account_id, $this->product_id, $this->quantity, $this->unit_price, $this->size, $this->color);
    }

    public function clear($account_id)
    {
        $sql = "DELETE FROM $this->table WHERE account_id = ?";
        $this->pdo_execute($sql, $account_id);
    }

    public function is_item_existed()
    {
        $sql = "SELECT * FROM $this->table WHERE account_id = ? AND product_id = ? AND size = ? AND color = ?";
        return $this->pdo_query_one($sql, $this->account_id, $this->product_id, $this->size, $this->color);
    }

    public function cart_get_total_quantity($cart_id)
    {
        $sql = "SELECT * FROM $this->table WHERE cart_id = ?";
        $cart = $this->pdo_query($sql, $cart_id);
        $total_quantity = 0;
        foreach ($cart as $item) {
            $total_quantity += $item['quantity'];
        }
        return $total_quantity;
    }

    public function item_increase_quantity($quantity)
    {
        $sql = "UPDATE $this->table SET quantity = quantity + $quantity WHERE id = ?";
        $this->pdo_execute($sql, $this->id);
    }

    public function item_update_quantity($quantity)
    {
        $sql = "UPDATE $this->table SET quantity = $quantity WHERE id = ?";
        $this->pdo_execute($sql, $this->id);
    }

    public function get_all_items()
    {
        $sql = "SELECT $this->table.*,product.name FROM $this->table JOIN product ON product.id = $this->table.product_id WHERE account_id = ?";
        return $this->pdo_query($sql, $this->account_id);
    }


    public function delete_item()
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->pdo_execute($sql, $this->id);
    }

    public function shopping_cart_update()
    {
        $sql = "UPDATE $this->table SET name = ?, description = ? WHERE category_id = ?";
        $this->pdo_execute($sql, $this->name, $this->description, $this->category_id);
    }
}


$shopping_cart = new shopping_cart();
$shopping_cart->init();
