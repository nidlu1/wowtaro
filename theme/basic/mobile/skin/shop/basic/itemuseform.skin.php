<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 사용후기 쓰기 시작 { -->
<div id="sit_use_write" class="w_popup review">
    <h1 class="wp_title text big bold cb">상담후기 쓰기</h1>

    <form name="fitemuse" method="post" action="./itemuseformupdate.php" onsubmit="return fitemuse_submit(this);" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
    <input type="hidden" name="is_id" value="<?php echo $is_id; ?>">
	<input type="hidden" name="is_cat2" value="<?php echo $is_cat2; ?>">
	<input type="hidden" name="ca_id" value="<?php echo $ca_id; ?>">

		<div class="wp_body">
			<ul class="wpb_wrap">
				<li>
					<label for="is_subject" class="sound_only">제목<strong> 필수</strong></label>
					<input type="text" name="is_subject" value="<?php echo get_text($use['is_subject']); ?>" id="is_subject" required class="required input"  maxlength="250" placeholder="제목">
				</li>
				<li class="mb10">
					<label for="is_cat" class="sound_only">분류<strong> 필수</strong></label>
					<select id="is_cat" name="is_cat" class="required select">
						<option value="할인상담">할인상담</option>
						<option value="일반상담">일반상담</option>
					</select>
					<i class="arrow"></i>
				</li>
				<li>
					<strong class="sound_only">내용</strong>
					<?php echo $editor_html; ?>
				</li>
				<li class="wpb_score">
					<span class="sound_only">평점</span>
					<ul>
						<li>
							<input type="radio" name="is_score" value="5" id="is_score5" <?php echo ($is_score==5)?'checked="checked"':''; ?>>
							<i></i>
							<label for="is_score5" class="text cg">
								<div class="wpb_star">
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon on'></i>
								</div>
								매우만족
							</label>
						</li>
						<li>
							<input type="radio" name="is_score" value="4" id="is_score4" <?php echo ($is_score==4)?'checked="checked"':''; ?>>
							<i></i>
							<label for="is_score4" class="text cg">
								<div class="wpb_star">
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon off'></i>
								</div>
								만족
							</label>
						</li>
						<li>
							<input type="radio" name="is_score" value="3" id="is_score3" <?php echo ($is_score==3)?'checked="checked"':''; ?>>
							<i></i>
							<label for="is_score3" class="text cg">
								<div class="wpb_star">
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon off'></i>
									<i class='wpbs_icon off'></i>
								</div>
								보통
							</label>
						</li>
						<li>
							<input type="radio" name="is_score" value="2" id="is_score2" <?php echo ($is_score==2)?'checked="checked"':''; ?>>
							<i></i>
							<label for="is_score2"" class="text cg">
								<div class="wpb_star">
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon off'></i>
									<i class='wpbs_icon off'></i>
									<i class='wpbs_icon off'></i>
								</div>
								불만
							</label>
						</li>
						<li>
							<input type="radio" name="is_score" value="1" id="is_score1" <?php echo ($is_score==1)?'checked="checked"':''; ?>>
							<i></i>
							<label for="is_score1" class="text cg">
								<div class="wpb_star">
									<i class='wpbs_icon on'></i>
									<i class='wpbs_icon off'></i>
									<i class='wpbs_icon off'></i>
									<i class='wpbs_icon off'></i>
									<i class='wpbs_icon off'></i>
								</div>
								매우불만
							</label>
						</li>
					</ul>
				</li>
			</ul>
			<div class="win_btn">
				<input type="submit" value="작성완료" class="btn t1 fr mt10">
			</div>
		</div>
	</form>
	<button type="button" onclick="window.close();" class="wp_btn"><span class="blind">창닫기</span></button>
</div>

<script type="text/javascript">
function fitemuse_submit(f)
{
    <?php echo $editor_js; ?>

    return true;
}
</script>
<!-- } 사용후기 쓰기 끝 -->
