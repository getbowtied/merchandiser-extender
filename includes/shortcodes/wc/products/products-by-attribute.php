<?php

// [product_attribute_mixed]
function merchandiser_extender_products_by_attribute($atts, $content = null) {
	extract( shortcode_atts( array(
		'widget_title' => '',
		'attribute' => '',
		'filter' => '',
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

	echo do_shortcode('[product_attribute attribute="'.$attribute.'" filter="'.$filter.'" per_page="'.$per_page.'" columns="'.$columns.'" orderby="'.$orderby.'" order="'.$order.'"]');

	return;
}
add_shortcode( 'product_attribute_mixed', 'merchandiser_extender_products_by_attribute' );
