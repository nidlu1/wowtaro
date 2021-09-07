<?php
include_once('./_common.php');

$od_pwd = get_encrypt_string($od_pwd);

// 회원인 경우
if ($is_member)
{
    $sql_common = " from {$g5['point_table']} where mb_id = '{$member['mb_id']}' ";
}
else // 그렇지 않다면 로그인으로 가기
{
    goto_url(G5_BBS_URL.'/login.php?url='.urlencode(G5_URL.'/mypage_point_list.php'));
}

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 비회원 주문확인시 비회원의 모든 주문이 다 출력되는 오류 수정
// 조건에 맞는 주문서가 없다면
if ($total_count == 0)
{
    /*if ($is_member) // 회원일 경우는 메인으로 이동
        alert('주문이 존재하지 않습니다.', G5_SHOP_URL);
    else // 비회원일 경우는 이전 페이지로 이동
        alert('주문이 존재하지 않습니다.');*/
}

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$g5['title'] =  '코인내역';

include_once(G5_PATH.'/head.php');
?>


<div class="c_hero">
	<strong>신선운세 <mark>코인내역</mark></strong>
</div>
<div class="c_list">
	<div class="cl_menu">
		<span>마이페이지</span>
		<span><mark><a href="/mypage_point_list.php" class="sct_here">코인내역</a></mark></span>
	</div>
	<button type="button" class="cl_btn"><span class="blind"></span></button>
</div>
<ul id="mypage-tab">
	<?php
	include_once(G5_SHOP_PATH.'/mymenu.php');
	?>
</ul>
<div class="c_area mypage">
	  <div class="wrap">
		<ul class="ca_function">
			<li><span><?php echo $member['mb_name']; ?>님</span></li>
				<?php
			switch($member['mb_grade']) {
				case "1" :
					echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank01.svg"></div><b>나그네회원</b></span></li>';
					break;
				case "2" :
					echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank02.svg"></div><b>열심회원</b></span></li>';
					break;
				case "3" :
					echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank03.svg"></div><b>성실회원</b></span></li>';
					break;
				case "4" :
					echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank04.svg"></div><b>충성회원</b></span></li>';
					break;
				case "5" :
				case "6" :
					echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank05.svg"></div><b>신선회원</b></span></li>';
					break;
				default :
					echo '<li><span><div class="caf_rank"><img src="/images/common/icon_rank01.svg"></div><b>나그네회원</b></span></li>';
					break;
			}
			//보유 포인트 확인
			$sql = "select * from {$g5['point_table']} where mb_id = '{$member['mb_id']}' order by po_id DESC";
			$row = sql_fetch($sql);
			?>
			<li><span><i class="icon money"></i>보유 <mark class="cs"><?=number_format($row['po_mb_point'])?></mark> coin</span></li>
		</ul>
        <!-- 주문 내역 시작 { -->
        <div id="mypage-content" class="point">
            <p>하루에 <mark>한번! 출석하고 추가코인</mark>도 받자!</p>
			<ul>
				<li><span>출석 시 <mark>+30</mark><i class="icon coin t1"></i>이 적립됩니다. 적립된 코인은 <b>3,000<i class="icon coin t2"></i></b>부터 사용 가능합니다.</span></li>
				<li class="blind"><span>코인 상세내역이 궁금하시다면 해당하는 <mark>일자의 내역 옆 ‘<i class="icon menu"></i>’ 아이콘</mark>을 클릭하여 확인하세요.</span></li>
			</ul>
			<div class="ca_caltop">
				<div class="cac_center">
					<span id="yearmonth"></span>
				</div>
				<div class="cac_wrap t1">
					<a id="before" href="javascript:beforem()"></a>
				</div>
				<div class="cac_wrap t2">
					<a id="next" href="javascript:nextm()"></a>
				</div>
			</div>
			<div class="ca_calender">
				<table id="calendar">
					<tr class="blind">
					</tr>
					<tr class="top">
						<td width="14%">일</td>
						<td width="14%">월</td>
						<td width="14%">화</td>
						<td width="14%">수</td>
						<td width="14%">목</td>
						<td width="14%">금</td>
						<td width="14%">토</td>
					</tr>
				</table>
			</div>
		</div>
	</div><!--order-wr-->
</div> <!--inner-->
<!-- } 주문 내역 끝 -->

<?php
include_once(G5_PATH . '/tail.php');
?>
<script language="javascript">
    var today = new Date(); //오늘 날짜        
    var date = new Date();

    //이전달
    function beforem() { //이전 달을 today에 값을 저장
        today = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
        autoReload(); //만들기
    }

    //다음달
    function nextm() {  //다음 달을 today에 저장
        today = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
        autoReload();
    }

    //오늘선택
    function thisMonth() {
        today = new Date();
        autoReload();
    }

    function autoReload() {
        let nMonth = new Date(today.getFullYear(), today.getMonth(), 1); //현재달
        let lastDate = new Date(today.getFullYear(), today.getMonth() + 1, 0); //현재 달의 마지막 날
        let tbcal = document.getElementById("calendar"); // 테이블 달력을 만들 테이블
        let yearmonth = document.getElementById("yearmonth"); //  년도와 월 출력할곳
        yearmonth.innerHTML = today.getFullYear() + "년 <mark>" + (today.getMonth() + 1) + "</mark>월"; //년도와 월 출력

        if (today.getMonth() + 1 === 12) { //  눌렀을 때 월이 넘어가는 곳
            before.innerHTML = ("" + today.getMonth()) + "월";
            next.innerHTML = "1월" + "";

        } else if (today.getMonth() + 1 === 1) { //  1월 일 때
            before.innerHTML = "" + "12월";
            next.innerHTML = (today.getMonth() + 2) + "월" + "";
        } else { //   12월 일 때
            before.innerHTML = "" + (today.getMonth()) + "월";
            next.innerHTML = (today.getMonth() + 2) + "월" + "";
        }

        // 남은 테이블 줄 삭제
        while (tbcal.rows.length > 2) {
            tbcal.deleteRow(tbcal.rows.length - 1);
        }
        let row = null;
        row = tbcal.insertRow();
        let cnt = 0;
        let dayCheck = (nMonth.getDay() === 0) ? 0 : nMonth.getDay(); //일요일을 첫번째로 넣기 위해서.
        // 1일 시작칸 찾기
        for (i = 0; i < (dayCheck); i++) {
            cnt = cnt + 1;
            cell = row.insertCell();
            if(i===0){
                //cell.style.backgroundColor = "#f7f7f7";
            }
        }

        // 달력 출력
        for (i = 1; i <= lastDate.getDate(); i++) { // 1일부터 마지막 일까지
            cell = row.insertCell();
            let str = "";
            str += "<span class='cac_day'>" + i + "</span>";
            let day = (i < 10) ? "0" + i : i;
            str += "<span id='" + day + "'></span>"; //나중에 원하는 날에 일정을 넣기위해 id값을 날자로 설정
            cell.innerHTML = str;

            cnt = cnt + 1;
            if (cnt % 7 === 1) {// 일요일
                let str = "";
                str += "<span class='cac_day sunday'>" + i + "</span>";
                let day = (i < 10) ? "0" + i : i;
                str += "<span id='" + day + "'>";
                str += "</span>";
                cell.innerHTML = str;
            }
            if (cnt % 7 === 0) { //토요일
                let str = "";
                str += "<span class='cac_day saturday'>" + i + "</span>";
                let day = (i < 10) ? "0" + i : i;
                str += "<span id='" + day + "'>";
                str += "</span>";
                cell.innerHTML = str;
                row = calendar.insertRow();// 줄 추가
            }

            //마지막 날짜가 지나면 토요일까지 칸 그리기
            if (lastDate.getDate() === i && ((cnt % 7) !== 0)) {
                let add = 7 - (cnt % 7);
                for (let k = 1; k <= add; k++) {
                    cell = row.insertCell();
                    cnt = cnt + 1;
                    if (cnt % 7 === 6) { //토요일
//                        cell.style.backgroundColor = "#f7f7f7";
                    }
                    if (cnt % 7 === 0) { //일요일
// cell.style.backgroundColor = "#f7f7f7";
                    }
                }
            }

            //오늘날짜배경색
            if (today.getFullYear() === date.getFullYear() && today.getMonth() === date.getMonth() && i === date.getDate()) {
                //cell.style.backgroundColor = "#e2f3da"; //오늘날짜배경색
            }


        }
        let todayMonthCheck = today.getMonth()+1;
        let todayYearMonth = todayMonthCheck < 10 ? `${today.getFullYear()}-0${todayMonthCheck}`:`${today.getFullYear()}-${todayMonthCheck}` ;
        let tdStr = "";
        let initDay = "";
<?php
$sql = " select *
            from {$g5['point_table']}
           where mb_id = '{$member['mb_id']}'
           order by po_id desc
           $limit ";
//echo $sql;
$result = sql_query($sql);
for ($i = 0; $row = sql_fetch_array($result); $i++) {
        $phpYearMonth = substr($row["po_datetime"], 0, 7);
        $phpDay = substr($row["po_datetime"], 8, 2);
		if(strpos($row["po_rel_action"],"출석")) {
			$ischeckin= true;
		}else{
			$ischeckin= false;
		}
    ?> 
        // 현재 년월과 포인트내역 년월이 일치
        if(todayYearMonth === "<?=$phpYearMonth?>"){
            
            //다른날짜 초기화
            if(initDay === ""){
                initDay = "<?=$phpDay?>";
//                console.log(`init없음 연결->${initDay}:<?=$phpDay?> :: 내용:<?=$row["po_content"]?>`);
            }
            if(initDay === "<?=$phpDay?>"){
//                initDay = "<?=$phpDay?>";
//                console.log(`init동일 연결->${initDay}:<?=$phpDay?> :: 내용:<?=$row["po_content"]?>`);
            }
            if(initDay !== "<?=$phpDay?>"){
                tdStr = "";
                initDay = "<?=$phpDay?>";
//                console.log(`init다름 초기화->${initDay}:<?=$phpDay?> :: 내용:<?=$row["po_content"]?>`);
            }
            
            //원하는 날짜 영역에 내용 추가하기
            let tdId = "<?=$phpDay?>"; //1일
            tdStr += "<br>*<?=$row["po_rel_action"]?>\n[<?=$row["po_point"]?>코인]";
            document.getElementById(tdId).innerHTML = tdStr;
        }
    <?php
}
?>


    }
    $(document).ready(function () {
        autoReload();
    });
</script>
