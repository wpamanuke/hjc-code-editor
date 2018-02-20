jQuery(document).ready(function( $ ) {
	
	
	
	ace.require("ace/ext/language_tools");
	
	var editor_html = ace.edit("js_html_temp");
	editor_html.setTheme("ace/theme/monokai");
	editor_html.session.setMode("ace/mode/php");
	editor_html.setOptions({
		enableBasicAutocompletion: true
	});
	var textarea_html = $('#js_html');
	editor_html.getSession().on("change", function () {
		
		textarea_html.val(editor_html.getSession().getValue());
	});
		
	
	var editor_js = ace.edit("js_js_temp");
	editor_js.setTheme("ace/theme/dracula");
	editor_js.session.setMode("ace/mode/javascript");
	editor_js.setOptions({
		enableBasicAutocompletion: true
	});
	var textarea_js = $('#js_js');
	editor_js.getSession().on("change", function () {
		textarea_js.val(editor_js.getSession().getValue());
	});
	
	var editor_css = ace.edit("js_css_temp");
	editor_css.setTheme("ace/theme/chaos");
	editor_css.session.setMode("ace/mode/css");
	editor_css.setOptions({
		enableBasicAutocompletion: true
	});
	var textarea_css = $('#js_css');
	editor_css.getSession().on("change", function () {
		textarea_css.val(editor_css.getSession().getValue());
	});
	
	
});