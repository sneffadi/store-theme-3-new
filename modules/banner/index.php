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
    #banner_meta .custom-product-tabs textarea {
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
            <label>Retail Price:</label>
            <?php $retail= isset($cf_value['cf_retail_price']) ? $cf_value['cf_retail_price'][0] : ''; ?>
            $ <input type="text" name="cf_retail_price" value="<?php echo $retail;?>" style="width:25%" />
        </p>
        <p>
            <label>Store Price 1:</label>
            <?php $priceOne= isset($cf_value['cf_store_price_one']) ? $cf_value['cf_store_price_one'][0] : ''; ?>
            $ <input type="text" name="cf_store_price_one" value="<?php echo $priceOne;?>" style="width:25%" />
        </p>
        <p>
            <label>Item ID 1:</label>
            <?php $itemId= isset($cf_value['cf_item_id_one']) ? $cf_value['cf_item_id_one'][0] : ''; ?>
            <input type="text" name="cf_item_id_one" value="<?php echo $itemId;?>" style="width:25%" />
        </p>
        <p>
            <label>Store Price 2:</label>
            <?php $priceTwo= isset($cf_value['cf_store_price_two']) ? $cf_value['cf_store_price_two'][0] : ''; ?>
            $ <input type="text" name="cf_store_price_two" value="<?php echo $priceTwo;?>" style="width:25%" />
        </p>
        <p>
            <label>Item ID 2:</label>
            <?php $itemIdTwo= isset($cf_value['cf_item_id_two']) ? $cf_value['cf_item_id_two'][0] : ''; ?>
            <input type="text" name="cf_item_id_two" value="<?php echo $itemIdTwo;?>" style="width:25%" />
        </p>
        <p>
            <label>Store Price 3:</label>
            <?php $priceThree= isset($cf_value['cf_store_price_three']) ? $cf_value['cf_store_price_three'][0] : ''; ?>
            $ <input type="text" name="cf_store_price_three" value="<?php echo $priceThree;?>" style="width:25%" />
        </p>
        <p>
            <label>Item ID 3:</label>
            <?php $itemIdThree= isset($cf_value['cf_item_id_three']) ? $cf_value['cf_item_id_three'][0] : ''; ?>
            <input type="text" name="cf_item_id_three" value="<?php echo $itemIdThree;?>" style="width:25%" />
        </p>
        <p>
            <label>Bottle Image</label>
            <?php $bannerImg= isset($cf_value['cf_banner_image']) ? $cf_value['cf_banner_image'][0] : ''; ?>
            <input type="text" name="cf_banner_image" value="<?php echo $bannerImg;?>" style="width:50%" /> <span class="prompt">(File path relative to the media upload directory)</span>
        </p>
        <p>
            <label>Product Sub-Header</label>
            <?php $bannerSubheader= isset($cf_value['cf_banner_subheader']) ? $cf_value['cf_banner_subheader'][0] : ''; ?>
            <input type="text" name="cf_banner_subheader" value="<?php echo $bannerSubheader;?>"/>
        </p>
         <?php for($i=1;$i<5;$i++):
        ?>
        <p>
            <label>Product Bullet-point #<?php echo $i;?></label>
            <?php $bannerImg= isset($cf_value['cf_prod_bullet_point_'.$i]) ? $cf_value['cf_prod_bullet_point_'.$i][0] : ''; ?>
            <input type="text" name="cf_prod_bullet_point_<?php echo $i;?>" value="<?php echo $bannerImg;?>"/>
        </p>
    <?php endfor; ?>
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
                <label for="faq-tab">FAQ Tab (include p tags)</label>
                <textarea type="text" name="faq-tab"><?php if ( isset ( $cf_value['faq-tab'] ) ) echo $cf_value['faq-tab'][0]; ?></textarea>
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
    if((isset($_POST['cf_item_id_one']))&&($_POST['cf_item_id_one']!='')) {
        update_post_meta($post->ID, 'cf_item_id_one', esc_attr($_POST['cf_item_id_one']));
    } else delete_post_meta($post->ID, 'cf_item_id_one');
    if((isset($_POST['cf_item_id_two']))&&($_POST['cf_item_id_two']!='')) {
        update_post_meta($post->ID, 'cf_item_id_two', esc_attr($_POST['cf_item_id_two']));
    } else delete_post_meta($post->ID, 'cf_item_id_two');
if((isset($_POST['cf_item_id_three']))&&($_POST['cf_item_id_three']!='')) {
        update_post_meta($post->ID, 'cf_item_id_three', esc_attr($_POST['cf_item_id_three']));
    } else delete_post_meta($post->ID, 'cf_item_id_three');
    if((isset($_POST['cf_store_price_three']))&&($_POST['cf_store_price_three']!='')) {
        update_post_meta($post->ID, 'cf_store_price_three', esc_attr($_POST['cf_store_price_three']));
    } else delete_post_meta($post->ID, 'cf_store_price_three');

    if((isset($_POST['cf_retail_price']))&&($_POST['cf_retail_price']!='')) {
        update_post_meta($post->ID, 'cf_retail_price', esc_attr($_POST['cf_retail_price']));
    } else delete_post_meta($post->ID, 'cf_retail_price');
    if((isset($_POST['cf_store_price_one']))&&($_POST['cf_store_price_one']!='')) {
        update_post_meta($post->ID, 'cf_store_price_one', esc_attr($_POST['cf_store_price_one']));
    } else delete_post_meta($post->ID, 'cf_store_price_one');
    if((isset($_POST['cf_store_price_two']))&&($_POST['cf_store_price_two']!='')) {
        update_post_meta($post->ID, 'cf_store_price_two', esc_attr($_POST['cf_store_price_two']));
    } else delete_post_meta($post->ID, 'cf_store_price_two');
    if((isset($_POST['cf_store_price_three']))&&($_POST['cf_store_price_three']!='')) {
        update_post_meta($post->ID, 'cf_store_price_three', esc_attr($_POST['cf_store_price_three']));
    } else delete_post_meta($post->ID, 'cf_store_price_three');
    if((isset($_POST['cf_banner_image']))&&($_POST['cf_banner_image']!='')) {
        update_post_meta($post->ID, 'cf_banner_image', esc_attr($_POST['cf_banner_image']));
    } else delete_post_meta($post->ID, 'cf_banner_image');
    if((isset($_POST['cf_banner_subheader']))&&($_POST['cf_banner_subheader']!='')) {
        update_post_meta($post->ID, 'cf_banner_subheader', esc_attr($_POST['cf_banner_subheader']));
    } else delete_post_meta($post->ID, 'cf_banner_subheader');
    
    for($i=1;$i<5;$i++) {
        if((isset($_POST['cf_prod_bullet_point_'.$i]))&&($_POST['cf_prod_bullet_point_'.$i]!='')) {
            update_post_meta($post->ID, 'cf_prod_bullet_point_'.$i, esc_attr($_POST['cf_prod_bullet_point_'.$i]));
        } else delete_post_meta($post->ID, 'cf_prod_bullet_point_'.$i);
    }
    if((isset($_POST['cf_custom_tabs']))&&($_POST['cf_custom_tabs']!='')) {
        update_post_meta($post->ID, 'cf_custom_tabs', 'yes');
    } else delete_post_meta($post->ID, 'cf_custom_tabs');
    if((isset($_POST['description-tab']))&&($_POST['description-tab']!='')) {
        update_post_meta($post->ID, 'description-tab', $_POST['description-tab']);
    } else delete_post_meta($post->ID, 'description-tab');
    if((isset($_POST['suppfacts-tab']))&&($_POST['suppfacts-tab']!='')) {
        update_post_meta($post->ID, 'suppfacts-tab', $_POST['suppfacts-tab']);
    } else delete_post_meta($post->ID, 'suppfacts-tab');
    if((isset($_POST['faq-tab']))&&($_POST['faq-tab']!='')) {
        update_post_meta($post->ID, 'faq-tab', $_POST['faq-tab']);
    } else delete_post_meta($post->ID, 'faq-tab');;
}
add_action('save_post', 'product_banner_save');

/*-----  End Custom Fields  ------*/

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
    $cf_value= get_post_meta($postId);
    $priceOne = get_post_meta($postId, "cf_store_price_one", true);
    $priceTwo = get_post_meta($postId, "cf_store_price_two", true);
    $priceThree = get_post_meta($postId, "cf_store_price_three", true);
    $retail = get_post_meta($postId, "cf_retail_price", true);
    $retailTwo = $retail * 2;
    $retailThree = $retail * 3;
    $savingsOne = $retail - $priceOne;
    $savingsTwo = $retailTwo - $priceTwo;
    $savingsThree = $retailThree - $priceThree;
    if($showCustom= (isset($cf_value['cf_custom_banner']))&&($cf_value['cf_custom_banner'][0]==='yes')):
        ?>
<div class="row custom-product-banner">
    <div class="columns large-8 medium-8 small-24">
        <?php $customImg= isset($cf_value['cf_banner_image']) ? $cf_value['cf_banner_image'][0] : ''; ?>
        <div class="imgBox">
            <img src="<?php echo custom_get_uploadurl().$customImg;?>" class="custom-image" />
        <?php if((isset($cf_value['cf_cb_show_guar']))&&($cf_value['cf_cb_show_guar'][0]==='yes')):
            ?>
        <img src="<?php echo do_shortcode('[upload_dir]').'guarantee.png'?>" class="guarantee-seal" alt="Money Back Guarantee" title="Money Back Guarantee" />
        <?php endif; ?>
        </div>
        <?php if((isset($cf_value['cf_cb_free_ship']))&&($cf_value['cf_cb_free_ship'][0]==='yes')):
            ?>
        <img src="<?php echo do_shortcode('[upload_dir]') .'free-shipping.png'?>" class="free-shipping" alt="Free Shipping (within US) with order of 2 bottles or more" title="Free Shipping (within US) with order of 2 bottles or more" />
        <?php endif; ?>
    </div><!--end div.columns-->
    <div class="columns large-16 medium-16 small-24 productMeta">
        <h1><?php the_title();?></h1>
        <?php $bannerSubheader= isset($cf_value['cf_banner_subheader']) ? $cf_value['cf_banner_subheader'][0] : '';
        if(($bannerSubheader!==FALSE)&&($bannerSubheader!=='')):
            ?>
        <h2><?php echo $bannerSubheader;?></h2>
        <?php endif;
        $bannerBp= isset($cf_value['cf_prod_bullet_point_1']) ? $cf_value['cf_prod_bullet_point_1'][0] : '';
        if(($bannerBp!==FALSE)&&($bannerBp!=='')):
            $i= 1; ?>
        <ul>
            <?php while($bannerBp):
                ?>
            <li><?php echo $bannerBp;?></li>
                <?php $i++;
                $bannerBp= isset($cf_value['cf_prod_bullet_point_'.$i]) ? $cf_value['cf_prod_bullet_point_'.$i][0] : '';
            endwhile; ?>
        </ul>
        <?php endif;
        $themeOptions= get_option('theme_options');?>
        <form class="addProductForm" action="<?php echo $themeOptions['cart-url'];?>" method="GET">
            <div class="hBorders qtyBox">
                <ul class="tabs" data-tabs id="buy-tabs">
                    <li class="tabs-title is-active" role="presentation"><a href="#panel1" aria-selected="true">1 Bottle</a></li>
                    <?php if((isset($cf_value['cf_item_id_two']))&&($cf_value['cf_item_id_two']!='')) { ?><li class="tabs-title"><a href="#panel2">2 Bottles</a></li><?php } ?>
                    <?php if((isset($cf_value['cf_item_id_three']))&&($cf_value['cf_item_id_three']!='')) { ?><li class="tabs-title"><a href="#panel3">3 Bottles</a></li><?php } ?>
                </ul>
                <div class="tabs-content" data-tabs-content="buy-tabs">
                    <section class="tabs-panel is-active" id="panel1">
                        <span class="retail" data-value="<?php echo format_currency($retail);?>">$<span><?php echo format_currency($retail);?></span></span>
                        <div class="row collapse pricing">
                            <div class="small-24 medium-7 columns">
                                <span class="price" data-value="<?php echo format_currency($priceOne);?>">$<span><?php echo format_currency($priceOne);?></span></span>
                            </div> <!-- / .small-24 medium-8 columns -->
                            <div class="small-24 medium-8 end columns">
                                <span class="savings">Save: $<span><?php echo format_currency($savingsOne);?></span>!</span>
                            </div> <!-- / .small-24 medium-5 end -->
                        </div> <!-- / .row small-collapse -->
                    <?php $itemId= isset($cf_value['cf_item_id_one']) ? $cf_value['cf_item_id_one'][0] : '';
                    echo "<a href=\"" . do_shortcode('[cart_url]') . "?add=" . $itemId . "\" class=\"button add-to-cart addToCart button\" >" . "Add to Cart" . "</a>"; ?>   
                    </section>
                    <section class="tabs-panel" id="panel2">
                        <span class="retail" data-value="<?php echo format_currency($retailTwo);?>">$<span><?php echo format_currency($retailTwo);?></span></span>
                        <div class="row collapse pricing">
                            <div class="small-24 medium-7 columns">
                                <span class="price" data-value="<?php echo format_currency($priceTwo);?>">$<span><?php echo format_currency($priceTwo);?></span></span>
                            </div> <!-- / .small-24 medium-8 columns -->
                            <div class="small-24 medium-7 end columns">
                                <span class="savings">Save: $<span><?php echo format_currency($savingsTwo);?></span>!</span>
                            </div> <!-- / .small-24 medium-5 end -->
                        </div> <!-- / .row small-collapse -->
                    <?php $itemId= isset($cf_value['cf_item_id_two']) ? $cf_value['cf_item_id_two'][0] : '';
                    echo "<a href=\"" . do_shortcode('[cart_url]') . "?add=" . $itemId . "\" class=\"button add-to-cart addToCart button\" >" . "Add to Cart" . "</a>"; ?>
                    </section>
                    <section class="tabs-panel " id="panel3">
                        <span class="retail">$<span><?php echo format_currency($retailThree);?></span></span>
                        <div class="row collapse pricing">
                            <div class="small-24 medium-7 columns">
                                <span class="price" data-value="<?php echo format_currency($priceThree);?>">$<span><?php echo format_currency($priceThree);?></span></span>
                            </div> <!-- / .small-24 medium-8 columns -->
                            <div class="small-24 medium-7 end columns">
                                <span class="savings">Save: $<span><?php echo format_currency($savingsThree);?></span>!</span>
                            </div> <!-- / .small-24 medium-5 end -->
                        </div> <!-- / .row small-collapse -->
                    <?php $itemId= isset($cf_value['cf_item_id_three']) ? $cf_value['cf_item_id_three'][0] : '';
                    echo "<a href=\"" . do_shortcode('[cart_url]') . "?add=" . $itemId . "\" class=\"button add-to-cart addToCart button\" >" . "Add to Cart" . "</a>";?>
                    </section>
                </div>
            </div>
        </form>
    </div><!--end div.columns-->
</div><!--end div.custom-product-banner-->
<?php
    $description= isset($cf_value['description-tab']) ? $cf_value['description-tab'][0] : 'Coming Soon';
    $suppfacts= isset($cf_value['suppfacts-tab']) ? $cf_value['suppfacts-tab'][0] : 'Coming Soon';
    $faq= isset($cf_value['faq-tab']) ? $cf_value['faq-tab'][0] : 'Coming Soon';
    if ($showCustom= (isset($cf_value['cf_custom_tabs']))&&($cf_value['cf_custom_tabs'][0]==='yes')) { ?>
        <div class="row tabs-section">
            <div class="small-24 column">
                <div class="border-wrap">
                    <div class="row">
                        <div class="small-24 columns">
                            <ul class="tabs" data-tabs id="custom-tabs">
                              <?php if((isset($cf_value['description-tab']))&&($cf_value['description-tab']!='')) { ?><li class="tabs-title is-active"><a href="#description-panel">Description</a></li> <?php } ?>
                              <?php if((isset($cf_value['suppfacts-tab']))&&($cf_value['suppfacts-tab']!='')) { ?><li class="tabs-title"><a href="#suppfacts-panel">Supplement Facts</a></li> <?php } ?>
                              <?php if((isset($cf_value['faq-tab']))&&($cf_value['faq-tab']!='')) { ?><li class="tabs-title"><a href="#faq-panel">FAQ</a></li> <?php } ?>
                            </ul>
                        </div> <!-- / .small-24 columns -->                
                    </div> <!-- / .row --> 
                </div>
                <div class="tabs-content" data-tabs-content="custom-tabs">
                    <div class="content is-active tabs-panel" id="description-panel">
                        <div class="row">
                            <div class="small-24 columns">
                                <?php echo do_shortcode($description); ?> 
                            </div> <!-- / .small-24 columns -->
                        </div> <!-- / .row -->  
                    </div>
                    <div class="content tabs-panel" id="suppfacts-panel">
                        <div class="row">
                            <div class="small-24 columns">
                                <?php echo do_shortcode($suppfacts); ?> 
                            </div> <!-- / .small-24 columns -->
                        </div> <!-- / .row -->
                    </div>
                    <div class="content tabs-panel" id="faq-panel">
                        <div class="row">
                            <div class="small-24 columns">
                                <?php echo do_shortcode($faq); ?> 
                            </div> <!-- / .small-24 columns -->
                        </div> <!-- / .row -->
                    </div>
                </div>
            </div> <!-- / .small-24 column -->
        </div> <!-- / .row tabs -->
        
    <?php } ?>
    <?php endif;
}
add_action('before_review_content', 'render_custom_product_banner', 10);
