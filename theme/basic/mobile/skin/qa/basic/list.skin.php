<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<div class="c_hero" id="sub_callcenter">
	<strong>신선운세 <mark>1:1고객문의</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<a href="<?php echo G5_URL; ?>"><i></i><span class="blind">HOME</span></a>
		<span>신선운세</span>
		<span>고객센터</span>
		<span><mark><a href="/bbs/qalist.php" class="sct_here">1:1고객문의</a></mark></span>
	</div>
</div>
<div class="c_area list">
	<div class="wrap">
		<div class="ca_customrtab">
			<ul>
				<li><a href="/bbs/faq.php?fm_id=4">FAQ</a></li>
				<li class="active"><a href="/bbs/qalist.php">1:1고객문의</a></li>
				<li><a href="/bbs/faq2.php?fm_id=3">이용안내</a></li>
				<?php if ($is_admin || $member['mb_level'] == 3)  { ?>
				<li><a href="/bbs/board.php?bo_table=notice2">공지사항</a></li>
				<?php } else {?>
				<li><a href="/bbs/board.php?bo_table=notice">공지사항</a></li>
				<?php }?>
			</ul>
		</div>
	<!-- <div class="ca_tabs" id="ca_tab">
		<ul>
			<li><a href="/bbs/faq.php?fm_id=4#ca_tab"><span>FAQ</span></a></li>
			<li class="on"><a href="/bbs/qalist.php#ca_tab"><span>1:1고객문의</span></a></li>
			<li><a href="/bbs/faq2.php?fm_id=3#ca_tab"><span>이용안내</span></a></li>
			<li><a href="/bbs/board.php?bo_table=notice#ca_tab"><span>공지사항</span></a></li>
		</ul>
	</div> -->

     <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <!-- <div id="bo_btn_top">
        <div id="bo_list_total">
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div>

        <?php if ($admin_href || $write_href) { ?>
        <ul class="btn_bo_user">
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin btn"><i class="fa fa-user-circle" aria-hidden="true"></i> 관리자</a></li><?php } ?>
             <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn"><i class="fa fa-pencil" aria-hidden="true"></i> 문의등록</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div> -->
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <?php if ($category_option) { ?>
    <!-- 카테고리 시작 { -->
	<div class="ca_tabs" id="ca_tabs">
		<h2 class="blind"><?php echo $qaconfig['qa_title'] ?> 카테고리</h2>
		<ul>
			<?php echo $category_option ?>
		</ul>
	</div>
    <!-- } 카테고리 끝 -->
    <?php } ?>

    <form name="fqalist" id="fqalist" action="./qadelete.php" onsubmit="return fqalist_submit(this);" method="post">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="sca" value="<?php echo $sca; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">

		 <div class="ca_board">
			<table class="cab_table">
			<?php if ($is_checkbox) { ?>
			<div class="cab_chkall">	
				<input type="checkbox" class="cab_check" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
				<i></i>
				<label for="chkall">게시물 전체</label>
			</div>
			<?php } ?>
			<caption class="blind"><?php echo $board['bo_subject'] ?> 목록</caption>
			<thead>
			<tr>
				<?php if ($is_checkbox) { ?>
				<th class="w50">
					<label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
					<input type="checkbox" id="chkall" class="cab_check" onclick="if (this.checked) all_checked(true); else all_checked(false);">
					<i></i>
				</th>
				<?php } ?>
				<th class="w100">번호</th>
				<th class="w100">상담분류</th>
				 <?php if ($is_checkbox) { ?>
				<th class="w550">제목</th>
				 <?php } else {?>
				  <th class="w600">제목</th>
				 <?php } ?>
				<th class="w150">글쓴이</th>
				<th class="w150">등록일</th>
				<th class="w100">상태</th>
			</tr>
			</thead>
			<tbody>
			<?php
			for ($i=0; $i<count($list); $i++) {
			?>
			<tr>
				<?php if ($is_checkbox) { ?>
				<td class="cabt_chk">
					<label for="chk_qa_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject']; ?></label>
					<input type="checkbox" name="chk_qa_id[]" class="cab_check" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>">
					<i></i>
				</td>
				<?php } ?>
				<th class="cabt_num"><?php echo $list[$i]['num']; ?></th>
				<td class="cabt_category"><strong>상담분류</strong><span><?php echo $list[$i]['category']; ?></span></td>
				<td class="cabt_subject">
					<strong>제목</strong>
					<a href="<?php echo $list[$i]['view_href']; ?>">
						<?php echo $list[$i]['subject']; ?>
						<?php if ($list[$i]['icon_file']) echo " <i class=\"cabts_download\" aria-hidden=\"true\"></i>" ; ?>
					</a>
				</td>
				<td ><strong>글쓴이</strong><span><?php echo $list[$i]['name']; ?></span></td>
				<td class="cabt_date"><strong>등록일</strong><?php echo date("Y-m-d", strtotime($list[$i]['date'])) ?></td>
				<td class="cabt_stat"><strong>상태</strong><span class=" <?php echo ($list[$i]['qa_status'] ? 'done' : 'rdy'); ?>"><?php echo ($list[$i]['qa_status'] ? '답변완료' : '답변대기'); ?></span></td>
			</tr>
			<?php
			}
			?>

			<?php if ($i == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
			</tbody>
			</table>
		</div>
	</form>

	<!-- 게시판 검색 시작 { -->
	<div class="search_wrap">
		 <fieldset class="ca_search t1">
			<legend>게시물 검색</legend>
			<form name="fsearch" method="get">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="sca" value="<?php echo $sca ?>">
			<input type="hidden" name="sop" value="and">
			<label for="sfl" class="sound_only">검색대상</label>
			<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
			<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="cas_input" size="25" maxlength="20" placeholder="검색어를 입력하세요">
			<input type="submit" value="검색" class="cas_search">
			<i class="icon_search"></i>
			</form>
		</fieldset>
	</div>
	<!-- } 게시판 검색 끝 -->
    <!-- 게시판 검색 시작 { -->
   <!--  <fieldset id="bo_sch">
        <legend>게시물 검색</legend>
    
        <form name="fsearch" method="get">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" required  class="sch_input" size="25" maxlength="15">
        <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
        </form>
    </fieldset> -->
    <!-- } 게시판 검색 끝 -->
	<!-- 페이지 -->
	<?php echo $list_pages_moblie;  ?>
	<div class="pg_buttons">
		<ul>
			<?php if ($list_href) { ?><li><a href="<?php echo $list_href ?>" class="btn">목록</a></li><?php } ?>
			<?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn t1">문의등록</a></li><?php } ?>
			<?php if ($is_checkbox) { ?>
			<li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn t2">선택삭제</button></li>
			<?php } ?>
		</ul>
	</div>
</div>
<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

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
