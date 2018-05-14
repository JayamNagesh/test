<?php
/**
 * About configuration
 *
 * @package X_Business
 */

$config = array(
	'menu_name' => esc_html__( 'About X Business', 'x-business' ),
	'page_name' => esc_html__( 'About X Business', 'x-business' ),

	/* translators: theme version */
	'welcome_title' => sprintf( esc_html__( 'Welcome to %s - ', 'x-business' ), 'X Business' ),

	/* translators: 1: theme name */
	'welcome_content' => sprintf( esc_html__( 'We hope this page will help you to setup %1$s with few clicks. We believe you will find it easy to use and perfect for your website development.', 'x-business' ), 'X Business' ),

	// Quick links.
	'quick_links' => array(
		'theme_url' => array(
			'text' => esc_html__( 'Theme Details','x-business' ),
			'url'  => 'https://promenadethemes.com/downloads/x-business/',
			),
		'demo_url' => array(
			'text' => esc_html__( 'View Demo','x-business' ),
			'url'  => 'https://promenadethemes.com/demo/x-business/',
			),
		'documentation_url' => array(
			'text'   => esc_html__( 'View Documentation','x-business' ),
			'url'    => 'https://promenadethemes.com/documentation/x-business/',
			'button' => 'primary',
			),
		'rate_url' => array(
			'text' => esc_html__( 'Rate This Theme','x-business' ),
			'url'  => 'https://wordpress.org/support/theme/x-business/reviews/',
			),
		),

	// Tabs.
	'tabs' => array(
		'getting_started'     => esc_html__( 'Getting Started', 'x-business' ),
		'recommended_actions' => esc_html__( 'Recommended Actions', 'x-business' ),
		'support'             => esc_html__( 'Support', 'x-business' ),
	),

	// Getting started.
	'getting_started' => array(
		array(
			'title'               => esc_html__( 'Theme Documentation', 'x-business' ),
			'text'                => esc_html__( 'Find step by step instructions with video documentation to setup theme easily.', 'x-business' ),
			'button_label'        => esc_html__( 'View documentation', 'x-business' ),
			'button_link'         => 'https://promenadethemes.com/documentation/x-business/',
			'is_button'           => false,
			'recommended_actions' => false,
			'is_new_tab'          => true,
		),
		array(
			'title'               => esc_html__( 'Recommended Actions', 'x-business' ),
			'text'                => esc_html__( 'We recommend few steps to take so that you can get complete site like shown in demo.', 'x-business' ),
			'button_label'        => esc_html__( 'Check recommended actions', 'x-business' ),
			'button_link'         => esc_url( admin_url( 'themes.php?page=x-business-about&tab=recommended_actions' ) ),
			'is_button'           => false,
			'recommended_actions' => false,
			'is_new_tab'          => false,
		),
		array(
			'title'               => esc_html__( 'Customize Everything', 'x-business' ),
			'text'                => esc_html__( 'Start customizing every aspect of the website with customizer.', 'x-business' ),
			'button_label'        => esc_html__( 'Go to Customizer', 'x-business' ),
			'button_link'         => esc_url( wp_customize_url() ),
			'is_button'           => true,
			'recommended_actions' => false,
			'is_new_tab'          => false,
		),
	),

	// Recommended actions.
	'recommended_actions' => array(
		'content' => array(
			
			'front-page' => array(
				'title'       => esc_html__( 'Setting Static Front Page','x-business' ),
				'description' => esc_html__( 'Create a new page to display on front page ( Ex: Home ) and assign "Home" template. Select A static page then Front page and Posts page to display front page specific sections. Note: Static page will be set automatically when you import demo content.', 'x-business' ),
				'id'          => 'front-page',
				'check'       => ( 'page' === get_option( 'show_on_front' ) ) ? true : false,
				'help'        => '<a href="' . esc_url( wp_customize_url() ) . '?autofocus[section]=static_front_page" class="button button-secondary">' . esc_html__( 'Static Front Page', 'x-business' ) . '</a>',
			),

			'one-click-demo-import' => array(
				'title'       => esc_html__( 'One Click Demo Import', 'x-business' ),
				'description' => esc_html__( 'Please install the One Click Demo Import plugin to import the demo content. After activation go to Appearance >> Import Demo Data and import it.', 'x-business' ),
				'check'       => class_exists( 'OCDI_Plugin' ),
				'plugin_slug' => 'one-click-demo-import',
				'id'          => 'one-click-demo-import',
			),
		),
	),

	// Support.
	'support_content' => array(
		'first' => array(
			'title'        => esc_html__( 'Contact Support', 'x-business' ),
			'icon'         => 'dashicons dashicons-sos',
			'text'         => esc_html__( 'If you have any problem, feel free to create ticket on our dedicated Support forum.', 'x-business' ),
			'button_label' => esc_html__( 'Contact Support', 'x-business' ),
			'button_link'  => esc_url( 'https://promenadethemes.com/support/item/x-business/' ),
			'is_button'    => true,
			'is_new_tab'   => true,
		),
		'second' => array(
			'title'        => esc_html__( 'Theme Documentation', 'x-business' ),
			'icon'         => 'dashicons dashicons-book-alt',
			'text'         => esc_html__( 'Kindly check our theme documentation for detailed information and video instructions.', 'x-business' ),
			'button_label' => esc_html__( 'View Documentation', 'x-business' ),
			'button_link'  => 'https://promenadethemes.com/documentation/x-business/',
			'is_button'    => false,
			'is_new_tab'   => true,
		),
		'third' => array(
			'title'        => esc_html__( 'Customization Request', 'x-business' ),
			'icon'         => 'dashicons dashicons-admin-tools',
			'text'         => esc_html__( 'We have dedicated team members for theme customization. Feel free to contact us any time if you need any customization service.', 'x-business' ),
			'button_label' => esc_html__( 'Customization Request', 'x-business' ),
			'button_link'  => 'https://promenadethemes.com/contact-us/',
			'is_button'    => false,
			'is_new_tab'   => true,
		),
	),

);
X_Business_About::init( apply_filters( 'x_business_about_filter', $config ) );
