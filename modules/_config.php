<?php
define('MODULE_PATH', get_template_directory_uri() . '/modules/');

require_once ('products-post-type.php');
require_once ('archive-menu-support.php');
require_once ('top-products-page/index.php');
require_once ('ratings/index.php');
require_once ('references/index.php');
require_once ('custom_fields.php');
require_once ('contact/index.php');
require_once ('buy-table/index.php');
require_once ('add-css/add-css-js.php');
require_once ('banner/index.php');
require_once ('hero.php');

//require_once( 'custom_fields.php' );



/** Shortcodes */
require_once ('shortcodes.php');
require_once ('hooks.php');
require_once ('upsells.php');

// Theme options
require_once ('theme_options.php');

$themeOptions = get_option('theme_options');
if (!empty($themeOptions['gaID'])) {
    require_once ('google_analytics.php');
}
if (!empty($themeOptions['optimizelyID'])) {
    require_once ('optimizely.php');
}
require_once ('fonts.php');

// Auto create cats
require_once (ABSPATH . '/wp-config.php');
require_once (ABSPATH . '/wp-includes/wp-db.php');
require_once (ABSPATH . '/wp-admin/includes/taxonomy.php');
wp_create_category('recommended');

// force no date folders
add_filter('option_uploads_use_yearmonth_folders', '__return_false', 100);

//set permalinks
function setPermalinks() {
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
}
add_action('init', 'setPermalinks');

// flushes permalinks after theme switch/activation
add_action('after_switch_theme', 'flush_rewrite_rules');

// Miscellaneous
function theme_scripts_admin() {
    wp_enqueue_style('theme-styles', MODULE_PATH . 'assets/' . 'styles.css');
    wp_register_script('meta-box-image', MODULE_PATH . 'assets/' . 'scripts.js', array('jquery'));
    wp_enqueue_script('meta-box-image');
}
add_action('admin_enqueue_scripts', 'theme_scripts_admin');
add_image_size('upsell-image', 90, 160);
add_image_size('review-product-image', 90, 500);

function add_mcafee() {
    wp_enqueue_script( 'script-name', 'https://cdn.ywxi.net/js/1.js', array(), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'add_mcafee' );

//create contact page
function create_front_page() {
    if (!get_page_by_title('Front Page')) {
        $postID = wp_insert_post(array('post_type' => 'page', 'post_title' => 'Front Page', 'post_content' => '', 'post_name' => 'front-page', 'post_status' => 'publish'));
        if ($postID !== 0) {
            add_post_meta($postID, 'custom_hero_html_custom_hero_html', '<div class="row medium-collapse"><div class="small-24 medium-12 columns collapse"><h1>YOUR GUIDE TO FINDING THE<br /><span class="pink">BEST FEMALE ENHANCEMENT</span></h1><p>There are thousands of [niche]s on the market that simply do NOT work! With each of them claiming they are the best, how can you find the [niche]s that are both safe and effective?</p><p>That\'s where we come in to help.</p><a class="button radius tiny success" href="#top-rated-list">See Our Best-Selling [niche]s</a></div><div class="small-0 medium-12  hide-for-small columns"><figure class="front-page-image"><img src="[url]/wp-content/uploads/intro-img.png" /></figure></div> <!-- / .small-0 --><div class="small-24 columns"><p>Our top [niche]s have been picked and are rated on the following <b>9 criteria:</b></p><ul><li>Overall Value</li><li>Effectiveness</li><li>Speed of Results</li><li>Product Safety</li><li>Ingredient Quality</li><li>Long-Term Results</li><li>Customer Reviews</li><li>Guarantee</li><li>Company Reputation</li></ul><p>*Individual results may vary</p><p>Keep reading to discover your favorite [niche]s of [year]!</p></div> <!-- / .small-24 --></div>');
        }
    }
}
add_action('after_switch_theme', 'create_front_page');

function create_contact() {
    if (!get_page_by_title('Contact')) {
        wp_insert_post(array('post_type' => 'page', 'post_title' => 'Contact', 'post_content' => "<h1>Contact Us</h1> [contact_form]", 'post_name' => 'contact', 'post_status' => 'publish'));
    }
}
add_action('after_switch_theme', 'create_contact');

//set front page to front page
function set_front_page() {
    $homepage = get_page_by_title('Front Page');
    if ($homepage) {
        update_option('page_on_front', $homepage->ID);
        update_option('show_on_front', 'page');
    }
}
add_action('after_switch_theme', 'set_front_page');

// function set_order() {
//     $fpid = get_option('page_on_front');

//     if ( get_post_meta($fpid, 'top-products-list', true) != '' ) {
//         if (!add_post_meta($fpid, 'top-products-list', '1,2,3,4,5', true)) {
//             update_post_meta($fpid, 'top-products-list', '1,2,3,4,5');
//         }
//     }
// }
// add_action('after_switch_theme', 'set_order');

function custom_get_url() {
  return get_site_url();
}
add_shortcode('url', 'custom_get_url');

function custom_get_themeurl() {
    return get_template_directory_uri().'/';
}
add_shortcode('theme_url', 'custom_get_themeurl');

function custom_get_uploadurl() {
    return get_site_url().'/wp-content/uploads/';
}
add_shortcode('theme_url', 'custom_get_uploadurl');

add_action('admin_menu', 'custom_title');
add_action('save_post', 'save_custom_title');
add_action('wp_head','insert_custom_title');

function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('body_class','out_of_stock_class');
function out_of_stock_class( $classes ) {
    global $post;
    if ( is_singular('products') && ( get_post_meta( $post->ID, 'out-of-stock', true ) == 'yes' ) ) {
        $classes[] = 'out-of-stock';
    }
    return $classes;
}

function custom_title() {
    add_meta_box('custom_title', 'SEO PAGE TITLE', 'custom_title_input_function', 'products', 'normal', 'high');
    add_meta_box('custom_title', 'SEO PAGE TITLE', 'custom_title_input_function', 'page', 'normal', 'high');
}
function custom_title_input_function() {
    global $post;
    echo '<input type="hidden" name="custom_title_input_hidden" id="custom_title_input_hidden" value="'.wp_create_nonce('custom-title-nonce').'" />';
    echo '<input type="text" name="custom_title_input" id="custom_title_input" style="width:100%;" value="'.get_post_meta($post->ID,'_custom_title',true).'" />';
}
function save_custom_title($post_id) {
    if (!wp_verify_nonce($_POST['custom_title_input_hidden'], 'custom-title-nonce')) return $post_id;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
    $customTitle = $_POST['custom_title_input'];
    update_post_meta($post_id, '_custom_title', $customTitle);
}
function insert_custom_title() {
    if (have_posts()) : the_post();
      $customTitle = get_post_meta(get_the_ID(), '_custom_title', true);
      if ($customTitle) {
        echo "<title>" . do_shortcode($customTitle) . "</title>";
      } else {
        echo "<title>";
          if (is_tag()) {
             single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
          elseif (is_archive()) {
             wp_title(''); echo ' Archive - '; }
          elseif ((is_single()) || (is_page()) && (!(is_front_page())) ) {
             wp_title(''); echo ' - '; }
          if (is_home()) {
             bloginfo('name'); echo ' - '; bloginfo('description'); }
          else {
              bloginfo('name'); }
          if ($paged>1) {
             echo ' - page '. $paged; }
        echo "</title>";
    }
    else :
      echo "<title>Page Not Found | Envision</title>";
    endif;
    rewind_posts();
}
