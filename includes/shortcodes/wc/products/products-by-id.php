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

	ob_start();

	if ( isset($widget_title) && !empty($widget_title) ) {
		?>
		<h3 class="wb-products-title"><?php echo wp_kses_post( $widget_title ); ?></h3>
		<?php
	}

	echo do_shortcode('[products columns="'.$columns.'" orderby="'.$orderby.'" order="'.$order.'" ids="'.$ids.'"]');

	wp_reset_postdata();
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}
add_shortcode( 'products_mixed', 'merchandiser_extender_products_by_ids' );
