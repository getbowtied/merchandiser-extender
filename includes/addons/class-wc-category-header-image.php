<?php

if ( ! class_exists( 'MCCategoryHeaderImage' ) ) :

	/**
	 * MCCategoryHeaderImage class.
	 *
	 * Adds a Header Image to WooCommerce Product Category.
	 *
	 * @since 1.3
	*/
	class MCCategoryHeaderImage {

		/**
		 * The single instance of the class.
		 *
		 * @since 1.3
		 * @var MCCategoryHeaderImage
		*/
		protected static $_instance = null;

		/**
		 * MCCategoryHeaderImage constructor.
		 *
		 * @since 1.3
		*/
		public function __construct() {
			add_action( 'product_cat_add_form_fields', array( $this, 'woocommerce_add_category_header_img' ) );
			add_action( 'product_cat_edit_form_fields', array( $this, 'woocommerce_edit_category_header_img' ), 10,2 );
			add_action( 'created_term', array( $this, 'woocommerce_category_header_img_save' ), 10,3 );
			add_action( 'edit_term', array( $this, 'woocommerce_category_header_img_save' ), 10,3 );
			add_filter( 'manage_edit-product_cat_columns', array( $this, 'woocommerce_product_cat_header_columns' ) );
			add_filter( 'manage_product_cat_custom_column', array( $this, 'woocommerce_product_cat_header_column' ), 10, 3 );

			add_action( 'plugins_loaded', function() {
				add_filter( 'body_class', array( $this, 'getbowtied_category_body_classes' ) );
			});

			add_filter( 'getbowtied_get_category_header_image', function() {
				return $this->woocommerce_get_header_image_url();
			} );
		}

		/**
		 * Ensures only one instance of MCCategoryHeaderImage is loaded or can be loaded.
		 *
		 * @since 1.3
		 *
		 * @return MCCategoryHeaderImage
		*/
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Adds body classes
		 *
		 * @since 1.3.1
		 * @return void
		*/
		public function getbowtied_category_body_classes($classes) {

		    $listing_header_src = $this->woocommerce_get_header_image_url();

		    if ( class_exists('WooCommerce') && function_exists('is_product_category') && is_product_category() && !empty($listing_header_src) ) {

		    	$header_transparent_class           = '';
                $header_transparent_scheme_class    = '';

                if( get_theme_mod('category_transparency', 'transparency_light') == 'inherit' ) {
                	if( get_theme_mod('header_transparent', 0) ) {
                		$header_transparent_class = 'header-transparent';
	                	if( get_theme_mod('header_transparent_scheme', 'dark') == 'light' ) {
	                		$header_transparent_scheme_class = 'header-transparent-light';
	                	} else if( get_theme_mod('header_transparent_scheme', 'dark') == 'dark' ) {
	                		$header_transparent_scheme_class = 'header-transparent-dark';
	                	}
	                }
                }

                if( get_theme_mod('category_transparency', 'transparency_light') == 'transparency_light' ) {
                	$header_transparent_class           = 'header-transparent';
	                $header_transparent_scheme_class    = 'header-transparent-light';
                }

                if( get_theme_mod('category_transparency', 'transparency_light') == 'transparency_dark' ) {
                	$header_transparent_class           = 'header-transparent';
	                $header_transparent_scheme_class    = 'header-transparent-dark';
                }

                $classes[] = $header_transparent_class . " " . $header_transparent_scheme_class;
		    }

		    return $classes;
		}

		/**
		 * Category Header fields.
		 *
		 * @since 1.3
		 * @return void
		*/
		public function woocommerce_add_category_header_img() {
			global $woocommerce;

			?>

			<div class="form-field">
				<label><?php esc_html_e( 'Header', 'getbowtied' ); ?></label>
				<div id="product_cat_header" style="float:left;margin-right:10px;"><img src="<?php echo wc_placeholder_img_src(); ?>" width="60px" height="60px" /></div>
				<div style="line-height:60px;">
					<input type="hidden" id="product_cat_header_id" name="product_cat_header_id" />
					<button type="submit" class="upload_header_button button"><?php esc_html_e( 'Upload/Add image', 'getbowtied' ); ?></button>
					<button type="submit" class="remove_header_image_button button"><?php esc_html_e( 'Remove image', 'getbowtied' ); ?></button>
				</div>

				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( ! jQuery('#product_cat_header_id').val() )
						jQuery('.remove_header_image_button').hide();

					// Uploading files
					var header_file_frame;

					jQuery(document).on( 'click', '.upload_header_button', function( event ){

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( header_file_frame ) {
							header_file_frame.open();
							return;
						}

						// Create the media frame.
						header_file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php esc_html_e( 'Choose an image', 'getbowtied' ); ?>',
							button: {
								text: '<?php esc_html_e( 'Use image', 'getbowtied' ); ?>',
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						header_file_frame.on( 'select', function() {
							attachment = header_file_frame.state().get('selection').first().toJSON();
							jQuery('#product_cat_header_id').val( attachment.id );
							jQuery('#product_cat_header img').attr('src', attachment.url );
							jQuery('.remove_header_image_button').show();
						});

						// Finally, open the modal.
						header_file_frame.open();

					});

					jQuery(document).on( 'click', '.remove_header_image_button', function( event ){
						jQuery('#product_cat_header img').attr('src', '<?php echo wc_placeholder_img_src(); ?>');
						jQuery('#product_cat_header_id').val('');
						jQuery('.remove_header_image_button').hide();
						return false;
					});

				</script>

				<div class="clear"></div>

			</div>

			<?php
		}

		/**
		 * Edit category header field.
		 *
		 * @since 1.3
		 *
		 * @param mixed $term Term (category) being edited
		 * @param mixed $taxonomy Taxonomy of the term being edited
		 *
		 * @return void
		*/
		public function woocommerce_edit_category_header_img( $term, $taxonomy ) {
			global $woocommerce;

			$display_type	= get_term_meta( $term->term_id, 'display_type', true );
			$image 			= '';
			$header_id 	= absint( get_term_meta( $term->term_id, 'header_id', true ) );
			if ($header_id) :
				$image = wp_get_attachment_url( $header_id );
			else :
				$image = wc_placeholder_img_src();
			endif;

			?>

			<tr class="form-field">
				<th scope="row" valign="top"><label><?php esc_html_e( 'Header', 'getbowtied' ); ?></label></th>
				<td>
					<div id="product_cat_header" style="float:left;margin-right:10px;"><img src="<?php echo ent2ncr($image); ?>" width="60px" height="60px" /></div>
					<div style="line-height:60px;">
						<input type="hidden" id="product_cat_header_id" name="product_cat_header_id" value="<?php echo ent2ncr($header_id); ?>" />
						<button type="submit" class="upload_header_button button"><?php esc_html_e( 'Upload/Add image', 'getbowtied' ); ?></button>
						<button type="submit" class="remove_header_image_button button"><?php esc_html_e( 'Remove image', 'getbowtied' ); ?></button>
					</div>

					<script type="text/javascript">

					if (jQuery('#product_cat_thumbnail_id').val() == 0)
						 jQuery('.remove_image_button').hide();

					if (jQuery('#product_cat_header_id').val() == 0)
						 jQuery('.remove_header_image_button').hide();

						// Uploading files
						var header_file_frame;

						jQuery(document).on( 'click', '.upload_header_button', function( event ){

							event.preventDefault();

							// If the media frame already exists, reopen it.
							if ( header_file_frame ) {
								header_file_frame.open();
								return;
							}

							// Create the media frame.
							header_file_frame = wp.media.frames.downloadable_file = wp.media({
								title: '<?php esc_html_e( 'Choose an image', 'getbowtied' ); ?>',
								button: {
									text: '<?php esc_html_e( 'Use image', 'getbowtied' ); ?>',
								},
								multiple: false
							});

							// When an image is selected, run a callback.
							header_file_frame.on( 'select', function() {
								attachment = header_file_frame.state().get('selection').first().toJSON();
								jQuery('#product_cat_header_id').val( attachment.id );
								jQuery('#product_cat_header img').attr('src', attachment.url );
								jQuery('.remove_header_image_button').show();
							});

							// Finally, open the modal.
							header_file_frame.open();
						});

						jQuery(document).on( 'click', '.remove_header_image_button', function( event ){
							jQuery('#product_cat_header img').attr('src', '<?php echo wc_placeholder_img_src(); ?>');
							jQuery('#product_cat_header_id').val('');
							jQuery('.remove_header_image_button').hide();
							return false;
						});

					</script>

					<div class="clear"></div>

				</td>

			</tr>

			<?php
		}

		/**
		 * Save category header image.
		 *
		 * @since 1.3
		 *
		 * @param mixed $term_id Term ID being saved
		 * @param mixed $tt_id
		 * @param mixed $taxonomy Taxonomy of the term being saved
		 *
		 * @return void
		 */
		public function woocommerce_category_header_img_save( $term_id, $tt_id, $taxonomy ) {
			if ( isset( $_POST['product_cat_header_id'] ) )
				update_term_meta( $term_id, 'header_id', absint( $_POST['product_cat_header_id'] ) );

			delete_transient( 'wc_term_counts' );
		}

		/**
		 * Header column added to category admin.
		 *
		 * @since 1.3
		 *
		 * @param mixed $columns
		 *
		 * @return void
		 */
		public function woocommerce_product_cat_header_columns( $columns ) {
			$new_columns = array();

			if( isset($columns['cb']) ) {
				$new_columns['cb'] = $columns['cb'];
			}

			$new_columns['thumb'] = esc_html__( 'Image', 'getbowtied' );
			$new_columns['header'] = esc_html__( 'Header', 'getbowtied' );
			unset( $columns['cb'] );
			unset( $columns['thumb'] );

			return array_merge( $new_columns, $columns );
		}

		/**
		 * Thumbnail column value added to category admin.
		 *
		 * @since 1.3
		 *
		 * @param mixed $columns
		 * @param mixed $column
		 * @param mixed $id
		 *
		 * @return void
		 */

		public function woocommerce_product_cat_header_column( $columns, $column, $id ) {
			global $woocommerce;

			if ( $column == 'header' ) {

				$image 			= '';
				$thumbnail_id 	= get_term_meta( $id, 'header_id', true );

				if ($thumbnail_id)
					$image = wp_get_attachment_url( $thumbnail_id );
				else
					$image = wc_placeholder_img_src();

				$columns .= '<img src="' . $image . '" alt="Thumbnail" class="wp-post-image" height="40" width="40" />';

			}

			return $columns;
		}

		/**
		 * Get category header image url.
		 *
		 * @since 1.3
		 *
		 * @param mixed $cat_ID -image's product category ID (if empty/false auto loads curent product category ID)
		 *
		 * @return mixed (string|false)
		 */
		public function woocommerce_get_header_image_url($cat_ID = false) {
			if ($cat_ID==false && is_product_category()){
				global $wp_query;

				// get the query object
				$cat = $wp_query->get_queried_object();

				// get the thumbnail id user the term_id
				$cat_ID = $cat->term_id;
			}

		    $thumbnail_id = get_term_meta($cat_ID, 'header_id', true );

		    // get the image URL
		   return wp_get_attachment_url( $thumbnail_id );

		}
	}

endif;

$mc_wc_cat_header = new MCCategoryHeaderImage;
