<?php

// [recent_products_mixed]
function merchandiser_extender_recent_products($atts, $content = null) {
	extract( shortcode_atts( array(
		'widget_title' => '',
		'per_page'  => '4',
		'columns'  => '4',
        'orderby' => 'date',
        'order' => 'desc',
	), $atts ) );

	ob_start();

	if ( isset($widget_title) && !empty($widget_title) ) {
		?>
		<h3 class="wb-products-title"><?php echo wp_kses_post( $widget_title ); ?></h3>
		<?php
	}

	echo do_shortcode('[recent_products per_page="'.$per_page.'" columns="'.$columns.'" orderby="'.$orderby.'" order="'.$order.'"]');

	wp_reset_postdata();
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}
add_shortcode( 'recent_products_mixed', 'merchandiser_extender_recent_products' );
