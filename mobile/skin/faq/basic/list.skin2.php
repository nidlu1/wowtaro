<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$faq_skin_url.'/style.css">', 0);
?>

<div class="c_hero" id="sub_callcenter">
	<strong>신선운세 <mark>이용안내</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span>고객센터</span>
		<span><mark><a href="/bbs/faq2.php?fm_id=3" class="sct_here ">이용안내</a></mark></span>
	</div>
</div>
<!-- 이용안내 시작 { -->
<div class="c_area">
	<div class="wrap">
		<div class="ca_customrtab">
			<ul>
				<li><a href="/bbs/faq.php?fm_id=4">FAQ</a></li>
				<li><a href="/bbs/qalist.php">1:1고객문의</a></li>
				<li class="active"><a href="/bbs/faq2.php?fm_id=3">이용안내</a></li>
				<?php if ($is_admin || $member['mb_level'] == 3)  { ?>
				<li><a href="/bbs/board.php?bo_table=notice2">공지사항</a></li>
				<?php } else {?>
				<li><a href="/bbs/board.php?bo_table=notice">공지사항</a></li>
				<?php }?>
			</ul>
		</div>
		<div class="ca_faq guide">
			<?php // FAQ 내용
			if( count($faq_list) ){
			?>
				<h2 class="blind"><?php echo $g5['title']; ?> 목록</h2>
				<ol>
					<?php
					foreach($faq_list as $key=>$v){
						if(empty($v))
							continue;
					?>
					<li>
						<div class="caf_wrap">
							<h3 class="caf_title">
								<i class="caf_icon"></i><a href="#none" onclick="return faq_open(this);"><div><?php echo conv_content($v['fa_subject'], 1); ?></div></a>
							</h3>
							<div class="caf_content">
								<?php echo conv_content($v['fa_content'], 1); ?>
								<!-- <div class="con_closer"><button type="button" class="closer_btn btn_b03">닫기</button></div> -->
								 
							</div>
						</div>
					</li>
					<?php
					}
					?>
				</ol>
			<?php

			} else {
				if($stx){
					echo '<p class="empty_list">검색된 게시물이 없습니다.</p>';
				} else {
					echo '<div class="empty_list">등록된 FAQ가 없습니다.';
					if($is_admin)
						echo '<br><a href="'.G5_ADMIN_URL.'/faqmasterlist.php">FAQ를 새로 등록하시려면 FAQ관리</a> 메뉴를 이용하십시오.';
					echo '</div>';
				}
			}
			?>
		</div>

		<?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

		<?php
		// 하단 HTML
		echo '<div id="faq_thtml">'.conv_content($fm['fm_tail_html'], 1).'</div>';

		if ($timg_src)
			echo '<div id="faq_timg" class="faq_img"><img src="'.$timg_src.'" alt=""></div>';
		?>


<!-- } FAQ 끝 -->

<!-- <?php
if ($admin_href)
    echo '<div class="faq_admin"><a href="'.$admin_href.'" class="btn_admin btn">FAQ 수정</a></div>';
?> -->

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<script>
$(function() {
    $(".closer_btn").on("click", function() {
        $(this).closest(".caf_content").slideToggle();
    });
});

function faq_open(el)
{
    var $con = $(el).closest("li").find(".caf_content");
	var $con2 = $(el).closest("li").find(".caf_wrap");
    if($con.is(":visible")) {
        $con.slideUp();
		 $con2.removeClass("on");
    } else {
		//$(".ca_faq .caf_wrap .caf_content:visible").css("display", "none");
		 //$(".ca_faq .caf_wrap").removeClass("on");
		$con2.addClass("on");
        $con.slideDown(
            function() {
                // 이미지 리사이즈
                $con.viewimageresize2();
            }
        );
    }

    return false;
}
</script>
