<?php
/*
Plugin Name: Time since date
Plugin URI: http://www.freanki.net/timesincedate/
Description: This plugin shows the time since a specific date.
Version: 0.5
Author: Frank Hommes
Author URI: http://www.freanki.net/
License: GPL2
*/

/**
 * Authors Widget Class
 */
class time_since_date_widget extends WP_Widget {


    /** constructor */
    function time_since_date_widget() {
        parent::WP_Widget(false, $name = 'Time since date Widget');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {	
	
        extract( $args );
		global $wpdb;
		
        $title = apply_filters('widget_title', $instance['title']);
		$date = $instance['date'];
		$pre = $instance['pre'];
		$after = $instance['after'];
		
		if(!$size)
			$size = 40;

        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul>
							<?php
							echo $pre;
							$query = "select to_days(CURDATE())-to_days('$date') as day";
							echo $wpdb->get_var($query);
							echo $after;
							?>
							</ul>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['date'] = strip_tags($new_instance['date']);
		$instance['pre'] = strip_tags($new_instance['pre']);
		$instance['after'] = strip_tags($new_instance['after']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {	

        $title = esc_attr($instance['title']);
	$date = esc_attr($instance['date']);
	$pre = esc_attr($instance['pre']);
	$after = esc_attr($instance['after']);
		
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

		<p>
          
          <label for="<?php echo $this->get_field_id('date'); ?>"><?php _e('Date (Year-Month-Day):'); ?></label> 
	  <input  class="widefat" id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="text" value="<?php echo $date; ?>" />
        </p>

         <p>
          <label for="<?php echo $this->get_field_id('pre'); ?>"><?php _e('Text before:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('pre'); ?>" name="<?php echo $this->get_field_name('pre'); ?>" type="text" value="<?php echo $pre; ?>" />
        </p>

         <p>
          <label for="<?php echo $this->get_field_id('after'); ?>"><?php _e('Text after:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('after'); ?>" name="<?php echo $this->get_field_name('after'); ?>" type="text" value="<?php echo $after; ?>" />
        </p>


        <?php 
    }

function days_to ($anfangsdatum) {

//  $query = "select to_days(CURDATE())-to_days('2012-03-15') as day";
        // MYSQL 4.1.1: $query = "select DATEDIFF('CURDATE()', '".$anfangsdatum."') as day";
//$result = $wpdb->get_var( $wpdb->prepare( $query ) );
//$days = $wpdb->get_var($query);

//        return ("152");
        //return $ausgabe['day'];
        
}


} // class utopian_recent_posts
// register Recent Posts widget
add_action('widgets_init', create_function('', 'return register_widget("time_since_date_widget");'));
