<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include_once( dirname( __FILE__ ) . '/functions/function-setup.php' );

//==============================================================================
//	Frontend Output
//==============================================================================
if( !function_exists('gbt_18_mc_render_frontend_posts_slider') ) {
	function gbt_18_mc_render_frontend_posts_slider( $attributes ) {

		extract( shortcode_atts( array(
			'number'				=> '12',
			'categoriesSavedIDs'	=> '',
			'align'					=> 'center',
			'orderby'				=> 'date_desc',
			'arrows'				=> true,
			'bullets' 				=> true,
			'fontColor'				=> '#000',
			'backgroundColor'		=> '#fff'
		), $attributes ) );

		$args = array(
	        'post_status' 		=> 'publish',
	        'post_type' 		=> 'post',
	        'posts_per_page' 	=> $number
	    );

	    switch ( $orderby ) {
	    	case 'date_asc' :
				$args['orderby'] = 'date';
				$args['order']	 = 'asc';
				break;
			case 'date_desc' :
				$args['orderby'] = 'date';
				$args['order']	 = 'desc';
				break;
			case 'title_asc' :
				$args['orderby'] = 'title';
				$args['order']	 = 'asc';
				break;
			case 'title_desc':
				$args['orderby'] = 'title';
				$args['order']	 = 'desc';
				break;
			default: break;
		}

	    if( substr($categoriesSavedIDs, - 1) == ',' ) {
			$categoriesSavedIDs = substr( $categoriesSavedIDs, 0, -1);
		}

		if( substr($categoriesSavedIDs, 0, 1) == ',' ) {
			$categoriesSavedIDs = substr( $categoriesSavedIDs, 1);
		}

	    if( $categoriesSavedIDs != '' ) $args['category'] = $categoriesSavedIDs;
	    
	    $recentPosts = get_posts( $args );

		ob_start();
		        
	    if ( !empty($recentPosts) ) : ?>

	    <div class="gbt_18_mc_posts_slider align<?php echo $align; ?>">
	    
			<div class="gbt_18_mc_posts_slider_container swiper-container">
				<div class="swiper-wrapper">
			                    
			        <?php foreach($recentPosts as $post) : ?>
			        
			            <div class="gbt_18_mc_posts_slider_item swiper-slide">

			            	<?php if ( has_post_thumbnail($post->ID)) :
								$image_id = get_post_thumbnail_id($post->ID);
								$image_url = wp_get_attachment_image_src($image_id,'large', true);
							?>
								<div class="slide-wrapper" style="background: url(<?php echo esc_url($image_url[0]); ?>) no-repeat; "></div>
							<?php else : ?>
								<div class="slide-wrapper" style="background-color: #ccc; "></div>
							<?php endif;  ?>

							<div class="text-wrapper">
			                	<span class="gbt_18_mc_posts_slider_item_link" href="<?php echo get_post_permalink($post->ID); ?>">
									<a class="gbt_18_mc_posts_slider_item_link_wrapper" style="background-color:<?php echo $backgroundColor; ?>;">
										<h4 class="gbt_18_mc_posts_slider_item_title" style="color:<?php echo $fontColor; ?>;"><?php echo $post->post_title; ?></h4>
										<span class="gbt_18_mc_posts_slider_item_date" style="color:<?php echo $fontColor; ?>;"><?php echo date('F d, Y', strtotime($post->post_date)); ?></span>
									</a>
								</span>
							</div>
			                
			            </div>

			        <?php endforeach; // end of the loop. ?>
			    </div>
			    <?php if ($bullets): ?>
					<div class="quickview-pagination"></div>
				<?php endif; ?>	 
			</div>
			<?php if ($arrows): ?>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>	
			<?php endif; ?>
		</div>
	        
	    <?php endif;
		        
		wp_reset_query();

		return ob_get_clean();
	}
}