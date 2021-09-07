<?php
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) return;


$menu['menu400'] = array (
    array('400000', '쇼핑몰관리', G5_ADMIN_URL.'/shop_admin/', 'shop_config'),
    array('400100', '주문내역', G5_ADMIN_URL.'/shop_admin/orderlist.php', 'scf_order', 1),
    array('400200', '포인트관리', G5_ADMIN_URL.'/point_list.php', 'mb_point'),
    array('400210', '포인트획득관리', G5_ADMIN_URL.'/pointuse_list.php', 'mb_pointuse'),
    array('400300', '결제상품관리', G5_ADMIN_URL.'/paylist.php', 'scf_pay'),
    array('400310', '5분/10분무료 설정', G5_ADMIN_URL.'/event.php', 'cf_event'),
    array('400400', '게시판관리', ''.G5_ADMIN_URL.'/board_list.php', 'bbs_board'),
    array('400500', '상담후기', G5_ADMIN_URL.'/shop_admin/itemuselist.php', 'scf_ps'),
    array('400510', '상담문의', G5_ADMIN_URL.'/shop_admin/itemqalist.php', 'scf_item_qna'),
    array('400520', '1:1문의설정', ''.G5_ADMIN_URL.'/qa_config.php', 'qa'),
    array('400600', '기본환경설정', G5_ADMIN_URL.'/config_form.php',   'cf_basic'),
    array('400610', '배너관리', G5_ADMIN_URL.'/shop_admin/bannerlist.php', 'scf_banner', 1),
    array('400620', '팝업레이어관리', G5_ADMIN_URL.'/newwinlist.php', 'scf_poplayer'),
    array('400710', '해시태그관리', G5_ADMIN_URL.'/hashtaglist_v1.php', 'scf_hashtag'),
    array('400720', '세부분야관리', G5_ADMIN_URL.'/hashtaglist.php', 'scf_hashtag'),
    
   array('400300', '쇼핑몰설정', G5_ADMIN_URL.'/shop_admin/configform.php', 'scf_config'),
	array('400420', '주문내역출력', G5_ADMIN_URL.'/shop_admin/orderprint.php', 'sst_print_order', 1),
    array('400440', '개인결제관리', G5_ADMIN_URL.'/shop_admin/personalpaylist.php', 'scf_personalpay', 1),
    array('400200', '분류관리', G5_ADMIN_URL.'/shop_admin/categorylist.php', 'scf_cate'),
    array('400300', '상품관리', G5_ADMIN_URL.'/shop_admin/itemlist.php', 'scf_item'),
    array('400620', '상품재고관리', G5_ADMIN_URL.'/shop_admin/itemstocklist.php', 'scf_item_stock'),
    array('400610', '상품유형관리', G5_ADMIN_URL.'/shop_admin/itemtypelist.php', 'scf_item_type'),
    array('400500', '상품옵션재고관리', G5_ADMIN_URL.'/shop_admin/optionstocklist.php', 'scf_item_option'),
    array('400800', '쿠폰관리', G5_ADMIN_URL.'/shop_admin/couponlist.php', 'scf_coupon'),
    array('400810', '쿠폰존관리', G5_ADMIN_URL.'/shop_admin/couponzonelist.php', 'scf_coupon_zone'),
    array('400750', '추가배송비관리', G5_ADMIN_URL.'/shop_admin/sendcostlist.php', 'scf_sendcost', 1),
    array('400410', '미완료주문', G5_ADMIN_URL.'/shop_admin/inorderlist.php', 'scf_inorder', 1),
);
?>