<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 사용후기 쓰기 시작 { -->
<div id="sit_use_write" class="w_popup review">
	<h1 class="wp_title text big bold cb">답변하기</h1>

    <form name="fitemuse" method="post" action="./itemuseform2update.php" onsubmit="return fitemuse_submit(this);" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
    <input type="hidden" name="is_id" value="<?php echo $is_id; ?>">
	<input type="hidden" name="is_cat2" value="<?php echo $is_cat2; ?>">
	<input type="hidden" name="ca_id" value="<?php echo $ca_id; ?>">

   <div class="wp_body">
        <ul class="wpb_wrap">
            <li>
                <label for="is_reply_subject" class="sound_only">제목<strong> 필수</strong></label>
                <input type="text" name="is_reply_subject" value="<?php echo get_text($use['is_reply_subject']); ?>" id="is_reply_subject" required class="required input"  maxlength="250" placeholder="제목">
            </li>
            <li>
                <strong  class="sound_only">내용</strong>
				<textarea id="is_reply_content" name="is_reply_content" maxlength="65536" class="textarea" style="width: 100%; height: 300px;"><?php echo get_text($use['is_reply_content']); ?></textarea>
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
function fitemuse_submit(f)
{
    <?php //echo $editor_js; ?>

	/*var cnt_byte2 = check_byte2("is_reply_content");
	//alert("test => " + cnt_byte2);return false;
	if (cnt_byte2 > 200) {
		alert("내용은 100자 이내로 작성해 주세요. 현재 "+(cnt_byte2/2)+"자 입니다.");
		f.is_reply_content.focus();
		return false;
	}*/

    return true;
}
</script>
<!-- } 사용후기 쓰기 끝 -->
