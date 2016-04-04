<?php
function add_optimizely() {
	$options = get_option('theme_options');
	echo "<script src=\"//cdn.optimizely.com/js/" . $options['optimizelyID'] . ".js\"></script>\n";
}
add_action('wp_head', 'add_optimizely', 2);