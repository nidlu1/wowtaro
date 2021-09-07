<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>


<?php
if($is_admin) // 관리자이면 답변등록
{
?>
<h2 class="title t1 bold cb s05 mb15 mt50 left">답변등록</h2>
<section class="cab_form ">
    <form name="fanswer" method="post" action="./qawrite_update.php" onsubmit="return fwrite_submit(this);" autocomplete="off">
    <input type="hidden" name="qa_id" value="<?php echo $view['qa_id']; ?>">
    <input type="hidden" name="w" value="a">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">
    <?php
    $option = '';
    $option_hidden = '';
    $option = '';

    if ($is_dhtml_editor) {
        $option_hidden .= '<input type="hidden" name="qa_html" value="1">';
    } else {
        $option .= "\n".'<input type="checkbox" id="qa_html" name="qa_html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="qa_html">html</label>';
    }

    echo $option_hidden;
    ?>
           <!--  <?php if ($option) { ?>
            <li>
                옵션
                <?php echo $option; ?>
            </li>
            <?php } ?> -->
			<div class="cabf_wrap p15">
				<div class="cabf_title">
					<label class="text middle cb s05" for="qa_subject">제목<strong class="sound_only">필수</strong></label>
				</div>
				<div class="cabf_content">
					<input type="text" name="qa_subject" value="<?php echo get_text($write['qa_subject']); ?>" id="qa_subject" required class="frm_input full_input required" size="50" maxlength="255">
				</div>
			</div>
			<div class="cabf_wrap p15">
				<div class="cabf_title">
					<label class="text middle cb s05" for="qa_content">내용<strong class="sound_only">필수</strong></label>
				</div>
				<div class="cabf_content" <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
					<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
				</div>
			</div>

   <div class="cab_buttons mt50">
        <input type="submit" value="답변쓰기" id="btn_submit" accesskey="s" class="btn t1 fr">
    </div>
    </form>

    <script>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "2";
            else
                obj.value = "1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.qa_subject.value,
                "content": f.qa_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.qa_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_qa_content) != "undefined")
                ed_qa_content.returnFalse();
            else
                f.qa_content.focus();
            return false;
        }

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>
</section>
<?php
}
else
{
?>
<section class="cab_reply">
	<div class="cabr_head">
		<div class="fl">
			<h2><span>고객님의 문의에 대한 답변을 준비 중입니다.</span></h2>
		</div>
	</div>
</section>

<?php
}
?>

