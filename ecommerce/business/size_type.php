<?php
require_once __DIR__ . '/database.php';
class SizeType extends Database
{
    protected $size_type_id;
    protected $name;
    protected $table = "size_type";
    public function init()
    {
        global $VIEW;
        global $size_types;
        $VIEW = "admin/view/size_type/size_type_list.php";
        $action = "";
        $size_type_id = null;
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 6) == "submit") {
                $last_underscore = strrpos($key, '_');
                $action = substr($key, strlen('submit_'), $last_underscore - strlen('submit_'));
                $size_type_id = substr($key, $last_underscore + 1);
                break;
            }
        }
        switch ($action) {
            case "add_size_type":
                $this->name = $_POST['size_type_name'];
                $this->size_type_insert();
                break;
            case "delete_size_type":
                $this->size_type_id = $size_type_id;
                $this->size_type_delete();
                break;
            case "edit_size_type":
                global $size_type_ID;
                $size_type_ID = $size_type_id;
                $VIEW = "admin/view/size_type/size_type_edit.php";
                break;
            case "update_size_type":
                $this->name = $_POST['size_type_name'];
                $this->size_type_id = $size_type_id;
                $this->size_type_update();
                break;
        }

        $size_types = $this->size_type_get_all();
    }

    public function size_type_insert()
    {
        $sql = "INSERT INTO $this->table (name) values (?)";
        $this->pdo_execute($sql, $this->name);
    }

    public function size_type_get_all()
    {
        $sql = "SELECT * FROM $this->table";
        return $this->pdo_query($sql);
    }

    public function size_type_delete()
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->pdo_execute($sql, $this->size_type_id);
    }

    public function size_type_update()
    {
        $sql = "UPDATE $this->table SET name = ? WHERE id = ?";
        $this->pdo_execute($sql, $this->name, $this->size_type_id);
    }

    public function show_size_types()
    {
        $size_types = $this->size_type_get_all();
        $output = "";
        foreach ($size_types as $size_type) {
            echo "<div class='radio'>
                    <label for='size_type_{$size_type['id']}'>
                        <input type='radio' id='size_type_{$size_type['id']}' name='size_type' value='{$size_type['id']}'> {$size_type['name']}
                    </label>
                </div>";
        }
    }

    public function show_checked_size_type($SizeType)
    {
        $size_types = $this->size_type_get_all();
        $output = "";
        foreach ($size_types as $size_type) {
            if ($size_type['id'] == $SizeType) {
                echo "<div class='radio'>
                    <label for='size_type_{$size_type['id']}'>
                        <input type='radio' checked id='size_type_{$size_type['id']}' name='size_type' value='{$size_type['id']}'> {$size_type['name']}
                    </label>
                </div>";
            } else {
                echo "<div class='radio'>
                    <label for='size_type_{$size_type['id']}'>
                        <input type='radio' id='size_type_{$size_type['id']}' name='size_type' value='{$size_type['id']}'> {$size_type['name']}
                    </label>
                </div>";
            }
        }
    }
}
