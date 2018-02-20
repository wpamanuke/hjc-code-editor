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
	<div class="row">
		<div class="col-md-12">
			<h3>Category</h3>
			<?php $wcatTerms = get_terms('hjc-code-category', array('hide_empty' => 1, 'parent' =>0)); 
		   foreach($wcatTerms as $wcatTerm) : 
			   ?>
			<ul>
			   <li>
				  <a href="<?php echo get_term_link( $wcatTerm->slug, $wcatTerm->taxonomy ); ?>"><?php echo $wcatTerm->name; ?></a>
				  <ul class="megaSubCat">
					 <?php
						$wsubargs = array(
						   'hierarchical' => 1,
						   'show_option_none' => '',
						   'hide_empty' => 0,
						   'parent' => $wcatTerm->term_id,
						   'taxonomy' => 'hjc-code-category'
						);
						$wsubcats = get_categories($wsubargs);
						foreach ($wsubcats as $wsc):
						?>
							 <li><a href="<?php echo get_term_link( $wsc->slug, $wsc->taxonomy );?>"><?php echo $wsc->name;?></a></li>
							 <?php
						endforeach;
						?>  
				  </ul>
			   </li>
			</ul>
			<?php 
		   endforeach; 
		   ?>
		</div>		
	</div>
</div>
</body>