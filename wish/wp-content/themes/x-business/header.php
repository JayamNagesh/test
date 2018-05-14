<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package X_Business
 */

?>
<?php
	/**
	 * Hook - x_business_doctype.
	 *
	 * @hooked x_business_doctype_action - 10
	 */
	do_action( 'x_business_doctype' );
?>
<head>
	<?php
	/**
	 * Hook - x_business_head.
	 *
	 * @hooked x_business_head_action - 10
	 */
	do_action( 'x_business_head' );
	
	wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="page" class="site">
		<?php
		/**
		 * Hook - x_business_top_header.
		 *
		 * @hooked x_business_top_header_action - 10
		 */
		do_action( 'x_business_top_header' );

		/**
		* Hook - winsone_before_header.
		*
		* @hooked x_business_before_header_action - 10
		*/
		do_action( 'x_business_before_header' );

		/**
		* Hook - x_business_header.
		*
		* @hooked x_business_header_action - 10
		*/
		do_action( 'x_business_header' );

		/**
		* Hook - x_business_after_header.
		*
		* @hooked x_business_after_header_action - 10
		*/
		do_action( 'x_business_after_header' );

		/**
		* Hook - x_business_main_content.
		*
		* @hooked x_business_main_content_for_slider - 5
		* @hooked x_business_main_content_for_breadcrumb - 7
		* @hooked x_business_main_content_for_home_widgets - 9
		*/
		do_action( 'x_business_main_content' );

		/**
		* Hook - x_business_before_content.
		*
		* @hooked x_business_before_content_action - 10
		*/
		do_action( 'x_business_before_content' );