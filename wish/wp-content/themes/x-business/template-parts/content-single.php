<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package X_Business
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php x_business_post_thumbnail(); ?>

	<div class="content-wrap">

		<div class="content-wrap-inner">
			
			<header class="entry-header">
				<?php

				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				
				if ( ( 'post' === get_post_type() ) ){ ?>
					<div class="entry-meta">
						<?php x_business_posted_on(); ?>
					</div><!-- .entry-meta -->
					<?php 
				} ?>

			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( esc_html__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'x-business' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'x-business' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php x_business_entry_footer(); ?>
			</footer><!-- .entry-footer -->

		</div>

	</div>

</article><!-- #post-## -->
