<?php
require_once __DIR__ . '/database.php';
class ProductColor extends Database
{
    protected $color_group_id;
    protected $name;
    protected $table = "product_color";
    public function init()
    {
        global $VIEW;
        global $color_groups;
        $VIEW = "admin/templates/color_group/color_group_list.php";
        $action = "";
        $color_group_id = null;
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 6) == "submit") {
                $last_underscore = strrpos($key, '_');
                $action = substr($key, strlen('submit_'), $last_underscore - strlen('submit_'));
                $color_group_id = substr($key, $last_underscore + 1);
                break;
            }
        }
        switch ($action) {
            case "add_color_group":
                $this->name = $_POST['color_group_name'];
                $this->color_group_insert();
                break;
            case "delete_color_group":
                $this->color_group_id = $color_group_id;
                $this->color_group_delete();
                break;
            case "edit_color_group":
                global $color_group_ID;
                $color_group_ID = $color_group_id;
                $VIEW = "admin/templates/color_group/color_group_edit.php";
                break;
            case "update_color_group":
                $this->name = $_POST['color_group_name'];
                $this->color_group_id = $color_group_id;
                $this->color_group_update();
                break;
        }

        $color_groups = $this->color_group_get_all();
    }

    public function color_group_insert()
    {
        $sql = "INSERT INTO $this->table (name) values (?)";
        $this->pdo_execute($sql, $this->name);
    }

    public function color_group_get_all()
    {
        $sql = "SELECT * FROM $this->table";
        return $this->pdo_query($sql);
    }

    public function color_group_delete()
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->pdo_execute($sql, $this->color_group_id);
    }

    public function color_group_update()
    {
        $sql = "UPDATE $this->table SET name = ? WHERE id = ?";
        $this->pdo_execute($sql, $this->name, $this->color_group_id);
    }
}
