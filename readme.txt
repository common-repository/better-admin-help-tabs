=== Better Admin Help Tabs ===
Contributors: ssuess,
Tags: admin help tabs, help
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=paypal%40c%2esatoristephen%2ecom&lc=US&item_name=Stephen%20Suess&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Requires at least: 3.3
Tested up to: 4.5.3
Stable tag: 1.3.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows creation and placement of Admin Help Tabs (those pull down tabs at the top of some admin pages) on any page or post, including custom post types.

== Description ==
This plugin will allow creation of admin help tabs (and associated sidebars) on any screen in the WordPress admin area. It creates a custom post type called Help Tabs to store information.  You need to add the following info to make it work:

1. Title - The title of your tab
2. Main content area 
3. Screen - What page/screen it should appear on
6. Type - Help tab or tab sidebar


HELP TAB EXAMPLE:
Let's say I want to add a help tab on the main Help Tabs listing page that says something about my plugin. I would use:

1. "My Main Tab"
2. "This is a main tab with my own info on it!"
3. "edit-sbah_helptab"
5. Select "Tab" (the default)

HELP SIDEBAR EXAMPLE:
Let's say I want to add a help sidebar (these are the areas to the right with extra info and links) on the main Help Tabs listing page. I would use:

1. "My Sidebar"
2. "This is a sidebar!"
3. "edit-sbah_helptab"
5. Select "Sidebar"

IMPORTANT NOTE: While there can be multiple tabs per page, there can be only ONE sidebar per page. If you add others to the same page, only the first one found will show.

NOTE:  I also have a plugin that does Admin Pointers (those blue info boxes), if you are interested in that one you can find it here: http://wordpress.org/plugins/better-admin-pointers/

This plugin leverages the great work done by others here:

For configuring metaboxes on the custom post type:
https://github.com/WebDevStudios/Custom-Metaboxes-and-Fields-for-WordPress


== Installation ==
It is always a good idea to make a backup of your database before installing any plugin.

There are 3 ways to install this plugin:

1. Search for it in your WordPress Admin (Plugins/Add New/Search) area and install from there

2. Download the zip file from http://wordpress.org/plugins/better-admin-help-tabs/ and then go to Plugins/Add New/Upload and then upload and activate it.

3. Upload the folder "better-admin-help-tabs" to "/wp-content/plugins/", then activate the plugin through the "Plugins" menu in WordPress




== Frequently Asked Questions ==
= Q: How can I find the screen/page id name to use? =
A: This can be easily deduced from looking at the URL in the admin. For regular posts, it would just be "post". For a custom post type, it would be the name of that custom post type (my-custom-post-type). For other pages (like my plugin editor example), it usually works to just remove the ".php" from the end of the url (i.e. "plugin-editor.php" becomes "plugin-editor").

= Q: Is there some handy reference somewhere for the main admin screen ids? =
A: You are in luck: <http://codex.wordpress.org/Plugin_API/Admin_Screen_Reference>

= Q: I'm the lazy type, is there some tool to help me identify admin screens? =
A: You are in even greater luck. I just added an option to show you what screen you are on anywhere in the admin. Go to BAH Options page and check the box for "Show Current Screen". A small header on every page will identify your admin screen.

= Q: If I have more than one tab on a page, how can I order them? =
A: Like the blog, they are in reverse cron order. So you can just change the dates of the ones you want to be on the top to the latest. If there is enough interest I may add an order field in a future version.

= Q: Can I put the same tab on multiple pages? =
A: As of version 1.1, yes. Separate your page(screen) names with either a comma or a space.



== Screenshots ==
1. The config page for my example help tab.
2. The example help tab and sidebar in action.


== Changelog ==

= Version 1.3.4 =
* FIX: REGEXP was not matching if item was at end of the line.

= Version 1.3.3 =
* FIX: Fixes the previous fix to the fix. Who knew MariaDB was not really identical to MySQL?

= Version 1.3.2 =
* FIX: previous fix was not a fix. This version fixes the fix, sigh.

= Version 1.3.1 =
* FIX: help tab query was sometimes showing on wrong pages because of partial name matching.

= Version 1.3 =
* FIX: resolved conflicts with some plugins that did not have a wp screen available.
* FIX: applying content filter properly to help tab content.

= Version 1.2 =
* FIX: Screen display option now properly coded and falls after admin bar loads.

= Version 1.1 =
* NEW FEATURE: Single entry can show on multiple pages

= Version 1.0 =
* First Version, awaiting bug reports...