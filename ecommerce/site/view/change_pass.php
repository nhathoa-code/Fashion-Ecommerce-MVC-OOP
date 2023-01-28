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
              <div class="col-md-9 col-sm-12">
                  <form style="width:50%">
                      <div class="mb-3">
                          <label for="old_pass" class="form-label">Mật khẩu cũ</label>
                          <input type="password" class="form-control shadow-none" id="old_pass">
                      </div>
                      <div class="mb-3">
                          <label for="new_pass" class="form-label">Mật khẩu mới</label>
                          <input type="password" class="form-control shadow-none" id="new_pass">
                      </div>
                      <div class="mb-3">
                          <label for="re_new_pass" class="form-label">Nhập lại mật khẩu mới</label>
                          <input type="password" class="form-control shadow-none" id="re_new_pass">
                      </div>
                      <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                  </form>
              </div>
              <!-- FEATURED-PRODUCTS-AREA END -->
          </div>
      </div>
  </section>