=== Hreflang Manager - Hreflang Implementation for International SEO ===
Contributors: DAEXT
Tags: hreflang, seo, language, internationalization, multilingual
Donate link: https://daext.com
Requires at least: 4.0
Tested up to: 6.9.4
Requires PHP: 5.2
Stable tag: 1.17
License: GPLv3

The Hreflang Manager plugin provides you an easy and reliable method to implement hreflang in WordPress.

== Description ==
The Hreflang Manager plugin provides you an easy and reliable method to implement hreflang in WordPress.

For more information on the technical use of hreflang, please consider reading the [official Google documentation](https://developers.google.com/search/docs/advanced/crawling/localized-versions).

### Pro Version
The [Pro version](https://daext.com/hreflang-manager/) of this plugin is available on our website with additional features, including the synchronization of hreflang data across all sites in a network, an integrated Hreflang Checker for detecting implementation issues, a Locale Selector to display available alternate versions, support for adding hreflang information in XML sitemaps, up to 100 alternate versions per connection, tools for importing hreflang data from spreadsheets, and more.

### Features
* Supports the hreflang implementation of different websites or the sub-sites of a WordPress network
* Supports all the languages defined with [ISO 639-1](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes)
* Supports all the scripts defined with [ISO 15924](https://en.wikipedia.org/wiki/ISO_15924)
* Supports all the countries defined with [ISO 3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
* A maximum of 10 alternative versions of the page per connection
* Includes a tag inspector to verify the correct implementation in the front-end
* Allows configuring hreflang from the post editor or from a centralized menu
* Ability to select the default languages, scripts, and countries
* Automatically deletes the hreflang data of the deleted posts

### Getting Started

To begin working with the plugin, you may find the following Knowledge Base article helpful:

* [How to Manually Add Hreflang Data](https://daext.com/kb/hreflang-manager/how-to-manually-add-hreflang-data/)

Once your configuration is complete, you can confirm that your hreflang implementation works as expected with the following guide:

* [Verifying and Debugging Your Hreflang Implementation](https://daext.com/kb/hreflang-manager/verifying-and-debugging-your-hreflang-implementation/)

For more advanced configuration, examples, and troubleshooting, visit the [Plugin Knowledge Base](https://daext.com/kb/hreflang-manager/).

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/hreflang-manager-lite/` directory, or install the plugin through the WordPress Plugins screen directly.
2. Activate the plugin through the Plugins screen in WordPress.

### 1. Add hreflang data

Go to **Hreflang → Connections** and start adding hreflang data.

Alternatively, you can create connections directly from the post editor using the **Hreflang Manager** panel. This panel is available in both the Block Editor and the Classic Editor. If you don’t see it, enable it from the editor options.

### 2. Verify your implementation

To verify your hreflang implementation, you can use the built-in **Tag Inspector**.

Go to **Hreflang → Options** and enable the Tag Inspector option. Then visit your site pages on the front end. When hreflang data is present, the Tag Inspector will be displayed over the page. The Tag Inspector is visible only to logged-in users with appropriate permissions and is not shown to visitors.

For detailed guidance and advanced configuration, visit the [official Knowledge Base](https://daext.com/kb/hreflang-manager/).

== Changelog ==

= 1.17 =

*Mar 26, 2026*

* The Pro version upgrade banner previously displayed at the bottom of all plugin menu pages is now shown only in the Options menu.
* Added a notices manager class used to display documentation resources and a link to rate the plugin. A related action hook has also been introduced to allow notices to be rendered in a specific area of the plugin UI.

= 1.16 =

*March 1, 2026*

* The style of the post editor meta box has been updated for improved consistency with the native classic editor interface. In addition, the Select2 library is no longer used for select elements, as these have been replaced with native HTML select fields.
* Additional minor functional improvements to the post editor meta box.

= 1.15 =

*February 16, 2026*

* Updated Pro Version feature labels in the admin toolbar.

= 1.14 =

*February 16, 2026*

* Added new interfaces for adding and managing hreflang data in both the Block Editor (via a dedicated sidebar) and the Classic or non-standard editors (via a dedicated meta box).

= 1.13 =

*October 16, 2025*

* The Log feature has been renamed to Tag Inspector, featuring an improved interface.

= 1.12 =

*April 16, 2025*

* Fixed PHP notice caused by early use of translation functions.

= 1.11 =

*November 29, 2024*

* Resolved CSS style issue.
* The load_plugin_textdomain() function now runs with the correct hook.

= 1.10 =

*June 14, 2024*

* In the "Connections" menu the URLs max length is now properly set to 2083 characters.
* The PHP trim() function has been added to the "Connections" menu to remove any leading or trailing white spaces from the entered URLs.

= 1.09 =

*May 23, 2024*

* Major back-end UI update.
* Refactoring.

= 1.08 =

*April 7, 2024*

* Fixed a bug (started with WordPress version 6.5) that prevented the creation of the plugin database tables and the initialization of the plugin database options during the plugin activation.

= 1.07 =

*October 25, 2023*

* Nonce fields have been added to the "Connections" menus.
* General refactoring. The phpcs "WordPress-Core" ruleset has been partially applied to the plugin code.

= 1.06 =

*February 8, 2023*

* The "Auto Alternate Pages" option has been added.
* Footer links have been added to all the plugin menus.
* Minor backend improvements.

= 1.05 =

*July 31, 2022*

* The text domain has been changed to match the plugin slug.
* Changelog added.
* All the dismissible notices are now generated in the "Connections" menu.
* Updated the description of the features in the "Pro Version" menu.
* The "Export to Pro" menu has been added.
* Minor backend improvements.

= 1.04 =

*February 11, 2022*

* The correct ISO 3166-1 alpha-2 code is now used for Lebanon.

= 1.03 =

*December 30, 2021*

* Minor backend improvements.

= 1.01 =

*March 17, 2021*

* Minor backend improvements.
* Bug fix.

= 1.00 =

*March 17, 2021*

* Initial release.

== Screenshots ==
1. Connections menu
2. Hreflang implementation of a single URL
3. Options menu in the "General" tab
4. Options menu in the "Defaults" tab