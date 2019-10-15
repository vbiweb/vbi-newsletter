<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://visualbi.com
 * @since      1.0.0
 *
 * @package    Vbi_Newsletters
 * @subpackage Vbi_Newsletters/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Vbi_Newsletters
 * @subpackage Vbi_Newsletters/includes
 * @author     Visualbi <website@visualbi.com>
 */
class Vbi_Newsletters_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'vbi-newsletters',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
