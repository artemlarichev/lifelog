<script type="text/javascript" src="/tiny_mce/tiny_mce.js"></script>
	<script language="javascript" type="text/javascript">
tinyMCE.init({
		// General options
		mode : "exact", elements : "text_banner",language : "ru",
		theme : "advanced", content_css : "/css/tmce.css",
		plugins : "imagemanager,autolink,lists,advhr,advimage,advlink,emotions,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : " code,|bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,undo,redo,|,link,unlink,anchor,image,|,forecolor,backcolor",
		 

		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
       extended_valid_elements : "div[align|class|style|id|title]",
        extended_valid_elements : "iframe[name|src|framespacing|border|frameborder|scrolling|title|height|width],object[declare|classid|codebase|data|type|codetype|archive|standby|height|width|usemap|name|tabindex|align|border|hspace|vspace]",
 
 

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
	</script>
