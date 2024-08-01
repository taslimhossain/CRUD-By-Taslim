<?php

namespace CRUDBT;

/**
 * Frontend class.
 *
 * @class Frontend
 */
class Frontend {
   
    /**
	 *  __construct
	 * 
	 * @return void
     */
    function __construct() {

        // Sets up all the appropriate hooks and actions within our plugin.
        $this->dispatch_actions();
    }

    /**
     * Dispatch and bind actions
     *
     * @since 1.0.0
     * @return void
     */
    public function dispatch_actions() {
        add_action( 'after_setup_theme', array( $this, 'register_shortcode' ) );
    }

	/**
	 * Register crud_data shortcode function.
	 *
	 * @return void
	 */
	public function register_shortcode() {
        add_shortcode( 'crud_data', array( $this, 'render_crud_data_shortcode' ) );
	}

	/**
	 * CRUD data views shortcode function.
	 *
	 * @param array $atts
     * @param  string $content
     * @since 1.0.0
	 * @return string
	 */
    public function render_crud_data_shortcode( $atts , $content = null ) {

        // add css for this shortcode layout.
        wp_enqueue_style( 'crudbt-style' );

        // Attributes
        $atts = shortcode_atts(
            array(
                'number'  => 99,
                'offset'  => 0,
                'orderby' => 'id',
                'order'   => 'DESC'
            ),
            $atts,
            'crud_data'
        );


        $items = crudbt_get_items( $atts );

        $output  = '';
        $output .= '<div class="crud-veiw-wrap">';
        $output .= '<table>';
        $output .= '<tr>';
        $output .= '<th>' . __( 'Name', 'crud-by-taslim' ) . '</th>';
        $output .= '<th>' . __( 'Email', 'crud-by-taslim' ) . '</th>';
        $output .= '<th>' . __( 'Create at', 'crud-by-taslim' ) . '</th>';
        $output .= '</tr>';

            if( $items && is_array($items) && count($items) != 0 ) {
                foreach ($items as $item ) {
                    $output .= '<tr>';
                    $output .= '<td>' . esc_attr( $item->name ) . '</td>';
                    $output .= '<td>' . esc_attr( $item->email ) . '</td>';
                    $output .= '<td>' . esc_attr( wp_date( get_option( 'date_format' ), strtotime( $item->created_at ) ) ) . '</td>';
                    $output .= '</tr>';
                }
            }
        $output .= '</table>';
        $output .= '</div>';
        
        // Return code
        return $output;
    }
}
