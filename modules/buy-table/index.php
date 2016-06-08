<?php
define("module_path", get_template_directory_uri() . "/modules/buy-table/");

/*=============================================
=           Create Custom Fields              =
=============================================*/

if (!function_exists('underscore')) {
    function underscore($string) {
        $content = preg_replace('/\s+/', '_', $string);
        return strtolower($content);
    }
}

function product_custom_meta() {
    add_meta_box('product_meta', __('Product Options'), 'product_meta_callback', 'products', 'normal', 'high');
}
add_action('add_meta_boxes', 'product_custom_meta');

function product_meta_callback($post) {
    wp_nonce_field(basename(__FILE__), 'product_nonce');
    $cf_value = get_post_meta($post->ID);
    echo '<section id="product_meta">';
    $i = 1;
    $html = '';
    $check = isset( $cf_value[ 'out-of-stock' ] ) ? esc_attr( $cf_value[ 'out-of-stock' ][0] ) : '';
    $html .= '<p>';
    $html .= '<label for="'.'out-of-stock' . '">Out of Stock</label>';
    $html .= '<input type="checkbox" name='.'"out-of-stock" '. checked( $check, 'yes', false ) .' /></p>';
    while (!empty($cf_value["title_c{$i}"][0]) && $cf_value["title_c{$i}"][0] != '' || $i == 1) {
        $html.= "<div data-column={$i}>";
        $html.= "<div><h4>Column " . $i . "</h4></div>";

        $html.= "<label>Column Title:</label><input type=\"text\" name=\"title_c{$i}\" value=\"" . (isset($cf_value["title_c{$i}"]) ? $cf_value["title_c{$i}"][0] : '') . "\" />";
        $html.= "<label>Column Sub Title:</label><input type=\"text\" name=\"sub_title_c{$i}\" value=\"" . (isset($cf_value["sub_title_c{$i}"]) ? $cf_value["sub_title_c{$i}"][0] : '') . "\" />";
        $html.= "<label>Retail:</label><input type=\"text\" name=\"retail_c{$i}\" value=\"" . (isset($cf_value["retail_c{$i}"]) ? $cf_value["retail_c{$i}"][0] : '') . "\" />";
        $html.= "<label>Price:</label><input type=\"text\" name=\"price_c{$i}\" value=\"" . (isset($cf_value["price_c{$i}"]) ? $cf_value["price_c{$i}"][0] : '') . "\" />";
        $html.= "<label>Quantity (include bottles, kits, etc):</label><input type=\"text\" name=\"qty_c{$i}\" value=\"" . (isset($cf_value["qty_c{$i}"]) ? $cf_value["qty_c{$i}"][0] : '') . "\" />";
        $html.= "<label>Bonus:</label><input type=\"text\" name=\"bonus_c{$i}\" value=\"" . (isset($cf_value["bonus_c{$i}"]) ? $cf_value["bonus_c{$i}"][0] : '') . "\" />";
        $html.= "<label>Shipping:</label><input type=\"text\" name=\"shipping_c{$i}\" value=\"" . (isset($cf_value["shipping_c{$i}"]) ? $cf_value["shipping_c{$i}"][0] : '') . "\" />";
        $html.= "<label>Item ID:</label><input type=\"text\" name=\"itemId_c{$i}\" value=\"" . (isset($cf_value["itemId_c{$i}"]) ? $cf_value["itemId_c{$i}"][0] : '') . "\" />";
        $html.= "<label>Product Image:</label><input type=\"text\" name=\"image_c{$i}\" value=\"" . (isset($cf_value["image_c{$i}"]) ? $cf_value["image_c{$i}"][0] : '') . "\" />";
        $html.= "</div><!--/data-column-->";
        $i++;
    }
    $html.= '<div class="add clear"><a href="#" class="addColumn">Add Column [+]</a></div>';
    $html.= '<input type="hidden" name="' . 'columnCount' . '" value="' . ($i - 1) . '" />';
    echo $html;
    echo '</section><!--/product_meta -->';
}

function product_meta_save($post_id) {

    // Run of the mill checks
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce = (isset($_POST['product_nonce']) && wp_verify_nonce($_POST['product_nonce'], basename(__FILE__))) ? 'true' : 'false';

    // Exits script depending on save status
    if ($is_autosave || $is_revision || !$is_valid_nonce) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    $cf_value = get_post_meta($post_id);
    $chk = isset( $_POST['out-of-stock' ] ) && $_POST['out-of-stock' ] ? 'yes' : 'no';
    update_post_meta( $post_id, 'out-of-stock', $chk );
    
    $i = 1;
    while (isset($_POST['title_c' . $i])) {
        if (isset($_POST['title_c' . $i])) {
            update_post_meta($post_id, 'title_c' . $i, sanitize_text_field($_POST['title_c' . $i]));
        }
        else {
            delete_post_meta($post_id, "title_c{$i}");
        }
        if (isset($_POST['sub_title_c' . $i])) {
            update_post_meta($post_id, 'sub_title_c' . $i, sanitize_text_field($_POST['sub_title_c' . $i]));
        }
        else {
            delete_post_meta($post_id, "sub_title_c{$i}");
        }
        if (isset($_POST['retail_c' . $i])) {
            update_post_meta($post_id, 'retail_c' . $i, sanitize_text_field($_POST['retail_c' . $i]));
        }
        else {
            delete_post_meta($post_id, "retail_c{$i}");
        }
        if (isset($_POST['price_c' . $i])) {
            update_post_meta($post_id, 'price_c' . $i, sanitize_text_field($_POST['price_c' . $i]));
        }
        else {
            delete_post_meta($post_id, "price_c{$i}");
        }

        if (isset($_POST['qty_c' . $i])) {
            update_post_meta($post_id, 'qty_c' . $i, sanitize_text_field($_POST['qty_c' . $i]));
        }
        else {
            delete_post_meta($post_id, "qty_c{$i}");
        }
        if (isset($_POST['bonus_c' . $i])) {
            update_post_meta($post_id, 'bonus_c' . $i, sanitize_text_field($_POST['bonus_c' . $i]));
        }
        else {
            delete_post_meta($post_id, "bonus_c{$i}");
        }
        if (isset($_POST['shipping_c' . $i])) {
            update_post_meta($post_id, 'shipping_c' . $i, sanitize_text_field($_POST['shipping_c' . $i]));
        }
        else {
            delete_post_meta($post_id, "shipping_c{$i}");
        }
        if (isset($_POST['itemId_c' . $i])) {
            update_post_meta($post_id, 'itemId_c' . $i, sanitize_text_field($_POST['itemId_c' . $i]));
        }
        else {
            delete_post_meta($post_id, "itemId_c{$i}");
        }
        if (isset($_POST['image_c' . $i])) {
            update_post_meta($post_id, 'image_c' . $i, sanitize_text_field($_POST['image_c' . $i]));
        }
        else {
            delete_post_meta($post_id, "shipping_c{$i}");
        }
        if (isset($_POST['columnCount'])) {
            update_post_meta($post_id, 'columnCount', sanitize_text_field($_POST['columnCount']));
        }
        else {
            update_post_meta($post_id, 'columnCount', 1);
        }
        $i++;
    }
}
add_action('save_post', 'product_meta_save');

/*-----  End Custom Fields  ------*/

/*====================================
=            Load Scripts            =
====================================*/

function product_custom_fields_styles() {
    wp_register_style('product-integration', module_path . 'style.css', array(), '', 'all');
    wp_enqueue_style('product-integration');
}
add_action('admin_enqueue_scripts', 'product_custom_fields_styles');

//enqueue script for module and image loader
function product_image_enqueue() {
    global $typenow;
    if ($typenow == 'products') {
        wp_enqueue_media();

        wp_register_script('meta-box-image', module_path . 'script.js', array('jquery'));
        wp_localize_script('meta-box-image', 'meta_image', array('title' => __('Choose or Upload an Image', 'product-textdomain'), 'button' => __('Use this image', 'product-textdomain'),));
        wp_enqueue_script('meta-box-image');
    }
}
add_action('admin_enqueue_scripts', 'product_image_enqueue');

/*-----  End of Load Scripts  ------*/

/*=============================================
=            Insert into post           =
=============================================*/
add_action('after_product_content', 'buy_table_cb');
function buy_table_cb() {
    if (is_singular('products')) {
        global $post;

        $cf_value = get_post_meta($post->ID);
        $showCustom= (isset($cf_value['cf_custom_banner']))&&($cf_value['cf_custom_banner'][0]==='yes');
        echo "<div class=\"row collapse buy-row-wrap\">";
        echo "<div id=\"buytable\" data-magellan-destination=\"buytable\"> <a name=\"buytable\"></a>";
		
        $count = 1;
        while (get_post_meta($post->ID, "title_c{$count}", true) != '') {
            $count++;
        }
        $count = $count-1 ;

        if ($count === 4) {
            echo "<div class=\"row collapse four-columns\">";
        } else {
            echo "<div class=\"row\">";
        }
		
        if($showCustom != 1){
	        echo "<h2>Don't Settle For Average, Get ".get_the_title()." Today!</h2>";
            echo "<img src=\"".do_shortcode('[upload_dir]')."buy-top.png\" class=\"buy-top-img\">";
        }


        $i = 1;
        while (get_post_meta($post->ID, "title_c{$i}", true) != '') {
            $quantity = get_post_meta($post->ID, "quantity_c{$i}", true);
            $price = get_post_meta($post->ID, "price_c{$i}", true);
            $retail = get_post_meta($post->ID, "retail_c{$i}", true);
            $quantity = array_map('floatval', explode(',', $quantity));
            $total_retail = 0;
            $percent_off = 0;
            $savings = $retail - $price;
            $percent_off = $savings / $retail;
            if ($count === 4) {
                echo "<div class='small-24 medium-6 columns hide-for-small-only'>";
            } elseif ($count === 2 && $i % 3 == 1) {
                echo "<div class='small-24 medium-8 medium-offset-4 columns noPadding hide-for-small-only'>";
            } else {
                echo "<div class='small-24 medium-8 columns hide-for-small-only'>";
            }
            echo "<form action=\"". do_shortcode('[cart_url]') . "\" " . "method=\"get\" id=\"buy{$i}\" class=\"buy-form\">";

            if ($i % 2 == 0) {
                $class = "even";
            }
            else {
                $class = "";
            }
            echo "<div class=\"title {$class}\">" . get_post_meta($post->ID, "title_c{$i}", true) . "</div>";
            echo "<div class=\"small-24 columns buy-wrap\">";
            echo "<div class='quantity'>";
            echo get_post_meta($post->ID, "sub_title_c{$i}", true);
            echo "</div>";
            echo "<div class='description'>" . get_post_meta($post->ID, "description" . "_" . $i, true) . "</div>";

            echo "<div class=\"buy-image\">";
            echo "<a href=\"" . do_shortcode('[cart_url]') . "?add=" . $cf_value["itemId_c{$i}"][0] . "\">";
            echo "<img src=\"" . do_shortcode('[upload_dir]') . get_post_meta($post->ID, "image_c{$i}", true) . "\"  />";
            echo "</a>";
            echo "</div>";

            echo "<div class=\"shipping\">";
            $shipping = strtolower(get_post_meta($post->ID, "shipping_c{$i}", true));
            if ($shipping==0 || $shipping=='free' || $shipping=='free shipping') echo "+Free Shipping!";
            elseif (is_numeric($shipping)) {
                echo "Shipping: $" . $shipping;
            }
            else echo "Shipping: $" . do_shortcode("[shipping_cost]");
            echo "<br />";
            $bonus = get_post_meta($post->ID, "bonus_c{$i}", true);
            if(($bonus!==FALSE)&&($bonus!=='')) echo "+" . $bonus;
            else echo '&nbsp;';
            echo "</div>";

            echo "<div class='retail'>Retail $" . "<span>" .number_format($retail, 2, '.', '') . "</span>" . "</div>";

            echo "<div class=\"price\">$" . "<span>" . $price . "</span>" . "</div>";
            if ($savings > 0) {
                echo "<div class=\"savings\">" . "<span>Save $</span><span>" . number_format($savings, 2, '.', '') . "</span>" . "<span>" . number_format($percent_off, 2, '.', '') * 100 . "</span><span>% Off</span></div>";
            }
            else {
                echo "<div class=\"savings no-savings\"></div>";
            }
            echo "<a href=\"" . do_shortcode('[cart_url]') . "?add=" . $cf_value["itemId_c{$i}"][0] . "\" class=\"button add-to-cart\" >" . "Add to Cart" . "</a>";


            echo "<div class=\"hiddenInputs\">";
            echo "</div><!--/hiddenInputs-->";

            echo "</form>";
            echo "</div><!--end column -->";
            echo "</div><!--end row -->";

            echo "<div class='row collapse buy-small show-for-small-only'>";
            echo "<div class='small-9 columns center bottle-images'>";
            echo "<a href=\"" . do_shortcode('[cart_url]') . "?add=" . $cf_value["itemId_c{$i}"][0] . "\">";
            echo "<img src=\"" . do_shortcode('[upload_dir]') . get_post_meta($post->ID, "image_c{$i}", true) . "\"  />";
            echo "</a>";
            echo "</div>";
            echo "<div class='small-15 columns product-info'>";
            echo "<div class=\"supply\">".get_post_meta($post->ID, "sub_title_c{$i}", true)."</div>";
            echo "<div class=\"price\">$" . "<span>" . $price . "</span>" . "</div>";

             echo "<div class='retail'>Retail $" . "<span>" .number_format($retail, 2, '.', '') . "</span>" . "</div>";

            if ($savings > 0) {
                echo "<div class=\"savings\">" . "<span>Save $</span><span>" . number_format($savings, 2, '.', '') . "</span>" . "<span>" . number_format($percent_off, 2, '.', '') * 100 . "</span><span>% Off</span></div>";
            }


            if (get_post_meta($post->ID, "bonus_c{$i}", true) !== ""){
            echo "<div class=\"bonus-item\">+".get_post_meta($post->ID, "bonus_c{$i}", true)."</div>";
            }
            if ($shipping=='free' || $shipping=='free shipping') {
            echo "<div class=\"shipping free\"> " . "+Free Shipping!" . "</div>";
            }
            elseif (is_numeric($shipping)) {
            echo "<div class=\"shipping\" > Shipping: $" . $shipping . "</div>";
            }
            else {
            echo "<div class=\"shipping\" > Shipping: $" . do_shortcode("[shipping_cost]") . "</div>";
            }
            echo "<a href=\"" . do_shortcode('[cart_url]') . "?add=" . $cf_value["itemId_c{$i}"][0] . "\" class=\"button add-to-cart\" >" . "Add to Cart" . "</a>";

            echo "</div>";
            echo "</div>";


            $i++;
        }
        echo "</div>";
        echo "<div class=\"payment\">";
        echo "<i class=\"fa fa-cc-visa\"></i>";
        echo "<i class=\"fa fa-cc-amex\"></i>";
        echo "<i class=\"fa fa-cc-mastercard\"></i>";
        echo "<i class=\"fa fa-cc-discover\"></i>";
        echo "<i class=\"fa fa-cc-paypal\"></i>";
        echo "<script src=\"https://cdn.ywxi.net/js/inline.js?w=70\"></script>";
        echo "</div><!--/.payment-->";
        echo "</div><!--/#buytable-->";
        echo "</div><!--/.row-->";
    }
}

/*-----  End of Section comment block  ------*/
