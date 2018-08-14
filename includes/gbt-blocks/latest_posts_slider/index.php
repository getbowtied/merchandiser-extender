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
		'fontColor'						=> array(
			'type'						=> 'string',
			'default'					=> '#000'
		),
		'bgColor'						=> array(
			'type'						=> 'string',
			'default'					=> '#fff'
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
		'bulletsToggle' => true,
		'fontColor'		=> '#000',
		'bgColor'		=> '#fff'
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
		            'category' 			=> $category,
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
									<span class="shortcode_blog_posts_link_wrapper" style="background-color:<?php echo $bgColor; ?>;">
										<h4 class="shortcode_blog_posts_title" style="color:<?php echo $fontColor; ?>;"><?php echo $post->post_title; ?></h4>
										<span class="shortcode_blog_posts_date" style="color:<?php echo $fontColor; ?>;"><?php echo date('F d, Y', strtotime($post->post_date)); ?></span>
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

add_action('wp_ajax_getbowtied_mc_render_backend_latest_posts_slider', 'getbowtied_mc_render_backend_latest_posts_slider');
function getbowtied_mc_render_backend_latest_posts_slider() {

	$attributes = $_POST['attributes'];
	$output = '';
	$counter = 0;
	$sliderrandomid = rand();

	extract( shortcode_atts( array(
		'category'	=> 'All Categories',
		'fontColor' => '#000',
		'bgColor'	=> '#fff'
	), $attributes ) ); ?>

	<?php

	$output = 'el( "div", { key: "wp-block-gbt-posts-slider", className: "wp-block-gbt-posts-slider"},';

		$output .= 'el( "div", { key: "blog_posts_slider", className: "blog_posts_slider"},';

			$args = array(
	            'post_status' 		=> 'publish',
	            'post_type' 		=> 'post',
	            'category' 			=> $category,
	            'posts_per_page' 	=> '2'
	        );
	        
	        $recentPosts = get_posts( $args );

	        if ( !empty($recentPosts) ) :
	                    
	            foreach($recentPosts as $post) :

	            	$output .= 'el( "div", { key: "swiper-slide_' . $counter . '", className: "shortcode_blog_posts_item swiper-slide" },';

	            		if ( has_post_thumbnail($post->ID)) :
							$image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large', true);

							$output .= 'el( "div", { key: "slide-wrapper_' . $counter . '", className: "slide-wrapper", style: { backgroundImage: "url('.$image_url[0].')" } }),';
						
						else : 

							$output .= 'el( "div", { key: "slide-wrapper_noimg_' . $counter . '", className: "slide-wrapper_noimg" } ),';

						endif;

						$output .= 'el( "div", { key: "text-wrapper_' . $counter . '", className: "text-wrapper" },';

							$output .= 'el( "a", { key: "shortcode_blog_posts_link_' . $counter . '", className: "shortcode_blog_posts_link" },';

								$output .= 'el( "span", { key: "shortcode_blog_posts_link_wrapper_' . $counter . '", className: "shortcode_blog_posts_link_wrapper", style: { backgroundColor:"'.$bgColor.'" } },';

									$output .= 'el( "h4", { key: "shortcode_blog_posts_title_' . $counter . '", className: "shortcode_blog_posts_title", style: { color:"'.$fontColor.'" } }, "'.$post->post_title.'" ),';
									$output .= 'el( "span", { key: "shortcode_blog_posts_date_' . $counter . '", className: "shortcode_blog_posts_date", style: { color:"'.$fontColor.'" } }, "'.date('F d, Y', strtotime($post->post_date)).'" ),';


								$output .= '),'; 

							$output .= '),'; 

						$output .= '),'; 

	             	$output .= '),'; 

					$counter++;

				endforeach; 

	        endif;

	        $output .= 'el( "div", { key: "swiper-button-prev", className: "swiper-button-prev dashicon dashicons-arrow-left-alt2" } ),'; 
	        $output .= 'el( "div", { key: "swiper-button-next", className: "swiper-button-next dashicon dashicons-arrow-right-alt2" } ),'; 

	        $output .= 'el( "div", { key: "swiper-pagination-bullets", className: "quickview-pagination swiper-pagination-clickable swiper-pagination-bullets" },';

	        	$output .= 'el( "div", { key: "swiper-pagination-bullet_1", className: "swiper-pagination-bullet swiper-pagination-bullet-active" } ),'; 
	        	$output .= 'el( "div", { key: "swiper-pagination-bullet_2", className: "swiper-pagination-bullet" } ),';
	        	$output .= 'el( "div", { key: "swiper-pagination-bullet_3", className: "swiper-pagination-bullet" } ),';

        	$output .= '),';

	    $output .= ')';

	$output .= ')';

	echo json_encode($output);
	exit;
}