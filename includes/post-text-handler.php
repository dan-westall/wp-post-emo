<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class WP_Post_Emo_Post_Text_Handler {

    /**
     * @var WP_Post_Emo_Plugin
     */
    private $plugin;

    public function __construct( WP_Post_Emo_Plugin $plugin ) {

        $this->plugin = $plugin;


        add_action( 'wp_ajax_process_text', [ $this, 'process_text' ] );

        add_action( 'admin_enqueue_scripts',  [ $this, 'register_scripts' ], 10 , 0 );

        add_action( 'add_meta_boxes', [ $this, 'register_meta_box' ] );

    }

    public function register_scripts(){

        wp_register_script(
            'WP-Post-Emo', ( $this->plugin->plugin_url. 'assets/js/wp_post_emo.js'   ), array( 'jquery' ), date('U')
        );

    }

    public function process_text() {

        //check_ajax_referer( 'process_text', 'security' );

        if ( ! current_user_can( 'manage_options' ) ) {

            return;

        }

        $post = get_post( $_POST['post_id'] );


        try {

            //text
            $content = strip_tags( $post->post_content );

            $notes = $this->plugin->analysis->feed($content);

            $filename = $this->plugin->music->generate($notes);

            $this->plugin->midi->save_to_media_library( $_POST['post_id'], $filename);

        } catch (Exception $e){


            wp_send_json_error($e->getMessage());

        }

        wp_send_json_success('Bibgo');

    }

    public function register_meta_box(){

        global $post;

        add_meta_box(

            'analyze-post',

            __( 'Analyze Post',  'wp-post-emo' ),

            [ $this, 'text_handler_post_submit' ],

            'post',

            'side',

            'core'

        );

    }

    public function text_handler_post_submit( $post ) {

        wp_enqueue_script('WP-Post-Emo');

        require_once $this->plugin->plugin_path . '/views/post-analyze-meta.php';

    }

}


