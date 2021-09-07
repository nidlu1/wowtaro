<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="sit_qa_wbtn">
    <a href="<?php echo $itemqa_form; ?>" class="itemqa_form qa_wr margin_top_05">상담문의 쓰기<span class="sound_only"> 새 창</span></a>
</div>

<!-- 상담문의 목록 시작 { -->
<div id="sit_qa_list">

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
            $iq_style = 'sit_qaa_done';
            $is_answer = true;
        } else {
            $iq_stats = '답변대기';
            $iq_style = 'sit_qaa_yet';
            $iq_answer = '답변이 등록되지 않았습니다.';
            $is_answer = false;
        }

        if ($i == 0) echo '<table id="sit_qa_ol">';
    ?>
    <colgroup>
      <col width="50px;">
      <col width="80px;">
      <col width="*">
      <!-- <col width="75px;"> -->
    </colgroup>
    <tbody>
      <tr>
        <th>번호</th>
        <th>상태</th>
        <th>내용</th>
        <!-- <th>날짜</th> -->
      </tr>
        <tr class="sit_qa_li">
          <td>
            <?php echo $i+1; ?>
          </td>
          <td>
            <span class="<?php echo $iq_style; ?>"><?php echo $iq_stats; ?></span>
          </td>
          <td>
            <button type="button" class="sit_qa_li_title"><?php echo $iq_subject; ?></button>
          </td>
          <!-- <td class="date">
            <?php echo $iq_time; ?>
          </td> -->
        </tr>

        <tr class="content_sit" id="sit_qa_con_<?php echo $i; ?>">
          <td colspan="4"  class="qa-wr">
            <div id="sit_qa_con_<?php echo $i; ?>" class="sit_qa_con">
                <div class="sit_qa_p">
                    <div class="sit_qa_qaq">
                        <span class="sit_alp">Q</span>
                        <strong>문의내용</strong>
                        <?php echo $iq_question; // 상품 문의 내용 ?>
                    </div>
                    <?php if(!$is_secret) { ?>
                    <div class="sit_qa_qaa sps_section clearfix">
                        <span class="sit_alp">A</span>
                        <strong>답변</strong>

                        <!--상담후기랑 같은 이미지 넣어주세요~-->
                        <div class="sps_section_title">
                    			<a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=&it_id=<?php echo $row['mb_no']; ?>">
                            <div class="review_back teacher_back_common <?php echo $bcat_bg; ?>">
                              <!-- 선생님 배경이미지 : 클래스, 배경이미지 바뀜(sct_img 뒤에 클래스 추가)
                              타로 일때 : back_taro (현재 예시로 설정해 놓음)
                              꿈해몽 일떄 : back_dream
                              펫타로 일때 : back_taro
                              사주 일떄 : back_saju
                              신점 일때 : back_shinjeom -->
                              <img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $row['mb_no']; ?>/<?php echo $row['mb_8']; ?>" height="145" alt="<?php echo $row['mb_nick']; ?> <?php echo $row['mb_id']; ?>번">
                            </div>
                            <div class="sps_section_title_title">
                              <!--카테고리 스타일2-->
                              <span class="sub_cate">
                                <!--타로일때-->
                                <span class="cate-<?php echo $bcat_str; ?>">
                                  <?php echo $ca['ca_name'] ?>
                                </span>

                                <!--사주일때
                                <span class="cate-saju">
                                  <?php echo $row['is_cat2']; ?>
                                </span>-->

                                <!--신점일때
                                <span class="cate-sin">
                                  <?php echo $row['is_cat2']; ?>
                                </span>-->

                                <!--꿈해몽일때
                                <span class="cate-dream">
                                  <?php echo $row['is_cat2']; ?>
                                </span>-->

                                <!--펫타로일때
                                <span class="cate-dream">
                                  <?php echo $row['is_cat2']; ?>
                                </span>-->

                              </span>
                              <br>
                                <!--//카테고리 스타일2-->
                              <?php echo $row['mb_nick']; ?>
                              <?php echo $row['mb_id']; ?>번
                            </div>
                    			</a>
                  			</div>
                        <!--//상담후기랑 같은 이미지 넣어주세요~-->
                        <div class="qa_answer">
                          <?php echo $iq_answer; ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <div class="sit_qa_cmd">
				<?php if ($is_admin || ($row['iq_mb_id'] == $member['mb_id'] && !$is_answer)) { ?>
                    <a href="<?php echo $itemqa_form."&amp;iq_id={$row['iq_id']}&amp;w=u"; ?>" class="itemqa_form btn01" onclick="return false;">수정</a>
                    <a href="<?php echo $itemqa_formupdate."&amp;iq_id={$row['iq_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemqa_delete btn01">삭제</a>
                <?php } ?>
				<?php if ($is_admin || $it_id == $member['mb_no']) { ?>
                  <a href="<?php echo $itemqa_form2."&amp;iq_id={$row['iq_id']}&amp;w=u"; ?>" class="itemuse_form btn01" onclick="return false;">답글</a>
				<?php } ?>
                </div>
            </div>
          </td>
        </tr>
      </tbody>
    <?php
        $iq_num--;
    }
    if ($i > 0) echo '</table>';

    if (!$i) echo '<p class="sit_empty">상담문의가 없습니다.</p>';
    ?>

    <a href="<?php echo $itemqa_list; ?>" id="itemqa_list" class="more_wr">더보기</a>
</div>

<?php
echo itemqa_page($config['cf_mobile_pages'], $page, $total_page, "./item.php?it_id=$it_id&amp;page=", "");
?>


<script>
$(function(){
    $(".itemqa_form").click(function(){
        window.open(this.href, "itemqa_form", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(".itemqa_delete").click(function(){
        return confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.");
    });

    $(".sit_qa_li_title").click(function(){
        var $con = $(this).parents('tr').siblings(".content_sit");
        if($con.is(":visible")) {
            $con.slideUp();
        } else {
            $(".sit_qa_con:visible").hide();
            $con.slideDown(
                function() {
                    // 이미지 리사이즈
                    $con.viewimageresize2();
                }
            );
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
<!-- } 상담문의 목록 끝 -->