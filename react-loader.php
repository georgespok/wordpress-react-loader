<?php
/**
 * Plugin Name: React Loader Shortcode
 * Description: Shortcode to embed a React application on any page, theme-agnostic. Supports multiple CSS and JS assets.
 * Version:     1.8.0
 * Author:      George P
 * License:     GPLv2+
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Allow <script> tags with src/defer in post content so our inline tags aren’t stripped by KSES
 */
add_filter( 'wp_kses_allowed_html', function( $allowed, $context ) {
    if ( 'post' === $context ) {
        $allowed['script'] = array(
            'src'   => true,
            'type'  => true,
            'defer' => true,
        );
    }
    return $allowed;
}, 10, 2 );

/**
 * Shortcode: [reactloader base_url="..." js="f1.js,f2.js" css="a.css,b.css" id="root"]
 * Outputs a mount-point <div> and inline <link> and <script> tags.
 */
function rl_shortcode_handler( $atts ) {
    // normalize attribute keys to lowercase
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );

    // Determine base URL
    $base_url = ! empty( $atts['base_url'] )
        ? rtrim( $atts['base_url'], '/' )
        : rtrim( plugin_dir_url( __FILE__ ), '/' ) . '/assets';

    // Figure out mount-point ID
    if ( ! empty( $atts['mount_id'] ) ) {
        $mount_id = $atts['mount_id'];
    } elseif ( ! empty( $atts['id'] ) ) {
        $mount_id = $atts['id'];
    } else {
        $mount_id = 'root';
    }

    $output = '';

    // Handle CSS files (comma-separated)
    if ( ! empty( $atts['css'] ) ) {
        $css_files = array_map( 'trim', explode( ',', $atts['css'] ) );
        foreach ( $css_files as $css_file ) {
            if ( $css_file ) {
                $css_url   = esc_url( "{$base_url}/{$css_file}" );
                $output   .= "<link rel=\"stylesheet\" href=\"{$css_url}\" media=\"all\" />\n";
            }
        }
    }

    // Mount-point div
    $output .= sprintf( "<div id=\"%s\"></div>\n", esc_attr( $mount_id ) );

    // Handle JS files (comma-separated)
    if ( ! empty( $atts['js'] ) ) {
        $js_files = array_map( 'trim', explode( ',', $atts['js'] ) );
        foreach ( $js_files as $js_file ) {
            if ( $js_file ) {
                $js_url    = esc_url( "{$base_url}/{$js_file}" );
                $output   .= "<script src=\"{$js_url}\" defer></script>\n";
            }
        }
    }

    return $output;
}
add_shortcode( 'reactloader', 'rl_shortcode_handler' );