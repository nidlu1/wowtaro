var newJquery = $.noConflict(true);
$(document).ready(function() {
	var ie = false;
	var agent = navigator.userAgent.toLowerCase();

	/* 높이 계산 */
	$(window).scroll(function() {
		var scTop = $(window).scrollTop();
		head_nav(scTop);
		if(ie){
			stickHeader(scTop);
			
		}
		stickView(scTop);
	});
	function head_nav(scTop) {
		if (scTop > 40) {
			$('#header').removeClass('on');
			$('#header').addClass('on')
			$('#aside').removeClass('on');
		} else {
			$('#header').removeClass('on');
			$('#aside').removeClass('on');
			$('#aside').addClass('on')
		}
	}


	/* 토글버튼 */
	$(function(){
		/* 메뉴 오픈 */
		$(document).on("click", '.hma_btn', function(){
			$('.hm_all').stop().toggleClass('on');
		});

		/* 검색 오픈 */
		$(document).on("click", '.hms_btn', function(){
			$('.hm_search').stop().toggleClass('on');
		});
	});


	/* 슬라이드 */

	var slide_hero = newJquery('.slide_hero');
	
	slide_hero.owlCarousel({
		items: 1,
		loop: true,
		nav: true,
		center: true,
		callbacks: true,
		animateOut: 'fadeOut',
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:false
	});
	var slide_type1 = newJquery('.slide_type1');
	slide_type1.owlCarousel({
		items: 1,
		loop: true,
		nav: false,
		center: true,
		callbacks: true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:false
	});
	var slide_type2 = newJquery('.slide_type2');
	slide_type2.owlCarousel({
		items: 5,
		loop: true,
		nav: true,
		center: true,
		callbacks: true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true
	});
	var slide_type3  = newJquery('.slide_type3');
	slide_type3 .owlCarousel({
		items: 1,
		loop: true,
		nav: true,
		center: true,
		callbacks: true,
		autoplay:false,
	});
	var slide_type4 = newJquery('.slide_type4');
	slide_type4.owlCarousel({
		items: 3,
		loop: true,
		margin:30,
		nav: true,
		center: true,
		callbacks: true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true
	});


	// Go to the next item
	newJquery('.p_box .pb_txt .pbt_btn').click(function (){
		 slide_type3.trigger('next.owl.carousel');
	});

	/* 아코디언 */
	$(function(){
		/* GNB 온 오프버튼 */
		$(document).on("click", '.n_menu', function(){
		//	$('.n_menu').click(function (){
			$('#wrap').stop().toggleClass('on');
		});

		/* 메뉴 아코디언 */
		$('.cm_depth1 > li > strong').click(function (){
			if($(this).hasClass('open')===true){
				if($(this).next().length>0){
					$(this).next().removeClass('open');
				}
				$(this).removeClass('open');
			}else{
				if($(this).next().length>0){
					$(this).next().addClass('open');
				}
				$(this).addClass('open');
			}
		});
	});

	/* 레이어팝업 */
	$(window).on('hashchange', function(){
		var className = "popup";
		
		var classUrl = location.href.split("#")[1];
		if (classUrl == "!" || classUrl == undefined) {
			$("." + className).removeClass("on");
		} else {
				$("." + className).removeClass("on");
				$("." + classUrl).addClass("on");

		}
	});

	var classUrl = location.href.split("#")[1];
		if(classUrl != "!" && classUrl != "")
			$("." + classUrl).addClass("on");

	if ((navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {
			$('#wrap').addClass("ie");
			ie = true;
		}
	function stickHeader(scTop){
		if(scTop > 80){
			$('#header').addClass("sticky");
		}else{
			$('#header').removeClass("sticky");
		}

	}

	function stickView(scTop){

		if($('.c_area').length != 0){
			if(scTop > $('.c_area').offset().top - 40 && scTop < $('#footer').offset().top -$(window).height() - 200){
				$('.c_area.view .ca_member').addClass("sticky");
				$('.c_area.view .ca_member').removeClass("end");
			} 
			else if(scTop > $('#footer').offset().top -$(window).height() - 200){
				$('.c_area.view .ca_member').addClass("end");
			}
			else{
				$('.c_area.view .ca_member').removeClass("sticky");
				$('.c_area.view .ca_member').removeClass("end");
			}
		}
	}

	$('#favorite').on('click', function(e) { 

		var bookmarkURL = window.location.href; 

		var bookmarkTitle = document.title;

		var triggerDefault = false; 

			

		if (window.sidebar && window.sidebar.addPanel) { 

			// Firefox version < 23 

			window.sidebar.addPanel(bookmarkTitle, bookmarkURL, ''); 

		} else if ((window.sidebar && (navigator.userAgent.toLowerCase().indexOf('firefox') > -1)) || (window.opera && window.print)) { 

			// Firefox version >= 23 and Opera Hotlist 

			var $this = $(this); 

			$this.attr('href', bookmarkURL); 

			$this.attr('title', bookmarkTitle); 

			$this.attr('rel', 'sidebar'); 

			$this.off(e); 

			triggerDefault = true; 

		} else if (window.external && ('AddFavorite' in window.external)) { 

			// IE Favorite 

			window.external.AddFavorite(bookmarkURL, bookmarkTitle); 

		} else { 

			// WebKit - Safari/Chrome 

			alert((navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') + '+D 키를 눌러 즐겨찾기에 등록하실 수 있습니다.'); 

		} 

		

		return triggerDefault; 

	});


});