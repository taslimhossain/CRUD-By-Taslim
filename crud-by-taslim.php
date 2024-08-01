<?php 
/*
 * Plugin Name: CRUD By Taslim
 * Plugin URI:  http://taslimhossain.com/plugins/crud-by-taslim/
 * Description: CRUD By Taslim is a plugin that makes it easy to achieve CRUD operations on custom tables. This plugin allows you to easily display CRUD item. <strong>[crud_data]</strong>.
 * Version:     1.0.0
 * Author:      taslim
 * Author URI:  https://taslimhossain.com/
 * Text Domain: crud-by-taslim
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * CRUD by taslim main class.
 */
final class CrudByTaslim {
    
    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0';

    /**
	 *  __construct
     * 
     * Sets up all the appropriate hooks and actions within our plugin.
     * 
     * @since 1.0.0
	 * @return void
     */
    private function __construct() {

        // Define constant.
        $this->define_constants();

        // Create database table if not exit.
        register_activation_hook( __FILE__, array( $this, 'activate' ) );

        // initialize the plugin
        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
    }

    /**
     * Initializes a singleton instance
     *
     * @since 1.0.0
     * @return \CrudByTaslim
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
	 * @since 1.0.0
	 * @return void
     */
    public function define_constants() {

        if ( ! defined( 'CRUDBT_VERSION' ) ) {
            define( 'CRUDBT_VERSION', self::version );
        }
        
        if ( ! defined( 'CRUDBT_FILE' ) ) {
            define( 'CRUDBT_FILE', __FILE__ );
        }
        
        if ( ! defined( 'CRUDBT_PATH' ) ) {
            define( 'CRUDBT_PATH', __DIR__ );
        }
        
        if ( ! defined( 'CRUDBT_URL' ) ) {
            define( 'CRUDBT_URL', plugins_url( '', CRUDBT_FILE ) );
        }

        if ( ! defined( 'CRUDBT_ASSETS' ) ) {
            define( 'CRUDBT_ASSETS', CRUDBT_URL . '/assets' );
        }
    }

    /**
     * Initialize the plugin
     *
     * @since 1.0.0
     * @return void
     */
    public function init_plugin() {

        // Enqueue scripts.
        new CRUDBT\Assets();
        
        // Ajax codes
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new CRUDBT\Ajax();
        }

        // Check if it's admin.
        if ( is_admin() ) {
            new CRUDBT\Admin();
        } else {
            new CRUDBT\Frontend();
        }
    }


    /**
     * Crete database table and do other stuff upon plugin activation.
     *
     * @since 1.0.0
     * @return void
     */
    public function activate() {
        $installer = new CRUDBT\Installer();
        $installer->create_tables();
    }

}

/**
 * Initialize CRUD by taslim.
 *
 * @since 1.0.0
 * @return object
 */
if ( ! function_exists( 'crudbt_crud_by_taslim' ) ) {
    function crudbt_crud_by_taslim() {
        return CrudByTaslim::init();
    }
}

// Run the plugin.
crudbt_crud_by_taslim();