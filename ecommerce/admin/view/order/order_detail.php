<?php extract($order); ?>
<!-- Navigation info -->
<ul id="nav-info" class="clearfix">
    <li><a href="index.php"><i class="fa fa-home"></i></a></li>
    <li><a href="javascript:void(0)">Pages</a></li>
    <li class="active"><a href="">Invoice</a></li>
</ul>
<!-- END Navigation info -->

<!-- Invoice -->
<!-- Header -->
<h3 class="sub-header text-center"><i class="fa fa-file-o"></i> Mã đơn hàng #<?php echo $id ?></h3>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <!-- Invoice Tile -->
        <div class="dash-tile dash-tile-dark no-opacity remove-margin">
            <!-- Content -->
            <div class="dash-tile-content">
                <div class="dash-tile-content-inner-fluid dash-tile-content-light">
                    <!-- Addresses -->
                    <div class="row">
                        <div class="col-md-5">
                            <address>
                                <strong><i class="fa fa-home"></i> Địa chỉ giao hàng</strong><br>
                                <?php echo $address ?>
                                <div style="margin:10px 0">
                                    <abbr title="Phone"><i class="fa fa-phone"></i> </abbr> <?php echo $phone_number ?>
                                </div>
                                <div style="margin:10px 0">
                                    <abbr title="Phone"><i class="fa fa-envelope"></i> </abbr> <?php echo $email ?>
                                </div>
                                <strong><i class="fa fa-pencil-square-o"></i> Ghi chú</strong><br>
                                <?php echo $note ?>
                            </address>
                        </div>
                        <div class="col-md-6 col-md-offset-1">
                            <table class="table table-borderless table-condensed">
                                <tbody>
                                    <tr>
                                        <td><strong>Tên khách hàng:</strong></td>
                                        <td>
                                            <address>
                                                <?php echo $fullname ?>
                                            </address>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mã đơn hàng</strong></td>
                                        <td><span class="label label-danger">#<?php echo $id ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ngày Đặt</strong></td>
                                        <td><span class="label label-warning"><?php echo $created_on ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Trạng thái</strong></td>
                                        <td><span class="label label-success status"><?php echo $status ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phương Thức Thanh Toán</strong></td>
                                        <td><span class="label label-primary"><?php echo $payment ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Trạng Thái Thanh toán</strong></td>
                                        <td><span class="label label-primary"><?php echo $pay_status ?></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END Addresses -->

                    <!-- Product Table -->
                    <table class="table table-borderless table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="hidden-xs hidden-sm">Mã sản phẩm</th>
                                <th class="hidden-xs hidden-sm">Tên sản phẩm</th>
                                <th class="hidden-xs hidden-sm">Kích cỡ</th>
                                <th class="hidden-xs hidden-sm text-center">Màu sắc</th>
                                <th class="hidden-xs hidden-sm text-center">Quantity</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-right">Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_details as $key => $item) : ?>
                                <tr class="success">
                                    <td>
                                        <img style="width:50px;height:auto" src="<?php echo preg_replace("/\/colors\//", "/color_images/", $item['color']) ?>" alt="">
                                    </td>
                                    <td><?php echo $item['product_id'] ?></td>
                                    <td><?php echo $item['name'] ?></td>
                                    <td class="hidden-xs hidden-sm text-center"><?php echo $item['size'] ?></td>
                                    <td class="hidden-xs hidden-sm text-center">
                                        <img style="width:15px;height:auto;" src="<?php echo $item['color'] ?>" alt="">
                                    </td>
                                    <td class="hidden-xs hidden-sm text-center"><?php echo $item['quantity'] ?></td>
                                    <td class="text-center"><?php echo number_format($item['unit_price'], 0, "", ".") . " đ" ?></td>
                                    <td class="text-right"><?php echo number_format($item['quantity'] * $item['unit_price'], 0, "", ".") . " đ" ?></td>
                                </tr>
                            <?php endforeach ?>

                            <tr class="warning">
                                <td></td>
                                <td></td>
                                <td class="hidden-xs hidden-sm"></td>
                                <td class="hidden-xs hidden-sm"></td>
                                <td class="hidden-xs hidden-sm"></td>
                                <td class="text-right"><strong>Tổng tiền đơn hàng</strong></td>
                                <td class="text-right"><?php echo number_format($order_total, 0, "", ".") . " đ" ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- END Product Table -->

                    <!-- Extras -->
                    <?php if ($status !== "Đã hủy" && $status !== "Đã giao") : ?>
                        <div class="clearfix">
                            <a href="javascript:void(0)" class="update btn btn-success pull-right push">Cập nhật trạng thái</a>
                            <div class="form-group">
                                <?php
                                $status_array = array("Đang xử lý", "Đang chuẩn bị hàng", "Đang giao", "Đã giao");
                                ?>
                                <div class="col-md-4">
                                    <select id="status" class="form-control">
                                        <?php foreach ($status_array as $item) : ?>
                                            <option <?php echo $item === $status ? "selected" : "" ?> value="<?php echo $item ?>"><?php echo $item ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- END Extras -->
                    <?php endif ?>
                </div>
            </div>
            <!-- END Content -->
        </div>
        <!-- END Invoice Tile -->
    </div>
</div>
<!-- END Invoice -->
<script>
    const order_id = <?php echo $id ?>;
</script>