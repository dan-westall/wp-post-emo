<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class WP_Post_Emo_Mini_Handler {

    private $plugin;

    /**
     * WP_Post_Emo_Process_Text constructor.
     */
    public function __construct( WP_Post_Emo_Plugin $plugin ) {

        $this->plugin = $plugin;


    }


}