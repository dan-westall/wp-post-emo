<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class WP_Post_Emo_Process_Text {

    private $plugin;

    public static $tempo = 0.06;

    public static $tone_index = [
        '-1',
        '-2',
        '-3',
        '-4',
        '-5',
        '-6',
        '-7',
    ];


    /**
     * WP_Post_Emo_Process_Text constructor.
     */
    public function __construct( WP_Post_Emo_Plugin $plugin ) {

        $this->plugin = $plugin;


    }

    




}