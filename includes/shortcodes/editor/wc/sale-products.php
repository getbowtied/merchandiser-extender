<?php

// [sale_products_mixed]

vc_map( array(
   "name" 			=> "Sale Products",
   "category" 		=> 'WooCommerce',
   "description"	=> "",
   "base" 			=> "sale_products_mixed",
   "class" 			=> "",
   "icon" 			=> "icon-wpb-woocommerce",

   "params" 	=> array(

	   	array(
   			"type" 			=> "textfield",
			"holder" 		=> "div",
			"heading" 		=> "Widget Title",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"param_name" 	=> "widget_title"
   		),

		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Number of Products",
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

		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Order By",
			"description"	=> "",
			"param_name"	=> "orderby",
			"value"			=> array(
				"Date"		=> "date",
				"Title"		=> "title",
				"Modified"	=> "modified",
				"Random"	=> "rand"
			),
			"std"			=> "date",
		),

		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Order Way",
			"description"	=> "",
			"param_name"	=> "order",
			"value"			=> array(
				"Descending"	=> "desc",
				"Ascending"	=> "asc"
			),
			"std"			=> "desc",
		),
   )
));
