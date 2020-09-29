( function( blocks, components, editor, i18n, element ) {

	const el = element.createElement;

	/* Blocks */
	const registerBlockType = wp.blocks.registerBlockType;

	const {
		TextControl,
		SelectControl,
		ToggleControl,
		RangeControl,
		PanelBody,
		Button,
		TabPanel,
		SVG,
		Path,
		Circle,
		Polygon,
	} = wp.components;

	const {
		InspectorControls,
		InnerBlocks,
		PanelColorSettings,
	} = wp.blockEditor;

	var attributes = {
		fullHeight: {
			type: 'boolean',
			default: false
		},
		customHeight: {
			type: 'number',
			default: '800',
		},
		slides: {
			type: 'number',
			default: '3',
		},
		pagination: {
			type: 'boolean',
			default: true
		},
		paginationColor: {
			type: 'string',
			default: '#fff'
		},
		arrows: {
			type: 'boolean',
			default: true
		},
		arrowsColor: {
			type: 'string',
			default: '#fff'
		},
		activeTab: {
			type: 'number',
			default: '1'
		}
	};

	/* Register Block */
	registerBlockType( 'getbowtied/mc-slider', {
		title: i18n.__( 'Slider', 'merchandiser-extender' ),
		icon:
			el( SVG, { xmlns:'http://www.w3.org/2000/svg', viewBox:'0 0 100 100' },
				el( Path, { d:'M85,15H15v60h70V15z M20,70v-9l15-15l9,9L29,70H20z M36,70l19-19l21,19H36z M80,66.8L54.9,44l-7.4,7.4L35,39 L20,54V20h60V66.8z' } ),
				el( Circle, {cx: "50", cy: "82.5", r: "2.5"}),
				el( Circle, {cx: "40", cy: "82.5", r: "2.5"}),
				el( Circle, {cx: "60", cy: "82.5", r: "2.5"}),
				el( Circle, {cx: "70", cy: "82.5", r: "2.5"}),
				el( Circle, {cx: "30", cy: "82.5", r: "2.5"}),
				el( Polygon, { points: "10,40 5,45 10,50 "}),
				el( Polygon, { points: "90,50 95,45 90,40 "}),
				el( Path, { d:'M65,40c4.1,0,7.5-3.4,7.5-7.5S69.1,25,65,25s-7.5,3.4-7.5,7.5S60.9,40,65,40z M65,30c1.4,0,2.5,1.1,2.5,2.5 S66.4,35,65,35s-2.5-1.1-2.5-2.5S63.6,30,65,30z' } )
			),
		category: 'merchandiser',
		supports: {
			align: [ 'center', 'wide', 'full' ],
		},
		attributes: attributes,

		edit: function( props ) {

			var attributes = props.attributes;

			function getTabs() {

				let tabs = [];

				let icons = [
					{ 'tab': '1', 'code': 'M3 5H1v16c0 1.1.9 2 2 2h16v-2H3V5zm11 10h2V5h-4v2h2v8zm7-14H7c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zm0 16H7V3h14v14z' },
					{ 'tab': '2', 'code': 'M3 5H1v16c0 1.1.9 2 2 2h16v-2H3V5zm18-4H7c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zm0 16H7V3h14v14zm-4-4h-4v-2h2c1.1 0 2-.89 2-2V7c0-1.11-.9-2-2-2h-4v2h4v2h-2c-1.1 0-2 .89-2 2v4h6v-2z' },
					{ 'tab': '3', 'code': 'M21 1H7c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zm0 16H7V3h14v14zM3 5H1v16c0 1.1.9 2 2 2h16v-2H3V5zm14 8v-1.5c0-.83-.67-1.5-1.5-1.5.83 0 1.5-.67 1.5-1.5V7c0-1.11-.9-2-2-2h-4v2h4v2h-2v2h2v2h-4v2h4c1.1 0 2-.89 2-2z' },
					{ 'tab': '4', 'code': 'M3 5H1v16c0 1.1.9 2 2 2h16v-2H3V5zm12 10h2V5h-2v4h-2V5h-2v6h4v4zm6-14H7c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zm0 16H7V3h14v14z' },
					{ 'tab': '5', 'code': 'M21 1H7c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zm0 16H7V3h14v14zM3 5H1v16c0 1.1.9 2 2 2h16v-2H3V5zm14 8v-2c0-1.11-.9-2-2-2h-2V7h4V5h-6v6h4v2h-4v2h4c1.1 0 2-.89 2-2z' },
					{ 'tab': '6', 'code': 'M3 5H1v16c0 1.1.9 2 2 2h16v-2H3V5zm18-4H7c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zm0 16H7V3h14v14zm-8-2h2c1.1 0 2-.89 2-2v-2c0-1.11-.9-2-2-2h-2V7h4V5h-4c-1.1 0-2 .89-2 2v6c0 1.11.9 2 2 2zm0-4h2v2h-2v-2z' },
				];

				for( let i = 1; i <= attributes.slides; i++ ) {
					tabs.push(
						el( 'a',
							{
				                key: 'slide' + i,
				                className: 'slide-tab slide-' + i,
				                'data-tab': i,
				                onClick: function() {
                    				props.setAttributes({ activeTab: i });
                                },
				            },
				            el( SVG,
				            	{
				            		xmlns:"http://www.w3.org/2000/svg",
				            		viewBox:"0 0 24 24"
				            	},
				            	el( Path,
				            		{
				            			d: icons[i-1]['code']
				            		}
				            	)
				            ),
			            )
					);
				}

				return tabs;
			}

			function getTemplates() {
				let n = [];

                for ( let i = 1; i <= attributes.slides; i++ ) {
                	n.push(["getbowtied/mc-slide", {
                        tabNumber: i
                    }]);
                }

                return n;
			}

			function getColors() {

				let colors = [];

				if( attributes.pagination ) {
					colors.push(
						{
							label: i18n.__( 'Pagination Bullets', 'merchandiser-extender' ),
							value: attributes.paginationColor,
							onChange: function( newColor) {
								props.setAttributes( { paginationColor: newColor } );
							},
						}
					);
				}

				if( attributes.arrows ) {
					colors.push(
						{
							label: i18n.__( 'Navigation Arrows', 'merchandiser-extender' ),
							value: attributes.arrowsColor,
							onChange: function( newColor) {
								props.setAttributes( { arrowsColor: newColor } );
							},
						}
					);
				}

				return colors;
			}

			return [
				el(
					InspectorControls,
					{
						key: 'gbt_18_mc_slider_inspector'
					},
					el(
						'div',
						{
							className: 'main-inspector-wrapper',
						},
						el(
							ToggleControl,
							{
								key: "gbt_18_mc_slider_full_height",
								label: i18n.__( 'Full Height', 'merchandiser-extender' ),
								checked: attributes.fullHeight,
								onChange: function() {
									props.setAttributes( { fullHeight: ! attributes.fullHeight } );
								},
							}
						),
						attributes.fullHeight === false &&
						el(
							RangeControl,
							{
								key: "gbt_18_mc_slider_custom_height",
								value: attributes.customHeight,
								allowReset: false,
								initialPosition: 800,
								min: 100,
								max: 1000,
								label: i18n.__( 'Custom Desktop Height', 'merchandiser-extender' ),
								onChange: function( newNumber ) {
									props.setAttributes( { customHeight: newNumber } );
								},
							}
						),
						el(
							RangeControl,
							{
								key: "gbt_18_mc_slider_slides",
								value: attributes.slides,
								allowReset: false,
								initialPosition: 3,
								min: 1,
								max: 6,
								label: i18n.__( 'Number of Slides', 'merchandiser-extender' ),
								onChange: function( newNumber ) {
									props.setAttributes( { slides: newNumber } );
									props.setAttributes( { activeTab: '1' } );
								},
							}
						),
						el(
							ToggleControl,
							{
								key: "gbt_18_mc_slider_pagination",
	              				label: i18n.__( 'Pagination Bullets', 'merchandiser-extender' ),
	              				checked: attributes.pagination,
	              				onChange: function() {
									props.setAttributes( { pagination: ! attributes.pagination } );
								},
							}
						),
						el(
							ToggleControl,
							{
								key: "gbt_18_mc_slider_arrows",
	              				label: i18n.__( 'Navigation Arrows', 'merchandiser-extender' ),
	              				checked: attributes.arrows,
	              				onChange: function() {
									props.setAttributes( { arrows: ! attributes.arrows } );
								},
							}
						),
						el(
							PanelColorSettings,
							{
								key: 'gbt_18_mc_slider_arrows_color',
								title: i18n.__( 'Colors', 'merchandiser-extender' ),
								initialOpen: false,
								colorSettings: getColors()
							},
						),
					),
				),
				el( 'div',
					{
						key: 				'gbt_18_mc_editor_slider_wrapper',
						className: 			'gbt_18_mc_editor_slider_wrapper',
						'data-tab-active': 	attributes.activeTab
					},
					el( 'div',
						{
							key: 		'gbt_18_mc_editor_slider_tabs',
							className: 	'gbt_18_mc_editor_slider_tabs'
						},
						getTabs()
					),
					el(
						InnerBlocks,
						{
							key: 'gbt_18_mc_editor_slider_inner_blocks ',
							template: getTemplates(),
	                        templateLock: "all",
	            			allowedBlocksNames: ["getbowtied/mc-slide"]
						},
					),
				),
			];
		},

		save: function( props ) {
			attributes = props.attributes;
			return el(
				'div',
				{
					key: 'gbt_18_mc_slider_wrapper',
					className: 'gbt_18_mc_slider_wrapper'
				},
				el(
					'div',
					{
						key: 'gbt_18_mc_slider_container',
						className: attributes.fullHeight ? 'gbt_18_mc_slider_container swiper-container full_height' : 'gbt_18_mc_slider_container swiper-container',
						style:
						{
							height: ! attributes.fullHeight ? attributes.customHeight + 'px' : '',
						}
					},
					el(
						'div',
						{
							key: 'swiper-wrapper',
							className: 'swiper-wrapper'
						},
						el( InnerBlocks.Content, { key: 'slide-content' } ),
					),
					!! attributes.pagination && el(
						'div',
						{
							key: 'gbt_18_mc_slider_pagination',
							className: 'gbt_18_mc_slider_pagination',
							style:
							{
								color: attributes.paginationColor
							}
						}
					)
				),
				!! attributes.arrows && el(
					'div',
					{
						key: 'swiper-button-prev',
						className: 'gbt_18_mc_slider_button_prev',
					},
					el( SVG,
						{
							key: 'gbt_18_mc_slider_button_prev_svg',
							xmlns:"http://www.w3.org/2000/svg",
							focusable: 'false',
							viewBox:"0 0 75 14",
							style:
							{
								fill: props.attributes.arrowsColor,
							}
						},
						el( Path,
							{
								key: 'gbt_18_mc_slider_button_prev_svg_path',
								d:"M7.45101521,0.192896598 C7.89901521,-0.133103402 8.52301521,-0.0361034022 8.84801521,0.409896598 C9.17401521,0.854896598 9.07701521,1.4808966 8.63201521,1.8068966 L8.63201521,1.8068966 L3.149,5.818 L74.4540152,5.8188966 L74.4540152,7.8188966 L3.093,7.818 L8.62701521,11.8288966 C9.04055367,12.1270504 9.15671935,12.6833818 8.91730925,13.1187846 L8.85001521,13.2248966 C8.65401521,13.4938966 8.34901521,13.6378966 8.03901521,13.6378966 C7.83501521,13.6378966 7.63001521,13.5758966 7.45401521,13.4478966 L7.45401521,13.4478966 L1.08201521,8.8308966 C0.396015212,8.3338966 0.00101521243,7.6108966 7.57719141e-06,6.8478966 C-0.00198478757,6.0848966 0.389015212,5.3598966 1.07301521,4.8598966 L1.07301521,4.8598966 Z",
							}
						)
					),
				),
				!! attributes.arrows && el(
					'div',
					{
						key: 'swiper-button-next',
						className: 'gbt_18_mc_slider_button_next',
					},
					el( SVG,
						{
							key: 'gbt_18_mc_slider_button_next_svg',
							xmlns:"http://www.w3.org/2000/svg",
							focusable: 'false',
							viewBox:"0 0 75 14",
							style:
							{
								fill: props.attributes.arrowsColor,
							}
						},
						el( Path,
							{
								key: 'gbt_18_mc_slider_button_next_svg_path',
								d:"M66.5944205,0.198018246 L72.933528,4.988933 C73.613357,5.50220863 74.0019727,6.2464583 73.9999925,7.02971691 C73.998991,7.81297553 73.6063997,8.55517209 72.9245828,9.06536807 L66.5914388,13.8049553 C66.4165121,13.9363538 66.2127621,14 66.0100061,14 C65.7018965,14 65.3987563,13.8521766 65.2039515,13.5760343 C64.8819273,13.1171659 64.9803236,12.4745448 65.4255917,12.1429688 L70.925,8.026 L4.26325641e-14,8.02649819 L4.26325641e-14,5.97339566 L70.87,5.973 L65.4206222,1.85487199 C64.9783358,1.52021628 64.8819273,0.877595184 65.2059393,0.420779871 C65.5289575,-0.0370619931 66.1491524,-0.136637466 66.5944205,0.198018246 Z",
							}
						)
					),
				),
			);
		},

		deprecated: [
			{
				attributes: attributes,

				save: function( props ) {
					attributes = props.attributes;
					return el(
						'div',
						{
							key: 'gbt_18_mc_slider_wrapper',
							className: 'gbt_18_mc_slider_wrapper'
						},
						el(
							'div',
							{
								key: 'gbt_18_mc_slider_container',
								className: attributes.fullHeight ? 'gbt_18_mc_slider_container swiper-container full_height' : 'gbt_18_mc_slider_container swiper-container',
								style:
								{
									height: attributes.customHeight + 'px'
								}
							},
							el(
								'div',
								{
									key: 'swiper-wrapper',
									className: 'swiper-wrapper'
								},
								el( InnerBlocks.Content, { key: 'slide-content' } ),
							),
							!! attributes.pagination && el(
								'div',
								{
									key: 'gbt_18_mc_slider_pagination',
									className: 'gbt_18_mc_slider_pagination',
									style:
									{
										color: attributes.paginationColor
									}
								}
							)
						),
						!! attributes.arrows && el(
							'div',
							{
								key: 'swiper-button-prev',
								className: 'gbt_18_mc_slider_button_prev',
								style:
								{
									backgroundColor: attributes.arrowsColor
								}
							},
						),
						!! attributes.arrows && el(
							'div',
							{
								key: 'swiper-button-next',
								className: 'gbt_18_mc_slider_button_next',
								style:
								{
									backgroundColor: attributes.arrowsColor
								}
							},
						),
					);
				},
			}
		]
	} );

} )(
	window.wp.blocks,
	window.wp.components,
	window.wp.editor,
	window.wp.i18n,
	window.wp.element
);
