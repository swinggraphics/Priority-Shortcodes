<?php
/**
* Plugin Name: Priority Shortcodes
* Description: Processes specific shortcodes before wpautop and do_shortcode.
* Version: 1.0
* Author: Greg Perham
* Author URI: http://www.swinggraphics.com/
* License: LGPLv2.1
* 
* The code below is copied from do_shortcode() and do_shortcode_tag() in https://core.trac.wordpress.org/browser/tags/4.0/src/wp-includes/shortcodes.php#L0
* 
* Credit is due to the awesome people who authored the shortcodes API!
* My only unique contribution is line 29. :)
* 
*/

// Run our own [[shortcode]] before wpautop and do_shortcode

function sg_priority_shortcode( $content ) {
  global $shortcode_tags;

  if ( false === strpos( $content, '[[' ) )
    return $content;

  if (empty($shortcode_tags) || !is_array($shortcode_tags))
    return $content;

  // look for double brackets only
  $pattern = '(\\[\\[)' . substr( get_shortcode_regex(), 7, -5 ) . '(\\])';

  return preg_replace_callback( "/$pattern/s",
    function( $m ) {
      global $shortcode_tags;

      $tag = $m[2];
      $attr = shortcode_parse_atts( $m[3] );

      if ( isset( $m[5] ) ) {
        // enclosing tag - extra parameter
        return call_user_func( $shortcode_tags[$tag], $attr, $m[5], $tag );
      } else {
        // self-closing tag
        return call_user_func( $shortcode_tags[$tag], $attr, null,  $tag );
      }
    },
    $content
  );
}
add_filter( 'the_content', 'sg_priority_shortcode', 9 );
