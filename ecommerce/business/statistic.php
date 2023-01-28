<?php
require_once __DIR__ . '/database.php';
class Statistic extends Database
{
    public $time;
    public function __construct()
    {
        parent::__construct();
        $this->time = date("Y-m-d", strtotime("-1 month"));
    }

    public function total_users()
    {
        if (isset($_GET['time']) && $_GET['time'] !== "") {
            $time_range = explode(" - ", $_GET['time']);
            $from = date("Y-m-d", strtotime($time_range[0]));
            $to = date("Y-m-d", strtotime($time_range[0]));
            $sql = "SELECT count(*) as total_users FROM account WHERE created_on >= $from AND created_on <= $to";
        } else {
            $sql = "SELECT count(*) as total_users FROM account WHERE created_on >= $this->time";
        }

        return $this->pdo_query_value($sql);
    }

    public function total_paid_orders()
    {
        if (isset($_GET['time']) && $_GET['time'] !== "") {
            $time_range = explode(" - ", $_GET['time']);
            $from = date("Y-m-d", strtotime($time_range[0]));
            $to = date("Y-m-d", strtotime($time_range[0]));
            $sql = "SELECT * FROM orders WHERE pay_status like 'Đã thanh toán%' AND created_on >= $from AND created_on <= $to";
        } else {
            $sql = "SELECT * FROM orders WHERE pay_status like 'Đã thanh toán%' AND created_on >= $this->time";
        }
        return $this->pdo_query($sql);
    }

    public function total_orders()
    {
        if (isset($_GET['time']) && $_GET['time'] !== "") {
            $time_range = explode(" - ", $_GET['time']);
            $from = date("Y-m-d", strtotime($time_range[0]));
            $to = date("Y-m-d", strtotime($time_range[0]));
            $sql = "SELECT count(*) as total_users FROM orders WHERE created_on >= $from AND created_on <= $to AND status != 'Đã hủy'";
        } else {
            $sql = "SELECT count(*) as total_orders FROM orders WHERE created_on >= $this->time AND status != 'Đã hủy'";
        }
        return $this->pdo_query_value($sql);
    }

    public function total_new_orders()
    {
        $sql = "SELECT * FROM orders WHERE status = ?";
        return $this->pdo_query($sql, "Đang xử lý");
    }
}
