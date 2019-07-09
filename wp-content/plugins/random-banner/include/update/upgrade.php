<?php
/**
 * Upgrade
 *
 * @package upgrade.
 */

add_action( 'bc_rb_upgrade', 'bc_rb_db_update' );
/**
 * Update
 *
 * @param float $old_version Old Version.
 */
function bc_rb_db_update( $old_version ) {
	bc_rb_update_from_old();
	version_2_0_to_2_2();
	version_2_2_greater();
	version_3_3();
}

/**
 * Update from version 2.0 to 2.2
 */
function version_2_0_to_2_2() {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;
	$bc_random_banner = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;
	if ( ! $wpdb->get_col_length( $bc_random_banner, 'automatic' ) ) {
		$wpdb->query( "ALTER TABLE $bc_random_banner ADD automatic VARCHAR(255) NOT NULL DEFAULT 'checked' AFTER banner_type, ADD width MEDIUMINT(9) NOT NULL  AFTER automatic, ADD height MEDIUMINT(9) NOT NULL AFTER width" );
	}
}

/**
 * Update from version above 2.2 to 3.3.
 */
function version_2_2_greater() {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;
	$post                      = array( 'category' => 'default' );
	$bc_random_banner_category = $wpdb->prefix . BC_RB_RANDOM_BANNER_CATEGORY;
	$bc_random_banner          = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;

	// Add new Category Table.
	$wpdb->query( "CREATE TABLE IF NOT EXISTS $bc_random_banner_category (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		category varchar (255) NOT NULL,
		created VARCHAR (255)  DEFAULT '0000-00-00 00:00:00' NOT NULL,
		PRIMARY KEY id (id)
	)" );

	// Add Category column to random banner table if not exist.
	if ( ! $wpdb->get_col_length( $bc_random_banner, 'category' ) ) {
		$wpdb->query( "ALTER TABLE $bc_random_banner ADD category VARCHAR(255) NOT NULL DEFAULT 'default' AFTER height" );
	}

	bc_rb_add_new_category( $bc_random_banner_category, $post );
}

/**
 * Update from above 3.3.
 */
function version_3_3() {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	global $wpdb;
	$bc_random_banner = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;

	// Add Campaign Columns to random banner table if not exist.
	if ( ! $wpdb->get_col_length( $bc_random_banner, 'ads_type' ) ) {
		$wpdb->query( "ALTER TABLE $bc_random_banner ADD ads_type VARCHAR(255) NOT NULL AFTER category, ADD max_click INT(11) NOT NULL DEFAULT -1 AFTER ads_type, ADD max_impression INT(11) NOT NULL DEFAULT -1 AFTER max_click, ADD total_click INT(11) NOT NULL DEFAULT -1 AFTER max_impression, ADD total_impression INT(11) NOT NULL DEFAULT -1 AFTER total_click, ADD slot_name VARCHAR(255) NOT NULL AFTER total_impression, ADD cost_per_click decimal(10,5) NOT NULL DEFAULT -1 AFTER slot_name, ADD cost_per_impression decimal(10,5) NOT NULL DEFAULT -1 AFTER cost_per_click, ADD is_enable VARCHAR(255) NOT NULL DEFAULT 'yes' AFTER cost_per_impression" );
	}
}

/**
 * Add table if it is newer installation
 */
function bc_rb_update_from_old() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();

	$bc_random_banner         = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;
	$bc_random_banner_options = $wpdb->prefix . BC_RB_RANDOM_BANNER_OPTION_DB;

	_bc_random_banner_table_create( $bc_random_banner, $charset_collate );
	_bc_random_banner_option_table( $bc_random_banner_options, $bc_random_banner, $charset_collate );

	add_option( 'bc_rb_payment_info', 'no' );
}

/**
 * Create Banner Table
 *
 * @param string $bc_random_banner table name.
 * @param string $charset_collate char set.
 */
function _bc_random_banner_table_create( $bc_random_banner, $charset_collate ) {
	global $wpdb;
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$bc_random_banner'" ) != $bc_random_banner ) {
		$sql_create_table_bc_random_banner = "CREATE TABLE $bc_random_banner (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		file_url text NOT NULL,
		file_description varchar (255) NOT NULL,
		external_link text NOT NULL,
		banner_type varchar (255) NOT NULL,
		user_id mediumint(9) NOT NULL,
		created VARCHAR (255)  DEFAULT '0000-00-00 00:00:00' NOT NULL,
		PRIMARY KEY id (id)
	) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql_create_table_bc_random_banner );
	}
}

/**
 * Create Option Table
 *
 * @param string $bc_random_banner_options banner table name.
 * @param string $bc_random_banner option table name.
 * @param string $charset_collate char set.
 */
function _bc_random_banner_option_table( $bc_random_banner_options, $bc_random_banner, $charset_collate ) {
	global $wpdb;
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$bc_random_banner_options'" ) != $bc_random_banner_options ) {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$sql_create_table_bc_random_banner_options = "CREATE TABLE $bc_random_banner_options (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  country VARCHAR (255) NULL,
  ip_address VARCHAR (255) NULL,
  created_at VARCHAR (255) DEFAULT '0000-00-00 00:00:00' NOT NULL,
  random_banner_id mediumint(9) NOT NULL,
  PRIMARY KEY id (id),
  INDEX fk_statistics_random_banner_idx (random_banner_id ASC),
  CONSTRAINT fk_statistics_random_banner
    FOREIGN KEY (random_banner_id)
    REFERENCES {$bc_random_banner}(id)
    ON DELETE CASCADE
) $charset_collate; ";
		dbDelta( $sql_create_table_bc_random_banner_options );
	}


}
