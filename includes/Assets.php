<?php

namespace CRUDBT;

/**
 * Assets class.
 *
 * Add css for crud_data shortcode.
 * 
 * @class Assets
 */
class Assets {

    /**
	 *  __construct
     * 
     * @return void
     */
    function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'register_assets' ) );
    }

    /**
     * Register scripts and styles
     *
     * @since 1.0.0
     * @return void
     */
    public function register_assets() {
        // add crudbt-style for forntend shortcode style
        wp_register_style( 'crudbt-style', CRUDBT_ASSETS . '/css/crudbt-style.css', array(), CRUDBT_VERSION, 'all' );
       
        // admin CRUD list style js code for ajax
        wp_register_style( 'crudbt-admin-style', CRUDBT_ASSETS . '/css/crudbt-admin-style.css', array(), CRUDBT_VERSION, 'all' );
        wp_register_script( 'crudbt-admin', CRUDBT_ASSETS . '/js/crudbt-admin-script.js', array('jquery', 'wp-util'), CRUDBT_VERSION, true );

        wp_localize_script( 'crudbt-admin', 'crudbt', [
            'nonce' => wp_create_nonce( 'crudbt-delete-item' ),
            'confirm' => __( 'Are you sure?', 'crud-by-taslim' ),
            'error' => __( 'Sorry something wrong, please wait few minutes and try again', 'crud-by-taslim' ),
        ] );
    }
}