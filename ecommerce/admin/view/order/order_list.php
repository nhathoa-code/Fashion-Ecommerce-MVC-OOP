    <div id="status_menu">
        <div class="col-md-3">
            <div class="input-group" style="width:150px">
                <input type="text" name="OrderId" class="form-control" placeholder="Nhập mã đơn">
                <span class="input-group-btn">
                    <button class="btn btn-success search"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </div>
        <ul style="width:fit-content;margin:10px auto" class="nav nav-pills">
            <li <?php echo !isset($_GET['status']) ? "class='active'" : "" ?>><a href="?page=order_list">Tất cả</a></li>
            <li <?php echo isset($_GET['status']) && $_GET['status'] === "Đang xử lý" ? "class='active'" : "" ?>><a href="?page=order_list&status=Đang xử lý">Đang xử lý</a></li>
            <li <?php echo isset($_GET['status']) && $_GET['status'] === "Đang giao" ? "class='active'" : "" ?>><a href="?page=order_list&status=Đang giao">Đang giao</a></li>
            <li <?php echo isset($_GET['status']) && $_GET['status'] === "Đã giao" ? "class='active'" : "" ?>><a href="?page=order_list&status=Đã giao">Đã giao</a></li>
            <li <?php echo isset($_GET['status']) && $_GET['status'] === "Đã hủy" ? "class='active'" : "" ?>><a href="?page=order_list&status=Đã hủy">Đã hủy</a></li>
        </ul>
    </div>

    <?php if (count($orders) !== 0) : ?>
        <table class="table">
            <thead>
                <tr>
                    <th class="cell-small text-center" data-toggle="tooltip" title="" data-original-title="Toggle all!"><input type="checkbox" id="check1-all" name="check1-all"></th>
                    <th class="hidden-xs hidden-sm">Mã đơn hàng</th>
                    <th class="hidden-xs hidden-sm">Trạng thái</th>
                    <th class="hidden-xs hidden-sm">Ngày Tạo</th>
                    <th class="text-center"><i class="fa fa-bolt"></i> Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : extract($order); ?>
                    <tr>
                        <td class="text-center"><input type="checkbox" name="check1-td1"></td>
                        <td class="hidden-xs hidden-sm"><?php echo $id ?></td>
                        <td><?php echo $status ?></td>
                        <td><?php echo $created_on ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="?page=order_detail&order_id=<?php echo $id ?>" class="btn btn-xs btn-success">Chi tiết</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <h1 style="text-align: center;margin-top:70px">Không có đơn hàng !</h1>
    <?php endif; ?>