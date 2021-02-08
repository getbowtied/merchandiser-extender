<?php

// [featured_products_mixed]
function merchandiser_extender_featured_products($atts, $content = null) {
	extract( shortcode_atts( array(
		'widget_title' 	=> '',
		'per_page'  	=> '4',
		'columns'  		=> '4',
		'orderby'		=> 'date',
		'order' 		=> 'DESC',
	), $atts ) );

	if ( isset($widget_title) && !empty($widget_title) ) {
		?>
		<h3 class="wb-products-title"><?php echo wp_kses_post( $widget_title ); ?></h3>
		<?php
	}

	return do_shortcode('[featured_products per_page="'.$per_page.'" columns="'.$columns.'" orderby="'.$orderby.'" order="'.$order.'"]');
}
add_shortcode( 'featured_products_mixed', 'merchandiser_extender_featured_products' );
