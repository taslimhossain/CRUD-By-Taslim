<?php

namespace CRUDBT;

/**
 * Ajax class.
 *
 * Ajax code for delete crud item.
 * 
 * @class Ajax
 */
class Ajax {

    /**
	 *  __construct
     * 
     * @return void
     */
    function __construct() {

        add_action( 'wp_ajax_crudbt-delete-item', [ $this, 'delete_crud_item'] );
    }

    /**
     * Item delete
     *
     * @return void
     */
    public function delete_crud_item() {

        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'crudbt-delete-item' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verification failed!', 'crud-by-taslim' )
            ] );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [
                'message' => __( 'Sorry You don\'t have permission to delete CRUD item!', 'crud-by-taslim' )
            ] );
        }

        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;
        crudbt_delete_item( $id );

        wp_send_json_success();
    }
}
