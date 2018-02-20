<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo hjc_CODE_URL; ?>assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="<?php echo hjc_CODE_URL; ?>assets/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url( __FILE__ ); ?>css/style.css">
</head>
<body>
<div class="top-spacer"></div>
<div class="container">
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
		<div class="col-md-12">
	<?php
	while (have_posts()) : the_post(); 
	?>
		<div>
			<a href="<?php the_permalink(); ?>" title=""><?php the_title(); ?></a>
		</div>
	<?php
	endwhile; 
	the_posts_pagination();
	?>
		</div>
	</div>
</div>
</body>