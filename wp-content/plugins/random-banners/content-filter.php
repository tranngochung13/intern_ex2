<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


function alobaidi_random_banners_for_post_content( $content ){

	if( get_option('alobaidi_rbp_display_banners') == 'before' ){
		return do_shortcode('[obi_random_banners]').$content;
	}

	elseif( get_option('alobaidi_rbp_display_banners') == 'after' ){
		return $content.do_shortcode('[obi_random_banners]');
	}

	elseif( get_option('alobaidi_rbp_display_banners') == 'before_and_after' ){
		return do_shortcode('[obi_random_banners]').$content.do_shortcode('[obi_random_banners]');
	}

	else{
		return $content;
	}

}
add_filter('the_content', 'alobaidi_random_banners_for_post_content');

?>