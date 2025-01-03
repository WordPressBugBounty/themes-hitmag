<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package HitMag
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('hitmag-single'); ?>>

	<?php do_action( 'hitmag_inside_single_top' ); ?>
	
	<?php do_action( 'hitmag_before_entry_header' ); ?>

	<header class="entry-header">
		<?php

			hitmag_category_list();

			the_title( '<h1 class="entry-title">', '</h1>' );

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php hitmag_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

	</header><!-- .entry-header -->
	
	<?php hitmag_single_post_thumbnail(); ?>

	<?php do_action( 'hitmag_before_single_post_content' ); ?>

	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'hitmag' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'hitmag' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php do_action( 'hitmag_after_single_post_content' ); ?>

	<footer class="entry-footer">
		<?php 
			hitmag_entry_footer(); 
		?>
	</footer><!-- .entry-footer -->

	<?php do_action( 'hitmag_inside_single_bottom' ); ?>

</article><!-- #post-## -->