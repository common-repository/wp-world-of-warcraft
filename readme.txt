=== Plugin Name ===
Contributors: infinetsoftware
Tags: world of warcraft
Requires at least: 2.0.2
Tested up to: 2.7
Stable tag: trunk

Display random World of Warcraft images on your wordpress powered site.

== Description ==

WP World of Warcraft will display random World of Warcraft images on your Wordpress powered site. Works as a sidebar widget, in your theme, or as shortcode.

*	**[Plugin Homepage](http://mymmoinc.com/wpplugin/wow/)**
*	**[World of Warcraft Gold](http://mymmoshop.com/buy/world-of-warcraft-us/gold/index.php)**

== Installation ==

1.	Download the zip file and extract the wpwow.php file.
2.	Upload wpwow.php to your Wordpress plugins folder.
3.	Login to the Wordpress admin area and activate the plugin.
4.	Follow the steps in the next section for more on displaying the plugin on your site.

= Displaying WP World of Warcraft: = 

= As a Sidebar Widget (Requires Wordpress 2.3+ and a Widget-ready Theme) =
1.	Login to the Wordpress admin area and browse to the Appearance Tab
2.	Browse to the Widgets Tab and Enable WP World of Warcraft

= In Posts/Pages with Shortcode (Wordpress 2.5+): =
*	When writing or editing a page or post, insert the code `[WPWoW]` to display the images.
*	Optionally specifiy the number of images you want to display. Defaults to 5.
	Ex: `[WPWoW Count="10"]`

= In Your Theme: =
*	Insert the following code where you want the World of Warcraft images to appear in your blog template:
	`<?php WPWoW_ShowImages(); ?>`
*	Optionally pass a Count to set the max number of images to display. Defaults to 5.
	Ex: `<?php WPWoW_ShowImages(10); ?>`

== Frequently Asked Questions ==

= What are the requirements for WP World of Warcraft? =

1.	Wordpress 2.x+
2.	PHP 5+
3.	PHP CURL support

= Where are the Images? =

We host and update the World of Warcraft images for you on our servers.

== Screenshots ==

1. The WP World of Warcraft plugin as a sidebar widget.