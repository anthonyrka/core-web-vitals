<?php
/**
 * @package  CoreWebVitals
 */
/*
Plugin Name: Inca Bean
Plugin URI: https://github.com/anthonyrka/core-web-vitals
Description: Tracks and reports, in the admin bar, core web vitals as you develop your wordpress site
Version: 0.0.1
Author: Ryan Kirkish
Author URI: http://ryankirkish.com
License: GPLv2 or later
Text Domain: core-web-vitals-plugin
*/

defined( 'ABSPATH' ) or die( 'buh bye now' );

class CoreWebVitals {

    function __construct() {
        add_action( 'init', array( $this, 'custom_post_type' ) );
    }

    function register() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ));
        add_action( 'admin_bar_menu', array( $this, 'lcp_toolbar_item' ) , 999);
    }

    function lcp_toolbar_item( $wp_admin_bar ) {
        $args = array(
            'id'    => 'lcp_toolbar_item',
            'title' => 'LCP:',
        );
        $wp_admin_bar->add_node( $args );

        $args = array(
            'id'    => 'lcp_toolbar_item_score',
            'title' => '1.2s',
        );
        $wp_admin_bar->add_node( $args );
    }

    function activate() {
        // generated a CPT
        $this->custom_post_type();
        // flush write rules
        flush_rewrite_rules();
    }

    function deactivate() {
        // flush rewrite rules
        flush_rewrite_rules();
    }

    function uninstall() {
        // delete CPT
        // delete all the plugin data from the DB
    }

	function custom_post_type() {
		register_post_type( 'Vitals', array( 'public' => true, 'label' => 'Vitals' ) );
    }

    function enqueue() {
        // enqueue all of our scripts
        wp_enqueue_script( 'vitalspluginscript', plugins_url( '/assets/perf-observer.js', __FILE__ ) );
    }
}

if ( class_exists( 'CoreWebVitals' ) ) {
    $vitalBean = new CoreWebVitals();
    $vitalBean->register();

}

// activation
register_activation_hook( __FILE__, array( $vitalBean, 'activate' ) );

// deactivation
register_deactivation_hook( __FILE__, array( $vitalBean, 'deactivate' ) );

// uninstall
