( function( blocks, components, editor, i18n, element ) {

	const el = element.createElement;

	/* Blocks */
	const registerBlockType = wp.blocks.registerBlockType;
	const apiFetch = wp.apiFetch;

	const {
		TextControl,
		RadioControl,
		SelectControl,
		ToggleControl,
		RangeControl,
		SVG,
		Path,
	} = wp.components;

	const {
		InspectorControls,
		PanelColorSettings,
	} = wp.blockEditor;

	/* Register Block */
	registerBlockType( 'getbowtied/mc-posts-slider', {
		title: i18n.__( 'Posts Slider', 'merchandiser-extender' ),
		icon: el( SVG, { xmlns:'http://www.w3.org/2000/svg', viewBox:'0 0 24 24' },
				el( Path, { d:'M15 7v9h-5V7h5m6-2h-3v13h3V5zm-4 0H8v13h9V5zM7 5H4v13h3V5z' } )
			),
		category: 'merchandiser',
		supports: {
			align: [ 'center', 'wide', 'full' ],
		},
		attributes: {
			/* posts source */
			queryPosts: {
				type: 'string',
				default: '',
			},
			queryPostsLast: {
				type: 'string',
				default: '',
			},
			/* loader */
			isLoading: {
				type: 'bool',
				default: false,
			},
			/* Display by category */
			categoriesIDs: {
				type: 'string',
				default: ',',
			},
			categoriesSavedIDs: {
				type: 'string',
				default: '',
			},
			/* First Load */
			firstLoad: {
				type: 'boolean',
				default: true
			},
			/* Number of Posts */
			number: {
				type: 'number',
				default: '12'
			},
			/* Arrows */
			arrows: {
				type: 'boolean',
				default: true
			},
			/* Bullets */
			bullets: {
				type: 'boolean',
				default: true
			},
			/* Orderby */
			orderby: {
				type: 'string',
				default: 'date_desc'
			},
		},

		edit: function( props ) {

			var attributes = props.attributes;

			attributes.doneFirstLoad 		= attributes.doneFirstLoad || false;
			attributes.categoryOptions 		= attributes.categoryOptions || [];
			attributes.doneFirstPostsLoad 	= attributes.doneFirstPostsLoad || false;
			attributes.result 				= attributes.result || [];
			attributes.selectedSlide 		= attributes.selectedSlide || 0;

			//==============================================================================
			//	Helper functions
			//==============================================================================

			function _sortCategories( index, arr, newarr = [], level = 0) {
				for ( let i = 0; i < arr.length; i++ ) {
					if ( arr[i].parent == index) {
						arr[i].level = level;
						newarr.push(arr[i]);
						_sortCategories(arr[i].value, arr, newarr, level + 1 );
					}
				}

				return newarr;
			}

			function _verifyCatIDs( optionsIDs ) {

				let catArr = attributes.categoriesIDs;
				let categoriesIDs = attributes.categoriesIDs;

				if( catArr.substr(0,1) == ',' ) {
					catArr = catArr.substr(1);
				}
				if( catArr.substr(catArr.length - 1) == ',' ) {
					catArr = catArr.substring(0, catArr.length - 1);
				}

				if( catArr != ',' && catArr != '' ) {

					let newCatArr = catArr.split(',');
					let newArr = [];
					for (let i = 0; i < newCatArr.length; i++) {
						if( optionsIDs.indexOf(newCatArr[i]) == -1 ) {
							categoriesIDs = categoriesIDs.replace(',' + newCatArr[i].toString() + ',', ',');
						}
					}
				}

				if( attributes.categoriesIDs != categoriesIDs ) {
					props.setAttributes({ queryPosts: _buildQuery(categoriesIDs, attributes.number, attributes.orderby) });
					props.setAttributes({ queryPostsLast: _buildQuery(categoriesIDs, attributes.number, attributes.orderby) });
				}

				props.setAttributes({ categoriesIDs: categoriesIDs });
				props.setAttributes({ categoriesSavedIDs: categoriesIDs });
			}

			function _buildQuery( arr, nr, order ) {
				let query = '/wp/v2/posts?per_page=' + nr;

				if( arr.substr(0,1) == ',' ) {
					arr = arr.substr(1);
				}
				if( arr.substr(arr.length - 1) == ',' ) {
					arr = arr.substring(0, arr.length - 1);
				}

				if( arr != ',' && arr != '' ) {
					query = '/wp/v2/posts?categories=' + arr + '&per_page=' + nr;
				}

				switch (order) {
					case 'date_asc':
						query += '&orderby=date&order=asc';
						break;
					case 'date_desc':
						query += '&orderby=date&order=desc';
						break;
					case 'title_asc':
						query += '&orderby=title&order=asc';
						break;
					case 'title_desc':
						query += '&orderby=title&order=desc';
						break;
					default:
						break;
				}

				query += '&lang=' + posts_grid_vars.language;

				return query;
			}

			function _isChecked( needle, haystack ) {
				let idx = haystack.indexOf(needle.toString());
				if ( idx > - 1) {
					return true;
				}
				return false;
			}

			function _categoryClassName(parent, value) {
				if ( parent == 0) {
					return 'parent parent-' + value;
				} else {
					return 'child child-' + parent;
				}
			}

			function _isLoadingText(){
				if ( attributes.isLoading  === false ) {
					return i18n.__( 'Update', 'merchandiser-extender' );
				} else {
					return i18n.__( 'Updating', 'merchandiser-extender' );
				}
			}

			function _isDonePossible() {
				return ( (attributes.queryPosts.length == 0) || (attributes.queryPosts === attributes.queryPostsLast) );
			}

			function _isLoading() {
				if ( attributes.isLoading  === true ) {
					return 'is-busy';
				} else {
					return '';
				}
			}

			//==============================================================================
			//	Show posts functions
			//==============================================================================

			function getPosts() {
				let query = attributes.queryPosts;
				props.setAttributes({ queryPostsLast: query});

				if (query != '') {
					apiFetch({ path: query }).then(function (posts) {
						props.setAttributes({ result: posts});
						props.setAttributes({ isLoading: false});
						props.setAttributes({ doneFirstPostsLoad: true});
						props.setAttributes({ selectedSlide: 0});
					});
				}
			}

			function renderResults() {
				if ( attributes.firstLoad === true ) {
					apiFetch({ path: '/wp/v2/posts?per_page=12&orderby=date&order=desc&lang=' + posts_grid_vars.language }).then(function (posts) {
						props.setAttributes({ result: posts });
						props.setAttributes({ firstLoad: false });
						let query = '/wp/v2/posts?per_page=12&orderby=date&order=desc&lang=' + posts_grid_vars.language;
						props.setAttributes({queryPosts: query});
						props.setAttributes({ queryPostsLast: query});
					});
				}

				let posts = attributes.result;
				let postElements = [];
				let sliderElements = [];
				let wrapper = [];
				let count = 0;
				let selectedSlide = 0;
				let slide_no = 0;

				function isSelectedSlide( idx ) {
					if ( attributes.selectedSlide == idx ) {
						return 'selected';
					}
					else return '';
				}

				if( posts.length > 0) {

					for ( let i = 0; i < posts.length; i++ ) {

						var months = [
							i18n.__( 'January', 	'merchandiser-extender' ),
							i18n.__( 'February', 	'merchandiser-extender' ),
							i18n.__( 'March', 		'merchandiser-extender' ),
							i18n.__( 'April', 		'merchandiser-extender' ),
							i18n.__( 'May', 		'merchandiser-extender' ),
							i18n.__( 'June', 		'merchandiser-extender' ),
							i18n.__( 'July', 		'merchandiser-extender' ),
							i18n.__( 'August', 		'merchandiser-extender' ),
							i18n.__( 'September', 	'merchandiser-extender' ),
							i18n.__( 'October', 	'merchandiser-extender' ),
							i18n.__( 'November', 	'merchandiser-extender' ),
							i18n.__( 'December', 	'merchandiser-extender' )
							];

						let date = new Date(posts[i]['date']);
						date = months[date.getMonth()] + ' ' + date.getDate() + ', ' + date.getFullYear();

						let img = '';
						let img_class = 'gbt_18_mc_editor_posts_slider_noimg';
						if ( posts[i]['fimg_url'] ) { img = posts[i]['fimg_url']; img_class = 'gbt_18_mc_editor_posts_slider_with_img'; } else { img_class = 'gbt_18_mc_editor_posts_slider_noimg'; img = ''; };

						sliderElements.push(
							el( "div",
								{
									key: 		'gbt_18_mc_editor_posts_slider_item_' + posts[i].id,
									className: 	'gbt_18_mc_editor_posts_slider_item'
								},
								el( "div",
									{
										key: 		'gbt_18_mc_editor_posts_slider_item_img_' + i,
										className: 	'gbt_18_mc_editor_posts_slider_item_img ' + img_class
									},
									el( "img",
										{
											src: img,
											alt: 'post-image'
										}
									),
								),
								el( "div",
									{
										key: 		'gbt_18_mc_editor_posts_slider_item_text_' + i,
										className: 	'gbt_18_mc_editor_posts_slider_item_text'
									},
									el( "a",
										{
											key: 		'gbt_18_mc_editor_posts_slider_item_link_' + i,
											className: 	'gbt_18_mc_editor_posts_slider_item_link'
										},
										el( "span",
											{
												key: 		'gbt_18_mc_editor_posts_slider_item_link_wrapper_' + i,
												className: 	'gbt_18_mc_editor_posts_slider_item_link_wrapper',
											},
											el( "h4",
												{
													key: 		'gbt_18_mc_editor_posts_slider_item_title_' + i,
													className:  'gbt_18_mc_editor_posts_slider_item_title',
													dangerouslySetInnerHTML: { __html: posts[i]['title']['rendered'] },
												}
											),
											el( "span",
												{
													key: 		'gbt_18_mc_editor_posts_slider_item_date_' + i,
													className:  'gbt_18_mc_editor_posts_slider_item_date',
													dangerouslySetInnerHTML: { __html: date },
												}
											)
										),
									),
								)
							)
						);

						count++;

						if( count % 2 == 0 && count != posts.length) {
							wrapper.push(
								el( "div",
									{
										key: 		'gbt_18_mc_editor_posts_slider_slide_' + i,
										className: 	'gbt_18_mc_editor_posts_slider_slide ' + isSelectedSlide(slide_no)
									},
									sliderElements
								)
							);
							postElements.push(wrapper);
							wrapper = [];
							sliderElements = [];
							slide_no++;
						}
					}

					if( sliderElements != [] ) {
						wrapper.push(
							el( "div",
								{
									key: 		'gbt_18_mc_editor_posts_slider_slide',
									className: 	'gbt_18_mc_editor_posts_slider_slide ' + isSelectedSlide(slide_no)
								},
								sliderElements
							)
						);
						postElements.push(wrapper);
						wrapper = [];
						sliderElements = [];
						slide_no++;
					}
				}

				if( postElements.length > 1 ) {
					postElements.push(
						attributes.arrows && el( 'button',
							{
								key: 'swiper-button-prev',
								className: 'swiper-button-prev dashicon dashicons-arrow-left-alt2',
								onClick: function onClick() {
									const idx = attributes.selectedSlide;
									if ( idx - 1 >= 0) {
										props.setAttributes({ selectedSlide: idx - 1});
									} else {
										props.setAttributes({ selectedSlide: slide_no - 1});
									}
								}
							},
							el( SVG,
								{
									key: 		'swiper-button-prev-svg',
									xmlns: 		'http://www.w3.org/2000/svg',
									viewBox: 	'0 0 75 14',
								},
								el( Path,
									{
										d:"M7.45101521,0.192896598 C7.89901521,-0.133103402 8.52301521,-0.0361034022 8.84801521,0.409896598 C9.17401521,0.854896598 9.07701521,1.4808966 8.63201521,1.8068966 L8.63201521,1.8068966 L3.149,5.818 L74.4540152,5.8188966 L74.4540152,7.8188966 L3.093,7.818 L8.62701521,11.8288966 C9.04055367,12.1270504 9.15671935,12.6833818 8.91730925,13.1187846 L8.85001521,13.2248966 C8.65401521,13.4938966 8.34901521,13.6378966 8.03901521,13.6378966 C7.83501521,13.6378966 7.63001521,13.5758966 7.45401521,13.4478966 L7.45401521,13.4478966 L1.08201521,8.8308966 C0.396015212,8.3338966 0.00101521243,7.6108966 7.57719141e-06,6.8478966 C-0.00198478757,6.0848966 0.389015212,5.3598966 1.07301521,4.8598966 L1.07301521,4.8598966 Z"
									}
								),
						  	),
						),
						attributes.arrows && el( 'button',
							{
								key: 'swiper-button-next',
								className: 'swiper-button-next dashicon dashicons-arrow-right-alt2',
								onClick: function onClick() {
									const idx = attributes.selectedSlide;
									if ( idx + 1 < slide_no ) {
										props.setAttributes({ selectedSlide: idx + 1});
									} else {
										props.setAttributes({ selectedSlide: 0 });
									}
								}
							},
							el( SVG,
								{
									key: 		'swiper-button-prev-svg',
									xmlns: 		'http://www.w3.org/2000/svg',
									viewBox: 	'0 0 75 14',
								},
								el( Path,
									{
										d:"M66.5944205,0.198018246 L72.933528,4.988933 C73.613357,5.50220863 74.0019727,6.2464583 73.9999925,7.02971691 C73.998991,7.81297553 73.6063997,8.55517209 72.9245828,9.06536807 L66.5914388,13.8049553 C66.4165121,13.9363538 66.2127621,14 66.0100061,14 C65.7018965,14 65.3987563,13.8521766 65.2039515,13.5760343 C64.8819273,13.1171659 64.9803236,12.4745448 65.4255917,12.1429688 L70.925,8.026 L4.26325641e-14,8.02649819 L4.26325641e-14,5.97339566 L70.87,5.973 L65.4206222,1.85487199 C64.9783358,1.52021628 64.8819273,0.877595184 65.2059393,0.420779871 C65.5289575,-0.0370619931 66.1491524,-0.136637466 66.5944205,0.198018246 Z"
									}
								),
						  	),
						),
					);
				}

				return postElements;
			}

			function getBullets() {

				let bullets = [];
				let posts = attributes.result;

				if( posts.length > 0) {

					for ( let i = 0; i < posts.length / 2; i++ ) {

						bullets.push(
							el( 'div',
								{
									key: 'swiper-pagination-bullet_' + i,
									className: 'swiper-pagination-bullet'
								},
								i+1
							),
						);
					}
				}

				return bullets;
			}

			//==============================================================================
			//	Display Categories
			//==============================================================================

			function getCategories() {

				let categories_list = [];
				let options = [];
				let optionsIDs = [];
				let sorted = [];

				apiFetch({ path: '/wp/v2/categories?per_page=-1&lang=' + posts_grid_vars.language }).then(function (categories) {

				 	for( let i = 0; i < categories.length; i++) {
	        			options[i] = {'label': categories[i].name.replace(/&amp;/g, '&'), 'value': categories[i].id, 'parent': categories[i].parent, 'count': categories[i].count };
				 		optionsIDs[i] = categories[i].id.toString();
				 	}

				 	sorted = _sortCategories(0, options);
		        	props.setAttributes({categoryOptions: sorted });
		        	_verifyCatIDs(optionsIDs);
		        	props.setAttributes({ doneFirstLoad: true});
				});
			}

			function renderCategories( parent = 0, level = 0 ) {
				let categoryElements = [];
				let catArr = attributes.categoryOptions;
				if ( catArr.length > 0 )
				{
					for ( let i = 0; i < catArr.length; i++ ) {
						 if ( catArr[i].parent !=  parent ) { continue; };
						categoryElements.push(
							el(
								'li',
								{
									key: 'posts-slider-category-' + i,
									className: 'level-' + catArr[i].level,
								},
								el(
								'label',
									{
										key: 'posts-slider-category-label-' + i,
										className: _categoryClassName( catArr[i].parent, catArr[i].value ) + ' ' + catArr[i].level,
									},
									el(
									'input',
										{
											type:  'checkbox',
											key:   'category-checkbox-' + catArr[i].value,
											value: catArr[i].value,
											'data-index': i,
											'data-parent': catArr[i].parent,
											checked: _isChecked(','+catArr[i].value+',', attributes.categoriesIDs),
											onChange: function onChange(evt){
												let newCategoriesSelected = attributes.categoriesIDs;
												let index = newCategoriesSelected.indexOf(',' + evt.target.value + ',');
												if (evt.target.checked === true) {
													if (index == -1) {
														newCategoriesSelected += evt.target.value + ',';
													}
												} else {
													if (index > -1) {
														newCategoriesSelected = newCategoriesSelected.replace(',' + evt.target.value + ',', ',');
													}
												}
												props.setAttributes({ categoriesIDs: newCategoriesSelected });
												props.setAttributes({ queryPosts: _buildQuery(newCategoriesSelected, attributes.number, attributes.orderby) });
											},
										},
									),
									catArr[i].label,
									el(
										'sup',
										{},
										catArr[i].count,
									),
								),
								renderCategories( catArr[i].value, level+1)
							),
						);
					}
				}
				if (categoryElements.length > 0 ) {
					let wrapper = el('ul', {className: 'level-' + level}, categoryElements);
					return wrapper;
				} else {
					return;
				}
			}

			return [
				el(
					InspectorControls,
					{
						key: 'mc-posts-slider-inspector'
					},
					el(
						'div',
						{
							className: 'main-inspector-wrapper',
						},
						el( 'label', { className: 'components-base-control__label' }, i18n.__('Categories:', 'merchandiser-extender') ),
						el(
							'div',
							{
								className: 'category-result-wrapper',
							},
							attributes.categoryOptions.length < 1 && attributes.doneFirstLoad === false && getCategories(),
							renderCategories(),
						),
						el(
							SelectControl,
							{
								key: 'mc-posts-slider-order-by',
								options:
									[
										{ value: 'title_asc',   label: i18n.__( 'Alphabetical Ascending', 'merchandiser-extender' ) },
										{ value: 'title_desc',  label: i18n.__( 'Alphabetical Descending', 'merchandiser-extender' ) },
										{ value: 'date_asc',   	label: i18n.__( 'Date Ascending', 'merchandiser-extender' ) },
										{ value: 'date_desc',  	label: i18n.__( 'Date Descending', 'merchandiser-extender' ) },
									],
	              				label: i18n.__( 'Order By', 'merchandiser-extender' ),
	              				value: attributes.orderby,
	              				onChange: function( value ) {
	              					props.setAttributes( { orderby: value } );
	              					let newCategoriesSelected = attributes.categoriesIDs;
									props.setAttributes({ queryPosts: _buildQuery(newCategoriesSelected, attributes.number, value) });
								},
							}
						),
						el(
							RangeControl,
							{
								key: "mc-posts-slider-number",
								className: 'range-wrapper',
								value: attributes.number,
								allowReset: false,
								initialPosition: 12,
								min: 1,
								max: 20,
								label: i18n.__( 'Number of Posts', 'merchandiser-extender' ),
								onChange: function onChange(newNumber){
									props.setAttributes( { number: newNumber } );
									let newCategoriesSelected = attributes.categoriesIDs;
									props.setAttributes({ queryPosts: _buildQuery(newCategoriesSelected, newNumber, attributes.orderby) });
								},
							}
						),
						el(
							'button',
							{
								className: 'render-results components-button is-button is-default is-primary is-large ' + _isLoading(),
								disabled: _isDonePossible(),
								onClick: function onChange(e) {
									props.setAttributes({ isLoading: true });
									props.setAttributes({ categoriesSavedIDs: attributes.categoriesIDs });
									getPosts();
								},
							},
							_isLoadingText(),
						),
						el( 'hr', {} ),
						el(
							ToggleControl,
							{
								key: "mc-posts-slider-arrows",
								checked: attributes.arrows,
								label: i18n.__( 'Navigation Arrows', 'merchandiser-extender' ),
								onChange: function( newArrows ) {
									props.setAttributes( { arrows: newArrows } );
								},
							}
						),
						el(
							ToggleControl,
							{
								key: "mc-posts-slider-bullets",
								checked: attributes.bullets,
								label: i18n.__( 'Navigation Bullets', 'merchandiser-extender' ),
								onChange: function( newBullets ) {
									props.setAttributes( { bullets: newBullets } );
								},
							}
						),
					),
				),
				el( 'div',
					{
						key: 		'gbt_18_mc_editor_posts_slider',
						className: 	'gbt_18_mc_editor_posts_slider'
					},
					el(
						'div',
						{
							key: 		'gbt_18_mc_editor_posts_slider_wrapper',
							className: 	'gbt_18_mc_editor_posts_slider_wrapper',
						},
						attributes.result.length < 1 && attributes.doneFirstPostsLoad === false && getPosts(),
						renderResults(),
						attributes.bullets && el( 'div',
							{
								key: 		'swiper-pagination-bullets',
								className: 	'swiper-pagination-clickable swiper-pagination-bullets'
							},
							getBullets()
						),
					),
				),
			];
		},

		save: function(props) {
			return null;
		}
	});

} )(
	window.wp.blocks,
	window.wp.components,
	window.wp.editor,
	window.wp.i18n,
	window.wp.element
);
