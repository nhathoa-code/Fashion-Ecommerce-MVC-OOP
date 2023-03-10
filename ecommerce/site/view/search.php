  <section class="content shop-page">
      <div class="container">
          <h3 style="margin-top:10px">Kết quả tìm kiếm: <?php echo $_GET['q']; ?></h3>
          <div class="row">
              <div class="col-md-12 col-sm-12">
                  <?php if (count($products) > 0) : ?>
                      <!-- FEATURED-PRODUCTS-AREA START -->
                      <div class="featured-products-area">
                          <div class="tab-content">
                              <div role="tabpanel" class="tab-pane fade in  active" id="display-1-1">
                                  <div class="row">
                                      <?php foreach ($products as $product) : extract($product) ?>
                                          <!-- Single-Product Start -->
                                          <div class="col-sm-3 col-xs-12">
                                              <div class="single-product">
                                                  <div class="product-img">
                                                      <div class="product-sticker">
                                                          <?php if ($new === 1) : ?>
                                                              <div class="label-new">
                                                                  <span class="new">New</span>
                                                              </div>
                                                          <?php endif ?>
                                                          <?php if ($discounted_price > 0) : ?>
                                                              <div class="label-parcent">
                                                                  <span class="parcent"><?php echo "- " . ceil(($discounted_price / $price) * 100) . "%" ?></span>
                                                              </div>
                                                          <?php endif ?>
                                                      </div>
                                                      <a class="pro-image" href="<?php echo $ROOT_URL . "/product/$slug" ?>">
                                                          <?php
                                                            $arr = scandir("content/images/$dir");
                                                            $image = end($arr);
                                                            ?>
                                                          <img class="primary-image" src="<?php echo "$ROOT_URL/content/images/$dir/$image" ?>" alt="#">
                                                      </a>
                                                  </div>
                                                  <div class="product-content">
                                                      <div class="colors">
                                                          <?php
                                                            $colors = array_diff(scandir("content/images/$dir/colors"), array('.', '..'));
                                                            foreach ($colors as $image) :
                                                            ?>
                                                              <span style="background-image:url(<?php echo "http://localhost{$ROOT_URL}/content/images/$dir/colors/$image" ?>)"></span>
                                                          <?php endforeach ?>
                                                      </div>
                                                      <h2 class="product-name">
                                                          <a href="<?php echo $ROOT_URL . "/product/$slug" ?>"><?php echo $name ?></a>
                                                      </h2>
                                                      <div class="pro-price">
                                                          <?php
                                                            $old_price = number_format($price, 0, "", ".");
                                                            if ($discounted_price > 0) {
                                                                $new_price = number_format($price - $discounted_price, 0, "", ".");
                                                                echo "<span class='new-price'>$new_price đ</span>";
                                                                echo "<span class='old-price'>$old_price đ</span>";
                                                            } else {
                                                                echo "<span class='new-price'>$old_price đ</span>";
                                                            }
                                                            ?>

                                                      </div>
                                                      <div class="pro-rating">
                                                          <?php
                                                            $reviews = $review_ob->reviews_get_all_by_product($id);
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

                                                            echo "&nbsp;<span style='font-size:20px'>(" . count($reviews) . ")</span>";
                                                            ?>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <!-- Single-Product End -->
                                      <?php endforeach ?>
                                  </div>
                              </div>
                          </div>
                      </div>
              </div>
              <!-- FEATURED-PRODUCTS-AREA END -->
          <?php else : ?>
              <p>Không có sản phẩm nào !</p>
          <?php endif ?>
          </div>
      </div>
  </section>