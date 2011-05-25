<?php
/*
Plugin Name: List Drafts Widget
Plugin URI: http://losingit.me.uk/2010/03/14/list-drafts-widget-revisited
Description: A sidebar widget that lists the titles of draft posts
Version: 2.1
Author: Les Bessant
Author URI: http://losingit.me.uk/
*/


/*
List Drafts Widget:
Copyright (c) 2008-2011 Les Bessant

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

/**
 * Add function to widgets_init that'll load our widget.
 * @since 0.1
 */
add_action( 'widgets_init', 'listdrafts_load_widgets' );

/**
 * Register our widget.
 * 'ListDrafts_Widget' is the widget class used below.
 *
 * @since 0.1
 */
function listdrafts_load_widgets() {
	register_widget( 'ListDrafts_Widget' );
}

/**
 * List Drafts Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class ListDrafts_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function ListDrafts_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'example', 'description' => __('A widget which displays the title of draft posts.', 'listdrafts') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'listdrafts-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'listdrafts-widget', __('List Drafts Widget', 'listdrafts'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$untitled = $instance['untitled'];
		

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* List them */
		/*	This is where we extract the draft titles - Adapted from code provided by mdawaffe in the Wordpress Forum:
	http://wordpress.org/support/topic/34503#post-195148
*/
global $wpdb;
$my_drafts = $wpdb->get_results("SELECT post_title FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'draft'");
	if ($my_drafts) {

		$my_draft_list = "<ul>";
		foreach ($my_drafts as $my_draft) {
			$my_title = $my_draft->post_title;
			if ($my_title != '') {
				$my_draft_list .= "<li>" . $my_title . "</li>";
			}
			else {
				$my_draft_list .= "<li>" . $untitled . "</li>";
			}
		}
		$my_draft_list = $my_draft_list . "</ul>";
		echo $my_draft_list;
	}


		
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['untitled'] = strip_tags( $new_instance['untitled'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Coming Soon', 'listdrafts'), 'untitled' => __('An untitled post', 'listdrafts'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Name for Untitled Posts: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'untitled' ); ?>"><?php _e('Label for untitled posts', 'listdrafts'); ?></label>
			<input id="<?php echo $this->get_field_id( 'untitled' ); ?>" name="<?php echo $this->get_field_name( 'untitled' ); ?>" value="<?php echo $instance['untitled']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>