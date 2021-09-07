<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 상품문의 쓰기 시작 { -->
<div id="sit_qa_write" class="w_popup review">
	<h1 class="wp_title text big bold cb">상담문의 쓰기</h1>

	<form name="fitemqa" method="post" action="./itemqaform2update.php" onsubmit="return fitemqa_submit(this);" autocomplete="off">
	<input type="hidden" name="w" value="<?php echo $w; ?>">
	<input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
	<input type="hidden" name="iq_id" value="<?php echo $iq_id; ?>">
	<input type="hidden" name="is_cat2" value="<?php echo $is_cat2; ?>">
	<div class="wp_body">
		<ul class="wpb_wrap">
			<li>
				<label for="iq_subject" class="text cg vertical middle">제목 : </label>
				<span class="text cg vertical middle"><?php echo get_text($qa['iq_subject']); ?></span>
			</li>
			<li class="mt10">
				<label for="iq_question" class="text cg vertical middle mpb_qustion">질문 : </label>
				<p class="wpb_content"><?php echo $qa['iq_question']; ?>
			</li>
			<li class="mt20">
				<label for="iq_answer" class="text cb vertical middle">답변</label>
				<textarea id="iq_answer" name="iq_answer" maxlength="65536" class="textarea" style="width: 100%; height: 300px;"><?php echo get_text($qa['iq_answer']); ?></textarea>
				<?php //echo $editor_html; ?>
			</li>
		</ul>
		<div class="win_btn">
			<input type="submit" value="작성완료" class="btn t1 fr mt20">
		</div>
	</div>

	</form>
	<button type="button" onclick="window.close();" class="wp_btn"><span class="blind">창닫기</span></button>
</div>

<script type="text/javascript">
function fitemqa_submit(f)
{
    <?php //echo $editor_js; ?>

    return true;
}
</script>
<!-- } 상품문의 쓰기 끝 -->
