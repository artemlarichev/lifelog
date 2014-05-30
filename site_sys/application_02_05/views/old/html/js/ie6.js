$(document).ready(function() {


	$('.main_page').each(function() {
		$(this).prepend("<span class=\"main_page_before\">&#160;<\/span>");
	});

	$('.info_wrap').each(function() {
		$(this).prepend("<span class=\"info_wrap_before\">&#160;<\/span>");
	});

//	$('.main_page .main_row').each(function() {
//		$(this).prepend("<span class=\"main_page_main_row_before\">&#160;<\/span>");
//	});

//	$('.inner_two_col  .main_row').each(function() {
//		$(this).prepend("<span class=\"inner_two_col_before\">&#160;<\/span>");
//	});

	$('.inner_two_col  .h_line').each(function() {
		$(this).prepend("<span class=\"h_line_before\">&#160;<\/span>");
	});
	$('.inner_one_col  .h_line').each(function() {
		$(this).prepend("<span class=\"h_line_before\">&#160;<\/span>");
	});

	$('.curr_page').each(function() {
		$(this).prepend("<span class=\"curr_page_before\">&#160;<\/span>");
	});

	$('.cat_block_full .c_i_f_menu a').each(function() {
		$(this).prepend("<span class=\"c_i_f_menu_a_before\"><\/span>");
	});

	$('.r_menu a').each(function() {
		$(this).prepend("<span class=\"r_menu_a_before\"><\/span>");
	});

	$('.email_form label[for="fio"], .email_form label[for="tel"]').each(function() {
		$(this).addClass("important")
	});

	$('.side_form input[type="text"]').each(function() {
		$(this).addClass("form_field")
	});

	$('.lv1:first-child, .breadcrumbs li:first-child, .user_menu li:first-child, .user_menu_inner li:first-child, .c_i_f_menu li:first-child, .c_i_f_text p:first-child, .cat_block_full .c_i_f_menu li:first-child, .c_i_f_text h2:first-child, .c_i_f_func h2:first-child, .c_i_f_spec table:first-child, .s_text p:first-child, .where_buy td:first-child').each(function() {
		$(this).addClass("first-child")
	});

	$('.cat_block:first-child').each(function() {
		$(this).addClass("cat_block_first-child")
	});

	$('.cat_col .h_line_sub:first-child').each(function() {
		$(this).addClass("h_line_sub_first-child")
	});





});