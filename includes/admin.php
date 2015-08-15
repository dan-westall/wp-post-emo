<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class WP_Post_Emo_Admin {

    /**
     * @var WP_Post_Emo_Plugin
     */
    private $plugin;

    public function __construct( WP_Post_Emo_Plugin $plugin ) {

        $this->plugin = $plugin;

        add_action( 'admin_menu', [ $this, 'add_plugin_admin_menu' ] );

    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {


        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         * @TODO:
         *
         * - Change 'manage_options' to the capability you see fit
         *   For reference: http://codex.wordpress.org/Roles_and_Capabilities
         */


        add_menu_page(
            'WP Post Emo',
            __('WP Post Emo', $this->plugin->plugin_slug),
            'manage_options',
            $this->plugin->plugin_slug,
            [ $this, 'display_plugin_admin_page' ],
            'dashicons-networking');

        //add_submenu_page( 'my-top-level-handle', 'Page title', 'Sub-menu title', 'manage_options', 'my-submenu-handle', 'my_magic_function');
    //
    //        $this->plugin_screen_hook_suffix = add_options_page(
    //            __('WP Tournament Manager Settings', $this->plugin_slug),
    //            __('WP Tournament Manager', $this->plugin_slug),
    //            'manage_options',
    //            $this->plugin_slug,
    //            array($this, 'display_plugin_admin_page')
    //        );


    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_admin_page() {

        include_once $this->plugin->plugin_path . '/views/admin-options.php';

    }

}



