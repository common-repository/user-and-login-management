<?php
/**
 * Display pricing page.
 *
 * @package miniOrange UL_Management
 * @subpackage views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<script>
	var selectPricingArray = {
		'1'         : '159',
		'2'         : '286',
		'3'         : '405',
		'4'         : '516',
		'5'         : '619',
		'6'         : '710',
		'7'         : '789',
		'8'         : '857',
		'9'         : '912',
		'10'        : '955',
		'11'        : '994',
		'12'        : '1,029',
		'13'        : '1,060',
		'14'        : '1,087',
		'15'        : '1,111',
		'16'        : '1,131',
		'17'        : '1,146',
		'18'        : '1,157',
		'19'        : '1,164',
		'20'        : '1,168',
		'30'        : '1,208',
		'40'        : '1,248',
		'50'        : '1,431',
		'100'       : '1,590',
		'UNLIMITED' : '1,999',
	};
	function createSelectOpt(elemId) {
		var selectElem = ' <select class="no_instance" required="true" onchange="changePricing(this)" id="' + elemId + '">';
		jQuery.each(selectPricingArray, function (instances, price) {
			selectElem = selectElem + '<option value="' + instances + '" data-value="' + instances + '">' + instances + ' </option>';
		})
		selectElem = selectElem + '</select>';
		return document.write(selectElem);
	}

	function changePricing($this) {
		var selectId = jQuery($this).attr("id");
		var e = document.getElementById(selectId);
		var strUser = e.options[e.selectedIndex].value;
		var strUserInstances = strUser != "UNLIMITED" ? strUser : 500;
		selectArrayElement = [];
		selectArrayElement = selectPricingArray[strUser];
		jQuery('#moul_mg_pricing_value').text(selectArrayElement);
	}
</script>

<div class="moul_mg_page_container moul_mg_full_width">
	<div class="tab-content">
		<a href="<?php echo esc_url( add_query_arg( array( 'page' => 'mouserloginmanagement' ), $filtered_current_page_url ) ); ?>" class="moul_mg_submit_button moul_mg_back_to_pligin_button">< Back to Plugin Configuration</a>
		<div class="tab-pane active text-center" id="cloud">
			<div class="cd-pricing-container cd-has-margins" style="max-width: unset">
				<section class="section-licensing-plans js--section-plans" id="plans">
					<div class="row">
						<h2 class="mo-ldap-h2">
							Plans For Everyone
						</h2>
					</div>
					<div class="row">
						<div class="col span-1-of-2 moul-mg-plan-boxes">
							<div class="licensing-plan-box js--wp-4">
								<div class="moul_mg_licensing_plan_name">
									Free Plan
								</div>
								<div class="moul_mg_licensing_plan_price_section">
									<div class="plan-price">
										<span class="moul_mg_pricing_currency">$</span><span class="moul_mg_pricing_value" id="moul_mg_pricing_amount">0</span>
									</div>
								</div>

								<div>
									<a href="javascript:void(0)" class="btn btn-ghost moul_mg_submit_btn">Active Plan</a>
								</div>
							</div>
						</div>
						<div class="col span-1-of-2 moul-mg-plan-boxes">
							<div class="licensing-plan-box premium-licensing-plan-box">
								<div class="moul_mg_licensing_plan_name">
									Premium Plan
									<div> For 
										<script>
											createSelectOpt('1');
										</script>
										Instances
										<hr class="plan-seprator">
									</div>

								</div>
								<div class="moul_mg_licensing_plan_price_section">
									<div class="plan-price">
										<span style="font-size: 25px; font-weight: 500">$</span> <span class="moul_mg_pricing_value" id="moul_mg_pricing_value">159</span>
									</div>
									<div>Per Year</div>
								</div>

								<div>
									<a href="javascript:void(0)" class="btn btn-full moul_mg_submit_btn" id="moul_mg_header_contact_us_card moul_mg_buy_now_btn" onclick="upgradeForm('wp_user_login_mg_premium_plan')">Buy Now</a>
								</div>	
							</div>
						</div>
					</div>
					<div class="row moul_mg_licensing_details">For More Details, please <a href="https://plugins.miniorange.com/wordpress-login-and-user-management-plugin" target="_blank">click here</a>.</div>
				</section>

				<section class="payment-methods">
					<div class="row">
						<h2 class="mo-ldap-h2">Supported Payment Methods</h2>
					</div>
					<div class="row">
						<div class="col span-1-of-3">
							<div class="plan-box">
								<div>
									<img src="<?php echo esc_url( MOUL_MG_IMAGES . 'cards.webp' ); ?>" width="95%;" height="105%" alt="">
								</div>
								<div>
									If the payment is made through Credit Card/International Debit Card, the license will be created automatically once the payment is completed.
								</div>
							</div>
						</div>
						<div class="col span-1-of-3">
							<div class="plan-box">
								<div>
									<img class="payment-images" src="<?php echo esc_url( MOUL_MG_IMAGES . 'paypal.webp' ); ?>" alt="image not found">
								</div>
								<div>
									Use the following PayPal ID <strong>info@xecurify.com</strong> for making the payment via PayPal.<br><br>
								</div>
							</div>
						</div>
						<div class="col span-1-of-3">
							<div class="plan-box">
								<div>
									<em style="font-size:30px;" class="fas fa-university" aria-hidden="true"><span style="font-size: 20px;font-weight:500;">&nbsp;&nbsp;Bank Transfer</span></em>
								</div>
								<div>
									If you want to use bank transfer for the payment then contact us at <span style="color:blue;text-decoration:underline; word-wrap: break-word;">info@xecurify.com</span> so that we can provide you the bank details.
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<p style="margin-top:20px;font-size:16px;">
							<span style="font-weight:500;"> Note :</span> Once you have paid through PayPal/Net Banking, please inform us so that we can confirm and update your license.
						</p>
					</div>
				</section>

				<div class="PricingCard-toggle ldap-plan-title mul-dir-heading">
					<h2 class="mo-ldap-h2">Return Policy</h2>
				</div>
				<section class="return-policy">
					<p style="font-size:16px;">
						If the premium plugin you purchased is not working as advertised and you've attempted to resolve
						any feature issues with our support team, which couldn't get resolved, we will refund the whole
						amount within 10 days of the purchase. <br><br>
						<span style="color:red;font-weight:500;font-size:18px;">Note that this policy does not cover the
							following cases: </span> <br><br>
						<span> 1. Change of mind or change in requirements after purchase. <br>
							2. Infrastructure issues not allowing the functionality to work.
						</span> <br><br>
						Please email us at <a href="mailto:info@xecurify.com">info@xecurify.com</a> for
						any queries regarding the return policy.
						<a href="#" class="button button-primary button-large back-to-top" style="font-size:15px;">Top
							&nbsp;↑</a>
					</p>
				</section>
			</div>
		</div>
	</div>
</div>
