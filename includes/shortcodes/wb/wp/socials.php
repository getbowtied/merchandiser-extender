<?php 

/*
**	SOCIAL MEDIA PROFILES
*/

vc_map(array(
   
   "name"						=> "Social Media",
   "category"					=> 'Social',
   "description"				=> "Links to your social media profiles",
   "base"						=> "socials",
   "class"						=> "",
   "icon"			=> get_template_directory_uri() . "/images/vc/social.png",
   
   "params" 	=> array(
		
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Align",
			"param_name"	=> "align",
			"value"			=> array(
				"Left"		=> "left",
				"Center"	=> "center",
				"Right"		=> "right"
			)
		),

		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Font Size (px, em)",
			"param_name"	=> "font_size",
			"value"			=> "",
		),

		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Color",
			"param_name"	=> "color",
			"value"			=> "",
		),
		
   )
   
));