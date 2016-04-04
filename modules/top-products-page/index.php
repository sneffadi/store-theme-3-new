<?php

/*====================================
=            Content Hooks            =
====================================*/
if (!function_exists('underscore')) {
    function underscore($string) {
        $content = preg_replace('/\s+/', '_', $string);
        return strtolower($content);
    }
}

/*=============================================
=           Create Custom Fields              =
=============================================*/

function select_top_products() {
    add_meta_box('select_top_products', 'Create Top 10 List', 'select_top_products_cb', 'page', 'normal', 'high');
}
add_action('add_meta_boxes', 'select_top_products');
function select_top_products_cb($post) {
    $args = array('post_type' => array('products'), 'post_status' => array('published'), 'order' => 'ASC', 'orderby' => 'title');
    $myPosts = new WP_Query($args);
    $content = "<div id=\"products\">";
    $content.= "<h3>Drag and drop product.</h3>";
    $content.= "<div id=\"all-products\">";
    $content.= "<ul id=\"sortable\">";
    $i = 1;
    foreach ($myPosts->posts as $myPost) {
        $content.= "<li class=\"ui-state-default\" data-post-id=\"$myPost->ID\">";
        $content.= $myPost->post_title;
        $content.= "</li>";
        $i++;
    }
    wp_reset_postdata();
    $content.= "</ul>";
    $content.= "</div><!--/all-products-->";
    $content.= "</div><!--/products-->";
    
    $content.= "<div id=\"top-x-list\">";
    $content.= "<h3 class=\"ui-widget-header\">Top <span>X</span> List</h3>";
    $content.= "<div class=\"ui-widget-content\">";
    $content.= "<ol>";
    
    if (get_post_meta($post->ID, 'top-products-list', true) != '') {
        $ids = explode(",", get_post_meta($post->ID, 'top-products-list', true));
        foreach ($ids as $id) {
            $name = get_the_title($id);
            $edit = get_edit_post_link($id);
            $content.= "<li data-post-id=\"$id\">$name <span class=\"edit_review\"><a href=\"{$edit}\">Edit Product</a></span></li>";
        }
    } 
    else {
        $content.= "<li class=\"placeholder\">Add your items here</li>";
    }
    
    $content.= "</ol>";
    $content.= "</div><!--ui-widget-content-->";
    $content.= "</div><!--top-x-list-->";
    $content.= "<div class=\"cf\"></div>";
    $content.= "<input type=\"text\" name=\"top-products-list\" value=\"";
    $content.= get_post_meta($post->ID, 'top-products-list', true);
    $content.= "\" />";
    echo $content;
}
function custom_review_blurbs() {
    add_meta_box('custom_review_blurbs', 'Override Default Review Snippets', 'custom_descriptions_cb', 'page', 'normal', 'high');
}
add_action('add_meta_boxes', 'custom_review_blurbs');
function custom_descriptions_cb($post) {
    $content = "<div>";
    $topIds = explode(",", get_post_meta($post->ID, 'top-products-list', true));
    $cf = get_post_meta( $post->ID );
    $options = get_option('theme_options');
    $i = 1;
    foreach ($topIds as $topId) {
        $content.= "<p style=\"font-weight:bold;font-size:16px;clear:left;margin:0;\">" . $i . ". " . get_the_title($topId) . "</p>";
        $content.= "<p style=\"margin:0;font-style:italic;\">Custom product summary:</p>";
        $content.= "<textarea name=\"{$topId}_custom_content\">";
        $content.= get_post_meta($post->ID, "{$topId}_custom_content", true);
        $content.= "</textarea>";
        $content.= "<div class=\"customRatings\" style=\"margin-bottom:16px;\">";
        $content.= "<p style=\"margin:0;font-style:italic;\">Custom product ratings</p>";
        $content.= "<p style=\"float:left;width:200px;margin-top:0;\"><label for=\"{$topId}-ratings-overall-value\">Overall Value</label>&nbsp;<input type=\"number\" step=\"any\" name=\"{$topId}-ratings-overall-value\" value=\"".(isset($cf[$topId.'-ratings-overall-value']) ? $cf[$topId.'-ratings-overall-value'][0] : '')."\" style=\"width:45px;\" /> / ".(!empty($options['ratings']) ? $options['ratings'] : "5")."</p>";
        $content.= "<p style=\"float:left;width:200px;margin-top:0;\"><label for=\"{$topId}-ratings-effectiveness\">Effectiveness</label>&nbsp;<input type=\"number\" step=\"any\" name=\"{$topId}-ratings-effectiveness\" value=\"".(isset($cf[$topId.'-ratings-effectiveness']) ? $cf[$topId.'-ratings-effectiveness'][0] : '')."\" style=\"width:45px;\" /> / ".(!empty($options['ratings']) ? $options['ratings'] : "5")."</p>";
        $content.= "<p style=\"float:left;width:200px;margin-top:0;\"><label for=\"{$topId}-ratings-speed-of-results\">Speed of Results</label>&nbsp;<input type=\"number\" step=\"any\" name=\"{$topId}-ratings-speed-of-results\" value=\"".(isset($cf[$topId.'-ratings-speed-of-results']) ? $cf[$topId.'-ratings-speed-of-results'][0] : '')."\" style=\"width:45px;\" /> / ".(!empty($options['ratings']) ? $options['ratings'] : "5")."</p>";
        $content.= "<p style=\"float:left;width:200px;margin-top:0;\"><label for=\"{$topId}-ratings-product-safety\">Product Safety</label>&nbsp;<input type=\"number\" step=\"any\" name=\"{$topId}-ratings-product-safety\" value=\"".(isset($cf[$topId.'-ratings-product-safety']) ? $cf[$topId.'-ratings-product-safety'][0] : '')."\" style=\"width:45px;\" /> / ".(!empty($options['ratings']) ? $options['ratings'] : "5")."</p>";
        $content.= "<p style=\"float:left;width:200px;margin-top:0;\"><label for=\"{$topId}-ratings-ingredient-quality\">Ingredient</label>&nbsp;<input type=\"number\" step=\"any\" name=\"{$topId}-ratings-ingredient-quality\" value=\"".(isset($cf[$topId.'-ratings-ingredient-quality']) ? $cf[$topId.'-ratings-ingredient-quality'][0] : '')."\" style=\"width:45px;\" /> / ".(!empty($options['ratings']) ? $options['ratings'] : "5")."</p>";
        $content.= "<p style=\"float:left;width:200px;margin-top:0;\"><label for=\"{$topId}-ratings-long-term-results\">Long-Term Results</label>&nbsp;<input type=\"number\" step=\"any\" name=\"{$topId}-ratings-long-term-results\" value=\"".(isset($cf[$topId.'-ratings-long-term-results']) ? $cf[$topId.'-ratings-long-term-results'][0] : '')."\" style=\"width:45px;\" /> / ".(!empty($options['ratings']) ? $options['ratings'] : "5")."</p>";
        $content.= "<div style=\"clear:both;\"></div>";
        $content.= "</div><!-- end div.customRatings -->";
        $i++;
    }
    $content.= "<div style=\"clear:both;\"></div>";
    $content.= "</div>";
    echo $content;
}

function page_meta_save($post_id) {
    
    // Run of the mill checks
    global $typenow;
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['page_nonce']) && wp_verify_nonce($_POST['page_nonce'], basename(__FILE__))) ? 'true' : 'false';
    
    // Exits script depending on save status
    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }
    
    if ($typenow == 'page') {
        
        // Checks for input and sanitizes/saves if needed
        $cf_value = get_post_meta($post_id);
        
        if (isset($_POST['top-products-list'])) {
            update_post_meta($post_id, 'top-products-list', $_POST['top-products-list']);
        } 
        else {
            delete_post_meta($post_id, 'top-products-list', $_POST['top-products-list']);
        }
        $topIds = explode(",", get_post_meta($post_id, 'top-products-list', true));
        if (!empty($_POST["top-products-list"])) {
            foreach ($topIds as $topId) {
                if (isset($_POST[$topId . '_custom_content'])) {
                    update_post_meta($post_id, $topId.'_custom_content', $_POST[$topId.'_custom_content']);
                } else {
                    delete_post_meta($post_id, $topId.'_custom_content');
                }
                if (isset($_POST[$topId . '-ratings-overall-value'])) {
                    update_post_meta($post_id, $topId.'-ratings-overall-value', $_POST[$topId.'-ratings-overall-value']);
                } else {
                    delete_post_meta($post_id, $topId.'-ratings-overall-value');
                }
                if (isset($_POST[$topId . '-ratings-effectiveness'])) {
                    update_post_meta($post_id, $topId.'-ratings-effectiveness', $_POST[$topId.'-ratings-effectiveness']);
                } else {
                    delete_post_meta($post_id, $topId.'-ratings-effectiveness');
                }
                if (isset($_POST[$topId . '-ratings-speed-of-results'])) {
                    update_post_meta($post_id, $topId.'-ratings-speed-of-results', $_POST[$topId.'-ratings-speed-of-results']);
                } else {
                    delete_post_meta($post_id, $topId.'-ratings-speed-of-results');
                }
                if (isset($_POST[$topId . '-ratings-product-safety'])) {
                    update_post_meta($post_id, $topId.'-ratings-product-safety', $_POST[$topId.'-ratings-product-safety']);
                } else {
                    delete_post_meta($post_id, $topId.'-ratings-product-safety');
                }
                if (isset($_POST[$topId . '-ratings-ingredient-quality'])) {
                    update_post_meta($post_id, $topId.'-ratings-ingredient-quality', $_POST[$topId.'-ratings-ingredient-quality']);
                } else {
                    delete_post_meta($post_id, $topId.'-ratings-ingredient-quality');
                }
                if (isset($_POST[$topId . '-ratings-long-term-results'])) {
                    update_post_meta($post_id, $topId.'-ratings-long-term-results', $_POST[$topId.'-ratings-long-term-results']);
                } else {
                    delete_post_meta($post_id, $topId.'-ratings-long-term-results');
                }
            }
        }
    }
}
add_action('save_post', 'page_meta_save');

/*-----  End Custom Fields  ------*/

/*====================================
=            Load Scripts            =
====================================*/

//enqueue script for module and image loader
function page_enqueue() {
    global $typenow;
    if ($typenow == 'page') {
        wp_enqueue_media();
        wp_register_script('page-meta-box-image', get_template_directory_uri() . '/modules/top-products-page/' . 'script.js', array('jquery'));
        wp_localize_script('page-meta-box-image', 'meta_image', array('title' => __('Choose or Upload an Image', 'page-textdomain'), 'button' => __('Use this image', 'page-textdomain'),));
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-droppable');
        wp_enqueue_script('page-meta-box-image');
        wp_enqueue_style('page-integration', get_template_directory_uri() . '/modules/top-products-page/' . 'style.css', array(), '', 'all');
    }
}
add_action('admin_enqueue_scripts', 'page_enqueue');

/*-----  End Load Scrtipts  ------*/
