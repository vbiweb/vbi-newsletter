<?php

class Vbi_Newsletters_Widget extends WP_Widget {
  // Set up the widget name and description.
  public function __construct() {
    $widget_options = array( 'classname' => 'vbi_newsletter_widget', 'description' => 'Widget for Newsletter Widget' );
    parent::__construct( 'vbi_newsletter_widget', 'VBI Newsletter Widget', $widget_options );
  }
  // Create the widget output.
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance[ 'title' ] );
    $description =  $instance[ 'description' ] ;
    $button_text = $instance['button_text'];
    $button_color = $instance['button_color'];
    $text_color = $instance['text_color'];
    $type = 'widget';
    echo $args['before_widget'] ; 
    echo do_shortcode( '[vbi-newsletters title="'.$title.'" type="'.$type.'"   description="'.$description.'" button_text="'.$button_text.'" button_color="'.$button_color.'" text_color="'.$text_color.'"]' );
    echo $args['after_widget'];
  }
  
  // Create the admin area widget settings form.
  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; 
    $description = ! empty( $instance['description'] ) ? $instance['description'] : ''; 
    $button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : ''; 
    $text_color = ! empty( $instance['text_color'] ) ? $instance['text_color'] : ''; 
    $button_color = ! empty( $instance['button_color'] ) ? $instance['button_color'] : ''; 

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label><br>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
    </p>
     <p>
      <label for="<?php echo $this->get_field_id( 'description' ); ?>">Description:</label><br>
      <input type="text" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" value="<?php echo esc_attr( $description ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'button_text' ); ?>">Button Text:</label><br>
      <input type="text" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" value="<?php echo esc_attr( $button_text ); ?>" />
    </p>

    <p>

        <label for="<?php echo $this->get_field_id( 'text_color' ); ?>" style="display:block;"><?php _e( 'Text Color:' ); ?></label> 
        <input class="widefat color-picker" id="<?php echo $this->get_field_id( 'text_color' ); ?>" name="<?php echo $this->get_field_name( 'text_color' ); ?>" type="text" value="<?php echo esc_attr( $text_color ); ?>" />
    </p>
    <p>

        <label for="<?php echo $this->get_field_id( 'button_color' ); ?>" style="display:block;"><?php _e( 'Button Color:' ); ?></label> 
        <input class="widefat color-picker" id="<?php echo $this->get_field_id( 'button_color' ); ?>" name="<?php echo $this->get_field_name( 'button_color' ); ?>" type="text" value="<?php echo esc_attr( $button_color ); ?>" />
    </p>
   
<!--  -->
 <script type="text/javascript">
 
    ( function( $ ){
        function initColorPicker( widget ) {
            widget.find( '.color-picker' ).not('[id*="__i__"]').wpColorPicker( {
                change: _.throttle( function() {
                    $(this).trigger( 'change' );
                }, 3000 )
            });
        }
 
        function onFormUpdate( event, widget ) {
            initColorPicker( widget );
        }
 
        $( document ).on( 'widget-added widget-updated', onFormUpdate );
 
        $( document ).ready( function() {
            $( '.widget-inside:has(.color-picker)' ).each( function () {
                initColorPicker( $( this ) );
            } );
        } );
 
    }( jQuery ) );
 
</script>

	
    <?php
  }
  // Apply settings to the widget instance.
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    $instance[ 'description' ] = strip_tags( $new_instance[ 'description' ] );
    $instance[ 'button_text' ] = strip_tags( $new_instance[ 'button_text' ] );
    $instance[ 'text_color' ] = strip_tags( $new_instance[ 'text_color' ] );
    $instance[ 'button_color' ] = strip_tags( $new_instance[ 'button_color' ] );
    return $instance;
  }

function vbi_newsletter_widget() { 
  register_widget( 'Vbi_Newsletters_Widget' );
}
function widgets_scripts( $hook ) {
    if ( 'widgets.php' != $hook ) {
        return;
    }
    wp_enqueue_style( 'wp-color-picker' );        
    wp_enqueue_script( 'wp-color-picker' ); 
}
}

?>