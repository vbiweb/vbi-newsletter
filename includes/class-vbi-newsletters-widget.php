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
    $type = 'widget';
    echo $args['before_widget'] ; 
    echo do_shortcode( '[vbi-newsletters title="'.$title.'" type="'.$type.'" ]' );
    echo $args['after_widget'];
  }
  
  // Create the admin area widget settings form.
  public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
    </p>
	
    <?php
  }
  // Apply settings to the widget instance.
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    $instance[ 'type' ] = strip_tags( $new_instance[ 'type' ] );
    return $instance;
  }

function vbi_newsletter_widget() { 
  register_widget( 'Vbi_Newsletters_Widget' );
}

}

?>