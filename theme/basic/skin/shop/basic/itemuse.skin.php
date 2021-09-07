<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 상품 사용후기 시작 { -->
<section id="sit_use_list">
    <h3>등록된 사용후기</h3>

    <div class="sit_use_top">
        <!--별점 하드코딩-->
        <h4>전체후기 평점</h4>
        <div class="score_info">
          <img src="/shop/img/s_star<?php echo intval($use_dt['is_score'])?>.png" alt="" class="sit_star"> <span class="score_num"><?php echo number_format($use_dt['is_score'],1)?></span>
        </div>
        <!--별점 주석처리-->
        <!-- <?php if ($star_score) { ?>
        <h4>전체후기 평점</h4>
        <div class="score_info">
          <img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $star_score?>.png" alt="" class="sit_star"> <span class="score_num"><?php echo $star_score?></span>
        </div>
        <?php } ?> -->
    </div>

    <?php
    $thumbnail_width = 500;

    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $is_num     = $total_count - ($page - 1) * $rows - $i;
        $is_star    = get_star($row['is_score']);
        $is_name    = get_text($row['is_name']);
        $is_subject = conv_subject($row['is_subject'],50,"…");
        $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
        $is_reply_name = !empty($row['is_reply_name']) ? get_text($row['is_reply_name']) : '';
        $is_reply_subject = !empty($row['is_reply_subject']) ? conv_subject($row['is_reply_subject'],50,"…") : '';
        $is_reply_content = !empty($row['is_reply_content']) ? get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumbnail_width) : '';
        $is_time    = substr($row['is_time'], 2, 8);
        $is_href    = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];
		$is_cat    = get_text($row['is_cat']);

        $hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);

        if ($i == 0) echo '<ol id="sit_use_ol">';
    ?>

        <li class="sit_use_li">
                <div class="user_state">
                  <span class="default"><?php echo $is_cat; ?></span>
                  <h2><?php echo $row['is_best'] == 1 ? "[Best]" : ""; ?><?php echo $is_name; ?></h2>
                  <div class="user_data">
                    <div class="user_star">
                      <img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $is_star; ?>.png" alt="별<?php echo $is_star; ?>개" width="85">
                    </div>
                    <!-- <div class="user_date">
                      <?php echo $is_time; ?>
                    </div> -->
                  </div>
                </div>

            <div id="sit_use_con_<?php echo $i; ?>" class="sit_use_con">
                <div class="sit_use_p">
                    <?php echo $is_content; // 사용후기 내용 ?>

                </div>

                <div class="sit_use_cmd">
                  <?php if( $is_reply_subject ){  ?>
                  <button type="button" class="toggle_reply">1개의 댓글이 있습니다.</button>
                  <?php } ?>
                <?php if ($is_admin || $row['mb_id'] == $member['mb_id']) { ?>
                    <a href="<?php echo $itemuse_form."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="itemuse_form btn01" onclick="return false;">수정</a>
                    <a href="<?php echo $itemuse_formupdate."&amp;is_id={$row['is_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemuse_delete btn01">삭제</a>
                <?php } ?>
				<?php if ($is_admin || $it_id == $member['mb_no']) { ?>
                    <a href="<?php echo $itemuse_form2."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="itemuse_form btn01" onclick="return false;">답글</a>
                <?php } ?>
                </div>

                <?php if( $is_reply_subject ){  //  사용후기 답변 내용이 있다면 ?>
                <div class="sit_use_reply">
                    <div class="use_reply_p">
                        <?php echo $is_reply_content; // 답변 내용 ?>
                    </div>
                </div>
                <?php } //end if ?>
            </div>
        </li>

    <?php }

    if ($i > 0) echo '</ol>';

    if (!$i) echo '<p class="sit_empty">상담후기가 없습니다.</p>';
    ?>

    <div class="board_summary_bottom">
      <?php
      echo itemuse_page($config['cf_write_pages'], $page, $total_page, "./item.php?it_id=$it_id&amp;page=", "");
      ?>
      <a href="<?php echo $itemuse_form; ?>" class="write_btn itemuse_form">후기등록<span class="sound_only"> 새 창</span></a>
    </div>
</section>


<script>
$(function(){
  $(".toggle_reply").click(function(){
      var $con = $(this).parents('.sit_use_cmd').next('.sit_use_reply');
      if($con.is(":visible")) {
          $con.hide();
          $(this).html("1개의 댓글이 있습니다.");
      } else {
        $con.show();
        $(this).html("댓글접기");
      }
  });

    $(".itemuse_form").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(".itemuse_delete").click(function(){
        if (confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.")) {
            return true;
        } else {
            return false;
        }
    });

    $(".sit_use_li_title").click(function(){
        var $con = $(this).siblings(".sit_use_con");
        if($con.is(":visible")) {
            $con.slideUp();
        } else {
            $(".sit_use_con:visible").hide();
            $con.slideDown(
                function() {
                    // 이미지 리사이즈
                    $con.viewimageresize2();
                }
            );
        }
    });

    $(".pg_page").click(function(){
        $("#itemuse").load($(this).attr("href"));
        return false;
    });
});
</script>
<!-- } 상품 사용후기 끝 -->
