  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div style="margin-top: 100px;" class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Đánh giá sản phẩm</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div style="float:none;text-align:center" class="pro-rating">
                      <a class="rate" data-rate="1" href="javascript:void(0)"><i style="font-size:25px;" class="fa fa-star-o"></i></a>
                      <a class="rate" data-rate="2" href="javascript:void(0)"><i style="font-size:25px;" class="fa fa-star-o"></i></a>
                      <a class="rate" data-rate="3" href="javascript:void(0)"><i style="font-size:25px;" class="fa fa-star-o"></i></a>
                      <a class="rate" data-rate="4" href="javascript:void(0)"><i style="font-size:25px;" class="fa fa-star-o"></i></a>
                      <a class="rate" data-rate="5" href="javascript:void(0)"><i style="font-size:25px;" class="fa fa-star-o"></i></a>
                  </div>
                  <div class="mb-3">
                      <label for="exampleFormControlTextarea1" class="form-label">Nội dung dánh giá</label>
                      <textarea class="form-control shadow-none" id="review_content" rows="3"></textarea>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" id="review" class="btn btn-primary">Đánh giá</button>
              </div>
          </div>
      </div>
  </div>
  <section class="content shop-page">
      <div class="container">
          <div class="row">
              <div class="col-md-3 col-sm-12">
                  <ul class="nav flex-column">
                      <li class="nav-item">
                          <a style="<?php echo $_GET['page'] === "account/profile" ? "text-decoration:underline;text-underline-offset:5px" : "" ?>" class="nav-link" href="<?php echo $ROOT_URL ?>/account/profile">Hồ Sơ</a>
                      </li>
                      <li class="nav-item">
                          <a style="<?php echo $_GET['page'] === "account/order_history" ? "text-decoration:underline;text-underline-offset:5px" : "" ?>" class="nav-link" href="<?php echo $ROOT_URL ?>/account/order_history">Lịch Sử Đơn Hàng</a>
                      </li>
                      <li class="nav-item">
                          <a style="<?php echo $_GET['page'] === "account/change_pass" ? "text-decoration:underline;text-underline-offset:5px" : "" ?>" class="nav-link" href="<?php echo $ROOT_URL ?>/account/change_pass">Đổi Mật Khẩu</a>
                      </li>
                  </ul>
              </div>
              <div style="min-height: 500px;" class="col-md-9 col-sm-12">
                  <ul class="nav status-link">
                      <li id="tat_ca" data-status="tất cả" class="nav-item">
                          <a style="padding-left: 0;" class="nav-link" href="javascript:void(0)">Tất Cả</a>
                      </li>
                      <li id="dang_xu_ly" data-status="đang xử lý" class="nav-item">
                          <a class="nav-link" href="javascript:void(0)">Đang Xử Lý</a>
                      </li>
                      <li id="dang_giao" data-status="đang giao" class="nav-item">
                          <a class="nav-link" href="javascript:void(0)">Đang Giao</a>
                      </li>
                      <li id="da_giao" data-status="đã giao" class="nav-item">
                          <a class="nav-link" href="javascript:void(0)">Đã Giao</a>
                      </li>
                      <li id="da_huy" data-status="đã hủy" class="nav-item">
                          <a class="nav-link" href="javascript:void(0)">Đã Hủy</a>
                      </li>
                  </ul>
                  <div id="content"></div>
              </div>
              <!-- FEATURED-PRODUCTS-AREA END -->
          </div>
      </div>
  </section>