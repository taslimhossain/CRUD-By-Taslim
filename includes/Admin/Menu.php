<?php

namespace CRUDBT\Admin;

/**
 * Menu class.
 *
 * Add Menu in admin panel.
 * 
 * @class Menu
 */
class Menu {

    public $list_item;

    /**
     * Initialize the class
     */
    function __construct( $list_item ) {
        $this->list_item = $list_item;

        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() {
        $parent_slug = 'crudbt';
        $capability = 'manage_options';

        $hook = add_menu_page( __( 'CRUD Items', 'crud-by-taslim' ), __( 'CRUD Items', 'crud-by-taslim' ), $capability, $parent_slug, [ $this->list_item, 'plugin_page' ], 'dashicons-database', 10 );

        add_action( 'admin_head-' . $hook, [ $this, 'enqueue_assets' ] );
    }


    /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueue_assets() {
        wp_enqueue_style( 'crudbt-admin-style');
        wp_enqueue_script( 'crudbt-admin' );
    }
}
