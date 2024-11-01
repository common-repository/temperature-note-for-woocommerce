<?php
/*
Plugin Name: CMEBOSS Temperature Note for WooCommerce
Plugin URI: https://magiccloud.i234.me/
Description: Automatically detects if an order contains products that require temperature control during shipping.
Version: 1.0.0
Author: HaroldChen
Author URI: https://magiccloud.i234.me
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: woo-temp-note
Domain Path: /languages/
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('woocommerce_checkout_create_order', 'add_temperature_meta', 10, 2);

function add_temperature_meta($order, $data)
{
    $items = $order->get_items();
    $has_cold_product = false;

    foreach ($items as $item) {
        $product_id = $item->get_product_id();
        $is_cold_product = get_post_meta($product_id, 'is_cold_product', true);

        if ($is_cold_product) {
            $has_cold_product = true;
            break;
        }
    }

    $additional_temp = $has_cold_product ? 'cold' : 'temp';
    $order->update_meta_data('additional_temp', $additional_temp);
}