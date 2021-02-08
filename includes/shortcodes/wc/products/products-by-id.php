<?php

// [products_mixed]
function merchandiser_extender_products_by_ids($atts, $content = null) {
	extract( shortcode_atts( array(
		'widget_title' 	=> '',
		'columns'  		=> '4',
        'orderby' 		=> 'date',
        'order' 		=> 'desc',
		'ids' 			=> '',
	), $atts ) );

	if ( isset($widget_title) && !empty($widget_title) ) {
		?>
		<h3 class="wb-products-title"><?php echo wp_kses_post( $widget_title ); ?></h3>
		<?php
	}

	return do_shortcode('[products columns="'.$columns.'" orderby="'.$orderby.'" order="'.$order.'" ids="'.$ids.'"]');
}
add_shortcode( 'products_mixed', 'merchandiser_extender_products_by_ids' );
