<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/wpboss/
 * @since      1.0.0
 *
 * @package    Extra_Checkout_Fee
 * @subpackage Extra_Checkout_Fee/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Extra_Checkout_Fee
 * @subpackage Extra_Checkout_Fee/admin
 * @author     Aslam Shekh <aslamdxbca@gmail.com>
 */
class Extra_Checkout_Fee_Admin {

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
     *
     * Callback function of add section filter
     * @param $sections
     * @return mixed
     */
	public function extra_checkout_fee_setting_tab($sections){
        $sections['extra_checkout_fee'] = __( 'Checkout Fee', 'extra-checkout-fee' );
        return $sections;
    }

    /**
     *
     * Callback function of section setting page
     * @param $settings
     * @param $current_section
     * @return array
     */
    public function extra_checkout_fee_setting_page( $settings, $current_section ) {

        /**
         * Get all payment gateway ids
         **/
        $available_gateways = WC()->payment_gateways->get_payment_gateway_ids();

        if (in_array($current_section, $available_gateways) || $current_section === 'extra_checkout_fee') {

            $extraCheckoutFeeSettings = array();
            $extraCheckoutFeeMode = $current_section === 'extra_checkout_fee' ? 'extra_checkout_fee_on' : $current_section.'_extra_checkout_fee_on';
            $extraCheckoutAmount = $current_section === 'extra_checkout_fee' ? 'extra_checkout_amount' : $current_section.'_extra_checkout_amount';
            $extraCheckoutType = $current_section === 'extra_checkout_fee' ? 'extra_checkout_type' : $current_section.'_extra_checkout_type';
            $extraCheckoutFeeLabel = $current_section === 'extra_checkout_fee' ? 'extra_checkout_fee_label' : $current_section.'_extra_checkout_fee_label';

            $extraCheckoutFeeSettings[] = array(
                'name' => __( 'Extra Checkout Fee Settings', 'extra-checkout-fee' ),
                'type' => 'title', 
                'desc' => __( 'The following options are used to configure Extra Checkout Fee', 'extra-checkout-fee' ),
                'id' => 'extra_checkout_fee_title'
            );

            $extraCheckoutFeeSettings[] = array(
                'name'     => __( 'Enabled', 'extra-checkout-fee' ),
                'id'       => $extraCheckoutFeeMode,
                'type'     => 'checkbox',
                'css'      => 'min-width:300px;',
            );

            $extraCheckoutFeeSettings[] = array(
                'name'     => __( 'Fee Label', 'extra-checkout-fee' ),
                'id'       => $extraCheckoutFeeLabel,
                'required'    => true,
                'type'     => 'text',
            );

            $extraCheckoutFeeSettings[] = array(
                'name'     => __( 'Checkout Fee', 'extra-checkout-fee' ),
                'id'       => $extraCheckoutAmount,
                'required'    => true,
                'type'     => 'number',
            );

            $extraCheckoutFeeSettings[] = array(
                'name'     => __( 'Fee Type', 'extra-checkout-fee' ),
                'id'       => $extraCheckoutType,
                'type'    => 'select',
                'options' => array(
                    'flat'   => __( 'Flat', 'extra-checkout-fee' ),
                    'percentage'   => __( 'Percentage (%)', 'extra-checkout-fee' ),
                )
            );

            $extraCheckoutFeeSettings[] = array( 'type' => 'sectionend', 'id' => 'extra_checkout_fee' );

            return $extraCheckoutFeeSettings;
        } else {
            return $settings;
        }
    }
}
