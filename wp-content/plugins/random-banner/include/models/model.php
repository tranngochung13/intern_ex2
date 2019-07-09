<?php
/**
 * Handling all DB queries
 *
 * @package model
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Create new banner
 *
 * @param array $post Banner details.
 *
 * @return string [success / failure]
 */
function bc_rb_create( $post ) {
	global $wpdb;

	$table = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;

	/**
	 * Collect Upload Banner Details.
	 */
	$banner = bc_rb_check_banner_model_and_type( $post );

	$verify = $wpdb->insert(
		$table,
		$banner['type'],
		$banner['option']
	);

	if ( $verify ) {
		return 'success';
	}

	return 'failed';

}

/**
 * Update banner
 *
 * @param array $post Banner options.
 *
 * @return string
 */
function bc_rb_update( $post ) {
	global $wpdb;
	$table  = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;
	$banner = bc_rb_check_banner_model_and_type( $post );
	$verify = $wpdb->update(
		$table,
		$banner['type'],
		array( 'id' => $post['banner_id'] ),
		$banner['option'],
		array( '%d' )
	);

	if ( $verify ) {
		return 'success';
	}

	return 'failed';

}

/**
 * Get all banners
 *
 * @return array|null|object|void
 */
function bc_rb_get_all_row() {
	global $wpdb;
	$table   = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;
	$all_row = $wpdb->get_results( "SELECT * FROM $table ORDER BY id DESC" );

	return $all_row;
}

/**
 * Get one row by random selection
 *
 * @param string $category Category Name.
 *
 * @return mixed
 */
function bc_rb_get_one_row_random( $category ) {
	global $wpdb;
	$table   = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;
	$all_row = $wpdb->get_results( "SELECT * FROM $table WHERE category LIKE '{$category}' ORDER BY RAND()" );

	return $all_row[0];
}

/**
 * Delete banner by ID
 *
 * @param int $id Banner ID.
 *
 * @return string
 */
function bc_rb_delete_by_id( $id ) {
	global $wpdb;
	$table  = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;
	$verify = $wpdb->delete( $table, array( 'id' => $id ), array( '%d' ) );
	if ( $verify ) {
		return 'success';
	}

	return 'failed';
}

/**
 * Remind me later for PayPal Popup
 */
function bc_rb_remind_later() {
	$one_week = date( "Ymd", strtotime( "+2 days" ) );
	update_option( 'bc_rb_payment_info', $one_week );
	echo 'yes';
}

/**
 * Check add new or update category
 *
 * @param array $post Banners.
 *
 * @return string
 */
function bc_rb_add_update_category( $post ) {
	global $wpdb;
	$bc_random_banner_category = $wpdb->prefix . BC_RB_RANDOM_BANNER_CATEGORY;

	$search_found = search_for_category_exist( $bc_random_banner_category, $post );

	if ( $search_found ) {
		return 'already_exist';
	} else {
		if ( isset( $post['category_id'] ) && isset( $post['category'] ) ) { // update.
			$old_category = bc_rb_get_category_by_id( $post['category_id'] );
			bc_rb_update_random_banner_category_by_update( $post['category'], $old_category );
			bc_rb_update_category( $bc_random_banner_category, $post );
		} elseif ( isset( $post['category'] ) ) {
			bc_rb_add_new_category( $bc_random_banner_category, $post );
		}

		return 'new_row_created';
	}
}

/**
 * Add New Category
 *
 * @param string $table Table Name.
 * @param array  $post Banner Options.
 */
function bc_rb_add_new_category( $table, $post ) {
	$check_duplicate = search_for_category_exist( $table, $post );
	if ( ! $check_duplicate ) {
		global $wpdb;
		$wpdb->insert(
			$table,
			bc_rb_category_model( $post ),
			bc_rb_category_option()
		);
	}

}

/**
 * Update Category
 *
 * @param string $table Table Name.
 * @param array  $post Category Options.
 */
function bc_rb_update_category( $table, $post ) {
	global $wpdb;
	$wpdb->update(
		$table,
		bc_rb_category_model( $post ),
		array( 'id' => $post['category_id'] ),
		bc_rb_category_option(),
		array( '%d' )
	);


}

/**
 * Check Category Exist
 *
 * @param string $table Category Table name.
 * @param array  $post Category Options.
 *
 * @return bool
 */
function search_for_category_exist( $table, $post ) {
	global $wpdb;
	$category = strtolower( $post['category'] );
	$success  = $wpdb->get_row( "SELECT * FROM $table WHERE category LIKE '{$category}'" );
	if ( ! is_null( $success ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Get all category
 *
 * @return array | null
 */
function bc_rb_get_all_category() {
	global $wpdb;
	$table   = $wpdb->prefix . BC_RB_RANDOM_BANNER_CATEGORY;
	$all_row = $wpdb->get_results( "SELECT * FROM $table ORDER BY id DESC" );

	return $all_row;
}

/**
 * Delete Category by ID
 *
 * @param array $post Category details.
 *
 * @return string
 */
function bc_rb_delete_category_by_id( $post ) {
	global $wpdb;
	$cat_table = $wpdb->prefix . BC_RB_RANDOM_BANNER_CATEGORY;

	$verify = $wpdb->delete( $cat_table, array( 'id' => (int) $post['category_id'] ), array( '%d' ) );
	bc_rb_update_random_banner_category_by_delete( $post['category'] );

	if ( $verify ) {
		return 'success';
	}

	return 'failed';
}


/**
 * Update Banner Category on Delete
 *
 * @param string $category Category Name.
 */
function bc_rb_update_random_banner_category_by_delete( $category ) {
	global $wpdb;
	$table = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;

	$wpdb->update(
		$table,
		array(
			'category' => 'default'
		),
		array( 'category' => esc_attr( strtolower( $category ) ) ),
		array( '%s' ),
		array( '%s' )
	);

}
/**
 * Update Banner by Category
 *
 * @param string $new_category New Category Name.
 * @param string $old_category Old Category Name.
 */
function bc_rb_update_random_banner_category_by_update( $new_category, $old_category ) {
	global $wpdb;
	$table = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;

	$wpdb->update(
		$table,
		array(
			'category' => esc_attr( strtolower( $new_category ) )
		),
		array( 'category' => esc_attr( strtolower( $old_category ) ) ),
		array( '%s' ),
		array( '%s' )
	);
}

/**
 * Get Category by ID
 *
 * @param int $id Category ID.
 *
 * @return array Category
 */
function bc_rb_get_category_by_id( $id ) {
	global $wpdb;
	$cat_table    = $wpdb->prefix . BC_RB_RANDOM_BANNER_CATEGORY;
	$old_category = $wpdb->get_var( "SELECT category FROM $cat_table WHERE id = {$id}" );

	return $old_category;
}

/**
 * Get all Category
 *
 * @param string $category Category name.
 *
 * @return All Banner by Category Name
 */
function bc_rb_get_all_banners( $category ) {
	global $wpdb;
	$table   = $wpdb->prefix . BC_RB_RANDOM_BANNER_DB;
	$all_row = $wpdb->get_results( "SELECT * FROM $table WHERE category LIKE '{$category}' ORDER BY RAND()" );

	return $all_row;
}

/**
 * Get table status
 */
function bc_get_table_status($table_name) {
	global $wpdb;
	$table  = $wpdb->prefix . $table_name;


	return  $wpdb->query(
		"SHOW TABLES LIKE '{$table}'"
	);
}