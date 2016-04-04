<?php

/*=============================================
=            Add metabox            =
=============================================*/

function reference_custom_meta() {
    add_meta_box('reference_meta', 'References', 'reference_meta_callback', 'reviews');
}
add_action('add_meta_boxes', 'reference_custom_meta');

/*=============================================
=            Create inputs                   =
=============================================*/

function reference_meta_callback($post) {
    global $typenow;
    if ($typenow == 'reviews') {
        wp_nonce_field(basename(__FILE__), 'reference_nonce');
        $cf = get_post_meta($post->ID);
        $product_stored_meta = get_post_meta($post->ID);
        $i = 1;
        $content = '<div id="reference_meta">';
        echo $content;
        
        $content = '';
        while (((get_post_meta($post->ID, 'reference-' . $i, true)) != '') || $i == 1) {
            $content = '<div class="section reference">';
            $content.= '<p>';
            $content.= '<label>Reference #' . $i . '</label>';
            $content.= '<input type="text"' . 'name="reference-' . $i . '"' . 'value="';
            $content.= (isset($product_stored_meta['reference-' . $i]) ? $product_stored_meta['reference-' . $i][0] : '') . '"';
            $content.= '/></p>';
            $content.= '<p><a href="#" class="remove-reference-' . $i . '">Remove Reference</a></p>';
            $content.= '</div><!-- end .section -->';
            $i++;
            echo $content;
        }
        echo '<div class="section"><p><a href="#" class="add-reference">Add Reference </a></div>';
        echo '<input type="hidden" name="ref-counter" class="counter" value="' . ($i - 1) . '" />';
        
        echo '</div><!--/reference-meta-->';
    }
}

/*=============================================
=            Save data           =
=============================================*/
function references_meta_save($post_id) {
    global $typenow;
    if ($typenow == 'reviews') {
        
        // Checks save status
        $is_autosave = wp_is_post_autosave($post_id);
        $is_revision = wp_is_post_revision($post_id);
        $is_valid_nonce = (isset($_POST['reference_nonce']) && wp_verify_nonce($_POST['reference_nonce'], basename(__FILE__))) ? 'true' : 'false';
        
        // Exits script depending on save status
        if ($is_autosave || $is_revision || !$is_valid_nonce) {
            return;
        }
        
        // Checks for input and sanitizes/saves if needed
        $i = 1;
        if (isset($_POST['reference-1'])){            
            while (isset($_POST["reference-" . $i])) {
                if (isset($_POST['reference-' . $i])) {
                    update_post_meta($post_id, 'reference-' . $i, $_POST['reference-' . $i]);
                }
                $i++;
            }
        }
        while ($i <= intval($_POST['ref-counter'])) {
            delete_post_meta($post_id, 'reference-' . $i);
            $i++;
        }
    }
}
add_action('save_post', 'references_meta_save');

/*=============================================
=            Add stylesheet            =
=============================================*/

function references_admin_styles() {
    global $typenow;
    if ($typenow == 'reviews') {
        wp_enqueue_style('references_meta_box_styles', MODULE_PATH . 'references/' . 'style.css');
    }
}
add_action('admin_print_styles', 'references_admin_styles');

/*=============================================
=            Add script            =
=============================================*/

//Load scripts and styles
function references_script_enqueue() {
    global $typenow;
    if ($typenow == 'reviews') {
        wp_enqueue_media();
        
        wp_register_script('references-script', MODULE_PATH . 'references/' . 'script.js', array('jquery'));
        wp_enqueue_script('references-script');
    }
}
add_action('admin_enqueue_scripts', 'references_script_enqueue');

/*=============================================
=             Shortcode           =
=============================================*/

add_action('after_review_content', 'add_references_cb', 2);
function add_references_cb() {
    global $post;
    $post_type = get_post_type();
    $j = 1;
    if (get_post_meta($post->ID, 'reference-' . $j, true) != '' && $post_type === "reviews" ) {
        echo "<div id=\"references\">";
        echo "<h5>References</h5>";
        echo "<ol>";
        while (get_post_meta($post->ID, 'reference-' . $j, true) != '') {
            echo '<li id="ref'.$j.'">' . get_post_meta($post->ID, 'reference-' . $j, true) . '</li>';
            $j++;
        }
        echo '</ol>';
        echo "</div><!--/references-->";
    }

}
