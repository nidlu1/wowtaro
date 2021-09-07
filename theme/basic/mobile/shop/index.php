<?php
include_once('./_common.php');
/* 회원이 접속하면 상담사의 상태값이 상담중, 예약대기 인 경우 휴먼정보의 상태값으로 변경 */
counsel_stat_update();
/* 회원이 접속하면 상담사의 상태값이 상담중, 예약대기 인 경우 휴먼정보의 상태값으로 변경 */
define("_INDEX_", TRUE);

include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
?>

<!-- 
<script src="<?php echo G5_JS_URL; ?>/swipe.js"></script>
<script src="<?php echo G5_JS_URL; ?>/shop.mobile.main.js"></script>

<?php echo display_banner('메인', 'mainbanner.10.skin.php'); ?>
<?php echo display_banner('왼쪽', 'boxbanner.skin.php'); ?>
 -->
		<div class="cm_hero">
			<?php echo display_banner('메인', 'mainbanner.10_reform.skin.php'); ?>
			<ul class="cmh_btn">
				<li><a href="#counsel"><strong>바로상담</strong><span>060-300-6700</span></a></li>
				<li><a href="#counsel" class="focus"><strong>할인상담</strong><span>02-3433-1177</span></a></li>
			</ul>
			<div class="cmh_scroll">
				<a href="#page"><i></i><span class="blind">SCROLL</span></a>
			</div>
		</div>
		<div class="cm_quick" id="page">
			<div class="cmq_wrap">
				<div class="wrap">
					<ul>
						<li>
							<a href="/free_counsel.php">
								<i class="cmq_icon discount"></i>
								<strong>5분 무료안내</strong>
								<span>회원가입 시 최초 1인 1회 제공</span>
							</a>
						</li>
						<li>
							<a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=dream">
								<i class="cmq_icon dream"></i>
								<strong>무료 꿈해몽</strong>
								<span>회원가입만으로 누리는 꿈해몽 상담가기!</span>
							</a>
						</li>
						<li>
							<a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=charm">
								<i class="cmq_icon talisman"></i>
								<strong>찐 부적 무료</strong>
								<span>상담받고 무료 부적신청 하세요.</span>
							</a>
						</li>
						<li>
							<a href="<?php echo G5_BBS_URL; ?>/faq.php?fm_id=4">
								<i class="cmq_icon faq"></i>
								<strong>자주묻는 질문</strong>
								<span>궁금한게 있으신가요? 친절히 알려드립니다.</span>
							</a>
						</li>
					</ul>
				</div>
				<div class="cmq_deco">
					<i></i><i></i><i></i><i></i><i></i><i></i>
				</div>
			</div>
		</div>
		<div class="cm_month">
			<h3 class="title font cb enter">
				<span>신선운세</span>
				<strong class="bold cb">이달의 선생님</strong>
			</h3>
			<div class="slide_type2 owl-carousel">
				<?php
				$t5sql = "SELECT * FROM ".$g5['member_table']." WHERE mb_level='3' AND mb_type5='1' AND mb_status=2 ORDER BY rand() LIMIT 5";
				$t5res = sql_query($t5sql);
				while ( $t5row = sql_fetch_array($t5res) ) {
					$mb_1_arr = explode(",", $t5row['mb_1']);
					$scat_arr = s_cat_func($t5row['mb_2']);
					if ( in_array('10', $mb_1_arr) ) {
							$bcat_str = "taro";
							$bcat_str2 = "타로";
							$ca_id=10;
					}
					else if ( in_array('20', $mb_1_arr) ) {
							$bcat_str = "sin";
							$bcat_str2 = "신점";
							$ca_id=20;
					}
					else if ( in_array('30', $mb_1_arr) ) {
							$bcat_str = "saju";
							$bcat_str2 = "사주";
							$ca_id=30;
					}
					else if ( in_array('40', $mb_1_arr) ) {
							$bcat_str = "pet";
							$bcat_str2 = "펫타로";
							$ca_id=40;
					}
					else if ( in_array('50', $mb_1_arr) ) {
							$bcat_str = "dream";
							$bcat_str2 = "꿈해몽";
							$ca_id=50;
					}
					else {
							$bcat_str = "taro";
							$bcat_str2 = "타로";
							$ca_id=10;
					}
				?>
					<div class="item">
						<a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $ca_id; ?>&it_id=<?php echo $t5row['mb_no']; ?>" class="cmm_box">
							<div class="cmm_pic">
								 <img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $t5row['mb_no']; ?>/<?php echo $t5row['mb_8']; ?>" alt="<?php echo $t5row['mb_nick']; ?>  이미지">
							</div>
							<div class="cmm_focus"></div>
							<div class="cmm_category">
								<strong><?php echo $bcat_str2; ?></strong>
							</div>
							<div class="cmm_name">
								<span><?php echo $t5row['mb_nick']; ?></span>
								<strong><?php echo $t5row['mb_id']; ?>번</strong>
							</div>
							<div class="cmm_txt">
								<?php echo $t5row['mb_9']; ?>
							</div>
							<div class="cmm_hash">
								<ul>
									<?php
									for ($j = 0; $j < 3; $j++) {
									?>
										<li><span><?php echo $scat_arr[$j]['ht_name']; ?></span></li>
									<?php
									}
									?>
								</ul>
							</div>
						</a>
					</div>
				<?php
				}
				?>
			</div>
			<div class="cmm_deco">
				<i></i><i></i><i></i><i></i>
			</div>
		</div>
		<div class="cm_review">
			<h3 class="title font cb enter">
				<span>신선운세</span>
				<strong class="bold cb">베스트 후기</strong>
			</h3>
			<div class="slide_type1 owl-carousel">
					<?php
						$itemCount =0;
						$best_sql = "select b.mb_nick, b.mb_no, b.mb_id, b.mb_8, a.is_subject, a.is_cat2, a.is_content, a.is_score from `g5_shop_item_use` a join `g5_member` b on (a.it_id=b.mb_no AND b.mb_level='3' AND b.mb_hide='0') where a.is_confirm = '1' AND is_best='1' order by rand() limit 0, 12";
						$best_query = sql_query($best_sql);
						while($best_result = sql_fetch_array($best_query)){
                            $ca_id;
                            switch($best_result['is_cat2']){
                                case "타로":
                                    $ca_id=10;
                                    break;
                                case "신점":
                                    $ca_id=20;
                                    break;
                                case "사주":
                                    $ca_id=30;
                                    break;
                                case "펫타로":
                                    $ca_id=40;
                                    break;
                                case "꿈해몽":
                                    $ca_id=50;
                                    break;
                                default:
                                    $ca_id=10;
                                    break;
                            }
							if($itemCount % 4 == 0){
								echo "<div class='item'>";
							}
							$itemCount++;
							$star_str = "";
							for ($jj = 1; $jj <= 5; $jj++) {
								if ($jj <= $best_result['is_score']) $star_str .= "<i class='cmri_icon on'></i>";
								else $star_str .= "<i class='cmri_icon off'></i>";
							}
					?>
						<div class="cmr_box">
							<div class="cmr_pic">
								<a href="<?php echo G5_SHOP_URL; ?>/item.php?ca_id=<?php echo $ca_id; ?>&it_id=<?php echo $best_result['mb_no']; ?>"></a>
								<img src="<?php echo G5_DATA_URL; ?>/temp/<?php echo $best_result['mb_no']; ?>/<?php echo $best_result['mb_8']; ?>"alt="<?php echo $best_result['www']; ?>">
							</div>
							<div class="cmr_txt">
								<p><span><?=$best_result['mb_nick']?></span> <strong><?=$best_result['mb_id']?>번</strong></p>
								<a href="/shop/itemuselist.php?gubun=best#ca_tab" class="text s05 left"><?=$best_result['is_content']?></a>
							</div>
							<div class="cmr_info">
								<ul>
									<li><strong><?php echo $best_result['is_cat2']; ?></strong></li>
									<li>
										<?php echo $star_str; ?>
									</li>
								</ul>
							</div>
						</div>
						<hr>
					<?php 
						if($itemCount % 4 == 0){
							echo "</div>";
						}
					}
					if($itemCount % 4 != 0){
							echo "</div>";
						}
					?>
			</div>
			<div class="cmr_deco">
				<i></i><i></i><i></i><i></i><i></i>
			</div>
		</div>
		<div class="cm_youtube">
			<div class="wrap">
				<div class="cmy_wrap">
					<h3 class="mt3 title font cw enter">
						<span>신선운세</span>
						<strong class="bold cw">YOUTUBE</strong>
					</h3>
					<p class="mt15 text mini medium font cw s05">공식 유튜브 채널을 통해 다양한 이야기를 함께하세요.</p>
				</div>
				<div class="cmy_video mt25">
					<iframe  src="https://www.youtube.com/embed/-Hec1ogSn9s" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<img src="/images/m/ratio_16x9.png"/>
				</div>
				<ul class="mt30">
					<li><a href="https://www.youtube.com/channel/UCik5S72bGO9nEA0jeAAS7FQ/featured" target="_blank" class="btn t1 font">채널 <span class="light">바로가기</span></a></li>
				</ul>
			</div>
		</div>
		<div class="cm_app">
			<div class="wrap">
				<div class="cma_wrap">
					<h3 class="title font cw enter">
						<span>신선운세</span>
						<strong class="bold cw">앱 다운로드</strong>
					</h3>
					<p class="mt5 text mini medium font cw">신선운세를 스마트폰에서도 간편하게 즐겨보세요.</p>
					<ul class="btn_wrap mt25">
						<li><a href="#" class="btn font"><i class="cmp_icon apple"></i><span>App Store</span></a></li>
						<li><a href="#" class="btn font"><i class="cmp_icon google"></i><span>Google Play</span></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="cm_banner">
			<div class="wrap">
				<div class="cmb_wrap">
					<h3 class="title font cb s1 enter">
						<span>신선운세</span>
						<strong class="bold">이벤트 의뢰</strong>
					</h3>
					<p class="mt5 text mini thin font cb s05">
						<span>타로와 캐리커쳐를 동시에 진행할 수 있는</span>
						<strong class="medium">다양한 이벤트 행사!</strong>
					</p>
					<ul class="mt30">
						<li><a href="<?php echo G5_BBS_URL; ?>/write.php?bo_table=event_form" class="btn t1 font">더 알아보기</a></li>
					</ul>
				</div>
				<div class="cmb_deco">
					<i></i><i></i><i></i>
				</div>
			</div>
		</div>

<?php
include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
?>
