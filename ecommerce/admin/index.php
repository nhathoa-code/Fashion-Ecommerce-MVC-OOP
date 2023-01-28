    <!-- Navigation info -->
    <ul id="nav-info" class="clearfix">
        <li><a href="index.php"><i class="fa fa-home"></i></a></li>
        <li class="active"><a href="">Dashboard</a></li>
    </ul>


    <!-- END Navigation info -->
    <?php if (!isset($_GET['time']) || (isset($_GET['time']) && $_GET['time'] === "")) : ?>
        <p style="font-size:large;margin:30px 0;">
            Thống kê trong 30 ngày gần nhất
        </p>
    <?php endif ?>
    <form action="" method="GET">
        <div class="form-group">
            <div class="input-group">
                <input type="hidden" name="page" value="statistic">
                <input type="text" id="example-input-daterangepicker" name="time" class="form-control input-daterangepicker" placeholder="Nhập vào khoảng thời gian" value="<?php echo isset($_GET['time']) ? $_GET['time'] : "" ?>">
                <span class="input-group-addon"><button type="submit"><i class="fa fa-calendar"></i></button></span>
            </div>
        </div>
    </form>
    <!-- Tiles -->
    <!-- Row 1 -->
    <div class="dash-tiles row">
        <!-- Column 1 of Row 1 -->
        <div class="col-sm-3">
            <!-- Total Users Tile -->
            <div class="dash-tile dash-tile-ocean clearfix animation-pullDown">
                <div class="dash-tile-header">
                    Số tài khoản đăng ký
                </div>
                <div class="dash-tile-icon"><i class="fa fa-users"></i></div>
                <div class="dash-tile-text"><?php echo $statistic->total_users() ?></div>
            </div>
            <!-- END Total Users Tile -->


        </div>
        <!-- END Column 1 of Row 1 -->

        <!-- Column 2 of Row 1 -->
        <div class="col-sm-3">
            <!-- Total Sales Tile -->
            <div class="dash-tile dash-tile-flower clearfix animation-pullDown">
                <div class="dash-tile-header">
                    Doanh thu
                </div>
                <!-- <div class="dash-tile-icon"><i class="fa fa-money"></i></div> -->
                <?php
                $subtotal = 0;
                foreach ($statistic->total_paid_orders() as $item) {
                    $subtotal += $item['subtotal'];
                };
                ?>
                <div class="dash-tile-text"><?php echo number_format($subtotal, 0, "", ".") . " đ" ?></div>
            </div>
            <!-- END Total Sales Tile -->


        </div>
        <!-- END Column 2 of Row 1 -->

        <!-- Column 3 of Row 1 -->
        <div class="col-sm-3">
            <!-- Popularity Tile -->
            <div class="dash-tile dash-tile-oil clearfix animation-pullDown">
                <div class="dash-tile-header">
                    Số đơn hàng đã đặt
                </div>
                <div class="dash-tile-icon"><i class="gi gi-ok"></i></div>
                <div class="dash-tile-text"><?php echo $statistic->total_orders() ?></div>
            </div>
            <!-- END Popularity Tile -->


        </div>
        <!-- END Column 3 of Row 1 -->

        <!-- Column 4 of Row 1 -->
        <div class="col-sm-3">
            <!-- RSS Subscribers Tile -->
            <div class="dash-tile dash-tile-balloon clearfix animation-pullDown">
                <div class="dash-tile-header">
                    Số sản phẩm đã bán
                </div>
                <div class="dash-tile-icon"><i class="fa fa-plus-square"></i></div>
                <?php
                require_once "business/order.php";
                $order = new Order();
                $saled_products = 0;
                foreach ($statistic->total_paid_orders() as $ITEM) {
                    $order->order_id = $ITEM['id'];
                    foreach ($order->order_get_detail() as $item) {
                        $saled_products += $item['quantity'];
                    }
                }
                ?>
                <div class="dash-tile-text"><?php echo $saled_products; ?></div>
            </div>
            <!-- END RSS Subscribers Tile -->

        </div>
        <!-- END Column 4 of Row 1 -->
    </div>
    <!-- END Row 1 -->

    <!-- Row 3 -->
    <div class="row">
        <!-- Column 1 of Row 3 -->
        <div class="col-12">
            <!-- Datatables Tile -->
            <div class="dash-tile dash-tile-2x">
                <div class="dash-tile-header">
                    <div class="dash-tile-options">
                        <a href="javascript:void(0)" class="btn btn-default" data-toggle="tooltip" title="Manage Orders"><i class="fa fa-cogs"></i></a>
                    </div>
                    <i class="fa fa-shopping-cart"></i> Đơn hàng mới
                </div>
                <?php
                $orders = $statistic->total_new_orders();
                if (count($orders) !== 0) :
                ?>
                    <div class="dash-tile-content">
                        <div class="dash-tile-content-inner-fluid">
                            <table id="dash-example-orders" class="table table-striped table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th class="hidden-xs hidden-sm hidden-md">Stt</th>
                                        <th><i class="fa fa-shopping-cart"></i>Mã đơn</th>
                                        <th><i class="fa fa-bolt"></i>Trạng thái</th>
                                        <th><i class="fa fa-bolt"></i>Phương thức thanh toán</th>
                                        <th><i class="fa fa-bolt"></i>Trạng thái thanh toán</th>
                                        <th><i class="fa fa-bolt"></i>Ngày tạo</th>
                                        <th><i class="fa fa-bolt"></i>Tổng tiền</th>
                                        <th class="cell-small"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $stt = 0;
                                    foreach ($orders as $item) {
                                        $stt++;
                                        extract($item); ?>
                                        <tr>
                                            <td class="hidden-xs hidden-sm hidden-md"><?php echo $stt; ?></td>
                                            <td><a href="javascript:void(0)">#<?php echo $id; ?></a></td>
                                            <td><a href="javascript:void(0)"><?php echo $status; ?></a></td>
                                            <td><a href="javascript:void(0)"><?php echo $payment; ?></a></td>
                                            <td><a href="javascript:void(0)"><?php echo $pay_status; ?></a></td>
                                            <td><a href="javascript:void(0)"><?php echo $created_on; ?></a></td>
                                            <td><a href="javascript:void(0)"><?php echo number_format($subtotal, 0, "", ".") . " đ" ?></a></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="?page=order_detail&order_id=<?php echo $id ?>" data-toggle="tooltip" title="Process" class="btn btn-xs btn-primary">Chi tiết</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else : ?>
                    <p>Không có đơn hàng !</p>
                <?php endif ?>

            </div>
            <!-- END Datatables Tile -->
        </div>
        <!-- END Column 1 of Row 3 -->
    </div>
    <!-- END Row 3 -->
    <!-- END Tiles -->