<?php
require_once __DIR__ . '/database.php';
class SizeTypeValue extends Database
{
    protected $size_type_value_id;
    protected $value;
    protected $table = "size_value";
    public function init()
    {
        global $VIEW;
        global $size_type_values;
        $VIEW = "admin/view/size_type_value/size_type_value_list.php";
        $action = "";
        $size_type_value_id = null;
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 6) == "submit") {
                $last_underscore = strrpos($key, '_');
                $action = substr($key, strlen('submit_'), $last_underscore - strlen('submit_'));
                $size_type_value_id = substr($key, $last_underscore + 1);
                break;
            }
        }
        switch ($action) {
            case "add_size_type_value":
                $this->value = $_POST['size_type_value'];
                $this->size_type_value_insert($_GET['size_type_id']);
                break;
            case "delete_size_type_value":
                $this->size_type_value_id = $size_type_value_id;
                $this->size_type_value_delete();
                break;
            case "edit_size_type_value":
                global $size_type_value_ID;
                $size_type_value_ID = $size_type_value_id;
                $VIEW = "admin/view/size_type_value/size_type_value_edit.php";
                break;
            case "update_size_type_value":
                $this->value = $_POST['size_type_value'];
                $this->size_type_value_id = $size_type_value_id;
                $this->size_type_value_update();
                break;
        }

        $size_type_values = $this->size_type_value_get_all($_GET['size_type_id']);
    }

    public function size_type_value_insert($size_type_id)
    {
        $sql = "INSERT INTO $this->table (value,size_type_id) values (?,?)";
        $this->pdo_execute($sql, $this->value, $size_type_id);
    }

    public function size_type_value_get_all($size_type_id)
    {
        $sql = "SELECT * FROM $this->table WHERE size_type_id = ?";
        return $this->pdo_query($sql, $size_type_id);
    }

    public function get_color_sizes($product_id, $image_color)
    {
        $sql = "SELECT * FROM product_color WHERE product_id = ? AND image_color = ?";
        return $this->pdo_query($sql, $product_id, $image_color);
    }

    public function size_type_value_delete()
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->pdo_execute($sql, $this->size_type_value_id);
    }

    public function size_type_value_update()
    {
        $sql = "UPDATE $this->table SET value = ? WHERE id = ?";
        $this->pdo_execute($sql, $this->value, $this->size_type_value_id);
    }
}

if (isset($_POST['ajax_request'])) {
    $size_type_value = new SizeTypeValue();
    echo json_encode($size_type_value->size_type_value_get_all($_POST['size_type_id']));
}
if (isset($_POST['get_color_sizes'])) {
    $size_type_value = new SizeTypeValue();
    echo json_encode($size_type_value->get_color_sizes($_POST['product_id'], $_POST['image_color']));
}
