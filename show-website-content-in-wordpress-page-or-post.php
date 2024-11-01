<?php
/*
Plugin Name: Show Website Content in Page or Post
Description: Fetches the content of another webpage or URL to display inside the current post or page.
Version: 2024.07.23
Author: Matteo Enna
Author URI: https://matteoenna.it/it/wordpress-work/
Text Domain: show-website-ciwpop
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include __DIR__ . '/lib/horshipsrectors_elementor_function.php';

class horshipsrectors_website_byshortcode {
	
	public function __construct()
	{
		add_shortcode( 'horshipsrectors_get_html' , array($this, 'horshipsrectors_get_html' ));
		add_shortcode( 'horshipsrectors_get_html_get' , array($this, 'horshipsrectors_get_html' ));
		add_shortcode( 'horshipsrectors_get_html_curl' , array($this, 'horshipsrectors_get_html_curl' ));

		add_action('elementor/widgets/widgets_registered', 'show_website_content_in_wordpress_page_or_post_elementor_block');
	}

	public function horshipsrectors_get_html( $settings ) {

		$html = $this->horshipsrectors_get_html_get( $settings );
	
		if ( empty( $html ) )
			$html = $this->horshipsrectors_get_html_curl( $settings );
	
		return $html;
	
	}

	public function horshipsrectors_get_html_get( $settings ) {
		$response = wp_safe_remote_get( esc_url_raw($settings[0]) );
		$html = wp_remote_retrieve_body( $response );

		if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
			$sanitized_html = $this->remove_unwanted_scripts( $html );

			return $sanitized_html;
		}

		return '';
	}

	private function remove_unwanted_scripts( $html ) {
		$html = preg_replace( '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/', '', $html );
	
		$html = preg_replace( '/\s*on\w+="[^"]*"/i', '', $html );
	
		$dom = new DOMDocument();
		libxml_use_internal_errors( true );

		$allowed_tags = array(
			'p' => array(),
			'a' => array(
				'href' => array(),
				'title' => array(),
				'target' => array()
			),
			'strong' => array(),
			'em' => array(),
			'br' => array(),
			'span' => array(
				'style' => array() 
			),
			'ul' => array(),
			'ol' => array(),
			'li' => array(),
			'cite' => array(),
			'code' => array(),
			'pre' => array(),
			'h1' => array(),
			'h2' => array(),
			'h3' => array(),
			'h4' => array(),
			'h5' => array(),
			'h6' => array(),
			'img' => array(
				'src' => array(),
				'alt' => array(),
				'title' => array(),
				'width' => array(),
				'height' => array()
			),
			'style' => array()
		);

		$html = wp_kses($html,$allowed_tags);
		$dom->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8' ) );
		libxml_clear_errors();
	
		return $dom->saveHTML();
	}
	
	
	public function horshipsrectors_get_html_curl( $settings ) {
		if ( is_array( $settings ) && isset( $settings[0] ) ) {
			$url = esc_url_raw($settings[0]);
			
			$args = array(
				'timeout' => 30,
				'user-agent' => sprintf( "Mozilla/%d.0", wp_rand( 4, 5 ) ),
				'sslverify' => false,
			);
			
			$response = wp_safe_remote_get( $url, $args );
	
			if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
				$html = wp_remote_retrieve_body( $response );
				$sanitized_html = $this->remove_unwanted_scripts( $html );

				return $sanitized_html;
			}
		}
	
		return ''; 
	}
	
}

$short = new horshipsrectors_website_byshortcode();
