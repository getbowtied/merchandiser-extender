<?php

// Posts Slider

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


add_action( 'enqueue_block_editor_assets', 'getbowtied_mc_latest_posts_slider_editor_assets' );

if ( ! function_exists( 'getbowtied_mc_latest_posts_slider_editor_assets' ) ) {
	function getbowtied_mc_latest_posts_slider_editor_assets() {
		
		wp_enqueue_script(
			'getbowtied-latest-posts-slider',
			plugins_url( 'block.js', __FILE__ ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'jquery' ),
			filemtime( plugin_dir_path( __FILE__ ) . 'block.js' )
		);

		wp_enqueue_style(
			'getbowtied-latest-posts-slider-editor-css',
			plugins_url( 'css/editor.css', __FILE__ ),
			array( 'wp-blocks' )
		);
	}
}

add_action( 'enqueue_block_assets', 'getbowtied_mc_latest_posts_slider_assets' );

if ( ! function_exists( 'getbowtied_mc_latest_posts_slider_assets' ) ) {
	function getbowtied_mc_latest_posts_slider_assets() {
		
		wp_enqueue_style(
			'getbowtied-latest-posts-slider-css',
			plugins_url( 'css/style.css', __FILE__ ),
			array()
		);
	}
}

register_block_type( 'getbowtied/mc-latest-posts-slider', array(
	'attributes'      					=> array(
		'number'						=> array(
			'type'						=> 'number',
			'default'					=> '12',
		),
		'category'						=> array(
			'type'						=> 'string',
			'default'					=> '',
		),
		'align'							=> array(
			'type'						=> 'string',
			'default'					=> 'center',
		),
		'arrowsToggle'					=> array(
			'type'						=> 'boolean',
			'default'					=> true
		),
		'bulletsToggle'					=> array(
			'type'						=> 'boolean',
			'default'					=> true
		),
	),

	'render_callback' => 'getbowtied_mc_render_frontend_latest_posts_slider',
) );

function getbowtied_mc_render_frontend_latest_posts_slider( $attributes ) {

	extract( shortcode_atts( array(
		'number'		=> '12',
		'category'		=> 'All Categories',
		'align'			=> 'center',
		'arrowsToggle'	=> true,
		'bulletsToggle' => true
	), $attributes ) );

	ob_start();
	?> 

	<div class="wp-block-gbt-posts-slider <?php echo $align; ?>">
    
		<div class="shortcode_getbowtied_blog_posts swiper-container">
			<div class="swiper-wrapper">
			
				<?php

		        $args = array(
		            'post_status' 		=> 'publish',
		            'post_type' 		=> 'post',
		            'category_name' 	=> $category,
		            'posts_per_page' 	=> $number
		        );
		        
		        $recentPosts = get_posts( $args );
		        
		        if ( !empty($recentPosts) ) : ?>
		                    
		            <?php foreach($recentPosts as $post) : ?>
	                
		                <div class="shortcode_blog_posts_item swiper-slide">

		                	<?php if ( has_post_thumbnail($post->ID)) :
								$image_id = get_post_thumbnail_id($post->ID);
								$image_url = wp_get_attachment_image_src($image_id,'large', true);
							?>
								<div class="slide-wrapper" style="background: url(<?php echo esc_url($image_url[0]); ?>) no-repeat; "></div>
							<?php else : ?>
								<div class="slide-wrapper" style="background-color: #ccc; "></div>
							<?php endif;  ?>

							<div class="text-wrapper">
		                    	<a class="shortcode_blog_posts_link" href="<?php echo get_post_permalink($post->ID); ?>">
									<span class="shortcode_blog_posts_link_wrapper">
										<h4 class="shortcode_blog_posts_title"><?php echo $post->post_title; ?></h4>
										<span class="shortcode_blog_posts_date"><?php echo date('F d, Y', strtotime($post->post_date)); ?></span>
									</span>
								</a>
							</div>
		                    
		                </div>
		    
		            <?php endforeach; // end of the loop. ?>
		            
		        <?php endif; ?>

			</div>   

			<?php if ($arrowsToggle): ?>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>	
			<?php endif; ?>
			<?php if ($bulletsToggle): ?>
				<div class="quickview-pagination"></div>
			<?php endif; ?>	    
		</div>
	</div>
	
	<?php
	wp_reset_postdata();
	
	return ob_get_clean();

}

// add_action('wp_ajax_getbowtied_mc_render_backend_latest_posts_slider', 'getbowtied_mc_render_backend_latest_posts_slider');
// function getbowtied_mc_render_backend_latest_posts_slider() {

// 	$attributes = $_POST['attributes'];
// 	$output = '';
// 	$counter = 0;

// 	extract( shortcode_atts( array(
// 		'number'	=> '12',
// 		'category'	=> 'All Categories',
// 		'columns'	=> '3'
// 	), $attributes ) );

// 	$output = 'el( "div", { key: "wp-block-gbt-posts-grid", className: "wp-block-gbt-posts-grid"},';

// 		$output .= 'el( "div", { key: "latest_posts_grid_wrapper", className: "latest_posts_grid_wrapper columns-' . $columns . '"},';

// 			$args = array(
// 	            'post_status' 		=> 'publish',
// 	            'post_type' 		=> 'post',
// 	            'category' 			=> $category,
// 	            'posts_per_page' 	=> $number
// 	        );
	        
// 	        $recentPosts = get_posts( $args );

// 	        if ( !empty($recentPosts) ) :
	                    
// 	            foreach($recentPosts as $post) :
	        
// 	                $output .= 'el( "div", { key: "latest_posts_grid_item_' . $counter . '", className: "latest_posts_grid_item" },';

// 	                	$output .= 'el( "a", { key: "latest_posts_grid_link_' . $counter . '", className: "latest_posts_grid_link" },';

// 	                		$output .= 'el( "span", { key: "latest_posts_grid_img_container_' . $counter . '", className: "latest_posts_grid_img_container"},';
	                		
// 	                			$output .= 'el( "span", { key: "latest_posts_grid_overlay_' . $counter . '", className: "latest_posts_grid_overlay" }, ),';

// 	                			if ( has_post_thumbnail($post->ID)) :
// 	                				$image_id = get_post_thumbnail_id($post->ID);
// 									$image_url = wp_get_attachment_image_src($image_id,'large', true);

// 									$output .= 'el( "span", { key: "latest_posts_grid_img_' . $counter . '", className: "latest_posts_grid_img", style: { backgroundImage: "url(' . esc_url($image_url[0]) . ')" } } )';

// 								else :

// 									$output .= 'el( "span", { key: "latest_posts_grid_noimg_' . $counter . '", className: "latest_posts_grid_noimg"} )';

// 								endif;

// 	                		$output .= '),';

// 							$output .= 'el( "span", { key: "latest_posts_grid_title_' . $counter . '", className: "latest_posts_grid_title"}, "' . $post->post_title . '" )';

// 	                	$output .= '),';

// 	            	$output .= '),';

// 					$counter++;

// 				endforeach; 

// 	        endif;

// 		$output .= ')';

// 	$output .= ')';

// 	echo json_encode($output);
// 	exit;
// }
