<?php
require_once __DIR__ . '/database.php';
class Product extends Database
{
    public $table = "product";
    public $id, $slug, $name, $price, $discounted_price, $description, $dir, $size_type, $new, $featured;
    public function __construct($name = null, $price = null, $discounted_price = null, $description = null, $size_type = null, $dir = null, $new = null, $featured = null)
    {
        parent::__construct();
        $this->name = $name;
        $this->price = $price;
        $this->discounted_price = $discounted_price;
        $this->description = $description;
        $this->dir = $dir;
        $this->size_type = $size_type;
        $this->new = $new;
        $this->featured = $featured;
    }
    public function init()
    {
        global $action;
        global $VIEW;
        global $products;
        global $total_products;
        global $current_page;
        $total_products = count($this->product_get_all());
        $VIEW = "admin/view/product/product_list.php";
        $action = "";
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 6) == "submit") {
                $last_underscore = strrpos($key, '_');
                $action = substr($key, strlen('submit_'), $last_underscore - strlen('submit_'));
                $this->id = substr($key, $last_underscore + 1);
                break;
            }
        }
        switch ($action) {
            case "add_product":
                $this->id = $this->product_insert();
                $this->product_add_size_type();
                if ($_FILES['image']['size'] > 0) {
                    mkdir("../content/images/$this->dir");
                    $file = $_FILES['image']['tmp_name'];
                    $file_name = $_FILES['image']['name'];
                    move_uploaded_file($file, "../content/images/$this->dir/$file_name");
                }
                if (isset($_FILES['gallery'])) {
                    mkdir("../content/images/$this->dir/gallery");
                    for ($i = 0; $i < count($_FILES['gallery']['name']); $i++) {
                        $file = $_FILES['gallery']['tmp_name'][$i];
                        $file_name = $_FILES['gallery']['name'][$i];
                        move_uploaded_file($file, "../content/images/$this->dir/gallery/$file_name");
                    }
                }
                if (isset($_FILES['colors'])) {
                    mkdir("../content/images/$this->dir/colors");
                    for ($i = 0; $i < count($_FILES['colors']['name']); $i++) {
                        $file = $_FILES['colors']['tmp_name'][$i];
                        $file_name = $_FILES['colors']['name'][$i];
                        move_uploaded_file($file, "../content/images/$this->dir/colors/$file_name");
                    }
                }
                if (isset($_FILES['color_images'])) {
                    mkdir("../content/images/$this->dir/color_images");
                    for ($i = 0; $i < count($_FILES['color_images']['name']); $i++) {
                        $file = $_FILES['color_images']['tmp_name'][$i];
                        $file_name = $_FILES['color_images']['name'][$i];
                        move_uploaded_file($file, "../content/images/$this->dir/color_images/$file_name");
                    }
                }

                foreach ($_POST['categories'] as $category_id) {
                    $this->product_category_insert($this->id, $category_id);
                }
                $colors_sizes = json_decode($_POST['colors_sizes']);
                if (count($colors_sizes) > 0) {
                    foreach ($colors_sizes as $item) {
                        $image_name = $item->image_name;
                        sort($item->sizes);
                        foreach ($item->sizes as $size) {
                            $this->product_color_insert($this->id, $image_name, $size);
                        }
                    }
                }
                echo "Thêm sản phẩm thành công";
                break;
            case "delete_product":
                $product = $this->product_get_one_by_id();
                $this->product_delete();
                $dir = $product['dir'];
                $dir_path = "../content/images/$dir";
                $it = new RecursiveDirectoryIterator($dir_path, RecursiveDirectoryIterator::SKIP_DOTS);
                $files = new RecursiveIteratorIterator(
                    $it,
                    RecursiveIteratorIterator::CHILD_FIRST
                );
                foreach ($files as $file) {
                    if ($file->isDir()) {
                        rmdir($file->getRealPath());
                    } else {
                        unlink($file->getRealPath());
                    }
                }
                rmdir($dir_path);
                header("location:" . $_SESSION['admin_url']);
                exit;
                break;
            case "edit_product":
                global $product;
                global $checked_categories;
                global $size_type_id;
                $product = $this->product_get_one_by_id();
                $size_type_id = $this->product_get_size_type();
                $checked_categories = $this->product_get_categories();
                $VIEW = "admin/view/product/product_edit_form.php";
                break;
            case "update_product":
                $product = $this->product_get_one_by_id();
                $dir = $product['dir'];
                $this->product_update();
                $categories = $this->product_get_categories();
                $fullDiff_categories = array_merge(array_diff($_POST['categories'], $categories), array_diff($categories, $_POST['categories']));
                foreach ($fullDiff_categories as $item) {
                    if (in_array($item, $categories)) {
                        $this->product_delete_category($item);
                    } else {
                        $this->product_add_category($item);
                    }
                }
                if ($_FILES['image']['size'] > 0) {
                    $arr = scandir("content/images/$dir");
                    $image = end($arr);
                    unlink("../content/images/$dir/$image");
                    $file = $_FILES['image']['tmp_name'];
                    $name = $_FILES['image']['name'];
                    move_uploaded_file($file, "../content/images/$dir/$name");
                }
                if (isset($_POST['removed_images'])) {
                    $images = explode(",", $_POST['removed_images']);
                    foreach ($images as $image) {
                        unlink("../content/images/$dir/gallery/$image");
                    }
                }
                if (isset($_FILES['uploaded_images'])) {
                    if (!file_exists("../content/images/$dir/gallery")) {
                        mkdir("../content/images/$dir/gallery");
                    }
                    for ($i = 0; $i < count($_FILES['uploaded_images']['name']); $i++) {
                        $file = $_FILES['uploaded_images']['tmp_name'][$i];
                        $file_name = $_FILES['uploaded_images']['name'][$i];
                        move_uploaded_file($file, "../content/images/$dir/gallery/$file_name");
                    }
                }
                if (isset($_POST['removed_colors'])) {
                    $images = explode(",", $_POST['removed_colors']);
                    foreach ($images as $image) {
                        unlink("../content/images/$dir/colors/$image");
                        $this->product_color_delete($image);
                    }
                }
                if (isset($_FILES['colors'])) {
                    if (!file_exists("../content/images/$dir/colors")) {
                        mkdir("../content/images/$dir/colors");
                    }
                    for ($i = 0; $i < count($_FILES['colors']['name']); $i++) {
                        $file = $_FILES['colors']['tmp_name'][$i];
                        $file_name = $_FILES['colors']['name'][$i];
                        move_uploaded_file($file, "../content/images/$dir/colors/$file_name");
                    }
                }
                if (isset($_POST['removed_color_images'])) {
                    $images = explode(",", $_POST['removed_color_images']);
                    foreach ($images as $image) {
                        unlink("../content/images/$dir/color_images/$image");
                    }
                }
                if (isset($_FILES['color_images'])) {
                    if (!file_exists("../content/images/$dir/color_images")) {
                        mkdir("../content/images/$dir/color_images");
                    }
                    for ($i = 0; $i < count($_FILES['color_images']['name']); $i++) {
                        $file = $_FILES['color_images']['tmp_name'][$i];
                        $file_name = $_FILES['color_images']['name'][$i];
                        move_uploaded_file($file, "../content/images/$dir/color_images/$file_name");
                    }
                }
                if (isset($_POST['colors_sizes'])) {
                    $colors_sizes = json_decode($_POST['colors_sizes']);
                    foreach ($colors_sizes as $color_sizes) {
                        $old_sizes = $this->product_color_get_sizes($color_sizes->image_name);
                        $fullDiff_sizes = array_merge(array_diff($color_sizes->sizes, $old_sizes), array_diff($old_sizes, $color_sizes->sizes));
                        foreach ($fullDiff_sizes as $item) {
                            if (in_array($item, $old_sizes)) {
                                $sql = "DELETE FROM product_color WHERE product_id = ? AND image_color = ? AND size_id = ?";
                                $stmt = $this->conn->prepare($sql);
                                $stmt->execute([$this->id, $color_sizes->image_name, $item]);
                            } else {
                                $sql = "INSERT INTO product_color (product_id,image_color,size_id) VALUES (?,?,?)";
                                $stmt = $this->conn->prepare($sql);
                                $stmt->execute([$this->id, $color_sizes->image_name, $item]);
                            }
                        }
                    }
                }
                echo "Cập nhật sản phẩm thành công";
                break;
        }
        $current_page = isset($_GET['current_page']) ? $_GET['current_page'] : 1;
        $products = $this->product_get_limit(5, $current_page);
    }

    public function product_insert()
    {
        $this->slug = strtolower(stripVN(strtolower($this->name)));
        $columns = "name,description,price,discounted_price,dir,slug,new,featured";
        $values = "?,?,?,?,?,?,?,?";
        $sql = "INSERT INTO $this->table ($columns) value ($values)";
        return $this->pdo_execute($sql, $this->name, $this->description, $this->price, $this->discounted_price, $this->dir, $this->slug, $this->new, $this->featured);
    }

    public function product_color_insert($product_id, $image_color, $size_id)
    {
        $sql = "INSERT INTO product_color (product_id,image_color,size_id) values (?,?,?)";
        $this->pdo_execute($sql, $product_id, $image_color, $size_id);
    }

    public function product_color_delete($image_color)
    {
        $sql = "DELETE FROM product_color WHERE product_id = ? AND image_color = ?";
        $this->pdo_execute($sql, $this->id, $image_color);
    }

    public function product_color_get_sizes($image_color)
    {
        $sql = "SELECT size_id FROM product_color WHERE product_id = ? AND image_color = ?";
        return $this->pdo_query_column($sql, $this->id, $image_color);
    }

    public function product_get_limit($products_per_page, $current_page)
    {
        $row_start = ($current_page - 1) * $products_per_page;
        $sql = "SELECT * FROM product ORDER BY id desc LIMIT $row_start, $products_per_page";
        return $this->pdo_query($sql);
    }


    public function product_count_by_category($category_id)
    {
        $sql = "SELECT COUNT(*) AS num  FROM product_category WHERE category_id = ?";
        return $this->pdo_query_one($sql, $category_id);
    }

    public function product_category_insert($product_id, $category_id)
    {
        $sql = "INSERT INTO product_category (product_id,category_id) values (?,?)";
        $this->pdo_execute($sql, $product_id, $category_id);
    }

    public function product_get_one_by_id()
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        return $this->pdo_query_one($sql, $this->id);
    }

    public function product_get_one_by_slug()
    {
        $sql = "SELECT * FROM $this->table WHERE slug = ?";
        return $this->pdo_query_one($sql, $this->slug);
    }

    public function product_get_all()
    {
        $sql = "SELECT * FROM $this->table";
        return $this->pdo_query($sql);
    }

    public function get_featured_products()
    {
        $sql = "SELECT * FROM $this->table WHERE featured = ?";
        return $this->pdo_query($sql, 1);
    }

    public function product_get_by_category($category_id)
    {
        $sql = "SELECT p.* FROM product_category AS pc JOIN product AS p ON p.id = pc.product_id WHERE pc.category_id = ?";
        return $this->pdo_query($sql, $category_id);
    }

    public function product_get_categories()
    {
        $sql = "SELECT category_id FROM product_category WHERE product_id = ?";
        return $this->pdo_query_column($sql, $this->id);
    }

    public function product_add_category($category_id)
    {
        $sql = "INSERT INTO product_category (product_id,category_id) values (?,?)";
        $this->pdo_execute($sql, $this->id, $category_id);
    }


    public function product_add_size_type()
    {
        $sql = "INSERT INTO product_size_type (product_id,size_type_id) values (?,?)";
        $this->pdo_execute($sql, $this->id, $this->size_type);
    }

    public function product_get_size_type_values()
    {
        $sql = "SELECT size_value.id,size_value.value FROM product_size_type JOIN size_value ON size_value.size_type_id = product_size_type.size_type_id WHERE product_id = ?";
        return $this->pdo_query($sql, $this->id);
    }

    public function product_update_size_type()
    {
        $sql = "UPDATE product_size_type SET size_type_id = ? WHERE product_id = ?";
        $this->pdo_execute($sql, $this->size_type, $this->id);
    }

    public function product_get_size_type()
    {
        $sql = "SELECT size_type_id FROM product_size_type WHERE product_id = ?";
        return $this->pdo_query_value($sql, $this->id);
    }


    public function product_delete_category($category_id)
    {
        $sql = "DELETE FROM product_category WHERE product_id = ? AND category_id = ?";
        $this->pdo_execute($sql, $this->id, $category_id);
    }

    public function product_delete()
    {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $this->pdo_execute($sql, $this->id);
    }

    public function search_products($q)
    {
        $sql = "SELECT * FROM product WHERE name like '%$q%'";
        return $this->pdo_query($sql);
    }

    public function product_update()
    {
        $this->slug = strtolower(stripVN(strtolower($this->name)));
        $sql = "UPDATE $this->table SET ";
        $columns = array(
            "name",
            "description",
            "price",
            "discounted_price",
            "slug",
            "new",
            "featured"
        );
        $last_column = end($columns);
        foreach ($columns as $column) {
            if ($column == $last_column) {
                $sql .= "$column = ?";
            } else {
                $sql .= "$column = ?,";
            }
        }
        $sql .= " WHERE id = ?";
        return $this->pdo_execute($sql, $this->name, $this->description, $this->price, $this->discounted_price, $this->slug, $this->new, $this->featured, $this->id);
    }
}

if (isset($_POST['ajax_request'])) {
    $product = new product($_POST['name'], $_POST['price'], $_POST['discounted_price'] ? $_POST['discounted_price'] : 0, $_POST['description'], $_POST['size_type'], time(), isset($_POST['new']) ? $_POST['new'] : 0, isset($_POST['featured']) ? $_POST['featured'] : 0);
    $product->init();
}

if (isset($_POST['delete-product'])) {
    $product = new product();
    $product->init();
}
