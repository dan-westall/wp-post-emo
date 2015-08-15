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

    public function save_to_media_library( $post_id, $document_name ) {

        global $wp_filesystem;

        require_once( ABSPATH . 'wp-admin/includes/image.php');

        $wp_upload_dir = wp_upload_dir();

        //$wp_upload_dir['path'] .'/'.$document_name set as

        $wp_filetype = wp_check_filetype (basename( $document_name ), null );

        $attachment = array(
            'guid' => $wp_upload_dir['url'] . '/' . basename( $document_name ),
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($document_name)),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $document_name );
        // you must first include the image.php file
        // for the function wp_generate_attachment_metadata() to work

        $attach_data = wp_generate_attachment_metadata( $attach_id, $wp_upload_dir['path'].'/'.$document_name );

        wp_update_attachment_metadata( $attach_id, $attach_data );

    }




}

