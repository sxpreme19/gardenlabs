(function($) {
    "use strict";
	
	/* ..............................................
	   Loader 
	   ................................................. */
	$(window).on('load', function() {
		$('.preloader').fadeOut();
		$('#preloader').delay(550).fadeOut('slow');
		$('body').delay(450).css({
			'overflow': 'visible'
		});
	});

	/* ..............................................
	   Fixed Menu
	   ................................................. */

	$(window).on('scroll', function() {
		if ($(window).scrollTop() > 50) {
			$('.main-header').addClass('fixed-menu');
		} else {
			$('.main-header').removeClass('fixed-menu');
		}
	});

	/* ..............................................
	   Gallery
	   ................................................. */
	$(document).ready(function() {
		$('#slides-shop').superslides({
			inherit_width_from: '.cover-slides',
			inherit_height_from: '.cover-slides',
			play: 5000,
			animation: 'fade',
		});
	});

	$(".cover-slides ul li").append("<div class='overlay-background'></div>");

	/* ..............................................
	   Map Full
	   ................................................. */

	$(document).ready(function() {
		$(window).on('scroll', function() {
			if ($(this).scrollTop() > 100) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
		$('#back-to-top').click(function() {
			$("html, body").animate({
				scrollTop: 0
			}, 600);
			return false;
		});
	});

	/* ..............................................
	   Special Menu
	   ................................................. */
$(document).ready(function() {
	var Container = $('.container');
	Container.imagesLoaded(function() {
		var portfolio = $('.special-menu');
		portfolio.on('click', 'button', function() {
			$(this).addClass('active').siblings().removeClass('active');
			var filterValue = $(this).attr('data-filter');
			$grid.isotope({
				filter: filterValue
			});
		});
		var $grid = $('.special-list').isotope({
			itemSelector: '.special-grid'
		});
	});
});

	/* ..............................................
	   BaguetteBox
	   ................................................. */

	baguetteBox.run('.tz-gallery', {
		animation: 'fadeIn',
		noScrollbars: true
	});

	/* ..............................................
	   Offer Box
	   ................................................. */
	$(document).ready(function() {
	$('.offer-box').inewsticker({
		speed: 3000,
		effect: 'fade',
		dir: 'ltr',
		font_size: 13,
		color: '#ffffff',
		font_family: 'Montserrat, sans-serif',
		delay_after: 1000
	});
});
	/* ..............................................
	   Tooltip
	   ................................................. */

	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});

	/* ..............................................
	   Owl Carousel Instagram Feed
	   ................................................. */
	$(document).ready(function() {
	$('.main-instagram').owlCarousel({
		loop: true,
		margin: 0,
		dots: false,
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true,
		navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
		responsive: {
			0: {
				items: 2,
				nav: true
			},
			600: {
				items: 3,
				nav: true
			},
			1000: {
				items: 5,
				nav: true,
				loop: true
			}
		}
	});
});
	/* ..............................................
	   Featured Products
	   ................................................. */
	$(document).ready(function() {
	$('.featured-products-box').owlCarousel({
		loop: true,
		margin: 15,
		dots: false,
		autoplay: true,
		autoplayTimeout: 3000,
		autoplayHoverPause: true,
		navText: ["<i class='fas fa-arrow-left'></i>", "<i class='fas fa-arrow-right'></i>"],
		responsive: {
			0: {
				items: 1,
				nav: true
			},
			600: {
				items: 3,
				nav: true
			},
			1000: {
				items: 4,
				nav: true,
				loop: true
			}
		}
	});
});
	/* ..............................................
	   Scroll
	   ................................................. */

	$(document).ready(function() {
		$(window).on('scroll', function() {
			if ($(this).scrollTop() > 100) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
		$('#back-to-top').click(function() {
			$("html, body").animate({
				scrollTop: 0
			}, 600);
			return false;
		});
	});

	/* ..............................................
	   Cart Product Quantity
	   ................................................. */

	   $(function() {
		const quantityInputs = document.querySelectorAll('.quantity-box input');
		
		quantityInputs.forEach(input => {
			input.addEventListener('input', function () {
				const row = this.closest('tr'); 
				const priceElement = row.querySelector('.price-pr'); 
				const price = parseFloat(priceElement.textContent.replace('€', '').trim()); 
	
				if (isNaN(price)) {
					console.error('Invalid price value');
					return;
				}
	
				const quantity = parseInt(this.value) || 0; 
				const total = price * quantity;
	
				const totalElement = row.querySelector('.total-pr p');
				if (totalElement) {
					totalElement.textContent = `${total.toFixed(2)}€`;
				} else {
					console.error('Total price element not found');
				}

				const form = this.closest('form');
				if (form) {
					form.submit();
				}
			});
		});
	});

	/* ..............................................
	   Slider Range
	   ................................................. */

	   jQuery(document).ready(function() {

		var minPrice = window.minPrice;  
   		var maxPrice = window.maxPrice;

		jQuery("#slider-range").slider({
			range: true,
			min: minPrice,
			max: maxPrice, 
			values: [minPrice, maxPrice], 
			slide: function(event, ui) {
				jQuery("#amount").val(ui.values[0] + "€ - " + ui.values[1] + "€");
			}
		});
	
		jQuery("#amount").val(jQuery("#slider-range").slider("values", 0) + "€ - " + jQuery("#slider-range").slider("values", 1) + "€");
	
		jQuery("#filter-button").click(function() {
			var minPrice = jQuery("#slider-range").slider("values", 0);
			var maxPrice = jQuery("#slider-range").slider("values", 1);
	
			var currentUrl = window.location.href.split('?')[0];  
			var queryParams = new URLSearchParams(window.location.search);  
	
			queryParams.set('minPrice', minPrice);
			queryParams.set('maxPrice', maxPrice);
	
			var newUrl = currentUrl + "?" + queryParams.toString();
			window.location.href = newUrl;
		});
	});	
	
	/* ..............................................
	   NiceScroll
	   ................................................. */
$(document).ready(function() {
	$(".brand-box").niceScroll({
		cursorcolor: "#9b9b9c",
	});
});
}(jQuery));

