<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<!-- <div id="sit_qa_wbtn">
    <a href="<?php echo $itemqa_form; ?>" class="itemqa_form qa_wr margin_top_05">상담문의 쓰기<span class="sound_only"> 새 창</span></a>
</div> -->

<!-- 상품문의 목록 시작 { -->


    <?php
    $thumbnail_width = 500;
    $iq_num     = $total_count - ($page - 1) * $rows;

    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $iq_name    = get_text($row['iq_name']);
        $iq_subject = conv_subject($row['iq_subject'],50,"…");

        $is_secret = false;
        if($row['iq_secret']) {
            $iq_subject .= ' <img src="'.G5_MSHOP_SKIN_URL.'/img/icon_secret.gif" alt="비밀글">';

            if($is_admin || $member['mb_id' ] == $row['mb_id']) {
                $iq_question = get_view_thumbnail(conv_content($row['iq_question'], 1), $thumbnail_width);
            } else {
                $iq_question = '비밀글로 보호된 문의입니다.';
                $is_secret = true;
            }
        } else {
            $iq_question = get_view_thumbnail(conv_content($row['iq_question'], 1), $thumbnail_width);
        }
        $iq_time    = substr($row['iq_time'], 2, 8);

        $hash = md5($row['iq_id'].$row['iq_time'].$row['iq_ip']);

        $iq_stats = '';
        $iq_style = '';
        $iq_answer = '';

        if ($row['iq_answer'])
        {
            $iq_answer = get_view_thumbnail(conv_content($row['iq_answer'], 1), $thumbnail_width);
            $iq_stats = '답변완료';
            $iq_style = 'done';
            $is_answer = true;
        } else {
            $iq_stats = '답변대기';
            $iq_style = 'yet';
            $iq_answer = '답변이 등록되지 않았습니다.';
            $is_answer = false;
        }
			 if ($i == 0) echo '<table id="sit_qa_ol">';
          if ($i == 0) echo '<thead><tr><th>번호</th><th>상태</th><th>내용</th></tr></thead>';
		   if ($i == 0) echo '<tbody>';
    ?>
        <tr >
          <td>
            <?php echo $i+1; ?>
          </td>
          <td>
            <span class="<?php echo $iq_style; ?>"><?php echo $iq_stats; ?></span>
          </td>
          <td>
            <button type="button" class="qa_li_title"><span><?php echo $iq_subject; ?><i></i></span></button>
          </td>
          <!-- <td class="date">
            <?php echo $iq_time; ?>
          </td> -->
        </tr>

        <tr class="content_sit" id="sit_qa_con_<?php echo $i; ?>">
          <td colspan="4"  class="qa-wr">
		  	<div class="cabc_wrap">
				<div class="cabc_area qustion">
					<strong class="sound_only">문의내용</strong>
					<div class="cabca_wrap">
						<div class="qa_icon q"><i>Q</i></div>
					</div>
					<div class="cabca_txt">
						<?php echo $iq_question; // 상품 문의 내용 ?>
					</div>
				</div>
				<?php if(!$is_secret) { ?>
				<div class="cabc_area answer clearfix">
					<strong class="sound_only">답변</strong>
					<div class="cabca_wrap <?php if ($is_admin || $it_id == $member['mb_no'] || ($row['iq_mb_id'] == $member['mb_id'] && !$is_answer)) { ?>on<?php }?>">
						<div class="qa_icon a"><i>A</i></div>
							<div class="cabca_info">
								<a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=&it_id=<?php echo $row['mb_no']; ?>">
									<div class="cabcai_pic">
										<img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $row['mb_no']; ?>/<?php echo $row['mb_8']; ?>" alt="<?php echo $row['mb_nick']; ?> <?php echo $row['mb_id']; ?>번">
									</div>
									<div class="cabcai_txt">
									<!--카테고리 스타일2-->
									
										<!--타로일때-->
										<p>
											<?php echo $ca['ca_name'] ?>
										</p>

										<!--사주일때
										<span class="cate_saju">
										  <?php echo $row['is_cat2']; ?>
										</span>-->

										<!--신점일때
										<span class="cate_sin">
										  <?php echo $row['is_cat2']; ?>
										</span>-->

										<!--꿈해몽일때
										<span class="cate_dream">
										  <?php echo $row['is_cat2']; ?>
										</span>-->

										<!--펫타로일때
										<span class="cate_dream">
										  <?php echo $row['is_cat2']; ?>

										<!--//카테고리 스타일2-->
										<span class="cabcai_wrap">
											<span><?php echo $row['mb_nick']; ?></span>
											<span><mark><?php echo $row['mb_id']; ?>번</mark></span>
										</span>
									</div>
								</a>
							</div>
					</div>
					<div class="cabca_txt">
					  <?php echo $iq_answer; ?>
					</div>
				</div>
				<?php } ?>
				<div class="cabc_edit">
				  <?php if ($is_admin || ($row['iq_mb_id'] == $member['mb_id'] && !$is_answer)) { ?>
					  <a href="<?php echo $itemqa_form."&amp;iq_id={$row['iq_id']}&amp;w=u"; ?>" class="cabce_btn fix" onclick="return false;">수정</a>
					  <a href="<?php echo $itemqa_formupdate."&amp;iq_id={$row['iq_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="cabce_btn del">삭제</a>
					  <!-- <button type="button" onclick="javascript:itemqa_update(<?php echo $i; ?>);" class="btn01">수정</button>
					  <button type="button" onclick="javascript:itemqa_delete(fitemqa_password<?php echo $i; ?>, <?php echo $i; ?>);" class="btn01">삭제</button> -->
				  <?php } ?>
				  <?php if ($is_admin || $it_id == $member['mb_no']) { ?>
					  <a href="<?php echo $itemqa_form2."&amp;iq_id={$row['iq_id']}&amp;w=u"; ?>" class="cabce_btn reply" onclick="return false;">답글</a>
				  <?php } ?>
				</div>
			</div>
          </td>
        </tr>
    <?php
        $iq_num--;
    }
    if ($i > 0) echo '</tbody>';
    if ($i > 0) echo '</table>';

    if (!$i) echo '<p class="sit_empty">상담문의가 없습니다.</p>';
    ?>

    <!--<a href="<?php echo $itemqa_list; ?>" id="itemqa_list" class="more_wr">더보기</a>-->



<div class="cabc_buttons">
	<?php
		echo itemqa_page_moblie($config['cf_write_pages'], $pageqa, $total_page, "./item.php?ca_id=$ca_id&it_id=$it_id&amp;pageqa=", "#cab_qa");
	?>
</div>
<div class="cabc_buttons">
	<a href="<?php echo $itemqa_form; ?>" class="write_btn itemqa_form">문의하기<span class="sound_only"> 새 창</span></a>
</div>
<script>
$(function(){
    $(".itemqa_form").click(function(){
        window.open(this.href, "itemqa_form", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(".cabce_btn.fix").click(function(){
        window.open(this.href, "itemqa_form", "width=810,height=680,scrollbars=1");
        return false;
    });
	
	 $(".cabce_btn.reply").click(function(){
        window.open(this.href, "itemqa_form", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(".cabce_btn.del").click(function(){
        return confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.");
    });

     $('.qa_li_title').click(function(){
		var originParent = $(this).parents('tr');
		if(originParent.next('.content_sit').hasClass("on")){
			originParent.next('.content_sit').removeClass("on")
		}else{
			originParent.next('.content_sit').addClass("on")
		}
		if($(this).hasClass("on")){
			$(this).removeClass("on");
		}else{
			$(this).addClass("on");
		}
	  });

    $(".qa_page").click(function(){
        $("#itemqa").load($(this).attr("href"));
        return false;
    });

    $("a#itemqa_list").on("click", function() {
        window.opener.location.href = this.href;
        self.close();
        return false;
    });
});
</script>
<!-- } 상품문의 목록 끝 -->
