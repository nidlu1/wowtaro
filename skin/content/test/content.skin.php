<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css">', 0);
?>

<article id="ctt" class="ctt_<?php echo $co_id; ?>">
    <header>
        <h1><?php echo $g5['title']; ?></h1>
    </header>

    <div id="content">
		<div class="c_hero">
		   <strong>신선운세 <mark>베스트 상담사 신청</mark></strong>
		</div>
		<div class="c_list">
		   <div class="cl_menu">
			  <a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
			  <span>신선운세</span>
			  <span><mark><a href="/bbs/content.php?co_id=recruit" class="sct_here">베스트 상담사 신청</a></mark></span>
		   </div>
		</div>
		<div class="c_reigster">
			<a href="/bbs/register_form2.php" class="cr_btn">상담사 신청하기</a>
		</div>
    </div>

</article>