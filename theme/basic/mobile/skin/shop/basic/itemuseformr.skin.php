<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 사용후기 쓰기 시작 { -->
<div id="sit_use_write" class="new_win">
    <h1 id="win_title">답변하기</h1>

    <form name="fitemuse" method="post" action="./itemuseform2update.php" onsubmit="return fitemuse_submit(this);" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
    <input type="hidden" name="is_id" value="<?php echo $is_id; ?>">
    <input type="hidden" name="is_mobile_shop" value="1">
	<input type="hidden" name="is_cat2" value="<?php echo $is_cat2; ?>">

    <div class="form_01">

        <ul>
            <li>
                <label for="is_reply_subject" class="sound_only">제목</label>
                <input type="text" name="is_reply_subject" value="<?php echo get_text($use['is_reply_subject']); ?>" id="is_reply_subject" required class="required frm_input" minlength="2" maxlength="250" placeholder="제목">
            </li>
            <li>
                <span class="sound_only">내용</span>
				<textarea id="is_reply_content" name="is_reply_content" maxlength="65536" style="width: 100%; height: 300px;"><?php echo get_text($use['is_reply_content']); ?></textarea>
                <?php //echo $editor_html; ?>
            </li>
        </ul>
    </div>

    <div class="win_btn">
        <input type="submit" value="작성완료" class="btn_submit">
        <button type="button" onclick="self.close();" class="btn_close">닫기</button>
    </div>

    </form>
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
