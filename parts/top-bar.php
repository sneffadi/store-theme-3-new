<div class="top-bar-container desktop-menu" data-hide-for="small">
	<nav class="top-bar logo-section">
	    <div class="row collapse">
	        <div class="small-24 medium-12 columns">
	                    <?php
	                    $url = home_url();
	                    $options = get_option('theme_options');
	                    if (!empty($options['logo'])) {
	                        $content = "<div class=\"logo\">";
	                            $content.= "<a href=\"" . $url . "\">";
	                            $content.= "<img src=\"" . do_shortcode('[upload_dir]') . $options['logo'] . "\" />";
	                            $content.= "</a>";
	                        $content.= "</div>";
	                    }
	                    else {
	                        $url = home_url();
	                        $content = "<h1><a href=\"" . $url . "\">" . get_bloginfo('name') . "</a></h1>";
	                    }
	                    echo $content;
	                    ?>
	        </div> <!-- / .small-12 -->
	        <div class="small-0 medium-12 columns show-for-medium">
	            <nav class="top-bar nav" data-topbar role="navigation">
		            <section class="top-bar-section row right">
		                <ul class="dropdown menu desktop-menu" data-dropdown-menu>
		                	<li><a href="<?php echo site_url();?>">Home</a></li>
							<li>
						    	<a href="#">Products</a>
						    	<ul class="menu">
						    	<?php
						    		global $post;
						    		$options = get_option('theme_options');
						    		$num = !empty($options['ratings']) ? $options['ratings'] : "100";
						    		$post_type = get_post_type();
						    		$ids = explode(",", get_post_meta($post->ID, "top-products-list", true));
						    		$idsCount = count($ids);
						    		$link = get_permalink($id);

						    		$ids = explode(",", get_post_meta(get_option('page_on_front'), "top-products-list", true));
        							$num = !empty($options['ratings']) ? $options['ratings'] : "100";
        							$image = get_the_post_thumbnail($recId, 'upsell-image', array('class' => 'product-image'));
        							$i = 1;
        							foreach ($ids as $id) {
        								if ($i < 6) { ?>
        								<li><a href="<?php echo get_permalink($id); ?>">
        									<?php 
        									$thisRating= get_post_meta($post->ID, $id.'-ratings-overall-value', TRUE);
	                                    if($thisRating==='') {
	                                        $thisRating= get_post_meta($id, 'ratings-overall-value', TRUE);
	                                        if($thisRating==='') $thisRating= 0;
	                                    }
	                                    $thisRating= number_format(floatval($thisRating), 0);
        									if (has_post_thumbnail($id)) { echo get_the_post_thumbnail($id); }  
        									 
        									echo '<h4>'.get_the_title($id).'</h4>';
        									echo '<div class="nav-rating">'.$thisRating.'/'.$num.'</div>';?>
        								</a></li>
        							<?php 
        								$i++; }
        							}

						    	?>
						    	
						      		<li class="all-prods-nav"><a href="<?php echo site_url();?>/products/">All Products</a></li>
						    	</ul>
						  </li>
						  <li><a href="<?php echo site_url();?>/contact">Contact Us</a></li>
						</ul>
		                <script src="https://cdn.ywxi.net/js/inline.js?w=90"></script>
		            </section>
		        </nav>
	            
	        </div> <!-- / .small-12 -->
	    </div> <!-- / .row -->
    </nav>
</div> <!-- / .top-bar-container -->