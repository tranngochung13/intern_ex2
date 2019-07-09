<?php


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class AlobaidiRandomBannersWidget extends WP_Widget {
	function AlobaidiRandomBannersWidget() {
		parent::__construct( false, 'Random Banners', array('description' => 'Display random banners easily, unlimited banners.') );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'];
		$banners = $instance['banners'];
		$links = $instance['links'];
		?>
            
			<?php echo $args['before_widget']; ?>

			<?php if ( !empty($title) ){
				echo $args['before_title'] . $title . $args['after_title'];
			}
            ?>

			<?php
				$filter_before = apply_filters('alobaidi_random_banners_widget_wrap_filter_before', null);
				$filter_after = apply_filters('alobaidi_random_banners_widget_wrap_filter_after', null);
				echo $filter_before.alobaidi_random_banners( $banners, $links, null ).$filter_after;
			?>
            
            <?php echo  $args['after_widget']; ?>

        <?php
	}//widget
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['banners'] = strip_tags($new_instance['banners']);
		$instance['links'] = strip_tags($new_instance['links']);
		return $instance;
	}//update
	
	function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance
		);
		
		$defaults = array(
			'title' 	=> '',
			'banners' 	=> '',
			'links' 	=> ''
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$banners = $instance['banners'];
		$links = $instance['links'];
		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
            
			<p>
				<label for="<?php echo $this->get_field_id('banners'); ?>">Banners:</label> 
				<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('banners'); ?>" name="<?php echo $this->get_field_name('banners'); ?>"><?php echo $banners; ?></textarea>
				<label for="<?php echo $this->get_field_id('banners'); ?>">Enter list of banners links, one URL per line.</label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('links'); ?>">Links:</label> 
				<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('links'); ?>" name="<?php echo $this->get_field_name('links'); ?>"><?php echo $links; ?></textarea>
				<label for="<?php echo $this->get_field_id('links'); ?>">Enter list of links <a href="<?php echo plugins_url( '/images/same-order-widget.png', __FILE__ ); ?>" target="_blank">in the same order</a>, one URL per line.</label>
			</p>
        <?php
		
	}//form
	
}
add_action('widgets_init', create_function('', 'return register_widget("AlobaidiRandomBannersWidget");') );

?>