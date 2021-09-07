<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<section class="cab_reply">
	<div class="cabr_head">
		<div class="fl">
			<h2><i class="cabrh_stat">답변</i> <span><?php echo get_text($answer['qa_subject']); ?></span></h2>
		</div>
		<div class="fr">
			<div class="cabrh_item">
				<i class="time"></i>
				<span class="text cg tiny s05"><?php echo date("Y.m.d", strtotime($view['qa_datetime'])) ?></span>
			</div>
			<div class="cabrh_item question">
				<a href="<?php echo $rewrite_href; ?>"class=""><i class="pluse"></i>추가질문하기</a>
			</div>
		</div>
	</div>
	<div class="cabr_content">
		<?php echo get_view_thumbnail(conv_content($answer['qa_content'], $answer['qa_html']), $qaconfig['qa_image_width']); ?>
	</div>
	 <div class="cab_buttons mb30">
		<ul class="fr">
			<?php if($answer_update_href) { ?>
			<li><a href="<?php echo $answer_update_href; ?>" class="btn">답변수정</a></li>
			<?php } ?>
			<?php if($answer_delete_href) { ?>
			<li><a href="<?php echo $answer_delete_href; ?>" class="btn mr10" onclick="del(this.href); return false;">답변삭제</a></li>
			<?php } ?>
		</ul>
	</div>
</section>
