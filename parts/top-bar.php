<div class="top-bar-container desktop-menu" data-hide-for="small">
	<nav class="top-bar logo-section">
	    <div class="row collapse">
	        <div class="small-24 medium-18 columns">
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
	        <div class="small-0 medium-6 columns">
	            <span class="cart">
	                <a href="<?php echo do_shortcode('[cart_url]');?>">
	                    <i class="fa fa-shopping-cart"></i> Cart <span id="cartCountWrap">(<span class="pink" id="cartCount"></span>)</span>
	                </a>
	            </span><!--/.cart-->
	            <script src="https://cdn.ywxi.net/js/inline.js?w=90"></script>
	        </div> <!-- / .small-12 -->
	    </div> <!-- / .row -->
    </nav>
    <div id="navWrap">
        <nav class="top-bar nav" data-topbar role="navigation">
            <section class="top-bar-section row">
                <?php foundationpress_top_bar_l(); ?>
            </section>
        </nav>
    </div>
</div> <!-- / .top-bar-container -->