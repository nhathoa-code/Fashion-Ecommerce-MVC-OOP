      <div class="col-md-7 hidden-sm hidden-xs">
          <div class="mainmenu" style="float:left">
              <nav>
                  <ul>
                      <?php
                        require_once "business/category.php";
                        $category = new category();
                        $displayed_category = array();
                        $categories_array = $category->category_get_all();
                        $categories = array();
                        foreach ($categories_array as $item) {
                            $item_object = new category();
                            $item_object->category_id = $item['category_id'];
                            $item_object->name = $item['name'];
                            $item_object->slug = $item['slug'];
                            array_push($categories, $item_object);
                        }
                        $category->show_site_category($categories, $displayed_category, $ROOT_URL);
                        ?>
                  </ul>
              </nav>
          </div>
      </div>