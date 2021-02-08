<?php

// [product_category_mixed]
function merchandiser_extender_products_by_category($atts, $content = null) {
	extract( shortcode_atts( array(
		'widget_title' => '',
		'category' => '',
		'per_page'  => '4',
		'columns'  => '4',
        'orderby' => 'date',
        'order' => 'desc',
	), $atts ) );

	if ( isset($widget_title) && !empty($widget_title) ) {
		?>
		<h3 class="wb-products-title"><?php echo wp_kses_post( $widget_title ); ?></h3>
		<?php
	}

	return do_shortcode('[product_category category="'.$category.'" per_page="'.$per_page.'" columns="'.$columns.'" orderby="'.$orderby.'" order="'.$order.'"]');
}
add_shortcode( 'product_category_mixed', 'merchandiser_extender_products_by_category' );
