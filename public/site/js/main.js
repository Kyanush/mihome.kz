/**************** Каталог меню *****************/
function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".more-less")
        .toggleClass('glyphicon-plus glyphicon-minus');
}
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);
/**************** Каталог меню *****************/

(function($) {
	"use strict"

    // Catalog menu
    $('.cat_menu .fa').on('click', function (e){
        e.preventDefault();
    });

    $('.show-full').on('click', function (e){
    	 $('.company-text').addClass('full');
         $('#description').addClass('full');
    	 $(this).remove();
    });

    $('.cat_menu_container').hover(function(e) {

        var allimages = $(this).find('img.lazy-my');

        for (var i = 0; i < allimages.length; i++)
            $( allimages[i] ).attr("src",  $(allimages[i]).data('original'));

    });

    $('.show-more-filters').on('click', function (e){
        $(this).parents('.checkbox-filter').find('.hide').removeClass('hide');
        $(this).remove();
    });

	// Catalog filter
    $('#filterpro .aside-title').on('click', function (e) {
        if($(this).next(".checkbox-filter").hasClass('active')){
            $(this).next(".checkbox-filter").removeClass('active')
		}else{
            $(this).next(".checkbox-filter").addClass('active')
		}
    });

	// Mobile Nav toggle
	$('#menu-mobile > a, #close-menu').on('click', function (e) {
		e.preventDefault();
		$('#responsive-nav').toggleClass('active');
	});

	// Fix cart dropdown from closing
	$('.cart-dropdown').on('click', function (e) {
		e.stopPropagation();
	});

	/////////////////////////////////////////

	// Products Slick
	$('.products-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
            lazyLoad: 'ondemand',
            ease : 'Pow4.easeIn',

			slidesToShow: 4,
			slidesToScroll: 1,
			autoplay: false,
			infinite: true,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
			responsive: [{
	        breakpoint: 991,
	        settings: {
	          slidesToShow: 2,
	          slidesToScroll: 1,
	        }
	      },
	      {
	        breakpoint: 480,
	        settings: {
	          slidesToShow: 1,
	          slidesToScroll: 1,
	        }
	      },
	    ]
		});

        $this.on('beforeChange', function(event, slick, currentSlide, nextSlide){
            $("img.lazy").lazyload();
        });

	});


	// Products Widget Slick
	$('.products-widget-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
			infinite: true,
			autoplay: false,
			speed: 300,
			dots: false,
			arrows: true,
			appendArrows: $nav ? $nav : false,
		});
	});

	/////////////////////////////////////////



    // Main slider
    $('.main-slider').slick({
        lazyLoad: 'ondemand',
        infinite: true,
        speed: 300,
        dots: true,
        arrows: true,
        fade: true,
        autoplay: true,
    });
    $('.main-slider').on('lazyLoaded', function (e, slick, image, imageSource) {
    	image.parent().css('background-image', 'url("' + imageSource + '")');
    	image.remove();
    });






    // Product imgs Slick
  $('#product-imgs').slick({
    lazyLoad: 'ondemand',
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    centerMode: true,
    focusOnSelect: true,
		centerPadding: 0,
		vertical: true,
    	asNavFor: '#product-main-img',
		responsive: [{
        breakpoint: 991,
        settings: {
					vertical: false,
					arrows: false,
					dots: true
        }
      }]
  });
	// Product Main img Slick
	$('#product-main-img').slick({
        lazyLoad: 'ondemand',
		infinite: true,
		speed: 300,
		dots: false,
		arrows: true,
		fade: true,
		asNavFor: '#product-imgs'
	});

	// Product img zoom




	/////////////////////////////////////////

	// Input number
	$('.input-number').each(function() {
		var $this = $(this),
		$input = $this.find('input[type="number"]'),
		up = $this.find('.qty-up'),
		down = $this.find('.qty-down');

		down.on('click', function () {
			var value = parseInt($input.val()) - 1;
			value = value < 1 ? 1 : value;
			$input.val(value);
			$input.change();
			updatePriceSlider($this , value)
		})

		up.on('click', function () {
			var value = parseInt($input.val()) + 1;
			$input.val(value);
			$input.change();
			updatePriceSlider($this , value)
		})
	});

	var priceInputMax = document.getElementById('price-max'),
		priceInputMin = document.getElementById('price-min');

	if(priceInputMax)
		priceInputMax.addEventListener('change', function(){
			updatePriceSlider($(this).parent() , this.value)
		});

	if(priceInputMin)
		priceInputMin.addEventListener('change', function(){
			updatePriceSlider($(this).parent() , this.value)
		});

	function updatePriceSlider(elem , value) {
		if ( elem.hasClass('price-min') ) {
			console.log('min')
			priceSlider.noUiSlider.set([value, null]);
            urlParamsGenerate();
		} else if ( elem.hasClass('price-max')) {
			console.log('max')
			priceSlider.noUiSlider.set([null, value]);
            urlParamsGenerate();
        }
	}

	// Price Slider


	var priceSlider = document.getElementById('price-slider');
	if (priceSlider)
	{
        var price_min = parseInt($('#catalog-price-min').val());
        var price_max = parseInt($('#catalog-price-max').val());
        var start     = JSON.parse($('#catalog-price-value').val());

        noUiSlider.create(priceSlider, {
			start: start,
			connect: true,
			step: 1,
			range: {
				'min': price_min,
				'max': price_max
			},
            format: {
                from: function(value) {
                    return parseInt(value);
                },
                to: function(value) {
                    return parseInt(value);
                }
            }
		});

		priceSlider.noUiSlider.on('update', function( values, handle ) {
			var value = values[handle];
			handle ? priceInputMax.value = value : priceInputMin.value = value
		});
        priceSlider.noUiSlider.on('change', function ( values, handle ) {
            urlParamsGenerate();
        });

	}

    $('[data-toggle="tooltip"]').tooltip()

})(jQuery);
