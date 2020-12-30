$(document).ready(function(){
	var date = new Date();
	var month = date.getMonth();
	var $sliderBy = $('#event-by-month');
	$sliderBy.slick({
		vertical: true,
		slidesToShow: 5,
		slidesToScroll: 1,
		infinite: true,
		centerMode: true
	});
	
	$('.section-event .left-content .slick-slide').click(function(){
		$('.event-slider.active').removeClass('active');
		var $month = "." + $(this).attr('data-month');
		var $position = $(this).attr('data-slick-index');
		$sliderBy.slick('slickGoTo', $position);
		$($month + '.event-slider').addClass('active');
	});
	
	$('.event-slider.t' + (month + 1)).addClass('active');

	
	var $slider = $('.event-slider');
	$slider.on('init', function(event, slick){
		$('.count-event .slider-nav .next').click(function(){
			var $slick = $(this).parent().attr('data-slider');
			$(document).find($slick + ' .slick-next.slick-arrow').click();
		});
		$('.count-event .slider-nav .prev').click(function(){
			var $slick = $(this).parent().attr('data-slider');
			$(document).find($slick + ' .slick-prev.slick-arrow').click();
		});
	});
	$slider.slick({
		vertical: false,
		slidesToShow: 1,
		centerMode: false,
		slidesToScroll: 1,
		touchMove: true
	});
	
	var $slider = $('.js-quan-11-travel-slider');
	$slider.slick({
		vertical: false,
		slidesToShow: 3,
		centerMode: false,
		slidesToScroll: 3,
		touchMove: true
	});
	
	$('.owl-filter-bar .item').click(function(){
		if(!$(this).hasClass('active')){
			$('.owl-filter-bar .item.active').removeClass('active');
			$(this).addClass('active');
			var $elementFt = $(this).attr('data-owl-filter');
			$('.js-quan-11-travel-slider.active').removeClass('active');
			$($elementFt).addClass('active');
		}
	});
	
	/* Dulich Scroll Section */
	setTimeout(function(){
		$.scrollify({
			section:"body.dulich-khampha-index > main > section",
			scrollbars:true,
			setHeights: false,
			touchScroll:false,
			overflowScroll: false,
			before: function(i,panels) {
				var ref = panels[i].attr("data-section-name");
				$(".menu-content-scroll-v2 li.active").removeClass("active");
				$(".section-home-content.active").removeClass("active");
				$(".section-home-content[data-section-name="+ref+"]").addClass("active");
				$(".menu-content-scroll-v2 li.js-scroll-" + ref).addClass("active");
				$('.section-home-content:not(.active) .animate__animated').each(function(){
					var animateClass = $(this).data('animate');
					$(this).removeClass(animateClass);
				});
				$('.section-home-content.active .animate__animated').each(function(){
					var animateClass = $(this).data('animate');
					$(this).addClass(animateClass);
				});
				if(ref === "su-kien") {
					$sliderBy.slick('slickGoTo', month);
				}
			},
			afterRender:function() {
				var $current = $.scrollify.current();
				var ref = $current.attr("data-section-name");
				$(".menu-content-scroll-v2 li.js-scroll-" + ref).addClass("active");
				$current.addClass('active');
				$('.section-home-content:not(.active) .animate__animated').each(function(){
					var animateClass = $(this).data('animate');
					$(this).removeClass(animateClass);
				});
				$(".menu-content-scroll-v2 ul li a").on("click",function(e) {
					e.preventDefault();
					$.scrollify.move($(this).attr("href"));
				});
				$(".dulich-khampha-index .vertical-header .header-social .move_down").on("click",function() {
					$.scrollify.next();
				});
			}
		});
	}, 1000);
});