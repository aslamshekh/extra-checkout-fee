<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/wpboss/
 * @since      1.0.0
 *
 * @package    Extra_Checkout_Fee
 * @subpackage Extra_Checkout_Fee/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Extra_Checkout_Fee
 * @subpackage Extra_Checkout_Fee/includes
 * @author     Aslam Shekh <aslamdxbca@gmail.com>
 */
class Extra_Checkout_Fee_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'extra-checkout-fee',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
