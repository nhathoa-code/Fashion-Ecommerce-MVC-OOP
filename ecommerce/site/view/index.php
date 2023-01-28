	<!-- SLIDER-AREA START -->
	<section class="slider-area">
		<div class="bend niceties preview-2">
			<div id="ensign-nivoslider" class="slides">
				<?php foreach ($sliders as $key => $slider) : ?>
					<img src="<?php echo $ROOT_URL ?>/content/images/slider/<?php echo $slider['image'] ?>" alt="" title="#slider-direction-<?php echo $key + 1 ?>" />
				<?php endforeach ?>
			</div>
			<!-- direction 1 -->
			<?php foreach ($sliders as $key => $slider) : ?>
				<div id="slider-direction-<?php echo  $key + 1 ?>" class="slider-direction">
					<div class="slider-progress"></div>
					<div class="slider-content t-lft s-tb slider-<?php echo $key + 1 ?>">
						<div class="title-container s-tb-c title-compress">
							<div class="<?php echo $key + 1 !== 1 ? "layer-1" : "" ?> layer-<?php echo $key + 1 ?>">
								<div class="custom-slider">
									<h5><?php echo $slider['title'] ?></h5>
									<h2 class="title1"><?php echo $slider['title1'] ?></h2>
									<p><?php echo $slider['content'] ?></p>
								</div>
								<a href="<?php echo $slider['link'] ?>"><?php echo $slider['button'] ?></a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	</section>
	<!-- SLIDER-AREA END -->
	<section class="content">
		<!-- FASHION-COLLECTION-AREA START -->
		<div class="fashion-collection-area">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="fashion-collection">
							<div class="fashion-photo">
								<img src="https://im.uniqlo.com/global-cms/spa/resfda424b434da3fa23f643ed9d48e2250fr.jpg" alt="#">
							</div>
							<div class="fashion-details">
								<h2>
									<span class="color-white">20</span>23 <br>
									<span class="color-white">Fa</span>Shion
								</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi perspiciatis eius quis quam odio, error accusantium, quis ullam sint exercitationem mollitia accusa mus magnam debitis dolor culpa quibusdam animi adipisci ducimus magnam debi tis dolor culpa quibusdam animi adipisci ducimus natus?</p>
								<a href="">View <span> collection</span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- FASHION-COLLECTION-AREA END -->
		<!-- FEATURED-PRODUCTS-AREA START -->
		<div class="featured-products-area">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="area-title title-top-border">
							<h2>sản phẩm nổi bật</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="active-product-carousel navigation-top">
						<!-- Single-Product Start -->
						<?php $count = 0; ?>
						<?php foreach ($products as $product) : extract($product); ?>
							<div class="single-product" style="margin-right: 20px;">
								<div class="product-img">
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
						<?php endforeach ?>
						<!-- Single-Product End -->
					</div>
				</div>
			</div>
		</div>
		<!-- FEATURED-PRODUCTS-AREA END -->
		<!-- PRODUCT-BANNER-AREA START -->
		<div class="product-banner-area">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="product-banner">
							<a class="banner-photo" href=""><img src="https://im.uniqlo.com/global-cms/spa/res38f1fbdded9dad9f84aa5a96d89f6a2efr.jpg" alt="#" /></a>
							<div class="banner-brief">
								<h2>for mens</h2>
								<a href="" class="shop-now">Shop Now</a>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="product-banner banner-2">
							<a class="banner-photo" href=""><img src="https://im.uniqlo.com/global-cms/spa/resec5cc3d3314ab953861be67fedf2e62efr.jpg" alt="#" /></a>
							<div class="banner-brief">
								<h2>Dresses For Women</h2>
								<p>Spring Collection</p>
								<a href="" class="shop-now">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- PRODUCT-BANNER-AREA END -->
		<!-- NEW-ARRIVAL-AREA START -->
		<div class="new-arrival-area">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="area-title title-top-border">
							<h2>sản phẩm mới</h2>
						</div>
					</div>
				</div>
				<div class="product-banner-area">
					<div class="container">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
								<div class="product-banner">
									<a class="banner-photo" href=""><img src="https://im.uniqlo.com/global-cms/spa/resd2b79bdaeab535929a65cb1ef0e06ffbfr.jpeg" alt="#" /></a>
									<div class="banner-brief">
										<h2>for womens</h2>
										<a href="" class="shop-now">Shop Now</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- NEW-ARRIVAL-AREA END -->
	</section>