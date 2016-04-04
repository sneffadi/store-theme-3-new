<?php
function add_google_analytics() {
	$options = get_option('theme_options');
	$ga = "<script>\n\t";
	$ga .= "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){\n\t";
	$ga .= "(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\n\t";
	$ga .= "m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\n\t";
	$ga .= "})(window,document,'script','//www.google-analytics.com/analytics.js','ga');\n\t";
	$ga .= "ga('create', '" . $options['gaID'] . "', 'auto');\n\t";
	if (!empty( $add_google_analytics['optimizelyID'] )) {
		$ga .= "window.optimizely = window.optimizely || [];\n\t";
		$ga .= "window.optimizely.push(\"activateUniversalAnalytics\");\n\t";
	}
	$ga .= "ga('send', 'pageview');\n";
	$ga .= "</script>\n";
	echo $ga;
}
add_action('wp_head', 'add_google_analytics');