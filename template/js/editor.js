jQuery(document).ready(function( $ ) {
	
	
	
	ace.require("ace/ext/language_tools");
	
	var editor_html = ace.edit("js_html");
	editor_html.setTheme("ace/theme/monokai");
	editor_html.session.setMode("ace/mode/php");
	editor_html.setOptions({
		enableBasicAutocompletion: true
	});
	
	var editor_js = ace.edit("js_js");
	editor_js.setTheme("ace/theme/dracula");
	editor_js.session.setMode("ace/mode/javascript");
	editor_js.setOptions({
		enableBasicAutocompletion: true
	});
	
	var editor_css = ace.edit("js_css");
	editor_css.setTheme("ace/theme/chaos");
	editor_css.session.setMode("ace/mode/css");
	editor_css.setOptions({
		enableBasicAutocompletion: true
	});
	
	/* EVENT */
	$("#btn-preview").click(function() {
		
		var doc =  editor_html.getSession().getValue() + "<style>" +  editor_css.getSession().getValue() + "</style><script>" +  editor_js.getSession().getValue() + "</script>";
		var iframeDoc = $("#js_preview").contents()[0];            
		iframeDoc.open();            
		iframeDoc.write(doc);            
		iframeDoc.close();  
		//document.getElementById('preview').contentWindow.location.reload();
		$("#js_preview").addClass('preview-full');
		$("#btn-preview-close").show();
	 });
	 
	$("#btn-preview-close").click(function() {
		$("#js_preview").removeClass('preview-full');
		$("#btn-preview-close").hide();
	});
 
	$("#btn-clear-all").click(function() {
		clearAll();
	});
	
	// full / minimize
	$("#btn-html").click(function() {
		$(".js_html_container").toggleClass('preview-full nobscode');
		editor_html.resize();
	});
 
	$("#btn-js").click(function() {
		$(".js_js_container").toggleClass('preview-full nobscode');
		editor_js.resize();
	});
	
	$("#btn-css").click(function() {
		$(".js_css_container").toggleClass('preview-full nobscode');
		editor_css.resize();
	});
	
	$("#btn-save").click(function() {
		save_data();
	});
	
	/* FUNCTIONS */
	function clearAll(){
	  
		editor_html.getSession().setValue("");
		editor_js.getSession().setValue("");
		editor_css.getSession().setValue("");
		
		
		
		var doc = "";
		var iframeDoc = $("#preview").contents()[0];            
		iframeDoc.open();            
		iframeDoc.write(doc);            
		iframeDoc.close();  
		
	  }
	
	function save_data() {
		$.ajax({
			url: admin_ajax_url,
			type: "POST",
			data : {post_id:post_id,action:'hjc_code_save',hjc_code_html:editor_html.getSession().getValue(),hjc_code_js:editor_js.getSession().getValue(),hjc_code_css:editor_css.getSession().getValue(),randomx : Math.floor(Math.random()*1000)},
		}).done(function(response) {
			alert(response);
			
		});
    }
});