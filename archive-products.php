<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0
 */

get_header(); ?>
<div class="row"><!-- Row for main content area -->
    <div class="small-24 medium-24 columns" role="main">
<?php $productCount = 1; ?>
<?php if(have_posts()):
    $options= get_option('theme_options');
    $num= !empty($options['ratings']) ? $options['ratings'] : "100";
    echo "<h4>All Products</h4>";
    echo "<div id=\"product_list\">";
    query_posts($query_string.'&orderby=title&order=ASC');
    while(have_posts()):
        the_post(); ?>
        <?php
            if(($productCount % 3) == 1){
                echo "<div class=\"row collapse\">";
            }
        ?>

        <div class="small-24 medium-8 columns small-text-center product_listing">
        <?php echo "<a href=\"" . get_permalink($post->ID)."\" class=\"product_name\">";
        echo $post->post_title;
        echo "<figure>";
        echo "<a href=\"" . get_the_permalink($post->ID) . "\">";
        echo get_the_post_thumbnail($post->ID);
        echo "</a>";
        echo "</figure>";
        echo "</a>";
        $starsWidth= get_post_meta($post->ID, 'ratings-overall-value', true)*20;?>
            <div class="star-positioner">
                <div class="stars">
                    <div class="colorbar" style="width:<?php echo $starsWidth;?>%"></div>
                    <div class="star_holder">
                        <div class="star star-1"></div> <!-- / .star -->
                        <div class="star star-2"></div> <!-- / .star -->
                        <div class="star star-3"></div> <!-- / .star -->
                        <div class="star star-4"></div> <!-- / .star -->
                        <div class="star star-5"></div> <!-- / .star -->
                   </div> <!-- / .star_holder -->
                </div> <!-- / .stars -->
            </div> <!-- / .star-positioner -->
        <?php echo number_format(get_post_meta($post->ID, "ratings-overall-value", true), 1)."/".$num;
        $cf_value= get_post_meta($post->ID);
        $showCustom= (isset($cf_value['cf_custom_banner']))&&($cf_value['cf_custom_banner'][0]==='yes');
        if($showCustom) $retail= get_post_meta($post->ID, "cf_retail_price", true);
        else $retail= get_post_meta($post->ID, "retail_c1", true); ?>
            <div class="msrp">
                Retail: <?php echo "$".number_format($retail, 2);?>
            </div>
            <div class="our-price">Our Price:
        <?php if($showCustom) $price= get_post_meta($post->ID, "cf_store_price_one", true);
        else {
            $pricing = array();
            $qty= get_post_meta($post->ID, "qty_c1", true);
            if(($qty===FALSE)||($qty==='')) $qty= 1;
            $p1 = (get_post_meta($post->ID, "price_c1", true)/$qty);
            $qty= get_post_meta($post->ID, "qty_c2", true);
            if(($qty===FALSE)||($qty==='')) $qty= 1;
            $p2 = (get_post_meta($post->ID, "price_c2", true)/$qty);
            $qty= get_post_meta($post->ID, "qty_c3", true);
            if(($qty===FALSE)||($qty==='')) $qty= 1;
            $p3 = (get_post_meta($post->ID, "price_c3", true)/$qty);
            array_push($pricing, $p1, $p2, $p3);
            $low = min($pricing);
            $high = max($pricing);
            $epsilon = 0.00001;
            if ($low == 0) {
                    $price = number_format($high, 2);
                }
                else {
                  $price= number_format($low, 2);
                if(abs($low-$high)>=$epsilon) $price.= '-'.number_format($high, 2);  
                }
        } ?>
                <a href="<?php echo get_the_permalink($post->ID);?>">$<?php echo $price;?></a>
            </div>
        </div><!-- /. small-24 medium-6 columns -->
        <?php
            if(($productCount % 3) == 0){
                echo "</div><!--/end row-->";
            }
        ?>
        <?php $productCount++; ?>
    <?php endwhile; ?>
    </div>
<?php else:
    get_template_part('content', 'none');
endif; // End have_posts() check.
/* Display navigation to next/previous pages when applicable */ ?>
<?php if(function_exists('foundationpress_pagination')):
    foundationpress_pagination();
elseif(is_paged()):
    ?>
        <nav id="post-nav">
            <div class="post-previous"><?php next_posts_link(__('&larr; Older posts', 'foundationpress'));?></div>
            <div class="post-next"><?php previous_posts_link(__('Newer posts &rarr;', 'foundationpress'));?></div>
        </nav>
<?php endif; ?>
    </div>
</div> <!--What is this for?-->
<?php get_footer(); ?>