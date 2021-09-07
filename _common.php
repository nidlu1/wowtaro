<?php
include_once('./common.php');
/*
 * 접근제어.
 */
//include_once(G5_ADMIN_PATH.'/admin.lib.php');

// 커뮤니티 사용여부
if(G5_COMMUNITY_USE === false) {
    if (!defined('G5_USE_SHOP') || !G5_USE_SHOP)
        die('<p>쇼핑몰 설치 후 이용해 주십시오.</p>');

    define('_SHOP_', true);
}
?>