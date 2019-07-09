<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


function alobaidi_random_banners( $banners, $links, $align ){

	if( empty($banners) or empty($links) ){
		return '<p>Please enter banners and links.</p>';
		return false;
	}

	if( empty($align) ){
		$class = null;
	}else{
		$class = ' class="'.$align.'"';
	}

	/* Set Banners */
	$get_banners 		= 	$banners;
	$preg_banners 		= 	preg_replace('/\s+/', "\n", $get_banners);
	$explode_banners	= 	explode("\n", $preg_banners);
	$banners_array 		= 	(array) $explode_banners;
	$banners_count 		=	count($banners_array);


	/* Set Links */
	$get_links 			= 	$links;
	$preg_links 		= 	preg_replace('/\s+/', "\n", $get_links);
	$explode_links		= 	explode("\n", $preg_links);
	$links_array 		= 	(array) $explode_links;
	$links_count 		=	count($links_array);


	/* Get Random Banner */
	if( $banners_count > 0 and $links_count > 0){

		if( $banners_count == $links_count ){
			$total  = $banners_count - 1;
			$random = rand(0, $total);
		}

		elseif( $banners_count < $links_count ){
			$total  = $banners_count - 1;
			$random = rand(0, $total);
		}

		elseif( $banners_count > $links_count ){
			$total  = $links_count - 1;
			$random = rand(0, $total);
		}

	}else{
		$random = 0;
	}

	return '<a rel="nofollow" target="_blank" href="'.$links_array[$random].'"><img src="'.$banners_array[$random].'"'.$class.'></a>';

}

?>