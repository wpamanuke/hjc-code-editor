<?php
if ( !defined( 'ABSPATH' ) ) exit;
if ( !class_exists( 'HCJ_Code_Editor' ) ) :
/**
 * Main AmaUCP Class
 *
 */
class HCJ_Code_Editor {
	public static function instance() {
	// Store the instance locally to avoid private static replication
		static $instance = null;
		// Only run these methods if they haven't been ran previously
		if ( null === $instance ) {
			$instance = new HCJ_Code_Editor;
			$instance->add_actions();
		}

		// Always return the instance
		return $instance;
	}
	
	public function add_actions() {
		add_action( 'init', array( $this , 'create_taxonomy' ) );
		add_action( 'init', array( $this , 'create_posttype' ) );
	}
	
	
	
	public function create_taxonomy() {
		register_taxonomy(
			'hjc-code-category',
			'hjc-code',
			array(
				'label' => __( 'Category' ),
				'rewrite' => array( 'slug' => 'hjc-code-category' ),
				'hierarchical' => true
			)
		);
	}
	// Our custom post type function
	public function create_posttype() {
	 
		 register_post_type( 'hjc-code',
		// CPT Options
			array(
				'labels' => array(
					'name'                => __('Code' , 'Post Type General Name', 'amaucp-admin' ),
					'singular_name'       => __('Code' , 'Post Type Singular Name', 'amaucp-admin' ),
					'menu_name'           => __( 'HJC Code' , 'amaucp-admin' ),
					'parent_item_colon'   => __( 'Parent Code' , 'amaucp-admin' ),
					'all_items'           => __( 'All Codes' , 'amaucp-admin' ),
					'view_item'           => __( 'View Code' , 'amaucp-admin' ),
					'add_new_item'        => __( 'Add New Code' , 'amaucp-admin' ),
					'add_new'             => __( 'Add New Code' , 'amaucp-admin' ),
					'edit_item'           => __( 'Edit Code' , 'amaucp-admin' ),
					'update_item'         => __( 'Update Code' , 'amaucp-admin' ),
					'search_items'        => __( 'Search Code' , 'amaucp-admin' ),
					'not_found'           => __( 'Not Found' , 'amaucp-admin' ),
					'not_found_in_trash'  => __( 'Not found in Trash' , 'amaucp-admin' ),
				),
				'supports' => array('title'),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => true,
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'taxonomies'          => array( 'hjc-code-category' ),
				
			)
		);
	}
	
}
endif;



// Create Subscribe Post Type
function hjc_code() {
	$res =  HCJ_Code_Editor::instance();	
	return $res;
}
add_action( 'plugins_loaded', 'hjc_code' );




function hjc_code_single_template($single) {
    global $post;
	
    /* Checks for single template by post type */
    if ( $post->post_type == 'hjc-code' ) {
        if ( file_exists( dirname( __FILE__ )  . '/template/single.php' ) ) {
            return dirname( __FILE__ ) . '/template/single.php';
        }
    }
    return $single;
}
add_filter('single_template', 'hjc_code_single_template');


function _hjc_code_archive_template($archive_template) {
    global $post;
	
 
    if ( $post->post_type == 'hjc-code' ) {
        if ( file_exists( dirname( __FILE__ )  . '/template/archive.php' ) ) {
            return dirname( __FILE__ ) . '/template/archive.php';
        }
    }
    return $archive_template;
}
add_filter('archive_template', '_hjc_code_archive_template');


function _hjc_code_category_template($category_template) {
    global $post;
	
    if ( is_tax('hjc-code-category' ) ) {
		
        if ( file_exists( dirname( __FILE__ )  . '/template/category.php' ) ) {
            return dirname( __FILE__ ) . '/template/category.php';
        }
    }
    return $category_template;
}
add_filter('template_include', '_hjc_code_category_template');


/// ADMIN TABLE

/**
 * Display a custom taxonomy dropdown in admin
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_action('restrict_manage_posts', 'hjc_code_filter_post_type_by_taxonomy');
function hjc_code_filter_post_type_by_taxonomy() {
	global $typenow;
	$post_type = 'hjc-code'; // change to your post type
	$taxonomy  = 'hjc-code-category'; // change to your taxonomy
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
			'show_option_all' => __("Show All {$info_taxonomy->label}"),
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => true,
			'hide_empty'      => true,
		));
	};
}
/**
 * Filter posts by taxonomy in admin
 * @author  Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_filter('parse_query', 'hjc_code_convert_id_to_term_in_query');
function hjc_code_convert_id_to_term_in_query($query) {
	global $pagenow;
	$post_type = 'hjc-code'; // change to your post type
	$taxonomy  = 'hjc-code-category'; // change to your taxonomy
	$q_vars    = &$query->query_vars;
	if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

add_filter( 'manage_edit-hjc-code_columns', 'hjc_code_columns' );
function hjc_code_columns( $columns ) {
	unset($columns['date']);
    $columns['hjc-code-category'] = 'Category';
	$columns['date'] = 'Date';
    return $columns;
}


add_action( 'manage_posts_custom_column' , 'hjc_code_custom_columns', 10, 2 );

function hjc_code_custom_columns( $column, $post_id ) {

	switch ( $column ) {
		case 'hjc-code-category':
			
			$terms = get_the_term_list( $post_id, 'hjc-code-category', '', ',', '' );
			if ( is_string( $terms ) ) {
				echo $terms;
			} else {
				_e( 'Unknow Category', 'your_text_domain' );
			}
			
			break;
	}
}

add_filter( 'manage_edit-hjc-code_sortable_columns', 'hjc_code_sort_me' );
function hjc_code_sort_me( $columns ) {
    $columns['hjc-code-category'] = 'hjc-code-category';
   
 
    return $columns;
}


?>