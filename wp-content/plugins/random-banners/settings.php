<?php

	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


	function alobaidi_random_banners_add_settings_page() {
		add_plugins_page( 'Random Banners Settings', 'Random Banners', 'manage_options', 'alobaidi_random_banners_settings', 'alobaidi_random_banners_settings_page');
	}
	add_action( 'admin_menu', 'alobaidi_random_banners_add_settings_page' );
	

	function alobaidi_random_banners_register_settings() {
		register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_banners' );
		register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_links' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_display_banners' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_banners_align' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_screen' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_search' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_category' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_tag' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_home' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_404' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_front_page' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_attachment' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_post_type_post' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_post_type_page' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_custom_post_type' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_custom_banners' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_custom_links' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_aside' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_image' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_video' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_quote' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_link' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_gallery' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_status' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_audio' );
        register_setting( 'alobaidi_random_banners_register_setting', 'alobaidi_rbp_exclude_chat' );
	}
	add_action( 'admin_init', 'alobaidi_random_banners_register_settings' );
		

	function alobaidi_random_banners_settings_page(){ // settings page function
        $display_banners            =   get_option( 'alobaidi_rbp_display_banners' );
        $banners_align              =   get_option( 'alobaidi_rbp_banners_align' );
        $screen                     =   get_option( 'alobaidi_rbp_screen' );
        $exclude_search             =   get_option( 'alobaidi_rbp_exclude_search' );
        $exclude_category           =   get_option( 'alobaidi_rbp_exclude_category' );
        $exclude_tag                =   get_option( 'alobaidi_rbp_exclude_tag' );
        $exclude_home               =   get_option( 'alobaidi_rbp_exclude_home' );
        $exclude_front_page         =   get_option( 'alobaidi_rbp_exclude_front_page' );
        $exclude_404                =   get_option( 'alobaidi_rbp_exclude_404' );
        $exclude_attachment         =   get_option( 'alobaidi_rbp_exclude_attachment' );
        $exclude_post_type_post     =   get_option( 'alobaidi_rbp_exclude_post_type_post' );
        $exclude_post_type_page     =   get_option( 'alobaidi_rbp_exclude_post_type_page' );
        $exclude_aside              =   get_option( 'alobaidi_rbp_exclude_aside' );
        $exclude_quote              =   get_option( 'alobaidi_rbp_exclude_quote' );
        $exclude_link               =   get_option( 'alobaidi_rbp_exclude_link' );
        $exclude_gallery            =   get_option( 'alobaidi_rbp_exclude_gallery' );
        $exclude_status             =   get_option( 'alobaidi_rbp_exclude_status' );
        $exclude_audio              =   get_option( 'alobaidi_rbp_exclude_audio' );
        $exclude_chat               =   get_option( 'alobaidi_rbp_exclude_chat' );
        $exclude_image              =   get_option( 'alobaidi_rbp_exclude_image' );
        $exclude_video              =   get_option( 'alobaidi_rbp_exclude_video' );
		?>
			<div class="wrap">
				<h2>Random Banners Settings</h2>
                
				<?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] ){ ?>
					<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
						<p><strong>Settings saved.</strong></p>
                        <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
					</div>
				<?php } ?>
                
            	<form method="post" action="options.php">
                	<?php settings_fields( 'alobaidi_random_banners_register_setting' ); ?>

                    <h3>Post Content Banners</h3>
                    <table class="form-table">
                        <tbody>

                            <tr>
                                <th><label for="alobaidi_rbp_banners">Banners</label></th>
                                <td>
                                    <textarea id="alobaidi_rbp_banners" name="alobaidi_rbp_banners" rows="10" cols="50" class="large-text code" style="white-space:nowrap !important;"><?php echo esc_textarea( get_option('alobaidi_rbp_banners') ); ?></textarea>
                                     <p class="description">Enter list of banners links, one URL per line.</p>
                                </td>
                            </tr>

                            <tr>
                                <th><label for="alobaidi_rbp_links">Links</label></th>
                                <td>
                                     <textarea id="alobaidi_rbp_links" name="alobaidi_rbp_links" rows="10" cols="50" class="large-text code" style="white-space:nowrap !important;"><?php echo esc_textarea( get_option('alobaidi_rbp_links') ); ?></textarea>
                                    <p class="description">Enter list of links <a href="<?php echo plugins_url( '/images/same-order.png', __FILE__ ); ?>" target="_blank">in the same order</a>, one URL per line.</p>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">Display Banners</th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>Display Banners</span></legend>
                                        <label><input type="radio" name="alobaidi_rbp_display_banners" value="before" <?php checked( $display_banners, 'before' ); ?>>Before post content automatically.</label>
                                        <br>
                                        <label><input type="radio" name="alobaidi_rbp_display_banners" value="after" <?php checked( $display_banners, 'after' ); ?>>After post content automatically.</label>
                                        <br>
                                        <label><input type="radio" name="alobaidi_rbp_display_banners" value="before_and_after" <?php checked( $display_banners, 'before_and_after' ); ?>>Before and after post content automatically.</label>
                                        <br>
                                        <label><input type="radio" name="alobaidi_rbp_display_banners" value="disable" <?php checked( $display_banners, 'disable' ); ?>>Disable post content banners.</label>
                                    </fieldset>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">Banners Align</th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>Banners Align</span></legend>
                                        <label><input type="radio" name="alobaidi_rbp_banners_align" value="none" <?php checked( $banners_align, 'none' ); ?>>None.</label>
                                        <br>
                                        <label><input type="radio" name="alobaidi_rbp_banners_align" value="center" <?php checked( $banners_align, 'center' ); ?>>Center.</label>
                                        <br>
                                        <label><input type="radio" name="alobaidi_rbp_banners_align" value="left" <?php checked( $banners_align, 'left' ); ?>>Left.</label>
                                        <br>
                                        <label><input type="radio" name="alobaidi_rbp_banners_align" value="right" <?php checked( $banners_align, 'right' ); ?>>Right.</label>
                                    </fieldset>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row">Screen And Exclude</th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>Screen And Exclude</span></legend>
                                        <label title="single posts, single pages, single custom post type"><input type="radio" name="alobaidi_rbp_screen" value="single" <?php checked( $screen, 'single' ); ?>>Display banners in single post only.</label>
                                        <br>
                                        <label title="home page, front page, search page, category page, tag page, 404 error page, attachment page"><input type="radio" name="alobaidi_rbp_screen" value="index" <?php checked( $screen, 'index' ); ?>>Display banners in index pages only.</label>
                                        <br>
                                        <label title="all website pages"><input type="radio" name="alobaidi_rbp_screen" value="all" <?php checked( $screen, 'all' ); ?>>Display banners in single post and index pages.</label>
                                        <br>
                                        <label>When choosing "in index pages" or "in single post and index pages", exclude:</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_home" value="true" <?php checked( $exclude_home, 'true' ); ?>>Exclude home page.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_front_page" value="true" <?php checked( $exclude_front_page, 'true' ); ?>>Exclude front page.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_search" value="true" <?php checked( $exclude_search, 'true' ); ?>>Exclude search page.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_category" value="true" <?php checked( $exclude_category, 'true' ); ?>>Exclude category page.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_tag" value="true" <?php checked( $exclude_tag, 'true' ); ?>>Exclude tag page.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_attachment" value="true" <?php checked( $exclude_attachment, 'true' ); ?>>Exclude attachment page.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_404" value="true" <?php checked( $exclude_404, 'true' ); ?>>Exclude 404 error page.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_aside" value="true" <?php checked( $exclude_aside, 'true' ); ?>>Exclude aside post format.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_image" value="true" <?php checked( $exclude_image, 'true' ); ?>>Exclude image post format.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_video" value="true" <?php checked( $exclude_video, 'true' ); ?>>Exclude video post format.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_quote" value="true" <?php checked( $exclude_quote, 'true' ); ?>>Exclude quote post format.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_link" value="true" <?php checked( $exclude_link, 'true' ); ?>>Exclude link post format.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_gallery" value="true" <?php checked( $exclude_gallery, 'true' ); ?>>Exclude gallery post format.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_status" value="true" <?php checked( $exclude_status, 'true' ); ?>>Exclude status post format.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_audio" value="true" <?php checked( $exclude_audio, 'true' ); ?>>Exclude audio post format.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_chat" value="true" <?php checked( $exclude_chat, 'true' ); ?>>Exclude chat post format.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_post_type_post" value="true" <?php checked( $exclude_post_type_post, 'true' ); ?>>Exclude post type post.</label>
                                        <br>
                                        <label><input type="checkbox" name="alobaidi_rbp_exclude_post_type_page" value="true" <?php checked( $exclude_post_type_page, 'true' ); ?>>Exclude post type page.</label>
                                        <br>
                                        <label for="alobaidi_rbp_exclude_custom_post_type">Exclude custom post type:</label>
                                        <input id="alobaidi_rbp_exclude_custom_post_type" type="text" class="regular-text" name="alobaidi_rbp_exclude_custom_post_type" value="<?php echo esc_attr( get_option( 'alobaidi_rbp_exclude_custom_post_type' ) ); ?>">
                                        <p class="description">Enter custom post type name, if two or more, enter space between name, for example: movies book games.</p>
                                    </fieldset>
                                    <p class="description">Exclude options not working with "Custom Place Banners", <a href="http://wp-plugins.in/random-banners" target="_blank">Learn how to exclude with custom place banners</a>.</p>
                                </td>
                            </tr>

                            <tr>
                                <th><label for="alobaidi_rbp_shortcode">Shortcode</label></th>
                                <td>
                                    <textarea id="alobaidi_rbp_shortcode" rows="24" cols="50" class="large-text code" style="white-space:nowrap !important;">
                                        To display random banners between post content,
                                        use this shortcode:
                                        [obi_random_banners]


                                        Shortcode attributes:
                                        align=""
                                        enter "center" or "left" or "right" or "none".
                                        default is "none".


                                        screen=""
                                        enter "index" or "all" or "single".
                                        if choosing "single" will be display banners between post content in single post or single page, etc.
                                        if choosing "index" will be display banners between post content in index pages only, like home page, category page, etc.
                                        if choosing "all" will be display banners between post content in index pages and in single post, etc.
                                        default is "single".


                                        For example:
                                        [obi_random_banners align="center" screen="index"]
                                        now will be display random banners in index pages only and banners will be center align.
                                    </textarea>
                                     <p class="description">To display random banners between post content, exclude options is working with this shortcode, <a href="http://wp-plugins.in/random-banners" target="_blank">Do you have some wrongs with shortcode? Please read</a>.</p>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <h3>Custom Place Banners</h3>
                    <table class="form-table">
                        <tbody>

                            <tr>
                                <th><label for="alobaidi_rbp_custom_banners">Banners</label></th>
                                <td>
                                    <textarea id="alobaidi_rbp_custom_banners" name="alobaidi_rbp_custom_banners" rows="10" cols="50" class="large-text code" style="white-space:nowrap !important;"><?php echo esc_textarea( get_option('alobaidi_rbp_custom_banners') ); ?></textarea>
                                     <p class="description">Enter list of banners links, one URL per line.</p>
                                </td>
                            </tr>

                            <tr>
                                <th><label for="alobaidi_rbp_custom_links">Links</label></th>
                                <td>
                                     <textarea id="alobaidi_rbp_custom_links" name="alobaidi_rbp_custom_links" rows="10" cols="50" class="large-text code" style="white-space:nowrap !important;"><?php echo esc_textarea( get_option('alobaidi_rbp_custom_links') ); ?></textarea>
                                    <p class="description">Enter list of links <a href="<?php echo plugins_url( '/images/same-order.png', __FILE__ ); ?>" target="_blank">in the same order</a>, one URL per line.</p>
                                </td>
                            </tr>

                            <tr>
                                <th><label for="alobaidi_rbp_custom_usage">Usage</label></th>
                                <td>
                                    <textarea id="alobaidi_rbp_custom_usage" rows="10" cols="50" class="large-text code" style="white-space:nowrap !important;">
                                        Now go to your custom place, for example in header.php file or footer.php file, etc,
                                        and use this code:
                                        <?php echo esc_html('<?php
                                            $banners = get_option("alobaidi_rbp_custom_banners");
                                            $links = get_option("alobaidi_rbp_custom_links");
                                            echo alobaidi_random_banners( $banners, $links, null );
                                        ?>'); ?>
                                    </textarea>
                                    <p class="description">To display random banners in custom place, <a href="http://wp-plugins.in/random-banners" target="_blank">To using more of custom place, please read</a>.</p>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    
                    <p class="submit"><input id="submit" class="button button-primary" type="submit" name="submit" value="Save Changes"></p>
                </form>
                
            	<div class="tool-box">
					<h4 class="title">Recommended Links</h4>
					<p>Get collection of 87 WordPress themes for $69 only, a lot of features and free support! <a href="http://j.mp/ET_WPTime_ref_pl" target="_blank">Get it now</a>.</p>
					<p>See also:</p>
						<ul>
							<li><a href="http://j.mp/CM_WPTime" target="_blank">Premium WordPress themes on CreativeMarket.</a></li>
							<li><a href="http://j.mp/TF_WPTime" target="_blank">Premium WordPress themes on Themeforest.</a></li>
							<li><a href="http://j.mp/CC_WPTime" target="_blank">Premium WordPress plugins on Codecanyon.</a></li>
						</ul>
					<p><a href="http://j.mp/ET_WPTime_ref_pl" target="_blank"><img src="<?php echo plugins_url( '/images/570x100.jpg', __FILE__ ); ?>"></a></p>
				</div>
                
            </div>
        <?php
	} // settings page function

?>