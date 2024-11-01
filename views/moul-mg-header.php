<?php
/**
 * Display Plugin page header.
 *
 * @package miniOrange UL_Management
 * @subpackage views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="moul_mg_head">
	<div>
		<div>
			<img src="<?php echo esc_url( MOUL_MG_LOGO_URL ); ?>" height="50px" alt="LOGO">
		</div>
		<a class="moul_mg_text_large" href="<?php echo esc_url( add_query_arg( array( 'page' => 'mouserloginmanagement' ), $filtered_current_page_url ) ); ?>">User and Login Management</a>
	</div>

	<div>
		<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'moul-mg-pricing' ), $filtered_current_page_url ) ); ?>" class="moul_mg_pricing_page_button moul_mg_header_center_section">
			<div>
				<img src="<?php echo esc_url( MOUL_MG_ICONS . 'pricing.webp' ); ?>" height="28px" alt="">
			</div>
			<div>
				Pricing Plans
			</div>
		</a>
	</div>

	<div class="moul_mg_header_right_section">
		<div class="moul_mg_header_right_section_card quick_links_card" id="moul_mg_header_quick_links_card" onclick="moul_mg_popup_card_clicked(this)">
			<div class="moul_mg_header_right_section_card_icon">
				<img src="<?php echo esc_url( MOUL_MG_ICONS . 'quick-links.webp' ); ?>" alt="">
			</div>
			<div class="moul_mg_header_right_section_card_text">
				Quick Links
			</div>

			<div class="moul_mg_popup_box d-none" id="moul_mg_quick_links_card">
				<div>
					<img src="<?php echo esc_url( MOUL_MG_GIF . 'quick_links.gif' ); ?>" height="150px" alt="">
				</div>
				<div class="moul_mg_popup_title">Quick Links</div>
				<br>
				<div>
					<a href="https://plugins.miniorange.com/wordpress-login-and-user-management-plugin" class="moul_mg_quick_links_btn" target="_blank">Licensing Page</a>
				</div>
				<br>
				<div>
					<a href="https://plugins.miniorange.com/wordpress-user-session-login-management" class="moul_mg_quick_links_btn" target="_blank">Setup Guide</a>
				</div>
				<br>
			</div>
		</div>

		<div class="moul_mg_header_right_section_card contact_us_card" id="moul_mg_header_contact_us_card" onclick="moul_mg_popup_card_clicked(this)">
			<div class="moul_mg_header_right_section_card_icon">
				<img src="<?php echo esc_url( MOUL_MG_ICONS . 'contact-us.webp' ); ?>" alt="">
			</div>
			<div class="moul_mg_header_right_section_card_text">
				Contact Us
			</div>
			<div class="moul_mg_popup_box d-none" id="moul_mg_contact_us_card">
				<div>
					<img src="<?php echo esc_url( MOUL_MG_GIF . 'contact_us.gif' ); ?>" height="150px" alt="">
				</div>
				<div class="moul_mg_popup_title">Contact Us</div>
				<p>Need any help? We can help you with configuring LDAP configuration. Just send us a query so we can help you.</p>
				<form action="" method="post" class="moul_mg_support_popup_form">
					<?php wp_nonce_field( 'moul_mg_contact_us_nonce' ); ?>
					<input type="hidden" name="option" value="moul_mg_contact_us_option">
					<div class="moul_mg_full_width moul_mg_font_dark">
						<input type="email" name="moul_mg_contact_us_email" class="moul_mg_popup_input_box moul_mg_full_input" placeholder="Enter Your Email" >
						<input type="tel" name="moul_mg_contact_us_phone" id="moul_mg_telephone_input" class="moul_mg_popup_input_box moul_mg_full_input" placeholder="Enter Your Phone Number">
						<textarea name="moul_mg_contact_us_query" id="" cols="3" class="moul_mg_popup_input_box moul_mg_full_input" placeholder="Please write your query here"></textarea>
					</div>
					<input type="submit" class="moul_mg_submit_query_button" value="Submit Query">
				</form>
			</div>
		</div>

		<div class="moul_mg_header_right_section_card setup_call_card" id="moul_mg_header_setup_call_card" onclick="moul_mg_popup_card_clicked(this)">
			<div class="moul_mg_header_right_section_card_icon">
				<img src="<?php echo esc_url( MOUL_MG_ICONS . 'setup-call.webp' ); ?>" alt="">
			</div>
			<div class="moul_mg_header_right_section_card_text">
				Setup a call
			</div>

			<div class="moul_mg_popup_box d-none" id="moul_mg_setup_call_card">
				<div>
					<img src="<?php echo esc_url( MOUL_MG_GIF . 'setup_call.gif' ); ?>" height="150px" alt="">
				</div>
				<div class="moul_mg_popup_title">Setup a call</div>
				<p>Setup a call / screen-share session with miniOrange Technical Team</p>
				<form action="" method="post" class="moul_mg_support_popup_form">
					<?php wp_nonce_field( 'moul_mg_setup_call_nonce' ); ?>
					<input type="hidden" name="option" value="moul_mg_setup_call_option">
					<div>
						<select class="moul_mg_select moul_mg_popup_input_box moul_mg_full_input" name="moul_mg_setup_call_timezone" id="moul_mg_setup_call_timezone" class="moul_mg_popup_input_box moul_mg_full_input">
							<option value="" selected disabled>Select your time-zone</option>
							<?php
							foreach ( $zones as $zone => $value ) {
								if ( strcasecmp( $value, 'Etc/GMT' ) === 0 ) {
									?>
									<option value="<?php echo esc_attr( $zone . ' ' . $value ); ?>" selected><?php echo esc_html( $zone ); ?></option>
									<?php
								} else {
									?>
									<option value="<?php echo esc_attr( $zone . ' ' . $value ); ?>"><?php echo esc_html( $zone ); ?></option>
									<?php
								}
							}
							?>
						</select>
						<div style="display: flex; width: 100%">
							<input type="date" class="moul_mg_popup_input_box" name="moul_mg_setup_call_date" id="moul_mg_setup_call_date" style="width: 60%;">
							<input type="time" class="moul_mg_popup_input_box" name="moul_mg_setup_call_time" id="moul_mg_setup_call_time" style="width: 40%;">
						</div>
						<input type="email" name="moul_mg_setup_call_email" class="moul_mg_popup_input_box moul_mg_full_input" placeholder="Enter Your Email" >
						<textarea name="moul_mg_setup_call_query" id="" cols="3" class="moul_mg_popup_input_box moul_mg_full_input" placeholder="How may we help you?"></textarea>
					</div>
					<input type="submit" class="moul_mg_submit_query_button" value="Setup a call">
				</form>
			</div>
		</div>		
	</div>
</div>

<div class="moul_mg_overlay_back d-none" id="moul_mg_overlay"></div>
