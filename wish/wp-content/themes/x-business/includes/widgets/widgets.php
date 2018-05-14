<?php
/**
 * Custom widgets.
 *
 * @package X_Business
 */

if ( ! function_exists( 'x_business_load_widgets' ) ) :

	/**
	 * Load widgets.
	 *
	 * @since 1.0.0
	 */
	function x_business_load_widgets() {

		// Social.
		register_widget( 'X_Business_Social_Widget' );

		// Latest news.
		register_widget( 'X_Business_Latest_News_Widget' );

		// CTA widget.
		register_widget( 'X_Business_CTA_Widget' );

		// Advanced recent posts widget.
		register_widget( 'X_Business_Recent_Posts_Widget' );

		// About Us widget.
		register_widget( 'X_Business_About_Widget' );

		// Features widget.
		register_widget( 'X_Business_Features_Widget' );

	}

endif;

add_action( 'widgets_init', 'x_business_load_widgets' );

if ( ! class_exists( 'X_Business_Social_Widget' ) ) :

	/**
	 * Social widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Business_Social_Widget extends WP_Widget {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$opts = array(
				'classname'   => 'x_business_widget_social',
				'description' => esc_html__( 'Social Icons Widget', 'x-business' ),
			);
			parent::__construct( 'x-business-social', esc_html__( 'X-Business: Social', 'x-business' ), $opts );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . esc_html( $title ). $args['after_title'];
			}

			if ( has_nav_menu( 'social' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'social',
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>',
				) );
			}

			echo $args['after_widget'];

		}

		/**
		 * Update widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $new_instance New settings for this instance as input by the user via
		 *                            {@see WP_Widget::form()}.
		 * @param array $old_instance Old settings for this instance.
		 * @return array Settings to save or bool false to cancel saving.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title'] = sanitize_text_field( $new_instance['title'] );

			return $instance;
		}

		/**
		 * Output the settings update form.
		 *
		 * @since 1.0.0
		 *
		 * @param array $instance Current settings.
		 * @return void
		 */
		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, array(
				'title' => '',
			) );
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'x-business' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>

			<?php if ( ! has_nav_menu( 'social' ) ) : ?>
	        <p>
				<?php esc_html_e( 'Social menu is not set. Please create menu and assign it to Social Theme Location.', 'x-business' ); ?>
	        </p>
	        <?php endif; ?>
			<?php
		}
	}

endif;


if ( ! class_exists( 'X_Business_Latest_News_Widget' ) ) :

	/**
	 * Latest News widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Business_Latest_News_Widget extends WP_Widget {

	    function __construct() {
	    	$opts = array(
				'classname'   => 'x_business_widget_latest_news',
				'description' => esc_html__( 'Widget to dispaly latest posts with thumbnail, title, short content and read more link', 'x-business' ),
    		);

			parent::__construct( 'x-business-latest-news', esc_html__( 'X-Business: Latest News', 'x-business' ), $opts );
	    }


	    function widget( $args, $instance ) {

			$title             	= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$sub_title 	 		= !empty( $instance['sub_title'] ) ? $instance['sub_title'] : '';

			$post_category     	= ! empty( $instance['post_category'] ) ? $instance['post_category'] : 0;

			$exclude_categories = !empty( $instance[ 'exclude_categories' ] ) ? esc_attr( $instance[ 'exclude_categories' ] ) : '';

			$excerpt_length		= !empty( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 15;

			$disable_date   	= ! empty( $instance['disable_date'] ) ? $instance['disable_date'] : 0;

	        echo $args['before_widget']; ?>

	        <div class="latest-news-widget latest-news-section">

        		<div class="section-title">

			        <?php 

			        if ( $title ) {
			        	echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
			        }

			        if ( $sub_title ) { ?>

			        	<p><?php echo esc_html( $sub_title ); ?></p>

			        	<?php 
			        	
			        } ?>

		        </div>

		        <div class="blogs-wrapper">

			        <?php

			        $query_args = array(
						        	'posts_per_page' 		=> 3,
						        	'no_found_rows'  		=> true,
						        	'post__not_in'          => get_option( 'sticky_posts' ),
						        	'ignore_sticky_posts'   => true,
					        	);

			        if ( absint( $post_category ) > 0 ) {

			        	$query_args['cat'] = absint( $post_category );
			        	
			        }

			        if ( !empty( $exclude_categories ) ) {

			        	$exclude_ids = explode(',', $exclude_categories);

			        	$query_args['category__not_in'] = $exclude_ids;

			        }

			        $all_posts = new WP_Query( $query_args );

			        if ( $all_posts->have_posts() ) :?>

				        <div class="inner-wrapper">

							<?php 

							$post_count = $all_posts->post_count;

							while ( $all_posts->have_posts() ) :

	                            $all_posts->the_post(); ?>

				                <div class="blog-item">
					                <div class="blog-inner">

						                <?php if ( has_post_thumbnail() ) :  ?>
						                  <div class="blog-thumbnail">
						                    <a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail( 'x-business-common' ); ?>
						                    </a>
						                  </div><!-- .blog-thumbnail -->
						                <?php endif; ?>

						                <?php 
						                if( 1 == $disable_date ){ 

						                	$text_wrap_class = 'date-disabled';

						                }else{

						                	$text_wrap_class = 'date-enabled';

						                }?>

						                <div class="blog-text-wrap <?php echo $text_wrap_class; ?>">

						                	<?php if( 1 != $disable_date ){ ?>

							                	<header class="entry-header">
							                	    <div class="entry-meta">
							                	        <span class="day"><?php echo esc_html( get_the_date('d') ); ?></span>
							                	        <span class="month"><?php echo esc_html( get_the_date('M') ); ?></span>
							                	        
							                	    </div>
							                	</header>

						                	<?php } ?>

						                	<div class="entry-content">
						                	    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						                	    <?php 
						                	    $content = x_business_get_the_excerpt( absint( $excerpt_length ) );
						                	    
						                	    echo $content ? wpautop( wp_kses_post( $content ) ) : '';
						                	    ?>
						                	</div>

						                </div>

					                </div><!-- .blog-inner -->
				                </div><!-- .blog-item --> 

				                <?php 

							endwhile; 

	                        wp_reset_postdata(); ?>

	                    </div>

			        <?php endif; ?>

		        </div>

	        </div><!-- .latest-news-widget -->

	        <?php
	        echo $args['after_widget'];

	    }

	    function update( $new_instance, $old_instance ) {
	        $instance = $old_instance;
			$instance['title']          	= sanitize_text_field( $new_instance['title'] );
			$instance['sub_title'] 		    = sanitize_text_field( $new_instance['sub_title'] );
			$instance['post_category']  	= absint( $new_instance['post_category'] );
			$instance['exclude_categories'] = sanitize_text_field( $new_instance['exclude_categories'] );
			$instance['excerpt_length'] 	= absint( $new_instance['excerpt_length'] );
			$instance['disable_date']    	= (bool) $new_instance['disable_date'] ? 1 : 0;

	        return $instance;
	    }

	    function form( $instance ) {

	        $instance = wp_parse_args( (array) $instance, array(
				'title'          		=> '',
				'sub_title' 			=> '',
				'post_category'  		=> '',
				'exclude_categories' 	=> '',
				'excerpt_length'		=> 15,
				'disable_date'   		=> 0,
	        ) );
	        ?>
	        <p>
	          <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><strong><?php esc_html_e( 'Title:', 'x-business' ); ?></strong></label>
	          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
	        </p>
	        <p>
	        	<label for="<?php echo esc_attr( $this->get_field_id( 'sub_title' ) ); ?>"><strong><?php esc_html_e( 'Sub Title:', 'x-business' ); ?></strong></label>
	        	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'sub_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sub_title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['sub_title'] ); ?>" />
	        </p>
	        <p>
	          <label for="<?php echo  esc_attr( $this->get_field_id( 'post_category' ) ); ?>"><strong><?php esc_html_e( 'Select Category:', 'x-business' ); ?></strong></label>
				<?php
	            $cat_args = array(
	                'orderby'         => 'name',
	                'hide_empty'      => 0,
	                'class' 		  => 'widefat',
	                'taxonomy'        => 'category',
	                'name'            => $this->get_field_name( 'post_category' ),
	                'id'              => $this->get_field_id( 'post_category' ),
	                'selected'        => absint( $instance['post_category'] ),
	                'show_option_all' => esc_html__( 'All Categories','x-business' ),
	              );
	            wp_dropdown_categories( $cat_args );
				?>
	        </p>
            <p>
            	<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_categories' ) ); ?>"><strong><?php esc_html_e( 'Exclude Categories:', 'x-business' ); ?></strong></label>
            	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'exclude_categories' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude_categories' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['exclude_categories'] ); ?>" />
    	        <small>
    	        	<?php esc_html_e('Enter category id seperated with comma. Posts from these categories will be excluded from latest post listing.', 'x-business'); ?>	
    	        </small>
            </p>

            <p>
            	<label for="<?php echo esc_attr( $this->get_field_name('excerpt_length') ); ?>">
            		<?php esc_html_e('Excerpt Length:', 'x-business'); ?>
            	</label>
            	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('excerpt_length') ); ?>" name="<?php echo esc_attr( $this->get_field_name('excerpt_length') ); ?>" type="number" value="<?php echo absint( $instance['excerpt_length'] ); ?>" />
            </p>

	        <p>
	            <input class="checkbox" type="checkbox" <?php checked( $instance['disable_date'] ); ?> id="<?php echo $this->get_field_id( 'disable_date' ); ?>" name="<?php echo $this->get_field_name( 'disable_date' ); ?>" />
	            <label for="<?php echo $this->get_field_id( 'disable_date' ); ?>"><?php esc_html_e( 'Hide Posted Date', 'x-business' ); ?></label>
	        </p>
	        <?php
	    }

	}

endif;

if ( ! class_exists( 'X_Business_CTA_Widget' ) ) :

	/**
	 * CTA widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Business_CTA_Widget extends WP_Widget {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$opts = array(
				'classname'   => 'x_business_widget_call_to_action',
				'description' => esc_html__( 'Call To Action Widget', 'x-business' ),
			);
			parent::__construct( 'x-business-cta', esc_html__( 'X-Business: CTA', 'x-business' ), $opts );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {
			$title       = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$cta_page    = !empty( $instance['cta_page'] ) ? $instance['cta_page'] : ''; 
			$button_text = ! empty( $instance['button_text'] ) ? esc_html( $instance['button_text'] ) : '';
			$button_url  = ! empty( $instance['button_url'] ) ? esc_url( $instance['button_url'] ) : '';
			$secondary_button_text = ! empty( $instance['secondary_button_text'] ) ? esc_html( $instance['secondary_button_text'] ) : '';
			$secondary_button_url  = ! empty( $instance['secondary_button_url'] ) ? esc_url( $instance['secondary_button_url'] ) : '';
			$bg_pic  	 = ! empty( $instance['bg_pic'] ) ? esc_url( $instance['bg_pic'] ) : '';

			// Add background image.
			if ( ! empty( $bg_pic ) ) {
				$background_style = '';
				$background_style .= ' style="background-image:url(' . esc_url( $bg_pic ) . ');" ';
				$args['before_widget'] = implode( $background_style . ' ' . 'class="bg_enabled ', explode( 'class="', $args['before_widget'], 2 ) );
			}else{

				$args['before_widget'] = implode( 'class="bg_disabled ', explode( 'class="', $args['before_widget'], 2 ) );

			}

			echo $args['before_widget']; ?>

			<div class="cta-widget">

				<?php

				if ( ! empty( $title ) ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
				}  

				if ( $cta_page ) { 

					$cta_args = array(
									'posts_per_page' => 1,
									'page_id'	     => absint( $cta_page ),
									'post_type'      => 'page',
									'post_status'  	 => 'publish',
								);

					$cta_query = new WP_Query( $cta_args );	

					if( $cta_query->have_posts()){

						while( $cta_query->have_posts()){

							$cta_query->the_post(); ?>

							<div class="call-to-action-content">
								<?php the_content(); ?>
							</div>

							<?php

						}

						wp_reset_postdata();

					} ?>
					
				<?php } ?>

				<div class="call-to-action-buttons">

					<?php if ( ! empty( $button_text ) ) : ?>
						<a href="<?php echo esc_url( $button_url ); ?>" class="button cta-button cta-button-primary"><?php echo esc_attr( $button_text ); ?></a>
					<?php endif; ?>

					<?php if ( ! empty( $secondary_button_text ) ) : ?>
						<a href="<?php echo esc_url( $secondary_button_url ); ?>" class="button cta-button cta-button-secondary"><?php echo esc_attr( $secondary_button_text ); ?></a>
					<?php endif; ?>

				</div><!-- .call-to-action-buttons -->

			</div><!-- .cta-widget -->

			<?php
			echo $args['after_widget'];

		}

		/**
		 * Update widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $new_instance New settings for this instance as input by the user via
		 *                            {@see WP_Widget::form()}.
		 * @param array $old_instance Old settings for this instance.
		 * @return array Settings to save or bool false to cancel saving.
		 */
		function update( $new_instance, $old_instance ) {

			$instance = $old_instance;

			$instance['title'] 			= sanitize_text_field( $new_instance['title'] );

			$instance['cta_page'] 	 	= absint( $new_instance['cta_page'] );

			$instance['button_text'] 	= sanitize_text_field( $new_instance['button_text'] );
			$instance['button_url']  	= esc_url_raw( $new_instance['button_url'] );

			$instance['secondary_button_text'] 	= sanitize_text_field( $new_instance['secondary_button_text'] );
			$instance['secondary_button_url']  	= esc_url_raw( $new_instance['secondary_button_url'] );

			$instance['bg_pic']  	 	= esc_url_raw( $new_instance['bg_pic'] );

			return $instance;
		}

		/**
		 * Output the settings update form.
		 *
		 * @since 1.0.0
		 *
		 * @param array $instance Current settings.
		 */
		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, array(
				'title'       			=> '',
				'cta_page'    			=> '',
				'button_text' 			=> esc_html__( 'Find More', 'x-business' ),
				'button_url'  			=> '',
				'secondary_button_text' => esc_html__( 'Buy Now', 'x-business' ),
				'secondary_button_url'  => '',
				'bg_pic'      			=> '',
			) );

			$bg_pic = '';

            if ( ! empty( $instance['bg_pic'] ) ) {

                $bg_pic = $instance['bg_pic'];

            }

            $wrap_style = '';

            if ( empty( $bg_pic ) ) {

                $wrap_style = ' style="display:none;" ';
            }

            $image_status = false;

            if ( ! empty( $bg_pic ) ) {
                $image_status = true;
            }

            $delete_button = 'display:none;';

            if ( true === $image_status ) {
                $delete_button = 'display:inline-block;';
            }
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><strong><?php esc_html_e( 'Title:', 'x-business' ); ?></strong></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'cta_page' ); ?>">
					<strong><?php esc_html_e( 'CTA Page:', 'x-business' ); ?></strong>
				</label>
				<?php
				wp_dropdown_pages( array(
					'id'               => $this->get_field_id( 'cta_page' ),
					'class'            => 'widefat',
					'name'             => $this->get_field_name( 'cta_page' ),
					'selected'         => $instance[ 'cta_page' ],
					'show_option_none' => esc_html__( '&mdash; Select &mdash;', 'x-business' ),
					)
				);
				?>
				<small>
		        	<?php esc_html_e('Content of this page will be used as content of CTA', 'x-business'); ?>	
		        </small>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><strong><?php esc_html_e( 'Primary Button Text:', 'x-business' ); ?></strong></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['button_text'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"><strong><?php esc_html_e( 'Primary Button URL:', 'x-business' ); ?></strong></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_url' ) ); ?>" type="text" value="<?php echo esc_url( $instance['button_url'] ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'secondary_button_text' ) ); ?>"><strong><?php esc_html_e( 'Secondary Button Text:', 'x-business' ); ?></strong></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'secondary_button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'secondary_button_text' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['secondary_button_text'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'secondary_button_url' ) ); ?>"><strong><?php esc_html_e( 'Secondary Button URL:', 'x-business' ); ?></strong></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'secondary_button_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'secondary_button_url' ) ); ?>" type="text" value="<?php echo esc_url( $instance['secondary_button_url'] ); ?>" />
			</p>

			<div class="cover-image">
                <label for="<?php echo esc_attr( $this->get_field_id( 'bg_pic' ) ); ?>">
                    <strong><?php esc_html_e( 'Background Image:', 'x-business' ); ?></strong>
                </label>
                <input type="text" class="img widefat" name="<?php echo esc_attr( $this->get_field_name( 'bg_pic' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'bg_pic' ) ); ?>" value="<?php echo esc_url( $instance['bg_pic'] ); ?>" />
                <div class="rtam-preview-wrap" <?php echo $wrap_style; ?>>
                    <img src="<?php echo esc_url( $bg_pic ); ?>" alt="<?php esc_attr_e( 'Preview', 'x-business' ); ?>" />
                </div><!-- .rtam-preview-wrap -->
                <input type="button" class="select-img button button-primary" value="<?php esc_html_e( 'Upload', 'x-business' ); ?>" data-uploader_title="<?php esc_html_e( 'Select Background Image', 'x-business' ); ?>" data-uploader_button_text="<?php esc_html_e( 'Choose Image', 'x-business' ); ?>" />
                <input type="button" value="<?php echo esc_attr_x( 'X', 'Remove Button', 'x-business' ); ?>" class="button button-secondary btn-image-remove" style="<?php echo esc_attr( $delete_button ); ?>" />
            </div>
		<?php
		} 
	
	}

endif;

if ( ! class_exists( 'X_Business_Recent_Posts_Widget' ) ) :

	/**
	 * Recent Posts widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Business_Recent_Posts_Widget extends WP_Widget {

	    function __construct() {
	    	$opts = array(
				'classname'   => 'x_business_widget_advanced_recent_posts',
				'description' => esc_html__( 'Widget to display recent posts with thumbnail. Receommneded to use in sidebar or footer widgets area.', 'x-business' ),
    		);

			parent::__construct( 'x-business-advanced-recent-posts', esc_html__( 'X-Business: Advanced Recent Posts', 'x-business' ), $opts );
	    }


	    function widget( $args, $instance ) {

			$title       = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$post_number = ! empty( $instance['post_number'] ) ? $instance['post_number'] : 5;

	        echo $args['before_widget']; ?>

	        <div class="advanced-recent-posts-wrap">

        		<?php 

        		if ( $title ) {
        			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        		} ?>

        		<div class="recent-posts-side">

        		    <?php

        		    $recent_args = array(
        		                        'posts_per_page'        => absint( $post_number ),
        		                        'no_found_rows'         => true,
        		                        'post__not_in'          => get_option( 'sticky_posts' ),
        		                        'ignore_sticky_posts'   => true,
        		                        'post_status'           => 'publish', 
        		                    );

        		    $recent_posts = new WP_Query( $recent_args );

        		    if ( $recent_posts->have_posts() ) :


        		        while ( $recent_posts->have_posts() ) :

        		            $recent_posts->the_post(); ?>

        		            <div class="news-item">
        		                <div class="news-thumb">
        		                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>   
        		                </div><!-- .news-thumb --> 

        		                <div class="news-text-wrap">
        		                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        		                     <span class="posted-date"><?php echo esc_html( get_the_date() ); ?></span>
        		                </div><!-- .news-text-wrap -->
        		            </div><!-- .news-item -->

        		            <?php

        		        endwhile; 

        		        wp_reset_postdata(); ?>

        		    <?php endif; ?>

        		</div>

	        </div><!-- .bp-advanced-recent-posts -->

	        <?php
	        echo $args['after_widget'];

	    }

	    function update( $new_instance, $old_instance ) {
	        $instance = $old_instance;
			$instance['title']           = sanitize_text_field( $new_instance['title'] );
			$instance['post_number']     = absint( $new_instance['post_number'] );

	        return $instance;
	    }

	    function form( $instance ) {

	        $instance = wp_parse_args( (array) $instance, array(
				'title'         => esc_html__( 'Recent Posts', 'x-business' ),
				'post_number'   => 5,
	        ) );
	        ?>
	        <p>
	          <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><strong><?php esc_html_e( 'Title:', 'x-business' ); ?></strong></label>
	          <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
	        </p>
	        <p>
	            <label for="<?php echo esc_attr( $this->get_field_name('post_number') ); ?>">
	                <?php esc_html_e('Number of Posts:', 'x-business'); ?>
	            </label>
	            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('post_number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('post_number') ); ?>" type="number" value="<?php echo absint( $instance['post_number'] ); ?>" />
	        </p>
	        <?php
	    }

	}

endif;

if ( ! class_exists( 'X_Business_About_Widget' ) ) :

	/**
	 * About Us widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Business_About_Widget extends WP_Widget {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			$opts = array(
				'classname'   => 'x_business_widget_about_us',
				'description' => esc_html__( 'Widget to display about us section with skills', 'x-business' ),
			);
			parent::__construct( 'x-business-about', esc_html__( 'X-Business: About Us', 'x-business' ), $opts );
		}

		/**
		 * Echo the widget content.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args     Display arguments including before_title, after_title,
		 *                        before_widget, and after_widget.
		 * @param array $instance The settings for the particular instance of the widget.
		 */
		function widget( $args, $instance ) {

			$title       		= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$sub_title 	 		= !empty( $instance['sub_title'] ) ? $instance['sub_title'] : '';
			
			$about_page  		= !empty( $instance['about_page'] ) ? $instance['about_page'] : ''; 

			$image_alignment 	= !empty( $instance['image_alignment'] ) ? $instance['image_alignment'] : '';

			$show_skills 		= ! empty( $instance['show_skills'] ) ? $instance['show_skills'] : 0;

			echo $args['before_widget']; ?>

			<div class="section-title">
				<?php

				if ( $title ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
				}

				if ( $sub_title ) { ?>

					<p><?php echo esc_html( $sub_title ); ?></p>

					<?php 
					
				} ?>

			</div>

			<div class="about-us-wrap">

				<?php

				if( 'right' === $image_alignment ){

					$image_position 	= 'img-align-right';
					$content_position	= 'content-align-left';

				} else{

					$image_position 	= 'img-align-left';
					$content_position	= 'content-align-right';

				} ?>

				<div class="inner-wrapper">

					<div class="about-us-inner">

						<div class="about-us-content <?php echo $content_position; ?>"">

							<?php

							if ( $about_page ) { 

								$about_args = array(
												'posts_per_page' => 1,
												'page_id'	     => absint( $about_page ),
												'post_type'      => 'page',
												'post_status'  	 => 'publish',
											);

								$about_query = new WP_Query( $about_args );	

								if( $about_query->have_posts()){

									while( $about_query->have_posts()){

										$about_query->the_post(); ?>

										<div class="about-us-text">
											<?php the_content(); ?>
										</div>

										<?php

									}

									wp_reset_postdata();

								} 

							} 

							if( 1 === $show_skills ){ ?>

								<div class="about-us-skills">
									<?php 
									
									for ( $s = 1; $s<=5; $s++ ) {

										$skill	= ! empty( $instance['skill_'.$s] ) ? $instance['skill_'.$s] : '';

										$skill_percent	= ! empty( $instance['skill_'.$s.'_percent'] ) ? $instance['skill_'.$s.'_percent'] : '';

										
										
										if( !empty( $skill ) && !empty( $skill_percent ) ){ ?>

											<h3><?php echo esc_html( $skill ); ?></h3>

											<div class="skill-progress-bar progress-bar-striped">
												<div class="progress-bar-length" style="width:<?php echo absint( $skill_percent ); ?>%">
													<span><?php echo absint( $skill_percent )."%"; ?></span>
												</div>
											</div>

											<?php

										} 
									}?>
									
								</div>
								<?php

							} ?>

						</div>

						<?php 

						$about_img = get_the_post_thumbnail_url( $about_page, 'full' );

						if( !empty( $about_img ) ){ ?>

							<div class="about-us-image <?php echo $image_position; ?>">

								<img src="<?php echo esc_url( $about_img ); ?>">

							</div><!-- .about-us-image -->

							<?php

						} ?>

					</div>

				</div>

			</div><!-- .about-us-widget -->

			<?php
			echo $args['after_widget'];

		}

		/**
		 * Update widget instance.
		 *
		 * @since 1.0.0
		 *
		 * @param array $new_instance New settings for this instance as input by the user via
		 *                            {@see WP_Widget::form()}.
		 * @param array $old_instance Old settings for this instance.
		 * @return array Settings to save or bool false to cancel saving.
		 */
		function update( $new_instance, $old_instance ) {

			$instance = $old_instance;

			$instance['title'] 				= sanitize_text_field( $new_instance['title'] );

			$instance['sub_title'] 			= sanitize_text_field( $new_instance['sub_title'] );

			$instance['about_page'] 		= absint( $new_instance['about_page'] );

			$instance['image_alignment'] 	= $new_instance['image_alignment'];

			$instance['show_skills']    	= (bool) $new_instance['show_skills'] ? 1 : 0;

			$instance['skill_1'] 			= sanitize_text_field( $new_instance['skill_1'] );

			$instance['skill_1_percent'] 	= absint( $new_instance['skill_1_percent'] );

			$instance['skill_2'] 			= sanitize_text_field( $new_instance['skill_2'] );

			$instance['skill_2_percent'] 	= absint( $new_instance['skill_2_percent'] );

			$instance['skill_3'] 			= sanitize_text_field( $new_instance['skill_3'] );

			$instance['skill_3_percent']	= absint( $new_instance['skill_3_percent'] );

			$instance['skill_4'] 			= sanitize_text_field( $new_instance['skill_4'] );

			$instance['skill_4_percent']	= absint( $new_instance['skill_4_percent'] );

			$instance['skill_5'] 			= sanitize_text_field( $new_instance['skill_5'] );

			$instance['skill_5_percent']	= absint( $new_instance['skill_5_percent'] );

			return $instance;
		}

		/**
		 * Output the settings update form.
		 *
		 * @since 1.0.0
		 *
		 * @param array $instance Current settings.
		 */
		function form( $instance ) {

			$instance = wp_parse_args( (array) $instance, array(
				'title'       			=> '',
				'sub_title' 			=> '',
				'about_page'    		=> '',
				'image_alignment'   	=> 'right',
				'show_skills'   		=> 1,
				'skill_1' 				=> '',
				'skill_1_percent' 		=> '',
				'skill_2' 				=> '',
				'skill_2_percent' 		=> '',
				'skill_3' 				=> '',
				'skill_3_percent' 		=> '',
				'skill_4' 				=> '',
				'skill_4_percent' 		=> '',
				'skill_5' 				=> '',
				'skill_5_percent' 		=> '',
			) );

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><strong><?php esc_html_e( 'Title:', 'x-business' ); ?></strong></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'sub_title' ) ); ?>"><strong><?php esc_html_e( 'Sub Title:', 'x-business' ); ?></strong></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'sub_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sub_title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['sub_title'] ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'about_page' ); ?>">
					<strong><?php esc_html_e( 'Select Page:', 'x-business' ); ?></strong>
				</label>
				<?php
				wp_dropdown_pages( array(
					'id'               => $this->get_field_id( 'about_page' ),
					'class'            => 'widefat',
					'name'             => $this->get_field_name( 'about_page' ),
					'selected'         => $instance[ 'about_page' ],
					'show_option_none' => esc_html__( '&mdash; Select &mdash;', 'x-business' ),
					)
				);
				?>
				<small>
		        	<?php esc_html_e('Content and featured image of this page will be used as content of about us section', 'x-business'); ?>	
		        </small>
			</p>

	        <p>
	          <label for="<?php echo esc_attr( $this->get_field_id( 'image_alignment' ) ); ?>"><strong><?php _e( 'Image Position:', 'x-business' ); ?></strong></label>
				<?php
	            $this->dropdown_image_alignment( array(
					'id'       => $this->get_field_id( 'image_alignment' ),
					'name'     => $this->get_field_name( 'image_alignment' ),
					'selected' => esc_attr( $instance['image_alignment'] ),
					)
	            );
				?>
	        </p>

	        <p>
	            <input class="checkbox" type="checkbox" <?php checked( $instance['show_skills'] ); ?> id="<?php echo $this->get_field_id( 'show_skills' ); ?>" name="<?php echo $this->get_field_name( 'show_skills' ); ?>" />
	            <label for="<?php echo $this->get_field_id( 'show_skills' ); ?>"><?php esc_html_e( 'Show skill chart', 'x-business' ); ?></label>
	        </p>

			<hr>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_name('skill_1') ); ?>">
					<?php esc_html_e('Skill One:', 'x-business'); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('skill_1') ); ?>" name="<?php echo esc_attr( $this->get_field_name('skill_1') ); ?>" type="text" value="<?php echo esc_attr( $instance['skill_1'] ); ?>" />		
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_name('skill_1_percent') ); ?>">
					<?php esc_html_e('Percentage:', 'x-business'); ?>
				</label>
				<input class="small" id="<?php echo esc_attr( $this->get_field_id('skill_1_percent') ); ?>" name="<?php echo esc_attr( $this->get_field_name('skill_1_percent') ); ?>" type="number" value="<?php echo absint( $instance['skill_1_percent'] ); ?>" />
			</p>

			<hr>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_name('skill_2') ); ?>">
					<?php esc_html_e('Skill Two:', 'x-business'); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('skill_2') ); ?>" name="<?php echo esc_attr( $this->get_field_name('skill_2') ); ?>" type="text" value="<?php echo esc_attr( $instance['skill_2'] ); ?>" />		
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_name('skill_2_percent') ); ?>">
					<?php esc_html_e('Percentage:', 'x-business'); ?>
				</label>
				<input class="small" id="<?php echo esc_attr( $this->get_field_id('skill_2_percent') ); ?>" name="<?php echo esc_attr( $this->get_field_name('skill_2_percent') ); ?>" type="number" value="<?php echo absint( $instance['skill_2_percent'] ); ?>" />
			</p>

			<hr>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_name('skill_3') ); ?>">
					<?php esc_html_e('Skill Three:', 'x-business'); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('skill_3') ); ?>" name="<?php echo esc_attr( $this->get_field_name('skill_3') ); ?>" type="text" value="<?php echo esc_attr( $instance['skill_3'] ); ?>" />		
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_name('skill_3_percent') ); ?>">
					<?php esc_html_e('Percentage:', 'x-business'); ?>
				</label>
				<input class="small" id="<?php echo esc_attr( $this->get_field_id('skill_3_percent') ); ?>" name="<?php echo esc_attr( $this->get_field_name('skill_3_percent') ); ?>" type="number" value="<?php echo absint( $instance['skill_3_percent'] ); ?>" />
			</p>

			<hr>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_name('skill_4') ); ?>">
					<?php esc_html_e('Skill Four:', 'x-business'); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('skill_4') ); ?>" name="<?php echo esc_attr( $this->get_field_name('skill_4') ); ?>" type="text" value="<?php echo esc_attr( $instance['skill_4'] ); ?>" />		
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_name('skill_4_percent') ); ?>">
					<?php esc_html_e('Percentage:', 'x-business'); ?>
				</label>
				<input class="small" id="<?php echo esc_attr( $this->get_field_id('skill_4_percent') ); ?>" name="<?php echo esc_attr( $this->get_field_name('skill_4_percent') ); ?>" type="number" value="<?php echo absint( $instance['skill_4_percent'] ); ?>" />
			</p>

			<hr>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_name('skill_5') ); ?>">
					<?php esc_html_e('Skill Five:', 'x-business'); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('skill_5') ); ?>" name="<?php echo esc_attr( $this->get_field_name('skill_5') ); ?>" type="text" value="<?php echo esc_attr( $instance['skill_5'] ); ?>" />		
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_name('skill_5_percent') ); ?>">
					<?php esc_html_e('Percentage:', 'x-business'); ?>
				</label>
				<input class="small" id="<?php echo esc_attr( $this->get_field_id('skill_5_percent') ); ?>" name="<?php echo esc_attr( $this->get_field_name('skill_5_percent') ); ?>" type="number" value="<?php echo absint( $instance['skill_5_percent'] ); ?>" />
			</p>
			
		<?php
		}

	    function dropdown_image_alignment( $args ) {
			$defaults = array(
		        'id'       => '',
		        'class'    => 'widefat',
		        'name'     => '',
		        'selected' => 'right',
			);

			$r = wp_parse_args( $args, $defaults );
			$output = '';

			$choices = array(
				'left' 		=> esc_html__( 'Left', 'x-business' ),
				'right' 	=> esc_html__( 'Right', 'x-business' ),
			);

			if ( ! empty( $choices ) ) {

				$output = "<select name='" . esc_attr( $r['name'] ) . "' id='" . esc_attr( $r['id'] ) . "' class='" . esc_attr( $r['class'] ) . "'>\n";
				foreach ( $choices as $key => $choice ) {
					$output .= '<option value="' . esc_attr( $key ) . '" ';
					$output .= selected( $r['selected'], $key, false );
					$output .= '>' . esc_html( $choice ) . '</option>\n';
				}
				$output .= "</select>\n";
			}

			echo $output;
	    } 
	
	}

endif;

if ( ! class_exists( 'X_Business_Features_Widget' ) ) :

	/**
	 * Features widget class.
	 *
	 * @since 1.0.0
	 */
	class X_Business_Features_Widget extends WP_Widget {

		function __construct() {
			$opts = array(
					'classname'   => 'x_business_widget_features',
					'description' => esc_html__( 'Widget to display features with icon and description including one main image.', 'x-business' ),
			);
			parent::__construct( 'x-business-features', esc_html__( 'X-Business: Features', 'x-business' ), $opts );
		}

		function widget( $args, $instance ) {

			$title 			= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			$sub_title 	 	= !empty( $instance['sub_title'] ) ? $instance['sub_title'] : '';

			$excerpt_length	= !empty( $instance['excerpt_length'] ) ? $instance['excerpt_length'] : 10;

			$left_features_ids 	= array();

			$left_item_number 		= 3;

			for ( $i = 1; $i <= $left_item_number; $i++ ) {
				if ( ! empty( $instance["left_item_id_$i"] ) && absint( $instance["left_item_id_$i"] ) > 0 ) {
					$id = absint( $instance["left_item_id_$i"] );
					$left_features_ids[ $id ]['id']   = $id;
					$left_features_ids[ $id ]['icon'] = $instance["left_item_icon_$i"];
				}
			}

			$right_features_ids 	= array();

			$right_item_number 		= 3;

			for ( $i = 1; $i <= $right_item_number; $i++ ) {
				if ( ! empty( $instance["right_item_id_$i"] ) && absint( $instance["right_item_id_$i"] ) > 0 ) {
					$id = absint( $instance["right_item_id_$i"] );
					$right_features_ids[ $id ]['id']   = $id;
					$right_features_ids[ $id ]['icon'] = $instance["right_item_icon_$i"];
				}
			}

			$features_pic  	 = ! empty( $instance['features_pic'] ) ? esc_url( $instance['features_pic'] ) : '';

			echo $args['before_widget']; ?>

			<div class="features-list">

				<div class="section-title">
					<?php

					if ( $title ) {
						echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
					}

					if ( $sub_title ) { ?>

						<p><?php echo esc_html( $sub_title ); ?></p>

						<?php 
						
					} ?>

				</div>
				<div class="features-wrapper">
					<?php

					if ( ! empty( $left_features_ids ) ) {
						$left_args = array(
							'posts_per_page' => count( $left_features_ids ),
							'post__in'       => wp_list_pluck( $left_features_ids, 'id' ),
							'orderby'        => 'post__in',
							'post_type'      => 'page',
							'no_found_rows'  => true,
						);
						$left_features = get_posts( $left_args ); ?>



						<?php if ( ! empty( $left_features ) ) : ?>
							
							<?php global $post; ?>
							
								<div class="feature-column right-align">

									<?php foreach ( $left_features as $post ) : ?>
										<?php setup_postdata( $post ); ?>
										<div class="features-item">
											<div class="features-inner">
												<div class="features-icon">
													<span class="<?php echo esc_attr( $left_features_ids[ $post->ID ]['icon'] ); ?>"></span>
												</div>

												<div class="features-text-wrap">
													<h3 class="features-item-title"><?php the_title(); ?></h3>
													<?php 
													$content = x_business_get_the_excerpt( absint( $excerpt_length ), $post );
													
													echo $content ? wpautop( wp_kses_post( $content ) ) : '';
													?>
												</div>
											</div>
										</div><!-- .features-item -->
									<?php endforeach; ?>

								</div><!-- .feature-column.right-align -->

							<?php wp_reset_postdata(); ?>

						<?php endif;
					} ?>

					<?php if ( ! empty( $features_pic ) ) : ?>
						<div class="feature-column center-align">
						    <img src="<?php echo esc_url( $features_pic ); ?>" alt="<?php esc_attr_e( 'feature-image', 'x-business' ); ?>"/>
						</div> <!-- .feature-column -->
					<?php endif; ?>

					<?php

					if ( ! empty( $right_features_ids ) ) {
						$right_args = array(
							'posts_per_page' => count( $right_features_ids ),
							'post__in'       => wp_list_pluck( $right_features_ids, 'id' ),
							'orderby'        => 'post__in',
							'post_type'      => 'page',
							'no_found_rows'  => true,
						);
						$right_features = get_posts( $right_args ); ?>



						<?php if ( ! empty( $right_features ) ) : ?>
							
							<?php global $post; ?>
							
								<div class="feature-column left-align">

									<?php foreach ( $right_features as $post ) : ?>
										<?php setup_postdata( $post ); ?>
										<div class="features-item">
											<div class="features-inner">
												<div class="features-icon">
													<span class="<?php echo esc_attr( $right_features_ids[ $post->ID ]['icon'] ); ?>"></span>
												</div>

												<div class="features-text-wrap">
													<h3 class="features-item-title"><?php the_title(); ?></h3>
													<?php 
													$content = x_business_get_the_excerpt( absint( $excerpt_length ), $post );
													
													echo $content ? wpautop( wp_kses_post( $content ) ) : '';
													?>
												</div>
											</div>
										</div><!-- .features-item -->
									<?php endforeach; ?>

								</div><!-- .feature-column.right-align -->

							<?php wp_reset_postdata(); ?>

						<?php endif;
					} ?>

				</div>

			</div><!-- .features-list -->

			<?php

			echo $args['after_widget'];

		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			$instance['title'] 			= sanitize_text_field( $new_instance['title'] );

			$instance['sub_title'] 		= sanitize_text_field( $new_instance['sub_title'] );

			$instance['excerpt_length'] = absint( $new_instance['excerpt_length'] );

			$left_item_number = 3;

			for ( $i = 1; $i <= $left_item_number; $i++ ) {
				$instance["left_item_id_$i"]   = absint( $new_instance["left_item_id_$i"] );
				$instance["left_item_icon_$i"] = sanitize_text_field( $new_instance["left_item_icon_$i"] );
			}

			$right_item_number = 3;

			for ( $i = 1; $i <= $right_item_number; $i++ ) {
				$instance["right_item_id_$i"]   = absint( $new_instance["right_item_id_$i"] );
				$instance["right_item_icon_$i"] = sanitize_text_field( $new_instance["right_item_icon_$i"] );
			}

			$instance['features_pic']  	 = esc_url_raw( $new_instance['features_pic'] );

			return $instance;
		}

		function form( $instance ) {

			// Defaults.
			$defaults = array(
							'title' 			=> '',
							'sub_title' 		=> '',
							'excerpt_length'	=> 10,
							'features_pic' 		=> '',
						);

			$left_item_number = 3;

			for ( $i = 1; $i <= $left_item_number; $i++ ) {
				$defaults["left_item_id_$i"]   = '';
				$defaults["left_item_icon_$i"] = 'icon-pencil';
			}

			$right_item_number = 3;

			for ( $i = 1; $i <= $right_item_number; $i++ ) {
				$defaults["right_item_id_$i"]   = '';
				$defaults["right_item_icon_$i"] = 'icon-pencil';
			}

			$instance = wp_parse_args( (array) $instance, $defaults );

			$features_pic = '';

            if ( ! empty( $instance['features_pic'] ) ) {

                $features_pic = $instance['features_pic'];

            }

            $wrap_style = '';

            if ( empty( $features_pic ) ) {

                $wrap_style = ' style="display:none;" ';
            }

            $image_status = false;

            if ( ! empty( $features_pic ) ) {
                $image_status = true;
            }

            $delete_button = 'display:none;';

            if ( true === $image_status ) {
                $delete_button = 'display:inline-block;';
            }
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><strong><?php esc_html_e( 'Title:', 'x-business' ); ?></strong></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'sub_title' ) ); ?>"><strong><?php esc_html_e( 'Sub Title:', 'x-business' ); ?></strong></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'sub_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sub_title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['sub_title'] ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_name('excerpt_length') ); ?>">
					<?php esc_html_e('Excerpt Length:', 'x-business'); ?>
				</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('excerpt_length') ); ?>" name="<?php echo esc_attr( $this->get_field_name('excerpt_length') ); ?>" type="number" value="<?php echo absint( $instance['excerpt_length'] ); ?>" />
			</p>

	        <p>
		        <small>
		        	
		        	<?php printf( esc_html__( '%1$s %2$s', 'x-business' ), 'ET-LINE icons are used for icon of each feature. You can find icon code', '<a href="http://rhythm.nikadevs.com/content/icons-et-line" target="_blank">here</a>' ); ?>
		        </small>
	        </p>
			
			<?php
			for ( $i = 1; $i <= $left_item_number; $i++ ) {
				?>
				<hr>
				<p>
					<label for="<?php echo $this->get_field_id( "left_item_id_$i" ); ?>"><strong><?php esc_html_e( 'Left Feature Page:', 'x-business' ); ?>&nbsp;<?php echo $i; ?></strong></label>
					<?php
					wp_dropdown_pages( array(
						'id'               => $this->get_field_id( "left_item_id_$i" ),
						'class'            => 'widefat',
						'name'             => $this->get_field_name( "left_item_id_$i" ),
						'selected'         => $instance["left_item_id_$i"],
						'show_option_none' => esc_html__( '&mdash; Select &mdash;', 'x-business' ),
						)
					);
					?>
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( "left_item_icon_$i" ) ); ?>"><strong><?php esc_html_e( 'Icon:', 'x-business' ); ?>&nbsp;<?php echo $i; ?></strong></label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( "left_item_icon_$i" ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( "left_item_icon_$i" ) ); ?>" type="text" value="<?php echo esc_attr( $instance["left_item_icon_$i"] ); ?>" />
				</p>
				<?php 
			} ?>

			<div class="cover-image">
                <label for="<?php echo esc_attr( $this->get_field_id( 'features_pic' ) ); ?>">
                    <strong><?php esc_html_e( 'Features Image:', 'x-business' ); ?></strong>
                </label>
                <input type="text" class="img widefat" name="<?php echo esc_attr( $this->get_field_name( 'features_pic' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'features_pic' ) ); ?>" value="<?php echo esc_url( $instance['features_pic'] ); ?>" />
                <div class="rtam-preview-wrap" <?php echo $wrap_style; ?>>
                    <img src="<?php echo esc_url( $features_pic ); ?>" alt="<?php esc_attr_e( 'Preview', 'x-business' ); ?>" />
                </div><!-- .rtam-preview-wrap -->
                <input type="button" class="select-img button button-primary" value="<?php esc_html_e( 'Upload', 'x-business' ); ?>" data-uploader_title="<?php esc_html_e( 'Select Background Image', 'x-business' ); ?>" data-uploader_button_text="<?php esc_html_e( 'Choose Image', 'x-business' ); ?>" />
                <input type="button" value="<?php echo esc_attr_x( 'X', 'Remove Button', 'x-business' ); ?>" class="button button-secondary btn-image-remove" style="<?php echo esc_attr( $delete_button ); ?>" />
            </div>

            <?php
            for ( $i = 1; $i <= $right_item_number; $i++ ) {
            	?>
            	<hr>
            	<p>
            		<label for="<?php echo $this->get_field_id( "right_item_id_$i" ); ?>"><strong><?php esc_html_e( 'Right Feature Page:', 'x-business' ); ?>&nbsp;<?php echo $i; ?></strong></label>
            		<?php
            		wp_dropdown_pages( array(
            			'id'               => $this->get_field_id( "right_item_id_$i" ),
            			'class'            => 'widefat',
            			'name'             => $this->get_field_name( "right_item_id_$i" ),
            			'selected'         => $instance["right_item_id_$i"],
            			'show_option_none' => esc_html__( '&mdash; Select &mdash;', 'x-business' ),
            			)
            		);
            		?>
            	</p>
            	<p>
            		<label for="<?php echo esc_attr( $this->get_field_id( "right_item_icon_$i" ) ); ?>"><strong><?php esc_html_e( 'Icon:', 'x-business' ); ?>&nbsp;<?php echo $i; ?></strong></label>
            		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( "right_item_icon_$i" ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( "right_item_icon_$i" ) ); ?>" type="text" value="<?php echo esc_attr( $instance["right_item_icon_$i"] ); ?>" />
            	</p>
            	<?php 
            } ?>
			<?php
		}
	}

endif;