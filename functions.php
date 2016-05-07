<?php

// Faster than @import and stable http://getbootstrap.com/getting-started/#support-ie8-respondjs
add_action( 'wp_enqueue_scripts', 'wpbss_import_base_style', 22 );
function wpbss_import_base_style() {
    wp_enqueue_style( 'parent-theme-css', get_template_directory_uri() . '/style.css' );
}

add_action( 'after_setup_theme', 'register_thumbnail_size');
function register_thumbnail_size() {
	if ( function_exists( 'add_image_size' ) ) {
		add_image_size( 'film-thumbnails', 300, 300); 

	}
}


add_shortcode('recent_films', 'recent_films_shortcode'); 
function recent_films_shortcode( $atts ) {
	extract ( shortcode_atts( array(
		'quantity' => 5,
		), $atts ) );
	
	$args = array(
		'numberposts' => $quantity,
		'post_type'   => 'films',
		'post_status' => 'publish',
		'orderby'     => 'post_date',
		'order'       => 'DESC',
	); 
	$posts = get_posts($args);
	
	ob_start();
	?>
	<ul>
	<?php
	foreach ( $posts as $post ) {
		?>
		<li><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></li>
		<?php
	}
	?>
	</ul>
	<?php
	
	return ob_get_clean(); 
}

