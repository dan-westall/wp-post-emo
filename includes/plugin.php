<?php
/**
 * This is the plugin class and acts as container for component instances and
 * basic properties of a plugin. Using container like this will avoid polluting
 * global namespaces. There's no global constants and only one global object
 * defined, that's this class' instance.
 */
class WP_Post_Emo_Plugin {

    /**
     * @var array
     */
    private $items = array();

    /**
     * @param string $path Path to main plugin file
     */
    public function run( $path ) {
        // Basic plugin information.
        $this->name    = 'wp_post_emo'; // This maybe used to prefix options, slug of menu or page, and filters/actions.
        $this->version = '0.1.0';

        // Path.
        $this->plugin_path   = trailingslashit(plugin_dir_path($path));
        $this->plugin_url    = trailingslashit(plugin_dir_url($path));
        $this->includes_path = $this->plugin_path . trailingslashit('includes');

        // Instances.
        $this->handler  = new WP_Post_Emo_Post_Text_Handler( $this );
        $this->process  = new WP_Post_Emo_Process_Text( $this );
        $this->midi     = new WP_Post_Emo_Mini_Handler( $this );
        $this->theme     = new WP_Post_Emo_Theme( $this );

        $this->music  = new WP_Post_Emo_Music( $this );
        $this->analysis  = new WP_Post_Emo_Analysis( $this );

    }

    public function __set( $key, $value ) {
        $this->items[ $key ] = $value;
    }

    public function __get( $key ) {
        if ( isset( $this->items[ $key ] ) ) {
            return $this->items[ $key ];
        }

        return null;
    }

    public function __isset( $key ) {
        return isset( $this->items[ $key ] );
    }

    public function __unset( $key ) {
        if ( isset( $this->items[ $key ] ) ) {
            unset( $this->items[ $key ], $this->raws[ $key ], $this->frozen[ $key ] );
        }
    }
}
