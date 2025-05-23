<?php
/**
 * YITH wishlist integration
 *
 * @author      UX Themes
 * @package     Flatsome/Integrations
 */

if ( ! function_exists( 'flatsome_wishlist_integrations_scripts' ) ) {
	/**
	 * Enqueues wishlist integrations scripts
	 */
	function flatsome_wishlist_integrations_scripts() {
		global $integrations_uri;

		wp_dequeue_style( 'yith-wcwl-main' );
		wp_deregister_style( 'yith-wcwl-main' );
		wp_dequeue_style( 'yith-wcwl-font-awesome' );
		wp_deregister_style( 'yith-wcwl-font-awesome' );

		// TODO 4.0 Move and apply on AJAX search plugin.
		wp_dequeue_style( 'yith_wcas_frontend' );
		wp_deregister_style( 'yith_wcas_frontend' );

		wp_enqueue_script( 'flatsome-woocommerce-wishlist', $integrations_uri . '/wc-yith-wishlist/wishlist.js', array( 'jquery', 'flatsome-js' ), flatsome()->version(), true );
		wp_enqueue_style( 'flatsome-woocommerce-wishlist', $integrations_uri . '/wc-yith-wishlist/wishlist.css', 'flatsome-woocommerce-style', flatsome()->version() );
	}
}

add_action( 'wp_enqueue_scripts', 'flatsome_wishlist_integrations_scripts' );

/**
 * Force YITH Wishlist to use PHP templates.
 *
 * @return string
 */
function flatsome_yith_wcwl_rendering_method(): string {
	return 'php-templates';
}

add_filter( 'yith_wcwl_rendering_method', 'flatsome_yith_wcwl_rendering_method' );

if ( ! function_exists( 'flatsome_wishlist_account_item' ) ) {
	/**
	 * Add wishlist button to my account dropdown
	 */
	function flatsome_wishlist_account_item() {
		$page_id = get_option( 'yith_wcwl_wishlist_page_id' );
		if ( ! $page_id ) {
			return;
		}

		$wishlist_page = yith_wcwl_object_id( $page_id );
		?>
		<li class="wishlist-account-element <?php if ( is_page( $wishlist_page ) ) echo 'active'; ?>">
			<a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>"><?php echo get_the_title( $wishlist_page ); ?></a>
		</li>
		<?php
	}
}
add_action( 'flatsome_account_links', 'flatsome_wishlist_account_item' );


if ( ! function_exists( 'flatsome_product_wishlist_button' ) ) {
	/**
	 * Add wishlist Button to Product Image
	 */
	function flatsome_product_wishlist_button() {
		$icon                = get_theme_mod( 'wishlist_icon', 'heart' );
		if ( ! $icon ) $icon = 'heart';
		?>
		<div class="wishlist-icon">
			<button class="wishlist-button button is-outline circle icon" aria-label="<?php echo esc_html__( 'Wishlist', 'flatsome' ); ?>">
				<?php echo get_flatsome_icon( 'icon-' . $icon ); ?>
			</button>
			<div class="wishlist-popup dark">
				<?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>
			</div>
		</div>
		<?php
	}
}

add_action( 'flatsome_product_image_tools_top', 'flatsome_product_wishlist_button', 2 );
add_action( 'flatsome_product_box_tools_top', 'flatsome_product_wishlist_button', 2 );

if ( ! function_exists( 'flatsome_header_wishlist' ) ) {
	/**
	 * Registers the wishlist header element.
	 *
	 * @param array $elements Registered header elements.
	 *
	 * @return array
	 */
	function flatsome_header_wishlist( $elements ) {
		$elements['wishlist'] = esc_html__( 'Wishlist', 'flatsome' );

		return $elements;
	}
}

add_filter( 'flatsome_header_element', 'flatsome_header_wishlist' );

if ( ! function_exists( 'flatsome_update_wishlist_count' ) ) {
	/**
	 * Update Wishlist Count
	 */
	function flatsome_update_wishlist_count() {
		$count = function_exists( 'yith_wcwl_wishlists' )
			? yith_wcwl_wishlists()->count_items_in_wishlist()
			: YITH_WCWL()->count_products();

		wp_send_json( $count );
	}
}

add_action( 'wp_ajax_flatsome_update_wishlist_count', 'flatsome_update_wishlist_count' );
add_action( 'wp_ajax_nopriv_flatsome_update_wishlist_count', 'flatsome_update_wishlist_count' );
