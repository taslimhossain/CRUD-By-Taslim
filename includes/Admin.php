<?php

namespace CRUDBT;

/**
 * Admin class.
 *
 * Create Menu and form in admin panel.
 * 
 * @class Admin
 */
class Admin {

    /**
     * Initialize the class
     */
    function __construct() {
        $curd_items = new Admin\CrudItem();

        $this->dispatch_actions( $curd_items );

         new Admin\Menu( $curd_items );
    }

    /**
     * Dispatch and bind actions
     *
     * @return void
     */
    public function dispatch_actions( $curd_items ) {
        add_action( 'admin_init', [ $curd_items, 'form_handler' ] );
    }
}