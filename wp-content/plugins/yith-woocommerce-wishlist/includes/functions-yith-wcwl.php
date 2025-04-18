<?php
/**
 * Functions file
 *
 * @package YITH\Wishlist\Functions
 * @author  YITH <plugins@yithemes.com>
 * @version 3.0.0
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly

/* === TESTER FUNCTIONS === */

if ( ! function_exists( 'yith_wcwl_is_wishlist' ) ) {
	/**
	 * Check if we're printing wishlist shortcode
	 *
	 * @return bool
	 * @since 2.0.0
	 */
	function yith_wcwl_is_wishlist() {
		global $yith_wcwl_is_wishlist;

		return $yith_wcwl_is_wishlist;
	}
}

if ( ! function_exists( 'yith_wcwl_is_wishlist_page' ) ) {
	/**
	 * Check if current page is wishlist
	 *
	 * @return bool
	 * @since 2.0.13
	 */
	function yith_wcwl_is_wishlist_page() {
		$wishlist_page_id = YITH_WCWL()->get_wishlist_page_id();

		if ( ! $wishlist_page_id ) {
			return false;
		}

		/**
		 * APPLY_FILTERS: yith_wcwl_is_wishlist_page
		 *
		 * Filter whether the current page is the wishlist page.
		 *
		 * @param bool $is_wishlist_page Whether current page is wishlist page or not
		 *
		 * @return bool
		 */
		return apply_filters( 'yith_wcwl_is_wishlist_page', is_page( $wishlist_page_id ) );
	}
}

if ( ! function_exists( 'yith_wcwl_is_single' ) ) {
	/**
	 * Returns true if it finds that you're printing a single product
	 * Should return false in any loop (including the ones inside single product page)
	 *
	 * @return bool Whether you're currently on single product template
	 * @since 3.0.0
	 */
	function yith_wcwl_is_single() {
		/**
		 * APPLY_FILTERS: yith_wcwl_is_single
		 *
		 * Filter whether the ATW button is being printed in a single product page.
		 *
		 * @param bool $is_product Whether current page is a product page or not
		 *
		 * @return bool
		 */
		return apply_filters( 'yith_wcwl_is_single', is_product() && ! in_array( wc_get_loop_prop( 'name' ), array( 'related', 'up-sells' ), true ) && ! wc_get_loop_prop( 'is_shortcode' ) );
	}
}

if ( ! function_exists( 'yith_wcwl_is_mobile' ) ) {
	/**
	 * Returns true if we're currently on mobile view
	 *
	 * @return bool Whether you're currently on mobile view
	 * @since 3.0.0
	 */
	function yith_wcwl_is_mobile() {
		global $yith_wcwl_is_mobile;

		/**
		 * APPLY_FILTERS: yith_wcwl_is_wishlist_responsive
		 *
		 * Filter if is enabled the responsive layout.
		 *
		 * @param bool $is_wishlist_responsive Whether responsive layout is enabled or not
		 *
		 * @return bool
		 */
		return apply_filters( 'yith_wcwl_is_wishlist_responsive', true ) && ( wp_is_mobile() || $yith_wcwl_is_mobile );
	}
}

/* === TEMPLATE FUNCTIONS === */

if ( ! function_exists( 'yith_wcwl_locate_template' ) ) {
	/**
	 * Locate the templates and return the path of the file found
	 *
	 * @param string $path Path to locate.
	 * @param array  $var  Unused.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	function yith_wcwl_locate_template( $path, $var = null ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter, Universal.NamingConventions.NoReservedKeywordParameterNames.varFound
		$woocommerce_base = WC()->template_path();

		$template_woocommerce_path = $woocommerce_base . $path;
		$template_path             = '/' . $path;
		$plugin_path               = YITH_WCWL_DIR . 'templates/' . $path;

		$located = locate_template(
			array(
				$template_woocommerce_path, // Search in <theme>/woocommerce/.
				$template_path,             // Search in <theme>/.
			)
		);

		if ( ! $located && file_exists( $plugin_path ) ) {
			return apply_filters( 'yith_wcwl_locate_template', $plugin_path, $path );
		}

		/**
		 * APPLY_FILTERS: yith_wcwl_locate_template
		 *
		 * Filter the location of the templates.
		 *
		 * @param string $located Template found
		 * @param string $path    Template path
		 *
		 * @return string
		 */
		return apply_filters( 'yith_wcwl_locate_template', $located, $path );
	}
}

if ( ! function_exists( 'yith_wcwl_get_template' ) ) {
	/**
	 * Retrieve a template file.
	 *
	 * @param string $path   Path to get.
	 * @param mixed  $var    Variables to send to template.
	 * @param bool   $return Whether to return or print the template.
	 *
	 * @return string|void
	 * @since 1.0.0
	 */
	function yith_wcwl_get_template( $path, $var = null, $return = false ) { // phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames.varFound, Universal.NamingConventions.NoReservedKeywordParameterNames.returnFound
		$located = yith_wcwl_locate_template( $path, $var );

		if ( $var && is_array( $var ) ) {
			$atts = $var;
			extract( $var ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		}

		if ( $return ) {
			ob_start();
		}

		if (file_exists($located)) {
			// include file located.
			include $located;
		}

		if ( $return ) {
			return ob_get_clean();
		}
	}
}

if ( ! function_exists( 'yith_wcwl_get_view' ) ) {
	/**
	 * Retrieve a template file.
	 *
	 * @param string $path   Path to get.
	 * @param mixed  $args   the args to use in the view.
	 * @param bool   $return Whether to return or print the template.
	 *
	 * @return string|void
	 * @since 1.0.0
	 */
	function yith_wcwl_get_view( $path, $args = null, $return = false ) {
		$fullpath = strpos( $path, YITH_WCWL_VIEWS ) === 0 ? $path : YITH_WCWL_VIEWS . $path;
		if ( $args && is_array( $args ) ) {
			$atts = $args;
			extract( $args ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		}

		if ( $return ) {
			ob_start();
		}

		file_exists( $fullpath ) && include $fullpath;

		if ( $return ) {
			return ob_get_clean();
		}
	}
}

if ( ! function_exists( 'yith_wcwl_get_template_part' ) ) {
	/**
	 * Search and include a template part
	 *
	 * @param string $template        Template to include.
	 * @param string $template_part   Template part.
	 * @param string $template_layout Template variation.
	 * @param array  $var             Array of variables to be passed to template.
	 * @param bool   $return          Whether to return template or print it.
	 *
	 * @return string|null
	 */
	function yith_wcwl_get_template_part( $template = '', $template_part = '', $template_layout = '', $var = array(), $return = false ) { // phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames.varFound, Universal.NamingConventions.NoReservedKeywordParameterNames.returnFound
		if ( ! empty( $template_part ) ) {
			$template_part = '-' . $template_part;
		}

		if ( ! empty( $template_layout ) ) {
			$template_layout = '-' . $template_layout;
		}

		/**
		 * APPLY_FILTERS: yith_wcwl_template_part_hierarchy
		 *
		 * Filter the hierarchy structure of the plugin templates and templates parts.
		 *
		 * @param array  $template_hierarchy Template hierarchy
		 * @param string $template           Template
		 * @param string $template_part      Template part
		 * @param string $template_layout    Template layout
		 * @param array  $var                Array of data
		 *
		 * @return array
		 */
		$template_hierarchy = apply_filters(
			'yith_wcwl_template_part_hierarchy',
			array_merge(
				! yith_wcwl_is_mobile() ? array() : array(
					"wishlist-{$template}{$template_layout}{$template_part}-mobile.php",
					"wishlist-{$template}{$template_part}-mobile.php",
				),
				array(
					"wishlist-{$template}{$template_layout}{$template_part}.php",
					"wishlist-{$template}{$template_part}.php",
				)
			),
			$template,
			$template_part,
			$template_layout,
			$var
		);

		foreach ( $template_hierarchy as $filename ) {
			$located = yith_wcwl_locate_template( $filename );

			if ( $located ) {
				return yith_wcwl_get_template( $filename, $var, $return );
			}
		}
	}
}

if ( ! function_exists( 'yith_wcwl_get_icon' ) ) {
	/**
	 * Get the SVG icon string
	 *
	 * @param string $icon The icon name.
	 * @return false|string
	 */
	function yith_wcwl_get_icon( $icon ) {
		if ( 0 === strpos( $icon, '<svg' ) ) {
			return $icon;
		}

		$path = YITH_WCWL_ASSETS_ICONS . $icon . ( substr( $icon, -4 ) === '.svg' ? '' : '.svg' );

		ob_start();
		if ( file_exists( $path ) ) {
			include $path;
		}

		return ob_get_clean();
	}
}
if ( ! function_exists( 'yith_wcwl_get_icon_url' ) ) {
	/**
	 * Get the icon url
	 *
	 * @param string $icon The icon name.
	 * @return string
	 */
	function yith_wcwl_get_icon_url( $icon ) {
		return YITH_WCWL_ASSETS_ICONS_URL . $icon . ( substr( $icon, -4 ) === '.svg' ? '' : '.svg' );
	}
}

/* === COUNT FUNCTIONS === */

if ( ! function_exists( 'yith_wcwl_count_products' ) ) {
	/**
	 * Retrieve the number of products in the wishlist.
	 *
	 * @param string|bool $wishlist_token Optional wishlist token.
	 *
	 * @return int
	 * @since 1.0.0
	 */
	function yith_wcwl_count_products( $wishlist_token = false ) {
		return yith_wcwl_wishlists()->count_items_in_wishlist( $wishlist_token );
	}
}

if ( ! function_exists( 'yith_wcwl_count_all_products' ) ) {
	/**
	 * Retrieve the number of products in all the wishlists.
	 *
	 * @return int
	 * @since 2.0.13
	 */
	function yith_wcwl_count_all_products() {
		return yith_wcwl_wishlists()->count_all_items();
	}
}

if ( ! function_exists( 'yith_wcwl_count_add_to_wishlist' ) ) {
	/**
	 * Count number of times a product was added to users wishlists
	 *
	 * @param int|bool $product_id Product id.
	 *
	 * @return int Number of times the product was added to wishlists
	 * @since 2.0.13
	 */
	function yith_wcwl_count_add_to_wishlist( $product_id = false ) {
		return yith_wcwl_wishlists()->count_add_to_wishlist( $product_id );
	}
}

if ( ! function_exists( 'yith_wcwl_get_count_text' ) ) {
	/**
	 * Returns the label that states how many users added a specific product to wishlist
	 *
	 * @param int|bool $product_id Product id or false, when you want to use global product as reference.
	 *
	 * @return string Label with count of items
	 */
	function yith_wcwl_get_count_text( $product_id = false ) {
		$count              = yith_wcwl_count_add_to_wishlist( $product_id );
		$current_user_count = $count ? YITH_WCWL_Wishlist_Factory::get_times_current_user_added_count( $product_id ) : 0;

		// if no user added to wishlist, return empty string.
		if ( ! $count ) {
			/**
			 * APPLY_FILTERS: yith_wcwl_count_text_empty
			 *
			 * Filter the text shown when a product has not been added to any wishlist.
			 *
			 * @param string $text       Text
			 * @param int    $product_id Product ID
			 *
			 * @return string
			 */
			return apply_filters( 'yith_wcwl_count_text_empty', '', $product_id );
		} elseif ( ! $current_user_count ) {
			// translators: 1. Number of users.
			$count_text = sprintf( _n( '%d user', '%d users', $count, 'yith-woocommerce-wishlist' ), $count );
			$text       = _n( 'has this item in wishlist', 'have this item in wishlist', $count, 'yith-woocommerce-wishlist' );
		} elseif ( $count === $current_user_count ) {
			$count_text = __( 'You\'re the first', 'yith-woocommerce-wishlist' );
			$text       = __( 'to add this item in wishlist', 'yith-woocommerce-wishlist' );
		} else {
			$other_count = $count - $current_user_count;
			// translators: 1. Count of users when many, or "another" when only one.
			$count_text = sprintf( _n( 'You and %s user', 'You and %d users', $other_count, 'yith-woocommerce-wishlist' ), 1 === $other_count ? __( 'another', 'yith-woocommerce-wishlist' ) : $other_count ); // phpcs:ignore WordPress.WP.I18n.MismatchedPlaceholders
			$text       = __( 'have this item in wishlist', 'yith-woocommerce-wishlist' );
		}

		$label = sprintf( '<div class="count-add-to-wishlist"><span class="count">%s</span> %s</div>', $count_text, $text );

		/**
		 * APPLY_FILTERS: yith_wcwl_count_text
		 *
		 * Filter the text that states how many users added a specific product to wishlist.
		 *
		 * @param string $label              Text
		 * @param int    $product_id         Product ID
		 * @param int    $current_user_count Current user count
		 * @param int    $count              Total count
		 *
		 * @return string
		 */
		return apply_filters( 'yith_wcwl_count_text', $label, $product_id, $current_user_count, $count );
	}
}

/* === COOKIE FUNCTIONS === */

if ( ! function_exists( 'yith_wcwl_get_cookie_expiration' ) ) {
	/**
	 * Returns default expiration for wishlist cookie
	 *
	 * @return int Number of seconds the cookie should last.
	 */
	function yith_wcwl_get_cookie_expiration() {
		/**
		 * APPLY_FILTERS: yith_wcwl_cookie_expiration
		 *
		 * Filter the cookie expiration.
		 *
		 * @param int $cookie_expiration Cookie expiration
		 *
		 * @return int
		 */
		return intval( apply_filters( 'yith_wcwl_cookie_expiration', 60 * 60 * 24 * 30 ) );
	}
}

if ( ! function_exists( 'yith_setcookie' ) ) {
	/**
	 * Create a cookie.
	 *
	 * @param string $name     Cookie name.
	 * @param mixed  $value    Cookie value.
	 * @param int    $time     Cookie expiration time.
	 * @param bool   $secure   Whether cookie should be available to secured connection only.
	 * @param bool   $httponly Whether cookie should be available to HTTP request only (no js handling).
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	function yith_setcookie( $name, $value = array(), $time = null, $secure = false, $httponly = false ) {
		/**
		 * APPLY_FILTERS: yith_wcwl_set_cookie
		 *
		 * Filter whether to set the cookie.
		 *
		 * @param bool $set_cookie Whether to set cookie or not
		 *
		 * @return bool
		 */
		if ( ! apply_filters( 'yith_wcwl_set_cookie', true ) || empty( $name ) ) {
			return false;
		}

		$time = ! empty( $time ) ? $time : time() + yith_wcwl_get_cookie_expiration();

		$value = wp_json_encode( stripslashes_deep( $value ) );

		/**
		 * APPLY_FILTERS: yith_wcwl_cookie_expiration_time
		 *
		 * Filter the cookie expiration time.
		 *
		 * @param int $time Cookie expiration time
		 *
		 * @return int
		 */
		$expiration = apply_filters( 'yith_wcwl_cookie_expiration_time', $time ); // Default 30 days.

		$_COOKIE[ $name ] = $value;
		wc_setcookie( $name, $value, $expiration, $secure, $httponly );

		return true;
	}
}

if ( ! function_exists( 'yith_getcookie' ) ) {
	/**
	 * Retrieve the value of a cookie.
	 *
	 * @param string $name Cookie name.
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	function yith_getcookie( $name ) {
		if ( isset( $_COOKIE[ $name ] ) ) {
			return json_decode( sanitize_text_field( wp_unslash( $_COOKIE[ $name ] ) ), true );
		}

		return array();
	}
}

if ( ! function_exists( 'yith_destroycookie' ) ) {
	/**
	 * Destroy a cookie.
	 *
	 * @param string $name Cookie name.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	function yith_destroycookie( $name ) {
		yith_setcookie( $name, array(), time() - 3600 );
	}
}

/* === GET FUNCTIONS === */

if ( ! function_exists( 'yith_wcwl_get_hidden_products' ) ) {
	/**
	 * Retrieves a list of hidden products, whatever WC version is running
	 *
	 * WC switched from meta _visibility to product_visibility taxonomy since version 3.0.0,
	 * forcing a split handling (Thank you, WC!)
	 *
	 * @return array List of hidden product ids
	 * @since 2.1.1
	 */
	function yith_wcwl_get_hidden_products() {
		$hidden_products = get_transient( 'yith_wcwl_hidden_products' );

		if ( false === $hidden_products ) {
			if ( version_compare( WC()->version, '3.0.0', '<' ) ) {
				// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				$hidden_products = get_posts(
					array(
						'post_type'      => 'product',
						'post_status'    => 'publish',
						'posts_per_page' => -1,
						'fields'         => 'ids',
						'meta_query'     => array(
							array(
								'key'   => '_visibility',
								'value' => 'visible',
							),
						),
					)
				);
				// phpcs:enable WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			} else {
				$hidden_products = wc_get_products(
					array(
						'limit'      => -1,
						'status'     => 'publish',
						'return'     => 'ids',
						'visibility' => 'hidden',
					)
				);
			}

			/**
			 * Array_filter was added to prevent errors when previous query returns for some reason just 0 index.
			 *
			 * @since 2.2.6
			 */
			$hidden_products = array_filter( $hidden_products );

			set_transient( 'yith_wcwl_hidden_products', $hidden_products, 30 * DAY_IN_SECONDS );
		}

		/**
		 * APPLY_FILTERS: yith_wcwl_hidden_products
		 *
		 * Filter the array of hidden products.
		 *
		 * @param array $hidden_products Hidden products
		 *
		 * @return array
		 */
		return apply_filters( 'yith_wcwl_hidden_products', $hidden_products );
	}
}

if ( ! function_exists( 'yith_wcwl_get_wishlist' ) ) {
	/**
	 * Retrieves wishlist by ID
	 *
	 * @param int|string|false $wishlist_id Wishlist ID or Wishlist Token, or false to retrieve the default one.
	 *
	 * @return \YITH_WCWL_Wishlist|bool Wishlist object; false on error
	 */
	function yith_wcwl_get_wishlist( $wishlist_id = false ) {
		return YITH_WCWL_Wishlist_Factory::get_wishlist( $wishlist_id );
	}
}

if ( ! function_exists( 'yith_wcwl_get_plugin_icons' ) ) {
	/**
	 * Return array of available icons
	 *
	 * @param string $none_label   Label to use for none option.
	 * @param string $custom_label Label to use for custom option.
	 *
	 * @return array Array of available icons, in class => name format
	 * @deprecated since 4.0 due to new icons-pack usage
	 */
	function yith_wcwl_get_plugin_icons( $none_label = '', $custom_label = '' ) {
		wc_deprecated_function( 'yith_wcwl_get_plugin_icons', '4.0.0' );
		$icons = json_decode( file_get_contents( YITH_WCWL_DIR . 'assets/js/admin/yith-wcwl-icons.json' ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

		$icons[ 'none' ]   = $none_label ?: __( 'None', 'yith-woocommerce-wishlist' );
		$icons[ 'custom' ] = $custom_label ?: __( 'Custom', 'yith-woocommerce-wishlist' );

		/**
		 * APPLY_FILTERS: yith_wcwl_plugin_icons
		 *
		 * Filter the icons used in the plugin.
		 *
		 * @param array  $icons        Icons
		 * @param string $none_label   Label to use for none option
		 * @param string $custom_label Label to use for custom option
		 *
		 * @return array
		 */
		return apply_filters( 'yith_wcwl_plugin_icons', $icons, $none_label, $custom_label );
	}
}

if ( ! function_exists( 'yith_wcwl_get_icons_list' ) ) {
	/**
	 * Return array of available icons
	 *
	 * @param string|string[] $context The context of the icons you want.
	 *
	 * @return array Array of available icons, in class => name format
	 */
	function yith_wcwl_get_plugin_icons_list( $context = '' ) {
		static $icons = null;

		if ( is_null( $icons ) ) {
			$icons = include YITH_WCWL_DIR . '/plugin-options/icons-list.php';

			foreach ( $icons as $icon => &$icon_details ) {
				if ( empty( $icon_details[ 'svg' ] ) ) {
					if ( ! empty( $icon_details[ 'path' ] ) && file_exists( $icon_details[ 'path' ] ) ) {
						ob_start();
						include $icon_details[ 'path' ];
						$icon_details[ 'svg' ] = ob_get_clean();
					} else {
						$icon_details[ 'svg' ] = yith_wcwl_get_icon( $icon );
					}
				}
			}
		}

		$list = $icons;
		if ( $context ) {
			$list = array_filter(
				$icons,
				function ( $icon ) use ( $context ) {
					return is_array( $context ) ? array_intersect( $context, $icon[ 'tags' ] ) : in_array( $context, $icon[ 'tags' ], true );
				}
			);
		}

		/**
		 * APPLY_FILTERS: yith_wcwl_plugin_icons_list
		 *
		 * Filter the icons used in the plugin.
		 *
		 * @param array $list Icons
		 *
		 * @return array
		 */
		return apply_filters( 'yith_wcwl_plugin_icons_list', $list );
	}
}

if ( ! function_exists( 'yith_wcwl_get_plugin_icons_options' ) ) {
	/**
	 * Return array of options 'value' => 'label' of icons
	 *
	 * @param string|string[] $context The icon context.
	 * @return array The array of icons options used in the plugin icons selectors
	 */
	function yith_wcwl_get_plugin_icons_options( $context = '' ) {
		$icons         = yith_wcwl_get_plugin_icons_list( $context );
		$icons_options = array_combine( array_keys( $icons ), array_column( $icons, 'label' ) );

		/**
		 * APPLY_FILTERS: yith_wcwl_plugin_icons_options
		 *
		 * Filter the icons options used in the icons selectors.
		 *
		 * @param array $icons_options The icons options.
		 *
		 * @return array
		 */
		return apply_filters( 'yith_wcwl_plugin_icons_options', $icons_options );
	}
}

if ( ! function_exists( 'yith_wcwl_get_privacy_label' ) ) {
	/**
	 * Returns privacy label
	 *
	 * @param int         $privacy  Privacy value.
	 * @param bool|string $extended Either to show extended, simplified label or get only the extension.
	 *
	 * @return string Privacy label
	 * @since 3.0.0
	 */
	function yith_wcwl_get_privacy_label( $privacy, $extended = false ) {

		$extension = '';

		switch ( $privacy ) {
			case 1:
				$privacy_label = 'shared';
				$privacy_text  = __( 'Shared', 'yith-woocommerce-wishlist' );
				$extension     = __( 'Only people with the link can view it', 'yith-woocommerce-wishlist' );
				break;
			case 2:
				$privacy_label = 'private';
				$privacy_text  = __( 'Private', 'yith-woocommerce-wishlist' );
				$extension     = __( 'Only you can view it', 'yith-woocommerce-wishlist' );
				break;
			default:
				$privacy_label = 'public';
				$privacy_text  = __( 'Public', 'yith-woocommerce-wishlist' );
				$extension     = __( 'Anybody can view it', 'yith-woocommerce-wishlist' );
				break;
		}

		if ( $extended ) {
			if ( 'only_extension' === $extended ) {
				$privacy_text = $extension;
			} else {
				$privacy_text = '<b>' . $privacy_text . '</b> - ' . $extension;
			}
		}

		/**
		 * APPLY_FILTERS: yith_wcwl_{$privacy_label}_wishlist_visibility
		 *
		 * Filter the privacy label for the wishlist privacy status.
		 *
		 * @param string $privacy_text Privacy text
		 * @param bool   $extended     Whether to show extended or simplified label
		 * @param int    $privacy      Privacy value
		 *
		 * @return string
		 */
		return apply_filters( "yith_wcwl_{$privacy_label}_wishlist_visibility", $privacy_text, $extended, $privacy );
	}
}

if ( ! function_exists( 'yith_wcwl_get_privacy_value' ) ) {
	/**
	 * Returns privacy numeric value
	 *
	 * @param string $privacy_label Privacy label.
	 *
	 * @return int Privacy value
	 * @since 3.0.0
	 */
	function yith_wcwl_get_privacy_value( $privacy_label ) {

		switch ( $privacy_label ) {
			case 'shared':
				$privacy_value = 1;
				break;
			case 'private':
				$privacy_value = 2;
				break;
			default:
				$privacy_value = 0;
				break;
		}

		/**
		 * APPLY_FILTERS: yith_wcwl_privacy_value
		 *
		 * Filter the privacy value.
		 *
		 * @param int    $privacy_value Privacy value
		 * @param string $privacy_label Privacy label
		 *
		 * @return string
		 */
		return apply_filters( 'yith_wcwl_privacy_value', $privacy_value, $privacy_label );
	}
}

if ( ! function_exists( 'yith_wcwl_get_current_url' ) ) {
	/**
	 * Retrieves current url
	 *
	 * @return string Current url
	 * @since 3.0.0
	 */
	function yith_wcwl_get_current_url() {
		global $wp;

		/**
		 * Returns empty string by default, to avoid problems with unexpected redirects
		 * Added filter to change default behaviour, passing what we think is current page url
		 *
		 * @since 3.0.12
		 */

		/**
		 * APPLY_FILTERS: yith_wcwl_current_url
		 *
		 * Filter the current URL.
		 *
		 * @param string $current_url Current URL
		 * @param string $url         URL
		 *
		 * @return string
		 */
		return apply_filters( 'yith_wcwl_current_url', '', add_query_arg( $wp->query_vars, home_url( $wp->request ) ) );
	}
}

/* === UTILITY FUNCTIONS === */

if ( ! function_exists( 'yith_wcwl_merge_in_array' ) ) {
	/**
	 * Merges an array of items into a specific position of an array
	 *
	 * @param array  $array    Origin array.
	 * @param array  $element  Elements to merge.
	 * @param string $pivot    Index to use as pivot.
	 * @param string $position Where elements should be merged (before or after the pivot).
	 *
	 * @return array Result of the merge
	 */
	function yith_wcwl_merge_in_array( $array, $element, $pivot, $position = 'after' ) { // phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames.arrayFound
		// search for the pivot inside array.
		$pos = array_search( $pivot, array_keys( $array ), true );

		if ( false === $pos ) {
			return $array;
		}

		// separate array into chunks.
		$i      = 'after' === $position ? 1 : 0;
		$part_1 = array_slice( $array, 0, $pos + $i );
		$part_2 = array_slice( $array, $pos + $i );

		return array_merge( $part_1, $element, $part_2 );
	}
}

if ( ! function_exists( 'yith_wcwl_maybe_format_field_array' ) ) {
	/**
	 * Take a field structure from plugin saved data, and format it as required by WC to print fields
	 *
	 * @param array $field_structure Array of fields as saved on db.
	 *
	 * @return array Array of fields as required by WC
	 */
	function yith_wcwl_maybe_format_field_array( $field_structure ) {
		$fields = array();

		if ( empty( $field_structure ) ) {
			return array();
		}

		foreach ( $field_structure as $field ) {
			if ( isset( $field[ 'active' ] ) && 'yes' !== $field[ 'active' ] ) {
				continue;
			}

			if ( empty( $field[ 'label' ] ) ) {
				continue;
			}

			// format type.
			$field_id = sanitize_title_with_dashes( $field[ 'label' ] );

			// format options, if needed.
			if ( ! empty( $field[ 'options' ] ) ) {
				$options     = array();
				$raw_options = explode( '|', $field[ 'options' ] );

				if ( ! empty( $raw_options ) ) {
					foreach ( $raw_options as $raw_option ) {
						if ( strpos( $raw_option, '::' ) === false ) {
							continue;
						}

						list( $id, $value ) = explode( '::', $raw_option );
						$options[ $id ] = $value;
					}
				}

				$field[ 'options' ] = $options;
			}

			// format class.
			$field[ 'class' ] = array( 'form-row-' . $field[ 'position' ] );

			// format requires.
			$field[ 'required' ] = isset( $field[ 'required' ] ) && 'yes' === $field[ 'required' ];

			// set custom attributes when field is required.
			if ( $field[ 'required' ] ) {
				$field[ 'custom_attributes' ] = array(
					'required' => 'required',
				);
			}

			// if type requires options, but no options was defined, skip field printing.
			if ( in_array( $field[ 'type' ], array( 'select', 'radio' ), true ) && empty( $field[ 'options' ] ) ) {
				continue;
			}

			$fields[ $field_id ] = $field;
		}

		return $fields;
	}
}

if ( ! function_exists( 'yith_wcwl_add_notice' ) ) {
	/**
	 * Calls wc_add_notice, when it exists
	 *
	 * @param string $message     Message to print.
	 * @param string $notice_type Notice type (succcess|error|notice).
	 * @param array  $data        Optional notice data.
	 *
	 * @since 3.0.10
	 */
	function yith_wcwl_add_notice( $message, $notice_type = 'success', $data = array() ) {
		function_exists( 'wc_add_notice' ) && wc_add_notice( $message, $notice_type, $data );
	}
}

if ( ! function_exists( 'yith_wcwl_object_id' ) ) {
	/**
	 * Retrieve translated object id, if a translation plugin is active
	 *
	 * @param int    $id              Original object id.
	 * @param string $type            Object type.
	 * @param bool   $return_original Whether to return original object if no translation is found.
	 * @param string $lang            Language to use for translation ().
	 *
	 * @return int Translation id
	 * @since 1.0.0
	 */
	function yith_wcwl_object_id( $id, $type = 'page', $return_original = true, $lang = null ) {

		// process special value for $lang.
		if ( 'default' === $lang ) {
			if ( defined( 'ICL_SITEPRESS_VERSION' ) ) { // wpml default language.
				global $sitepress;
				$lang = $sitepress->get_default_language();
			} elseif ( function_exists( 'pll_default_language' ) ) { // polylang default language.
				$lang = pll_default_language( 'locale' );
			} else { // cannot determine default language.
				$lang = null;
			}
		}

		// Should work with WPML and PolyLang.
		$id = apply_filters( 'wpml_object_id', $id, $type, $return_original, $lang );

		// Space for additional translations.
		/**
		 * APPLY_FILTERS: yith_wcwl_object_id
		 *
		 * Filter the Wishlist object ID.
		 *
		 * @param int    $id              Object ID
		 * @param string $type            Object type
		 * @param bool   $return_original Whether to return original object if no translation is found
		 * @param string $lang            Language to use for translation
		 *
		 * @return int
		 */
		$id = apply_filters( 'yith_wcwl_object_id', $id, $type, $return_original, $lang );

		return $id;
	}
}

if ( ! function_exists( 'yith_wcwl_kses_icon' ) ) {
	/**
	 * Escape output of wishlist icon
	 *
	 * @param string $data Data to escape.
	 * @return string Escaped data
	 */
	function yith_wcwl_kses_icon( $data ) {
		/**
		 * APPLY_FILTERS: yith_wcwl_allowed_icon_html
		 *
		 * Filter the allowed HTML for the icons.
		 *
		 * @param array $allowed_icon_html Allowed HTML
		 *
		 * @return array
		 */
		$allowed_icon_html = apply_filters(
			'yith_wcwl_allowed_icon_html',
			array(
				'i'        => array(
					'class' => true,
				),
				'img'      => array(
					'src'    => true,
					'alt'    => true,
					'width'  => true,
					'height' => true,
				),
				'svg'      => array(
					'id'           => true,
					'class'        => true,
					'width'        => true,
					'height'       => true,
					'viewbox'      => true,
					'fill'         => true,
					'xmlns'        => true,
					'aria-hidden'  => true,
					'stroke'       => true,
					'stroke-width' => true,
				),
				'path'     => array(
					'd'               => true,
					'fill'            => true,
					'stroke'          => true,
					'clip-rule'       => true,
					'fill-rule'       => true,
					'stroke-linecap'  => true,
					'stroke-linejoin' => true,
				),
				'g'        => array(
					'clip-path' => true,
				),
				'clipPath' => array(
					'id' => true,
				),
				'defs'     => array(),
				'rect'     => array(
					'id'     => true,
					'width'  => true,
					'height' => true,
					'fill'   => true,
				),
			)
		);

		return wp_kses( $data, $allowed_icon_html );
	}
}

if ( ! function_exists( 'yith_wcwl_get_feedback_duration' ) ) {
	/**
	 * Get the feedback duration
	 *
	 * @return int
	 */
	function yith_wcwl_get_feedback_duration() {
		/**
		 * APPLY_FILTERS: yith_wcwl_feedback_duration
		 *
		 * Filter the feedback duration time.
		 *
		 * @param int $duration The duration time.
		 *
		 * @return int
		 */
		return absint( apply_filters( 'yith_wcwl_feedback_duration', 3000 ) );
	}
}

if ( ! function_exists( 'yith_wcwl_get_modal_colors_defaults' ) ) {
	/**
	 * Get modal colors default values
	 *
	 * @return string[]
	 */
	function yith_wcwl_get_modal_colors_defaults() {
		return array(
			'overlay'                     => '#0000004d',
			'icon'                        => '#007565',
			'primary_button'              => '#007565',
			'primary_button_hover'        => '#007565',
			'primary_button_text'         => '#fff',
			'primary_button_text_hover'   => '#fff',
			'secondary_button'            => '#e8e8e8',
			'secondary_button_hover'      => '#d8d8d8',
			'secondary_button_text'       => '#777',
			'secondary_button_text_hover' => '#777',
		);
	}
}

/* === INSTANCE CLASS FUNCTIONS === */

if ( ! function_exists( 'yith_wcwl' ) ) {
	/**
	 * Unique access to instance of YITH_WCWL class
	 *
	 * @return \YITH_WCWL|\YITH_WCWL_Extended|\YITH_WCWL_Premium
	 * @since 2.0.0
	 */
	function yith_wcwl() {
		return YITH_WCWL::get_instance();
	}
}

if ( ! function_exists( 'yith_wcwl_install' ) ) {
	/**
	 * Unique access to instance of YITH_WCWL_Install class
	 *
	 * @return \YITH_WCWL_Install
	 * @since 2.0.0
	 */
	function yith_wcwl_install() {
		return YITH_WCWL_Install::get_instance();
	}
}

if ( ! function_exists( 'yith_wcwl_frontend' ) ) {
	/**
	 * Unique access to instance of YITH_WCWL_Frontend class
	 *
	 * @return \YITH_WCWL_Frontend|\YITH_WCWL_Frontend_Extended|\YITH_WCWL_Frontend_Premium
	 * @since 2.0.0
	 */
	function yith_wcwl_frontend() {
		return YITH_WCWL_Frontend::get_instance();
	}
}

if ( ! function_exists( 'yith_wcwl_admin' ) ) {
	/**
	 * Unique access to instance of YITH_WCWL_Admin class
	 *
	 * @return YITH_WCWL_Admin|YITH_WCWL_Admin_Extended|YITH_WCWL_Admin_Premium
	 * @since 2.0.0
	 */
	function yith_wcwl_admin() {
		return YITH_WCWL_Admin::get_instance();
	}
}

if ( ! function_exists( 'yith_wcwl_session' ) ) {
	/**
	 * Unique access to instance of YITH_WCWL_Session class
	 *
	 * @return YITH_WCWL_Session
	 */
	function yith_wcwl_session() {
		return YITH_WCWL_Session::get_instance();
	}
}

if ( ! function_exists( 'yith_wcwl_emails' ) ) {
	/**
	 * Unique access to instance of YITH_WCWL_Emails class
	 *
	 * @return YITH_WCWL_Emails|YITH_WCWL_Emails_Premium|YITH_WCWL_Emails_Extended
	 * @since 2.0.0
	 */
	function yith_wcwl_emails() {
		return YITH_WCWL_Emails::get_instance();
	}
}

if ( ! function_exists( 'yith_wcwl_cron' ) ) {
	/**
	 * Unique access to instance of YITH_WCWL_Cron class
	 *
	 * @return \YITH_WCWL_Cron|YITH_WCWL_Cron_Extended|YITH_WCWL_Cron_Premium
	 * @since 3.0.0
	 */
	function yith_wcwl_cron() {
		return YITH_WCWL_Cron::get_instance();
	}
}

if ( ! function_exists( 'yith_wcwl_wishlists' ) ) {
	/**
	 * Unique access to instance of YITH_WCWL_Wishlists class
	 *
	 * @return YITH_WCWL_Wishlists|YITH_WCWL_Wishlists_Premium
	 * @since 4.0.0
	 */
	function yith_wcwl_wishlists() {
		return YITH_WCWL_Wishlists::get_instance();
	}
}

/* === DEPRECATED FUNCTIONS === */
