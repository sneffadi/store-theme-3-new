<?php
add_action('wp_enqueue_scripts', 'add_fonts', 1);


function add_fonts() {

    $option = get_option('theme_options');
    wp_register_script('typekit', '//use.typekit.net/' . $option ['typekit'] . '.js');
    wp_register_style('googlefont', 'http://fonts.googleapis.com/css?family=' . $option ['googlefont']);
    
    if (!empty( $option['typekit'] )) {
        wp_enqueue_script('typekit');
        function typekit_inline() {    
    		$output = "<script type=\"text/javascript\">try{Typekit.load();}catch(e){}</script>";   
    		echo $output;
		}
		add_action('wp_head', 'typekit_inline');
    }
    
    if (!empty( $option ['googlefont'] )) {
        wp_enqueue_style('googlefont');
    }

    if (empty( $option['googlefont'] ) &&  empty( $option['typekit'] ) ) {
        wp_register_style( 'googlefontDefault', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:700,600,400,400italic' );
        wp_enqueue_style('googlefontDefault');
    }

   
}