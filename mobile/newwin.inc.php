<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!defined('_SHOP_')) {
    $pop_division = 'comm';
} else {
    $pop_division = 'shop';
}

$sql = " select * from {$g5['new_win_table']}
          where nw_id = 14";
$result = sql_query($sql, false);

$sql2 = " select * from {$g5['new_win_table']}
          where '".G5_TIME_YMDHIS."' between nw_begin_time and nw_end_time
            and nw_device IN ( 'both', 'mobile' ) and nw_division IN ( 'both', '".$pop_division."' )
          order by nw_id asc ";
$result2 = sql_query($sql2, false);
?>

<!-- 팝업레이어 시작 { -->

    <h2 class="blind">팝업레이어 알림</h2>

<?php
for ($i=0; $nw=sql_fetch_array($result); $i++)
{
    // 이미 체크 되었다면 Continue
    if ($_COOKIE["topbanner"])
        continue;
?>
    <div id="topbanner">
		<button type="button" class="t_close topbanner <?php echo $nw['nw_disable_hours']; ?>"><span class="blind">닫기</span></button>
		<div class="slide_type1 owl-carousel">
			<?php
				while($nw2=sql_fetch_array($result2)){
				?>
					<div class="item">
						<a href="<?=$nw2['nw_link']?>"><?php echo conv_content($nw2['nw_content'], 1); ?></a>
					</div>
				<?php
				}
			?>
		</div>
	</div>
<?php }
if ($i == 0) echo '<span class="sound_only">팝업레이어 알림이 없습니다.</span>';
?>


<script>
$(function() {
	
	$(".t_close").click(function() {
		var id = $(this).attr('class').split(' ');
		var ck_name = id[1];
		var exp_time = parseInt(id[2]);
		$("#"+id[1]).css("display", "none");
		set_cookie(ck_name, 1, exp_time, g5_cookie_domain);
		console.log(ck_name,exp_time);
		$("#header .h_menu .hm_all .hma_wrap").addClass("on");
	});
    /*$('.hd_pops_close').click(function() {
        var idb = $(this).attr('class').split(' ');
		console.log(idb);
        $('#topbanner').css('display','none');
    });*/
    //$("#hd").css("z-index", 1000);
});
</script>
<!-- } 팝업레이어 끝 -->