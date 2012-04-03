<?php
/*
Plugin Name: Time since date
Plugin URI: http://www.freanki.net/timesincedate/
Description: This plugin shows the time since a specific date.
Version: 0.6
Author: Frank Hommes
Author URI: http://www.freanki.net/
License: GPL2
*/

/**
 * Authors Widget Class
 */
class time_since_date_widget extends WP_Widget {

function monate_differenz ($t1, $t2) {
$month_from = date(‘n’, $t1);
$month_to = date(‘n’, $t2);
$year_from = date(‘Y’, $t1);
$year_to = date(‘Y’, $t2);
return 12*($year_to-$year_from)+$month_to-$month_from;
}

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
		$scale = $instance['scale'];	
		if(!$size)
			$size = 40;

        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul>
							<?php
							echo $pre;
	
	  

							if ($scale == "days") $output = floor((strtotime("now") - strtotime("$date")) / 86400);
							elseif ($scale == "weeks") $output = floor((strtotime("now") - strtotime("$date")) / (86400*7));
							elseif ($scale == "months") {
										  $query = "SELECT TIMESTAMPDIFF(MONTH,'$date' ,CURDATE())";
										  echo $wpdb->get_var($query);
										    }
							elseif ($scale == "years") {
									$query = "SELECT TIMESTAMPDIFF(YEAR,'$date',CURDATE())";
										  echo $wpdb->get_var($query);
}

							echo $output;
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
		$instance['scale'] = strip_tags($new_instance['scale']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {	

        $title = esc_attr($instance['title']);
	$date = esc_attr($instance['date']);
	$pre = esc_attr($instance['pre']);
	$after = esc_attr($instance['after']);
	$scale = esc_attr($instance['scale']);			
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
          
          <label for="<?php echo $this->get_field_id('scale'); ?>"><?php _e('Scale (days/months/years):'); ?></label> 
	  <select size="1" name="<?php echo $this->get_field_name('scale'); ?>" id="<?php echo $this->get_field_id('scale'); ?>" class="widefat">

					 <option value="days" <?php if ("days" == $scale) echo "selected='selected' "; ?> ><?php _e('days'); ?></option>
					 <option value="weeks" <?php if ("weeks" == $scale) echo "selected='selected' "; ?> ><?php _e('weeks'); ?></option>	
					 <option value="months" <?php if ("months" == $scale) echo "selected='selected' "; ?> ><?php _e('months'); ?></option>	
					 <option value="years" <?php if ("years" == $scale) echo "selected='selected' "; ?> ><?php _e('years'); ?></option>	


		  </select>
        </p>

         <p>
          <label for="<?php echo $this->get_field_id('pre'); ?>"><?php _e('Text before (optional):'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('pre'); ?>" name="<?php echo $this->get_field_name('pre'); ?>" type="text" value="<?php echo $pre; ?>" />
        </p>

         <p>
          <label for="<?php echo $this->get_field_id('after'); ?>"><?php _e('Text after (optional):'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('after'); ?>" name="<?php echo $this->get_field_name('after'); ?>" type="text" value="<?php echo $after; ?>" />
        </p>


        <?php 
    }



}
// register Recent Posts widget
add_action('widgets_init', create_function('', 'return register_widget("time_since_date_widget");'));
