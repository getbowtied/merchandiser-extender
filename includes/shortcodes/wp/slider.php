<?php

// [slider]

function merchandiser_extender_slider_shortcode($params = array(), $content = null) {

	wp_enqueue_style( 'swiper' );
	wp_enqueue_script( 'swiper' );

	wp_enqueue_style(  'merchandiser-slider-shortcode-styles' );
	wp_enqueue_script( 'merchandiser-slider-shortcode-script' );

	extract(shortcode_atts(array(
		'full_height' 	=> 'yes',
		'custom_height' => '',
		'hide_arrows'	=> '',
		'hide_bullets'	=> ''
	), $params));

	$unique = uniqid();
	
	ob_start();

	$height = ( !empty($custom_height) && ( 'no' === $full_height ) ) ? 'style="height:'.$custom_height.';"' : '';
	?>

	<div class="shortcode_getbowtied_slider swiper-container swiper-<?php echo esc_attr($unique); ?> <?php echo ( !empty($custom_height) && ( 'no' === $full_height ) ) ? '' : 'full_height'; ?>" <?php echo wp_kses_post($height); ?> data-id="<?php echo esc_attr($unique); ?>">
		<div class="swiper-wrapper">
			<?php echo do_shortcode($content); ?>
		</div>

		<?php if ( !$hide_arrows ) { ?>
			<div class="swiper-button-prev">
				<svg xmlns="http://www.w3.org/2000/svg" width="75" height="14" viewBox="0 0 75 14">
					<path d="M7.45101521,0.192896598 C7.89901521,-0.133103402 8.52301521,-0.0361034022 8.84801521,0.409896598 C9.17401521,0.854896598 9.07701521,1.4808966 8.63201521,1.8068966 L8.63201521,1.8068966 L3.149,5.818 L74.4540152,5.8188966 L74.4540152,7.8188966 L3.093,7.818 L8.62701521,11.8288966 C9.04055367,12.1270504 9.15671935,12.6833818 8.91730925,13.1187846 L8.85001521,13.2248966 C8.65401521,13.4938966 8.34901521,13.6378966 8.03901521,13.6378966 C7.83501521,13.6378966 7.63001521,13.5758966 7.45401521,13.4478966 L7.45401521,13.4478966 L1.08201521,8.8308966 C0.396015212,8.3338966 0.00101521243,7.6108966 7.57719141e-06,6.8478966 C-0.00198478757,6.0848966 0.389015212,5.3598966 1.07301521,4.8598966 L1.07301521,4.8598966 Z"/>
				</svg>
			</div>
			<div class="swiper-button-next">
				<svg xmlns="http://www.w3.org/2000/svg" width="75" height="14" viewBox="0 0 75 14">
					<path d="M66.5944205,0.198018246 L72.933528,4.988933 C73.613357,5.50220863 74.0019727,6.2464583 73.9999925,7.02971691 C73.998991,7.81297553 73.6063997,8.55517209 72.9245828,9.06536807 L66.5914388,13.8049553 C66.4165121,13.9363538 66.2127621,14 66.0100061,14 C65.7018965,14 65.3987563,13.8521766 65.2039515,13.5760343 C64.8819273,13.1171659 64.9803236,12.4745448 65.4255917,12.1429688 L70.925,8.026 L4.26325641e-14,8.02649819 L4.26325641e-14,5.97339566 L70.87,5.973 L65.4206222,1.85487199 C64.9783358,1.52021628 64.8819273,0.877595184 65.2059393,0.420779871 C65.5289575,-0.0370619931 66.1491524,-0.136637466 66.5944205,0.198018246 Z"/>
				</svg>
			</div>
		<?php } ?>

		<?php if ( !$hide_bullets ) { ?>
			<div class="swiper-pagination"></div>
		<?php } ?>

	</div>

	<?php
	wp_reset_postdata();
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}
add_shortcode('slider', 'merchandiser_extender_slider_shortcode');

function merchandiser_extender_slide_shortcode($params = array(), $content = null) {
	extract(shortcode_atts(array(
		'title' 					=> '',
		'title_font_size'			=> '64px',
		'title_line_height'			=> '',
		'title_font_family'			=> 'primary_font',
		'description' 				=> '',
		'description_font_size' 	=> '21px',
		'description_line_height'	=> '',
		'description_font_family'	=> 'primary_font',
		'text_color'				=> '#000000',
		'button_text' 				=> '',
		'button_url'				=> '',
		'link_whole_slide'			=> '',
		'button_color'				=> '#000000',
		'button_text_color'			=>'#FFFFFF',
		'bg_color'					=> '#CCCCCC',
		'bg_image'					=> '',
		'text_align'				=> 'left'

	), $params));

	ob_start();

	if (is_numeric($bg_image))
	{
		$bg_image = wp_get_attachment_url($bg_image);
	} else {
		$bg_image = "";
	}
	?>

	<div class="swiper-slide <?php echo esc_attr($text_align); ?>-align" style="background: <?php echo $bg_color; ?>; url( <?php echo $bg_image; ?> ); color:<?php echo esc_attr($text_color); ?>">

		<?php if( !empty($button_url) && $link_whole_slide ) { ?>
			<a class="fullslidelink" href="<?php echo esc_url($button_url); ?>"></a>
		<?php } ?>

		<div class="slider-content" data-swiper-parallax="-1000">
			<div class="slider-content-wrapper">

				<?php if ( !empty($title) ) { ?>
					<?php $title_line_height = $title_line_height ? $title_line_height : $title_font_size; ?>

					<h1 class="slide-title <?php echo esc_attr($title_font_family); ?>" style="color:<?php echo esc_attr($text_color); ?>; font-size:<?php echo esc_attr($title_font_size); ?>; line-height:<?php echo esc_attr($title_line_height); ?>">
						<?php echo wp_kses_post($title); ?>
					</h1>
				<?php } ?>

				<?php if ( !empty($description) ) { ?>
					<?php $description_line_height = $description_line_height ? $description_line_height : $description_font_size; ?>

					<p class="slide-description <?php echo esc_attr($description_font_family); ?>" style="color:<?php echo esc_attr($text_color); ?>; font-size:<?php echo esc_attr($description_font_size); ?>; line-height:<?php echo esc_attr($description_line_height); ?>">
						<?php echo wp_kses_post($description); ?>
					</p>
				<?php } ?>

				<?php if ( !empty($button_text) ) { ?>
					<a class="button" href="<?php echo esc_url($button_url); ?>" style="color:<?php echo esc_attr($button_text_color); ?>; background:<?php echo esc_attr($button_color); ?>">
						<?php echo wp_kses_post($button_text); ?>
					</a>
				<?php } ?>

			</div>
		</div>
	</div>

	<?php
	wp_reset_postdata();
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}
add_shortcode('image_slide', 'merchandiser_extender_slide_shortcode');
