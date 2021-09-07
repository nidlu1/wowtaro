<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<?php
if (G5_IS_MOBILE) {
    echo '<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
	echo '<meta content="yes" name="apple-mobile-web-app-capable" />'.PHP_EOL;
	echo '<meta content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" name="viewport" />'.PHP_EOL;

} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">'.PHP_EOL;
}

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>
<title><?php echo $g5_head_title; ?></title>
<link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR:300,400,500,700|Noto+Serif+KR:400,500,600,700&amp;subset=korean" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Nanum+Gothic&display=swap" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
<meta name="description" content="혼자 속 앓이 하지마세요 신선운세가 있습니다.">
<meta name="keywords" content="신선운세">
<meta name="author" content="신선운세 - 혼자 속 앓이 하지마세요 신선운세가 있습니다." />
<meta name="format-detection" content="telephone=no">
<meta property="og:type" content="website">
<meta property="og:title" content="신선운세 - 혼자 속 앓이 하지마세요 신선운세가 있습니다.">
<meta property="og:site_name" content="신선운세">
<meta property="og:description" content="혼자 속 앓이 하지마세요 신선운세가 있습니다.">
<meta property="og:image" content="/css/favicon_1200x630.png">
<meta name="twitter:description" content="혼자 속 앓이 하지마세요 신선운세가 있습니다.">
<meta name="twitter:image" content="/css/favicon_270x270.png">
<link rel="shortcut icon" href="/css/favicon.ico">
<link rel="icon" href="/css/favicon.png">
<link rel="apple-touch-icon" href="/css/favicon.png">
<?php
$shop_css = '';
if (defined('_SHOP_')) $shop_css = '_shop';
echo '<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/'.(G5_IS_MOBILE?'mobile':'default').$shop_css.'.css?ver='.G5_CSS_VER.'">'.PHP_EOL;
?>
<!--[if lte IE 8]>
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
</script>
<link rel="stylesheet" href="/css/owl.carousel.min.css">
<?php if(G5_IS_MOBILE) {
	echo '<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/m_layout.css">'.PHP_EOL;
	echo '<link rel="stylesheet" href="/css/m/init.css">'.PHP_EOL;
	echo '<link rel="stylesheet" href="/css/m/common.css">'.PHP_EOL;
	echo '<link rel="stylesheet" href="/css/m/layout.css">'.PHP_EOL;
	echo '<link rel="stylesheet" href="/css/m/lightgallery.css">'.PHP_EOL;
	} else {
	echo '<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/layout.css">'.PHP_EOL;
	echo '<link rel="stylesheet" href="/css/init.css">'.PHP_EOL;
	echo '<link rel="stylesheet" href="/css/common.css">'.PHP_EOL;
	echo '<link rel="stylesheet" href="/css/layout.css">'.PHP_EOL;
	}
?>
<script src="<?php echo G5_JS_URL ?>/jquery-1.8.3.min.js"></script>
<?php
if (defined('_SHOP_')) {
    if(!G5_IS_MOBILE) {
?>
<script src="<?php echo G5_JS_URL ?>/jquery.shop.menu.js?ver=<?php echo G5_JS_VER; ?>"></script>
<?php
    }
} else {
?>
<script src="<?php echo G5_JS_URL ?>/jquery.menu.js?ver=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>
<script src="<?php echo G5_JS_URL ?>/common.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_JS_URL ?>/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_JS_URL ?>/placeholders.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<script src="/js/jquery.min.js"></script>
<script src="/js/owl.carousel.min.js"></script>
<?php if(G5_IS_MOBILE) {
	echo '<script src="/js/m/lightgallery.js"></script>'.PHP_EOL;
	echo '<script src="/js/m/lg-zoom.js"></script>'.PHP_EOL;
	echo '<script src="/js/m/lib.js"></script>'.PHP_EOL;
	} else {
	echo '<script src="/js/lib.js"></script>'.PHP_EOL;
	}
?>
<link rel="stylesheet" href="<?php echo G5_JS_URL ?>/font-awesome/css/font-awesome.min.css">
<script src="https://use.fontawesome.com/releases/v5.2.0/js/all.js"></script>
<?php
if(G5_IS_MOBILE) {
    echo '<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
}
if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>
</head>
<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>
<?php
if ($is_member) { // 회원이라면 로그인 중이라는 메세지를 출력해준다.
    $sr_admin_msg = '';
    if ($is_admin == 'super') $sr_admin_msg = "최고관리자 ";
    else if ($is_admin == 'group') $sr_admin_msg = "그룹관리자 ";
    else if ($is_admin == 'board') $sr_admin_msg = "게시판관리자 ";

    echo '<div id="hd_login_msg">'.$sr_admin_msg.get_text($member['mb_nick']).'님 로그인 중 ';
    echo '<a href="'.G5_BBS_URL.'/logout.php">로그아웃</a></div>';
}
?>
<!-- ADN Tracker[공통] start -->
<script type="text/javascript">
var adn_param = adn_param || [];
adn_param.push([{ 	
 ui:'101897',
 ut:'Home'
}]);
</script>
<script type="text/javascript" async src="//fin.rainbownine.net/js/adn_tags_1.0.0.js"></script>
<!-- ADN Tracker[공통] end -->