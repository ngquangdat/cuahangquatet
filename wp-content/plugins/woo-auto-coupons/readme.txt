=== Auto Coupons for WooCommerce ===
Contributors: rermis
Tags: woocommerce, coupons, auto apply, quantity, discount
Requires at least: 4.6
Tested up to: 5.6
Stable tag: 1.3.10

Apply WooCommerce Coupons automatically with a simple, fast and lightweight plugin.

== Description ==
Apply WooCommerce Coupons automatically with a simple, fast and lightweight plugin.

= Special Features =
* Apply coupons when native WooCommerce coupon conditions are met
* Apply coupons when minimum product quantities are reached
* Apply coupons when a URL is visited
* Troubleshoot coupons easily by adding /?troubleshoot to the cart page URL


== Installation ==
1. Upload the plugin files to the `/wp-content/plugins/woo-auto-coupons` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the \'Plugins\' screen in WordPress
3. Go to the WooCommerce > Coupons page
4. Create a coupon or visit an existing coupon
5. Auto Apply settings are found on the General tab inside all WooCommerce coupons

== Screenshots ==
1. Coupon Applied
2. Minimum Quantity for discount
3. Admin Settings
4. Troubleshooting mode

== Changelog ==
= 1.3.10 = * Bug fix for add-to-cart - including ajax and parameter based actions.
= 1.3.7 = * If apply-via-url is attempted and no product is in cart, cache coupon and retry on next cart visit.
= 1.3.6 = * Improved option descriptions in admin.
= 1.3.5 = * Compatibility check for WC 4.8.
= 1.3.3 = * Compatibility check for WC 4.7. Do not display quantity related offer or attempt to auto-apply coupon if an individual use coupon has already been auto applied.
= 1.3.2 = * Compatibility check for WC 4.6
= 1.3.1 = * Finely detailed troubleshooting mode, encompassing all existing coupons
= 1.2.16 = * Compatibility with WC 4.5, bug fix for coupon expiration unixtime
= 1.2.15 = * Compatibility with WP 5.5
= 1.2.14 = * Improvements to settings interface
= 1.2.12 = * Compatibility check for WC 4.3
= 1.2.11 = * Accommodation for custom admin URL
= 1.2.10 = * Compatibility check for WC 4.2
= 1.2.9 = * Compatibility check for WC 4.1
= 1.2.8 = * Compatibility with WP 5.4
= 1.2.7 = * Updates to plugin name
= 1.2.6 = * Compatibility check for WC 4.0
= 1.2.5 = * Minor updates for WC 3.9
= 1.2.4 = * Minor updates for WC 3.8
= 1.2.3 = * Compatibility with WP 5.3
= 1.2.2 = * Minor updates for WC 3.7
= 1.2.1 = * Assign cart notifications a css class of 'wac' for ease of further customization.
= 1.2.0 = * Added handling of individual use coupons. Improved icons and color compatibility.
= 1.1.1 = * Improved admin input validation and input descriptions. Added cart messaging for max quantity limit.
= 1.0.9 = * WooCommerce version compatibility testing and indicator
= 1.0.8 = * current_user_can fixes
= 1.0.7 = * Helper function fixes
= 1.0.6 = * Adjusted keywords and installation instructions
= 1.0.5 = * Fixed removal logic when coupon no longer qualifies
= 1.0.3 = * Fixed empty admin menu item
= 1.0.2 = * Improved images and tags
= 1.0.1 = * Basic functionality created


== Frequently Asked Questions ==

= Does this plugin have a coupon limit? =
This plugin works with an unlimited number of coupons.

= Why isn't my coupon auto-applying? =
The coupon will apply only when conditions are met.  This includes conditions in the WooCommerce coupon settings under Usage Restriction and Usage Limits.  For instance, the coupon expiration date (if set) must be in the future.

= How can I troubleshoot my coupons? =
To troubleshoot, you must be logged in as an administrator.  Visit the cart page and add /?troubleshoot to the URL in the address bar.  This will list all auto-apply coupons and the status.

= Where can I get support? =
Reach out to us anytime for [additional support](https://richardlerma.com/#contact).