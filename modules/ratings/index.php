<?php

/*=============================================
=            Add metabox            =
=============================================*/

function rating_custom_meta() {

    add_meta_box( 'rating_meta', 'Product Ratings', 'rating_meta_callback', 'products', 'advanced', 'high' );

}
add_action( 'add_meta_boxes', 'rating_custom_meta' );


/*=============================================
=            Create inputs          		 =
=============================================*/

function rating_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'rating_nonce' );
    $cf = get_post_meta( $post->ID );
    $options = get_option('theme_options');
    ?>
    <div id="ratings">
        <p>
            <label for="ratings-overall-value">Overall Rating</label>
            <input type="number" step="any" name="ratings-overall-value" value="<?php if ( isset ( $cf['ratings-overall-value'] ) ) echo $cf['ratings-overall-value'][0]; ?>" /> / <?php echo !empty($options['ratings']) ? $options['ratings'] : "100"; ?>
        </p>
        <p>
            <label for="ratings-ingredient-quality">Ingredient Quality</label>
            <input type="number" step="any" name="ratings-ingredient-quality" value="<?php if ( isset ( $cf['ratings-ingredient-quality'] ) ) echo $cf['ratings-ingredient-quality'][0]; ?>" /> / <?php echo !empty($options['ratings']) ? $options['ratings'] : "100"; ?>
        </p>
        <p>
            <label for="ratings-effectiveness">Enlargement Power</label>
            <input type="number" step="any" name="ratings-effectiveness" value="<?php if ( isset ( $cf['ratings-effectiveness'] ) ) echo $cf['ratings-effectiveness'][0]; ?>" /> / <?php echo !empty($options['ratings']) ? $options['ratings'] : "100"; ?>
        </p>
        <p>
            <label for="ratings-long-term-results">Long-Term Results</label>
            <input type="number" step="any" name="ratings-long-term-results" value="<?php if ( isset ( $cf['ratings-long-term-results'] ) ) echo $cf['ratings-long-term-results'][0]; ?>" /> / <?php echo !empty($options['ratings']) ? $options['ratings'] : "100"; ?>
        </p>
        <p>
            <label for="ratings-customer-reviews">Customer Reviews</label>
            <input type="number" step="any" name="ratings-customer-reviews" value="<?php if ( isset ( $cf['ratings-customer-reviews'] ) ) echo $cf['ratings-customer-reviews'][0]; ?>" /> / <?php echo !empty($options['ratings']) ? $options['ratings'] : "100"; ?>
        </p>
        <p>
            <label for="ratings-product-safety">Product Safety</label>
            <input type="number" step="any" name="ratings-product-safety" value="<?php if ( isset ( $cf['ratings-product-safety'] ) ) echo $cf['ratings-product-safety'][0]; ?>" /> / <?php echo !empty($options['ratings']) ? $options['ratings'] : "100"; ?>
        </p>
        

        
        <p>
            <label for="ratings-guarantee">Guarantee</label>
            <input type="text" name="ratings-guarantee" value="<?php if ( isset ( $cf['ratings-guarantee'] ) ) echo $cf['ratings-guarantee'][0]; ?>" />
        </p>
        <p>
            <label for="ratings-official-site">Official Site (domain.com)</label>
            <input type="text" name="ratings-official-site" value="<?php if ( isset ( $cf['ratings-official-site'] ) ) echo $cf['ratings-official-site'][0]; ?>" />
        </p>
        <p>
            <label for="review-subhead">Subhead</label>
            <input type="text" name="review-subhead" value="<?php if ( isset ( $cf['review-subhead'] ) ) echo $cf['review-subhead'][0]; ?>" />
        </p>
        <p>
            <label for="review-blurb">Blurb - Wrap links in [a][/a]</label>
            <textarea type="text" name="review-blurb"><?php if ( isset ( $cf['review-blurb'] ) ) echo $cf['review-blurb'][0]; ?></textarea>
        </p>


    </div><!--/#ratings-->
    <?php
}

/*=============================================
=            Save data           =
=============================================*/

function rating_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'rating_nonce' ] ) && wp_verify_nonce( $_POST[ 'rating_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'ratings-overall-value' ] ) ) {
        update_post_meta( $post_id, 'ratings-overall-value', sanitize_text_field( $_POST[ 'ratings-overall-value' ] ) );
    }
    if( isset( $_POST[ 'ratings-effectiveness' ] ) ) {
        update_post_meta( $post_id, 'ratings-effectiveness', sanitize_text_field( $_POST[ 'ratings-effectiveness' ] ) );
    }
    if( isset( $_POST[ 'ratings-customer-reviews' ] ) ) {
        update_post_meta( $post_id, 'ratings-customer-reviews', sanitize_text_field( $_POST[ 'ratings-customer-reviews' ] ) );
    }
    if( isset( $_POST[ 'ratings-product-safety' ] ) ) {
        update_post_meta( $post_id, 'ratings-product-safety', sanitize_text_field( $_POST[ 'ratings-product-safety' ] ) );
    }
    if( isset( $_POST[ 'ratings-ingredient-quality' ] ) ) {
        update_post_meta( $post_id, 'ratings-ingredient-quality', sanitize_text_field( $_POST[ 'ratings-ingredient-quality' ] ) );
    }
    if( isset( $_POST[ 'ratings-long-term-results' ] ) ) {
        update_post_meta( $post_id, 'ratings-long-term-results', sanitize_text_field( $_POST[ 'ratings-long-term-results' ] ) );
    }
    if( isset( $_POST[ 'ratings-official-site' ] ) ) {
        update_post_meta( $post_id, 'ratings-official-site', sanitize_text_field( $_POST[ 'ratings-official-site' ] ) );
    }
    if( isset( $_POST[ 'ratings-guarantee' ] ) ) {
        update_post_meta( $post_id, 'ratings-guarantee', sanitize_text_field( $_POST[ 'ratings-guarantee' ] ) );
    }
    if( isset( $_POST[ 'review-subhead' ] ) ) {
        update_post_meta( $post_id, 'review-subhead', esc_attr( $_POST[ 'review-subhead' ] ) );
    }
    if( isset( $_POST[ 'review-blurb' ] ) ) {
        update_post_meta( $post_id, 'review-blurb', $_POST[ 'review-blurb' ] );
    }

}
add_action( 'save_post', 'rating_meta_save' );

/*=============================================
=            Add stylesheet            =
=============================================*/

function rating_admin_styles(){
    global $typenow;
    if( $typenow == 'products' ) {
        wp_enqueue_style( 'rating_meta_box_styles',  MODULE_PATH . 'ratings/' . 'style.css' );
    }
}
add_action( 'admin_print_styles', 'rating_admin_styles' );

/*=============================================
=            Add script            =
=============================================*/
function rating_image_enqueue() {
    global $typenow;
    if( $typenow == 'products' ) {
        wp_enqueue_media();

        // Registers and enqueues the required javascript.
        wp_register_script( 'ratings-script', MODULE_PATH . 'ratings/' . 'script.js', array( 'jquery' ) );
        wp_enqueue_script( 'ratings-script' );
    }
}
add_action( 'admin_enqueue_scripts', 'rating_image_enqueue' );

