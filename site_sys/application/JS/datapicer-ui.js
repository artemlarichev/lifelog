/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Andrew Stromnov (stromnov@gmail.com). */
jQuery(function($){
	$.datepicker.regional['ru'] = {
		closeText: 'ааАаКбббб',
		prevText: '&#x3c;абаЕаД',
		nextText: 'аЁаЛаЕаД&#x3e;',
		currentText: 'аЁаЕаГаОаДаНб',
		monthNames: ['аЏаНаВаАбб','аЄаЕаВбаАаЛб','ааАбб','ааПбаЕаЛб','ааАаЙ','абаНб',
		'абаЛб','ааВаГббб','аЁаЕаНббаБбб','ааКббаБбб','ааОбаБбб','ааЕаКаАаБбб'],
		monthNamesShort: ['аЏаНаВ','аЄаЕаВ','ааАб','ааПб','ааАаЙ','абаН',
		'абаЛ','ааВаГ','аЁаЕаН','ааКб','ааОб','ааЕаК'],
		dayNames: ['аВаОбаКбаЕбаЕаНбаЕ','аПаОаНаЕаДаЕаЛбаНаИаК','аВбаОбаНаИаК','ббаЕаДаА','баЕбаВаЕбаГ','аПббаНаИбаА','ббаБаБаОбаА'],
		dayNamesShort: ['аВбаК','аПаНаД','аВбб','ббаД','ббаВ','аПбаН','баБб'],
		dayNamesMin: ['аб','ааН','аб','аЁб','аЇб','аб','аЁаБ'],
		weekHeader: 'ааЕаД',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
});