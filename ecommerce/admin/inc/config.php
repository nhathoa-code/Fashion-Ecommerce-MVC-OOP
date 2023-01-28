<?php

/**
 * config.php
 *
 * Author: pixelcave
 *
 * Configuration php file. It contains variables used in the template
 *
 */

// Template variables
$template = array(
    'name'        => 'uAdmin',
    'version'     => '2.1',
    'author'      => 'pixelcave',
    'title'       => 'uAdmin - Professional, Responsive and Flat Admin Template',
    'description' => 'uAdmin is a Professional, Responsive and Flat Admin Template created by pixelcave and published on Themeforest',
    'header'      => '', // 'fixed-top', 'fixed-bottom'
    'layout'      => '', // 'fixed'
    'theme'       => '', // 'deepblue', 'deepwood', 'deeppurple', 'deepgreen', '' empty for default
    'active_page' => basename($_SERVER['QUERY_STRING'])
);

// Primary navigation array (the primary navigation will be created automatically based on this array)
$primary_nav = array(
    array(
        'name'  => 'Thống Kê',
        'url'   => 'page=statistic',
        'icon'  => 'fa fa-fire'
    ),
    array(
        'name'  => 'Danh Mục',
        'icon'  => 'fa fa-th-list',
        'sub'   => array(
            array(
                'name' => 'Danh Sách',
                'url' => 'page=category',
                'icon' => ''
            )
        )

    ),
    array(
        'name'  => 'Kích Cỡ',
        'icon'  => 'fa fa-th-list',
        'sub'   => array(
            array(
                'name' => 'Danh Sách',
                'url' => 'page=size_type',
                'icon' => ''
            )
        )
    ),
    array(
        'name'  => 'Sản Phẩm',
        'icon'  => 'fa fa-th-list',
        'sub'   => array(
            array(
                'name' => 'Danh Sách',
                'url' => 'page=product_list',
                'icon' => ''
            ),
            array(
                'name' => 'Thêm Sản Phẩm',
                'url' => 'page=add_product_form',
                'icon' => ''
            )
        )
    ),
    array(
        'name'  => 'Đơn Hàng',
        'icon'  => 'fa fa-th-list',
        'sub'   => array(
            array(
                'name' => 'Danh Sách',
                'url' => 'page=order_list',
                'icon' => ''
            )
        )
    ),
    array(
        'name'  => 'slider',
        'icon'  => 'fa fa-th-list',
        'sub'   => array(
            array(
                'name' => 'Danh Sách',
                'url' => 'page=slider_list',
                'icon' => ''
            )
        )
    )
);
