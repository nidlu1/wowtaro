<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<style>
    .search-page-form{
        text-align: center;
    }
    .search-page-form .subject {
        display: inline-block;
        width: 600px;
        text-align: left;
    }
    .subject, .search-tag_area .subject{
        font-size: 18px;
        color: #222;
        font-weight: 600;
        margin-bottom: 10px;        
    }
    .search-page-form .defalut-view {
    display: inline-block;
    width: 600px;
    text-align: left;
}
.search-page-form .sub-title {
    font-size: 24px;
    color: #555;
    letter-spacing: -1px;
}
.m60t {
    margin-top: 60px;
}
.search-page-form .sub-title span {
    color: #222;
}
.no-result-desc {
    position: relative;
    width: 580px;
    margin-left: auto;
    margin-right: auto;
    text-align: left;
    font-size: 16px;
    letter-spacing: -1px;
    color: #555;
    line-height: 24px;
}
.no-result-desc li {
    position: relative;
    padding-left: 10px;
}
.search-tag_area {
    margin-top: 30px;
    margin: 40px auto 20px auto;
}
.search-page-form .subject {
    display: inline-block;
    width: 600px;
    text-align: left;
}
.subject, .search-tag_area .subject {
    font-size: 18px;
    color: #222;
    font-weight: 600;
    margin-bottom: 10px;
}
.search-tag_area .subject .title-line {
    display: block;
    height: 17px;
    margin-top: 10px;
    font-weight: normal;
    font-size: 16px;
    color: #555;
}
.search-tag_area .tag_list {
    margin: 15px auto 0 auto;
    width: 450px;
}
.search-tag_area .tag_list li {
    width: 23.6%;
    margin-right: 1.5%;
    font-size: 12px;
    list-style: none;
    float: left;
    text-align: center;
    border: 1px solid #222;
    margin-bottom: 1.5%;
    background: #fff;
    border-radius: 20px;
}
.search-tag_area .tag_list li a {
    display: block;
    width: 100%;
    color: #222;
    font-size: 16px;
    padding: 10px 0;
}
.search-tag_area .tag_list::after {
    display: block;
    content: "";
    clear: both;
}
.search-page-form input {
    vertical-align: top;
    padding-left: 7px;
    width: 250px;
    height: 50px;
    border: 2px solid #222;
}
.search-page-form #sch_submit {
    border: 0;
    border: 1px solid #f0f0f0;
    border-left: 0;
    width: 50px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
    height: 50px;
    color: #555;
    background: #ddd;
}
</style>
<div class="search-page-form">
    <p class="subject">키워드 검색</p>
    <form action="./search.php" method="get" id="searchKeywordForm">
        <input type="text" name="mb_hashtag" id="keyword" value="">
        <!--<button type="submit" id="adjust_search_callee"><img src="https://www.hongcafe.com/assets/image/pc/icon/search-page-icon.png" alt="검색하기"></button>-->
        <button type="submit" id="sch_submit"><svg class="svg-inline--fa fa-search fa-w-16" aria-hidden="true" data-prefix="fa" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg><!-- <i class="fa fa-search" aria-hidden="true"></i> --><span class="sound_only">검색</span></button>
    </form>
    <div class="searchSuggest"></div>
    <div class="defalut-view" id="search_desc">
        <p class="title m10t">상담사 닉네임(예명)이나 원하시는 키워드로 검색해 보세요.</p>
    </div>
    <div class="noresult-view" id="search_no_result" style="display: none;">
        <p class="sub-title m60t"><span class="highlight">"<span id="no_keyword"></span>"</span>에 대한 상담사 검색 결과가 없습니다.</p>
        <nav class="no-result-desc m60t">
            <ul>
                <li>
                    단어의 철자가 정확한지 확인해 보세요.
                </li>
                <li>
                    다른 검색어를 입력하시거나 철자와 띄어쓰기를 확인해 보세요.
                </li>
                <li>
                    검색어의 단어 수를 줄여 보세요.
                </li>
                <li>
                    상담사 닉네임, 상담사 태그, 프로필 내용등에 많이 쓰일만한 단어로 검색해 보세요. 
                </li>
                <li>
                    보다 일반적인 검색어로 다시 검색해 보세요.
                </li>
            </ul>
        </nav>
    </div>
    <div class="search-tag_area">
        <p class="subject">
            태그 선택
            <span class="title-line">원하는 상담분야 태그를 선택하세요.</span>
        </p>
        <ul class="tag_list">
            <?php
            while ($row_hashtag = sql_fetch_array($result_hashtag)){
            ?>
            <li><a href="/mobile/shop/search.php?mb_hashtag=<?=$row_hashtag['mg_hashtag']?>" class="tag">#<?=$row_hashtag['mg_hashtag']?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>

<!-- 검색 시작 { -->
<!--<div id="ssch">-->
    <!-- 상세검색 항목 시작 { -->
<!--    <div id="ssch_frm">
        <form name="frmdetailsearch">
        <input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
        <input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
        <input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">-->
        <!-- <div>
            <strong>검색범위</strong>
            <input type="checkbox" name="qname" id="ssch_qname" <?php echo $qname_check?'checked="checked"':'';?>> <label for="ssch_qname">상품명</label>
            <input type="checkbox" name="qexplan" id="ssch_qexplan" <?php echo $qexplan_check?'checked="checked"':'';?>> <label for="ssch_qexplan"><span class="sound_only">상품</span>설명</label>
            <input type="checkbox" name="qbasic" id="ssch_qbasic" value="1" <?php echo $qbasic_check?'checked="checked"':'';?>> <label for="ssch_qbasic">기본설명</label>
          <input type="checkbox" name="qid" id="ssch_qid" <?php echo $qid_check?'checked="checked"':'';?>> <label for="ssch_qid"><span class="sound_only">상품</span>코드</label>
            <input type="checkbox" name="qbasic" id="ssch_qbasic" value="1" <?php echo $qbasic_check?'checked="checked"':'';?>> <label for="ssch_qbasic">기본설명</label><br>
        </div> -->
        <!-- <div>
            <strong>상품가격 (원)</strong>
            <label for="ssch_qfrom" class="sound_only">최소 가격</label>
            <input type="text" name="qfrom" value="<?php echo $qfrom; ?>" id="ssch_qfrom" class="frm_input"> ~
            <label for="ssch_qto" class="sound_only">최대 가격</label>
            <input type="text" name="qto" value="<?php echo $qto; ?>" id="ssch_qto" class="frm_input"> 까지<br>
        </div> -->
<!--        <div class="search-sch">
            <label for="ssch_q" class="ssch_lbl"></label>
            <input type="text" name="q" value="<?php echo $q; ?>" id="ssch_q" class="frm_input" maxlength="30">
            <input type="submit" value="검색" class="btn_submit">
        </div>-->
        <!-- <p>
            상세검색을 선택하지 않으면 전체에서 검색합니다.<br>
            검색어는 최대 30글자까지, 여러개의 검색어를 공백으로 구분하여 입력 할수 있습니다.
        </p> -->
        <!--</form>-->

        <!--ul id="ssch_sort" class="clearfix">
            <li><a href="#" class="btn01" onclick="set_sort('it_sum_qty', 'desc'); return false;">조회순</a></li>
            <li><a href="#" class="btn01" onclick="set_sort('it_use_cnt', 'desc'); return false;">후기많은순</a></li>
            <li><a href="#" class="btn01" onclick="set_sort('it_use_avg', 'desc'); return false;">별점높은순</a></li>
        </ul-->
		<?php
        define('G5_SHOP_CSS_URL', G5_MSHOP_SKIN_URL);
        $list_file = G5_MSHOP_SKIN_PATH.'/'.$default['de_mobile_search_list_skin'];
        if (file_exists($list_file)) {
            /*$list = new item_list($list_file, $default['de_mobile_search_list_mod'], $default['de_mobile_search_list_row'], $default['de_mobile_search_img_width'], $default['de_mobile_search_img_height']);
            $list->set_query(" select * $sql_common $sql_where {$order_by} limit $from_record, $items ");
            $list->set_is_page(true);
            $list->set_mobile(true);
            $list->set_view('it_img', true);
            $list->set_view('it_id', false);
            $list->set_view('it_name', true);
            $list->set_view('it_basic', true);
            $list->set_view('it_cust_price', false);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', true);
            $list->set_view('sns', true);
            echo $list->run();*/
			$sub_where = "";
			if ( $_REQUEST['q'] ) {
				$concat = array();
				$concat[] = "mb_nick";
				$concat[] = "mb_id";

				$concat_fields = "concat(".implode(",' ',",$concat).")";

				$sub_where = " AND ".$concat_fields." like '%".$_REQUEST['q']."%' ";
			}

			$sql = "SELECT * FROM ".$g5['member_table']." WHERE mb_level='3' AND ( mb_hashtag LIKE '%$mb_hashtag%' OR mb_nick LIKE '%$mb_hashtag%' ) ".$sub_where." ORDER BY mb_status ASC, rand()";
			//echo $sql;
			$result = sql_query($sql);

			// where 된 전체 상품수
			$total_count = sql_num_rows($result);
			// 전체 페이지 계산
			$total_page  = ceil($total_count / $items);
		?>
        <div id="ssch_ov">
            검색 결과 <b><?php echo $total_count; ?></b>건
        </div>
<!--    </div>-->
    <!-- } 상세검색 항목 끝 -->

    <!-- 검색된 분류 시작 { --
    <div id="ssch_cate">
        <ul>
        <?php
        $total_cnt = 0;
        foreach( $categorys as $row ){
            echo "<li><a href=\"#\" onclick=\"set_ca_id('{$row['ca_id']}'); return false;\">{$row['ca_name']} (".$row['cnt'].")</a></li>\n";
            $total_cnt += $row['cnt'];
        }
        echo '<li><a href="#" onclick="set_ca_id(\'\'); return false;">전체분류 <span>('.$total_cnt.')</span></a></li>'.PHP_EOL;
        ?>
        </ul>
    </div>
    <!-- } 검색된 분류 끝 -->

    <!-- 검색결과 시작 { -->
    <div>
        <?php
        // 리스트 유형별로 출력
	//echo $skin_file;
			include $list_file;
        }
        else
        {
            $i = 0;
            $error = '<p class="sct_nofile">'.$list_file.' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</p>';
        }

        if ($i==0)
        {
            echo '<div>'.$error.'</div>';
        }

        $query_string = 'qname='.$qname.'&amp;qexplan='.$qexplan.'&amp;qid='.$qid.'&amp;qbasic='.$qbasic;
        if($qfrom && $qto) $query_string .= '&amp;qfrom='.$qfrom.'&amp;qto='.$qto;
        $query_string .= '&amp;qcaid='.$qcaid.'&amp;q='.urlencode($q);
        $query_string .='&amp;qsort='.$qsort.'&amp;qorder='.$qorder;
        echo get_paging($config['cf_mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=');
        ?>
    </div>
    <!-- } 검색결과 끝 -->

</div>
<!-- } 검색 끝 -->

<script>
function set_sort(qsort, qorder)
{
    var f = document.frmdetailsearch;
    f.qsort.value = qsort;
    f.qorder.value = qorder;
    f.submit();
}

function set_ca_id(qcaid)
{
    var f = document.frmdetailsearch;
    f.qcaid.value = qcaid;
    f.submit();
}
</script>
