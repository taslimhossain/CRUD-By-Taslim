<?php

/**
 * Insert a new item
 *
 * @param  array  $args
 *
 * @return int|WP_Error
 */
function crudbt_insert_item( $args = [] ) {
    global $wpdb;

    if ( empty( $args['name'] ) ) {
        return new \WP_Error( 'no-name', __( 'You must provide a name.', 'crud-by-taslim' ) );
    }

    if ( empty( $args['email'] ) ) {
        return new \WP_Error( 'no-email', __( 'You must provide a email.', 'crud-by-taslim' ) );
    }

    $defaults = [
        'name'       => '',
        'email'    => '',
        'created_at' => current_time( 'mysql' ),
    ];

    $data = wp_parse_args( $args, $defaults );

    if ( isset( $data['id'] ) ) {

        $id = $data['id'];
        unset( $data['id'] );

        $updated = $wpdb->update(
            $wpdb->prefix . 'crudbt_table',
            $data,
            [ 'id' => $id ],
            [
                '%s',
                '%s',
                '%s'
            ],
            [ '%d' ]
        );

        return $updated;

    } else {

        $inserted = $wpdb->insert(
            $wpdb->prefix . 'crudbt_table',
            $data,
            [
                '%s',
                '%s',
                '%s'
            ]
        );

        if ( ! $inserted ) {
            return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'crud-by-taslim' ) );
        }

        return $wpdb->insert_id;
    }
}

/**
 * Fetch CRUD Items
 *
 * @param  array  $args
 *
 * @return array
 */
function crudbt_get_items( $args = [] ) {
    global $wpdb;

    $defaults = [
        'number'  => 15,
        'offset'  => 0,
        'orderby' => 'id',
        'order'   => 'DESC'
    ];

    $args = wp_parse_args( $args, $defaults );

    $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}crudbt_table
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
            $args['offset'], $args['number']
    );

    $items = $wpdb->get_results( $sql );

    return $items;
}

/**
 * Get the count of total items
 *
 * @return int
 */
function crudbt_items_count() {
    global $wpdb;

    $count = (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}crudbt_table" );

    return $count;
}

/**
 * Fetch a single item from the crudbt_table table
 *
 * @param  int $id
 *
 * @return object
 */
function crudbt_get_item( $id ) {
    global $wpdb;

    $item = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}crudbt_table WHERE id = %d", $id ) );
    
    return $item;
}

/**
 * Delete item from the crudbt_table table.
 *
 * @param  int $id
 *
 * @return int|boolean
 */
function crudbt_delete_item( $id ) {
    global $wpdb;

    return $wpdb->delete(
        $wpdb->prefix . 'crudbt_table',
        [ 'id' => $id ],
        [ '%d' ]
    );
}