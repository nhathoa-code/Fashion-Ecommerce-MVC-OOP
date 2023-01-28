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
                  <form class="row">
                      <div class="col-md-5 col-sm-12">
                          <div class="mb-3">
                              <label for="username" class="form-label">Tên đăng nhập</label>
                              <input type="text" class="form-control shadow-none" id="username">
                          </div>
                          <div class="mb-3">
                              <label for="fullname" class="form-label">Họ Tên</label>
                              <input type="text" class="form-control shadow-none" id="fullname">
                          </div>
                          <div class="mb-3">
                              <label for="email" class="form-label">Email</label>
                              <input type="text" class="form-control shadow-none" id="email">
                          </div>
                          <div class="mb-3">
                              <label for="phone" class="form-label">Số điện thoại</label>
                              <input type="text" class="form-control shadow-none" id="phone">
                          </div>
                          <div class="mb-3">
                              <input type="checkbox" id="save_to_deli_info" name="save_to_deli_info"> <label for="save_to_deli_info">Lưu vào thông tin giao hàng</label>
                          </div>
                          <button type="submit" class="btn btn-primary">Cập nhật hồ sơ</button>
                      </div>
                      <div class="col-md-5 col-sm-12 offset-md-1">
                          <div class="mb-3">
                              <label for="address" class="form-label">Địa chỉ</label>
                              <input type="text" class="form-control shadow-none" id="address">
                          </div>
                          <div class="mb-3">
                              <label for="province" class="form-label">Tỉnh Thành</label>
                              <select class="form-select" id="province">
                              </select>
                          </div>
                          <div class="mb-3">
                              <label for="district" class="form-label">Quận huyện</label>
                              <select class="form-select" id="district">
                              </select>
                          </div>
                          <div class="mb-3">
                              <label for="ward" class="form-label">Phường xã</label>
                              <select class="form-select" id="ward">
                              </select>
                          </div>
                      </div>
                  </form>
              </div>
              <!-- FEATURED-PRODUCTS-AREA END -->
          </div>
      </div>
  </section>