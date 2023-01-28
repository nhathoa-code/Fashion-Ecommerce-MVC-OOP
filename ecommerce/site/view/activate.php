<?php

require_once __DIR__ . "/../../business/database.php";

require_once __DIR__ . "/../../business/account.php";

$account = new account();

$account->token = isset($_GET["token"]) ? $_GET["token"] : "";

if ($account->check_token()) {
    $account->active_account();
    echo "<p>Kích hoạt tài khoản thành công</p>";
    echo "<a href='http://localhost{$ROOT_URL}/dang-nhap'>Đăng nhập</a>";
} else {
    echo "Token không hợp lệ";
}
