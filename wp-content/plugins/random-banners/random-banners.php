<?php
/*
Plugin Name: Random Banners
Plugin URI: http://wp-plugins.in/random-banners
Description: Display random banners easily, random banners widget, banners before or after post content automatically, banners between post content, custom place, unlimited banners!.
Version: 1.0.0
Author: Alobaidi
Author URI: http://wp-plugins.in
License: GPLv2 or later
*/

/*  Copyright 2015 Alobaidi (email: wp-plugins@outlook.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


function alobaidi_random_banners_plugin_row_meta( $links, $file ) {

	if ( strpos( $file, 'random-banners.php' ) !== false ) {
		
		$new_links = array(
						'<a href="http://wp-plugins.in/random-banners" target="_blank">Explanation of Use</a>',
						'<a href="https://profiles.wordpress.org/alobaidi#content-plugins" target="_blank">More Plugins</a>',
						'<a href="http://j.mp/ET_WPTime_ref_pl" target="_blank">Elegant Themes</a>'
					);
		
		$links = array_merge( $links, $new_links );
		
	}
	
	return $links;
	
}
add_filter( 'plugin_row_meta', 'alobaidi_random_banners_plugin_row_meta', 10, 2 );


function alobaidi_random_banners_plugin_action_links( $actions, $plugin_file ){
	
	static $plugin;

	if ( !isset($plugin) ){
		$plugin = plugin_basename(__FILE__);
	}
		
	if ($plugin == $plugin_file) {
		
		if ( is_ssl() ) {
			$settings_link = '<a href="'.admin_url( 'plugins.php?page=alobaidi_random_banners_settings', 'https' ).'">Settings</a>';
		}else{
			$settings_link = '<a href="'.admin_url( 'plugins.php?page=alobaidi_random_banners_settings', 'http' ).'">Settings</a>';
		}
		
		$settings = array($settings_link);
		
		$actions = array_merge($settings, $actions);
			
	}
	
	return $actions;
	
}
add_filter( 'plugin_action_links', 'alobaidi_random_banners_plugin_action_links', 10, 5 );


if( !get_option( 'alobaidi_rbp_display_banners' ) ){
	update_option( 'alobaidi_rbp_display_banners', 'before' );
}

if( !get_option( 'alobaidi_rbp_banners_align' ) ){
	update_option( 'alobaidi_rbp_banners_align', 'none' );
}

if( !get_option( 'alobaidi_rbp_screen' ) ){
	update_option( 'alobaidi_rbp_screen', 'single' );
}


include( plugin_dir_path( __FILE__ ) . '/alobaidi-random-banners-function.php' );
include( plugin_dir_path( __FILE__ ) . '/settings.php' );
include( plugin_dir_path( __FILE__ ) . '/widget.php' );
include( plugin_dir_path( __FILE__ ) . '/shortcode.php' );
include( plugin_dir_path( __FILE__ ) . '/content-filter.php' );

?>