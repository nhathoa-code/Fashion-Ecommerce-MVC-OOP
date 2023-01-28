 <section class="content">
     <!-- ABOUT-AREA START -->
     <div class="product-detail-area margin-70">
         <div class="container">
             <div class="row">
                 <div class="col-md-5">
                     <div class="single-product-view">
                         <!-- Nav tabs -->
                         <div class="large-product-tab-menu">
                             <div role="tablist" class="product-details-menu product-details-carousel navigation-center">
                                 <?php
                                    $gallery = array_diff(scandir("content/images/$dir/gallery"), array('.', '..'));
                                    $gallery = array_values($gallery);
                                    foreach ($gallery as $index => $image) :
                                    ?>
                                     <div role="presentation" class="<?php echo $index === 0 ? "active" : "" ?>">
                                         <a href="#img-<?php echo $index ?>" role="tab" data-toggle="tab">
                                             <img data-image="<?php echo $image ?>" src="<?php echo "$ROOT_URL/content/images/$dir/gallery/$image" ?>" alt="" />
                                         </a>
                                     </div>
                                 <?php endforeach ?>
                             </div>
                         </div>

                         <div class="view-large-photo">
                             <!-- Tab panes -->
                             <div class="simpleLens-container tab-content">
                                 <?php
                                    $gallery_large = array_diff(scandir("content/images/$dir/gallery"), array('.', '..'));
                                    $gallery_large = array_values($gallery_large);
                                    foreach ($gallery_large as $index => $image) :
                                    ?>
                                     <div role="tabpanel" class="tab-pane <?php echo $index === 0 ? "active" : "" ?>" id="img-<?php echo $index ?>">
                                         <div class="simpleLens-big-image-container">
                                             <a class="simpleLens-lens-image" data-lens-image="<?php echo "$ROOT_URL/content/images/$dir/gallery/$image" ?>" href="javascript:void(0)">
                                                 <img data-image="<?php echo $image ?>" src="<?php echo "$ROOT_URL/content/images/$dir/gallery/$image" ?>" alt="" class="simpleLens-big-image" />
                                             </a>
                                         </div>
                                     </div>
                                 <?php endforeach ?>

                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="col-md-7">
                     <div class="single-product-details listview">
                         <div class="product-content">
                             <h2 class="product-name">
                                 <p><?php echo $name ?></p>
                             </h2>
                             <div class="rating-review">
                                 <div class="pro-rating">
                                     <?php
                                        $rate = 0;
                                        if (count($reviews) > 0) {
                                            $total_rate = 0;
                                            foreach ($reviews as $review) {
                                                $total_rate += $review['rate'];
                                            }
                                            $rate = $total_rate / count($reviews);
                                            $save = $rate;
                                        }
                                        $done = false;
                                        for ($i = 1; $i <= 5; $i++) {
                                            $rate = $rate - 1;
                                            if (!$done) {
                                                if ($rate >= 0) {
                                                    echo '<a href="#"><i class="fa fa-star"></i></a> ';
                                                } else {
                                                    $done = true;
                                                    $rate = $rate + 1;
                                                    if ($rate === 0) {
                                                        echo '<a href="#"><i class="fa fa-star-o"></i></a> ';
                                                    } else if ($rate < 0.5) {
                                                        echo '<a href="#"><i class="fa fa-star-half-o"></i></a> ';
                                                    } else if ($rate > 0.5) {
                                                        echo '<a href="#"><i class="fa fa-star"></i></a> ';
                                                    } else if ($rate === 0.5) {
                                                        echo '<a href="#"><i class="fa fa-star-half-o"></i></a> ';
                                                    } else {
                                                        echo '<a href="#"><i class="fa fa-star-o"></i></a> ';
                                                    }
                                                }
                                            } else {
                                                echo '<a href="#"><i class="fa fa-star-o"></i></a> ';
                                            }
                                        }
                                        ?>
                                 </div>
                                 <a class="reviews" href="javascript:void(0)"><?php echo count($reviews) ?> Đánh giá</a>
                             </div>
                             <div class="stock">
                                 <a href="javascript:void(0)">Còn hàng</a>
                             </div>
                             <div class="price-box">
                                 <?php
                                    $old_price = number_format($price, 0, "", ".");
                                    if ($discounted_price > 0) {
                                        echo "<span class='old-price'>$old_price đ</span>";
                                        $new_price = number_format($price - $discounted_price, 0, "", ".");
                                        echo "<span class='new-price'>$new_price đ</span>";
                                    } else {
                                        echo "<span class='new-price'>$old_price đ</span>";
                                    }
                                    ?>
                             </div>
                             <div class="description">
                                 <p><?php echo $description ?></p>
                             </div>
                             <div class="color-choose">
                                 <span class="choose-title">MÀU SẮC : </span>
                                 <?php
                                    $colors = array_diff(scandir("content/images/$dir/colors"), array('.', '..'));
                                    foreach ($colors as $image) :
                                    ?>
                                     <a data-img-color=<?php echo $image ?> style="background-image: url(<?php echo "http://localhost{$ROOT_URL}/content/images/$dir/colors/$image" ?>)" class="color"></a>
                                 <?php endforeach ?>
                             </div>
                             <div class="size">
                                 <span class="choose-title">KÍCH CỠ : </span>
                                 <ul>
                                     <?php
                                        foreach ($sizes as $size) {
                                            echo "<li style='opacity:0.5;pointer-events:none'><a href='#'>{$size['value']}</a></li>";
                                        }
                                        ?>
                                 </ul>
                             </div>
                             <div class="qty">
                                 <span class="choose-title">Qty : </span>
                                 <input type="number" value="1" min="1" />
                             </div>
                             <div class="pro-actions">
                                 <a class="action-btn action-btn-1 cart" style="width:fit-content;padding:0 10px" href="javascript:void(0)"><i class="pe-7s-cart"></i>Thêm vào giỏ hàng</a>
                             </div>
                         </div>
                         <div class="product-description-tab">
                             <!-- Nav tabs -->
                             <ul role="tablist">
                                 <li role="presentation" class="active"><a href="#reviews" role="tab" data-toggle="tab">Đánh giá của người mua</a></li>
                             </ul>
                             <!-- Tab panes -->
                             <div class="tab-content">
                                 <?php if (count($reviews) > 0) : ?>
                                     <div role="tabpanel" class="tab-pane active" id="reviews">
                                         <div class="reviews-list">
                                             <?php foreach ($reviews as $review) : ?>
                                                 <!-- Single-Review Start -->
                                                 <div class="single-reviews fix">
                                                     <div class="reviews-details">
                                                         <div class="reviewer-reply">
                                                             <div class="about-reviewer">
                                                                 <div class="name-date">
                                                                     <h2 class="reviewer-name"><a href="javascript:void(0)"><?php echo $review['name'] ?></a></h2>
                                                                     <span class="raply-date"><?php echo $review['created_on'] ?></span>
                                                                     <!-- <span class="raply-date">February 10, 2016</span> -->
                                                                 </div>
                                                                 <div class="reviewer-rating">
                                                                     <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                                         <?php if ($i <= $review['rate']) : ?>
                                                                             <a href="javascript:void(0)"><i class="fa fa-star"></i></a>
                                                                         <?php else : ?>
                                                                             <a href="javascript:void(0)"><i class="fa fa-star-o"></i></a>
                                                                         <?php endif ?>
                                                                     <?php endfor ?>
                                                                 </div>
                                                             </div>
                                                             <p><?php echo $review['content'] ?></p>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <!-- Single-Review End -->
                                             <?php endforeach ?>
                                         </div>
                                     </div>
                                 <?php else : ?>
                                     <p style="margin:10px 0">Chưa có đánh giá nào !</p>
                                 <?php endif ?>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- ABOUT-AREA END -->
 </section>
 <script>
     var carousel_html = document.querySelector(".large-product-tab-menu").innerHTML;
     var simpleLens_container = document.querySelector(".simpleLens-container").innerHTML
     const product_id = <?php echo (int) $id ?>;
     const product_name = "<?php echo $name ?>";
     const unit_price = <?php echo (int) ($price - $discounted_price) ?>;
     const sizes = [];
 </script>
 <?php foreach ($sizes as $size) : ?>
     <script>
         sizes.push({
             id: <?php echo (int) $size['id'] ?>,
             size: "<?php echo $size['value'] ?>"
         })
     </script>
 <?php endforeach ?>