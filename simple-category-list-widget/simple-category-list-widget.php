<?php

/*
 * Plugin Name: Simple Category List Widget
 * Plugin URI: http://thomasvitale.com
 * Description: Add a widget to show a list of categories with the possibility to exclude some of them.
 * Author: Thomas Vitale
 * Author URI: http://thomasvitale.com
 * Text Domain: simple-category-list-widget
 * Licence: GPL3
 * Version: 1.0
 */

 class SimpleCategoryListWidget extends WP_Widget {

    /**
     * Sets up the widget name and description
     */
    function __construct() {
      $properties = array(
        'classname' => 'widget_categories',
        'name' => __( 'Simple Category List Widget', 'simple-category-list-widget' ),
        'description' => __( 'Show a list of categories.', 'simple-category-list-widget' )
      );
      parent::__construct( 'simple_category_list_widget', '', $properties );
    }

    /**
  	 * Outputs the options form on admin
  	 */
    public function form( $instance ) {

      ?>

      <!-- Widget Title -->
      <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ), 'simple-category-list-widget' ); ?></label></label>
        <input
          class="widefat"
          type="text"
          id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
          name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
          value="<?php if ( ! empty( $instance['title'] ) ) echo esc_attr( $instance['title'] ); ?>"
        >
       </p>

       <!-- Widget Content -->
       <p>
         <label for="<?php echo esc_attr( $this->get_field_id( 'list' ) ); ?>"><?php _e( esc_attr( 'Categories IDs:' ), 'simple-category-list-widget' ) ?></label>
         <textarea
           class="widefat"
           type="text"
           id="<?php echo esc_attr( $this->get_field_id( 'list' ) ); ?>"
           name="<?php echo esc_attr( $this->get_field_name( 'list' ) ); ?>"
           placeholder="Insert a list of IDs belonging to categories to exclude, separated by a comma (,)."
         ><?php if ( ! empty( $instance['list'] ) ) echo esc_html( $instance['list'] ); ?></textarea>
       </p>

      <?php
    }

    /**
  	 * Outputs the content of the widget
  	 */
    public function widget( $args, $instance ) {

      echo $args['before_widget'];

        // The Title
        echo $args['before_title'];
         echo $instance['title'];
        echo $args['after_title'];

        echo '<ul>';
          // The Content
          $cat_args = array(
            'exclude' => trim( $instance[ 'list' ], ',' ),
            'title_li' => ''
          );
          wp_list_categories( apply_filters( 'widget_categories_args', $cat_args ) );
        echo '</ul>';

      echo $args['after_widget'];

    }

    /**
  	 * Processing widget options on save
  	 */
  	public function update( $new_instance, $old_instance ) {
      $instance = array();
      $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
      $instance['list'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( preg_replace('/[^0-9.,]/', '', trim( $new_instance['list'] ) ) ) : '';
  		return $new_instance;
  	}

  }

  add_action( 'widgets_init', function () {
    register_widget( 'SimpleCategoryListWidget' );
  });

?>