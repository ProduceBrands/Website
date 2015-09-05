<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="blocks-spacer">
		<!--  = Tabs with more info =  -->
		<div class="row">
			<div class="col-xs-12">
				<ul id="myTab" class="nav nav-tabs">
					<?php
					$c = 1;
					foreach ( $tabs as $key => $tab ) : ?>

						<li<?php echo $c === 1 ? " class='active'" : ''; ?>>
							<a data-toggle="tab" href="#tab-<?php echo $key ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
						</li>

					<?php
					$c++;
					endforeach; ?>
				</ul>
				<div class="tab-content">
					<?php
					$c = 1;
					foreach ( $tabs as $key => $tab ) : ?>

						<div class="fade tab-pane <?php if( $c == 1 ): echo " in active"; endif; ?>" id="tab-<?php echo $key ?>">
							 <?php call_user_func( $tab['callback'], $key, $tab ) ?>
						</div>

					<?php
					$c++;
					endforeach; ?>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>