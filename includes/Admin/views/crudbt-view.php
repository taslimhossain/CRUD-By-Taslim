<div class="wrap">
    <h1><?php _e( 'Item details', 'crud-by-taslim' ); ?></h1>

    <div class="item-details">
        <ul>
            <li> <strong>Name:</strong> <?php echo esc_attr( $item->name ); ?></li>
            <li><strong>Email: </strong><?php echo esc_attr( $item->email ); ?></li>
            <li><strong>Create at: </strong><?php echo esc_attr( wp_date( get_option( 'date_format' ), strtotime( $item->created_at ) ) ); ?></li>
        </ul>
    </div>
</div>