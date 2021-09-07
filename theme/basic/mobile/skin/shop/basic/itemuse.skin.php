<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>



<!-- 상품 사용후기 시작 { -->
<div class="total-score">
  <h3>전체후기 평점</h3>
  <div class="score-wr">
    <i class="xi-star"></i><i class="xi-star"></i><i class="xi-star"></i><i class="xi-star"></i><i class="xi-star"></i>
    <span>5.0</span>
  </div>
</div>

<div id="sit_use_wbtn">
    <a href="<?php echo $itemuse_form; ?>" class="qa_wr itemuse_form " onclick="return false;">상담후기 쓰기<span class="sound_only"> 새 창</span></a>
</div>

<ul class="use-tab clearfix">
  <li class="on">
    전체상담후기
  </li>
  <li>
    할인상담후기
  </li>
  <li>
    일반상담후기
  </li>
</ul>
<div class="sit-use-wr">
  <!--전체상담후기-->
  <div class="sit_use_list sit_use_list1">

      <?php
      $thumbnail_width = 500;

      for ($i=0; $row=sql_fetch_array($result); $i++)
      {
          $is_num     = $total_count - ($page - 1) * $rows - $i;
          $is_star    = get_star($row['is_score']);
          $is_name    = get_text($row['is_name']);
          $is_subject = conv_subject($row['is_subject'],50,"…");
          //$is_content = ($row['wr_content']);
          $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
          $is_reply_name = !empty($row['is_reply_name']) ? get_text($row['is_reply_name']) : '';
          $is_reply_subject = !empty($row['is_reply_subject']) ? conv_subject($row['is_reply_subject'],50,"…") : '';
          $is_reply_content = !empty($row['is_reply_content']) ? get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumbnail_width) : '';
          $is_time    = substr($row['is_time'], 2, 8);
          $is_href    = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];
/*
 * 모바일 상담후기 카테고리를 결정하는 기능.
 * 작성자: 한승희 nidlu123@gmail.comC:\xampp\htdocs\신선운세\theme\basic\mobile\skin\shop\basic\itemuse.skin.php
 */
//          $is_cat    = get_text($row['is_cat']) == "일반상담" ? '<span class="counsel-cate counsel-cate1">일반상담</span>' : '<span class="counsel-cate counsel-cate2">할인상담</span>';
          switch (get_text($row['is_cat'])){
              case "일반상담":
                  $is_cat = '<span class="counsel-cate counsel-cate1">일반상담</span>';
                  break;
              case "할인상담":
                  $is_cat = '<span class="counsel-cate counsel-cate1">할인상담</span>';
                  break;
              case "이벤트상담":
                  $is_cat = '<span class="counsel-cate counsel-cate1">이벤트상담</span>';
                  break;
              default :
                  $is_cat = '<span class="counsel-cate counsel-cate1">이벤트상담</span>';
                  break;
          }

          $hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);

          if ($i == 0) echo '<ol id="sit_use_ol">';
      ?>

          <li class="sit_use_li">
              <!-- <button type="button" class="sit_use_li_title"><?php echo $is_subject; ?></button> -->
              <div class="sit_use_div">
                  <span class="counsel-cate-wr">
				    <?php echo $is_cat; ?>
                    <!--<span class="counsel-cate counsel-cate1">일반상담</span>
                     할인상담일때 글씨, 배경색 달라짐
                     <span class="counsel-cate counsel-cate2">할인상담</span> -->
                  </span>
                  <span><?php echo $row['is_best'] == 1 ? "[Best]" : ""; ?><?php echo $is_name; ?></span>
                  <span class="sit_use_star"><img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $is_star; ?>.png" alt="별<?php echo $is_star; ?>개"></span>
              </div>

              <div id="sit_use_con_<?php echo $i; ?>" class="sit_use_con">
                  <div class="sit_use_p">
                      <?php echo $is_content; // 사용후기 내용 ?>
                  </div>

                  <?php if ($is_admin || $row['mb_id'] == $member['mb_id']) { ?>
                  <div class="sit_use_cmd">
                      <a href="<?php echo $itemuse_form."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="itemuse_form btn01" onclick="return false;">수정</a>
                      <a href="<?php echo $itemuse_formupdate."&amp;is_id={$row['is_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemuse_delete btn01">삭제</a>
                  <?php } ?>
				  <?php if ($is_admin || $it_id == $member['mb_no']) { ?>
                    <a href="<?php echo $itemuse_form2."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="itemuse_form btn01" onclick="return false;">답글</a>
                <?php } ?>

                  <?php if( $is_reply_subject ){  //  사용후기 답변 내용이 있다면 ?>
				  <button type="button" class="toggle_reply">1개의 댓글이 있습니다.</button>

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

      <a href="/shop/item.php?ca_id=<?php echo $ca_id; ?>&it_id=<?php echo $it_id; ?>&anchor=sit_use&page=<?php echo $page+1 ?>" id="itemuse_list" class="more_wr">더보기</a>
  </div><!--sit_use_list1-->

<!--할인상담후기 더미-->
  <div class="sit_use_list sit_use_list2">

      <?php
      $thumbnail_width = 500;

      for ($i=0; $row=sql_fetch_array($result2); $i++)
      {
          $is_num     = $total_count - ($page - 1) * $rows - $i;
          $is_star    = get_star($row['is_score']);
          $is_name    = get_text($row['is_name']);
          $is_subject = conv_subject($row['is_subject'],50,"…");
          //$is_content = ($row['wr_content']);
          $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
          $is_reply_name = !empty($row['is_reply_name']) ? get_text($row['is_reply_name']) : '';
          $is_reply_subject = !empty($row['is_reply_subject']) ? conv_subject($row['is_reply_subject'],50,"…") : '';
          $is_reply_content = !empty($row['is_reply_content']) ? get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumbnail_width) : '';
          $is_time    = substr($row['is_time'], 2, 8);
          $is_href    = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];
		  $is_cat    = get_text($row['is_cat']) == "일반상담" ? '<span class="counsel-cate counsel-cate1">일반상담</span>' : '<span class="counsel-cate counsel-cate2">할인상담</span>';

          $hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);

          if ($i == 0) echo '<ol id="sit_use_ol">';
      ?>

          <li class="sit_use_li">
              <!-- <button type="button" class="sit_use_li_title"><?php echo $is_subject; ?></button> -->
              <div class="sit_use_div">
                  <span class="counsel-cate-wr">
                    <?php echo $is_cat; ?>
                    <!--<span class="counsel-cate counsel-cate1">일반상담</span>
                     할인상담일때 글씨, 배경색 달라짐
                     <span class="counsel-cate counsel-cate2">할인상담</span> -->
                  </span>
                  <span><?php echo $row['is_best'] == 1 ? "[Best]" : ""; ?><?php echo $is_name; ?></span>
                  <span class="sit_use_star"><img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $is_star; ?>.png" alt="별<?php echo $is_star; ?>개"></span>
              </div>

              <div id="sit_use_con_<?php echo $i; ?>" class="sit_use_con">
                  <div class="sit_use_p">
                      <?php echo $is_content; // 사용후기 내용 ?>
                  </div>

                  <?php if ($is_admin || $row['mb_id'] == $member['mb_id']) { ?>
                  <div class="sit_use_cmd">
                      <a href="<?php echo $itemuse_form."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="itemuse_form btn01" onclick="return false;">수정</a>
                      <a href="<?php echo $itemuse_formupdate."&amp;is_id={$row['is_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemuse_delete btn01">삭제</a>
                  <?php } ?>

                  <?php if( $is_reply_subject ){  //  사용후기 답변 내용이 있다면 ?>
				  <button type="button" class="toggle_reply">1개의 댓글이 있습니다.</button>

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

      <a href="/shop/item.php?ca_id=<?php echo $ca_id; ?>&it_id=<?php echo $it_id; ?>&anchor=sit_use&page=<?php echo $page+1 ?>" id="itemuse_list" class="more_wr">더보기</a>
  </div><!--sit_use_list2-->


<!--일반상담후기-->
  <div class="sit_use_list sit_use_list3">

      <?php
      $thumbnail_width = 500;

      for ($i=0; $row=sql_fetch_array($result3); $i++)
      {
          $is_num     = $total_count - ($page - 1) * $rows - $i;
          $is_star    = get_star($row['is_score']);
          $is_name    = get_text($row['is_name']);
          $is_subject = conv_subject($row['is_subject'],50,"…");
          //$is_content = ($row['wr_content']);
          $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
          $is_reply_name = !empty($row['is_reply_name']) ? get_text($row['is_reply_name']) : '';
          $is_reply_subject = !empty($row['is_reply_subject']) ? conv_subject($row['is_reply_subject'],50,"…") : '';
          $is_reply_content = !empty($row['is_reply_content']) ? get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumbnail_width) : '';
          $is_time    = substr($row['is_time'], 2, 8);
          $is_href    = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];
		  $is_cat    = get_text($row['is_cat']) == "일반상담" ? '<span class="counsel-cate counsel-cate1">일반상담</span>' : '<span class="counsel-cate counsel-cate2">할인상담</span>';

          $hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);

          if ($i == 0) echo '<ol id="sit_use_ol">';
      ?>

          <li class="sit_use_li">
              <!-- <button type="button" class="sit_use_li_title"><?php echo $is_subject; ?></button> -->
              <div class="sit_use_div">
                  <span class="counsel-cate-wr">
                    <?php echo $is_cat; ?>
                    <!--<span class="counsel-cate counsel-cate1">일반상담</span>
                     할인상담일때 글씨, 배경색 달라짐
                     <span class="counsel-cate counsel-cate2">할인상담</span> -->
                  </span>
                  <span><?php echo $row['is_best'] == 1 ? "[Best]" : ""; ?><?php echo $is_name; ?></span>
                  <span class="sit_use_star"><img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $is_star; ?>.png" alt="별<?php echo $is_star; ?>개"></span>
              </div>

              <div id="sit_use_con_<?php echo $i; ?>" class="sit_use_con">
                  <div class="sit_use_p">
                      <?php echo $is_content; // 사용후기 내용 ?>
                  </div>

                  <?php if ($is_admin || $row['mb_id'] == $member['mb_id']) { ?>
                  <div class="sit_use_cmd">
                      <a href="<?php echo $itemuse_form."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="itemuse_form btn01" onclick="return false;">수정</a>
                      <a href="<?php echo $itemuse_formupdate."&amp;is_id={$row['is_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemuse_delete btn01">삭제</a>
                  <?php } ?>

                  <?php if( $is_reply_subject ){  //  사용후기 답변 내용이 있다면 ?>
				  <button type="button" class="toggle_reply">1개의 댓글이 있습니다.</button>

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

      <a href="/shop/item.php?ca_id=<?php echo $ca_id; ?>&it_id=<?php echo $it_id; ?>&anchor=sit_use&page=<?php echo $page+1 ?>" id="itemuse_list" class="more_wr">더보기</a>
  </div><!--sit_use_list3-->



</div><!--sit-use-wr-->
<?php
//echo itemuse_page($config['cf_mobile_pages'], $page, $total_page, "./item.php?it_id=$it_id&amp;page=", "");
?>

<script>
$(function(){
  $(".toggle_reply").click(function(){
      var $con = $(this).next('.sit_use_reply');
      if($con.is(":visible")) {
          $con.hide();
          $(this).html("1개의 댓글이 있습니다.");
      } else {
        $con.show();
        $(this).html("댓글접기");
      }
  });


$(function() {
			$('.use-tab li').click(function() {
        var idx = $(this).index();

        $(".sit_use_list").hide();
        $(".sit_use_list").eq(idx).show();

        $(".use-tab li").removeClass("on");
        $(".use-tab li").eq(idx).addClass("on");
			});
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

    $("a#itemuse_list").on("click", function() {
        window.opener.location.href = this.href;
        self.close();
        return false;
    });
});
</script>
<!-- } 상품 사용후기 끝 -->
