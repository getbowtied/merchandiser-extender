( function( blocks, i18n, element ) {

	var el = element.createElement;

	/* Blocks */
	var registerBlockType   = wp.blocks.registerBlockType;

	var InspectorControls 	= wp.editor.InspectorControls;

	var TextControl 		= wp.components.TextControl;
	var RadioControl        = wp.components.RadioControl;
	var SelectControl		= wp.components.SelectControl;
	var ToggleControl		= wp.components.ToggleControl;
	var RangeControl		= wp.components.RangeControl;
	var ColorPalette		= wp.components.ColorPalette;
	var PanelBody			= wp.components.PanelBody;
	var PanelColor			= wp.components.PanelColor;

	var categories_list = [];

	function escapeHtml(text) {
	  	return text
	    	.replace("&amp;", '&')
	    	.replace("&lt;", '<')
	    	.replace("&gt;", '>')
	     	.replace("&quot;", '"')
	    	.replace("&#039;", "'");
	}

	async function getCategories(categories_list) { 
	 	const categories = await wp.apiRequest( { path: '/wp/v2/categories?per_page=-1' } );

	 	var i;
	 	categories_list[0] = {value: '0', label: "All Categories"};
	 	for(i = 0; i < categories.length; i++) {
	 		var category = {value: categories[i]['id'], label: escapeHtml(categories[i]['name'])};
	 		categories_list[i+1] = category;
	 	}
	 } 

	getCategories(categories_list);

	/* Register Block */
	registerBlockType( 'getbowtied/mc-latest-posts-slider', {
		title: i18n.__( 'Latest Posts Slider' ),
		icon: 'slides',
		category: 'merchandiser',
		supports: {
			align: [ 'center', 'wide', 'full' ],
		},
		attributes: {
			number: {
				type: 'number',
				default: '12'
			},
			category: {
				type: 'string',
				default: 'All Categories'
			},
			categories : {
				type: 'array',
				default: categories_list
			},
			arrowsToggle: {
				type: 'boolean',
				default: true
			},
			bulletsToggle: {
				type: 'boolean',
				default: true
			},
			fontColor: {
	        	type: 'string',
	        	default: '#000'
	        },
	        bgColor: {
	        	type: 'string',
	        	default: '#fff'
	        },
			grid: {
				type: 'string',
				default: ''
			}
		},

		edit: function( props ) {

			var attributes = props.attributes;

			var colors = [
				{ name: 'red', 				color: '#d02e2e' },
				{ name: 'orange', 			color: '#f76803' },
				{ name: 'yellow', 			color: '#fbba00' },
				{ name: 'green', 			color: '#43d182' },
				{ name: 'blue', 			color: '#2594e3' },
				{ name: 'white', 			color: '#ffffff' },
				{ name: 'dark-gray', 		color: '#abb7c3' },
				{ name: 'black', 			color: '#000' 	 },
			];

			function getLatestPosts( category, fontColor, bgColor, arrows, bullets ) {

				fontColor = fontColor || attributes.fontColor;
				bgColor   = bgColor   || attributes.bgColor;
				category  = category  || attributes.category;

				var data = {
					action 		: 'getbowtied_mc_render_backend_latest_posts_slider',
					attributes  : {
						'category' 	: category,
						'fontColor' : fontColor,
						'bgColor' 	: bgColor,
						'arrows'    : Number(arrows),
						'bullets'   : Number(bullets)
					}
				};

				jQuery.post( 'admin-ajax.php', data, function(response) { 
					response = jQuery.parseJSON(response);
					props.setAttributes( { grid: response } );
				});	
			}

			return [
				el(
					InspectorControls,
					{
						key: 'latest-posts-inspector'
					},
					el( 
						PanelBody, 
						{ 
							key: 'posts-slider-post-settings-panel',
							title: 'Posts',
							initialOpen: false,
							style:
							{
							    borderBottom: '1px solid #e2e4e7'
							}
						},
						el(
							RangeControl,
							{
								key: "latest-posts-number",
								value: attributes.number,
								allowReset: false,
								label: i18n.__( 'Number of Posts' ),
								onChange: function( newNumber ) {
									props.setAttributes( { number: newNumber } );
								},
							}
						),
						el( 'hr', { key: 'separator1' } ),
						el(
							SelectControl,
							{
								key: "latest-posts-category",
								options: attributes.categories,
	              				label: i18n.__( 'Category' ),
	              				value: attributes.category,
	              				onChange: function( newCat ) {
	              					props.setAttributes( { category: newCat } );
	              					getLatestPosts( newCat, null, null, attributes.arrowsToggle, attributes.bulletsToggle );
								},
							}
						),
					),
					el( 
						PanelBody, 
						{ 
							key: 'posts-slider-bullets-settings-panel',
							title: 'Bullets & Arrows',
							initialOpen: false,
							style:
							{
							    borderBottom: '1px solid #e2e4e7'
							}
						},
						el(
							ToggleControl,
							{
								key: "posts-slider-arrows-toggle",
		          				label: i18n.__( 'Navigation Arrows' ),
		          				checked: attributes.arrowsToggle,
		          				onChange: function() {
									props.setAttributes( { arrowsToggle: ! attributes.arrowsToggle } );
									getLatestPosts( null, null, null, !attributes.arrowsToggle, attributes.bulletsToggle );
								},
							}
						),
						el( 'hr', { key: 'separator3' } ),
						el(
							ToggleControl,
							{
								key: "posts-slider-bullets-toggle",
		          				label: i18n.__( 'Navigation Bullets' ),
		          				checked: attributes.bulletsToggle,
		          				onChange: function() {
									props.setAttributes( { bulletsToggle: ! attributes.bulletsToggle } );
									getLatestPosts( null, null, null, attributes.arrowsToggle, !attributes.bulletsToggle );
								},
							}
						),
					),
					el( 
						PanelBody, 
						{ 
							key: 'posts-slider-colors-settings-panel',
							title: 'Colors',
							initialOpen: false,
							style:
							{
							    borderBottom: '1px solid #e2e4e7'
							}
						},
						el(
							PanelColor,
							{
								key: 'posts-slider-font-color-panel',
								title: i18n.__( 'Font Color' ),
								colorValue: attributes.fontColor,
							},
							el(
								ColorPalette, 
								{
									key: 'posts-slider-font-color-pallete',
									colors: colors,
									value: attributes.fontColor,
									onChange: function( newColor) {
										props.setAttributes( { fontColor: newColor } );
										getLatestPosts( null, newColor, null, attributes.arrowsToggle, attributes.bulletsToggle );
									},
								} 
							),
						),
						el(
							PanelColor,
							{
								key: 'posts-slider-text-bg-color-panel',
								title: i18n.__( 'Text Background Color' ),
								colorValue: attributes.bgColor,
							},
							el(
								ColorPalette, 
								{
									key: 'posts-slider-text-bg-color-palette',
									colors: colors,
									value: attributes.bgColor,
									onChange: function( newColor) {
										props.setAttributes( { bgColor: newColor } );
										getLatestPosts( null, null, newColor, attributes.arrowsToggle, attributes.bulletsToggle );
									},
								} 
							),
						),
					),
				),
				eval( attributes.grid ),
				attributes.grid == '' && getLatestPosts( 'All Categories' ),
			];
		},

		save: function( props ) {
			return '';
		},
	} );

} )(
	window.wp.blocks,
	window.wp.i18n,
	window.wp.element,
	jQuery
);