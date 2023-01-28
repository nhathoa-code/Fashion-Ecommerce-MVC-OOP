 <!-- FOOTER-AREA START -->
 <footer style="margin-top:100px" class="footer-area">
     <!-- Footer-Top-Area Start -->
     <div class="footer-top-area">
         <div class="container">
             <div class="row">
                 <div class="col-md-12">
                     <div class="footer-top">
                         <p style="margin:0">Coded by VÒNG NHẬT HÒA</p>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- Footer-Top-Area End -->
     <!-- Copyright-Area Start -->
     <div class="copyright-area">
         <div class="container">
             <div class="row">
                 <div class="col-sm-12">
                     <div class="copyright" style="text-align: center;">
                         <p>Copyright &copy; <a href="#" target="_blank"><b> Codecarnival </b></a> All rights reserved.</p>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- Copyright-Area End -->
 </footer>
 <!-- FOOTER-AREA END -->
 <!-- QUICKVIEW PRODUCT -->
 <div id="quickview-wrapper">
     <!-- Modal -->
     <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 </div>
                 <div class="modal-body">
                     <div class="modal-product">
                         <div class="product-images">
                             <div class="main-image images">
                                 <img alt="#" src="<?php echo $CONTENT_SITE_PATH ?>/img/product/quickview-photo.jpg" />
                             </div>
                         </div><!-- .product-images -->

                         <div class="product-info">
                             <h1>Aenean eu tristique</h1>
                             <div class="price-box-3">
                                 <hr />
                                 <div class="s-price-box">
                                     <span class="new-price">$160.00</span>
                                     <span class="old-price">$190.00</span>
                                 </div>
                                 <hr />
                             </div>
                             <a href="shop.html" class="see-all">See all features</a>
                             <div class="quick-add-to-cart">
                                 <form method="post" class="cart">
                                     <div class="numbers-row">
                                         <input type="number" id="french-hens" value="3">
                                     </div>
                                     <button class="single_add_to_cart_button" type="submit">Add to cart</button>
                                 </form>
                             </div>
                             <div class="quick-desc">
                                 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero.
                             </div>
                             <div class="social-sharing">
                                 <div class="widget widget_socialsharing_widget">
                                     <h3 class="widget-title-modal">Share this product</h3>
                                     <ul class="social-icons">
                                         <li><a target="_blank" title="Facebook" href="#" class="facebook social-icon"><i class="fa fa-facebook"></i></a></li>
                                         <li><a target="_blank" title="Twitter" href="#" class="twitter social-icon"><i class="fa fa-twitter"></i></a></li>
                                         <li><a target="_blank" title="Pinterest" href="#" class="pinterest social-icon"><i class="fa fa-pinterest"></i></a></li>
                                         <li><a target="_blank" title="Google +" href="#" class="gplus social-icon"><i class="fa fa-google-plus"></i></a></li>
                                         <li><a target="_blank" title="LinkedIn" href="#" class="linkedin social-icon"><i class="fa fa-linkedin"></i></a></li>
                                     </ul>
                                 </div>
                             </div>
                         </div><!-- .product-info -->
                     </div><!-- .modal-product -->
                 </div><!-- .modal-body -->
             </div><!-- .modal-content -->
         </div><!-- .modal-dialog -->
     </div>
     <!-- END Modal -->
 </div>
 <!-- END QUICKVIEW PRODUCT -->

 <!-- all js here -->
 <!-- jquery latest version -->
 <script src="<?php echo $CONTENT_SITE_PATH ?>/js/vendor/jquery-1.12.0.min.js"></script>
 <!-- bootstrap js -->
 <script src="<?php echo $CONTENT_SITE_PATH ?>/js/bootstrap.min.js"></script>
 <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> -->
 <!-- Nivo slider js -->
 <script src="<?php echo $CONTENT_SITE_PATH ?>/lib/js/jquery.nivo.slider.js"></script>
 <!-- owl.carousel js -->
 <script src="<?php echo $CONTENT_SITE_PATH ?>/js/owl.carousel.min.js"></script>
 <!-- jquery-ui js -->
 <script src="<?php echo $CONTENT_SITE_PATH ?>/js/jquery-ui.min.js"></script>
 <!-- countdon.min js -->
 <script src="<?php echo $CONTENT_SITE_PATH ?>/js/countdon.min.js"></script>
 <!-- jquery.meanmenu js -->
 <script src="<?php echo $CONTENT_SITE_PATH ?>/js/jquery.meanmenu.js"></script>
 <!-- Simple Lence JS -->
 <script src="<?php echo $CONTENT_SITE_PATH ?>/js/jquery.simpleLens.min.js"></script>
 <!-- wow js -->
 <script src="<?php echo $CONTENT_SITE_PATH ?>/js/wow.min.js"></script>
 <!-- plugins js -->
 <script src="<?php echo $CONTENT_SITE_PATH ?>/js/plugins.js"></script>
 <?php if (isset($_GET['page']) && $_GET['page'] === "single") : ?>
     <script type="module" src="<?php echo $CONTENT_SITE_PATH ?>/js/src/single.js"></script>
 <?php endif ?>
 <?php if (isset($_GET['page']) && $_GET['page'] === "shop") : ?>
     <script type="module" src="<?php echo $CONTENT_SITE_PATH ?>/js/src/shop.js"></script>
 <?php endif ?>
 <?php if (isset($_GET['page']) && $_GET['page'] === "shopping-cart") : ?>
     <script type="module" src="<?php echo $CONTENT_SITE_PATH ?>/js/src/cart.js"></script>
 <?php endif ?>
 <?php if (isset($_GET['page']) && $_GET['page'] === "checkout") : ?>
     <script type="module" src="<?php echo $CONTENT_SITE_PATH ?>/js/src/checkout.js"></script>
 <?php endif ?>
 <?php if (isset($_GET['page']) && $_GET['page'] === "account/order_history") : ?>
     <script src="<?php echo $CONTENT_SITE_PATH ?>/js/src/order_history.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
 <?php endif ?>
 <?php if (isset($_GET['page']) && $_GET['page'] === "account/profile") : ?>
     <script src="<?php echo $CONTENT_SITE_PATH ?>/js/src/profile.js"></script>
 <?php endif ?>
 <?php if (isset($_GET['page']) && $_GET['page'] === "account/change_pass") : ?>
     <script src="<?php echo $CONTENT_SITE_PATH ?>/js/src/change_pass.js"></script>
 <?php endif ?>
 <?php if (isset($_SESSION['account'])) : ?>
     <script type="module" src="<?php echo $CONTENT_SITE_PATH ?>/js/src/minicart.js"></script>
 <?php endif ?>
 <!-- main js -->
 <script src="<?php echo $CONTENT_SITE_PATH ?>/js/main.js"></script>
 </body>

 </html>