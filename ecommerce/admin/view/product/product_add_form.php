<style>
    ul li {
        list-style-type: none;
    }

    img {
        width: 160px;
        height: 12px;
    }

    li.color img {
        width: 50px;
        height: auto;
    }

    ul.color_images img {
        width: 70px;
        height: auto;
    }

    li.color .btn-sm {
        padding: 3px 7px;
        font-size: 10px;
        line-height: 0.75;
    }

    #page-content {
        position: relative;
    }

    #overlay {
        display: none;
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        z-index: 99;
    }

    #overlay p {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%);
        font-size: x-large;
        background-color: white;
    }
</style>
<div id="overlay">
    <p>Đợi chút,đang tải dữ liệu lên máy chủ...</p>
</div>
<form enctype="multipart/form-data" id="form" class="form-horizontal form-box">
    <div class="form-group">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-normal">Tên sản phẩm</label>
                <div class="col-md-5">
                    <input type="text" name="name" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-normal">Giá</label>
                <div class="col-md-5">
                    <input type="number" name="price" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-input-normal">Giảm giá</label>
                <div class="col-md-5">
                    <input type="number" name="discounted_price" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-file">Ảnh</label>
                <div class="col-md-6">
                    <input id="image" type="file" name="image" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-file"></label>
                <div class="col-md-6">
                    <ul class="thumbnails clearfix image">
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-file">Bộ sưu tập</label>
                <div class="col-md-6">
                    <input id="gallery" type="file" multiple class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-file"></label>
                <div class="col-md-10">
                    <ul class="thumbnails clearfix gallery" data-toggle="gallery-options">
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2" for="example-textarea-ckeditor">Mô tả</label>
                <div class="col-md-10">
                    <textarea class="ckeditor" id="description"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-10 col-md-offset-2">
                    <button class="btn btn-success"><i class="fa fa-floppy-o"></i> Lưu</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h4 class="form-box-header">Danh mục</h4>
            <div id="product_category">
                <?php
                require_once "business/category.php";
                $category = new category();
                $categories_array = $category->category_get_all();
                $categories = array();
                foreach ($categories_array as $item) {
                    $item_object = new category();
                    $item_object->category_id = $item['category_id'];
                    $item_object->name = $item['name'];
                    array_push($categories, $item_object);
                }
                $displayed_category = array();
                $category->show_category($categories, $displayed_category);
                ?>
            </div>
            <h4 style="padding:0" class="form-box-header"></h4>
            <div id="new">
                <div class="form-group">
                    <label class="control-label col-md-1"></label>
                    <div class="col-md-10">
                        <div class="checkbox">
                            <label for="checkboxnew">
                                <input type="checkbox" id="checkboxnew" name="new" value="1"> Sản phẩm mới
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="checkboxfeatured">
                                <input type="checkbox" id="checkboxfeatured" name="featured" value="1"> Hiển thị trang chủ
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="form-box-header">Loại kích cỡ</h4>
            <div id="size_types">
                <div class="form-group">
                    <label class="control-label col-md-1"></label>
                    <div class="col-md-4">
                        <?php
                        require_once "business/size_type.php";
                        $size_type = new SizeType();
                        $size_type->show_size_types();
                        ?>
                    </div>
                </div>
            </div>
            <h4 class="form-box-header">Ảnh màu <span style="font-weight: normal;font-size:small">(Ảnh màu và ảnh đại diện tương ứng phải cùng tên file)</span></h4>
            <div class="form-group">
                <div class="col-md-12">
                    <input id="colors" type="file" multiple class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <ul class="thumbnails clearfix colors" data-toggle="gallery-options">
                    </ul>
                </div>
            </div>
            <div class="sizes">
                <div class="form-group">
                    <div class="col-md-12">
                    </div>
                </div>
            </div>
            <h4 class="form-box-header">Ảnh đại diện màu</h4>
            <div class="form-group">
                <div class="col-md-12">
                    <input id="color_images" type="file" multiple class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <ul class="thumbnails clearfix color_images" data-toggle="gallery-options">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>