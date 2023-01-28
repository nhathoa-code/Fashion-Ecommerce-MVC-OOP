<?php
session_start();
$ROOT_URL = "/ecommerce";
$CONTENT_ADMIN_PATH = "$ROOT_URL/content/admin";
$CONTENT_SITE_PATH = "$ROOT_URL/content/site";
define("DATABASE_NAME", "ecommerce_db");
define("DATABASE_USER_NAME", "root");
define("DATABASE_PASSWORD", "");

function stripVN($str)
{
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    $str = str_replace(' ', '-', $str);
    return $str;
}


function pagination($products_per_page, $total_products, $current_page, $link)
{
    $total_pages = ceil($total_products / $products_per_page);
    if ($total_pages <= 1) {
        return;
    }
    echo "<nav aria-label='Page navigation example'>";
    echo "<ul class='pagination'>";
    if ($current_page >= 2) {
        $previous_page = $current_page - 1;
        echo "<li class='page-item'><a class='page-link' href='$link&current_page=$previous_page'>Previous</a></li>";
    }
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($current_page == $i) {
            echo "<li class='page-item active'><a class='page-link' href='$link&current_page=$i'>$i</a></li>";
        } else {
            echo "<li class='page-item'><a class='page-link' href='$link&current_page=$i'>$i</a></li>";
        }
    }
    if ($current_page < $total_pages) {
        $next_page = $current_page + 1;
        echo "<li class='page-item'><a class='page-link' href='$link&current_page=$next_page'>Next</a></li>";
    }
    echo "</ul>";
    echo "</nav>";
}
