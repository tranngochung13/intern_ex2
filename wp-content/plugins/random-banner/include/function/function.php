<?php
/**
 * Default Functions
 *
 * @package function
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Get Current Date
 *
 * @param string $format Date.
 *
 * @return bool|string
 */
function bc_rb_get_current_date( $format = 'd-m-Y H:i:s' ) {
	return date( $format );
}

/**
 * Convert Script to HTML for Script Banner
 *
 * @param string $string Convert to HTML.
 *
 * @return mixed
 */
function bc_rb_convert_to_html( $string ) {
	return str_replace( '\"', '"', html_entity_decode( $string ) );
}

/**
 * Show Payment Details for Paid user else PayPal Donation button
 *
 * @return string
 */
function bc_rb_show_payment_details() {
	return '<div class="paypal_donation_button">
				<img width="150px" src="' . plugins_url( "/assets/images/paypal.png", BC_RB_PLUGIN ) . '" alt="Buffercode PayPal Donation Button"/>
				</div>';

}

/**
 * Check is User did PayPal Donation
 *
 * @return bool
 */
function bc_rb_is_paid() {
	$paid_status = get_option( 'bc_rb_payment_info' );
	if ( $paid_status == 'no' || strlen( $paid_status ) == 8 ) {
		return false;
	}

	return true;
}

/**
 * Get user display name
 *
 * @return string
 */
function bc_rb_get_user_display_name() {
	global $current_user;

	return $current_user->display_name;
}

/**
 * Loader to show on processing request
 *
 * @return string
 */
function bc_rb_loader() {
	return '<div id="preview-area">
        <div class="spinner_circle hide">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>';
}

/**
 * Echo Transaction Details on Success
 *
 * @param array $request Transaction Details.
 */
function bc_rb_on_success_payment( $request ) {
	if ( isset( $request['success'], $request['tid'] ) ) {
		update_option( 'bc_rb_payment_info', $request['tid'] );
		echo '<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> Thanks for your Payment. Your Transaction ID : ' . $request['tid'] . '
</div>';
	} else if ( isset( $request['success'] ) ) {
		echo '<div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Cancelled!</strong> Oh! You have cancelled the Transaction
    </div>';
	}
}

/**
 * Dropdown Options
 *
 * @param string $name Name.
 * @param array $options Drop-down values.
 * @param null | string $selected Selected options.
 * @param null | string $onchange Extra Options.
 * @param null | string $class Class.
 *
 * @return string
 */
function bc_rb_drop_down( $name, $options, $selected = null, $onchange = null, $class = null ) {
	$options  = (array) $options;
	$dropdown = '<select name="' . $name . '" class="form-control ' . $class . '"' . $onchange . '>' . "\n";

	foreach ( $options as $key => $option ) {
		$select   = $selected == $key ? ' selected="true" selected' : "";
		$dropdown .= sprintf(
			"<option value=\"%s\"%s>%s</option>\r\n", htmlspecialchars( $key ), $select, ucfirst( htmlspecialchars( $option ) )
		);
	}

	$dropdown .= '</select>' . "\n";

	return $dropdown;
}


/**
 * Dropdown Currency Options
 *
 * @param string $name Name.
 * @param array $options Drop-down values.
 * @param null | string $selected Selected options.
 * @param null | string $onchange Extra Options.
 * @param null | string $class Class.
 *
 * @return string
 */
function bc_rb_drop_down_currency( $name, $options, $selected = null, $onchange = null, $class = null ) {
	$options  = (array) $options;
	$dropdown = '<select name="' . $name . '" class="form-control ' . $class . '"' . $onchange . '>' . "\n";

	foreach ( $options as $key => $option ) {
		$select   = $selected == $key ? ' selected="true" selected' : "";
		$option_  = $option['name'] . ' (' . $option['symbol'] . ')';
		$dropdown .= sprintf(
			"<option value=\"%s\"%s>%s</option>\r\n", htmlspecialchars( $key ), $select, $option_
		);
	}

	$dropdown .= '</select>' . "\n";

	return $dropdown;
}


/**
 * Dropdown Options for filters
 *
 * @param string $name Name.
 * @param array $options Drop-down values.
 * @param null | string $selected Selected options.
 * @param null | string $onchange Extra Options.
 * @param null | string $class Class.
 *
 * @return string
 */
function bc_rb_drop_down_category_filter( $name, $options, $selected = null, $onchange = null, $class = null ) {
	$options  = (array) $options;
	$dropdown = '<select name="' . $name . '" class="form-control ' . $class . '"' . $onchange . '>' . "\n";
	$dropdown .= sprintf(
		"<option value=\"%s\"%s>%s</option>\r\n", 'bc__all', '', 'Show All'
	);

	foreach ( $options as $key => $option ) {
		$select   = $selected == $key ? ' selected="true" selected' : "";
		$dropdown .= sprintf(
			"<option value=\"%s\"%s>%s</option>\r\n", htmlspecialchars( sanitize_title( $key ) ), $select, ucfirst( htmlspecialchars( $option ) )
		);
	}

	$dropdown .= '</select>' . "\n";

	return $dropdown;
}

/**
 * Get Yes or No Option Values
 *
 * @return array
 */
function bc_rb_get_yes_or_no_values() {
	return array(
		'No'  => 'No',
		'Yes' => 'Yes',
	);
}

/**
 * Get True or False
 *
 * @return array
 */
function bc_rb_get_true_or_false_values() {
	return array(
		'true'  => 'true',
		'false' => 'false',
	);
}

/**
 * Get Slider Animation Values
 *
 * @return array
 */
function bc_rb_get_slider_animation_values() {
	return array(
		'horizontal' => 'horizontal',
		'vertical'   => 'vertical',
		'fade'       => 'fade',
	);
}

/**
 * Get Slider Delay Value
 *
 * @return array
 */
function bc_rb_get_slider_delay_values() {
	return array(
		'3000'  => '3000',
		'4000'  => '4000',
		'5000'  => '5000',
		'6000'  => '6000',
		'7000'  => '7000',
		'10000' => '10000',
		'15000' => '15000',
		'20000' => '20000',
	);
}

/**
 * Get Ads Type
 *
 * @return array
 */
function bc_rb_get_ads_type() {
	return array( 'Cost Per Click' => 'Cost Per Click', 'Cost Per Impression' => 'Cost Per Impression' );
}

/**
 * Rename to -1 to Unlimited
 *
 * @param integer $value -1.
 * @param string $options Campaign Options.
 *
 * @return float|string
 */
function bc_rb_rename_to_unlimited( $value, $options ) {
	$rename_option = bc_rb_get_options_value_campaign( $options );

	if ( $value == - 1 ) {
		return 'Unlimited ' . $rename_option;
	}

	return floatval( $value );
}

/**
 * Get Option Values
 *
 * @param string $options Campaign Options.
 *
 * @return string
 */
function bc_rb_get_options_value_campaign( $options ) {
	switch ( $options ) {
		case 'max_click':
			$rename_option = 'Click';
			break;
		case 'cost_per_click':
		case 'cost_per_impression':
			$rename_option = 'Amount';
			break;
		case 'max_impression':
			$rename_option = 'Impression';
			break;
		default:
			$rename_option = '';
	}

	return $rename_option;
}

/**
 * Generate Random Characters
 *
 * @param int $length length default to 6.
 *
 * @return string
 */
function bc_rb_random_characters( $length = 6 ) {
	return substr( str_shuffle( '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' ), 0, $length );
}

/**
 * Increment Value for Click or Impression
 *
 * @param int | string $value Values.
 * @param string $options Options.
 *
 * @return float|string
 */
function bc_rb_rename_to_unlimited_add_one( $value, $options ) {
	$check_unlimited = bc_rb_rename_to_unlimited( $value, $options );
	if ( is_string( $check_unlimited ) ) {
		return $check_unlimited;
	}

	return $check_unlimited + 1;
}

/**
 * Calculate Amount Used
 *
 * @param float $total Total Amount.
 * @param float $cost Cost.
 *
 * @return string
 */
function bc_rb_calculate_amount_used( $total, $cost ) {

	if ( $total == - 1 ) {
		return 'Not Applicable';
	}
	if ( $cost == - 1 ) {
		return - ( ( $total + 1 ) * $cost );
	}

	return ( $total + 1 ) * $cost;

}

/**
 * Category Default Values
 *
 * @return array
 */
function bc_rb_category_default_values() {
	return array(
		'category_name' => 'default',
		'slider'        => 'false',
		'autoplay'      => 'false',
		'delay'         => '3000',
		'loop'          => 'yes',
		'location'      => 'bottom',
		'enable_insert' => 'false',
		'post_page'     => 'post',
		'dots'          => 'false',
	);
}

/**
 * Insert Post Page Options
 *
 * @return array
 */
function bc_rb_insert_post_page() {
	return array(
		'post' => 'post ',
		'page' => 'page [Pro Version]',
		'any'  => 'any [Pro Version]',
	);
}

/**
 * Insert Post Location
 *
 * @return array
 */
function bc_rb_insert_post_locations() {
	return array(
		'bottom'                     => 'bottom',
		'top'                        => 'top [Pro Version]',
		'After paragraph'            => 'After paragraph [Pro Version]',
		'top bottom after paragraph' => 'Top, Bottom, After paragraph [Pro Version]',
	);
}

/**
 * Check User Logged In
 *
 * @param array $options User Details.
 *
 * @return bool
 */
function bc_rb_check_user_logged_in( $options ) {
	if ( isset( $options['user_logged_in'] ) && 'checked' === $options['user_logged_in'] && is_user_logged_in() ) {
		return true;
	}

	return false;
}

/**
 * Number from 1 to 10
 *
 * @return array
 */
function bc_rb_number_1_to_10() {
	return array(
		'1'  => '1',
		'2'  => '2',
		'3'  => '3',
		'4'  => '4',
		'5'  => '5',
		'6'  => '6',
		'7'  => '7',
		'8'  => '8',
		'9'  => '9',
		'10' => '10'
	);
}

function bc_rb_border_styles() {
	return array(
		'dotted' => 'dotted',
		'dashed' => 'dashed',
		'solid'  => 'solid',
		'double' => 'double',
		'groove' => 'groove',
		'ridge'  => 'ridge',
		'inset'  => 'inset',
		'outset' => 'outset',
		'none'   => 'none',
		'hidden' => 'hidden'
	);
}

/**
 * Popup Animated Style
 *
 * @return array
 */
function bc_rb_popup_animated_style() {
	return
		array(
			'bounce'            => 'bounce',
			'flash'             => 'flash',
			'pulse'             => 'pulse',
			'rubberBand'        => 'rubberBand',
			'shake'             => 'shake',
			'headShake'         => 'headShake',
			'swing'             => 'swing',
			'tada'              => 'tada',
			'wobble'            => 'wobble',
			'jello'             => 'jello',
			'bounceIn'          => 'bounceIn',
			'bounceInDown'      => 'bounceInDown',
			'bounceInLeft'      => 'bounceInLeft',
			'bounceInRight'     => 'bounceInRight',
			'bounceInUp'        => 'bounceInUp',
			'fadeIn'            => 'fadeIn',
			'fadeInDown'        => 'fadeInDown',
			'fadeInDownBig'     => 'fadeInDownBig',
			'fadeInLeft'        => 'fadeInLeft',
			'fadeInLeftBig'     => 'fadeInLeftBig',
			'fadeInRight'       => 'fadeInRight',
			'fadeInRightBig'    => 'fadeInRightBig',
			'fadeInUp'          => 'fadeInUp',
			'fadeInUpBig'       => 'fadeInUpBig',
			'flipInX'           => 'flipInX',
			'flipInY'           => 'flipInY',
			'lightSpeedIn'      => 'lightSpeedIn',
			'rotateIn'          => 'rotateIn',
			'rotateInDownLeft'  => 'rotateInDownLeft',
			'rotateInDownRight' => 'rotateInDownRight',
			'rotateInUpLeft'    => 'rotateInUpLeft',
			'rotateInUpRight'   => 'rotateInUpRight',
			'hinge'             => 'hinge',
			'rollIn'            => 'rollIn',
			'zoomIn'            => 'zoomIn',
			'zoomInDown'        => 'zoomInDown',
			'zoomInRight'       => 'zoomInRight',
			'zoomInUp'          => 'zoomInUp',
			'slideInDown'       => 'slideInDown',
			'slideInLeft'       => 'slideInLeft',
			'slideInRight'      => 'slideInRight',
			'slideInUp'         => 'slideInUp',
		);
}

/**
 * Popup Default Value
 *
 * @return array
 */
function bc_rb_popup_default_value() {
	return array(
		'enable_popup'         => '',
		'popup_category_name'  => '',
		'bg_color'             => '',
		'bg_border_color'      => '',
		'bg_transparent'       => '',
		'popup_session'        => '',
		'popup_show'           => '',
		'popup_border_size'    => '',
		'popup_border_style'   => '',
		'popup_animated_style' => '',
	);
}

/**
 * Option Default Value
 *
 * @return array
 */
function bc_rb_option_default_value() {
	return array(
		'disable'        => '',
		'open'           => '',
		'disable_mobile' => '',
		'user_logged_in' => '',
		'empty_banner' => 'There is no ads to display, Please add some',
	);
}

/**
 * Currency Lists
 *
 * @return array
 */
function bc_rb_currency_lists() {
	return array(
		'USD' => array( 'name' => 'US Dollar', 'symbol' => '$', 'hex' => '&#x24;' ),
		'AED' => array( 'name' => 'United Arab Emirates Dirham', 'symbol' => 'د.إ', 'hex' => '&#x62f;&#x2e;&#x625;' ),
		'ANG' => array( 'name' => 'NL Antillian Guilder', 'symbol' => 'ƒ', 'hex' => '&#x192;' ),
		'ARS' => array( 'name' => 'Argentine Peso', 'symbol' => '$', 'hex' => '&#x24;' ),
		'AUD' => array( 'name' => 'Australian Dollar', 'symbol' => 'A$', 'hex' => '&#x41;&#x24;' ),
		'BRL' => array( 'name' => 'Brazilian Real', 'symbol' => 'R$', 'hex' => '&#x52;&#x24;' ),
		'BSD' => array( 'name' => 'Bahamian Dollar', 'symbol' => 'B$', 'hex' => '&#x42;&#x24;' ),
		'CAD' => array( 'name' => 'Canadian Dollar', 'symbol' => '$', 'hex' => '&#x24;' ),
		'CHF' => array( 'name' => 'Swiss Franc', 'symbol' => 'CHF', 'hex' => '&#x43;&#x48;&#x46;' ),
		'CLP' => array( 'name' => 'Chilean Peso', 'symbol' => '$', 'hex' => '&#x24;' ),
		'CNY' => array( 'name' => 'Chinese Yuan Renminbi', 'symbol' => '¥', 'hex' => '&#xa5;' ),
		'COP' => array( 'name' => 'Colombian Peso', 'symbol' => '$', 'hex' => '&#x24;' ),
		'CZK' => array( 'name' => 'Czech Koruna', 'symbol' => 'Kč', 'hex' => '&#x4b;&#x10d;' ),
		'DKK' => array( 'name' => 'Danish Krone', 'symbol' => 'kr', 'hex' => '&#x6b;&#x72;' ),
		'EUR' => array( 'name' => 'Euro', 'symbol' => '€', 'hex' => '&#x20ac;' ),
		'FJD' => array( 'name' => 'Fiji Dollar', 'symbol' => 'FJ$', 'hex' => '&#x46;&#x4a;&#x24;' ),
		'GBP' => array( 'name' => 'British Pound', 'symbol' => '£', 'hex' => '&#xa3;' ),
		'GHS' => array( 'name' => 'Ghanaian New Cedi', 'symbol' => 'GH₵', 'hex' => '&#x47;&#x48;&#x20b5;' ),
		'GTQ' => array( 'name' => 'Guatemalan Quetzal', 'symbol' => 'Q', 'hex' => '&#x51;' ),
		'HKD' => array( 'name' => 'Hong Kong Dollar', 'symbol' => '$', 'hex' => '&#x24;' ),
		'HNL' => array( 'name' => 'Honduran Lempira', 'symbol' => 'L', 'hex' => '&#x4c;' ),
		'HRK' => array( 'name' => 'Croatian Kuna', 'symbol' => 'kn', 'hex' => '&#x6b;&#x6e;' ),
		'HUF' => array( 'name' => 'Hungarian Forint', 'symbol' => 'Ft', 'hex' => '&#x46;&#x74;' ),
		'IDR' => array( 'name' => 'Indonesian Rupiah', 'symbol' => 'Rp', 'hex' => '&#x52;&#x70;' ),
		'ILS' => array( 'name' => 'Israeli New Shekel', 'symbol' => '₪', 'hex' => '&#x20aa;' ),
		'INR' => array( 'name' => 'Indian Rupee', 'symbol' => '₹', 'hex' => '&#x20b9;' ),
		'ISK' => array( 'name' => 'Iceland Krona', 'symbol' => 'kr', 'hex' => '&#x6b;&#x72;' ),
		'JMD' => array( 'name' => 'Jamaican Dollar', 'symbol' => 'J$', 'hex' => '&#x4a;&#x24;' ),
		'JPY' => array( 'name' => 'Japanese Yen', 'symbol' => '¥', 'hex' => '&#xa5;' ),
		'KRW' => array( 'name' => 'South-Korean Won', 'symbol' => '₩', 'hex' => '&#x20a9;' ),
		'LKR' => array( 'name' => 'Sri Lanka Rupee', 'symbol' => '₨', 'hex' => '&#x20a8;' ),
		'MAD' => array( 'name' => 'Moroccan Dirham', 'symbol' => '.د.م', 'hex' => '&#x2e;&#x62f;&#x2e;&#x645;' ),
		'MMK' => array( 'name' => 'Myanmar Kyat', 'symbol' => 'K', 'hex' => '&#x4b;' ),
		'MXN' => array( 'name' => 'Mexican Peso', 'symbol' => '$', 'hex' => '&#x24;' ),
		'MYR' => array( 'name' => 'Malaysian Ringgit', 'symbol' => 'RM', 'hex' => '&#x52;&#x4d;' ),
		'NOK' => array( 'name' => 'Norwegian Kroner', 'symbol' => 'kr', 'hex' => '&#x6b;&#x72;' ),
		'NZD' => array( 'name' => 'New Zealand Dollar', 'symbol' => '$', 'hex' => '&#x24;' ),
		'PAB' => array( 'name' => 'Panamanian Balboa', 'symbol' => 'B/.', 'hex' => '&#x42;&#x2f;&#x2e;' ),
		'PEN' => array( 'name' => 'Peruvian Nuevo Sol', 'symbol' => 'S/.', 'hex' => '&#x53;&#x2f;&#x2e;' ),
		'PHP' => array( 'name' => 'Philippine Peso', 'symbol' => '₱', 'hex' => '&#x20b1;' ),
		'PKR' => array( 'name' => 'Pakistan Rupee', 'symbol' => '₨', 'hex' => '&#x20a8;' ),
		'PLN' => array( 'name' => 'Polish Zloty', 'symbol' => 'zł', 'hex' => '&#x7a;&#x142;' ),
		'RON' => array( 'name' => 'Romanian New Lei', 'symbol' => 'lei', 'hex' => '&#x6c;&#x65;&#x69;' ),
		'RSD' => array( 'name' => 'Serbian Dinar', 'symbol' => 'RSD', 'hex' => '&#x52;&#x53;&#x44;' ),
		'RUB' => array( 'name' => 'Russian Rouble', 'symbol' => 'руб', 'hex' => '&#x440;&#x443;&#x431;' ),
		'SEK' => array( 'name' => 'Swedish Krona', 'symbol' => 'kr', 'hex' => '&#x6b;&#x72;' ),
		'SGD' => array( 'name' => 'Singapore Dollar', 'symbol' => 'S$', 'hex' => '&#x53;&#x24;' ),
		'THB' => array( 'name' => 'Thai Baht', 'symbol' => '฿', 'hex' => '&#xe3f;' ),
		'TND' => array( 'name' => 'Tunisian Dinar', 'symbol' => 'DT', 'hex' => '&#x44;&#x54;' ),
		'TRY' => array( 'name' => 'Turkish Lira', 'symbol' => 'TL', 'hex' => '&#x54;&#x4c;' ),
		'TTD' => array( 'name' => 'Trinidad/Tobago Dollar', 'symbol' => '$', 'hex' => '&#x24;' ),
		'TWD' => array( 'name' => 'Taiwan Dollar', 'symbol' => 'NT$', 'hex' => '&#x4e;&#x54;&#x24;' ),
		'VEF' => array( 'name' => 'Venezuelan Bolivar Fuerte', 'symbol' => 'Bs', 'hex' => '&#x42;&#x73;' ),
		'VND' => array( 'name' => 'Vietnamese Dong', 'symbol' => '₫', 'hex' => '&#x20ab;' ),
		'XAF' => array( 'name' => 'CFA Franc BEAC', 'symbol' => 'FCFA', 'hex' => '&#x46;&#x43;&#x46;&#x41;' ),
		'XCD' => array( 'name' => 'East Caribbean Dollar', 'symbol' => '$', 'hex' => '&#x24;' ),
		'XPF' => array( 'name' => 'CFP Franc', 'symbol' => 'F', 'hex' => '&#x46;' ),
		'ZAR' => array( 'name' => 'South African Rand', 'symbol' => 'R', 'hex' => '&#x52;' ),
	);
}

/**
 * Show error or success
 */
function bc_success_error( $bool ) {
	$bool = filter_var( $bool, FILTER_VALIDATE_BOOLEAN );

	if ( $bool ) {
		return '<div class="bc_success_circle"></div>';
	}

	return '<div class="bc_error_circle"></div>';
}

/**
 * Get current user email address
 */
function bc_get_current_user_email() {
	$current_user = wp_get_current_user();

	return $current_user->user_email;
}

/**
 * Plugin Translation
 */
function bc_load_languages() {
	load_plugin_textdomain( 'bc_rb', false, dirname( BC_RB_PLUGIN_BASENAME ) . '/languages/' );
}

add_action( 'plugins_loaded', 'bc_load_languages' );