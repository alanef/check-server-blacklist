<?php

/*
Plugin Name: Check Server Blacklist
Plugin URI: https://github.com/alanef/check-server-blacklist
Description: Simple shortcode to check some blacklist stuff as a shortcode [csb].
Version: 1.0
Author: alan
Author URI: https://fullworksplugins.com
License: GPL2
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

add_shortcode(
	'csb',
	function () {
		ob_start();
		if ( isset( $_SERVER['SERVER_ADDR'] ) ) {
			$ip = sanitize_text_field( $_SERVER['SERVER_ADDR'] );
			?>
            <p>Got IP from $_SERVER['SERVER_ADDR'] - IP value <?php echo esc_html( $ip ); ?></p>
			<?php
		} else {
			$ip = gethostbyname( $_SERVER['SERVER_NAME'] );
			?>
            <p>Got IP from $_SERVER['SERVER_NAME] - IP value <?php echo esc_html( $ip ); ?> - Server
                name: <?php echo esc_html( $_SERVER['SERVER_NAME'] ); ?> ?></p>
			<?php
		}
		if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			?>
            <p>FILTER_FLAG_IPV4 IP appears to be an IPv4</p>
			<?php
			$ip4 = true;
		} else {
			?>
            <p>FILTER_FLAG_IPV4 IP appears to be an IPv6</p>
			<?php
			$ip4 = false;
		}
		if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 ) ) {
			?>
            <p> FILTER_FLAG_IPV6 IP appears to be an IPv6</p>
			<?php
			$ip6 = true;
		} else {
			?>
            <p>FILTER_FLAG_IPV6 IP appears to be an IPv4</p>
			<?php
			$ip6 = false;
		}
		$google = gethostbyname( 'google.com' );
		if ( $google === false ) {
			?>
            <p>gethostbyname() returned badly</p>
			<?php
		} elseif ( $google !== 'google.com' ) {
			?>
            <p>gethostbyname() seems to work OK</p>
			<?php
		} elseif ( $google === 'google.com' ) {
			?>
            <p>gethostbyname() couldnt even find google.com something is wrong with the server</p>
			<?php
		} else {
			?>
            <p>gethostbyname() unexpected condition on google.com returning <?php echo esc_html( $google ); ?></p>
			<?php
		}
		if ( $ip4 ) {
			?>
            <p>IPv4 so checking blacklist</p>
			<?php
			$rbl           = 'zen.spamhaus.org';
			$rev           = array_reverse( explode( '.', $ip ) );
			$lookup        = implode( '.', $rev ) . '.' . $rbl;
			$lookup_result = gethostbyname( $lookup );
			if ( $lookup_result === false ) {
				?>
                <p>gethostbyname() returned badly in blacklist check of <?php echo esc_html( $lookup ); ?></p>
				<?php
			} elseif ( $lookup_result !== $lookup ) {
				?>
                <p>gethostbyname() returned <?php echo esc_html( $lookup_result ); ?> in blacklist check
                    of <?php echo esc_html( $lookup ); ?> - this means that Spamhaus ZEN has <strong>listed this IP in a
                        Blacklist</strong></p>
				<?php
			} elseif ( $lookup_result === $lookup ) {
				?>
                <p>gethostbyname() returned <?php echo esc_html( $lookup_result ); ?> in blacklist check
                    of <?php echo esc_html( $lookup ); ?> - this means that Spamhaus ZEN has <strong>NOT listed this IP in a
                        Blacklist</strong></p>
				<?php
			} else {
				?>
                <p>gethostbyname() unexpected condition on <?php echo esc_html( $lookup_result ); ?>
                    returning <?php echo esc_html( $lookup_result ); ?></p>
				<?php
			}
			?>
            <p>(note the IP is reversed for the Spamhuas look up - that is what is needed)</p>
			<?php
		} else {
			?>
            <p>IPv4 so checking blacklist</p>
			<?php
		}

		return ob_get_clean();
	}
);