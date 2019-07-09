<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


function alobaidi_random_banners_shortcode( $atts ){

	if( !empty($atts['screen']) ){

		if( $atts['screen'] == 'all' or $atts['screen'] == 'index' or $atts['screen'] == 'single' ){
			$screen = $atts['screen'];
		}
		else{
			$screen = 'single';
		}

	}
	else{

		$get_screen = get_option( 'alobaidi_rbp_screen' );

		if( $get_screen and $get_screen == 'single' or $get_screen == 'index' or $get_screen == 'all' ){
			$screen = get_option( 'alobaidi_rbp_screen' );
		}
		else{
			$screen = 'single';
		}

	}

	if( is_singular() and $screen == 'single' or $screen == 'all' or !is_singular() and $screen == 'index' ){

		if( get_option( 'alobaidi_rbp_exclude_search' ) and is_search() ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_category' ) and is_category() ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_tag' ) and is_tag() ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_home' ) and is_home() ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_404' ) and is_404() ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_front_page' ) and is_front_page() ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_attachment' ) and is_attachment() ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_post_type_post' ) and is_singular('post') ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_post_type_page' ) and is_singular('page') ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_custom_post_type' ) ){
			$str_replace 	 = str_replace( array(',', '.'), "", get_option( 'alobaidi_rbp_exclude_custom_post_type' ) );
			$post_type_names = preg_replace( '/\s+/', "\n", $str_replace );
			$post_type_array = (array) explode("\n", $post_type_names);
			if( is_singular($post_type_array) ){
				return false;
			}
		}

		if( get_option( 'alobaidi_rbp_exclude_aside' ) and has_post_format('aside') ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_image' ) and has_post_format('image') ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_video' ) and has_post_format('video') ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_quote' ) and has_post_format('quote') ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_link' ) and has_post_format('link') ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_gallery' ) and has_post_format('gallery') ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_status' ) and has_post_format('status') ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_audio' ) and has_post_format('audio') ){
			return false;
		}

		if( get_option( 'alobaidi_rbp_exclude_chat' ) and has_post_format('chat') ){
			return false;
		}
	
		$banners = get_option('alobaidi_rbp_banners');
		$links = get_option('alobaidi_rbp_links');
		$get_align = get_option('alobaidi_rbp_banners_align');

		if( !empty($atts['align']) ){

			if( $atts['align'] == 'none' or $atts['align'] == 'left' or $atts['align'] == 'right' or $atts['align'] == 'center' ){
				$align = 'align'.$atts['align'];
			}else{
				$align = 'alignnone';
			}

		}else{

			if( $get_align ){
				$align = 'align'.$get_align;
			}
			else{
				$align = 'alignnone';
			}

		}

		$filter_before = apply_filters('alobaidi_random_banners_shortcode_wrap_filter_before', '<p id="obi_random_banners_posts" class="obi_random_banners_posts">');
		$filter_after = apply_filters('alobaidi_random_banners_shortcode_wrap_filter_after', '</p>');

		return $filter_before.alobaidi_random_banners( $banners, $links, $align ).$filter_after;

	}

}
add_shortcode('obi_random_banners', 'alobaidi_random_banners_shortcode');

?>