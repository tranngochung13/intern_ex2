<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage WS_Theme
 * @since Wooskins 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif; ?>
	<?php wp_head(); 	?>
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,600,700&display=swap" rel="stylesheet">
	
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<!-- Top menu -->
	<?php
		 if ( is_active_sidebar( 'custom-header-widget' ) ) : ?>

		 <div id="header-widget-area" class="top-head chw-widget-area widget-area" role="complementary">

			 <div class="container">

			 	<?php dynamic_sidebar( 'custom-header-widget' ); ?>

			 </div>

		 </div>

	<?php endif; ?>
	<!-- End Top menu -->
	<header id="masthead" class="site-header" role="banner">



			
		</header><!-- .site-header -->
	<div class="site-inner">
		

		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'ltheme' ); ?></a>
			

	

		
		
		<div class="breadcrumb">
			<div class="container">
				<?php  dimox_breadcrumbs() ?>
			</div>
		</div>
		

		<div id="content" class="site-content">
			
