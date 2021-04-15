<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package  CoreWebVitals 
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Clear Database stored data
$vitals = get_posts( array( 'post_type' => 'vitals', 'numberposts' => -1 ) );

foreach( $vitals as $vital ) {
	wp_delete_post( $vital->ID, true );
}

// Access the database via SQL
global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'vitals'" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );
