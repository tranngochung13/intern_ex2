<?php

/**
 * Remove cache files.
 */
function bc_clear_all_cache() {
	global $wp_fastest_cache;

	/**
	 * WP Super Cache
	 */
	if ( function_exists( 'wp_cache_clear_cache' ) ) {
		wp_cache_clear_cache();
	}
	if ( function_exists( 'prune_super_cache' ) ) {
		prune_super_cache( get_supercache_dir(), true );
	}


	if ( function_exists( 'sg_cachepress_purge_cache' ) ) {
		sg_cachepress_purge_cache();
	}

	if ( function_exists( 'w3tc_pgcache_flush' ) ) {
		w3tc_pgcache_flush();
	}
	else if ( class_exists( 'WpeCommon' ) ) {
		if ( method_exists( 'WpeCommon', 'purge_memcached' ) ) {
			WpeCommon::purge_memcached();
		}
		if ( method_exists( 'WpeCommon', 'clear_maxcdn_cache' ) ) {
			WpeCommon::clear_maxcdn_cache();
		}
		if ( method_exists( 'WpeCommon', 'purge_varnish_cache' ) ) {
			WpeCommon::purge_varnish_cache();
		}
	} else if ( method_exists( 'WpFastestCache', 'deleteCache' ) && ! empty( $wp_fastest_cache ) ) {
		$wp_fastest_cache->deleteCache();
	}
}