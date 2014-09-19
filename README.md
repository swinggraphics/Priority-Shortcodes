# Priority Shortcodes #
**Contributors:** swinggraphics
  
**Tags:** shortcodes, tinymce
  
**Requires at least:** 2.5.0
  
**Tested up to:** 4.0
  
**Stable tag:** trunk
  
**License:** GPLv2 or later
  
**License URI:** http://www.gnu.org/licenses/lgpl-2.1.html
  

Processes specific shortcodes before wpautop() and do_shortcode()

## Description ##

Ever get annoyed or frustrated by the way TinyMCE+wpautop+do_shortcode wreak havoc on your shortcodes, wrapping `<p>`s around `<div>`s, leaving orphan `</p>`s, and all sorts of craziness? This plugin allows you to use double square brackets ("[[ ]]") to specify shortcodes to be processed before those other actions, generating the clean code you expected.

*Did you know that you can use double brackets `[[shortcode]]` around a shortcode to output the shortcode code itself, to literally print "[shortcode]" on the page?* **Me neither**. A WordPress coding blog probably relies heavily on that, but almost no one else will ever use it. This plugin repurposes that syntax.

Priority Shortcodes works by adding an action to `the_content` hook with a higher priority than `wpautop` and `do_shortcode`. The result is that those other actions run your shortcode's final output, rather than trying to guess if it should be wrapped in `<p>` tags, etc.

The [Codex says](http://codex.wordpress.org/Shortcode_API#Output):

> wpautop recognizes shortcode syntax and will attempt not to wrap p or br tags around shortcodes that stand alone on a line by themselves. Shortcodes intended for use in this manner should ensure that the output is wrapped in an appropriate block tag such as `<p>` or `<div>`.

But sometimes shortcodes stand on their own on a line, wanting desperately to be wrapped in a paragraph tag, and sometimes they don't. Like a shortcode that generates a `<span>` tag with some classes. *(Yeah, you might want to use [custom TinyMCE styles](http://codex.wordpress.org/TinyMCE_Custom_Styles) instead for a simple span.)*

### Usage ###

Where you want to process a shortcode with priority, use "[[" at the start and "]]" at the end. For example:

- `[my-shortcode]` becomes `[[my-shortcode]]` and
- `[my-shortcode]Some content.[/my-shortcode]` becomes `[[my-shortcode]Some content.[/my-shortcode]]`.

## Frequently Asked Questions ##

### Does this affect all shortcodes? ###

No.

### Should I use this everywhere instead of the normal shortcodes? ###

No. Only use it on shortcodes that are being messed up.

### How does it work? ###

The plugin adds an action hook to `the_content` with priority 9, before `wpautop` and `do_shortcode`, which run with normal priority 10. The function that runs in our action hook is basically a copy/mashup of `do_shortcode()` and `do_shortcode_tag()` with a custom regular expression. That regex pulled using `get_shortcode_regex()`, so any updates to that expression in core will be respected by this plugin. See [shortcodes.php](https://core.trac.wordpress.org/browser/tags/4.0/src/wp-includes/shortcodes.php#L0)

### Isn't it bad to replace/overwrite/break built-in WordPress functionality? ###

Yes. Probably. Maybe. Double brackets work so nicely; I think anything else would be confusing. Feel free to customize the search pattern to something else that doesn't already have meaning, like `[* *]` or `![ ]!`. The only update I expect to make to this plugin is to add a setting to specify your own delimiters.

### Why not just change the order wpautop and do_shortcode run in? ###

That can mess up other shortcodes. Plus, I've tried it, and it doesn't have the result I wanted at all.

## Installation ##

See the standard installation instructions at [WordPress.org](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins) or [WPBeginner](http://www.wpbeginner.com/beginners-guide/step-by-step-guide-to-install-a-wordpress-plugin-for-beginners/).

I expect developers will copy the code directly into their functions.php files, possibly customizing the string to specify the priority shortcodes.

## Changelog ##

### 1.0 ###
* Initial release

## Upgrade Notice ##

### 1.0 ###
Get it while it's hot.
