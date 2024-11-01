<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.webriderz.com/
 * @since      1.0.0
 *
 * @package    Age_Verification
 * @subpackage Age_Verification/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
$upload_dir = wp_upload_dir();
$plugin_dir = plugin_dir_url( __DIR__);
$bg_img = (!empty($setting->image) ? $upload_dir['url'] . '/'. $setting->image : $plugin_dir."images/bg.jpg");
$logo = (!empty($setting->logo) ? $upload_dir['url'] . '/'. $setting->logo : $plugin_dir."images/dummy-logo.png");
$age = isset($setting) ? $setting->age : '18';
?>
<div class="wr_verify_popup wr_verify_image" role="alert" id="age_v">
  	<div class="wr_verify_content" style="width: 40%;">
		<div class="wr_verify_row">
			<div class="wr_left_column" style="background-image: url(<?php echo esc_url($bg_img); ?>);">
				<div class="wr_verify_logo">
					<img src="<?php echo esc_url($logo); ?>" alt="logo">
				</div>
				<div class="wr_verify_description">
					<p>You Must Be <b><?php echo esc_html($age); ?></b> Years old to Enter</p>	
					<button class="wrf_red_btn" onclick="non_verified();">No</button><button class="wrf_green_btn" onclick="verifiedAge()">Yes</button>
				</div>
			</div>
		</div>
  	</div> 
</div>