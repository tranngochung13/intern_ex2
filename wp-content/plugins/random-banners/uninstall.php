<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* Uninstall Plugin */

// if not uninstalled plugin
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit(); // out!


/*esle:
	if uninstalled plugin, this options will be deleted
*/
delete_option('alobaidi_rbp_banners');
delete_option('alobaidi_rbp_links');
delete_option('alobaidi_rbp_display_banners');
delete_option('alobaidi_rbp_banners_align');
delete_option('alobaidi_rbp_screen');
delete_option('alobaidi_rbp_exclude_search');
delete_option('alobaidi_rbp_exclude_category');
delete_option('alobaidi_rbp_exclude_tag');
delete_option('alobaidi_rbp_exclude_home');
delete_option('alobaidi_rbp_exclude_404');
delete_option('alobaidi_rbp_exclude_front_page');
delete_option('alobaidi_rbp_exclude_attachment');
delete_option('alobaidi_rbp_exclude_post_type_post');
delete_option('alobaidi_rbp_exclude_post_type_page');
delete_option('alobaidi_rbp_exclude_custom_post_type');
delete_option('alobaidi_rbp_custom_banners');
delete_option('alobaidi_rbp_custom_links');
delete_option('alobaidi_rbp_exclude_aside');
delete_option('alobaidi_rbp_exclude_image');
delete_option('alobaidi_rbp_exclude_video');
delete_option('alobaidi_rbp_exclude_quote');
delete_option('alobaidi_rbp_exclude_link');
delete_option('alobaidi_rbp_exclude_gallery');
delete_option('alobaidi_rbp_exclude_status');
delete_option('alobaidi_rbp_exclude_audio');
delete_option('alobaidi_rbp_exclude_chat');

?>