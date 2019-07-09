<?php
/**
 * Install and Unistall
 *
 * @package install_uninstall
 */

/**
 * 1. Install and Uninstall
 * 2. Enqueue Script and Styles
 * 3. Redirect after Activation
 */

/**
 * 1. Install and Unistall Process Starts
 * Moved to Upgrade.php
 */

/**
 * Uninstall DB and Files
 */
function uninstall_bc_random_banner_table() {
	global $wpdb;
	$bc_random_banner_options = $wpdb->prefix . BC_RB_RANDOM_BANNER_OPTION_DB;
	$wpdb->query( "DROP TABLE IF EXISTS $bc_random_banner_options" );

	$bc_random_banner = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;
	$wpdb->query( "DROP TABLE IF EXISTS $bc_random_banner" );

	$bc_random_banner_category = $wpdb->prefix . BC_RB_RANDOM_BANNER_CATEGORY;
	$wpdb->query( "DROP TABLE IF EXISTS $bc_random_banner_category" );


	delete_option( 'bc_random_banner_db_version' );
	delete_option( 'bc_rb_payment_info' );

}

//register_uninstall_hook( BC_RB_PLUGIN, 'uninstall_bc_random_banner_table' );

add_action( 'admin_init', 'bc_rb_upgrade' );
/**
 * Update plugin if available
 */
function bc_rb_upgrade() {
	$new_version = BC_RB_PLUGIN_VERSION;
	$old_version = get_option( 'bc_random_banner_db_version', '0' );

	if ( $old_version == $new_version ) {
		return;
	}
	do_action( 'bc_rb_upgrade', $old_version );

	update_option( 'bc_random_banner_db_version', $new_version );
}


/**
 * Install and Unistall Process Ends
 */


/**
 * 2. Script and Styles Starts
 */

function bc_rb_global_script_style_collection() {
	bc_rb_global_script_style();
}

add_action( 'wp_enqueue_scripts', 'bc_rb_global_script_style_collection' );

add_action( 'admin_enqueue_scripts', 'bc_rb_enqueue' );

/**
 * Conditional Enqueue Random Banner CSS and JS Files
 */
function bc_rb_enqueue() {
	if ( isset( $_GET['page'] ) && ( $_GET['page'] == 'bc_random_banner' || $_GET['page'] == 'bc_random_banner_support' || $_GET['page'] == 'bc_random_banner_option' || $_GET['page'] == 'bc_random_banner_campaign' || $_GET['page'] == 'bc_random_banner_statistics' ) ) {
		bc_rb_enqueue_script();
		bc_rb_enqueue_style();
		bc_rb_notifications();
	}
	bc_rb_global_script_style();

}

function bc_rb_notifications() {
	if ( isset( $_REQUEST['bc_status'] ) ) {
		?>
		<div class="bc_fed container">
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Something went wrong, please contact - support@buffercode.com</strong>
			</div>
		</div>
		<?php
	}
}

/**
 * Global Script and Styles
 */
function bc_rb_global_script_style() {
	wp_enqueue_script( 'bc_rb_global_script',
		plugins_url( 'assets/script/bc_rb_global.js', __FILE__ ),
		array(), BC_RB_PLUGIN_VERSION, 'all' );

	wp_enqueue_style( 'bc_rb_global_style',
		plugins_url( 'assets/style/bc_rb_global.css', __FILE__ ),
		array(), BC_RB_PLUGIN_VERSION, 'all' );

	wp_enqueue_style( 'bc_rb_animate',
		plugins_url( 'assets/style/animate.css', __FILE__ ),
		array(), BC_RB_PLUGIN_VERSION, 'all' );

	if ( ! wp_style_is( 'owl.carousel', 'enqueued' ) ) {
		wp_enqueue_style( 'owl.carousel-style',
			plugins_url( 'assets/style/owl.carousel.css', __FILE__ ),
			array(), BC_RB_PLUGIN_VERSION, 'all' );
	}

	if ( ! wp_script_is( 'owl.carousel', 'unslider' ) ) {
		wp_enqueue_script( 'owl.carousel-script',
			plugins_url( 'assets/script/owl.carousel.js', __FILE__ ),
			array(), BC_RB_PLUGIN_VERSION, 'all' );
	}

	wp_enqueue_style( 'owl.carousel-default',
		plugins_url( 'assets/style/owl.theme.default.css', __FILE__ ),
		array(), BC_RB_PLUGIN_VERSION, 'all' );

	wp_enqueue_style( 'owl.carousel-transitions',
		plugins_url( 'assets/style/owl.transitions.css', __FILE__ ),
		array(), BC_RB_PLUGIN_VERSION, 'all' );
}

/**
 * Enqueue all CSS Files
 */
function bc_rb_enqueue_style() {

	wp_enqueue_style( 'bc_rb_style',
		plugins_url( 'assets/style/style.css', __FILE__ ),
		array(), BC_RB_PLUGIN_VERSION, 'all' );

	if ( ! wp_style_is( 'bootstrap', 'enqueued' ) ) {
		wp_enqueue_style( 'bootstrap',
			plugins_url( 'assets/style/bootstrap.css', __FILE__ ),
			array(), BC_RB_PLUGIN_VERSION, 'all' );
	}

	if ( ! wp_style_is( 'sweetalert', 'enqueued' ) ) {
		wp_enqueue_style( 'sweetalert',
			plugins_url( 'assets/style/sweetalert.css', __FILE__ ),
			array(), BC_RB_PLUGIN_VERSION, 'all' );
	}


	do_action( 'bc_rb_enqueue_style' );
}

/**
 * Enqueue all JS Files
 */
function bc_rb_enqueue_script() {
	wp_enqueue_script( 'bc_rb_script',
		plugins_url( 'assets/script/script.js', __FILE__ ),
		array(), BC_RB_PLUGIN_VERSION, 'all' );

	if ( ! wp_script_is( 'bootstrap', 'enqueued' ) ) {
		wp_enqueue_script( 'bootstrap',
			plugins_url( 'assets/script/bootstrap.js', __FILE__ ),
			array(), BC_RB_PLUGIN_VERSION, 'all' );
	}
	if ( ! wp_script_is( 'sweetalert', 'enqueued' ) ) {
		wp_enqueue_script( 'sweetalert',
			plugins_url( 'assets/script/sweetalert.js', __FILE__ ),
			array(), BC_RB_PLUGIN_VERSION, 'all' );
	}


	if ( ! wp_script_is( 'momentjs', 'enqueued' ) ) {
		wp_enqueue_script( 'moment',
			plugins_url( 'assets/script/moment.js', __FILE__ ),
			array(), BC_RB_PLUGIN_VERSION, 'all' );
	}

	$current_user = wp_get_current_user();
	// Pass PHP value to JavaScript
	$translation_array = array(
		'plugin_url'      => plugins_url( BC_RB_PLUGIN_NAME ),
		'payment_info'    => get_option( 'bc_rb_payment_info' ),
		'category'        => bc_rb_get_category_by_array_js(),
		'contact_email'   => $current_user->user_email,
		'display_name'    => strtoupper( $current_user->display_name ),
		'bc_redirect_url' => admin_url( 'admin.php?page=bc_random_banner_support' ),
	);
	wp_localize_script( 'bc_rb_script', 'vardata', $translation_array );
	wp_localize_script( 'sweetalert', 'sweet_data', array( 'ads_image' => plugins_url( BC_RB_PLUGIN_NAME . '/assets/images/banner-plugin.jpg' ) ) );

	wp_enqueue_media();
	do_action( 'bc_rb_enqueue_script' );
}

/**
 * Script and Styles Ends
 */

/**
 * 3. Redirect on Activation starts
 */
register_activation_hook( BC_RB_PLUGIN, 'bc_rb_add_activation_option' );
add_action( 'admin_init', 'bc_rb_activation_redirect' );

/**
 * Redirect After Activation Hook
 */
function bc_rb_add_activation_option() {
	add_option( 'bc_rb_activation_option_hook', true );
}

/**
 * Redirect After Activation
 */
function bc_rb_activation_redirect() {
	if ( get_option( 'bc_rb_activation_option_hook', false ) ) {
		delete_option( 'bc_rb_activation_option_hook' );
		wp_redirect( "admin.php?page=bc_random_banner" );
	}
}
