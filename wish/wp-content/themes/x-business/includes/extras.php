<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package X_Business
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function x_business_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class for global layout.
	$global_layout = x_business_get_option( 'global_layout' );
	$global_layout = apply_filters( 'x_business_filter_theme_global_layout', $global_layout );
	$classes[] = 'global-layout-' . esc_attr( $global_layout );

	return $classes;
}
add_filter( 'body_class', 'x_business_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function x_business_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'x_business_pingback_header' );

if ( ! function_exists( 'x_business_the_custom_logo' ) ) :

	/**
	 * Displays custom logo.
	 *
	 * @since 1.0.0
	 */
	function x_business_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
endif;


if ( ! function_exists( 'x_business_footer_goto_top' ) ) :

	/**
	 * Add Go to top.
	 *
	 * @since 1.0.0
	 */
	function x_business_footer_goto_top() {
		echo '<a href="#page" class="scrollup" id="btn-scrollup"><i class="fa fa-angle-up"></i></a>';
	}
endif;
add_action( 'wp_footer', 'x_business_footer_goto_top' );

if ( ! function_exists( 'x_business_implement_excerpt_length' ) ) :

	/**
	 * Implement excerpt length.
	 *
	 * @since 1.0.0
	 *
	 * @param int $length The number of words.
	 * @return int Excerpt length.
	 */
	function x_business_implement_excerpt_length( $length ) {

		$excerpt_length = x_business_get_option( 'excerpt_length' );
		
		if ( absint( $excerpt_length ) > 0 ) {

			$length = absint( $excerpt_length );

		}

		return $length;

	}
endif;

if ( ! function_exists( 'x_business_content_more_link' ) ) :

	/**
	 * Implement read more in content.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more_link Read More link element.
	 * @param string $more_link_text Read More text.
	 * @return string Link.
	 */
	function x_business_content_more_link( $more_link, $more_link_text ) {

		$read_more_text = x_business_get_option( 'readmore_text' );
		if ( ! empty( $read_more_text ) ) {
			$more_link = str_replace( $more_link_text, esc_html( $read_more_text ), $more_link );
		}
		return $more_link;

	}

endif;

if ( ! function_exists( 'x_business_implement_read_more' ) ) :

	/**
	 * Implement read more in excerpt.
	 *
	 * @since 1.0.0
	 *
	 * @param string $more The string shown within the more link.
	 * @return string The excerpt.
	 */
	function x_business_implement_read_more( $more ) {

		$output = $more;

		$read_more_text = x_business_get_option( 'readmore_text' );

		if ( ! empty( $read_more_text ) ) {

			$output = '&hellip;<p><a href="' . esc_url( get_permalink() ) . '" class="button btn-continue">' . esc_html( $read_more_text ) . '</a></p>';

		}

		return $output;

	}
endif;

if ( ! function_exists( 'x_business_hook_read_more_filters' ) ) :

	/**
	 * Hook read more and excerpt length filters.
	 *
	 * @since 1.0.0
	 */
	function x_business_hook_read_more_filters() {
		if ( is_home() || is_category() || is_tag() || is_author() || is_date() || is_search() ) {

			add_filter( 'excerpt_length', 'x_business_implement_excerpt_length', 999 );
			add_filter( 'the_content_more_link', 'x_business_content_more_link', 10, 2 );
			add_filter( 'excerpt_more', 'x_business_implement_read_more' );

		}
	}
endif;
add_action( 'wp', 'x_business_hook_read_more_filters' );

if ( ! function_exists( 'x_business_add_sidebar' ) ) :

	/**
	 * Add sidebar.
	 *
	 * @since 1.0.0
	 */
	function x_business_add_sidebar() {

		$global_layout = x_business_get_option( 'global_layout' );
		$global_layout = apply_filters( 'x_business_filter_theme_global_layout', $global_layout );

		// Include sidebar.
		if ( 'no-sidebar' !== $global_layout ) {
			get_sidebar();
		}

	}
endif;
add_action( 'x_business_action_sidebar', 'x_business_add_sidebar' );