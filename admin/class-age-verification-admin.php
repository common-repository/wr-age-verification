<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.webriderz.com/
 * @since      1.0.0
 *
 * @package    Age_Verification
 * @subpackage Age_Verification/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Age_Verification
 * @subpackage Age_Verification/admin
 * @author     Webriderz <info@webriderz.com>
 */
class Age_Verification_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Age_Verification_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Age_Verification_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $wp_styles;
		$srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src') );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/age-verification-admin.css', array(), $this->version, 'all' );
		if ( !in_array('bootstrap.min.css', $srcs)) {
			wp_enqueue_style( $this->plugin_name.'-bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );    
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Age_Verification_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Age_Verification_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $wp_styles;
		$srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src') );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/age-verification-admin.js', array( 'jquery' ), $this->version, false );
		if ( !in_array('popper.min.js', $srcs)) {
			wp_enqueue_script( $this->plugin_name.'-popper', plugin_dir_url( __FILE__ ) . 'js/popper.min.js', array( 'jquery' ), $this->version, false );  
		}
		if ( !in_array('bootstrap.min.js', $srcs)) {
			wp_enqueue_script( $this->plugin_name.'-bootstarp', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );  
		}
		wp_enqueue_script( $this->plugin_name.'-av-custom', plugin_dir_url( __FILE__ ) . 'js/av-custom.js', array( 'jquery' ));
		wp_localize_script( $this->plugin_name."-av-custom", 'ajax_url', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

	    /*
	     * Add a settings page for this plugin to the Settings menu.
	     *
	     */
	    add_options_page( 'Age Verification', 'Age Verification', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
	    );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
	    /*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */
	   $settings_link = array(
	    '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
		global $wpdb;
		$table = $wpdb->prefix."age_v_settings";
		$wordpress_upload_dir = wp_upload_dir();
		$settings = $wpdb->get_row("SELECT * FROM ".$table."");
		if ( ! function_exists( 'wp_handle_upload' ) ) {
		    require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		// We are only allowing images
		$allowedMimes = array(
		    'jpg|jpeg|jpe' => 'image/jpeg',
		    'gif'          => 'image/gif',
		    'png'          => 'image/png',
		);
		$error = false;
		$msg = array();
		/*if (isset($_POST['submit'])) {
			$logo = wp_check_filetype(basename($_FILES['logo_file']['name']), $allowedMimes);
			$bg_file = wp_check_filetype(basename($_FILES['bg_file']['name']), $allowedMimes);
			if (empty($logo['type']) or empty($bg_file['type'])) {
				$error = 'Invalid File Type, Only Jpeg/png/gif/jpg allwoed';
			}else{
				wp_handle_upload( $_FILES['logo_file'], array('test_form' => FALSE));
				wp_handle_upload( $_FILES['bg_file'], array('test_form' => FALSE));
				$wpdb->insert($table, array(
					'image' => sanitize_file_name($_FILES['bg_file']['name']),
					'logo'	=> sanitize_file_name($_FILES['logo_file']['name']),
					'description' => sanitize_textarea_field($_POST['description']),
					'template' => sanitize_text_field($_POST['template']),
					'age' => sanitize_text_field($_POST['age'])
				));
			}
			$msg = [
				'status'=>'success',
				'msg' => 'settings saved successfully'
			];
			$settings = $wpdb->get_row("SELECT * FROM ".$table."");
		}*/

		if (isset($_POST['update'])) {
			$id = sanitize_text_field($_POST['av_id']);
			$settings = $wpdb->get_row("SELECT * FROM ".$table." where id= $id");
			
			if ($_FILES['logo_file']['size'] != 0 ) {
				wp_delete_file( $wordpress_upload_dir['path'] . '/' . $settings->logo);
				wp_handle_upload( $_FILES['logo_file'], array('test_form' => FALSE) );
				$wpdb->query( $wpdb->prepare( "UPDATE ".$table." SET logo = %s WHERE ID = %d", sanitize_file_name($_FILES['logo_file']['name']), $id ) );
			}

			if ($_FILES['bg_file']['size'] != 0) {
				wp_delete_file( $wordpress_upload_dir['path'] . '/' . $settings->image);
				wp_handle_upload( $_FILES['bg_file'], array('test_form' => FALSE) );
				$wpdb->query( $wpdb->prepare( "UPDATE ".$table." SET image = %s WHERE ID = %d", sanitize_file_name($_FILES['bg_file']['name']), $id ) );
			}

			$wpdb->query( $wpdb->prepare( "UPDATE ".$table." SET description = %s, age = %d, template=%s WHERE ID = %d", sanitize_textarea_field($_POST['description']), sanitize_text_field($_POST['age']), sanitize_text_field($_POST['template']), $id ) );
			$settings = $wpdb->get_row("SELECT * FROM ".$table."");
			$msg = [
				'status'=>'success',
				'msg' => 'settings updated successfully'
			];
		}
		include_once( 'partials/age-verification-admin-display.php' );
	}

	/**
	 * Create Age Verification Menu
	 */
	public function create_age_verification_menu() {
		add_menu_page( 'Age Verification', 'Age Verification', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'), 'dashicons-yes-alt', 25
		);
		add_submenu_page( null, 'Add Country', 'Add Country', 'manage_options', 'add-country', array($this, 'display_plugin_country_page'));
		add_submenu_page( null, 'Add State', 'Add State', 'manage_options', 'add-state', array($this, 'display_plugin_state_page'));
	}

	/**
	 * Render Plugin Country Page
	 */
	public function display_plugin_country_page() {
		global $wpdb;
		$country_table = $wpdb->prefix."age_v_country";
		
		if (isset($_POST['update'])) {
			$id  = sanitize_text_field($_POST['c_id']);
			$name = sanitize_text_field($_POST['country']);
			$status = sanitize_text_field($_POST['status']);
			$age = sanitize_text_field($_POST['age']);
			$wpdb->query( $wpdb->prepare( "UPDATE ".$country_table." SET name = %s, status = %d, minimum_age = %d WHERE ID = %d", $name, $status, $age, $id ) );
		}
		include_once( 'partials/age-verification-admin-country-display.php' );
	}

	
	/**
	 * Form Validation
	 */
	public function age_verification_validation() {
?>
	<script>
		jQuery('#add_settings').submit(function() {
			var file = document.getElementById("logo").value;
			var bg = document.getElementById("bg").value;
			var content = document.getElementById("desc").value;
			if (file == '') {
				document.getElementById("logo_error").innerHTML = 'Please Upload Logo*';
				return false;
			}
			if (bg == '') {
				document.getElementById("bg_error").innerHTML = 'Please Upload Background Image*';
				return false;
			}
			if(content == "") {
				document.getElementById("d_error").innerHTML = 'Please Enter Some Short Description*';
				return false;
			}
			if (content.length > 200) {
				document.getElementById("d_error").innerHTML = 'Short description should be 200 character lenght';
				return false;
			}
		});
		jQuery('#update_settings').submit(function() {
			var content = document.getElementById("desc").value;
			if(content == "") {
				document.getElementById("d_error").innerHTML = 'Please Enter Some Short Description*';
				return false;
			}
			if (content.length > 200) {
				document.getElementById("d_error").innerHTML = 'Short description should be 200 character lenght';
				console.log('hello');
				return false;
			}
		});
		jQuery('#av_state_form').submit(function() {
			var country = document.getElementById("country").value;
			var state = document.getElementById("state").value;
			var age = document.getElementById("age").value;
			if (country == '') {
				document.getElementById("c_error").innerHTML = 'Please Select Country';
				return false;
			}
			if (state == '') {
				document.getElementById("s_error").innerHTML = 'Please Enter State';
				return false;
			}
			if(age == "") {
				document.getElementById("a_error").innerHTML = 'Please Enter Minimum Age';
				return false;
			}
		});
		jQuery('#av_country_form').submit(function() {
			var country = document.getElementById("country").value;
			var status = document.getElementById("status").value;
			if (country == '') {
				document.getElementById("c_error").innerHTML = 'Please Select Country';
				return false;
			}
			if (status == '') {
				document.getElementById("s_error").innerHTML = 'Please Enter State';
				return false;
			}
		})
		jQuery("input:radio[name=template]").click(function() {
			var value = jQuery(this).val();
			var image_name;
			if(value == 'template_2'){
                image_name = "template1.png";
            }else if(value == 'template_3'){
                image_name = "template2.png";
            }else if(value == 'template_4'){
                image_name = "template3.jpg";
            }else{
                image_name = "template.png";
            }
            var pluginUrl = '<?php echo plugin_dir_url(__DIR__); ?>' ;
            jQuery('#display_template').attr('src', pluginUrl+'admin/images/'+image_name);
		});
		const urlParams = new URLSearchParams(window.location.search);
		var page = urlParams.get('page');
		if(page == 'age-verification') {
			var checkedValue = document.querySelector('.form-check-input:checked').value;
			if(checkedValue == 'template_2'){
	            image_name = "template1.png";
	        }else if(checkedValue == 'template_3'){
	            image_name = "template2.png";
	        }else if(checkedValue == 'template_4'){
	            image_name = "template3.jpg";
	        }else{
	            image_name = "template.png";
	        }
        	var pluginUrl = '<?php echo plugin_dir_url(__DIR__); ?>' ;
        	jQuery('#display_template').attr('src', pluginUrl+'admin/images/'+image_name);
        }
	</script>
<?php
	}

	public function edit_country() {
		global $wpdb;
		$country_table = $wpdb->prefix."age_v_country";
		if(isset($_POST['action']) && $_POST['action'] == 'edit_country') {
			$id = sanitize_text_field($_POST['id']);
			$country = $wpdb->get_row("SELECT * FROM ".$country_table." where id= $id");
			$response='
				<form id="av_country_form" method="post" action="'. admin_url('admin.php').'?page=add-country">
					<div class="form-row align-items-center">
						<div class="col-4">
							<p id="c_error"></p>
							<label><strong>Name:</strong></label>
								<input type="text" id="name" name="country" class="form-control" placeholder="Enter Your Country" value="'.$country->name.'" required>
								<input type="hidden" id="c_id" name="c_id" value="'. $country->id.'">
						</div>
						<div class="col-4">
							<p id="c_error"></p>
							<label><strong>Minimum Age:</strong></label>
								<input type="text" id="minimum_age" name="age" class="form-control" placeholder="Enter Your Minimum Age" value="'.$country->minimum_age.'" required>
						</div>
						<div class="col-4">
							<p id="s_error"></p>
							<label><strong>Status:</strong></label>
							<select name="status" id="c_status" class="form-control">
								<option value="">Select Status</option>
								<option value="1"'. (($country->status == 1) ? 'selected' : '') . '>
									Active
								</option>
								<option value="0"'. (($country->status == 0) ? 'selected' : '') . '>
									Deactive
								</option>
							</select>
						</div>
						<div class="col-12">
							<input type="submit" name = "update" value = "Save Changes" class="btn btn-info btn-sm mt-1"">
						</div>
					</div>
			    </form>
			';
			//echo esc_html($response);
			wp_send_json(array('html'=>$response));
			exit();
		}
	}

	/**
	 * Enable / Disable Plugin
	 */
	public function plugin_status() {
		global $wpdb;
		$table = $wpdb->prefix."age_v_settings";
		if(isset($_POST['action']) && $_POST['action'] == 'plugin_status') {
			$id = sanitize_text_field($_POST['id']);
			$status = sanitize_text_field($_POST['status']);
			$wpdb->query( $wpdb->prepare( "UPDATE ".$table." SET status = %d WHERE ID = %d", $status, $id ) );
			if ($status == 0) {
				$msg = 'Plugin Disabled successfully';
			}else{
				$msg = 'Plugin Enabled successfully';
			}
			$settings = $wpdb->get_row("SELECT * FROM ".$table."");
			wp_send_json(array('msg'=>$msg,'status'=>$settings->status));
			exit();
		}
	}
}
