<?php if (count($products) > 0) : ?>
    <style>
        table {
            table-layout: fixed;
            width: 100px;
        }

        td {
            word-wrap: break-word !important;
        }

        img {
            width: 100px;
            height: auto;
        }

        .product-search {
            padding: 0;
            margin-bottom: 20px;
            width: 100%;
        }
    </style>
    <div class="col-md-3 product-search">
        <div class="input-group">
            <input type="text" name="keywords" class="form-control" placeholder="Tìm kiếm theo mã sản phẩm hoặc tên sản phẩm">
            <span class="input-group-btn product-search-btn">
                <button class="btn btn-success">Tìm kiếm <i class="fa fa-search"></i></button>
            </span>
        </div>
    </div>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Ảnh</th>
                <th scope="col">Tên</th>
                <th scope="col">Giá</th>
                <th scope="col">Giảm giá</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($products as $product) :
                extract($product);
                $arr = scandir("content/images/$dir");
                $image = end($arr);
            ?>
                <tr>
                    <td>
                        <img src="<?php echo "content/images/$dir/$image" ?>" alt="">
                    </td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo number_format($price, 0, "", "."); ?>đ</td>
                    <td><?php echo number_format($discounted_price, 0, "", "."); ?>đ</td>
                    <td>
                        <form style="float:left;margin-right:5px" action="<?php echo $_SERVER['PHP_SELF'] ?>?page=product_edit_form" method="POST">
                            <input class="btn btn-primary" type="submit" name="submit_edit_product_<?php echo $id ?>" value="sữa">
                        </form>
                        <form style="float:left" onsubmit="return confirm('Bạn thực sự muốn xóa sản phẩm này ?')" action="<?php echo $ROOT_URL ?>/business/product.php" method="POST">
                            <input class="btn btn-danger" type="submit" name="submit_delete_product_<?php echo $id ?>" value="xóa">
                            <input type="hidden" name="delete-product">
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php pagination($products_per_page, $total_products, $current_page, "$ROOT_URL/admin.php?page=product_list"); ?>
<?php else : ?>
    <h3>Danh sách trống</h3>
<?php endif ?>
<div>
    <a href="?page=add_product_form" class="btn btn-primary add-product">Thêm sản phẩm</a>
</div>