<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 상담문의 쓰기 시작 { -->
<div id="sit_qa_write" class="new_win">
    <h1 id="win_title">상담문의 쓰기</h1>

    <form name="fitemqa" method="post" action="./itemqaform2update.php" onsubmit="return fitemqa_submit(this);" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
    <input type="hidden" name="iq_id" value="<?php echo $iq_id; ?>">
	<input type="hidden" name="is_cat2" value="<?php echo $is_cat2; ?>">

    <div class="form_01 new_win_con">

        <ul>
            <li>
                <label for="iq_subject">제목 : </label>
                <?php echo get_text($qa['iq_subject']); ?>
            </li>
			<li>
                <label for="iq_question">질문 : </label>
                <p><?php echo $qa['iq_question']; ?></p>
            </li>
            <li>
                <label for="iq_answer">답변</label>
				<textarea id="iq_answer" name="iq_answer" maxlength="65536" style="width: 100%; height: 300px;"><?php echo get_text($qa['iq_answer']); ?></textarea>
                <?php //echo $editor_html; ?>
            </li>
        </ul>

        <div class="win_btn">
            <input type="submit" value="작성완료" class="btn_submit">
            <button type="button" onclick="self.close();" class="btn_close">닫기</button>
        </div>
    </div>

    </form>
</div>

<script type="text/javascript">
function fitemqa_submit(f)
{
    <?php //echo $editor_js; ?>

    return true;
}
</script>
<!-- } 상담문의 쓰기 끝 -->
