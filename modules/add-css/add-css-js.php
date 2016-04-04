<?php
/*
Plugin Name: Add CSS-JS By Post
Plugin URI: 
Description: 
Version: 
Author: 
Author URI: 
License: 
*/

add_action( 'add_meta_boxes', 'cd_meta_box_add' );
function cd_meta_box_add($postType){
	$types = get_post_types( null, 'names' ); //adds to all post types
	if(in_array($postType, $types)){
		add_meta_box('my-meta-box-id','Add CSS/JS To This Product/Post Only','cd_meta_box_cb',$postType,'advanced','high');
	}
}

function cd_meta_box_cb( $post )
{
	$values = get_post_custom( $post->ID );
	$text = isset( $values['my_meta_box_text'] ) ? esc_attr( $values['my_meta_box_text'][0] ) : '';
	$text2 = isset( $values['my_meta_box_text2'] ) ? esc_attr( $values['my_meta_box_text2'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>
	<p>
		<label for="my_meta_box_text" style="display: block;">Hook CSS into header:</label>
		<textarea name="my_meta_box_text" id="my_meta_box_text" style="width: 100%; min-height: 100px; background: #333; color: #fff;" placeholder="Example: body{color:#000;}"><?php echo $text; ?></textarea>
	</p>
	<p>
		<label for="my_meta_box_text2" style="display: block;">Hook JS into footer:</label>
		<textarea name="my_meta_box_text2" id="my_meta_box_text2" placeholder="Example: $('body').css('color','#000');" style="width: 100%; min-height: 100px; background: #666; color: #fff;"><?php echo $text2; ?></textarea>
	</p>
	<?php	
}


add_action( 'save_post', 'cd_meta_box_save' );
function cd_meta_box_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_posts' ) ) return;
	
	// now we can actually save the data
	$allowed = array( 
		'a' => array( // on allow a tags
			'href' => array() // and those anchords can only have href attribute
		)
	);
	
	// Probably a good idea to make sure your data is set
	if( isset( $_POST['my_meta_box_text'] ) )
		update_post_meta( $post_id, 'my_meta_box_text', wp_kses( $_POST['my_meta_box_text'], $allowed ) );
		update_post_meta( $post_id, 'my_meta_box_text2', wp_kses( $_POST['my_meta_box_text2'], $allowed ) );
}

function css_strip_whitespace($css)
{
  $replace = array(
    "#/\*.*?\*/#s" => "",  // Strip C style comments.
    "#\s\s+#"      => " ", // Strip excess whitespace.
  );
  $search = array_keys($replace);
  $css = preg_replace($search, $replace, $css);
  $replace = array(
    ": "  => ":",
    "; "  => ";",
    " {"  => "{",
    " }"  => "}",
    ", "  => ",",
    "{ "  => "{",
    ";}"  => "}", // Strip optional semicolons.
    ",\n" => ",", // Don't wrap multiple selectors.
    "\n}" => "}", // Don't wrap closing braces.
    "} "  => "}\n", // Put each rule on it's own line.
  );
  $search = array_keys($replace);
  $css = str_replace($search, $replace, $css);
  return trim($css);
}


//make sure wp_head(); is the last bit of code before </head>
function hook_into_head() {
	global $post;
	if($post){
		
		$css = apply_filters('the_content', get_post_meta($post->ID,'my_meta_box_text',true)); // apply_fulets allows shortcode use within custom field
		$css = html_entity_decode($css);
		$css = css_strip_whitespace($css);
		if($css!=''){
			echo '<style>';
			echo $css;
			echo '</style>';
		}
	}
}
add_action('wp_head','hook_into_head');
function hook_into_footer() {
	global $post;
	if($post){
		$js = get_post_meta($post->ID, 'my_meta_box_text2', true);
		if($js!=''){
			echo '<script>' . '(function($) {' . html_entity_decode($js) . '})(jQuery);' . '</script>';
		}
	}
}
add_action('wp_footer','hook_into_footer',999999);	