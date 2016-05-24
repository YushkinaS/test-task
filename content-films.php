<?php
/**
 * Template part for displaying single posts.
 *
 * @package wpbss
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
        <?php the_post_thumbnail( 'film-thumbnails', array( 'class' => 'img-responsive' )); ?>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
			<?php
			$post_id = get_the_ID();
			$countries = get_the_terms( $post_id , 'country' );
			$genres = get_the_terms( $post_id , 'genre' );
			$fee = get_post_meta( $post_id,'fee',true );
			$release_date = get_post_meta( $post_id,'release_date',true );
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
		
		<?php the_content(); ?>
		

		
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wpbss' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php wpbss_entry_footer(); ?>
        <div class="entry-meta">
			<?php wpbss_posted_on(); ?>
		</div><!-- .entry-meta -->
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

