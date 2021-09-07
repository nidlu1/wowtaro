<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div class="navi clearfix">
  <div class="left">
    <a href="#">
    </a>
  </div>

  <div class="right">
    <a href="/index.php" class="home"><i class="xi-home"></i></a>
    <i class="xi-angle-right-min"></i>
    <a href="#" class="txt">상담사례</a>
  </div>
</div>

<div id="review">
  <div class="sub_banner" id="sub_review">
    <h2>상담사례</h2>
    <p></p>
  </div>
</div>

<?php
$qrow = sql_fetch("SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$view['wr_1']."'");

$bcat_arr = b_cat_func($qrow['mb_1']);
$scat_arr = s_cat_func($qrow['mb_2']);

$j = searchForId3($qrow['mb_use'],$bcat_arr);

switch ($bcat_arr[$j]['ca_id']) {
	case '10' :
		$bcat_str = "taro";
		$bcat_bg = "back_taro";
		break;
	case '20' :
		$bcat_str = "sin";
		$bcat_bg = "back_shinjeom";
		break;
	case '30' :
		$bcat_str = "saju";
		$bcat_bg = "back_saju";
		break;
	case '40' :
		$bcat_str = "pet";
		$bcat_bg = "back_pettaro";
		break;
	case '50' :
		$bcat_str = "dream";
		$bcat_bg = "back_dream";
		break;
	default :
		$bcat_str = "taro";
		$bcat_bg = "back_taro";
		break;
}
?>
<!-- <div id="bo_v_table"><?php echo ($board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject']); ?></div> -->
    <div class="btn_top top">
        <?php if ($reply_href) { ?><a href="<?php echo $reply_href ?>" class="btn_b01">답변</a><?php } ?>
        <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_b02 btn">글쓰기</a><?php } ?>

    </div>
<article id="bo_v" style="width:<?php echo $width; ?>">
    <header>
        <h2 id="bo_v_title">
            <?php if ($category_name) { ?>
            <span class="bo_v_cate"><?php echo $view['ca_name']; // 분류 출력 끝 ?></span>
            <?php } ?>
            <span class="bo_v_tit">
            <?php
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?></span>
        </h2>
        <!-- <p><span class="sound_only">작성일</span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></p> -->
    </header>

    <section id="bo_v_info">
        <h2>페이지 정보</h2>
        <span class="sound_only">작성자 </span><?php echo $view['name'] ?><span class="ip"><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></span>
        <br>
        <span class="">조회</span><strong><?php echo number_format($view['wr_hit']) ?>회</strong>
        <span>추천 <?php echo number_format($view['wr_good']) ?></span>
        <!-- <?php if ($good_href) { ?>
          <span>추천 <?php echo number_format($view['wr_good']) ?></span>
        <?php } ?> -->
    </section>


    <div id="bo_v_top">
        <?php
        ob_start();
         ?>
        <ul class="bo_v_left">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_b01 btn">수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_b01 btn" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
            <?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" class="btn_admin btn" onclick="board_move(this.href); return false;"> 복사</a></li><?php } ?>
            <?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" class="btn_admin btn" onclick="board_move(this.href); return false;"> 이동</a></li><?php } ?>
            <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>" class="btn_b01 btn">검색</a></li><?php } ?>

        </ul>

        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>

        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }

            echo "</div>\n";
        }
         ?>

        <div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>

        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        <?php if ( $good_href || $nogood_href) { ?>
        <div id="bo_v_act">
            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="bo_v_good"><span>추천</span><br><strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good">이 글을 추천하셨습니다</b>
            </span>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="bo_v_nogood"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i><br><span class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
        <div id="bo_v_act" class="sps_section">
            <?php if($board['bo_use_good']) { ?><span class="bo_v_good"><span class="">추천</span><br><strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span class="bo_v_nogood"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i><br><span class="sound_only">비추천</span> <strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>

            <!--상담후기랑 같은 이미지 넣어주세요~-->
            <div class="sps_section_title">
              <a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$j]['ca_id']; ?>&it_id=<?php echo $qrow['mb_no']; ?>">
                <div class="review_back teacher_back_common <?php echo $bcat_bg; ?>">
                  <!-- 선생님 배경이미지 : 클래스, 배경이미지 바뀜(sct_img 뒤에 클래스 추가)
                  타로 일때 : back_taro (현재 예시로 설정해 놓음)
                  꿈해몽 일떄 : back_dream
                  펫타로 일때 : back_taro
                  사주 일떄 : back_saju
                  신점 일때 : back_shinjeom -->
                  <img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $qrow['mb_no']; ?>/<?php echo $qrow['mb_8']; ?>" height="145" alt="<?php echo $qrow['mb_nick']; ?> <?php echo $qrow['mb_id']; ?>번">
                </div>
                <div class="sps_section_title_title">
                  <!--카테고리 스타일2-->
                  <span class="sub_cate">
                    <!--타로일때-->
                    <span class="cate-taro">
                      <?php echo $bcat_arr[$j]['ca_name']; ?>
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
                  <?php echo $qrow['mb_nick']; ?>
                  <?php echo $qrow['mb_id']; ?>번
                </div>
              </a>
            </div>
            <!--//상담후기랑 같은 이미지 넣어주세요~-->
        </div>
        <?php
            }
        }
        ?>

        <!-- <div id="bo_v_share">
            <?php if ($scrap_href) { ?><a href="<?php echo $scrap_href;  ?>" target="_blank" class=" btn_scrap" onclick="win_scrap(this.href); return false;"><i class="fa fa-thumb-tack" aria-hidden="true"></i> 스크랩</a><?php } ?>

            <?php
            include_once(G5_SNS_PATH."/view.sns.skin.php");
            ?>
        </div> -->
    </section>


    <?php
    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
     ?>

    <?php if($cnt) { ?>
    <section id="bo_v_file">
        <h2>첨부파일</h2>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
                <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span> |
                <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <?php } ?>

    <?php if(isset($view['link'][1]) && $view['link'][1]) { ?>
    <!-- 관련링크 시작 { -->
    <section id="bo_v_link">
        <h2>관련링크</h2>
        <ul>
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
         ?>
            <li>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <i class="fa fa-link" aria-hidden="true"></i>
                    <strong><?php echo $link ?></strong>
                </a>
                <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </section>
    <!-- } 관련링크 끝 -->
    <?php } ?>

    <?php if ($prev_href || $next_href) { ?>
    <ul class="bo_v_nb">
        <?php if ($prev_href) { ?><li class="bo_v_prev"><a href="<?php echo $prev_href ?>"><i class="fa fa-caret-left" aria-hidden="true"></i> 이전글</a></li><?php } ?>
        <?php if ($next_href) { ?><li class="bo_v_next"><a href="<?php echo $next_href ?>">다음글 <i class="fa fa-caret-right" aria-hidden="true"></i></a></li><?php } ?>
        <li><a href="<?php echo $list_href ?>" class="btn_list"><i class="fa fa-list" aria-hidden="true"></i> 목록</a></li>

    </ul>
    <?php } ?>
    <?php
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
     ?>

</article>

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<!-- 게시글 보기 끝 -->

<script>
$(function() {
    $("a.view_image").click(function() {
      //팝업이미지 확대보기
        // window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
