<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class WP_Post_Emo_Theme {

    private $plugin;

    /**
     * WP_Post_Emo_Process_Text constructor.
     */
    public function __construct( WP_Post_Emo_Plugin $plugin ) {

        $this->plugin = $plugin;

        add_filter( 'the_content', [ $this, 'display_midi'], 10 );


    }

    public function display_midi ( $content ) {

        global $post;

        if( $post->post_type != 'post' ) {

            return $content;

        }

        $mini_attachement_id = $this->plugin->midi->get_midi( $post->ID );

        if( $this->plugin->midi->has_midi($post->ID) ) {

//            $attachment = get_attached_media( $mini_attachement_id );

            $attachment = get_post ( $mini_attachement_id);


            $content .= sprintf(
                '<a href="%s" style="margin-top: 50px;">%s</a>',
                $attachment->guid,
                __('Download the post sound', 'wp-post-emo')
            );

        }

        return $content;

    }

}