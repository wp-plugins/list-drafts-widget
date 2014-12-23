=== List Drafts Widget ===
Contributors: LesBessant
Tags: draft, drafts, sidebar, widget 
Requires at least: 2.8
Tested up to: 4.1
Stable tag: 2.1.1

Outputs an unordered list of the titles of saved draft posts in a sidebar widget. 
== Description ==

List Drafts is a simple sidebar widget which outputs a list of the titles of all posts currently saved as drafts. Users can set the title of the widget, and add a label to be used for all untitled drafts.

You can now have a list of forthcoming items as a "teaser" for your readers, or as a reminder to authors that they really need to finish those posts they started. It will probably not be of interest to many people, but I like it.

This version has been refactored to use the new plugins API introduced in WordPress 2.8

== Installation ==

1. Upload the 'list-drafts-widget' folder to your '/wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add the widget to your sidebar or other widget-enabled area in the usual way. 4. (Optional) Change the title and the text used for any untitled drafts - the default values are "Coming Soon" and "An untitled post"

== Frequently Asked Questions ==

= Does this have to be in the sidebar? =

This is a pure widget, so it can only be used in a sidebar or other widget-enabled area of your theme.

My older <a href="http://wordpress.org/extend/plugins/list-draft-posts/">List Draft Posts</a> plugin allows you to insert the list of drafts without resort to widgets. Please note that I won't be developing that plugin any more.

= Can it do this or that? =

Err, maybe. But that would be a job for a better coder. Anyone who wants to make their own version is more than welcome to do so.

== Changelog ==
= 2.1.1 =
* Minor edits, confirming compatibility with WordPress 4.0

= 2.1 =
* Bugfix: As menu items are a special kind of post, and can have a status of "Draft", under some circumstances these would be picked up as untitled posts by the widget. This version now checks for 'post_type' being "post", which will prevent this behaviour.

= 2.0.1 =
* Changed default widget title to "Coming Soon"

= 2.0 =
* Re-written to use the new Widget API introduced with WordPress 2.8. Otherwise unchanged.


= 1.0.3 =
* First released version


== Screenshots ==

1. Widget configuration options
2. Sample output

