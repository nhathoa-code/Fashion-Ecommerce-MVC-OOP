<?php
require_once __DIR__ . '/database.php';
class Category extends database
{
    public $category_id;
    public $name, $slug;
    public $table = "category";
    public function init()
    {
        global $VIEW;
        global $categories;
        $VIEW = "admin/view/category/category_list.php";
        $action = "";
        $category_id = null;
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 6) == "submit") {
                $last_underscore = strrpos($key, '_');
                $action = substr($key, strlen('submit_'), $last_underscore - strlen('submit_'));
                $category_id = substr($key, $last_underscore + 1);
                break;
            }
        }
        switch ($action) {
            case "add_category":
                $this->name = $_POST['category_name'];
                $this->slug = strtolower(stripVN(($_POST['category_name'])));
                if (isset($_GET['parent_id'])) {
                    $this->subcategory_insert($_GET['parent_id']);
                } else {
                    $this->category_insert();
                }
                break;
            case "delete_category":
                $this->category_id = $category_id;
                $this->category_delete();
                break;
            case "edit_category":
                global $category_ID;
                $category_ID = $category_id;
                $VIEW = "admin/view/category/category_edit.php";
                break;
            case "update_category":
                $this->name = $_POST['category_name'];
                $this->slug = strtolower(stripVN(($_POST['category_name'])));
                $this->category_id = $category_id;
                $this->category_update();
                break;
        }

        if (isset($_GET['parent_id'])) {
            $categories = $this->subcategory_get_all($_GET['parent_id']);
        } else {
            $categories = $this->parent_category_get_all();
        }
    }


    public function category_insert()
    {
        $sql = "INSERT INTO $this->table (name,slug) values (?,?)";
        $this->pdo_execute($sql, $this->name, $this->slug);
    }

    public function subcategory_insert($parent_id)
    {
        $sql = "INSERT INTO $this->table (name,slug,parent_id) values (?,?,?)";
        $this->pdo_execute($sql, $this->name, $this->slug, $parent_id);
    }

    public function category_get_all()
    {
        $sql = "SELECT * FROM $this->table";
        return $this->pdo_query($sql);
    }

    public function category_get_origin()
    {
        $sql = "SELECT * FROM $this->table WHERE parent_id = ?";
        return $this->pdo_query($sql, 0);
    }

    public function parent_category_get_all()
    {
        $sql = "SELECT * FROM $this->table WHERE parent_id = 0";
        return $this->pdo_query($sql);
    }

    public function subcategory_get_all($parent_id)
    {
        $sql = "SELECT * FROM $this->table WHERE parent_id = ?";
        return $this->pdo_query($sql, $parent_id);
    }

    public function category_delete()
    {
        $sql = "DELETE FROM $this->table WHERE category_id = ?";
        $this->pdo_execute($sql, $this->category_id);
        if ($this->hasChildren()) {
            $categories = $this->getChildren();
            foreach ($categories as $category) {
                $category->category_delete();
            }
        }
    }

    public function category_update()
    {
        $sql = "UPDATE $this->table SET name = ?,slug = ? WHERE category_id = ?";
        $this->pdo_execute($sql, $this->name, $this->slug, $this->category_id);
    }

    public function category_update_image($image, $category_id)
    {
        $sql = "UPDATE $this->table SET image = ? WHERE category_id = ?";
        $this->pdo_execute($sql, $image, $category_id);
    }

    public function hasChildren()
    {
        if (count($this->subcategory_get_all($this->category_id)) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getChildren()
    {
        $categories_array = $this->subcategory_get_all($this->category_id);
        $categories = array();
        foreach ($categories_array as $item) {
            $category = new category();
            $category->category_id = $item['category_id'];
            $category->name = $item['name'];
            $category->slug = $item['slug'];
            array_push($categories, $category);
        }
        return $categories;
    }

    public function show_category($categories, &$displayed_category)
    {
        echo "<ul>";
        foreach ($categories as $category) {
            if (array_key_exists($category->category_id, $displayed_category)) {
                continue;
            }
            echo "<li>";
            echo "<div class='checkbox'>
                    <label class='form-check-label' for='$category->category_id'>
                    <input class='form-check-input' type='checkbox' value='$category->category_id' name='categories[]' id='$category->category_id'>$category->name</label>
                  </div>";
            $displayed_category[$category->category_id] = "";
            if ($category->hasChildren()) {
                $category->show_category($category->getChildren(), $displayed_category);
            }
            echo "</li>";
        }
        echo "</ul>";
    }

    public function show_site_category($categories, &$displayed_category, $ROOT_URL)
    {
        global $parent_category;
        foreach ($categories as $category) {
            if (array_key_exists($category->category_id, $displayed_category)) {
                continue;
            }
            $displayed_category[$category->category_id] = "";
            if ($category->hasChildren()) {
                $parent_category = $category->slug;
                echo "<li><a href='$ROOT_URL/$category->slug'>$category->name</a>";
                echo "<div class='megamenu'>";
                echo "<div class='mega-top'>";
                $children_cats_l2 = $category->getChildren();
                foreach ($children_cats_l2 as $cat_l2) {
                    echo "<span><a class='mega-menu-title' href='$ROOT_URL/$category->slug/$cat_l2->slug'>$cat_l2->name</a>";
                    $displayed_category[$cat_l2->category_id] = "";
                    if ($cat_l2->hasChildren()) {
                        $children_cats_l3 = $cat_l2->getChildren();
                        foreach ($children_cats_l3 as $cat_l3) {
                            $displayed_category[$cat_l3->category_id] = "";
                            echo "<a href='$ROOT_URL/$category->slug/$cat_l2->slug/$cat_l3->slug'>$cat_l3->name</a>";
                        }
                    }
                    echo "</span>";
                }
                echo "</div>";
                echo "</div>";
                echo "</li>";
            } else {
                $url = "$category->slug";
                echo "<li><a href='$ROOT_URL/$url'>$category->name</a></li>";
            }
        }
    }

    public function show_checked_category($categories, &$displayed_category, $checked_categories)
    {
        echo "<ul>";
        foreach ($categories as $category) {
            if (array_key_exists($category->category_id, $displayed_category)) {
                continue;
            }
            echo "<li>";
            if (in_array($category->category_id, $checked_categories)) {
                echo "<div class='checkbox'>
                    <label class='form-check-label' for='$category->category_id'>
                    <input class='form-check-input' checked type='checkbox' value='$category->category_id' name='categories[]' id='$category->category_id'>$category->name</label>
                  </div>";
            } else {
                echo "<div class='checkbox'>
                    <label class='form-check-label' for='$category->category_id'>
                    <input class='form-check-input' type='checkbox' value='$category->category_id' name='categories[]' id='$category->category_id'>$category->name</label>
                  </div>";
            }

            $displayed_category[$category->category_id] = "";
            if ($category->hasChildren()) {
                $category->show_checked_category($category->getChildren(), $displayed_category, $checked_categories);
            }
            echo "</li>";
        }
        echo "</ul>";
    }
}
