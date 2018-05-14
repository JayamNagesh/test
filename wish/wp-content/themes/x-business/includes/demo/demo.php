<?php
/**
 * Demo configuration
 *
 * @package X_Business
 */

$config = array(
	'static_page'    => 'home',
	'posts_page'     => 'blog',
	'menu_locations' => array(
		'top'  	  => 'top-menu',
		'primary' => 'main-menu',
		'social'  => 'social-menu',
	),
	'ocdi'           => array(
		array(
			'import_file_name'             => esc_html__( 'Theme Demo Content', 'x-business' ),
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'includes/demo/demo-content/content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'includes/demo/demo-content/widget.wie',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'includes/demo/demo-content/customizer.dat',
		),
	),
);

X_Business_Demo::init( apply_filters( 'x_business_demo_filter', $config ) );
