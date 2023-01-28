<?php
// var_dump($review_detail);
// echo "<br>";
// var_dump($product);
// echo "<br>";
// var_dump($customer);
// exit;
?>
<div class="row mb-3">
    <h3 class="col-3">Mã đánh giá:</h3>
    <h3 class="col-6"><?php echo $review_detail['review_id'] ?></h3>
</div>
<div class="row mb-3">
    <h4 class="col-3">Tên người đánh giá:</h3>
        <h6 class="col-6"><?php echo $review_detail['name']  ?></h6>
</div>
<div class="row mb-3">
    <h4 class="col-3">Nội dung đánh giá:</h3>
        <h6 class="col-6"><?php echo $review_detail['review'] ?></h6>
</div>
<div class="row mb-3">
    <h4 class="col-3">Mức độ đánh giá:</h3>
        <div class="text-primary mb-2 col-6 review1">
            <?php
            for ($i = 0; $i <= 4; $i++) {
                if (($i + 1) <= (int)$review_detail['rating']) {
                    echo "<i class='fas fa-star mr-1'></i>";
                } else {
                    echo "<i class='far fa-star mr-1'></i>";
                }
            }
            ?>
        </div>

</div>
<div class="row mb-3">
    <h4 class="col-3">Ngày đánh giá:</h3>
        <h6 class="col-6"><?php echo date("d-m-Y", strtotime($review_detail['created_on'])); ?></h6>
</div>
<div class="row mb-3">
    <h4 class="col-3">Trạng thái:</h3>
        <h6 class="col-6"><?php echo (int)$review_detail['isApprove'] == 1 ? "Đã duyệt" : "Chưa duyệt" ?></h6>
</div>
<h3 class="mb-3">Đánh giá cho sản phẩm:</h3>
<div class="row mb-3">
    <h4 class="col-3">Mã sản phẩm:</h3>
        <h6 class="col-6"><?php echo $review_detail['product_id'] ?></h6>
</div>
<div class="row mb-3">
    <h4 class="col-3">Tên sản phẩm:</h3>
        <h6 class="col-6"><?php echo $product['name'] ?></h6>
</div>
<div class="row mb-3">
    <h4 class="col-3">Ảnh sản phẩm:</h3>
        <div class="col-6">
            <?php
            $image = $product['image'];
            ?>
            <img style="width:100px;height:auto" src="<?php echo "content/images/$image"; ?>" alt="">
        </div>
</div>
<input type="hidden" name="url" value="<?php echo $_SERVER["REQUEST_URI"] ?>">
<input type="hidden" name="order_id" value="<?php echo $order_id ?>">
<form action="/du_an_1/business/review.php" method="POST">
    <input type="hidden" name="review_id" value="<?php echo $review_detail['review_id'] ?>">
    <?php if ((int)$review_detail['isApprove'] == 0) : ?>
        <button type="submit" name="action" value="update_review">Duyệt đánh giá</button>
    <?php else : ?>
        <button type="submit" name="action" value="update_review">Bỏ duyệt đánh giá</button>
    <?php endif ?>
    <button type="submit" name="action" value="delete_review">Xóa đánh giá</button>
</form>