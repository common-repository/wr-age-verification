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
<div class="wr_verify_popup" role="alert" id="age_v">
  	<div class="wr_verify_content">
		<div class="wr_verify_row">
			<div class="wr_left_column" style="background-image: url(<?php echo esc_url($bg_img); ?>);">
				<div class="wr_verify_logo">
					<img src="<?php echo esc_url($logo); ?>" alt="logo">
				</div>
				<div class="wr_verify_description">
					<?php if (!empty($setting->description)): ?>
						<p>
							<?php echo esc_html($setting->description);?>
						</p>		
					<?php else: ?>
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate, praesentium. Explicabo eos quod quaerat delectus consequatur magni repellendus, nam itaque autem eaque fuga commodi labore?</p>
					<?php endif ?>
				</div>
			</div>
			<div class="wr_right_column">
				<p id="wr_error"></p>
				<h5>Age Verification</h5>
				<span>
					You must be <b id="age"><?php echo esc_html($age); ?></b> years or older to access this website.
				</span>
				<div class="form_area">
					<form id="verify_form" action="javascript:;" method="POST" autocomplete="off">
						<input type="hidden" id="hidden" name="age" value="">
						<div class="wr_verify_country">
							<?php 
								if (count($countries) > 0) {
							?>
							<div class="wr_country_col">
								<h6>Pleae Select Your Country</h6>
								<select id="country" name="country" class="form-control" onchange="get_minimum_age();" required>
									<option value="">Select Your Country</option>
									<?php foreach ($countries as $key => $country): ?>
										<option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
									<?php endforeach ?>
								</select>
							</div>
							<?php 
								}
							?>
						</div>
						<h6>Please Enter Your date of birth</h6>
						<div class="wr_days_row">
							<div class="wr_days_col">
								<select name="day" id="day" class="form-control" required>
									<option value="">Day</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
									<option value="24">24</option>
									<option value="25">25</option>
									<option value="26">26</option>
									<option value="27">27</option>
									<option value="28">28</option>
									<option value="29">29</option>
									<option value="30">30</option>
									<option value="31">31</option>
								</select>
							</div>
							<div class="wr_days_col">
								<select name="day" id="month" class="form-control" required>
									<option value="">Month</option>
									<option value="January">January</option>
									<option value="February">February</option>
									<option value="March">March</option>
									<option value="April">April</option>
									<option value="May">May</option>
									<option value="June">June</option>
									<option value="July">July</option>
									<option value="August">August</option>
									<option value="September">September</option>
									<option value="October">October</option>
									<option value="November">November</option>
									<option value="December">December</option>
								</select>
							</div>
							<div class="wr_days_col">
								<input type="number" id="year" name="year" placeholder="Year" required class="form-control">
							</div>
						</div>
						<div class="wr_buttons_wrap">
							<div class="wr_enter_button">
								<button type="submit" class="wr_verify_enter wr_blue_button">Enter</button>
							</div>
							<div class="wr_exit_button">
								<button class="wr_verify_exit wr_blue_button" onclick="non_verified();">Exit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
  	</div> 
</div>
<script>
	var default_age = "<?php echo esc_html($age); ?>"
</script>