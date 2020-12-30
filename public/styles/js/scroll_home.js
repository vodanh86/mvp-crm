$(document).ready(function(){
	/* Home Page Scroll Section */
	var timeOutMenuDelay;
	timeOutPageLoad = setTimeout(function(){ 
		$.scrollify({
			section:"body.homepage-index-index > main > section",
			scrollbars:true,
			setHeights: false,
			touchScroll:false,
			overflowScroll: false,
			before: function(i,panels) {
				clearTimeout(timeOutMenuDelay);
				var ref = panels[i].attr("data-section-name");
				$(".menu-content-scroll li.active").removeClass("active");
				$(".section-home-content.active").removeClass("active");
				$(".section-home-content[data-section-name="+ref+"]").addClass("active");
				$(".menu-content-scroll li.js-scroll-" + ref).addClass("active");
				$('.section-home-content:not(.active) .animate__animated').each(function(){
					var animateClass = $(this).data('animate');
					$(this).removeClass(animateClass);
				});
				$('.section-home-content.active .animate__animated').each(function(){
					var animateClass = $(this).data('animate');
					$(this).addClass(animateClass);
				});
				$('.menu-content-scroll ul').addClass('delay-effect');
				timeOutMenuDelay = setTimeout(function(){
					$('.menu-content-scroll ul').removeClass('delay-effect');
				}, 1200);
				if(ref === "introduction"){
					$('.vertical-header').addClass('ver-blue');
					$('.vertical-header').removeClass('ver-gray');
				}else if(ref === "location"){
					$('.vertical-header').addClass('ver-gray');
					$('.vertical-header').removeClass('ver-blue');
				}else {
					$('.vertical-header').removeClass('ver-gray');
					$('.vertical-header').removeClass('ver-blue');
				}
			},
			afterRender:function() {
				$('.menu-content-scroll ul').addClass('delay-effect');
				var $current = $.scrollify.current();
				var ref = $current.attr("data-section-name");
				$(".menu-content-scroll li.js-scroll-" + ref).addClass("active");
				$current.addClass('active');
				$('.section-home-content:not(.active) .animate__animated').each(function(){
					var animateClass = $(this).data('animate');
					$(this).removeClass(animateClass);
				});
				$(".menu-content-scroll ul li a").on("click",function(e) {
					e.preventDefault();
					$.scrollify.move($(this).attr("href"));
				});
				$(".section-welcome .action-down").on("click",function() {
					$.scrollify.next();
				});
				timeOutMenuDelay = setTimeout(function(){
					$('.menu-content-scroll ul').removeClass('delay-effect');
				}, 3000);
			}
		});
	}, 1000);
});