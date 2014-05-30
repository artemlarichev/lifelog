$(document).ready(function() {


	$('.header').each(function() {
		$(this).prepend("<span class=\"header_before\">&#160;<\/span>");
		$(this).prepend("<span class=\"header_after\">&#160;<\/span>");
	});

	$('.enter_form').each(function() {
		$(this).prepend("<span class=\"enter_form_before\">&#160;<\/span>");
	});

	$('.user_form').each(function() {
		$(this).prepend("<span class=\"user_form_before\">&#160;<\/span>");
	});

	$('.manager_form').each(function() {
		$(this).prepend("<span class=\"manager_form_before\">&#160;<\/span>");
	});

	$('.static').each(function() {
		$(this).prepend("<span class=\"static_before\">&#160;<\/span>");
	});

	
	$('.table tr:nth-child(even)').each(function() {
		$(this).addClass("even")
	});
	

	$('input[type="text"], input[type="password"]').each(function() {
		$(this).addClass("text")
	});



});