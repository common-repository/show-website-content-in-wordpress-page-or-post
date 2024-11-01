=== Website Content in Page or Post ===
Contributors: matteoenna
Tags: page, shortcode, post, content, block
Requires at least: 4.0.0
Tested up to: 6.6
Stable tag: 2024.07.23
Donate link: https://www.paypal.me/matteoedev/2.55
License URI: http://www.gnu.org/licenses/gpl.html
License: GPLv2 or later

Fetches the content of another webpage or URL to display inside the current post or page.

== Description ==

Fetches the content of another webpage or URL to display inside the current post or page.

Please note that this plugin previously used `file_get_contents()`, but it's no longer recommended.

Starting now, this plugin utilizes the `wp_remote_get()` and `wp_remote_retrieve_body()` functions to retrieve content from URLs.

**This plugin contains code adapted from the original work by horshipsrectors**

== Installation ==

To install the plugin, please upload the folder to your plugins folder and active the plugin.

== Frequently Asked Questions ==

= Where do I ask questions about this plugin? =

Questions can be directed to the WordPress support forums.

= How do I use the plugin? =

Once installed, you can include the shortcode [horshipsrectors_get_html URL] in a page or post to fetch and display the target URL.

= Can I force the plugin to use file_get_contents() or CURL? =

Yes, use [horshipsrectors_get_html_get URL] or [horshipsrectors_get_html_curl URL] instead of the default [horshipsrectors_get_html URL]

= Why can't I see anything? =

While displaying the shortcode on WordPress, the closing bracket appears to be lost. Please ensure you're closing the shortcode properly.