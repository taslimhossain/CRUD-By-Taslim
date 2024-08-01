<div class="wrap">
    <h1><?php _e( 'New Item', 'crud-by-taslim' ); ?></h1>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row<?php echo $this->has_error( 'name' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="name"><?php _e( 'Name', 'crud-by-taslim' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" value="">
                        <?php if ( $this->has_error( 'name' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error( 'name' ); ?></p>
                        <?php } ?>
                    </td>
                </tr>
                <tr class="row<?php echo $this->has_error( 'email' ) ? ' form-invalid' : '' ;?>">
                    <th scope="row">
                        <label for="email"><?php _e( 'Email', 'crud-by-taslim' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="email" id="email" class="regular-text" value="">

                        <?php if ( $this->has_error( 'email' ) ) { ?>
                            <p class="description error"><?php echo $this->get_error( 'email' ); ?></p>
                        <?php } ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php wp_nonce_field( 'crud-crudbt' ); ?>
        <?php submit_button( __( 'Add Item', 'crud-by-taslim' ), 'primary', 'submit_item' ); ?>
    </form>
</div>
