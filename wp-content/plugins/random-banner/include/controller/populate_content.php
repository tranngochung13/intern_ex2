<?php
/**
 * Populate Content for Front End
 *
 * @package random banner
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Fetch value from Database and output the data to view
 *
 * @param String $db_status Status Check.
 * @param String $message Message.
 */
function populate_data( $db_status, $message ) {
	if ( $db_status == 'success' ) {
		$rows = bc_rb_get_all_row();
		if ( $rows ) {
			$content = loop_data( $rows );
			echo wp_json_encode( array( 'content' => $content, 'message' => $message, 'type' => 'success' ) );
			die();
		}
	} else {
		echo wp_json_encode( array(
			'error' => esc_html__( 'Something went wrong, Please try again', 'bc_rb' ),
			'type'  => 'error',
		) );
		die();
	}
}

/**
 * Loop the data based on Banner type (Script or Upload)
 *
 * @param array $rows Content.
 *
 * @return string
 */
function loop_data( $rows ) {
	$content = '';

	foreach ( $rows as $row ) {
		if ( $row->banner_type == 'upload' ) {
			$content .= '<div class="row single_upload ' . sanitize_title( $row->category ) . '">
<form>
<input type="hidden" name="banner_type" value="' . esc_attr( $row->banner_type ) . '" />
<input type="hidden" name="banner_id" class="form-control banner_id" value="' . $row->id . '"/>
  <div class="col-md-3">
    <div class="col-md-12 padding_bottom_20 bc_flex_center">
      <div class="no_image" readonly>
        <img width=120 height=120 src=" ' . $row->file_url . ' ">
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-6">
      <button class="btn btn-primary form-control bc_rb_button_edit"> <span class="glyphicon glyphicon-edit"></span>
       ' . esc_html__( 'Edit', 'bc_rb' ) . '</button>
      </div>
      <div class="col-md-6">
      <button class="btn btn-danger form-control bc_rb_button_delete_by_id"> <span 
      class="glyphicon glyphicon-trash"></span> ' . esc_html__( 'Delete', 'bc_rb' ) . '</button>
     
      </div>
	</div>
    </div>
    <div class="col-md-9 bc_small_font">
    <div class="col-md-6">
    <label>' . __( 'Upload URL', 'bc_rb' ) . '</label>
      <input readonly type="text" name="file_url_link" class="form-control file_url_link" placeholder="Upload Image" value="' . $row->file_url . '"/>
     </div>
     <div class="col-md-6">
     <label>' . __( 'Description', 'bc_rb' ) . '</label>
      <input readonly type="text" name="file_description" class="form-control file_description" placeholder="File Description" value="' . $row->file_description . '"/>
      </div>
      <div class="col-md-12 padding_top_10">
      <label>' . __( 'External URL', 'bc_rb' ) . '</label>
      <input readonly type="text" name="external_link" class="bc_rb_external_link form-control" placeholder="External Link" value="' . $row->external_link . '" />
      </div>
      <div class="col-md-3 padding_top_10">
      <label>' . __( 'Width', 'bc_rb' ) . '</label>
      <div class="input-group">
      <input readonly name="width" type="number" class="form-control width" placeholder="Width in px" value="' . $row->width . '" />
      <span class="input-group-addon" >px</span>
      </div>
      </div>
      <div class="col-md-3 padding_top_10">
      <label>' . __( 'Height', 'bc_rb' ) . '</label>
      <div class="input-group">
      <input readonly name="height" type="number" class="form-control height" placeholder="Height in px" value="' . $row->height . '" />
      <span class="input-group-addon" >px</span>
      </div>
      </div>
      <div class="col-md-3 padding_top_10">
      <label>  ' . __( 'Theme Based Size', 'bc_rb' ) . ' </label>
      <div class="text-center">
      <input disabled="disabled" ' . $row->automatic . ' class="automatic form-control" type="checkbox" name="automatic" value="checked" />
       </div>
      </div>
      <div class="col-md-3 padding_top_10">
      <label>' . __( 'Category', 'bc_rb' ) . '</label>
      <div class="input-group">
      <div class="dropdown">
      ' . bc_rb_drop_down( 'category', bc_rb_get_category_by_array(), $row->category, 'disabled', 'category' ) . '
      </div>
      </div>
      </div>
      </div>
      </form>
      </div>';
		}
		if ( $row->banner_type == 'script' ) {
			$content .= '<div class="row single_upload ' . sanitize_title( $row->category ) . '">
<form>
<input type="hidden" name="banner_type" value="' . esc_attr( $row->banner_type ) . '" />
<input type="hidden" name="banner_id" class="form-control banner_id" value="' . $row->id . '"/>
<div class="col-md-6"> <input readonly type="text" value="' . $row->file_description . '" name="file_description" class="form-control file_description"
 placeholder="Title"/> </div>
<div class="col-md-2" >
      <div class="input-group">
      <div class="dropdown">
      ' . bc_rb_drop_down( 'category', bc_rb_get_category_by_array(), $row->category, 'disabled', 'category' ) . '
      </div>
      </div>
      </div>
<div class="col-md-9 padding_top_10">
<textarea readonly name="file_url_link" class="file_url_link_textarea form-control" rows="5" placeholder="Please paste the code here">' . esc_js( $row->file_url ) . '</textarea>
</div>

<div class="col-md-3 padding_top_10">
      <div class="col-md-12">
      <button class="btn btn-primary bc_rb_button_edit"> ' . esc_html__( 'Edit', 'bc_rb' ) . '</button>
      </div>
      <div class="col-md-12 padding_top_20">
      <button class="btn btn-danger bc_rb_button_delete_by_id"> ' . esc_html__( 'Delete', 'bc_rb' ) . '</button>
      </div>
      </div>
</form>
</div>';
		}
	}

	return $content;
}

/**
 * Check and return Banner Model and type based on give banner type
 *
 * @param array $post Check Post Type, Banner | SWF.
 *
 * @return mixed
 */
function bc_rb_check_banner_model_and_type( $post ) {
	$banner           = array();
	$banner['type']   = ( $post['banner_type'] == 'upload' ) ? bc_rb_upload_banner_model( $post ) : bc_rb_script_banner_model( $post );
	$banner['option'] = ( $post['banner_type'] == 'upload' ) ? bc_rb_upload_banner_option_model() : bc_rb_script_banner_option_model();

	return $banner;
}

/**
 * Get Option Value
 *
 * @return mixed
 */
function get_random_banner_option_value() {
	$options = unserialize( get_option( 'bc_rb_setting_options' ) );
	if ( ! $options ) {
		$options = bc_rb_option_default_value();
	}

	return $options;
}

/**
 * Get Popup Value
 *
 * @return mixed
 */
function get_popup_option_value() {
	$popup = unserialize( get_option( 'bc_rb_setting_popup' ) );
	if ( ! $popup ) {
		$popup = bc_rb_popup_default_value();
	}

	return $popup;
}

/**
 * Open the url in new window
 *
 * @return string
 */
function bc_rb_open_case() {
	$option_value = get_random_banner_option_value();
	if ( $option_value['open'] == 'checked' ) {
		return 'target="_blank"';
	}

	return '';
}

/**
 * Populate Category
 */
function bc_rb_populate_category() {
	$rows = bc_rb_get_all_category();
	if ( $rows ) {
		$content = bc_rb_loop_category( $rows );
		echo wp_json_encode( array(
			'content' => $content,
			'message' => esc_html__( 'Successfully Saved', 'bc_rb' ),
			'type'    => 'success',
		) );
		exit();
	}
}

/**
 * Category Loop
 *
 * @param array $rows Category Data.
 *
 * @return string
 */
function bc_rb_loop_category( $rows ) {
	$content = '';
	foreach ( $rows as $row ) {
		$content .= '<div class="row single_category padding_top_10">
      <form>
      <div class="col-md-6">
      <input type="hidden" name="category_id" value="' . $row->id . '">
      <input type="text" name="category" class="category_input form-control" value="' . $row->category . '" readonly />
      </div>
      <div class="col-md-6 category_button">';
		if ( $row->category != 'default' ) {
			$content .= '<button class="btn btn-primary bc_rb_button_edit"> ' . esc_html__( 'Edit', 'bc_rb' ) . '</button>
      <button class="btn btn-danger bc_rb_button_delete_by_id"> ' . esc_html__( 'Delete', 'bc_rb' ) . '</button>';
		}
		$content .= '</div>
      </form>
      </div>';
	}

	return $content;
}

/**
 * Get Category by array
 *
 * @return array
 */
function bc_rb_get_category_by_array() {
	$collections = bc_rb_get_all_category();
	$category    = array();
	foreach ( $collections as $collection ) {
		$category[ $collection->category ] = $collection->category;
	}

	return $category;
}

/**
 * Get Category by array JS
 *
 * @param string $selected Selected.
 *
 * @return string
 */
function bc_rb_get_category_by_array_js( $selected = '' ) {
	return bc_rb_loop_drop_down( $selected, array_reverse( bc_rb_get_category_by_array() ) );
	exit();
}

/**
 * Check Enable Slider or not
 *
 * @param String $selected Selected.
 *
 * @return string
 */
function bc_rb_get_enable_slider( $selected = '' ) {
	return bc_rb_loop_drop_down( $selected, bc_rb_get_yes_or_no_values() );
	exit();
}

/**
 * Get Slider Autoplay
 *
 * @param String $selected Selected.
 *
 * @return string
 */
function bc_rb_get_slider_autoplay( $selected = '' ) {
	return bc_rb_loop_drop_down( $selected, bc_rb_get_true_or_false_values() );
}

/**
 * Slider Loop
 *
 * @param String $selected Selected.
 *
 * @return string
 */
function bc_rb_get_slider_loop( $selected = '' ) {
	return bc_rb_loop_drop_down( $selected, bc_rb_get_true_or_false_values() );
}

/**
 * Get Slider Delay
 *
 * @param String $selected Selected.
 *
 * @return string
 */
function bc_rb_get_slider_delay( $selected = '' ) {
	return bc_rb_loop_drop_down( $selected, bc_rb_get_slider_delay_values() );
}

/**
 * Loop the drop-down
 *
 * @param String $selected Selected.
 * @param array $values array of Values.
 *
 * @return string
 */
function bc_rb_loop_drop_down( $selected, $values ) {
	$value = '';
	foreach ( $values as $single ) {
		$is_selected = '';
		if ( $selected == $single ) {
			$is_selected = 'selected';
		}
		$value .= '<option value="' . $single . '" ' . $is_selected . '>' . ucfirst( $single ) . '</option>';
	}

	return $value;
}

/**
 * Get Unique banner from Session
 *
 * @param String $category Category Name.
 *
 * @return string
 */
function bc_rb_get_unique_banner_from_session( $category ) {

	if ( ! isset( $_SESSION['bc_rb_category_session'] ) || ! is_array( $_SESSION['bc_rb_category_session'] ) ) {
		$_SESSION['bc_rb_category_session'] = array();
	}


	$get_all_banner = bc_rb_get_all_banners( $category );
//	var_dump($_SESSION['bc_rb_category_session']);
//	var_dump(count($_SESSION['bc_rb_category_session']));
//	var_dump(count($get_all_banner));
	if ( $get_all_banner ) {
		if ( count( $_SESSION['bc_rb_category_session'] ) >= count( $get_all_banner ) ) {
			$_SESSION['bc_rb_category_session'] = array();
		}
		$rb_bc_pending = bc_rb_check_value_in_session( $get_all_banner );

		return $rb_bc_pending;
	}

	return '';

}

/**
 * Check Value in Session
 *
 * @param array $get_all_banner Banners.
 *
 * @return array
 */
function bc_rb_check_value_in_session( $get_all_banner ) {

	if ( empty( $_SESSION['bc_rb_category_session'] ) ) {
		array_push( $_SESSION['bc_rb_category_session'], $get_all_banner[0]->id );

		return $get_all_banner[0];
	}
	foreach ( $get_all_banner as $index => $get_only ) {
		if ( ! in_array( $get_only->id, $_SESSION['bc_rb_category_session'] ) ) {
			array_push( $_SESSION['bc_rb_category_session'], $get_only->id );

			return $get_only;
		}
	}
}

/**
 * Loop Campaign Data
 *
 * @param array $data Campaign Data.
 *
 * @return string
 */
function bc_rb_loop_campaign_data( $data ) {

	$content = '';

	foreach ( $data as $banner ) {
		$ads_type_click = $ads_type_impression = '';
		$content        .= '<div class="row campaign_data bc_random_banner" data-display_name="' . bc_rb_get_user_display_name() . '">
<form>
<input type="hidden" name="banner_id" value="' . $banner->id . '" />
<div class="col-md-2">
  <div class="banner_image">';

		if ( $banner->banner_type == 'upload' ) {
			$content .= '<img width=100 height=80 src=" ' . $banner->file_url . ' ">';
		}
		if ( $banner->banner_type == 'script' ) {
			$content .= '<img width=100 height=80 src=" ' . plugins_url( '/assets/images/script.png', BC_RB_PLUGIN ) . ' ">';
		}
		$content .= '</div>
</div>

<div class="col-md-8">
  <div class="row">
    <div class="col-md-6">
      <input required readonly type="text" name="slot_name" class="form-control slot_name" placeholder="Slot Name [eg., Top sidebar, left 2nd sidebar]" value="' . $banner->slot_name . '"/>
    </div>
    <div class="col-md-6">';
		if ( $banner->banner_type == 'upload' ) {
			$content .= bc_rb_drop_down( 'ads_type', bc_rb_get_ads_type(), $banner->ads_type, 'disabled', 'ads_type' );
		}
		if ( $banner->banner_type == 'script' ) {
			$content .= bc_rb_drop_down( 'ads_type', array( 'Cost Per Impression' => 'Cost Per Impression' ), 'Cost Per Impression', 'disabled', 'ads_type' );
		}

		$content .= '</div>
  </div>';

		if ( $banner->ads_type == 'Cost Per Impression' || $banner->banner_type == 'script' ) {
//    if ($banner->ads_type == 'Cost Per Impression') {
			$ads_type_click = 'hide';
		} else {
			$ads_type_impression = 'hide';
		}
		$content .= '<div class="row padding_top_10 ads_click ' . $ads_type_click . '">
    <div class="col-md-6">
      <input required readonly type="text" name="max_click" class="form-control max_click" placeholder="Maximum Click" value="' . bc_rb_rename_to_unlimited( $banner->max_click, 'max_click' ) . '"/>
      <small>Maximum Click</small>
    </div>
    <div class="col-md-6">
    <div class="input-group">
      <input required readonly type="text" name="cost_per_click" class="form-control cost_per_click" placeholder="Cost per Click" value="' . bc_rb_rename_to_unlimited( $banner->cost_per_click, 'cost_per_click' ) . '"/>
      <span class="input-group-addon" >$</span>
      </div>
  <small>Cost per Single Click</small>
  </div>
  </div>';

		$content .= '<div class="row padding_top_10 ads_impression ' . $ads_type_impression . '">
    <div class="col-md-6">
      <input required readonly type="text" name="max_impression" class="form-control max_impression" placeholder="Maximum Impression" value="' . bc_rb_rename_to_unlimited( $banner->max_impression, 'max_impression' ) . '"/>
      <small>Maximum Impression</small>
    </div>
    <div class="col-md-6">
    <div class="input-group">
      <input required readonly type="text" name="cost_per_impression" class="form-control cost_per_impression" placeholder="Cost per Impression" value="' . bc_rb_rename_to_unlimited( $banner->cost_per_impression, 'cost_per_impression' ) . '"/>
      <span class="input-group-addon" >$</span>
      </div>
    <small>Cost per Single Impression</small>
    </div>
  </div>';

		$content .= '</div>
  <div class="col-md-2">
    <div class="col-md-12">
      <button type="submit" class="btn btn-primary bc_rb_campaign_edit"> ' . esc_html__( 'Edit', 'bc_rb' ) . '</button>
    </div>
  </div>

</form></div>';
	}

	return $content;
}

/**
 * Shortcode for Random Banner
 *
 * @param array $attr Shortcode Attributes.
 *
 * @return string
 */
function bc_random_banner_shortcode( $attr ) {
	$attr = shortcode_atts( array(
		'category' => 'default',
		'slider'   => 'No',
		'autoplay' => 'Autoplay',
		'delay'    => 3000,
		'loop'     => 'false',
		'dots'     => 'false',
	), $attr, 'bc_random_banner' );

	return bc_rb_generate_banners( $attr['category'],
		array(
			'slider'   => $attr['slider'],
			'autoplay' => $attr['autoplay'],
			'delay'    => $attr['delay'],
			'loop'     => $attr['loop'],
			'dots'     => $attr['dots'],
		) );
}

add_shortcode( 'bc_random_banner', 'bc_random_banner_shortcode' );


/**
 * Get all banner
 *
 * @param $category
 *
 * @return array
 */
function bc_rb_log_get_all_banner( $category ) {
	$all_banner_by_categories = bc_rb_get_all_banners( $category );

	return $all_banner_by_categories;
}

/**
 * Generate Banners for Sidebar and Shortcode
 *
 * @param $category
 * @param $slider array
 *
 * @return string
 */
function bc_rb_generate_banners( $category, array $slider ) {
	$banner_content = '';
	$random_number  = mt_rand( 11111, 999999 );
	$options        = get_random_banner_option_value();

	if ( ( isset( $options['disable'] ) && 'checked' == $options['disable'] ) || bc_rb_check_user_logged_in( $options )) {
		return $banner_content;
	}
	if ( strtolower( $slider['slider'] ) == 'yes' ) {
		$widgets = bc_rb_log_get_all_banner( $category );
		if ( ! $widgets ) {
			$banner_content .= ' <br>'.$options['empty_banner'].'<br>';
		}


		$banner_content .= '<div class="owl-carousel owl-theme bc_random_banner_slider-' . $random_number . '">';
		foreach ( $widgets as $widget ) {
			if ( $widget->banner_type == 'script' ) {
				$banner_content .= '<div class="bc_random_banner" data-id="' . (int) $widget->id . '" data-url="' . admin_url( 'admin-ajax.php?action=bc_rb_ads_click&nonce=' . wp_create_nonce( "bc_rb_ads_click" ) ) . '">' . bc_rb_convert_to_html( $widget->file_url ) . '</div>';
			}
			if ( $widget->banner_type == 'upload' ) {
				$custom_size = '';
				if ( $widget->automatic == '' ) {
					$custom_size = 'style=width:' . absint( $widget->width ) . 'px; height:' . absint( $widget->height ) . 'px';
				}
				$banner_content .= '<div class="bc_random_banner" data-id="' . (int) $widget->id . '" data-url="' . admin_url( 'admin-ajax.php?action=bc_rb_ads_click&nonce=' . wp_create_nonce( "bc_rb_ads_click" ) ) . '"><a ' . bc_rb_open_case() . ' href="' . $widget->external_link . '" title="' . esc_attr( $widget->file_description ) . '"><img ' . $custom_size . '  src="' . esc_url( $widget->file_url ) . '?v=' . $random_number . '" title="' . esc_attr( $widget->file_description ) . '"/></a></div>';
			}
		}
		$banner_content .= '</div>';
		$banner_content .= '<script> jQuery(function($) { $(".bc_random_banner_slider-' . $random_number . '").owlCarousel(
      {
      items: 1,
      dots: ' . $slider["dots"] . ',
      autoplay: "' . $slider["autoplay"] . '",
      autoplayTimeout:  ' . $slider["delay"] . ',
      loop:  ' . $slider["loop"] . ',
      center: true,
      autoHeight: true,
      autoHeightClass: "owl-height"
       }
      ) }); </script>';
	} else {
		$widget = bc_rb_get_unique_banner_from_session( $category );
		if ( ! $widget ) {
			$banner_content .= ' <br>'.$options['empty_banner'].'<br>';
		} else {
			if ( $widget->banner_type == 'script' ) {
				$banner_content .= '<div class="bc_random_banner script_bc_rb_widget" data-id="' . (int) $widget->id . '" data-url="' . admin_url( 'admin-ajax.php?action=bc_rb_ads_click&nonce=' . wp_create_nonce( "bc_rb_ads_click" ) ) . '">'
				                   . bc_rb_convert_to_html( $widget->file_url ) .
				                   '</div>';
			}
			if ( $widget->banner_type == 'upload' ) {
				$custom_size = '';
				if ( $widget->automatic == '' ) {
					$custom_size = 'style=width:' . absint( $widget->width ) . 'px; height:' . absint( $widget->height ) . 'px';
				}
				$banner_content .= '<div class="bc_random_banner" data-id="' . (int) $widget->id . '" data-url="' . admin_url( 'admin-ajax.php?action=bc_rb_ads_click&nonce=' . wp_create_nonce( "bc_rb_ads_click" ) ) . '"><a ' . bc_rb_open_case() . ' href="' . $widget->external_link . '" title="' . esc_attr( $widget->file_description ) . '"><img ' . $custom_size . ' src="' . esc_url( $widget->file_url ) . '?v=' . $random_number . '"  title="' . esc_attr( $widget->file_description ) . '"/></a></div>';
			}
		}

	}

	return $banner_content;
}

/**
 * Adding Short code to all post and pages
 */
add_filter( 'the_content', 'bc_rb_check_ads_required' );
/**
 * Check Ads Required
 *
 * @param String $content Content.
 *
 * @return string
 */
function bc_rb_check_ads_required( $content ) {
	global $post;
	$settings = get_option( 'bc_rb_insert_short_code_values', bc_rb_category_default_values() );
	if ( is_string( $settings ) ) {
		$settings = unserialize( $settings );
	}

	if ( ! isset( $settings['dots'] ) ) {
		$settings['dots'] = 'false';
	}

	$disable = get_post_meta( $post->ID, 'bc_rb_disable_banner', true );
	if ( ! is_array( $settings ) || count( $settings ) == 0 || $settings['enable_insert'] == 'false' || $disable == 'yes' ) {
		return $content;
	}

	if ( $settings['post_page'] == 'post' && is_single() ) {
		return bc_rb_insert_short_code_into_post_pages( $content, $settings );
	}

	return $content;
}

/**
 * Insert Shortcode into Post | Page
 *
 * @param String $content Content.
 * @param String $settings Location Top | Bottom | In between.
 *
 * @return string
 */
function bc_rb_insert_short_code_into_post_pages( $content, $settings ) {
	$short_code = generate_short_code_by_settings( $settings );

	return $content . $short_code;
}

/**
 * Generate Shortcode from Settings
 *
 * @param array $settings Settings options.
 *
 * @return string
 */
function generate_short_code_by_settings( $settings ) {
	$short_code = do_shortcode(
		'[bc_random_banner
        category=' . $settings["category_name"] . '
        slider="no"
      ]'
	);

	return $short_code;
}

/**
 * Add Post Meta
 */
add_action( 'save_post', 'bc_rb_save_post_meta' );
/**
 * Save Post Meta
 *
 * @param Int $post_id Post ID.
 *
 * @return mixed
 */
function bc_rb_save_post_meta( $post_id ) {
// Check if our nonce is set.
	if ( ! isset( $_POST['bc_rb_save_post_meta_nonce'] ) ) {
		return $post_id;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['bc_rb_save_post_meta_nonce'], 'bc_rb_save_post_meta_nonce' ) ) {
		return $post_id;
	}

	// Check the logged in user has permission to edit this post.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// OK to save meta data.
	if ( isset( $_POST['bc_rb_disable_banner'] ) ) {
		update_post_meta( $post_id, 'bc_rb_disable_banner', $_POST['bc_rb_disable_banner'] );
	} else {
		update_post_meta( $post_id, 'bc_rb_disable_banner', 'no' );
	}
}

add_action( 'plugins_loaded', 'bc_rb_translation' );
function bc_rb_translation() {
	load_plugin_textdomain( 'wp-admin-bc_rb', false, dirname( plugin_basename( __FILE__ ) ) . '/include/language/' );
}
