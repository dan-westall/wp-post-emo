<?php

/*
Plugin Name: WP Post Emo
Plugin URI:
Description: This generates a midi based on post length and tone.
Author:  Andrew Deniszczyc, Daniel Westall
Version: 0.1
Author URI:
*/

require_once __DIR__ . '/includes/autoloader.php';

// Register the autoloader.
WP_Post_Emo_Autoloader::register( 'WP_Post_Emo', trailingslashit( plugin_dir_path( __FILE__ ) ) . '/includes/' );

// Runs this plugin.
$GLOBALS['wp_Post_Emo'] = new WP_Post_Emo_Plugin();
$GLOBALS['wp_Post_Emo']->run( __FILE__ );
