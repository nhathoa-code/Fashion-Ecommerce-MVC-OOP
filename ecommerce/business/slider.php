<?php
require_once __DIR__ . '/database.php';
class Slider extends Database
{
    public $table = "slider";
    public $id, $title, $title1, $content, $button, $link, $image;
    public function init()
    {
        global $VIEW;
        global $sliders;
        $VIEW = "admin/view/slider/slider_list.php";
        $action = isset($_POST['action']) ? $_POST['action'] : "";
        switch ($action) {
            case "add_slider":
                $this->title = $_POST['title'];
                $this->title1 = $_POST['title1'];
                $this->content = $_POST['content'];
                $this->button = $_POST['button'];
                $this->link = $_POST['link'];
                if (!file_exists("../content/images/slider")) {
                    mkdir("../content/images/slider");
                }
                $file_name = $_FILES['image']['name'];
                $this->image = $file_name;
                move_uploaded_file($_FILES['image']['tmp_name'], "../content/images/slider/$file_name");
                $id = $this->slider_insert();
                echo json_encode(array("message" => "Thêm slider thành công", "id" => $id));
                break;
            case "update_slider":
                extract($_POST);
                if ($_FILES['image']['size'] !== 0) {
                    $file_name = $_FILES['image']['name'];
                    $sql = "UPDATE $this->table SET image = ?,title = ?,title1 = ?,content = ?,button = ?,link = ? WHERE id = ?";
                    $this->pdo_execute($sql, $file_name, $title, $title1, $content, $button, $link, $id);
                    unlink("..content/images/slider/" . $old_image);
                    move_uploaded_file($_FILES['image']['tmp_name'], "../content/images/slider/$file_name");
                } else {
                    $sql = "UPDATE $this->table SET title = ?,title1 = ?,content = ?,button = ?,link = ? WHERE id = ?";
                    $this->pdo_execute($sql, $title, $title1, $content, $button, $link, $id);
                }
                echo json_encode(array("message" => "Cập nhật thành công", "image" => isset($file_name) ? $file_name : null));
                break;
            case "delete_slider":
                $this->id = $_POST['id'];
                unlink("../content/images/slider/" . $_POST['image']);
                $this->slider_delete();
                echo "Xóa slider thành công";
                break;
        }
        $sliders = $this->slider_get_all();
    }

    public function slider_get_all()
    {
        $sql = "SELECT * FROM $this->table";
        return $this->pdo_query($sql);
    }

    public function slider_insert()
    {
        $sql = "INSERT INTO $this->table (image,title,title1,content,button,link) values (?,?,?,?,?,?)";
        return $this->pdo_execute($sql, $this->image, $this->title, $this->title1, $this->content, $this->button, $this->link);
    }


    public function slider_delete()
    {
        $sql = "DELETE FROM slider WHERE id = ?";
        return $this->pdo_execute($sql, $this->id);
    }

    public function banner_update_image($image, $banner_id)
    {
        $sql = "UPDATE $this->table SET image = ? WHERE id = ?";
        $this->pdo_execute($sql, $image, $banner_id);
    }
}

$slider = new Slider();
$slider->init();
