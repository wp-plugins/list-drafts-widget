<?php
/*
Plugin Name: List Drafts Widget
Plugin URI: http://losingit.me.uk/2008/06/29/list-drafts-widget
Description: A sidebar widget that lists the titles of draft posts
Version: 1.0.3
Author: Les Bessant
Author URI: http://losingit.me.uk/
*/


/*
List Drafts Widget:
Copyright (c) 2008 Les Bessant

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

function widget_lcb_list_drafts_init() {

	// Check to see required Widget API functions are defined...
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return; // ...and if not, exit gracefully from the script.

	$default_options = array(
		'title' => 'Coming Soon',
		'untitled' => 'An untitled post'
	);

	add_option('widget_lcb_list_drafts', $default_options );



	// This function prints the sidebar widget--the cool stuff!
	function widget_lcb_list_drafts($args) {

		// $args is an array of strings which help your widget
		// conform to the active theme: before_widget, before_title,
		// after_widget, and after_title are the array keys.
		extract($args);

		// Collect our widget's options, or define their defaults.
		$options = get_option('widget_lcb_list_drafts');
		$title = empty($options['title']) ? 'Coming Soon' : $options['title'];
		$untitled = empty($options['untitled']) ? 'An untitled post' : $options['untitled'];

 		// It's important to use the $before_widget, $before_title,
 		// $after_title and $after_widget variables in your output.
		global $wpdb;

		$my_drafts = $wpdb->get_results("SELECT post_title FROM $wpdb->posts WHERE post_status = 'draft'");
	if ($my_drafts) {

		echo $before_widget;
		echo $before_title . $title  . $after_title;
		lcb_list_drafts_output();
		echo $after_widget;
	}
}
	// This is the function that outputs the form to let users edit
	// the widget's title and so on. It's an optional feature, but
	// we'll use it because we can!
	function widget_lcb_list_drafts_control() {

		// Collect our widget's options.
		$options = $newoptions = get_option('widget_lcb_list_drafts');

		// This is for handing the control form submission.
		if ( $_POST['lcb_list_drafts-submit'] ) {
			// Clean up control form submission options
			$newoptions['title'] = strip_tags(stripslashes($_POST['lcb_list_drafts-title']));
			$newoptions['untitled'] = strip_tags(stripslashes($_POST['lcb_list_drafts-untitled']));


		// If original widget options do not match control form
		// submission options, update them.
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_lcb_list_drafts', $options);
		}
		}

		// Format options as valid HTML. Hey, why not.
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$untitled = htmlspecialchars($options['untitled'], ENT_QUOTES);

// The HTML below is the control form for editing options.
?>
		<div>
		<p style="text-align:right;"><label for="lcb_list_drafts-title" style="line-height:35px;display:block;">Widget Title: <input type="text" id="lcb_list_drafts-title" name="lcb_list_drafts-title" value="<?php echo $title; ?>" /></label></p>
		<p style="text-align:right;"><label for="lcb_list_drafts-untitled" style="line-height:35px;display:block;">Label for untitled drafts: <input type="text" id="lcb_list_drafts-untitled" name="lcb_list_drafts-untitled" value="<?php echo $untitled; ?>" /></label></p>
		<input type="hidden" name="lcb_list_drafts-submit" id="lcb_list_drafts-submit" value="1" />
		</div>
	<?php
	// end of widget_lcb_list_drafts_control()
	}

	// This registers the widget. About time.
	register_sidebar_widget('List Drafts', 'widget_lcb_list_drafts');

	// This registers the (optional!) widget control form.
	register_widget_control('List Drafts', 'widget_lcb_list_drafts_control',315,175);
}



// This is the function that outputs the list into the widget
function lcb_list_drafts_output() {
	global $wpdb;

	// initialise the variables
	$options = get_option('widget_lcb_list_drafts');
	$untitled = $options['untitled'];


/*	This is where we extract the draft titles - Adapted from code provided by mdawaffe in the Wordpress Forum:
	http://wordpress.org/support/topic/34503#post-195148
*/
$my_drafts = $wpdb->get_results("SELECT post_title FROM $wpdb->posts WHERE post_status = 'draft'");
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

}

// Delays plugin execution until Dynamic Sidebar has loaded first.
add_action('plugins_loaded', 'widget_lcb_list_drafts_init');
?>