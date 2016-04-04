<?php
class custom_hero_html {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
		add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );

	}

	public function add_metabox() {

		add_meta_box(
			'custom_hero_html',
			'Custom Hero HTML',
			array( $this, 'render_metabox' ),
			'page',
			'advanced',
			'high'
		);

	}

	public function render_metabox( $post ) {


		// Retrieve an existing value from the database.
		$custom_hero_html_custom_hero_html = get_post_meta( $post->ID, 'custom_hero_html_custom_hero_html', true );

		// Set default values.
		if( empty( $custom_hero_html_custom_hero_html ) ) $custom_hero_html_custom_hero_html = '';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<td>';
		echo '			<textarea id="custom_hero_html_custom_hero_html" name="custom_hero_html_custom_hero_html" class="custom_hero_html_custom_hero_html_field" placeholder="' . 'Enter custom HTML' . '">' . $custom_hero_html_custom_hero_html . '</textarea>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {


		$is_autosave = wp_is_post_autosave($post_id);
	    $is_revision = wp_is_post_revision($post_id);
	    $is_valid_nonce = (isset($_POST['hero_nonce']) && wp_verify_nonce($_POST['hero_nonce'], basename(__FILE__))) ? 'true' : 'false';

	    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        	return;
    	}


		// Sanitize user input.
		$custom_hero_html_new_custom_hero_html = isset( $_POST[ 'custom_hero_html_custom_hero_html' ] ) ? $_POST[ 'custom_hero_html_custom_hero_html' ] : '';

		// Update the meta field in the database.
		update_post_meta( $post_id, 'custom_hero_html_custom_hero_html', $custom_hero_html_new_custom_hero_html );

	}

}

new custom_hero_html;

/*=====================================
=            Intro Content            =
=====================================*/
function intro_content_cb() {
    global $post;
    if (is_page()) {
?>
    <div id="hero">
        <?php echo do_shortcode( get_post_meta($post->ID, 'custom_hero_html_custom_hero_html', true) ); ?>                            
    </div> <!-- /#hero  -->
<?php
	}
}
add_action('page_before_entry_content', 'intro_content_cb');