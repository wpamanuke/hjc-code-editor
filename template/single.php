<!DOCTYPE html>
<html>
<head>
<title><?php wp_title(''); ?></title>
<script>
	var admin_ajax_url = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
	var post_id = <?php global $post; echo $post->ID; ?>;
</script>
<link rel="stylesheet" type="text/css" href="<?php echo hjc_CODE_URL; ?>assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="<?php echo hjc_CODE_URL; ?>assets/css/font-awesome.min.css">
<script src="<?php echo plugin_dir_url( __FILE__ ); ?>js/ace/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo plugin_dir_url( __FILE__ ); ?>js/ace/src-noconflict/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo plugin_dir_url( __FILE__ ); ?>js/jquery.min.js"></script>
<script src="<?php echo plugin_dir_url( __FILE__ ); ?>js/editor.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url( __FILE__ ); ?>css/style.css">
</head>
<body>
<div class="top-spacer"></div>
<div class="container">
	
	
<?php
$prefix = "hjc_code_";
while (have_posts()) : the_post(); 
?>
<div class="row">
	<div class="col-md-6">
			<div class="site"><a href="<?php echo site_url('/hjc-code/'); ?>" title=""><i class="fa fa-home"></i> HOME</a></div>
	</div>
	<div class="col-md-6">
		<div>
			<form  class="pull-right" id="searchform" action="<?php echo site_url('/hjc-code/'); ?>" method="get">
					<input class="inlineSearch" type="text" name="s" value="Enter a keyword" onblur="if (this.value == '') {this.value = 'Enter a keyword';}" onfocus="if (this.value == 'Enter a keyword') {this.value = '';}" />
					<input type="hidden" name="post_type" value="hjc-code" />
					<input class="inlineSubmit" id="searchsubmit" type="submit" alt="Search" value="Search" />
			</form>
		</div>
		<div class="clear-fix"></div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<?php previous_post_link(); ?>
	</div>
	<div class="col-md-6">
		<?php next_post_link(); ?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div> <?php the_title('<h1>','</h1>'); ?> </div>
		<div class="clear-fix"></div>
		<div class="pull-left">
			<input id="btn-preview" type="button" value="Preview" />
			<?php  if (is_user_logged_in()) { ?>
			<input id="btn-save" type="button" value="Save" />
			<?php } ?>
			
			<input id="btn-clear-all" type="button" value="Clear All" />
			<input id="btn-preview-close" type="button" value="EXIT" />
		</div>
		<div class="pull-right">
			
			<?php the_terms( $post->ID, 'hjc-code-category', '<span>', "</span> , ", ' | ' ); ?>
			<?php  if (is_user_logged_in()) { ?>
			<span><a href="<?php echo site_url('/wp-admin/post-new.php?post_type=hjc-code'); ?>" title="">New Code</a></span> |
			<?php edit_post_link('edit', '<span>', '</span>'); ?>
			<?php } ?>
			
			
			
		</div>
		<div class="clear-fix"></div>
	</div>
</div>
<?php
	$html = get_post_meta( get_the_ID(), $prefix . 'html', true );
	$css = get_post_meta( get_the_ID(), $prefix . 'css', true );
	$js = get_post_meta( get_the_ID(), $prefix . 'js', true );
	echo '<div class="row">' . "\n";
	echo '<div class="col-md-6">
				<div class="js_html_container">
					<div class="div-btn">
						<div class="pull-right">
							<input id="btn-html" type="button" value="HTML" />
						</div>
						<div class="clear-fix"></div>
					</div>
					<div><textarea  name="js_html"  id="js_html">'. htmlspecialchars_decode( $html ) . '</textarea></div>
				</div>
		</div>' . "\n";
	echo '<div class="col-md-6">
				<div class="js_js_container">
					<div class="div-btn">
						<div class="pull-right">
							<input id="btn-js" type="button" value="JS" />
						</div>
						<div class="clear-fix"></div>
					</div>
					<div>
						<textarea name="js_js"  id="js_js">'. htmlspecialchars_decode( $js ) . '</textarea>
					</div>
				</div>
		</div>' . "\n";
	echo '</div>' . "\n";
	echo '<div class="row">' . "\n";
	echo '<div class="col-md-6">
				<div class="js_css_container">
					<div class="div-btn">
						<div class="pull-right">
							<input id="btn-css" type="button" value="CSS" />
						</div>
						<div class="clear-fix"></div>
					</div>
					<div><textarea name="js_css"  id="js_css">'. htmlspecialchars_decode( $css ) . '</textarea></div>
				</div>
		</div>' . "\n";
	echo '<div class="col-md-6">
				<iframe allow="midi; geolocation; microphone; camera" sandbox="allow-forms allow-scripts allow-same-origin allow-modals allow-popups" allowfullscreen allowpaymentrequest id="js_preview"></iframe>
		</div>' . "\n";
	echo '</div>' . "\n";

endwhile; 
?>
<div class="row">
	<div class="col-md-12">
		<div class="text-align-center">
			<p><a href="http://wpamanuke.com/hcj-code-editor-wp-plugin/" rel="nofollow">HJC Code Editor</a> by <a href="http://wpamanuke.com" rel="nofollow">wpamanuke</a> . Use in localhost only</p>
		</div>
	</div>
</div>
</div>
</body>