# Quick and Easy FAQs Plugin

This plugin provides a quick and easy way add FAQs using custom post type and later on displaying those FAQs using Gutenberg Blocks or shortcodes.

### Features

* Easily add FAQs using FAQ custom post type.
* Display FAQs in simple list style, accordion style or toggle style.
* Display FAQs in groups.
* Display FAQs in filterable groups.
* Display FAQs in sorted order by title or date.
* Settings page to customize colors and other stuff.
* Custom CSS box in settings page to override default styles.
* Translation Ready ( Comes with POT file and PO & MO translation files for few main languages )
* RTL ( Right to Left Language ) Support
* Support for Visual Composer Plugin

### Documentation

* `[faqs]` Display all FAQs in simple list style.

* `[faqs order="ASC" orderby="title"]` Display all FAQs in simple list style and order by ascending title.

* `[faqs order="DESC" orderby="title"]` Display all FAQs in simple list style and order by descending title.

* `[faqs style="grouped"]` Display all FAQs in simple list style that are separated by groups.

* `[faqs filter="true"]` Display FAQs in simple list style that are filterable by all available groups.

* `[faqs filter="group-slug,another-group-slug"]` Display FAQs in simple list style that are filterable by only given group slugs.

* `[faqs style="toggle"]` Display all FAQs in toggle style.

* `[faqs style="toggle" filter="true"]` Display all FAQs in toggle style and filterable by all available groups.

* `[faqs style="toggle-grouped"]` Display all FAQs in toggle style and grouped by all available groups.

* `[faqs style="toggle" order="ASC" orderby="title"]` Display all FAQs in toggle style and order by ascending title.

* `[faqs style="toggle" order="DESC" orderby="title"]` Display all FAQs in toggle style and order by descending title.

* `[faqs style="accordion"]` Display all FAQs in accordion style.

* `[faqs style="accordion" filter="true"]` Display all FAQs in accordion style and filterable by all available groups.

* `[faqs style="accordion-grouped"]` Display all FAQs in accordion style and grouped by all available groups.

* `[faqs style="accordion" order="ASC" orderby="title"]` Display all FAQs in accordion style and order by ascending title.

* `[faqs style="accordion" order="DESC" orderby="title"]` Display all FAQs in accordion style and order by descending title.

If you want to display FAQs using custom code in php template then you can use the following code.

## Installation

# Method 1: Manual Installation via FTP

1. **Extract the Contents**: Locate the downloaded `quick-and-easy-faqs.zip` file and extract its contents using your preferred file decompression tool.
2. **Upload to WordPress**: Using an FTP client or your web hosting control panel's file manager, upload the extracted `quick-and-easy-faqs` folder to the `/wp-content/plugins/` directory on your WordPress website's server.
3. **Activate the Plugin**: Log in to your WordPress dashboard, navigate to the 'Plugins' menu, and find `Quick and Easy FAQs` in the list of available plugins. Click 'Activate' to enable the plugin's features on your site.

# Method 2: Install Directly Through WordPress

1. **Access the WordPress Dashboard**: Log in to your WordPress site's backend.
2. **Navigate to Plugins**: On the dashboard menu, click on 'Plugins', then select 'Add New'.
3. **Search for the Plugin**: In the 'Search plugins...' box, type in `Quick and Easy FAQs`.
4. **Install the Plugin**: Locate `Quick and Easy FAQs` in the search results, click 'Install Now' and wait for the installation to complete.
5. **Activate the Plugin**: After installation, click 'Activate' to start using the plugin on your website.