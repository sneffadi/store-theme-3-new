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
		                <?php foundationpress_top_bar_r(); ?>
		                <script src="https://cdn.ywxi.net/js/inline.js?w=90"></script>
		            </section>
		        </nav>
	            
	        </div> <!-- / .small-12 -->
	    </div> <!-- / .row -->
    </nav>
</div> <!-- / .top-bar-container -->