<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.webriderz.com/
 * @since      1.0.0
 *
 * @package    Age_Verification
 * @subpackage Age_Verification/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Age_Verification
 * @subpackage Age_Verification/public
 * @author     Webriderz <info@webriderz.com>
 */
class Age_Verification_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/age-verification-public.css', array(), $this->version, 'all' );
		//wp_enqueue_style( $this->plugin_name.'-bootstrap', plugin_dir_url( __FILE__ ).'css/bootstrap.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/age-verification-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name."-ajax-test", plugin_dir_url( __FILE__ ) . 'js/ajax-test.js', array( 'jquery' ) );
		wp_localize_script( $this->plugin_name."-ajax-test", 'ajax_url', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}

	/**
	 * Load View
	 */
	public function age_verification_view(){
		$this->display_plugin_publicly();	
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_publicly() {
		global $wpdb;
		$country = $wpdb->prefix."age_v_country";
		$settings = $wpdb->prefix."age_v_settings";
		$countries = $wpdb->get_results("SELECT * FROM ".$country." where status = 1");
		$setting = $wpdb->get_row("SELECT * FROM ".$settings." where status = 1");
		if (!empty($setting)){
			if (isset($setting) && $setting->template == 'template_2') {
				include_once( 'partials/age-verification-public-display-one.php' );
			}else if (isset($setting) &&  $setting->template == 'template_3') {
				include_once( 'partials/age-verification-public-display-two.php' );
			}else if (isset($setting) &&  $setting->template == 'template_4') {
				include_once( 'partials/age-verification-public-display-template.php' );
			}else {
				include_once( 'partials/age-verification-public-display.php' );
			}
		}
	}

	public function get_age_state() {
		global $wpdb;
		$table = $wpdb->prefix."age_v_country";
		if(isset($_POST['action']) && $_POST['action'] == 'get_state') {
			$country_id = sanitize_text_field($_POST['id']);
			$country = $wpdb->get_row("SELECT * FROM ".$table." where id=$country_id");
			$response['type'] = "success";
			$response['name'] = $country->name;
			$response['age'] = $country->minimum_age;
			wp_send_json($response);
			exit;
		}
	}
}
