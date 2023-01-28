 <section class="content">
     <!-- CHECKOUT-AREA START -->
     <div class="checkout-area">
         <div class="container">
             <form action="<?php echo $ROOT_URL ?>/business/order.php" method="post">
                 <div class="row">
                     <!-- Shipping-Address Start -->
                     <div class="col-sm-7">
                         <div class="shipping-address margin-65">
                             <h2 class="title-3">Thông tin giao hàng</h2>
                             <div class="row margin-bottom-20">
                                 <div class="col-sm-6">
                                     <input class="custom-form" type="text" placeholder="Họ tên" name="ho_ten" />
                                 </div>
                                 <div class="col-sm-6">
                                     <input class="custom-form" type="text" placeholder="Số điện thoại" name="sdt" />
                                 </div>
                             </div>
                             <div class="row margin-bottom-20">
                                 <div class="col-md-12">
                                     <input type="text" class="custom-form" placeholder="Email" name="email" />
                                 </div>
                             </div>
                             <div class="row margin-bottom-20">
                                 <div class="col-md-12">
                                     <input type="text" class="custom-form" placeholder="Địa chỉ" name="dia_chi" />
                                 </div>
                             </div>
                             <div class="row margin-bottom-20">
                                 <div class="col-md-12">
                                     <select class="custom-select custom-form tinh_thanh" name="tinh_thanh">
                                     </select>
                                 </div>
                             </div>
                             <div class="row margin-bottom-20">
                                 <div class="col-sm-6">
                                     <select class="custom-select custom-form quan_huyen" name="quan_huyen">
                                     </select>
                                 </div>
                                 <div class="col-sm-6">
                                     <select class="custom-select custom-form phuong_xa" name="phuong_xa">
                                     </select>
                                 </div>
                             </div>
                             <div class="row margin-bottom-20">
                                 <div class="col-md-12">
                                     <textarea class="custom-form" name="ghi_chu" placeholder="Ghi chú"></textarea>
                                 </div>
                             </div>
                             <?php
                                $db = new Database();
                                $sql = "SELECT * FROM profile WHERE account_id = ?";
                                $result = $db->pdo_query($sql, $_SESSION['account']['id']);
                                if (!$result) {
                                ?>
                                 <div class="row margin-bottom-20 checkbox">
                                     <div class="col-md-12">
                                         <label>
                                             <input type="checkbox" name="save_profile">
                                             Lưu vào hồ sơ
                                         </label>
                                     </div>
                                 </div>
                             <?php } ?>
                             <h2 class="title-3">phương thức thanh toán</h2>
                             <div class="radio">
                                 <div>
                                     <label>
                                         <input type="radio" value="COD" name="payment">
                                         Thanh toán khi nhận hàng
                                     </label>
                                 </div>
                                 <div style="margin-top:10px">
                                     <label>
                                         <input type="radio" value="VNPay" name="payment">
                                         <img style="height:13px;width:auto" src="<?php echo $ROOT_URL ?>/content/site/img/vnpay.png" alt="">
                                     </label>
                                 </div>
                             </div>
                             <input type="hidden" name="action" value="add_order">
                             <div class="row margin-bottom-20">
                                 <div class="col-md-12">
                                     <input type="submit" class="custom-submit-2" value="Hoàn Tất Đặt Hàng">
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="col-md-5 col-sm-5">
                         <div class="order margin-65">
                             <h2 class="title-3">Chi Tiết Đơn Hàng</h2>
                             <div class="table-responsive">
                                 <table class="table table-bordered cart-table" style="font-size:small !important">
                                     <thead class="cart-table-head">
                                         <tr>
                                             <td class="text-center"> Sản phẩm</td>
                                             <td class="text-center"> Giá</td>
                                             <td class="text-center"> Số lượng</td>
                                             <td class="text-center"> Tổng cộng</td>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php $subtotal = 0; ?>
                                         <?php foreach ($items as $item) :
                                                extract($item);
                                                $subtotal += $unit_price * $quantity;
                                                $db = new Database();
                                                $sql = "SELECT name FROM product WHERE id = ?";
                                                $product_name = $db->pdo_query_value($sql, $product_id);
                                            ?>
                                             <tr style="font-size: smaller" data-id="<?php echo $id ?>">
                                                 <td class="text-left shopping-cart-breif">
                                                     <a href="#"><img style="width:50px;height:auto;margin:5px" src="<?php echo preg_replace("/\/colors\//", "/color_images/", $color) ?>" alt="#" /></a>
                                                     <h5 style="font-size: smaller;"><a href="#" class="text-uppercase"><?php echo $product_name ?></a></h5>
                                                     <div style="font-size: smaller;display:flex">
                                                         <div style="margin-right:5px;">
                                                             Color: <span style="background-image:url(<?php echo $color ?>);width:10px;height:10px;display:inline-block"></span>
                                                         </div>
                                                         <div>
                                                             Size: <?php echo $size ?>
                                                         </div>
                                                     </div>
                                                 </td>
                                                 <td class="text-center">
                                                     <div class="custom-cart"><?php echo number_format($unit_price, 0, "", ".") . " đ" ?></div>
                                                 </td>
                                                 <td class="text-center">
                                                     <?php echo $quantity ?>
                                                 </td>
                                                 <td class="text-center total-<?php echo $id ?>">
                                                     <?php echo number_format($unit_price * $quantity, 0, "", ".") . " đ" ?>
                                                 </td>
                                             </tr>
                                         <?php endforeach ?>
                                     </tbody>
                                 </table>
                             </div>
                             <div>
                                 <table class="table">
                                     <tbody>
                                         <tr>
                                             <td class="text-left">Tổng cộng</td>
                                             <td class="text-right"><?php echo number_format($subtotal, 0, "", ".") . " đ" ?></td>
                                         </tr>
                                         <tr>
                                             <td class="text-left">Phí vận chuyển</td>
                                             <td class="text-right">0 đ</td>
                                         </tr>
                                     </tbody>
                                     <tfoot>
                                         <tr>
                                             <td class="text-right custom-td"><strong>Tổng đơn hàng =</strong></td>
                                             <td class="text-right custom-td"><strong><?php echo number_format($subtotal + 0, 0, "", ".") . " đ" ?></strong></td>
                                         </tr>
                                     </tfoot>
                                 </table>
                             </div>
                         </div>
                     </div>
                 </div>
             </form>
         </div>
     </div>
     <!-- CHECKOUT-AREA END -->
 </section>