$(document).ready(function(){
	/* Megamenu Count */
	$('.header-menu-main > li').each(function(index){
		var count = index + 1;
		$(this).find('> a').attr('data-count', count);
	});
	/* Megamenu Open & Close */
	$('.logo-menu-bar .hamburger-menu').click(function(){
		$('html').addClass('active-menu');
	});
	$('#megamenu_content .close-menu').click(function(){
		$('html').removeClass('active-menu');
	});
	/* Gallery */
	$('.gallery-thumbnail').magnificPopup({
		delegate: '.gallery-thumbnail-item a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-gallery',
		fixedContentPos: true,
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0, 1]
		},
		iframe: {
			markup: '<div class="mfp-iframe-scaler">' + '<div class="mfp-close"></div>' + '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' + '<div class="mfp-bottom-bar">' + '<div class="mfp-title"></div>' + '<div class="mfp-counter"></div>' + '</div>' + '</div>'
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
		},
		callbacks: {
			open: function() {
				var magnificPopup = $.magnificPopup.instance;
				console.log(magnificPopup.currItem);
				$('.mfp-title').text(magnificPopup.currItem.el.find('.title').text());
			},
			elementParse: function(item) {
				if (item.el.hasClass('video')) {
					item.type = 'iframe';
				} else {
					item.type = 'image';
				}
			}
		}
	});
	
	$('.contact-list-items > li.active ul').slideDown();
	$('.contact-list-items > li').click(function(){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$(this).find('ul').slideUp();
		}else {
			$(this).addClass('active');
			$(this).find('ul').slideDown();
		}
		
	});
});