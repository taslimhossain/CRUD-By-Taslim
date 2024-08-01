<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'CRUD Items', 'crud-by-taslim' ); ?></h1>

    <a href="<?php echo admin_url( 'admin.php?page=crudbt&action=new' ); ?>" class="page-title-action"><?php _e( 'Add New Item', 'crud-by-taslim' ); ?></a>

    <?php if ( isset( $_GET['inserted'] ) ) { ?>
        <div class="notice notice-success">
            <p><?php _e( 'Item has been added successfully!', 'crud-by-taslim' ); ?></p>
        </div>
    <?php } ?>

    <form action="" method="post">
        <?php
        $table = new CRUDBT\Admin\Crudbt_Items_List();
        $table->prepare_items();
        $table->display();
        ?>
    </form>
</div>
