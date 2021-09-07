<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>



<div class="sub_banner" id="sub_review">
  <h2>상담사례</h2>
  <p>선생님들의 생생한 상담사례</p>
</div>

<!--네비게이션-->
<div id="sct" class="navi">
<div class="sc_wrap">
<div class="inner">
<div id="sct_location">
    <a href="/index.php" class="sct_bg"><i class="xi-home"></i></a>
    <a href="/bbs/board.php?bo_table=best" class="sct_here ">상담사례</a></div>
<div id="sct_hhtml"></div>
<div id="sct_sortlst">
<!-- 상품 정렬 선택 시작 { -->
<!-- <section id="sct_sort">
    <h2>상품 정렬</h2>
    <ul id="ssch_sort">
        <li><a href="/shop/list.php?ca_id=50&amp;sort=it_sum_qty&amp;sortodr=desc">조회순</a></li>
        <li><a href="/shop/list.php?ca_id=50&amp;sort=it_use_cnt&amp;sortodr=desc">후기많은순</a></li>
        <li><a href="/shop/list.php?ca_id=50&amp;sort=it_use_avg&amp;sortodr=desc">별점높은순</a></li>
    </ul>
</section> -->
</div>
</div>
</div>
</div>

<div class="inner best_inner">
<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">


    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <!-- <div id="bo_btn_top">
         <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div>

        <?php if ($rss_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn"><i class="fa fa-rss" aria-hidden="true"></i> RSS</a></li><?php } ?>
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn"><i class="fa fa-user-circle" aria-hidden="true"></i> 관리자</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div> -->
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <!-- 게시판 검색 시작 { -->
    <fieldset id="bo_sch">
        <legend>게시물 검색</legend>

        <form name="fsearch" method="get">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sop" value="and">
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="sch_input" size="25" maxlength="20" placeholder="검색어를 입력해주세요">
        <button type="submit" name="button" class="sch_btn" role="검색"><span class="sound_only">검색</span></button>
        </form>
    </fieldset>
    <!-- } 게시판 검색 끝 -->

    <!-- 게시판 카테고리 시작 { -->
    <?php if ($is_category) { ?>
    <nav id="bo_cate">
        <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <?php } ?>
    <!-- } 게시판 카테고리 끝 -->

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="tbl_head02 tbl_wrap">
        <table>
        <caption><?php echo $board['bo_subject'] ?> 목록</caption>
        <thead>
        <tr>
            <?php if ($is_checkbox) { ?>
            <th scope="col">
                <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            </th>
            <?php } ?>
            <th scope="col" class="num">번호</th>
            <th scope="col" class="num">상담사</th>
            <th scope="col">제목</th>
            <th scope="col">조회</th>
            <th scope="col">추천</th>
            <!-- <?php if ($is_nogood) { ?><th scope="col"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천 <i class="fa fa-sort" aria-hidden="true"></i></a></th><?php } ?> -->
            <!-- <th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>날짜</th> -->
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {
			$qrow = sql_fetch("SELECT * FROM ".$g5['member_table']." WHERE mb_id='".$list[$i]['wr_1']."'");

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
        <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </td>
            <?php } ?>
            <td class="td_num">
            <?php
            if ($list[$i]['is_notice']) // 공지사항
                echo '<strong class="notice_icon"><i class="fa fa-bullhorn" aria-hidden="true"></i><span class="sound_only">공지</span></strong>';
            else if ($wr_id == $list[$i]['wr_id'])
                echo "<span class=\"bo_current\">열람중</span>";
            else
                echo $list[$i]['num'];
             ?>
            </td>
            <td class="td_num2">
              <a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $bcat_arr[$j]['ca_id']; ?>&it_id=<?php echo $qrow['mb_no']; ?>">

                <span class="best_teacher_img teacher_back_common <?php echo $bcat_bg; ?>">
                  <!--선생님 배경 이미지 클래스 :
                  타로 일때 : back_taro (현재 예시로 설정해 놓음)
                  꿈해몽 일떄 : back_dream
                  펫타로 일때 : back_pettaro
                  사주 일떄 : back_saju
                  신점 일때 : back_shinjeom
                -->
                  <img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $qrow['mb_no']; ?>/<?php echo $qrow['mb_8']; ?>" alt="<?php echo $qrow['mb_nick']; ?> <?php echo $qrow['mb_id']; ?>번"><!--더미이미지-->
                </span>


              <span class="qa_text best_qa_text">
                <!--카테고리 스타일2-->
                <span class="sub_cate">

                  <!--타로일때-->
                  <span class="cate-<?php echo $bcat_str; ?>">
                    <?php echo $bcat_arr[$j]['ca_name']; ?>
                  </span>

                  <!--사주일때
                  <span class="cate-saju">
                    사주
                  </span>-->

                  <!--신점일때
                  <span class="cate-sin">
                    신점
                  </span>-->

                  <!--꿈해몽일때
                  <span class="cate-dream">
                    꿈해몽
                  </span>-->

                  <!--펫타로일때
                  <span class="cate-dream">
                    펫타로
                  </span>-->

                </span>
                  <!--//카테고리 스타일2-->
                <!-- <?php echo $row['mb_nick']; ?>
                <?php echo $row['mb_id']; ?>번 -->
                <?php echo $qrow['mb_nick']; ?> <?php echo $qrow['mb_id']; ?>번
              </span>
              </a>
            </td>

            <td class="td_subject" >
                <?php
                if ($is_category && $list[$i]['ca_name']) {
                 ?>
                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                <?php } ?>
                <div class="bo_tit">
                    <a href="<?php echo $list[$i]['href'] ?>">
                        <?php echo $list[$i]['subject'] ?>
                    </a>
                </div>

            </td>
            <!-- <td class="td_name sv_use"><?php echo $list[$i]['name'] ?></td> -->
            <td class="td_num"><?php echo $list[$i]['wr_hit'] ?></td>
            <td class="td_num"><?php echo $list[$i]['wr_good'] ?></td>
            <!-- <?php if ($is_nogood) { ?><td class="td_num"><?php echo $list[$i]['wr_nogood'] ?></td><?php } ?> -->
            <!-- <td class="td_datetime"><?php echo $list[$i]['datetime2'] ?></td> -->

        </tr>
        <?php } ?>
        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
        <!-- 예시 테이블 정보 -->
        </tbody>
        </table>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($list_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($is_checkbox) { ?>
            <li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_admin">선택삭제</button></li>
            <li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn btn_admin">선택복사</button></li>
            <li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn btn_admin">선택이동</button></li>
            <?php } ?>
            <?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn_b01 btn"><i class="fa fa-list" aria-hidden="true"></i> 목록</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn">글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>
    </form>

</div>
</div><!--inner-->
<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>



<!-- 페이지 -->
<?php echo $write_pages;  ?>


<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
