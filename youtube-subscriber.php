<?php
/*
Plugin Name: YouTube Subscriber
Plugin URI:
Description: Create widget with form to subscribe to YouTube channel
Version: 1.0
Author: Web4pro
Author URI: http://www.web4pro.net/
*/

add_action('widgets_init', create_function('', 'register_widget( "YouTube_Subscriber" );')); //Widget registration

class YouTube_Subscriber extends WP_Widget //Start widget class
{
    public function __construct()
    {
        parent::__construct(
            'YouTube_Subscriber', //Widget identify
            __('YouTube Subscriber'), //Widget name
            array('description' => __('Create form subscribing to YouTube channel'))
        );
    }

    public function form($instance)
    {
        $title = isset($instance['title']) ? $instance['title'] : __('My channel'); //Title of the widget
        $user_text = isset($instance['user_text']) ? $instance['user_text'] : ''; //"Subscribe to my channel" text
        $width = isset($instance['width']) ? $instance['width'] : '250'; //Width of the widget, pixels
        $height = isset($instance['height']) ? $instance['height'] : '150'; //Height of the widget, pixels
        $user_nickname = isset($instance['user_nickname']) ? strtolower($instance['user_nickname']) : ''; //Nickname of the YouTube channel owner
        //Start the widget settings form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget title'); ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('user_text'); ?>"><?php _e('"Subscribe to my channel" text'); ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('user_text'); ?>"
                   name="<?php echo $this->get_field_name('user_text'); ?>" value="<?php echo esc_attr($user_text); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('user_nickname'); ?>"><?php _e('Your YouTube nickname'); ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('user_nickname'); ?>"
                   name="<?php echo $this->get_field_name('user_nickname'); ?>"
                   value="<?php echo esc_attr($user_nickname); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width of the widget (pixels)'); ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('width'); ?>"
                   name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo esc_attr($width); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height of the widget (pixels)'); ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('height'); ?>"
                   name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo esc_attr($height); ?>">
        </p>
    <?php
    }

    public function update($new_instance, $old_instance) //Save widget settings
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['user_nickname'] = (!empty($new_instance['user_nickname'])) ? strip_tags($new_instance['user_nickname']) : '';
        $instance['user_text'] = (!empty($new_instance['user_text'])) ? strip_tags($new_instance['user_text']) : '';
        $instance['width'] = (!empty($new_instance['width'])) ? strip_tags($new_instance['width']) : '';
        $instance['height'] = (!empty($new_instance['height'])) ? strip_tags($new_instance['height']) : '';

        return $instance;
    }

    public function widget($args, $instance)
    {
        extract($args); //Theme arguments for widgets

        $title = apply_filters('widget_title', $instance['title']);

        echo $before_widget; //Before widget tags
        if (!empty($title)) {
            echo $before_title . $title . $after_title; //Output title with the before-after tags
        }
        if(!empty($instance['user_text']) && $instance['title'] != ''){ //If user enter "Subscribe to my channel" text - output it
           echo '<div class="user_title"><p>' . $instance['user_text'] . '</p></div>';
        }
        //Out YouTube subscribing form
        ?>
        <iframe id="fr"
                style="overflow: hidden; height: <?php echo $instance['height'] ?>px; width: <?php echo $instance['width']; ?>px; border: 0pt none;"
                src="http://www.youtube.com/subscribe_widget?p=<?php echo $instance['user_nickname']; ?>" scrolling="no"
                frameborder="0"></iframe>
        <?php
        echo $after_widget; //After widget tags

    }
}