<?php
/**
 * Plugin Name:     Event Tickets Plus Extension: Facebook for WooCommerce Integration
 * Description:     Ensures new ticket types are passed to the Facebook for WooCommerce plugin so that they can be registered in the linked Facebook shop.
 * Version:         0.1.0
 * Author:          Modern Tribe, Inc.
 * Author URI:      http://m.tri.be/1971
 * License:         GPL version 3 or any later version
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:     event-tickets-plus-faacebook-woocommerce-integration
 *
 *     This plugin is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     any later version.
 *
 *     This plugin is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *     GNU General Public License for more details.
 */

add_action( 'event_tickets_after_save_ticket', function( $ticket_id, $product_id ) {
	$wc_facebook = null;

	// Safety check in case WooCommerce is removed/disabled at any point
	if ( ! function_exists( 'wc' ) ) {
		return;
	}

	// Search for and fetch the Facebook integration
	foreach ( wc()->integrations->get_integrations() as $integration ) {
		if ( is_a( $integration, 'WC_Facebookcommerce_Integration' ) ) {
			$wc_facebook = $integration;
			break;
		}
	}

	// Bail if the integration isn't currently active
	if ( empty( $wc_facebook ) ) {
		return;
	}

	/** @var $wc_facebook WC_Facebookcommerce_Integration */
	$wc_facebook->on_product_publish( $product_id );
}, 10, 2 );