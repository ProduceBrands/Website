<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

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

<?php if (false): ?>

<div class="span3">
	<div class="product">
		<div class="product-inner">

		<?php do_action( 'woocommerce_before_subcategory', $category ); ?>


		<div class="product-img">
			<div class="picture">
			<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
				<?php
					/**
					 * woocommerce_before_subcategory_title hook
					 *
					 * @hooked woocommerce_subcategory_thumbnail - 10
					 */
					do_action( 'woocommerce_before_subcategory_title', $category );
				?>
			</a>
			</div>
		</div>

		<div class="main-titles no-margin">
			<h4 class="title align-center">
				<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
				<?php
					echo $category->name;

					if ( $category->count > 0 )
						echo apply_filters( 'woocommerce_subcategory_count_html', ' (' . $category->count . ')', $category );
				?>
				</a>
			</h4>
		</div>

		<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
		?>


		<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
		</div>
	</div>
</div>
<?php endif ?>



<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

<div class="col-xs-6 col-sm-3">
	<div class="products__single">

		<figure class="products__image">
			<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
				<?php
					/**
					 * woocommerce_before_subcategory_title hook
					 *
					 * @hooked woocommerce_subcategory_thumbnail - 10
					 */
					do_action( 'woocommerce_before_subcategory_title', $category );
				?>
			</a>
		</figure>

		<h5 class="products__title">

			<?php
				echo $category->name;

				if ( $category->count > 0 )
					echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
			?>
		</h5>
	</div>
</div>

<?php do_action( 'woocommerce_after_subcategory', $category ); ?>