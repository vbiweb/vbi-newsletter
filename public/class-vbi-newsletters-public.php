<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://visualbi.com
 * @since      1.0.0
 *
 * @package    Vbi_Newsletters
 * @subpackage Vbi_Newsletters/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Vbi_Newsletters
 * @subpackage Vbi_Newsletters/public
 * @author     Visualbi <website@visualbi.com>
 */
class Vbi_Newsletters_Public {



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
		 * defined in Vbi_Newsletters_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vbi_Newsletters_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
// 
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vbi-newsletters-public.css', array(), $this->version, 'all' );

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
		 * defined in Vbi_Newsletters_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vbi_Newsletters_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name.'-blockUI','//malsup.github.io/jquery.blockUI.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-validate', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vbi-newsletters-public.js',  array( $this->plugin_name.'-blockUI',$this->plugin_name.'-validate','jquery' ), $this->version, false );
			wp_localize_script($this->plugin_name, 'newsletters_vars', array(
				'_newsletters_ajax_url' => esc_url( admin_url( 'admin-ajax.php' ) ),
			));

	}


	public function add_widget_shortcode()
	{
		add_shortcode( 'welcome' , array( $this , 'welcome_callback' ) );
		add_shortcode( 'vbi-newsletters',array($this, 'newsletters_callback') );
	}

	public function welcome_callback()
	{
		return 'VBI  Newsletter Plugin - Welcome';
	}

	public function newsletters_callback($atts)
	{
		$atts = shortcode_atts(
			array(
				'title' => '',
				'type' => 'shortcode',
			) , 
			$atts , 
			'vbi-newsletters' 
		);
		$title = $atts['title'];
		$type = $atts['type'];
		ob_start();
		?>
		<div id="newsletter_registration_form_container">
	            <form action="" id="<?php echo $type; ?>_newsletter_reg" method="post" class="clearfix hubspot_forms newsletter_reg" >
	            	<input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
	                <input id="<?php echo $type; ?>_pagename" name="pagename" value="<?php global $post; echo $post->post_title; ?>" type="hidden" />
	                <input id="<?php echo $type; ?>_pageurl" name="pageurl" value="<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" type="hidden" />
	                <input id="<?php echo $type; ?>_hubutk" name="hubutk" value="<?php echo $_COOKIE['hubspotutk']; ?>" type="hidden" />
	                <input id="<?php echo $type; ?>_ipaddr" name="ipaddr" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" type="hidden" />

	                <h3 style="font-size:14px;" class="clearfix hubspot_forms_fields"><?php echo $title ?></h3>
	                <p class="clearfix hubspot_forms_fields">
	                    <input id="<?php echo $type; ?>_email" name="email" required="" aria-required="true"  placeholder="Email" type="text" value="<?php echo $business_email; ?>" />
	                </p>

	                <p class="message"></p>
	                <p class="clearfix hubspot_forms_fields">
	                    <input id="<?php echo $type; ?>_submit" name="<?php echo $type; ?>_submit" value="Submit" type="submit">
	                </p>
	            </form>
		 </div>
		<?php
		$output = ob_get_clean();
		return $output;
	}

		public function newsletters_submission()
		{
		
			$email 						= $_POST['email'];
			
			$page_url 					= $_POST['pageurl'];
			$page_name 					= $_POST['pagename'];
			$hubspotutk      			= $_POST['hubspotutk'];
			$ip_addr         			= $_POST['ipaddr'];

			$hs_context = array(
				'hutk' 		=> $hubspotutk,
				'ipAddress' => $ip_addr,
				'pageUrl' 	=> $page_url,
				'pageName' 	=> $page_name
			);

			$hs_context_json = json_encode($hs_context);

			$str_post = "&email=" . urlencode($email) 
			. "&hs_context=" . urlencode($hs_context_json);

			$endpoint = 'https://forms.hubspot.com/uploads/form/v2/5932932/2abe07bf-4abc-4e54-b4da-ad8d118c365b';

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $str_post);
			curl_setopt($ch, CURLOPT_URL, $endpoint);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/x-www-form-urlencoded' ));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response    = curl_exec($ch); 
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
			
			curl_close($ch);

			$message = array();

			$message['hubspot'] = $status_code;

			if($status_code != 204){
				wp_send_json($message);
			}

			// $endpoint = 'http://api.visualbi.com/gotowebinar/register/';

			// $str_post = "&email=" . urlencode($email) 
			// . "&hs_context=" . urlencode($hs_context_json);


			// $ch = curl_init();
			// curl_setopt($ch, CURLOPT_POST, true);
			// curl_setopt($ch, CURLOPT_POSTFIELDS, $str_post);
			// curl_setopt($ch, CURLOPT_URL, $endpoint);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

			// $response    = curl_exec($ch); 
			// $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
			
			// curl_close($ch);

			// $message['gotowebinar'] = $status_code;

		    wp_send_json($message);		

		}

	
}
