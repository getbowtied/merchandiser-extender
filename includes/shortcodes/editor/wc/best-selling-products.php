<?php

// [best_selling_products_mixed]

vc_map( array(
   "name" 			=> "Best Selling Products",
   "category" 		=> 'WooCommerce',
   "description"	=> "",
   "base" 			=> "best_selling_products_mixed",
   "class" 			=> "",
   "icon" 			=> "icon-wpb-woocommerce",

   "params" 	=> array(

   		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Widget Title",
			"param_name"	=> "widget_title",
			"value"			=> "",
		),

		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "How many products would you like to display?",
			"param_name"	=> "per_page",
			"value"			=> "4",
		),

		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Columns",
			"description"	=> "",
			"param_name"	=> "columns",
			"value"			=> "4",
		),
   )
));
