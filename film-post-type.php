<?php
/*
Plugin Name: Film Post Type
Plugin URI: 
Description: Add a film catalog to your site
Version: 
Author: YushkinaS
Author URI: 
License: 
License URI: 
*/

add_action( 'init', 'fpt_register_post_types' );
add_action( 'init', 'fpt_register_taxonomies' );
add_action( 'init', 'fpt_register_custom_fields' );
add_filter ('the_content', 'fpt_show_films_custom_fields');
add_filter ('the_excerpt', 'fpt_show_films_custom_fields');

function fpt_register_post_types() {
	$labels = array(
		'name' => __('Films'),
		'singular_name' => __('Film'),
		);

	$args = array(
		'labels' => $labels,
		'description' => '',
		'public' => true,
		'show_ui' => true,
		'has_archive' => true,
		'show_in_menu' => true,
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => array( 'slug' => 'films', 'with_front' => true ),
		'query_var' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' )
						
	);
	register_post_type( 'films', $args );
}


function fpt_register_taxonomies() {
	$args = array(
		'hierarchical' => false,
		'label' => __('Genre')
	);
	register_taxonomy( 'genre', array( 'films' ), $args );

	$args = array(
		'hierarchical' => false,
		'label' => __('Country')
	);
	register_taxonomy( 'country', array( 'films' ), $args );
	
		$args = array(
		'hierarchical' => false,
		'label' => __('Year')
	);
	register_taxonomy( 'film-year', array( 'films' ), $args );
	
		$args = array(
		'hierarchical' => false,
		'label' => __('Actors')
	);
	register_taxonomy( 'actors', array( 'films' ), $args );
}


function fpt_register_custom_fields() {
	if(function_exists("register_field_group"))
	{
		register_field_group(array (
			'id' => 'acf_films-fields',
			'title' => 'films fields',
			'fields' => array (
				array (
					'key' => 'field_572d72e6ef600',
					'label' => 'Стоимость сеанса',
					'name' => 'fee',
					'type' => 'number',
					'required' => 1,
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => '',
					'max' => '',
					'step' => '',
				),
				array (
					'key' => 'field_572d7334ef601',
					'label' => 'Дата выхода в прокат',
					'name' => 'release_date',
					'type' => 'date_picker',
					'date_format' => 'dd/mm/yy',
					'display_format' => 'dd/mm/yy',
					'first_day' => 1,
					'required' => 1,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'films',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'no_box',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 0,
		));
	}
}


function fpt_show_films_custom_fields($content) {
	if ( is_archive('films') ) { 
		$post_id = get_the_ID();
		$countries = get_the_terms( $post_id , 'country' );
		$genres = get_the_terms( $post_id , 'genre' );
		$fee = get_post_meta( $post_id,'fee',true );
		$release_date = get_post_meta( $post_id,'release_date',true );
		
		ob_start();
		?>
			<div class="row">
				<div class="col-xs-6">
				<div class="well well-sm">
					<span class="glyphicon glyphicon-globe" title="Страна" data-toggle="tooltip"></span>
					<?php
						foreach ($countries as $country) {
							$country_link=get_term_link($country);
							?>
							<a href="<?php echo $country_link; ?>"><?php echo $country->name; ?></a>
							<?php
	 
						}
						?>
					
				</div>
				</div>
				<div class="col-xs-6">
				<div class="well well-sm">
					<span class="glyphicon glyphicon-tag" title="Жанр" data-toggle="tooltip"></span>
					<?php
						foreach ($genres as $genre) {
							$genre_link=get_term_link($genre);
							?>
							<a href="<?php echo $genre_link; ?>"><?php echo $genre->name; ?></a>
							<?php
	 
						}
						?>
				</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-6">
				<div class="well well-sm">
					<span class="label label-info">Дата выхода</span>
					<span class="glyphicon glyphicon-calendar" title="Дата выхода" data-toggle="tooltip"></span><?php echo $release_date; ?>
				</div>
				</div>
				<div class="col-xs-6">
				<div class="well well-sm">
					<span class="label label-info">Стоимость сеанса</span>
					<span class="glyphicon glyphicon-rub" title="Стоимость сеанса" data-toggle="tooltip"></span><?php echo $fee; ?>
				</div>
				</div>

			</div>
		<?php
		$film_info = ob_get_clean();

		$content .= $film_info;
	}
	return $content;
}
