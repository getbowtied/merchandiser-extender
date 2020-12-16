<?php

// [blog_posts]
function getbowtied_mc_shortcode_blog_posts($atts, $content = null) {
	wp_enqueue_style( 'swiper' );
	wp_enqueue_script( 'swiper' );

	wp_enqueue_style(  'merchandiser-blog-posts-shortcode-styles' );
	wp_enqueue_script( 'merchandiser-blog-posts-shortcode-script' );

	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		"posts" 		=>  '9',
		"category" 		=>  '',
		"hide_arrows" 	=>  0,
		"hide_bullets" 	=>  0
	), $atts));

	$unique = uniqid();

	ob_start();
	?>

	<div class="shortcode_getbowtied_blog_posts swiper-container swiper-<?php echo esc_attr($unique); ?>" data-id="<?php echo esc_attr($unique); ?>">
		<div class="swiper-wrapper">
		<?php

        $args = array(
            'post_status' => 'publish',
            'post_type' => 'post',
            'category_name' => $category,
            'posts_per_page' => $posts
        );

        $recentPosts = new WP_Query( $args );

        if ( $recentPosts->have_posts() ) : ?>

            <?php while ( $recentPosts->have_posts() ) : $recentPosts->the_post(); ?>

	                <div class="shortcode_blog_posts_item swiper-slide">

						<?php if ( has_post_thumbnail()) :
							$image_id = get_post_thumbnail_id();
							$image_url = wp_get_attachment_image_src($image_id,'large', true);
						?>
							<div class="slide-wrapper">
								<img src="<?php echo esc_url($image_url[0]); ?>" alt="post-image" />
							</div>
						<?php else : ?>
							<div class="slide-wrapper" style="background-color: #ccc; "></div>
						<?php endif;  ?>

						<div class="text-wrapper">
	                    	<a class="shortcode_blog_posts_link" href="<?php the_permalink() ?>">
								<span class="shortcode_blog_posts_link_wrapper">
									<h4 class="shortcode_blog_posts_title"><?php echo get_the_title(); ?></h4>
									<span class="shortcode_blog_posts_date"><?php echo get_the_date(); ?></span>
								</span>
							</a>
						</div>

	                </div>

                </li>

            <?php endwhile; // end of the loop. ?>

        <?php

        endif;

        ?>
		</div>
		<?php if (!$hide_arrows): ?>
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
		<?php endif; ?>
		<?php if (!$hide_bullets): ?>
			<div class="swiper-pagination"></div>
		<?php endif; ?>
	</div>

	<?php
	wp_reset_postdata();
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode("blog_posts", "getbowtied_mc_shortcode_blog_posts");
