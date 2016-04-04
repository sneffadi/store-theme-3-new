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

<div class="row">
<!-- Row for main content area -->
	<div class="small-24 medium-24 columns" role="main">
<?php if ( have_posts() ) :
	$options = get_option('theme_options');
	$num = !empty($options['ratings']) ? $options['ratings'] : "100";
	echo "<h4>All Products</h4>";	
	echo "<div id=\"product_list\">";
	query_posts($query_string . '&orderby=title&order=ASC');
	while ( have_posts() ) :
		the_post(); ?>
		<div class="small-24 medium-8 columns">
		<?php
			echo "<a href=\"" . get_permalink($post->ID) . "\">";
			echo $post->post_title;
			echo "<figure>";
            echo "<a href=\"" . get_the_permalink($post->ID) . "\">";
            echo get_the_post_thumbnail($post->ID);
            echo "</a>";
            echo "</figure>";
			echo "</a>"; ?>
			<div class="star-positioner">
	            <div class="stars">
	                <div class="colorbar" style="width:<?php echo get_post_meta($id, 'ratings-overall-value', true) * 20; ?>%">                                                    
	                </div> <!-- / .colorbar -->
	                <div class="star_holder">
	                    <div class="star star-1"></div> <!-- / .star -->
	                    <div class="star star-2"></div> <!-- / .star -->
	                    <div class="star star-3"></div> <!-- / .star -->
	                    <div class="star star-4"></div> <!-- / .star -->
	                    <div class="star star-5"></div> <!-- / .star -->
	               </div> <!-- / .star_holder -->
	            </div> <!-- / .stars -->
	        </div> <!-- / .star-positioner -->
         <?php $cf_value= get_post_meta($post->ID);
        $showCustom= (isset($cf_value['cf_custom_banner']))&&($cf_value['cf_custom_banner'][0]==='yes');
        if($showCustom) $retail= get_post_meta($id, "cf_retail_price", true);
        else $retail= get_post_meta($id, "retail_c1", true);
        echo number_format ( get_post_meta($id, "ratings-overall-value", true), 1 ). "/" . $num; ?>
	        <div class="msrp">Retail: <?php echo "$" . number_format( $retail, 2 ); ?></div>
	        <div class="our-price">Our Price:
        <?php $pricing = array();
        if($showCustom) {
	        $p1 = ( get_post_meta($id, "cf_store_price_one", true));
	        $p2 = ( get_post_meta($id, "cf_store_price_two", true));
	        $p3 = ( get_post_meta($id, "cf_store_price_three", true));
        } else {
        	$qty= get_post_meta($id, "qty_c1", true);
	        if(($qty===FALSE)||($qty==='')) $qty= 1;
	        $p1 = ( get_post_meta($id, "price_c1", true) / $qty );
			$qty= get_post_meta($id, "qty_c2", true);
	        if(($qty===FALSE)||($qty==='')) $qty= 1;
	        $p2 = ( get_post_meta($id, "price_c2", true) / $qty );
	        $qty= get_post_meta($id, "qty_c3", true);
	        if(($qty===FALSE)||($qty==='')) $qty= 1;
	        $p3 = ( get_post_meta($id, "price_c3", true) / $qty );
        }
        array_push($pricing, $p1, $p2, $p3 );
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
            echo "<a href=\"" . get_the_permalink($id) . "\">" . "$" . $price . "</a>"; 
        } ?>
        	</div>
	    </div><!-- /. small-24 medium-6 columns -->
	<?php endwhile; ?>
	</div>
<?php else :
	get_template_part( 'content', 'none' );
endif; // End have_posts() check.
/* Display navigation to next/previous pages when applicable */ ?>
<?php if ( function_exists( 'foundationpress_pagination' ) ) { foundationpress_pagination(); } else if ( is_paged() ) { ?>
	<nav id="post-nav">
		<div class="post-previous"><?php next_posts_link( __( '&larr; Older posts', 'foundationpress' ) ); ?></div>
		<div class="post-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'foundationpress' ) ); ?></div>
	</nav>
<?php } ?>
</div>
<?php get_sidebar(); ?>
</div> <!--What is this for?-->
<?php get_footer(); ?>
