<?php if (count($reviews) > 0) : ?>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Tên khách hàng</th>
                <th>Nội dung</th>
                <th>Ngày đánh giá</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <form id="form-table" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
                <?php
                foreach ($reviews as $item) :
                    extract($item);
                ?>
                    <tr>
                        <td><?php echo $name ?></td>
                        <td><?php echo strlen($review) > 50 ? substr($review, 0, 50) . " . . ." : $review;  ?></td>
                        <td><?php echo date("d-m-Y", strtotime($created_on)); ?></td>
                        <td><?php echo $isApprove == 1 ? "Đã duyệt" : "Chưa duyệt" ?></td>
                        <td>
                            <a href="?page=review_detail&review_id=<?php echo $review_id ?>">Xem chi tiết</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </form>

        </tbody>
    </table>
<?php else : ?>
    <h3>Danh sách trống</h3>
<?php endif ?>