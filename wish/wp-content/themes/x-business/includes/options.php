<?php
/**
 * Options.
 *
 * @package X_Business
 */

class X_Business_Info extends WP_Customize_Control {
    public $type = 'info';
    public $label = '';
    public function render_content() {
    ?>
        <h2><?php echo esc_html( $this->label ); ?></h2>
    <?php
    }
}

$default = x_business_get_default_theme_options();

//Logo Options Setting Starts
$wp_customize->add_setting('site_identity', array(
	'default' 			=> $default['site_identity'],
	'sanitize_callback' => 'x_business_sanitize_select'
	));

$wp_customize->add_control('site_identity', array(
	'type' 		=> 'radio',
	'label' 	=> esc_html__('Logo Options', 'x-business'),
	'section' 	=> 'title_tagline',
	'choices' 	=> array(
		'logo-only' 	=> esc_html__('Logo Only', 'x-business'),
		'title-text' 	=> esc_html__('Title + Tagline', 'x-business'),
		'logo-desc' 	=> esc_html__('Logo + Tagline', 'x-business')
		)
));

// Add Theme Options Panel.
$wp_customize->add_panel( 'theme_option_panel',
	array(
		'title'      => esc_html__( 'Theme Options', 'x-business' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
	)
);

// Header Section.
$wp_customize->add_section( 'section_header',
	array(
		'title'      => esc_html__( 'Top Header Options', 'x-business' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting show_top_header.
$wp_customize->add_setting( 'show_top_header',
	array(
		'default'           => $default['show_top_header'],
		'sanitize_callback' => 'x_business_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'show_top_header',
	array(
		'label'    			=> esc_html__( 'Show Top Header', 'x-business' ),
		'section'  			=> 'section_header',
		'type'     			=> 'checkbox',
		'priority' 			=> 100,
	)
);

// Setting Address.
$wp_customize->add_setting( 'top_address',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'top_address',
	array(
		'label'    			=> esc_html__( 'Address/Location', 'x-business' ),
		'section'  			=> 'section_header',
		'type'     			=> 'text',
		'priority' 			=> 100,
		'active_callback' 	=> 'x_business_is_top_header_active',
	)
);

// Setting Phone.
$wp_customize->add_setting( 'top_phone',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'top_phone',
	array(
		'label'    			=> esc_html__( 'Phone Number', 'x-business' ),
		'section'  			=> 'section_header',
		'type'     			=> 'text',
		'priority' 			=> 100,
		'active_callback' 	=> 'x_business_is_top_header_active',
	)
);

// Setting Email.
$wp_customize->add_setting( 'top_email',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'top_email',
	array(
		'label'    			=> esc_html__( 'Email', 'x-business' ),
		'section'  			=> 'section_header',
		'type'     			=> 'text',
		'priority' 			=> 100,
		'active_callback' 	=> 'x_business_is_top_header_active',
	)
);

// Setting top right header.
$wp_customize->add_setting( 'right_section',
	array(
		'default'           => $default['right_section'],
		'sanitize_callback' => 'x_business_sanitize_select',
	)
);
$wp_customize->add_control( 'right_section',
	array(
		'label'    			=> esc_html__( 'Top Header Right Section', 'x-business' ),
		'section'  			=> 'section_header',
		'type'     			=> 'radio',
		'priority' 			=> 100,
		'choices'  			=> array(
								'top-social' => esc_html__( 'Social Links', 'x-business' ),
								'top-menu'  => esc_html__( 'Menu', 'x-business' ),
							),
		'active_callback' 	=> 'x_business_is_top_header_active',
	)
);

// Layout Section.
$wp_customize->add_section( 'section_layout',
	array(
		'title'      => esc_html__( 'Layout Options', 'x-business' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting global_layout.
$wp_customize->add_setting( 'global_layout',
	array(
		'default'           => $default['global_layout'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'x_business_sanitize_select',
	)
);
$wp_customize->add_control( 'global_layout',
	array(
		'label'    => esc_html__( 'Global Layout', 'x-business' ),
		'section'  => 'section_layout',
		'type'     => 'radio',
		'priority' => 100,
		'choices'  => array(
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'x-business' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'x-business' ),
				'no-sidebar'    => esc_html__( 'No Sidebar', 'x-business' ),
			),
	)
);

// Setting excerpt_length.
$wp_customize->add_setting( 'excerpt_length',
	array(
		'default'           => $default['excerpt_length'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'x_business_sanitize_positive_integer',
	)
);
$wp_customize->add_control( 'excerpt_length',
	array(
		'label'       => esc_html__( 'Excerpt Length', 'x-business' ),
		'description' => esc_html__( 'in words', 'x-business' ),
		'section'     => 'section_layout',
		'type'        => 'number',
		'priority'    => 100,
		'input_attrs' => array( 'min' => 1, 'max' => 200, 'style' => 'width: 55px;' ),
	)
);

// Setting readmore_text.
$wp_customize->add_setting( 'readmore_text',
	array(
		'default'           => $default['readmore_text'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'readmore_text',
	array(
		'label'    => esc_html__( 'Read More Text', 'x-business' ),
		'section'  => 'section_layout',
		'type'     => 'text',
		'priority' => 100,
	)
);

// Footer Section.
$wp_customize->add_section( 'section_footer',
	array(
		'title'      => esc_html__( 'Footer Options', 'x-business' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting copyright_text.
$wp_customize->add_setting( 'copyright_text',
	array(
		'default'           => $default['copyright_text'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'copyright_text',
	array(
		'label'    => esc_html__( 'Copyright Text', 'x-business' ),
		'section'  => 'section_footer',
		'type'     => 'text',
		'priority' => 100,
	)
);

// Breadcrumb Section.
$wp_customize->add_section( 'section_breadcrumb',
	array(
		'title'      => esc_html__( 'Breadcrumb Options', 'x-business' ),
		'priority'   => 100,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);

// Setting breadcrumb_type.
$wp_customize->add_setting( 'breadcrumb_type',
	array(
		'default'           => $default['breadcrumb_type'],
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'x_business_sanitize_select',
	)
);
$wp_customize->add_control( 'breadcrumb_type',
	array(
		'label'       => esc_html__( 'Breadcrumb Type', 'x-business' ),
		'section'     => 'section_breadcrumb',
		'type'        => 'radio',
		'priority'    => 100,
		'choices'     => array(
			'disable' => esc_html__( 'Disable', 'x-business' ),
			'simple'  => esc_html__( 'Simple', 'x-business' ),
		),
	)
);

// Add Slider Options Panel.
$wp_customize->add_panel( 'slider_option_panel',
	array(
		'title'      => esc_html__( 'Featured Slider Options', 'x-business' ),
		'priority'   => 100,
	)
);

// Slider Section.
$wp_customize->add_section( 'section_slider',
	array(
		'title'      => esc_html__( 'Slider On/Off', 'x-business' ),
		'panel'      => 'slider_option_panel',
	)
);

// Setting slider_status.
$wp_customize->add_setting( 'slider_status',
	array(
		'default'           => $default['slider_status'],
		'sanitize_callback' => 'x_business_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'slider_status',
	array(
		'label'    			=> esc_html__( 'Enable Slider', 'x-business' ),
		'section'  			=> 'section_slider',
		'type'     			=> 'checkbox',
		'priority' 			=> 100,
	)
);

$slider_number = 5;

for ( $i = 1; $i <= $slider_number; $i++ ) {

	$wp_customize->add_setting( "slider_page_$i",
		array(
			'sanitize_callback' => 'x_business_sanitize_dropdown_pages',
		)
	);
	$wp_customize->add_control( "slider_page_$i",
		array(
			'label'           => esc_html__( 'Slide ', 'x-business' ) . ' - ' . $i,
			'section'         => 'section_slider',
			'type'            => 'dropdown-pages',
			'active_callback' => 'x_business_is_featured_slider_active',
			'priority' 		  => 100,
		)
	); 

}

// Slider Options Section.
$wp_customize->add_section( 'section_slider_options',
	array(
		'title'      => esc_html__( 'Slider Effects Setting', 'x-business' ),
		'panel'      => 'slider_option_panel',
	)
);

// Setting slider_transition_effect.
$wp_customize->add_setting( 'slider_transition_effect',
	array(
		'default'           => $default['slider_transition_effect'],
		'sanitize_callback' => 'x_business_sanitize_select',
	)
);
$wp_customize->add_control( 'slider_transition_effect',
	array(
		'label'           => esc_html__( 'Transition Effect', 'x-business' ),
		'section'         => 'section_slider_options',
		'type'            => 'select',
		'choices'         => array(
			'fade'       => esc_html__( 'fade', 'x-business' ),
			'fadeout'    => esc_html__( 'fadeout', 'x-business' ),
			'none'       => esc_html__( 'none', 'x-business' ),
			'scrollHorz' => esc_html__( 'scrollHorz', 'x-business' ),
		),
	)
);

// Setting slider_transition_delay.
$wp_customize->add_setting( 'slider_transition_delay',
	array(
		'default'           => $default['slider_transition_delay'],
		'sanitize_callback' => 'x_business_sanitize_positive_integer',
	)
);
$wp_customize->add_control( 'slider_transition_delay',
	array(
		'label'           => esc_html__( 'Transition Delay', 'x-business' ),
		'description'     => esc_html__( 'in seconds', 'x-business' ),
		'section'         => 'section_slider_options',
		'type'            => 'number',
		'input_attrs'     => array( 'min' => 1, 'max' => 5, 'step' => 1, 'style' => 'width: 60px;' ),
	)
);

// Setting slider_transition_duration.
$wp_customize->add_setting( 'slider_transition_duration',
	array(
		'default'           => $default['slider_transition_duration'],
		'sanitize_callback' => 'x_business_sanitize_positive_integer',
	)
);
$wp_customize->add_control( 'slider_transition_duration',
	array(
		'label'           => esc_html__( 'Transition Duration', 'x-business' ),
		'description'     => esc_html__( 'in seconds', 'x-business' ),
		'section'         => 'section_slider_options',
		'type'            => 'number',
		'input_attrs'     => array( 'min' => 1, 'max' => 10, 'step' => 1, 'style' => 'width: 60px;' ),
	)
);

// Slider Element Section.
$wp_customize->add_section( 'section_slider_elements',
	array(
		'title'      => esc_html__( 'Slider Elements On/Off', 'x-business' ),
		'panel'      => 'slider_option_panel',
	)
);

// Setting slider_caption_status.
$wp_customize->add_setting( 'slider_caption_status',
	array(
		'default'           => $default['slider_caption_status'],
		'sanitize_callback' => 'x_business_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'slider_caption_status',
	array(
		'label'           => esc_html__( 'Show Caption/Description', 'x-business' ),
		'section'         => 'section_slider_elements',
		'type'            => 'checkbox',
	)
);

// Setting slider_arrow_status.
$wp_customize->add_setting( 'slider_arrow_status',
	array(
		'default'           => $default['slider_arrow_status'],
		'sanitize_callback' => 'x_business_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'slider_arrow_status',
	array(
		'label'           => esc_html__( 'Show Arrow', 'x-business' ),
		'section'         => 'section_slider_elements',
		'type'            => 'checkbox',
	)
);

// Setting slider_pager_status.
$wp_customize->add_setting( 'slider_pager_status',
	array(
		'default'           => $default['slider_pager_status'],
		'sanitize_callback' => 'x_business_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'slider_pager_status',
	array(
		'label'           => esc_html__( 'Show Pager', 'x-business' ),
		'section'         => 'section_slider_elements',
		'type'            => 'checkbox',
	)
);

// Setting slider_autoplay_status.
$wp_customize->add_setting( 'slider_autoplay_status',
	array(
		'default'           => $default['slider_autoplay_status'],
		'sanitize_callback' => 'x_business_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'slider_autoplay_status',
	array(
		'label'           => esc_html__( 'Enable Autoplay', 'x-business' ),
		'section'         => 'section_slider_elements',
		'type'            => 'checkbox',
	)
);

// Setting slider_overlay_status.
$wp_customize->add_setting( 'slider_overlay_status',
	array(
		'default'           => $default['slider_overlay_status'],
		'sanitize_callback' => 'x_business_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'slider_overlay_status',
	array(
		'label'           => esc_html__( 'Enable Overlay', 'x-business' ),
		'section'         => 'section_slider_elements',
		'type'            => 'checkbox',
	)
);

// Setting slider excerpt_length.
$wp_customize->add_setting( 'slider_excerpt_length',
	array(
		'default'           => $default['slider_excerpt_length'],
		'sanitize_callback' => 'x_business_sanitize_positive_integer',
	)
);
$wp_customize->add_control( 'slider_excerpt_length',
	array(
		'label'       => esc_html__( 'Slide Caption/Description Length', 'x-business' ),
		'section'     => 'section_slider_elements',
		'type'        => 'number',
		'input_attrs' => array( 'min' => 1, 'max' => 50, 'style' => 'width: 55px;' ),
		'priority' 	  => 100,
	)
);

// Setting slider_readmore_status.
$wp_customize->add_setting( 'slider_readmore_status',
	array(
		'default'           => $default['slider_readmore_status'],
		'sanitize_callback' => 'x_business_sanitize_checkbox',
	)
);
$wp_customize->add_control( 'slider_readmore_status',
	array(
		'label'           => esc_html__( 'Enable Readmore Button', 'x-business' ),
		'section'         => 'section_slider_elements',
		'type'            => 'checkbox',
		'priority' 		  => 100,
	)
);

// Setting slider readmore text.
$wp_customize->add_setting( 'slider_readmore_text',
	array(
		'default'           => $default['slider_readmore_text'],
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'slider_readmore_text',
	array(
		'label'    => esc_html__( 'Read More Text', 'x-business' ),
		'section'  => 'section_slider_elements',
		'type'     => 'text',
		'priority' => 100,
		'active_callback' 	=> 'x_business_is_slider_readmore_text_active',
	)
);