<div class="title-bar" data-responsive-toggle="site-navigation" data-hide-for="large">
	<section class="left-small">
		<button class="menu-icon" type="button" data-toggle="mobile-menu"></button>
	</section> <!-- / .left-small -->
	
	<div class="title-bar-title">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php
           $url = home_url();
           $options = get_option('theme_options');
            if ( !empty( $options['logo']) ) {    
                $content = "<div class=\"logo\">";
                $content .= "<a href=\"" . $url . "\">";
                $content .= "<img src=\"" . do_shortcode('[upload_dir]') .$options['logo'] . "\" />";
                $content .= "</a>";
                $content .= "</div>";
                echo $content;
            } 
            
        ?></a>
	</div>
</div>
<nav id="site-navigation" class="main-navigation title-bar" role="navigation" data-hide-for="large">
	<div class="row column">
		<div class="top-bar-left">
			<ul class="menu">
				<li class="home"><?php
           $url = home_url();
           $options = get_option('theme_options');
            if ( !empty( $options['logo']) ) {    
                $content = "<div class=\"logo\">";
                $content .= "<a href=\"" . $url . "\">";
                $content .= "<img src=\"" . do_shortcode('[upload_dir]') .$options['logo'] . "\" />";
                $content .= "</a>";
                $content .= "</div>";
                echo $content;
            } 
            
        ?></li>
			</ul>
		</div>
		<div class="top-bar-right">
			<?php foundationpress_top_bar_r(); ?>

			<?php if ( ! get_theme_mod( 'wpt_mobile_menu_layout' ) || get_theme_mod( 'wpt_mobile_menu_layout' ) == 'topbar' ) : ?>
				<?php get_template_part( 'template-parts/mobile-top-bar' ); ?>
			<?php endif; ?>
		</div>
	</div> <!-- / .row column -->
</nav>