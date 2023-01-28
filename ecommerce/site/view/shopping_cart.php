    <section class="content">
        <!-- CART-AREA START -->
        <div class="cart-area margin-70">
            <div class="container cart-container">
                <?php if (count($items) > 0) : ?>
                    <form action="<?php echo $ROOT_URL ?>/checkout" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered cart-table">
                                        <thead class="cart-table-head">
                                            <tr>
                                                <td class="text-center"> Items</td>
                                                <td class="text-center"> Price</td>
                                                <td class="text-center"> Quantity</td>
                                                <td class="text-center"> Total Price</td>
                                                <td class="text-center"> Remove</td>
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
                                                <tr data-id="<?php echo $id ?>">
                                                    <td class="text-left shopping-cart-breif">
                                                        <a href="#"><img style="width:100px;height:auto" src="<?php echo preg_replace("/\/colors\//", "/color_images/", $color) ?>" alt="#" /></a>
                                                        <h5><a href="#" class="text-uppercase"><?php echo $product_name ?></a></h5>
                                                        <p>Color: <span style="background-image:url(<?php echo $color ?>)"></span></p>
                                                        <p>Size: <?php echo $size ?></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="custom-cart"><?php echo number_format($unit_price, 0, "", ".") . " đ" ?></div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="cart-plus-minus">
                                                            <input type="text" value="<?php echo $quantity ?>" name="qtybutton" class="cart-plus-minus-box">
                                                        </div>
                                                    </td>
                                                    <td class="text-center total-<?php echo $id ?>">
                                                        <?php echo number_format($unit_price * $quantity, 0, "", ".") . " đ" ?>
                                                    </td>
                                                    <td class="text-center remove">
                                                        <a href="javascript:void(0)"><i class="pe-7s-close"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="shipping-discount-details">
                            <div class="row">
                                <div class="col-sm-4 col-sm-12">
                                    <label class="custom-form custom-submit active-submit">Payment Details</label>
                                    <div class="order">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="text-left">Tổng cộng:</td>
                                                    <td class="text-right cart-subtotal"><?php echo number_format($subtotal, 0, "", ".") . " đ" ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">Phí vận chuyển</td>
                                                    <td class="text-right">0 đ</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-right custom-td"><strong>Tổng đơn hàng =</strong></td>
                                                    <td class="text-right custom-td order-subtotal"><strong><?php echo number_format($subtotal + 0, 0, "", ".") . " đ" ?></strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <input type="submit" class="custom-submit-2" value="Đặt Hàng" />
                                </div>
                            </div>
                        </div>
                    </form>
                <?php else : ?>
                    <h1>Không có sản phẩm trong giỏ hàng!</h1>
                <?php endif ?>
            </div>
        </div>
        <!-- CART-AREA END -->
    </section>