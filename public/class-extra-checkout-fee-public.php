<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/wpboss/
 * @since      1.0.0
 *
 * @package    Extra_Checkout_Fee
 * @subpackage Extra_Checkout_Fee/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Extra_Checkout_Fee
 * @subpackage Extra_Checkout_Fee/public
 * @author     Aslam Shekh <aslamdxbca@gmail.com>
 */
class Extra_Checkout_Fee_Public {

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
     * Function to show checkout extra fee.
     */
    public function extra_checkout_fee_checkout_page() {

        $chosenGateway = WC()->session->get( 'chosen_payment_method' );

        $extraFeeEnabledKey = $chosenGateway.'_extra_checkout_fee_on';
        $extraCheckoutFeeMode = get_option( $extraFeeEnabledKey );

        if(isset($extraCheckoutFeeMode) && !empty($extraCheckoutFeeMode)){
            $extraFeeKey = $chosenGateway.'_extra_checkout_amount';
            $extraFeeTypeKey = $chosenGateway.'_extra_checkout_type';
            $extraFeeLabel = $chosenGateway.'_extra_checkout_fee_label';
        } else {
            $extraFeeEnabledKey = 'extra_checkout_fee_on';
            $extraFeeKey = 'extra_checkout_amount';
            $extraFeeTypeKey = 'extra_checkout_type';
            $extraFeeLabel = 'extra_checkout_fee_label';
            $extraCheckoutFeeMode = get_option( $extraFeeEnabledKey );
        }

        $extraFee = get_option( $extraFeeKey );
        $extraFee = isset($extraFee) && !empty($extraFee) ? $extraFee : 0;

        if(isset($extraCheckoutFeeMode) && !empty($extraCheckoutFeeMode) && 'yes' === $extraCheckoutFeeMode && !empty($extraFee)){

            $extraFeeTypeValue = get_option( $extraFeeTypeKey );
            $extraFeeTypeValue = isset($extraFeeTypeValue) && !empty($extraFeeTypeValue) ? $extraFeeTypeValue : 0;

            $extraFeeLabelValue = get_option( $extraFeeLabel );
            $extraFeeLabelValue = isset($extraFeeLabelValue) && !empty($extraFeeLabelValue) ? $extraFeeLabelValue : "Fee: ";

            if('flat' === $extraFeeTypeValue){
                $extraAmount = floatval($extraFee);
            } else {
                global $woocommerce;
                $extraAmount = $woocommerce->cart->cart_contents_total * $extraFee;
                $extraAmount = $extraAmount / 100;
                $extraAmount = number_format_i18n($extraAmount, 2);
            }

            WC()->cart->add_fee( $extraFeeLabelValue, $extraAmount );
        }
    }

    /**
     * Referesh the checkout page when payment method will be change.
     */
    function extra_checkout_fee__refresh_checkout_on_payment_methods_change(){
        ?>
        <script type="text/javascript">
            (function($){
                $( 'form.checkout' ).on( 'change', 'input[name^="payment_method"]', function() {
                    $('body').trigger('update_checkout');
                });
            })(jQuery);
        </script>
        <?php
    }

}
