<?php

// [best_selling_products_mixed]
function merchandiser_extender_best_selling_products($atts, $content = null) {
	extract( shortcode_atts( array(
		'widget_title' => '',
		'per_page'  => '4',
		'columns'  => '4',
	), $atts ) );

	if ( isset($widget_title) && !empty($widget_title) ) {
		?>
		<h3 class="wb-products-title"><?php echo wp_kses_post( $widget_title ); ?></h3>
		<?php
	}

	echo do_shortcode( '[best_selling_products per_page="'.$per_page.'" columns="'.$columns.'"]' );

	return;
}
add_shortcode( 'best_selling_products_mixed', 'merchandiser_extender_best_selling_products' );
