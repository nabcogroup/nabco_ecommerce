<?php
/**
 * Call a shortcode function by tag name.
 *
 * @since   0.1
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function nabcofurnitures_do_shortcode( $tags, array $atts = array(), $content = null ) {

	//call global shortcode tags
	global $shortcode_tags;

	if(is_array($tags))  {

		foreach($tags as $tag) {
			if ( isset( $shortcode_tags[ $tag ] ) ) {
				return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
			}
		}
	}
	else {

		if ( ! isset( $shortcode_tags[ $tags ] ) ) {
			return false;
		}
		
		return call_user_func( $shortcode_tags[ $tags ], $atts, $content, $tags );
	}

}