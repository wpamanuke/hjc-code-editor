<?php
/**
 * function to return a custom field value.
 */
function hjc_code_get_custom_field( $value ) {
	global $post;

    $custom_field = get_post_meta( $post->ID, $value, true );
    if ( !empty( $custom_field ) )
	    return is_array( $custom_field ) ? stripslashes_deep( $custom_field ) : stripslashes( wp_kses_decode_entities( $custom_field ) );

    return false;
}


/**
 * Register the Meta box
 */
function hjc_code_add_custom_meta_box() {
	//add_meta_box( 'wpshed-meta-box', __( 'Metabox Example', 'wpshed' ), 'hjc_code_meta_box_output', 'post', 'normal', 'high' );
	add_meta_box( 'wpshed-meta-box', __( 'JS hjc', 'wpshed' ), 'hjc_code_meta_box_output', 'hjc-code', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'hjc_code_add_custom_meta_box' );


/**
 * Output the Meta box
 */
function hjc_code_meta_box_output( $post ) {
	// create a nonce field
	wp_nonce_field( 'my_hjc_code_meta_box_nonce', 'hjc_code_meta_box_nonce' ); ?>
	<p>
		<label for="hjc_code_html"><?php _e( 'HTML', 'wpshed' ); ?>:</label><br />
		<textarea name="hjc_code_html_temp" id="js_html_temp" cols="100%" rows="20"><?php echo hjc_code_get_custom_field( 'hjc_code_html' ); ?></textarea>
		<textarea style="display:none" name="hjc_code_html" id="js_html" cols="100%" rows="20"><?php echo hjc_code_get_custom_field( 'hjc_code_html' ); ?></textarea>
    </p>
    <p>
		<label for="hjc_code_js"><?php _e( 'Javascript', 'wpshed' ); ?>:</label><br />
		<textarea name="hjc_code_js_temp" id="js_js_temp" cols="100%" rows="20"><?php echo hjc_code_get_custom_field( 'hjc_code_js' ); ?></textarea>
		<textarea style="display:none" name="hjc_code_js" id="js_js" cols="100%" rows="20"><?php echo hjc_code_get_custom_field( 'hjc_code_js' ); ?></textarea>
    </p>
	<p>
		<label for="hjc_code_css"><?php _e( 'CSS', 'wpshed' ); ?>:</label><br />
		<textarea name="hjc_code_css_temp" id="js_css_temp" cols="100%" rows="20"><?php echo hjc_code_get_custom_field( 'hjc_code_css' ); ?></textarea>
		<textarea style="display:none" name="hjc_code_css" id="js_css" cols="100%" rows="20"><?php echo hjc_code_get_custom_field( 'hjc_code_css' ); ?></textarea>
    </p>
	<?php
}


/**
 * Save the Meta box values
 */
function hjc_code_meta_box_save( $post_id ) {
	// Stop the script when doing autosave
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// Verify the nonce. If insn't there, stop the script
	if( !isset( $_POST['hjc_code_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['hjc_code_meta_box_nonce'], 'my_hjc_code_meta_box_nonce' ) ) return;

	// Stop the script if the user does not have edit permissions
	if( !current_user_can( 'edit_post', get_the_id() ) ) return;

    // Save the textarea
	if( isset( $_POST['hjc_code_html'] ) )
		update_post_meta( $post_id, 'hjc_code_html', esc_html( $_POST['hjc_code_html'] ) );
	if( isset( $_POST['hjc_code_js'] ) )
		update_post_meta( $post_id, 'hjc_code_js', esc_html( $_POST['hjc_code_js'] ) );
	if( isset( $_POST['hjc_code_css'] ) )
		update_post_meta( $post_id, 'hjc_code_css', esc_html( $_POST['hjc_code_css'] ) );
	
}
add_action( 'save_post', 'hjc_code_meta_box_save' );


function hjcadmin_script_and_style(){
	global $post;
	if( !in_array($post->post_type, array('hjc-code') ) )
		return;
	// add javascript
	wp_enqueue_script( 'codemirror',  hjc_CODE_URL . 'template/js/ace/src-noconflict/ace.js' , array( 'jquery' ) );
	wp_enqueue_script( 'codemirror2',  hjc_CODE_URL . 'template/js/ace/src-noconflict/ext-language_tools.js' , array( 'jquery' ) );
	
	wp_enqueue_script( 'codemirror-script-js',hjc_CODE_URL . 'assets/js/editor.js' , array( 'codemirror2' ) );
	// add just the styles
	wp_enqueue_style( 'codemirror-style',  hjc_CODE_URL . 'template/css/style.css');
}
add_action( 'admin_print_styles-post-new.php', 'hjcadmin_script_and_style' );
add_action( 'admin_print_styles-post.php','hjcadmin_script_and_style' );

// Place the metabox in the post edit page below the editor before other metaboxes (like the Excerpt)
// add_meta_box( 'wpshed-meta-box', __( 'Metabox Example', 'wpshed' ), 'hjc_code_meta_box_output', 'post', 'normal', 'high' );
// Place the metabox in the post edit page below the editor at the end of other metaboxes
// add_meta_box( 'wpshed-meta-box', __( 'Metabox Example', 'wpshed' ), 'hjc_code_meta_box_output', 'post', 'normal', '' );
// Place the metabox in the post edit page in the right column before other metaboxes (like the Publish)
// add_meta_box( 'wpshed-meta-box', __( 'Metabox Example', 'wpshed' ), 'hjc_code_meta_box_output', 'post', 'side', 'high' );
// Place the metabox in the post edit page in the right column at the end of other metaboxes
// add_meta_box( 'wpshed-meta-box', __( 'Metabox Example', 'wpshed' ), 'hjc_code_meta_box_output', 'post', 'side', '' );


function hjc_code_save_ajax() {
	// Stop the script if the user does not have edit permissions
	if(!function_exists('current_user_can') || !current_user_can('install_plugins')){
		echo 'You have no access. Please login first';
		return;
	} 
	
	$post_id = $_POST['post_id'];
    // Save the textarea
	if( isset( $_POST['hjc_code_html'] ) ) {
		update_post_meta( $post_id, 'hjc_code_html', esc_html( $_POST['hjc_code_html'] ) );
	}
	
	if( isset( $_POST['hjc_code_js'] ) ) {
		update_post_meta( $post_id, 'hjc_code_js', esc_html( $_POST['hjc_code_js'] ) );
	}
	if( isset( $_POST['hjc_code_css'] ) ) {
		update_post_meta( $post_id, 'hjc_code_css', esc_html( $_POST['hjc_code_css'] ) );
	}
	

	echo 'Success Save';
	die();
}
add_action('wp_ajax_hjc_code_save', 'hjc_code_save_ajax');
add_action('wp_ajax_nopriv_hjc_code_save', 'hjc_code_save_ajax');

