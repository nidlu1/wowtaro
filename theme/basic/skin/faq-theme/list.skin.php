<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 3;
if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;
// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<script src="<?php echo $board_skin_url ?>/jquery.corner.js"></script> <!-- jquery 자주하는질문 원 적용 -->

<script type="text/javascript">
// 코너 버튼 적용
$(window).load(function() {

		$("span.td_ask").corner(); // Q 아이콘
		$("span.td_answer").corner(); // A 아이콘

});
</script>



<div class="sub_banner" id="review">
  <h2>고객센터</h2>
  <p>고객님들의 궁금증을 해결해드립니다.</p>
</div>

<div class="review_tabs">
  <ul>
    <li class="active"><a href="/bbs/board.php?bo_table=faq">FAQ</a></li>
    <li><a href="/bbs/board.php?bo_table=qa">1:1고객문의</a></li>
    <li><a>이용안내</a></li>
    <li><a href="/bbs/board.php?bo_table=notice">공지사항</a></li>
  </ul>
</div>


<div class="inner">


<!-- 게시판 목록 시작 { -->
<div id="bo_list" style="width:<?php echo $width; ?>">

	<!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
	<fieldset id="bo_sch">
    	<legend>게시물 검색</legend>
		<form name=fsearch method=get style="margin:0px;">
		<input type=hidden name=bo_table value="<?=$bo_table?>">
		<input type=hidden name=sca      value="<?=$sca?>">
		<input type=hidden name=sfl value="wr_subject||wr_content">
		<input type=hidden name="sop" value="and">
		<input type=hidden name=sfl value="<?=$wr_subject?>">
		<div class="searchBox">
			<ul>
    		<li class="bo_explain"><p class="bo_title">FAQ</p>자주 묻는 질문들입니다. 궁금사항은 먼저 검색해 보세요.</li>
    		<li class="bo_search"><input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx"  class="frm_input required" size="25" maxlength="40" />
					<button type="submit" value="검색" class="faq_sch_btn"><i class="xi-search"></i></button>
				</li>
    		</ul>
		</div>
		</form>
	</fieldset>


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
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

<div class="tbl_head01 tbl_wrap">
	  <?php
       for ($i=0; $i<count($list); $i++) {
       ?>
        <table>
           <tr>
            <?php if ($is_checkbox) { ?>
            <td class="td_chk">
                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </td>
            <?php } ?>
            <td class="td_ask_wr"><span class="td_ask">Q</span></td>
            <td class="td_subject">
                <?php
                echo $list[$i]['icon_reply'];
                if ($is_category && $list[$i]['ca_name']) {
                 ?>
                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                <?php } ?>

                <a onclick=view(<?=$list[$i][num]?>) style='cursor:pointer'><?=$list[$i][subject]?></a>
            </td>
            <? if (($member[mb_id] && ($member[mb_id] == $write[mb_id])) || $is_admin) { ?>
	         <td class="td_modify"><a href="<?=$write_href?>&w=u&wr_id=<?=$list[$i][wr_id]?>&page=<?=$page?>" class="btn_modi">수정</a></td>
	                <? } ?>
          </tr>
        </table>
            <div id="view_<?=$list[$i][num]?>" style="display:none">
            <table class="contentBox">
                <tr>
                    <td class="td_title"><span class="td_answer">A</span></td>
                    <td class="td_content"><?php echo get_view_thumbnail($list[$i]['wr_content']); ?></td>
                </tr>
            </table>
            </div>
        <?php } ?>
     <table>
		<?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
    </table>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="bo_fx">
        <?php if ($is_checkbox) { ?>
        <ul class="btn_bo_adm">
            <li><input type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value"></li>
        </ul>
        <?php } ?>
        <?php if ($list_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin">관리자</a></li><?php } ?>
			<?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li><?php } ?>
			<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">등록하기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>
    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>
</div><!--inner-->

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

	// 이미지 리사이즈
    $(".contentBox").viewimageresize();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->

<!-- 펼쳐지는 스크립트-->
<script>
var old_i; // 전에 클릭했던 글의 번호값 저장
function view(i) { // 답변 표시여부 조정하는 js함수
	if (old_i==i) {
		var mode=document.getElementById('view_'+i).style.display;
		if (mode=='inline') document.getElementById('view_'+i).style.display='none';
		else document.getElementById('view_'+i).style.display='inline';
	}
	else {
		if (old_i) document.getElementById('view_'+old_i).style.display='none';
		document.getElementById('view_'+i).style.display='inline';
	}
	old_i=i;
}
</script>
