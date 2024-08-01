<?php

namespace CRUDBT\Admin;

use CRUDBT\FormError;

/**
 * CrudItem class.
 *
 * Add item Create, Read, Update, Delete page and hanle form.
 * 
 * @class CrudItem
 */
class CrudItem {

    use FormError;

    /**
     * Plugin page handler
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ( $action ) {
            case 'new':
                $template = __DIR__ . '/views/crudbt-new.php';
                break;

            case 'edit':
                $item  = crudbt_get_item( $id );
                $template = __DIR__ . '/views/crudbt-edit.php';
                break;

            case 'view':
                $item  = crudbt_get_item( $id );
                $template = __DIR__ . '/views/crudbt-view.php';
                break;

            default:
                $template = __DIR__ . '/views/crudbt-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Handle the form
     *
     * @return void
     */
    public function form_handler() {
        
        if ( ! isset( $_POST['submit_item'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'crud-crudbt' ) ) {
            wp_die( 'Nonce verification failed' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'You don\'t have permission to access this message.' );
        }

        $id      = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
        $name    = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
        $email   = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';

        if ( empty( $name ) ) {
            $this->errors['name'] = __( 'Please provide a name', 'crud-by-taslim' );
        }

        if ( empty( $email ) ) {
            $this->errors['email'] = __( 'Please provide a email', 'crud-by-taslim' );
        }


        if ( ! empty( $this->errors ) ) {
            return;
        }

        $args = array(
            'name'    => $name,
            'email'    => $email
        );

        if ( $id ) {
            $args['id'] = $id;
        }

        $insert_id = crudbt_insert_item( $args );

        if ( is_wp_error( $insert_id ) ) {
            wp_die( $insert_id->get_error_message() );
        }

        if ( $id ) {
            $redirected_to = admin_url( 'admin.php?page=crudbt&action=edit&item-updated=true&id=' . $id );
        } else {
            $redirected_to = admin_url( 'admin.php?page=crudbt&inserted=true' );
        }

        wp_redirect( $redirected_to );
        exit;
    }

    public function delete_item() {
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'crudbt-delete-item' ) ) {
            wp_die( 'Are you cheating?' );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Are you cheating?' );
        }

        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;

        if ( crudbt_delete_item( $id ) ) {
            $redirected_to = admin_url( 'admin.php?page=crudbt&item-deleted=true' );
        } else {
            $redirected_to = admin_url( 'admin.php?page=crudbt&item-deleted=false' );
        }

        wp_redirect( $redirected_to );
        exit;
    }
}
