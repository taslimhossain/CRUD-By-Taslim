<?php

namespace CRUDBT\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}


/**
 * CRUD Item List Table Class.
 *
 * Show all items from custom table.
 * 
 * @class Crudbt_Items_List
 */
class Crudbt_Items_List extends \WP_List_Table {

    function __construct() {
        parent::__construct( 
            array(
                'singular' => 'item',
                'plural'   => 'items',
                'ajax'     => false
            )
        );
    }

    /**
     * Message to show if no item found from custom table
     *
     * @return void
     */
    function no_items() {
        _e( 'No item found', 'crud-by-taslim' );
    }

    /**
     * Get the column names
     *
     * @return array
     */
    public function get_columns() {
        return array(
            'name'       => __( 'Name', 'crud-by-taslim' ),
            'email'      => __( 'Email', 'crud-by-taslim' ),
            'created_at' => __( 'Date', 'crud-by-taslim' ),
            'action' => __( 'action', 'crud-by-taslim' ),
        );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = [
            'created_at' => [ 'created_at', true ],
        ];

        return $sortable_columns;
    }

    /**
     * Default column values
     *
     * @param  object $item
     * @param  string $column_name
     *
     * @return string
     */
    protected function column_default( $item, $column_name ) {

        switch ( $column_name ) {

            case 'name':
                return sprintf( '<a href="%1$s"><strong>%2$s</strong></a>', admin_url( 'admin.php?page=crudbt&action=view&id=' . $item->id ), $item->name );

            case 'created_at':
                return wp_date( get_option( 'date_format' ), strtotime( $item->created_at ) );

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Render the "name" column
     *
     * @param  object $item
     *
     * @return string
     */
    public function column_action( $item ) {
        $actions = [];

        $actions['edit']   = sprintf( '<a href="%s" title="%s" class="button button-primary">%s</a>', admin_url( 'admin.php?page=crudbt&action=edit&id=' . $item->id ), $item->id, __( 'Edit', 'crud-by-taslim' ), __( 'Edit', 'crud-by-taslim' ) );
        $actions['delete'] = sprintf( '<a href="#" class="button itemdelete" data-id="%s">%s</a>', $item->id, __( 'Delete', 'crud-by-taslim' ) );

        return $this->row_actions( $actions, true );
    }


    /**
     * Prepare the items
     *
     * @return void
     */
    public function prepare_items() {
        $column   = $this->get_columns();
        $hidden   = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [ $column, $hidden, $sortable ];

        $per_page     = 15;
        $current_page = $this->get_pagenum();
        $offset       = ( $current_page - 1 ) * $per_page;

        $args = [
            'number' => $per_page,
            'offset' => $offset,
        ];

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        $this->items = crudbt_get_items( $args );

        $this->set_pagination_args( [
            'total_items' => crudbt_items_count(),
            'per_page'    => $per_page
        ] );
    }
}
