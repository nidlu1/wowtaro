<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<div class="navi clearfix">
  <div class="left">
    <a href="#">
    </a>
  </div>

  <div class="right">
    <a href="/index.php" class="home"><i class="xi-home"></i></a>
    <i class="xi-angle-right-min"></i>
    <a href="#" class="txt">고객센터</a>
  </div>
</div>

<div id="review">
  <div class="sub_banner" id="sub_callcenter">
    <h2>고객센터</h2>
    <p>고객님들의 궁금증을 해결해드립니다.</p>
  </div>
</div>

<div class="review_tabs">
  <ul>
    <li><a href="/bbs/faq.php?fm_id=4">FAQ</a></li>
    <li class="active"><a href="/bbs/qalist.php">1:1고객문의</a></li>
    <li><a href="/bbs/faq2.php?fm_id=3">이용안내</a></li>
    <li><a href="/bbs/board.php?bo_table=notice">공지사항</a></li>
  </ul>
</div>


<div id="bo_list" class="inner">
    <?php if ($category_option) { ?>
    <!-- 카테고리 시작 { -->
    <nav id="bo_cate">
        <h2><?php echo $qaconfig['qa_title'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <!-- } 카테고리 끝 -->
    <?php } ?>

     <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div class="bo_fx">
        <div id="bo_list_total" class="sound_only">
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div>


    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <form name="fqalist" id="fqalist" action="./qadelete.php" onsubmit="return fqalist_submit(this);" method="post">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="sca" value="<?php echo $sca; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">

    <?php if ($is_checkbox) { ?>
    <div id="list_chk">
        <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
        <label for="chkall">게시물 전체선택</label>
    </div>
    <?php } ?>

    <div class="list_02">
        <ul>
            <?php
            for ($i=0; $i<count($list); $i++) {
            ?>
            <li class="bo_li<?php if ($is_checkbox) echo ' bo_adm'; ?>">
                <?php if ($is_checkbox) { ?>
                <div class="li_chk">
                    <label for="chk_qa_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject']; ?></label>
                    <input type="checkbox" name="chk_qa_id[]" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>">
                </div>
                <?php } ?>
                <div class="li_title">
                    <a href="<?php echo $list[$i]['view_href']; ?>"><strong><?php echo $list[$i]['category']; ?></strong></a>
                    <a href="<?php echo $list[$i]['view_href']; ?>" class="li_sbj">
                        <?php echo $list[$i]['subject']; ?><span> <?php echo $list[$i]['icon_file']; ?></span>
                    </a>
                </div>
                <div class="li_info">
                    <a href="<?php echo $list[$i]['view_href']; ?>"><span><?php echo $list[$i]['name']; ?></span></a>
                    <!-- <span><?php echo $list[$i]['date']; ?></span> -->

                    <div class="li_stat <?php echo ($list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><a href="<?php echo $list[$i]['view_href']; ?>"><?php echo ($list[$i]['qa_status'] ? '<i class="fa fa-check-circle" aria-hidden="true"></i> 답변완료' : '<i class="fa fa-times-circle" aria-hidden="true"></i> 답변대기'); ?></a></div>

                </div>
            </li>
            <?php
            }
            ?>

            <?php if ($i == 0) { echo '<li class="empty_list">게시물이 없습니다.</li>'; } ?>
        </ul>
    </div>

    <?php if ($admin_href || $write_href) { ?>
    <div class="qa_button clearfix">
        <ul class="btn_top top btn_bo_adm">
          <?php if ($is_checkbox) { ?>
          <li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
          <?php } ?>
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin"><i class="fa fa-user-circle" aria-hidden="true"></i><span class="sound_only">관리자</span></a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b01">문의등록</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    </form>



</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $list_pages;  ?>

<!-- 게시판 검색 시작 { -->
<fieldset id="bo_sch">
    <legend>게시물 검색</legend>
    <form name="fsearch" method="get">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" class="sch_input" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="frm_input required" size="15" maxlength="15">
    <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i> <span class="sound_only">검색</span></button>
    </form>
</fieldset>
<!-- } 게시판 검색 끝 -->

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다"))
            return false;
    }

    return true;
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
