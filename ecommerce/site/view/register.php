<section class="content">
    <!-- LOGIN-AREA START -->
    <div class="lognin-area">
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form method="POST" action="<?php echo $ROOT_URL ?>/business/account.php">
                        <div class="new-customers margin-65">
                            <h2 class="title-3">Tạo Tài Khoản Mới</h2>
                            <div class="row margin-bottom-20">
                                <div class="col-sm-12">
                                    <input class="custom-form" name="email" type="email" placeholder="Email" value="<?php echo isset($_SESSION['data']['email']) ? $_SESSION['data']['email'] : "" ?>" />
                                    <?php unset($_SESSION['data']['email']) ?>
                                    <?php if (isset($_SESSION["error"]["email"])) : ?>
                                        <span style="color:red;margin-top:5px"><?php echo $_SESSION["error"]["email"];
                                                                                unset($_SESSION["error"]["email"]) ?></span>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="row margin-bottom-20">
                                <div class="col-sm-12">
                                    <input class="custom-form" name="password" type="password" placeholder="Password" />
                                    <?php if (isset($_SESSION["error"]["password"])) : ?>
                                        <span style="color:red"><?php echo $_SESSION["error"]["password"];
                                                                unset($_SESSION["error"]["password"]) ?></span>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="row margin-bottom-20">
                                <div class="col-sm-12">
                                    <input class="custom-form" name="retype_password" type="password" placeholder="Confirm Password" />
                                    <?php if (isset($_SESSION["error"]["retype_password"])) : ?>
                                        <span style="color:red"><?php echo $_SESSION["error"]["retype_password"];
                                                                unset($_SESSION["error"]["retype_password"]) ?></span>
                                    <?php endif ?>
                                </div>
                            </div>
                            <?php if (isset($_SESSION['message'])) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $_SESSION['message'];
                                    unset($_SESSION['message']) ?>
                                </div>
                            <?php endif ?>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="submit" name="submit_add_account_0" class="custom-form custom-submit no-margin" value="Đăng Ký" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGIN-AREA END -->
</section>