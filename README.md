# Quick and Easy FAQs Plugin

This plugin provides a quick and easy way to add FAQs to your website.

### Features

* Easily add FAQs using FAQ custom post type.
* Display FAQs in simple list style.
* Display FAQs in toggle ( independent form of accordion ) style.
* Display FAQs in filterable toggle style.
* Settings page to change toggle style text, background and border colors.
* Custom CSS box in settings page to override default styles.
* Translation Ready ( Comes with POT file and few partially translated po & mo files )
* RTL ( Right to Left Language ) Support
* Support for Visual Composer Plugin

### Documentation


* Display all FAQs in simple list style.
	`[faqs]`

* Display all FAQs in simple list style but separated by groups.
	`[faqs style="grouped"]`

* Display FAQs in simple list style but filtered by given group slug.
	`[faqs filter="true"]` or `[faqs filter="group-slug,another-group-slug"]`

* Display all FAQs in toggle style using following shortcode.
	`[faqs style="toggle"]`

* Display all FAQs in accordion style using following shortcode.
	`[faqs style="accordion"]`

* Display all FAQs in toggle style but separated by groups.
	`[faqs style="toggle-grouped"]`

* Display all FAQs in accordion style but separated by groups.
    	`[faqs style="accordion-grouped"]`

* Display FAQs in toggle style but filtered by given group slug.
	`[faqs style="toggle" filter="true"]` or `[faqs style="toggle" filter="group-slug,another-group-slug"]`

* Display FAQs in any order you want. For more details, follow [this guide](https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters)
    	`[faqs order="ASC" orderby="name"]`

## Installation

1. Unzip the downloaded package
2. Upload `quick-and-easy-faqs` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress