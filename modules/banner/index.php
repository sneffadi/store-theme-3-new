<?php

/*=============================================
=           Create Custom Fields              =
=============================================*/
if (!function_exists('underscore')) {
    function underscore($string) {
        $content = preg_replace('/\s+/', '_', $string);
        return strtolower($content);
    }
}
function product_banner_meta() {
    add_meta_box('banner_meta', __('Banner Options'), 'product_banner_callback', 'products', 'normal', 'high');
}
add_action('add_meta_boxes', 'product_banner_meta');

function product_banner_callback($post) {
    wp_nonce_field(basename(__FILE__), 'product_nonce');
    $cf_value= get_post_meta($post->ID); ?>
<style>
    label {
        display: block;
        margin-bottom: 0.5rem;
    }
    .prompt {
        font-size: 12px;
        font-style: italic;
    }
    #banner_meta input[type="text"] {
        width: 75%;
    }
    #banner_meta .custom-product-tabs textarea, .custom-product-banner textarea {
        width:80%;
        min-height:200px;
    }
</style>
<section id="banner_meta">
    <?php $checked= isset($cf_value['cf_custom_banner']) ? checked($cf_value['cf_custom_banner'][0], 'yes', FALSE) : '';
    $showCustom= (isset($cf_value['cf_custom_banner']))&&($cf_value['cf_custom_banner'][0]==='yes'); ?>
    <label><input type="checkbox" name="cf_custom_banner" <?php echo $checked;?> class="toggle-div" data-toggle-div="custom-product-banner" /> Custom Banner</label>
    <div class="custom-product-banner" <?php echo $showCustom ? '' : 'style="display:none;"';?>>
        <?php $checked= isset($cf_value['cf_cb_show_guar']) ? checked($cf_value['cf_cb_show_guar'][0], 'yes', FALSE) : ''; ?>
        <label><input type="checkbox" name="cf_cb_show_guar" <?php echo $checked;?> /> Show Guarantee Label</label>
        <?php $checked= isset($cf_value['cf_cb_free_ship']) ? checked($cf_value['cf_cb_free_ship'][0], 'yes', FALSE) : ''; ?>
        <label><input type="checkbox" name="cf_cb_free_ship" <?php echo $checked;?> /> Free Shipping</label>
        
        <p>
            <label>Item ID:</label>
            <?php $itemId= isset($cf_value['cf_item_id']) ? $cf_value['cf_item_id'][0] : ''; ?>
            <input type="text" name="cf_item_id" value="<?php echo $itemId;?>" style="width:25%" />
        </p>
        <p>
            <label>Retail Price:</label>
            <?php $retail= isset($cf_value['cf_retail_price']) ? $cf_value['cf_retail_price'][0] : ''; ?>
            $ <input type="text" name="cf_retail_price" value="<?php echo $retail;?>" style="width:25%" />
        </p>
        <p>
            <label>Store Price:</label>
            <?php $price= isset($cf_value['cf_store_price']) ? $cf_value['cf_store_price'][0] : ''; ?>
            $ <input type="text" name="cf_store_price" value="<?php echo $price;?>" style="width:25%" />
        </p>
        <p>
            <label>Banner Image(s)</label>
        <?php 
            $i = 1;
            $html = '';
            $cf_value = get_post_meta($post->ID);
            while(!empty($cf_value["cf_banner_image{$i}"][0]) && $cf_value["cf_banner_image{$i}"][0] != '' || $i == 1){
                $html.= "<input type=\"text\" name=\"cf_banner_image{$i}\" value=\"" . (isset($cf_value["cf_banner_image{$i}"]) ? $cf_value["cf_banner_image{$i}"][0] : '') . "\" />";
                $i++;
                
            }
            $html.= '<div class="add clear"><a href="#" class="addImage">Add Image [+]</a></div>';
            $html.= '<input type="hidden" name="'  . 'imageCount' . '" value="' . ($i - 1) . '" />';
            echo $html;
        ?>

        </p>
        <p>
            <label for="top-blurb">Top blurb (include p tags)</label>
            <textarea type="text" name="top-blurb"><?php if ( isset ( $cf_value['top-blurb'] ) ) echo $cf_value['top-blurb'][0]; ?></textarea>
        </p>
        <?php $checked= isset($cf_value['cf_custom_tabs']) ? checked($cf_value['cf_custom_tabs'][0], 'yes', FALSE) : '';
        $showCustom= (isset($cf_value['cf_custom_tabs']))&&($cf_value['cf_custom_tabs'][0]==='yes'); ?>
        <label><input type="checkbox" name="cf_custom_tabs" <?php echo $checked;?> class="toggle-div" data-toggle-div="custom-product-tabs" /> Add Tabs</label>
        <div class="custom-product-tabs" <?php echo $showCustom ? '' : 'style="display:none;"';?>>
            <p>
                <label for="description-tab">Description Tab (include p tags)</label>
                <textarea type="text" name="description-tab"><?php if ( isset ( $cf_value['description-tab'] ) ) echo $cf_value['description-tab'][0]; ?></textarea>
            </p>
            <p>
                <label for="suppfacts-tab">Supplement Facts Tab (include p tags)</label>
                <textarea type="text" name="suppfacts-tab"><?php if ( isset ( $cf_value['suppfacts-tab'] ) ) echo $cf_value['suppfacts-tab'][0]; ?></textarea>
            </p>
            <p>
                <label for="test-tab">Testimonials Tab (include p tags)</label>
                <textarea type="text" name="test-tab"><?php if ( isset ( $cf_value['test-tab'] ) ) echo $cf_value['test-tab'][0]; ?></textarea>
            </p>
            <p>
                <label for="guar-tab">Guarantee Tab (include p tags)</label>
                <textarea type="text" name="guar-tab"><?php if ( isset ( $cf_value['guar-tab'] ) ) echo $cf_value['guar-tab'][0]; ?></textarea>
            </p>
        </div>
    </div>
</section><!--/banner_meta -->
<script>
    (function($jq) {
        $jq(document).ready(function() {
            /* Toggle the custom data visibility */
            $jq('.toggle-div').on('click', function() {
                var toggleDiv = $jq(this).attr('data-toggle-div');
                if($jq(this).is(':checked')) $jq('.' + toggleDiv).show(300);
                else $jq('.' + toggleDiv).hide(300);
            });
        });
    })(jQuery.noConflict());

</script>
    <?php
}

function product_banner_save($post_id) {
    global $post;

    /* Verify that we should save the post form values -- if not, return without doing anything */
    if(!isset($_POST['product_nonce'])) return;
    if(!wp_verify_nonce($_POST['product_nonce'], basename(__FILE__))) return;
    if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE) return;

    /* Save the stuff */
    if((isset($_POST['cf_custom_banner']))&&($_POST['cf_custom_banner']!='')) {
        update_post_meta($post->ID, 'cf_custom_banner', 'yes');
    } else delete_post_meta($post->ID, 'cf_custom_banner');
    if((isset($_POST['cf_cb_show_guar']))&&($_POST['cf_cb_show_guar']!='')) {
        update_post_meta($post->ID, 'cf_cb_show_guar', 'yes');
    } else delete_post_meta($post->ID, 'cf_cb_show_guar');
    if((isset($_POST['cf_cb_free_ship']))&&($_POST['cf_cb_free_ship']!='')) {
        update_post_meta($post->ID, 'cf_cb_free_ship', 'yes');
    } else delete_post_meta($post->ID, 'cf_cb_free_ship');
    if((isset($_POST['cf_item_id']))&&($_POST['cf_item_id']!='')) {
        update_post_meta($post->ID, 'cf_item_id', esc_attr($_POST['cf_item_id']));
    } else delete_post_meta($post->ID, 'cf_item_id');
    if((isset($_POST['cf_retail_price']))&&($_POST['cf_retail_price']!='')) {
        update_post_meta($post->ID, 'cf_retail_price', esc_attr($_POST['cf_retail_price']));
    } else delete_post_meta($post->ID, 'cf_retail_price');
    if((isset($_POST['cf_store_price']))&&($_POST['cf_store_price']!='')) {
        update_post_meta($post->ID, 'cf_store_price', esc_attr($_POST['cf_store_price']));
    } else delete_post_meta($post->ID, 'cf_store_price');

    if((isset($_POST['cf_banner_subheader']))&&($_POST['cf_banner_subheader']!='')) {
        update_post_meta($post->ID, 'cf_banner_subheader', esc_attr($_POST['cf_banner_subheader']));
    } else delete_post_meta($post->ID, 'cf_banner_subheader');
    if((isset($_POST['top-blurb']))&&($_POST['top-blurb']!='')) {
        update_post_meta($post->ID, 'top-blurb', $_POST['top-blurb']);
    } else delete_post_meta($post->ID, 'top-blurb');
    
    if((isset($_POST['cf_custom_tabs']))&&($_POST['cf_custom_tabs']!='')) {
        update_post_meta($post->ID, 'cf_custom_tabs', 'yes');
    } else delete_post_meta($post->ID, 'cf_custom_tabs');
    if((isset($_POST['description-tab']))&&($_POST['description-tab']!='')) {
        update_post_meta($post->ID, 'description-tab', $_POST['description-tab']);
    } else delete_post_meta($post->ID, 'description-tab');
    if((isset($_POST['suppfacts-tab']))&&($_POST['suppfacts-tab']!='')) {
        update_post_meta($post->ID, 'suppfacts-tab', $_POST['suppfacts-tab']);
    } else delete_post_meta($post->ID, 'suppfacts-tab');
    if((isset($_POST['test-tab']))&&($_POST['test-tab']!='')) {
        update_post_meta($post->ID, 'test-tab', $_POST['test-tab']);
    } else delete_post_meta($post->ID, 'test-tab');
    if((isset($_POST['guar-tab']))&&($_POST['guar-tab']!='')) {
        update_post_meta($post->ID, 'guar-tab', $_POST['guar-tab']);
    } else delete_post_meta($post->ID, 'guar-tab');

    $cf_value = get_post_meta($post_id);
    $i = 1;
    while (isset($_POST['cf_banner_image' . $i])) {
        if (isset($_POST['cf_banner_image' . $i])) {
            update_post_meta($post_id, 'cf_banner_image' . $i, sanitize_text_field($_POST['cf_banner_image' . $i]));
        }
        else {
            delete_post_meta($post_id, "cf_banner_image{$i}");
        }
        if (isset($_POST['imageCount'])) {
            update_post_meta($post_id, 'imageCount', sanitize_text_field($_POST['imageCount']));
        }
        else {
            update_post_meta($post_id, 'imageCount', 1);
        }
        $i++;
    }
}
add_action('save_post', 'product_banner_save');

/*-----  End Custom Fields  ------*/

/*====================================
=            Load Scripts            =
====================================*/

//enqueue script for module and image loader
function banner_image_enqueue() {
    global $typenow;
    if ($typenow == 'products') {
        wp_enqueue_media();

        // Registers and enqueues the required javascript.
        wp_register_script( 'banner-script', MODULE_PATH . 'banner/' . 'script.js', array( 'jquery' ) );
        wp_enqueue_script( 'banner-script' );
    }
}
add_action('admin_enqueue_scripts', 'banner_image_enqueue');


/*=============================================
=                 Product Banner              =
=============================================*/

function format_currency($value) {
    $formattedValue= $value;
    if(($formattedValue===FALSE)||($formattedValue==='')) $formattedValue= 0;
    $formattedValue= number_format($formattedValue, 2);
    return $formattedValue;
}

function render_custom_product_banner() {
    $postId= get_the_ID();
    $options = get_option('theme_options');
    $num = !empty($options['ratings']) ? $options['ratings'] : "100";
    $cf_value= get_post_meta($postId);
    $themeOptions= get_option('theme_options');
    $priceOne = get_post_meta($postId, "cf_store_price", true);
    $priceTwo = get_post_meta($postId, "cf_store_price_two", true);
    $priceThree = get_post_meta($postId, "cf_store_price_three", true);
    $retail = get_post_meta($postId, "cf_retail_price", true);
    $retailTwo = $retail * 2;
    $retailThree = $retail * 3;
    $savingsOne = $retail - $priceOne;
    $savingsTwo = $retailTwo - $priceTwo;
    $savingsThree = $retailThree - $priceThree;
    $itemId= isset($cf_value['cf_item_id']) ? $cf_value['cf_item_id'][0] : '';
    if($showCustom= (isset($cf_value['cf_custom_banner']))&&($cf_value['cf_custom_banner'][0]==='yes')):
        ?>
<div class="row custom-product-banner medium-collapse">
    <div class="columns medium-10 small-24">
        
        <div class="tabs-content" data-tabs-content="image-tabs">
            <?php 
                $j = 1;
                $slides = '';
                while(($sfImg= get_post_meta(get_the_ID(), 'cf_banner_image'.$j, TRUE))!=='') {
                    $slides .= '<div class="tabs-panel';
                    if ($j ==1) {$slides .= ' is-active';}
                    $slides .= '" id="panel'.$j.'">';
                    $slides .= '<a data-open="imageModal'.$j.'">';
                    $slides .= '<img src="'.custom_get_uploadurl().$sfImg.'" class="img-large" />';
                    $slides .= '</a>';
                    $slides .= '</div>';
                    $slides .= '<div class="reveal" id="imageModal'.$j.'" data-reveal>';
                    $slides .= '<img src="'.custom_get_uploadurl().$sfImg.'" />';
                    $slides .= '<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>';
                    $slides .= '</div>';

                    $j++;
                } 
            echo $slides;?>
        </div>
        <ul class="tabs" data-tabs id="image-tabs">
            <?php 
                $i = 1;
                $slides = '';
                while(($sfImg= get_post_meta(get_the_ID(), 'cf_banner_image'.$i, TRUE))!=='') {
                    $slides .= '<li class="tabs-title';
                    if ($i ==1) {$slides .= ' is-active';}
                    $slides .= '"><a href="#panel'.$i.'"';
                    if ($i ==1) {$slides .= ' aria-selected="true"';}
                    $slides .= '>';
                    $slides .= '<img src="'.custom_get_uploadurl().$sfImg.'" class="image-thumbnail" />';
                    $slides .= '</a></li>';
                    $i++;
                } 
                echo $slides;?>
        </ul>

        <?php if((isset($cf_value['cf_cb_free_ship']))&&($cf_value['cf_cb_free_ship'][0]==='yes')):
            ?>
        <img src="<?php echo do_shortcode('[upload_dir]') .'free-shipping.png'?>" class="free-shipping" alt="Free Shipping (within US) with order of 2 bottles or more" title="Free Shipping (within US) with order of 2 bottles or more" />
        <?php endif; ?>
    </div><!--end div.columns-->
    <div class="columns medium-13 small-24 productMeta">

        <div class="row prod-title medium-collapse">
            <div class="small-12 columns">
                <h1><?php the_title();?></h1>
            </div>
            <div class="small-12 columns">
                <div class="criterion-row row">
                    <?php $thisRating= get_post_meta($postId, 'ratings-overall-value', TRUE);
                    $thisRating= number_format(floatval($thisRating), 1); ?>
                    <div class="small-18 columns star-col">
                        <div class="star-positioner">
                            <div class="stars">
                                <div class="colorbar" style="width:<?php echo $thisRating*20;?>%">
                                    
                                </div>
                                <div class="star_holder">
                                    <div class="star star-1"></div> <!-- / .star -->
                                    <div class="star star-2"></div> <!-- / .star -->
                                    <div class="star star-3"></div> <!-- / .star -->
                                    <div class="star star-4"></div> <!-- / .star -->
                                    <div class="star star-5"></div> <!-- / .star -->
                                </div> <!-- / .star_holder -->
                            </div> <!-- / .stars -->
                        </div> <!-- / .star-positioner -->
                    </div><!--/medium-5 columns show-for-medium-->
                    <div class="small-6 columns out-of">
                        <?php echo $thisRating."/".$num; ?>
                    </div><!--/ small-3 medium-2 columns out-of -->
                </div><!--/ criterion-row row -->
            </div>
        </div>
        <div class="ratings-box">
            <div class="small-24 columns table">
                <div class="criterion-row row">
                    <div class="small-8 columns criterion">
                        <div class="rating-type">
                            Overall Rating:
                        </div>
                        <?php $thisRating= get_post_meta($postId, 'ratings-overall-value', TRUE);
                        if($thisRating==='') {
                            $thisRating= get_post_meta($id, 'ratings-overall-value', TRUE);
                            if($thisRating==='') $thisRating= 0;
                        }
                        $thisRating= number_format(floatval($thisRating), 1); ?>
                        <div class="star-col" data-tooltip aria-haspopup="true" class="has-tip top" data-click-open="false" data-disable-hover="false" tabindex="2" title="<?php echo $thisRating."/".$num; ?>">
                            <div class="star-positioner">
                                <div class="stars">
                                    <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                    <div class="star_holder">
                                        <div class="star star-1"></div> <!-- / .star -->
                                        <div class="star star-2"></div> <!-- / .star -->
                                        <div class="star star-3"></div> <!-- / .star -->
                                        <div class="star star-4"></div> <!-- / .star -->
                                        <div class="star star-5"></div> <!-- / .star -->
                                    </div> <!-- / .star_holder -->
                                </div> <!-- / .stars -->
                            </div> <!-- / .star-positioner -->
                        </div>
                    </div>
                    <div class="small-8 columns criterion">
                        <div class="rating-type">
                            <?php $value= get_post_meta($id, "ratings-ingredient-quality", true);
                            if(($value===FALSE)||($value==='')) $value= 0; ?>
                                Ingredient Quality:
                        </div>
                            <?php $thisRating= get_post_meta($postId, 'ratings-ingredient-quality', TRUE);                            
                            if($thisRating==='') {
                                $thisRating= get_post_meta($id, 'ratings-ingredient-quality', TRUE);
                                if($thisRating==='') $thisRating= 0;
                            }
                            $thisRating= number_format(floatval($thisRating), 1); ?>
                        <div class="star-col" data-tooltip aria-haspopup="true" class="has-tip top" data-click-open="false" data-disable-hover="false" tabindex="2" title="<?php echo $thisRating."/".$num; ?>">
                            <div class="star-positioner">
                                <div class="stars">
                                    <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                    <div class="star_holder">
                                        <div class="star star-1"></div> <!-- / .star -->
                                        <div class="star star-2"></div> <!-- / .star -->
                                        <div class="star star-3"></div> <!-- / .star -->
                                        <div class="star star-4"></div> <!-- / .star -->
                                        <div class="star star-5"></div> <!-- / .star -->
                                    </div> <!-- / .star_holder -->
                                </div> <!-- / .stars -->
                            </div> <!-- / .star-positioner -->
                        </div>
                    </div>
                    <div class="small-8 columns criterion">
                        <div class="rating-type">
                            <?php $value= get_post_meta($id, "ratings-effectiveness", true);
                            if(($value===FALSE)||($value==='')) $value= 0; ?>
                                Weight Loss Power:
                        </div>
                            <?php $thisRating= get_post_meta($postId, 'ratings-effectiveness', TRUE);
                            if($thisRating==='') {
                                $thisRating= get_post_meta($id, 'ratings-effectiveness', TRUE);
                                if($thisRating==='') $thisRating= 0;
                            }
                            $thisRating= number_format(floatval($thisRating), 1); ?>
                        <div class="star-col" data-tooltip aria-haspopup="true" class="has-tip top" data-click-open="false" data-disable-hover="false" tabindex="2" title="<?php echo $thisRating."/".$num; ?>">
                            <div class="star-positioner">
                                <div class="stars">
                                    <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                    <div class="star_holder">
                                        <div class="star star-1"></div> <!-- / .star -->
                                        <div class="star star-2"></div> <!-- / .star -->
                                        <div class="star star-3"></div> <!-- / .star -->
                                        <div class="star star-4"></div> <!-- / .star -->
                                        <div class="star star-5"></div> <!-- / .star -->
                                    </div> <!-- / .star_holder -->
                                </div> <!-- / .stars -->
                            </div> <!-- / .star-positioner -->
                        </div>
                    </div> 
                </div><!--/ criterion-row row -->
                <div class="criterion-row row">
                    <div class="small-8 columns criterion">
                        <?php $value= get_post_meta($id, "ratings-long-term-results", true);
                        if(($value===FALSE)||($value==='')) $value= 0; ?>
                        <div class="rating-type">
                            Long-Term Results:
                        </div>
                        <?php $thisRating= get_post_meta($postId, 'ratings-long-term-results', TRUE);
                        if($thisRating==='') {
                            $thisRating= get_post_meta($id, 'ratings-long-term-results', TRUE);
                            if($thisRating==='') $thisRating= 0;
                        }
                        $thisRating= number_format(floatval($thisRating), 1); ?>
                        <div class="star-col" data-tooltip aria-haspopup="true" class="has-tip top" data-click-open="false" data-disable-hover="false" tabindex="2" title="<?php echo $thisRating."/".$num; ?>">
                            <div class="star-positioner">
                                <div class="stars">
                                    <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                    <div class="star_holder">
                                        <div class="star star-1"></div> <!-- / .star -->
                                        <div class="star star-2"></div> <!-- / .star -->
                                        <div class="star star-3"></div> <!-- / .star -->
                                        <div class="star star-4"></div> <!-- / .star -->
                                        <div class="star star-5"></div> <!-- / .star -->
                                    </div> <!-- / .star_holder -->
                                </div> <!-- / .stars -->
                            </div> <!-- / .star-positioner -->
                        </div><!-- /.star-col -->
                    </div>
                    <div class="small-8 columns criterion">
                        <div class="rating-type">
                            <?php $value= get_post_meta($id, "ratings-customer-reviews", true);
                            if(($value===FALSE)||($value==='')) $value= 0; ?>
                                Customer Reviews:
                        </div>
                            <?php $thisRating= get_post_meta($postId, 'ratings-customer-reviews', TRUE);
                            if($thisRating==='') {
                                $thisRating= get_post_meta($id, 'ratings-customer-reviews', TRUE);
                                if($thisRating==='') $thisRating= 0;
                            }
                            $thisRating= number_format(floatval($thisRating), 1); ?>
                        <div class="star-col" data-tooltip aria-haspopup="true" class="has-tip top" data-click-open="false" data-disable-hover="false" tabindex="2" title="<?php echo $thisRating."/".$num; ?>">
                            <div class="star-positioner">
                                <div class="stars">
                                    <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                    <div class="star_holder">
                                        <div class="star star-1"></div> <!-- / .star -->
                                        <div class="star star-2"></div> <!-- / .star -->
                                        <div class="star star-3"></div> <!-- / .star -->
                                        <div class="star star-4"></div> <!-- / .star -->
                                        <div class="star star-5"></div> <!-- / .star -->
                                    </div> <!-- / .star_holder -->
                                </div> <!-- / .stars -->
                            </div> <!-- / .star-positioner -->
                        </div><!--/ .star-col -->
                    </div>
                    <div class="small-8 columns criterion">
                        <div class="rating-type">
                            <?php $value= get_post_meta($id, "ratings-product-safety", true);
                            if(($value===FALSE)||($value==='')) $value= 0; ?>
                                Product Safety:
                        </div>
                            <?php $thisRating= get_post_meta($postId, 'ratings-product-safety', TRUE);
                            if($thisRating==='') {
                                $thisRating= get_post_meta($id, 'ratings-product-safety', TRUE);
                                if($thisRating==='') $thisRating= 0;
                            }
                            $thisRating= number_format(floatval($thisRating), 1); ?>
                        <div class="star-col" data-tooltip aria-haspopup="true" class="has-tip top" data-click-open="false" data-disable-hover="false" tabindex="2" title="<?php echo $thisRating."/".$num; ?>">
                            <div class="star-positioner">
                                <div class="stars">
                                    <div class="colorbar" style="width:<?php echo $thisRating*20;?>%"></div>
                                    <div class="star_holder">
                                        <div class="star star-1"></div> <!-- / .star -->
                                        <div class="star star-2"></div> <!-- / .star -->
                                        <div class="star star-3"></div> <!-- / .star -->
                                        <div class="star star-4"></div> <!-- / .star -->
                                        <div class="star star-5"></div> <!-- / .star -->
                                    </div> <!-- / .star_holder -->
                                </div> <!-- / .stars -->
                            </div> <!-- / .star-positioner -->
                        </div>
                    </div>
                </div><!--/ criterion-row row -->
            </div>
        </div>
        <?php $bannerSubheader= isset($cf_value['cf_banner_subheader']) ? $cf_value['cf_banner_subheader'][0] : '';
        if(($bannerSubheader!==FALSE)&&($bannerSubheader!=='')):
            ?>
        <h2><?php echo $bannerSubheader;?></h2>
        <?php endif;
            $topBlurb = isset($cf_value['top-blurb']) ? $cf_value['top-blurb'][0] : '';
            echo do_shortcode($topBlurb);
        ?>
        <?php 
        $themeOptions= get_option('theme_options');?>
        

        <script>
        function modify_qty(val) {
            var qty = document.getElementById('qty').value;
            var new_qty = parseInt(qty,10) + val;
            
            if (new_qty < 1) {
                new_qty = 1;
            }
            var value = document.getElementById('price').getAttribute('data-value');
            document.getElementById('qty').value = new_qty;
            document.getElementById('price').innerHTML = (value * new_qty).toFixed(2);
            return new_qty;
        }
        $(".custom-product-banner .productMeta .prod-title .criterion-row").mouseenter(
            function () {
                $(".productMeta .ratings-box").show();
            }
        );
        $(".custom-product-banner .productMeta .ratings-box").mouseleave(
            function () {
                $(".productMeta .ratings-box").hide();
            }
        );
        </script>
        <form class="addProductForm" action="<?php echo do_shortcode('[cart_url]');?>" method="GET">
            <div class="priceWrap">
            $<span id="price" data-value="<?php echo format_currency($priceOne);?>"><?php echo format_currency($priceOne);?></span>
            </div>
            Quantity
            <div class="box radius">    
                <span id="down" onclick="modify_qty(-1)">-</span>
                <input id="qty" name="ADD_<?php echo $itemId ?>" value="1" readonly/>
                <span id="up" onclick="modify_qty(1)">+</span>
                
            </div>
            <button type="submit" class="addToCart button">Add to Cart</button>
        </form>
    </div><!--end div.columns-->
    
</div><!--end div.custom-product-banner-->
<?php
    $description= isset($cf_value['description-tab']) ? $cf_value['description-tab'][0] : 'Coming Soon1';
    $suppfacts= isset($cf_value['suppfacts-tab']) ? $cf_value['suppfacts-tab'][0] : 'Coming Soon2';
    $test= isset($cf_value['test-tab']) ? $cf_value['test-tab'][0] : 'Coming Soon3';
    $faq= isset($cf_value['guar-tab']) ? $cf_value['guar-tab'][0] : 'Coming Soon4';
    if ($showCustom= (isset($cf_value['cf_custom_tabs']))&&($cf_value['cf_custom_tabs'][0]==='yes')) { ?>
        <div class="row tabs-section">
            <div class="small-24 column">
                <div class="border-wrap">
                    <div class="row">
                        <div class="small-20 small-centered columns">
                            <ul class="tabs" data-tabs id="custom-tabs">
                              <?php if((isset($cf_value['description-tab']))&&($cf_value['description-tab']!='')) { ?><li class="tabs-title is-active"><a href="#description-panel">Description</a></li> <?php } ?>
                              <?php if((isset($cf_value['suppfacts-tab']))&&($cf_value['suppfacts-tab']!='')) { ?><li class="tabs-title <?php if($cf_value['description-tab']=='') {echo 'is-active';} ?>"><a href="#suppfacts-panel">Ingredients</a></li> <?php } ?>
                              <?php if((isset($cf_value['test-tab']))&&($cf_value['test-tab']!='')) { ?><li class="tabs-title <?php if($cf_value['suppfacts-tab']=='' && $cf_value['description-tab']=='') {echo 'is-active';} ?>"><a href="#test-panel">Reviews</a></li> <?php } ?>
                              <?php if((isset($cf_value['guar-tab']))&&($cf_value['guar-tab']!='')) { ?><li class="tabs-title <?php if($cf_value['suppfacts-tab']=='' && $cf_value['description-tab']=='' && $cf_value['test-tab']=='') {echo 'is-active';} ?>"><a href="#guar-panel">Guarantee</a></li> <?php } ?>
                            </ul>
                        </div> <!-- / .small-24 columns -->                
                    </div> <!-- / .row --> 
                </div>
                <div class="tabs-content" data-tabs-content="custom-tabs">
                   <?php if((isset($cf_value['description-tab']))&&($cf_value['description-tab']!='')) { ?> <div class="content is-active tabs-panel" id="description-panel">
                        <div class="row small-collapse medium-uncollapse">
                            <div class="small-24 columns">
                                <?php echo do_shortcode($description); ?> 
                            </div> <!-- / .small-24 columns -->
                        </div> <!-- / .row -->  
                    </div> <?php } ?>
                   <?php if((isset($cf_value['suppfacts-tab']))&&($cf_value['suppfacts-tab']!='')) { ?> <div class="content <?php if($cf_value['description-tab']=='') {echo 'is-active';} ?> tabs-panel" id="suppfacts-panel">
                        <div class="row ingredients small-collapse medium-uncollapse">
                            <div class="small-24 columns">
                                <?php echo do_shortcode($suppfacts); ?> 
                            </div> <!-- / .small-24 columns -->
                        </div> <!-- / .row -->
                    </div> <?php } ?>
                    <?php if((isset($cf_value['test-tab']))&&($cf_value['test-tab']!='')) { ?><div class="content <?php if($cf_value['suppfacts-tab']=='' && $cf_value['description-tab']=='') {echo 'is-active';} ?> tabs-panel" id="test-panel">
                        <div class="row testimonials small-collapse medium-uncollapse">
                            <div class="small-24 columns">
                                <?php echo do_shortcode($test); ?> 
                            </div> <!-- / .small-24 columns -->
                        </div> <!-- / .row -->
                    </div> <?php } ?>
                    <?php if((isset($cf_value['guar-tab']))&&($cf_value['guar-tab']!='')) { ?><div class="content <?php if($cf_value['suppfacts-tab']=='' && $cf_value['description-tab']=='' && $cf_value['test-tab']=='') {echo 'is-active';} ?> tabs-panel" id="guar-panel">
                        <div class="row small-collapse medium-uncollapse">
                            <div class="small-24 columns">
                                <?php echo do_shortcode($faq); ?> 
                            </div> <!-- / .small-24 columns -->
                        </div> <!-- / .row -->
                    </div><?php } ?>
                </div>
            </div> <!-- / .small-24 column -->
        </div> <!-- / .row tabs -->
        
    <?php } ?>
    <?php endif;
}
add_action('before_review_content', 'render_custom_product_banner', 10);
