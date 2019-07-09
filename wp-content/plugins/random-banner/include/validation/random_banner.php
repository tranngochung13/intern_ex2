<?php
/**
 * Validation
 *
 * @package validation
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Check for Nonce
 *
 * @param string $nonce Nonce.
 * @param string $nonce_name Nonce Name.
 */
function bc_rb_check_nonce( $nonce, $nonce_name ) {
	if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
		$error = array( 'error' => 'No naughty business please', 'type' => 'error' );
		echo json_encode( $error );
		exit();
	}
}