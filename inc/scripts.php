<?php

/**
 * Echos the Javascript or returns it (if $echo is set to TRUE)
 *
 * @since 1.0
 *
 * @return void|string
 */
function gaoop_js() {

	$ua_code = gaoop_get_ua_code();
	if ( empty( $ua_code ) ) {
		return;
	}
	?>
	<script type="text/javascript">
		/* Google Analytics Opt-Out WordPress by WP-Buddy | https://wp-buddy.com/products/plugins/google-analytics-opt-out */
		<?php do_action( 'gaoop_js_before_script' ); ?>
		var gaoop_property    = '<?php echo $ua_code; ?>';
		var gaoop_disable_str = 'ga-disable-' + gaoop_property;
		if ( document.cookie.indexOf( gaoop_disable_str + '=true' ) > -1 ) {
			window[ gaoop_disable_str ] = true;
		}

		function gaoop_analytics_optout() {
			document.cookie             = gaoop_disable_str + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
			window[ gaoop_disable_str ] = true;
			<?php echo apply_filters( 'gaoop_cookie_set', '' ); ?>
		}
		<?php
		do_action( 'gaoop_js_after_script' );
		?>
	</script>
	<?php
}

add_action( 'wp_head', 'gaoop_js', 0 );


/**
 * Enqueue Frontend Scripts
 *
 * @since 1.0
 */
function gaoop_enqueue_scripts() {

	wp_enqueue_script( 'goop', GAOOP_URL . 'js/frontend.js', array( 'jquery' ), false, true );

	add_filter( 'script_loader_tag', function ( $tag, $handle ) {

		if ( $handle === 'goop' && false === stripos( $tag, 'defer' ) ) {
			return str_replace( '<script', '<script defer ', $tag );
		}

		return $tag;
	}, 10, 2 );
}

add_action( 'init', 'gaoop_enqueue_scripts' );
