<?php
require_once __DIR__ . '/database.php';
class Review extends Database
{
    protected $product_id, $account_id, $rate, $content;
    protected $name;
    protected $review;
    protected $rating;
    protected $created_on;
    public $table = "review";
    public function init()
    {
        global $VIEW;
        global $reviews;
        global $review_detail;
        $action = isset($_POST['action']) ? $_POST['action'] : "";
        switch ($action) {
            case "add_review":
                $this->account_id = $_SESSION['account']['id'];
                $this->product_id = $_POST['product_id'];
                $this->rate = $_POST['rate'];
                $sql = "SELECT username FROM profile WHERE account_id = ?";
                $this->name = $this->pdo_query_value($sql, $_SESSION['account']['id']);
                $this->content = $_POST['content'];
                $this->review_insert();
                echo "Đánh giá sản phẩm thành công";
                break;
            case "update_review":
                $this->account_id = $_SESSION['account']['id'];
                $this->product_id = $_POST['product_id'];
                $this->rate = $_POST['rate'];
                $this->name = $_POST['name'];
                $this->content = $_POST['content'];
                $this->review_update();
                echo "Cập nhật đánh giá thành công";
                break;
            case "delete_review":
                $this->review_delete($_POST['review_id']);
                header("location:/du_an_1/admin.php?page=review");
                break;
            default:
                if (isset($_GET['page']) && $_GET['page'] == "review_detail") {
                    global $product;
                    global $customer;
                    $review_detail = $this->review_get_detail($_GET['review_id']);
                    $sql = "SELECT * FROM product WHERE product_id = ?";
                    $product = $this->pdo_query_one($sql, $review_detail['product_id']);
                    $VIEW = "admin/templates/review/review_detail.php";
                } else {
                    $reviews = $this->review_get_all();
                    $VIEW = "admin/templates/review/review_list.php";
                }
        }
    }


    public function review_insert()
    {
        $sql = "INSERT INTO $this->table (account_id,product_id,name,content,rate) values (?,?,?,?,?)";
        return $this->pdo_execute($sql, $this->account_id, $this->product_id, $this->name, $this->content, $this->rate);
    }

    public function review_update()
    {
        $sql = "UPDATE review SET name = ?,content = ?,rate = ? WHERE product_id = ? AND account_id = ?";
        return $this->pdo_execute($sql, $this->name, $this->content, $this->rate, $this->product_id, $this->account_id);
    }

    public function review_delete($review_id)
    {
        $sql = "DELETE FROM $this->table WHERE review_id = ?";
        return $this->pdo_execute($sql, $review_id);
    }

    public function review_get_all()
    {
        $sql = "SELECT * FROM $this->table";
        return $this->pdo_query($sql);
    }

    public function review_get_detail($review_id)
    {
        $sql = "SELECT * FROM $this->table WHERE review_id = ?";
        return $this->pdo_query_one($sql, $review_id);
    }

    public function reviews_get_all_by_product($product_id)
    {
        $sql = "SELECT * FROM $this->table WHERE product_id = ?";
        return $this->pdo_query($sql, $product_id);
    }
}


$review = new Review();
$review->init();
