$(document).ready(function() {

	$('.main_page .c_l_item:nth-child(5)').each(function() {
		$(this).addClass("five");
	});
	$('.main_page .c_l_item:nth-child(6)').each(function() {
		$(this).addClass("six");
	});

	var body = $('#wrapper');
	var body_with = body.width();

	var cat_with = $('.cat_list');
	var cat_with_w = cat_with.width();

	$('.cat_list').each(function() {
		if (cat_with_w > 880) {
			if (cat_with_w > 1060) {
				$(this).addClass("six_item");
			}
			else {
				$(this).addClass("five_item");
			}

		}
	});

	$('.lv1').each(function() {
		if (body_with > 980) {
			var ratio = (body_with - 1000) / 110;
			var ratio_w = ratio + 4;
			$(this).css('paddingLeft', ratio_w + '%');
		}
	});


	$(window).bind('resize', function() {
		resizeWindow();
	});


	function resizeWindow() {
		var cat_with_w = cat_with.width();
		var body_with = body.width();

		$('.cat_list').each(function() {
			if (cat_with_w > 890) {
				if (cat_with_w > 1060) {
					if ($(this).hasClass("five_item")) {
						$(this).removeClass("five_item");

					}
					$(this).addClass("six_item");
				}
				else {
					if ($(this).hasClass("six_item")) {
						$(this).removeClass("six_item");
					}
					$(this).addClass("five_item");
				}

			}
			else {
				if ($(this).hasClass("five_item")) {
					$(this).removeClass("five_item");
				}
				if ($(this).hasClass("six_item")) {
					$(this).removeClass("six_item");
				}
			}
		});

		$('.lv1').each(function() {
			if (body_with > 980) {
				var ratio = (body_with - 1000) / 110;
				var ratio_w = ratio + 4;
				$(this).css('paddingLeft', ratio_w + '%');
			}
		});


	}


});
$(document).ready(function() {
    $("a.gallery").fancybox({
			"showCloseButton": true,
			"titleShow": false,
			"scrolling": false,
						});
});


$('.modal-closer').arcticmodal('close');
