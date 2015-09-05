<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

?>


<?php

	if ( 1 !== $woocommerce_loop['loop'] &&  1 === $woocommerce_loop['loop'] % 2 ) {
		echo '<div class="clearfix  visible-xs"></div>';
	}
	if ( 1 !== $woocommerce_loop['loop'] &&  1 === $woocommerce_loop['loop'] % 4 ) {
		echo '<div class="clearfix  hidden-xs"></div>';
	}

?>


<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

<div class="col-xs-6 col-sm-3">
	<div <?php post_class( 'products__single' ); ?>>
		<?php woocommerce_get_template( 'loop/sale-flash.php' ); ?>

		<figure class="products__image">
			<a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog', array( 'class' => 'product__image' ) ); ?></a>
			<div class="product-overlay">
				<a class="product-overlay__more" href="<?php the_permalink(); ?>">
					<span class="glyphicon glyphicon-search"></span>
				</a>
				<?php
					wc_get_template( 'loop/add-to-cart.php' );
				?>
				<div class="product-overlay__stock">
					<span class="<?php echo $product->is_in_stock() ? 'in' : 'out-of'; ?>-stock">&bull;</span> <span class="in-stock--text"><?php echo $product->is_in_stock() ? __( 'In stock', 'organique_wp' ) : __( 'Out of stock', 'organique_wp' ); ?></span>
				</div>
			</div>
		</figure>

		<div class="row">
			<div class="col-xs-12">
				<div class="products__price">
					<?php if ( $price_html = $product->get_price_html() ) : ?>
						<?php echo $price_html;?>
					<?php endif; ?>
				</div>
				<h5 class="products__title">
					<a class="products__link  js--isotope-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h5>
			</div>
		</div>
	</div>
</div>

<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>