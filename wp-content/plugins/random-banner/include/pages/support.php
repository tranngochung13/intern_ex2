<?php
function bc_get_random_banner_support() {
	global $wp_version,$wpdb;
	if ( method_exists( $wpdb, 'db_version' ) ) {
		$mysql_version = preg_replace( '/[^0-9.].*/', '', $wpdb->db_version() );
	} else {
		$mysql_version = 'N/A';
	}
	?>
<div class="bc_rb container bc_random_banner" data-display_name="<?php echo bc_rb_get_user_display_name(); ?>">
	<?php echo bc_rb_loader(); ?>
	<h2>
		<?php echo esc_html__( 'Random Banner Support', 'bc_rb' ) ?>
	</h2>
	<div class="col-md-12">
		<?php
		if ( isset( $_REQUEST['success'] ) ) {
			bc_rb_on_success_payment( $_REQUEST );
		}
		?>
	</div>
	<div class="row bc_rb_transaction_details">
		<div class="col-md-5">
			<?php
			if ( ! isset( $_REQUEST['success'] ) ) {
				?>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title"><?php _e( 'Buy Pro Version', 'bc_rb' ) ?></h3>
							</div>
							<div class="panel-body">
								<div class="row  flex_center ">
									<?php echo bc_rb_show_payment_details(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title"><?php _e( 'Support', 'bc_rb' ) ?></h3>
						</div>
						<div class="panel-body">
							<div class="flex_between">
								<div class="bc_item">
									<a href="https://buffercode.com/plugin/random-banner-pro">
										<img src="<?php echo plugins_url( 'assets/images/chat.png', BC_RB_PLUGIN ) ?>"/>
									</a>
									<h5 class="text-center"><?php _e( 'Chat', 'bc_rb' ) ?></h5>
								</div>
								<div class="bc_item">
									<a href="mailto:support@buffercode.com">
										<img src="<?php echo plugins_url( 'assets/images/mail.png', BC_RB_PLUGIN ) ?>"/>
									</a>
									<h5 class="text-center"><?php _e( 'Mail', 'bc_rb' ) ?></h5>
								</div>
								<div class="bc_item paypal_donation_button">
									<a href="#">
										<img src="<?php echo plugins_url( 'assets/images/tickets.png', BC_RB_PLUGIN ) ?>"/>
									</a>
									<h5 class="text-center"><?php _e( 'Ticket[Pro]', 'bc_rb' ) ?></h5>
								</div>
								<div class="bc_item">
									<a href="https://wordpress.org/support/plugin/random-banner/reviews/?rate=5#new-post">
										<img src="<?php echo plugins_url( 'assets/images/rate.png', BC_RB_PLUGIN ) ?>"/>
									</a>
									<h5 class="text-center"><?php _e( 'Rate us', 'bc_rb' ) ?></h5>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title"><?php _e( 'Settings', 'bc_rb' ) ?></h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-5">
									<h4><?php _e( 'Plugin Version', 'bc_rb' ) ?></h4>
								</div>
								<div class="col-md-7">
									<h4><?php echo get_option( 'bc_random_banner_db_version', 'Error' ); ?></h4>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5">
									<h4><?php _e( 'PHP Version', 'bc_rb' ) ?></h4>
								</div>
								<div class="col-md-7">
									<h4>
										<?php echo phpversion() ?>
									</h4>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5">
									<h4><?php _e( 'WordPress Version', 'bc_rb' ) ?></h4>
								</div>
								<div class="col-md-7">
									<h4>
										<?php echo $wp_version ?>
									</h4>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5">
									<h4><?php _e( 'DB Version', 'bc_rb' ) ?></h4>
								</div>
								<div class="col-md-7">
									<h4>
										<?php echo $mysql_version ?>
									</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


		</div>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title"><?php _e( 'How to install the Pro version', 'bc_rb' ) ?></h3>
						</div>
						<div class="panel-body">
							<ol>
								<li><?php _e( 'Please Deactivate and Uninstall the Random Banner free version', 'bc_rb' ) ?></li>
								<li><?php _e( 'Hope you have received the login credentials to your PayPal email address after your
									purchase.', 'bc_rb' ) ?> (<?php _e( 'If not,
									please contact us on live chat', 'bc_rb' ) ?> (
									<a href="https://ifecho.com/"
									   target="_blank">https://buffercode.com/plugin/random-banner-pro
									</a>
									).
								</li>
								<li><?php _e( 'Download the Pro version using credentials.', 'bc_rb' ) ?></li>
								<li><?php _e( 'Upload the file using plugins --> Add New from your Admin Dashboard.', 'bc_rb' ) ?></li>
								<li><?php _e( 'Activate the plugin using your Licence key', 'bc_rb' ) ?></li>
								<li><?php _e( 'You can get the license key from', 'bc_rb' ) ?>
									<a href="https://buffercode.com/dashboard"
									   target="_blank">Buffercode - <?php _e( 'Activation', 'bc_rb' ) ?>
									</a>
								</li>
								<li><?php _e( 'Apply the license key and activate it.', 'bc_rb' ) ?></li>
								<li><?php _e( 'If you still not able to activate the plugin, please contact me through the live chat on', 'bc_rb' ) ?>
									<a href="https://buffercode.com/"
									   target="_blank">https://buffercode.com/
									</a>
								</li>
							</ol>
						</div>
					</div>


				</div>

			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title"><?php _e( 'Tables', 'bc_rb' ) ?></h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-5">
									<h4><?php _e( 'Random Banner', 'bc_rb' ) ?></h4>
								</div>
								<div class="col-md-7 padding_top_10">

									<?php echo bc_success_error( bc_get_table_status( BC_RB_RANDOM_BANNER_DB ) ); ?>

								</div>
							</div>
							<div class="row">
								<div class="col-md-5">
									<h4><?php _e( 'Category', 'bc_rb' ) ?></h4>
								</div>
								<div class="col-md-7 padding_top_10">

									<?php echo bc_success_error( bc_get_table_status( BC_RB_RANDOM_BANNER_CATEGORY ) ); ?>

								</div>
							</div>
							<div class="row">
								<div class="col-md-5">
									<h4><?php _e( 'Options', 'bc_rb' ) ?></h4>
								</div>
								<div class="col-md-7 padding_top_10">

									<?php echo bc_success_error( bc_get_table_status( BC_RB_RANDOM_BANNER_OPTION_DB ) ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<h3 class="panel-title"><?php _e( 'DELETE ALL TABLES AND SETTINGS', 'bc_rb' ) ?></h3>
						</div>
						<div class="panel-body">
							<h4 class="bg-danger"><?php _e( 'Beware! Please don\'t use this setting unless its necessary, this will delete all your Random Banner Tables and its associated options.', 'bc_rb' ) ?></h4>
							<form id="bc_delete_dbs" method="post" action="<?php echo admin_url( 'admin-ajax.php?action=bc_delete_dbs&bc_delete_dbs=' . wp_create_nonce( "bc_delete_dbs" ) ) ?>" >
								<button class="btn btn-danger" type="submit"><?php _e( 'Delete All Tables and Settings', 'bc_rb' ) ?></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}