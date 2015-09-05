<?php
/**
 * WooCommerce functions file
 *
 * @package Organique
 */

if ( is_woocommerce_active() ) {

	// remove all the woocommerce CSS
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );

	// Delete page title for WooCommerce pages
	add_filter( 'woocommerce_show_page_title', '__return_false' );


	/**
	 * Theme compatibility
	 *
	 * @link http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
	 */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);



	/**
	 * Missing HTML markup before and after the shop items
	 */
	add_action('woocommerce_before_main_content', 'organique_theme_wrapper_start', 11);
	add_action('woocommerce_after_main_content', 'organique_theme_wrapper_end', 11);

	function organique_theme_wrapper_start() {
		$sidebar = organique_get_shop_sidebar();

		?>
		<div class="container  push-down-60">
			<div class="row">

				<div class="col-xs-12<?php echo 'no' !== $sidebar ? '  col-sm-9' : ''; echo 'left' === $sidebar ? '  col-sm-push-3' : ''; ?>" role="main">

					<div class="row">
						<div class="col-xs-6">
							<div class="post-title">
								<h3><?php echo lighted_title( woocommerce_page_title( false ) );?></h3>
							</div>
						</div>

						<div class="col-xs-6  right">
							<?php if ( function_exists( 'woocommerce_catalog_ordering' ) ): ?>
								<?php woocommerce_catalog_ordering(); ?>
							<?php endif ?>
						</div>
					</div>

					<div class="woocommerce">
		<?php
	}

	function organique_theme_wrapper_end() {

		$sidebar = organique_get_shop_sidebar();

		?>
					</div><!-- /.woocommerce -->
				</div><!-- /role=main -->

				<?php if ( "no" !== $sidebar ) : ?>
				<div class="col-xs-12  col-sm-3<?php echo 'left' === $sidebar ? '  col-sm-pull-9' : ''; ?>">
					<aside class="sidebar  sidebar--blog" role="complementary">
						<?php dynamic_sidebar( 'shop-page-sidebar' ); ?>
					</aside>
				</div>
				<?php endif; ?>

			</div><!-- /row -->
		</div><!-- /container -->
		<?php
	}


	/**
	 * Removes the confusing body.woocommerce so it is easier and more
	 * reliable to target the elements within WooCommerce implementation
	 *
	 * @param  array $classes
	 * @return array
	 */
	function organique_woo_body_class( $classes ) {
		$classes = (array) $classes;
		$class_to_remove = 'woocommerce';

		if ( in_array( $class_to_remove, $classes ) ) {
			unset( $classes[ array_search( $class_to_remove, $classes ) ] );
		}

		return $classes;
	}
	add_filter( 'body_class', 'organique_woo_body_class', 11 );


	/**
	 * Custom sale badget
	 */
	function organique_custom_sale_flash() {
		return '<div class="stamp green">' . get_theme_mod( 'sale_stamp_text', 'Sale!' ) . '</div>';
	}
	add_filter( 'woocommerce_sale_flash', 'organique_custom_sale_flash', 10, 0 );

	/**
	 * Custom Add to Cart Button
	 */

	function organique_single_add_to_cart_text() {
		return __( 'Add to shopping cart', 'organique_wp' );
	}
	add_filter( 'woocommerce_product_single_add_to_cart_text', 'organique_single_add_to_cart_text', 10, 0 );


	/**
	 * Remove add to cart after filter
	 */
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

	/**
	 * Remove the woocommerce sidebar
	 */
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

	/**
	 * Remove breadcrumbs on the products archive page
	 */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );


	/**
	 * Moved the results count between grid and pagination
	 */
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 9 );

	/**
	 * Remove the default catalog ordering
	 */
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );


	/**
	 * Remove rating in the title of the product
	 */
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11 );
	add_action( 'woocommerce_single_product_summary', 'organique_in_stock_indicator', 12 );


	/**
	 * Remove the sale badge for the single product
	 */
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

	/**
	 * Move the categories above the product title
	 */
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 4 );

	/**
	 * Change the category image thumbnail
	 */
	remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
	add_action( 'woocommerce_before_subcategory_title', 'organique_subcategory_thumbnail', 11 );

	if ( ! function_exists( 'organique_subcategory_thumbnail' ) ) {
		function organique_subcategory_thumbnail( $category ) {
			ob_start();
			woocommerce_subcategory_thumbnail( $category );
			$html = ob_get_clean();

			echo str_replace( '<img' , '<img class="product__image"', $html );
		}
	}



	/**
	 * Filters for my account page - for titles
	 */
	add_action( 'woocommerce_my_account_my_orders_title', 'lighted_title' );
	add_action( 'woocommerce_my_account_my_downloads_title', 'lighted_title' );
	add_action( 'woocommerce_my_account_my_address_title', 'lighted_title' );
	add_action( 'woocommerce_my_account_my_address_title', 'lighted_title' );



	/**
	 * Display custom number of products per page
	 * @param  integer $cols
	 * @return integer
	 */
	function custom_number_of_products_per_page( $cols ) {
		return intval( get_theme_mod( 'products_per_page', $cols ) );
	}
	add_filter( 'loop_shop_per_page', 'custom_number_of_products_per_page', 20 );



	/**
	 * Returns the styled add to cart link for Organique theme
	 * @param  string $html
	 * @param  wp_query $product
	 * @return string
	 */
	function organique_loop_add_to_cart_link( $html, $product ) {
		return sprintf(
			'<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="product-overlay__cart %s product_type_%s">%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( $product->id ),
			esc_attr( $product->get_sku() ),
			$product->is_purchasable() ? 'add_to_cart_button' : '',
			esc_attr( $product->product_type ),
			'+<span class="glyphicon glyphicon-shopping-cart"></span>'
		);
	}
	add_filter( 'woocommerce_loop_add_to_cart_link', 'organique_loop_add_to_cart_link', 20, 2 );


	/**
	 * Different indicator for the stock status
	 * @return void
	 */
	function organique_in_stock_indicator() {
		global $post, $product;
		?>

		<div class="in-stock--single-product">
			<span class="dot-stock-<?php echo $product->is_in_stock() ? 'success' : 'danger'; ?>">&bull;</span>
			<span class="stock-<?php echo $product->is_in_stock() ? 'success' : 'danger'; ?>"><?php echo $product->is_in_stock() ? __( 'In stock' , 'organique_wp' ) : __( 'Out of Stock' , 'organique_wp' ); ?></span>
		</div>
		<?php
	}

	/**
	 * Get the position of the sidebar for the shop pages, conditionally for the single product
	 */
	function organique_get_shop_sidebar() {
		if ( is_product() ) {
			return get_theme_mod( 'single_product_sidebar', 'no' );
		} else {
			return get_post_meta( (int)get_option( 'woocommerce_shop_page_id' ) , 'sidebar_position', true );
		}
	}


	/**
	 * Since price slider widget is pulled in the custom filters widget, we need to enqueue scripts for that widget as well
	 * The only way to do this was to extend the existing class from WC
	 *
	 * @since 1.2.0
	 * @see includes/class-wc-query.php
	 */

	if ( class_exists( 'WC_Query' ) ) {
		class Organique_WC_Query extends WC_Query {
			public function __construct() {
				parent::__construct();
				add_action( 'init', array( $this, 'organique_layered_nav_init' ) );
				add_action( 'init', array( $this, 'organique_price_filter_init' ) );
			}

			/**
			 * Layered Nav Init for custom widget
			 *
			 * @copied from includes/class-wc-query.php
			 */
			public function organique_layered_nav_init( ) {

				if ( is_active_widget( false, false, 'organique_price_filter', true ) && ! is_admin() ) {

					global $_chosen_attributes;

					$_chosen_attributes = array();

					$attribute_taxonomies = wc_get_attribute_taxonomies();
					if ( $attribute_taxonomies ) {
						foreach ( $attribute_taxonomies as $tax ) {

							$attribute       = wc_sanitize_taxonomy_name( $tax->attribute_name );
							$taxonomy        = wc_attribute_taxonomy_name( $attribute );
							$name            = 'filter_' . $attribute;
							$query_type_name = 'query_type_' . $attribute;

							if ( ! empty( $_GET[ $name ] ) && taxonomy_exists( $taxonomy ) ) {

								$_chosen_attributes[ $taxonomy ]['terms'] = explode( ',', $_GET[ $name ] );

								if ( empty( $_GET[ $query_type_name ] ) || ! in_array( strtolower( $_GET[ $query_type_name ] ), array( 'and', 'or' ) ) )
									$_chosen_attributes[ $taxonomy ]['query_type'] = apply_filters( 'woocommerce_layered_nav_default_query_type', 'and' );
								else
									$_chosen_attributes[ $taxonomy ]['query_type'] = strtolower( $_GET[ $query_type_name ] );

							}
						}
					}

					add_filter('loop_shop_post_in', array( $this, 'layered_nav_query' ) );
				}
			}

			/**
			 * Price filter Init for custom widget
			 *
			 * @copied from includes/class-wc-query.php
			 */
			public function organique_price_filter_init() {
				if ( is_active_widget( false, false, 'organique_price_filter', true ) && ! is_admin() ) {

					$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

					wp_register_script( 'wc-price-slider', WC()->plugin_url() . '/assets/js/frontend/price-slider' . $suffix . '.js', array( 'jquery-ui-slider' ), WC_VERSION, true );

					wp_localize_script( 'wc-price-slider', 'woocommerce_price_slider_params', array(
						'currency_symbol' => get_woocommerce_currency_symbol(),
						'currency_pos'    => get_option( 'woocommerce_currency_pos' ),
						'min_price'       => isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '',
						'max_price'       => isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : ''
					) );

					add_filter( 'loop_shop_post_in', array( $this, 'price_filter' ) );
				}
			}
		}
		return new Organique_WC_Query();
	}
} // is_woocommerce_active