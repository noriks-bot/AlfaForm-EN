<?php
/**
 * Author: Rymera Web Co
 *
 * @package AdTribes\PFP\Helpers
 */

namespace AdTribes\PFP\Helpers;

use AdTribes\PFP\Factories\Product_Feed;

/**
 * Sanitization methods class.
 *
 * @since 13.4.5
 */
class Sanitization {

    /**
     * Sanitize HTML.
     *
     * @since 13.4.5
     *
     * @param string       $html_content The string to sanitize.
     * @param Product_Feed $feed         The feed object.
     * @return string The sanitized string.
     */
    public static function sanitize_html_content( $html_content, $feed ) {
        if ( empty( $html_content ) ) {
            return $html_content;
        }

        // Common sanitization steps for ALL platforms.
        $html_content = self::common_sanitization( $html_content );

        // Platform-specific handling.
        if ( self::platform_allows_html( $feed ) ) {
            $html_content = self::preserve_html_formatting( $html_content, $feed );
        } elseif ( self::platform_requires_pure_plain_text( $feed ) ) {
            $html_content = self::convert_to_pure_plain_text( $html_content, $feed );
        } else {
            $html_content = self::convert_to_plain_text( $html_content );
        }

        $html_content = self::sanitize_utf8_for_xml( $html_content );

        return $html_content;
    }

    /**
     * Common sanitization steps for all platforms.
     *
     * @since 13.4.5
     *
     * @param string $html_content The string to sanitize.
     * @return string The sanitized string.
     */
    private static function common_sanitization( $html_content ) {
        // Remove script and style tags and their content from the string.
        // Use a more robust regex that handles various script/style tag formats.
        $html_content = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $html_content );

        // Also remove any self-closing script/style tags.
        $html_content = preg_replace( '@<(script|style)[^>]*?/>@si', '', $html_content );

        // Remove any remaining script-like content that might not be properly wrapped.
        $html_content = preg_replace( '/alert\s*\(\s*[\'"].*?[\'"]\s*\)\s*;?/i', '', $html_content );
        $html_content = preg_replace( '/var\s+\w+\s*=\s*[\'"].*?[\'"]\s*;?/i', '', $html_content );
        $html_content = preg_replace( '/body\s*\{[^}]*\}/i', '', $html_content );

        // Strip out Visual Composer raw HTML shortcodes.
        $html_content = preg_replace( '/\[vc_raw_html.*\[\/vc_raw_html\]/', '', $html_content );

        // Remove shortcodes from the string.
        $html_content = do_shortcode( $html_content );

        // Remove any remaining shortcodes if any.
        $html_content = preg_replace( '/\[(.*?)\]/', ' ', $html_content );

        return $html_content;
    }

    /**
     * Preserve HTML formatting for platforms that allow it.
     *
     * @since 13.4.5
     *
     * @param string       $html_content The string to sanitize.
     * @param Product_Feed $feed         The feed object.
     * @return string The sanitized string with HTML formatting preserved.
     */
    private static function preserve_html_formatting( $html_content, $feed ) {
        // Define allowed HTML tags for Google Merchant Center formatting.
        $allowed_tags = '<br><p><ul><ol><li><em><i><strong><b>';

        /**
         * Filter the allowed HTML tags for platforms that support HTML formatting.
         *
         * @since 13.4.5
         *
         * @param string $allowed_tags The allowed HTML tags.
         * @param Product_Feed $feed The feed object.
         */
        $allowed_tags = apply_filters( 'adt_product_feed_allowed_html_tags', $allowed_tags, $feed );

        // Remove all tags except allowed formatting tags.
        $html_content = strip_tags( $html_content, $allowed_tags );

        // Clean up any empty tags that might have been left.
        $html_content = preg_replace( '/<([^>]*?)\s*\/?>/', '<$1>', $html_content );
        $html_content = preg_replace( '/<([^>]*?)\s*\/?>\s*<\/\1>/', '', $html_content );

        // Remove new line breaks and non-breaking spaces.
        $html_content = str_replace( array( "\r", "\n", '&#xa0;' ), '', $html_content );

        // Clean up multiple spaces.
        $html_content = preg_replace( '/\s+/', ' ', $html_content );

        return trim( $html_content );
    }

    /**
     * Convert to plain text for platforms that don't allow HTML.
     *
     * @since 13.4.5
     *
     * @param string $html_content The string to sanitize.
     * @return string The sanitized string as plain text.
     */
    private static function convert_to_plain_text( $html_content ) {
        // Replace tags by space rather than deleting them, first we add a space before the tag, then we strip the tags.
        // This is to prevent words from sticking together.
        $html_content = str_replace( '<', ' <', $html_content );

        // Remove tags from the string.
        $html_content = wp_strip_all_tags( $html_content );

        // Convert special characters.
        $html_content = htmlentities( $html_content, ENT_QUOTES | ENT_SUBSTITUTE | ENT_XML1, 'UTF-8', false );

        // Remove new line breaks and non-breaking spaces.
        $html_content = str_replace( array( "\r", "\n", '&#xa0;' ), '', $html_content );

        return trim( $html_content );
    }

    /**
     * Convert to pure plain text format for platforms that require it.
     * This method handles platforms like Pinterest that need plain text without HTML entities.
     *
     * @since 13.4.6
     *
     * @param string       $html_content The string to sanitize.
     * @param Product_Feed $feed         The feed object.
     * @return string The sanitized string as pure plain text.
     */
    private static function convert_to_pure_plain_text( $html_content, $feed ) {
        // Convert common list elements to readable plain text first.
        $html_content = preg_replace( '/<li[^>]*>/i', '• ', $html_content );
        $html_content = preg_replace( '/<\/li>/i', "\n", $html_content );

        // Convert block elements to line breaks.
        $html_content = preg_replace( '/<\/?(p|div|h[1-6]|br)[^>]*>/i', "\n", $html_content );
        $html_content = preg_replace( '/<\/(ul|ol)[^>]*>/i', "\n", $html_content );

        // Remove opening list tags.
        $html_content = preg_replace( '/<(ul|ol)[^>]*>/i', '', $html_content );

        // Add space before tags to prevent words from sticking together.
        $html_content = str_replace( '<', ' <', $html_content );

        // Strip all remaining HTML tags.
        $html_content = wp_strip_all_tags( $html_content );

        // Decode HTML entities back to plain characters.
        $html_content = html_entity_decode( $html_content, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8' );

        // Clean up whitespace and line breaks.
        $html_content = preg_replace( '/\r\n|\r|\n/', ' ', $html_content ); // Convert line breaks to spaces.
        $html_content = preg_replace( '/\s+/', ' ', $html_content ); // Collapse multiple spaces.

        // Remove non-breaking spaces and other problematic characters.
        $html_content = str_replace( array( '&nbsp;', '&#160;', '&#xa0;' ), ' ', $html_content );

        /**
         * Filter the pure plain text content for specific platforms.
         *
         * @since 13.4.6
         *
         * @param string       $html_content The sanitized plain text content.
         * @param Product_Feed $feed         The feed object.
         */
        $html_content = apply_filters( 'adt_product_feed_pure_plain_text_content', $html_content, $feed );

        return trim( $html_content );
    }

    /**
     * Check if the platform allows HTML formatting.
     *
     * @since 13.4.5
     *
     * @param Product_Feed $feed The feed object.
     * @return bool True if platform allows HTML, false otherwise.
     */
    private static function platform_allows_html( $feed ) {
        if ( ! $feed ) {
            return false;
        }

        /**
         * Filter the platform allowes HTML fields.
         *
         * @since 13.4.5
         *
         * @param array $platform_allowes_html_fields The platform allowes HTML fields.
         * @param Product_Feed $feed The feed object.
         */
        $platform_allowes_html_fields = apply_filters(
            'adt_product_feed_platform_allowes_html_fields',
            array(
                'bing_shopping',
                'bing_shopping_promotions',
                'facebook_drm',
                'google_shopping',
                'google_drm',
                'google_dsa',
                'google_local',
                'google_local_products',
                'google_product_review',
                'google_shopping_promotions',
            ),
            $feed
        );

        return in_array( $feed->get_channel( 'fields' ), $platform_allowes_html_fields, true );
    }

    /**
     * Check if the platform requires pure plain text formatting.
     *
     * @since 13.4.6
     *
     * @param Product_Feed $feed The feed object.
     * @return bool True if platform requires pure plain text, false otherwise.
     */
    private static function platform_requires_pure_plain_text( $feed ) {
        if ( ! $feed ) {
            return false;
        }

        /**
         * Filter the platforms that require pure plain text fields.
         *
         * @since 13.4.5
         *
         * @param array        $platform_requires_pure_plain_text_fields The platforms that require pure plain text fields.
         * @param Product_Feed $feed                                     The feed object.
         */
        $platform_requires_pure_plain_text_fields = apply_filters(
            'adt_product_feed_platform_requires_pure_plain_text_fields',
            array(
                'pinterest',
            ),
            $feed
        );

        return in_array( $feed->get_channel( 'fields' ), $platform_requires_pure_plain_text_fields, true );
    }

    /**
     * Sanitize raw HTML for raw_* fields: remove script, style, iframe tags but keep other HTML.
     *
     * @since 13.4.6
     * @since 13.5.3 Removed wp_autop(), WooCommerce descriptions come from WordPress's visual editor, which already applies wpautop() when saving.
     *               This is for raw HTML content - we shouldn't be auto-formatting it and removes the source of trailing newlines.
     *
     * @param string $html_content The string to sanitize.
     * @return string The sanitized string.
     */
    public static function sanitize_raw_html_content( $html_content ) {
        if ( empty( $html_content ) ) {
            return $html_content;
        }
        // Expand shortcodes (content from WooCommerce is already HTML-formatted).
        $html_content = do_shortcode( $html_content );
        // Remove script, style, and iframe tags and their content.
        $html_content = preg_replace( '@<(script|style|iframe)[^>]*?>.*?</\1>@si', '', $html_content );
        // Remove self-closing script, style, and iframe tags.
        $html_content = preg_replace( '@<(script|style|iframe)[^>]*?/>@si', '', $html_content );
        return $html_content;
    }

    /**
     * Strip unwanted UTF characters from string to ensure XML compatibility.
     *
     * @since 13.4.6
     *
     * @param string $html_content The string to sanitize.
     * @return string The sanitized string with XML-safe characters only.
     */
    public static function sanitize_utf8_for_xml( $html_content ) {
        if ( empty( $html_content ) ) {
            return $html_content;
        }

        // Remove characters that are not valid in XML.
        // Only allow: tab, line feed, carriage return, and printable characters.
        return preg_replace( '/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $html_content );
    }

    /**
     * Sanitize an array recursively.
     *
     * @since 13.4.4
     * @param array $array_data The array to sanitize.
     * @param mixed ...$args Additional arguments to pass to the callback.
     * @return array
     */
    public static function sanitize_array( $array_data, ...$args ) {
        if ( ! is_array( $array_data ) ) {
            return self::sanitize_text_field( $array_data, null, ...$args );
        }

        foreach ( $array_data as $key => $value ) {
            if ( is_array( $value ) ) {
                $array_data[ $key ] = self::sanitize_array( $value, ...$args );
            } else {
                $array_data[ $key ] = self::sanitize_text_field( $value, $key, ...$args );
            }
        }

        return $array_data;
    }

    /**
     * Custom sanitize callback that preserves whitespace.
     *
     * Uses wp_kses() for secure HTML sanitization when allow_html is enabled.
     *
     * @since 13.3.9
     * @since 13.5.3 Updated to use wp_kses() for secure HTML sanitization.
     *               Added 'allow_html' and 'allowed_tags' arguments.
     * @access public
     *
     * @param string $str     The value to sanitize.
     * @param string $key     The key of the value being sanitized.
     * @param mixed  ...$args Additional arguments to pass to the callback.
     *                        Supported options:
     *                        - 'allow_html' (bool): If true, uses wp_kses() to preserve HTML while removing dangerous content.
     *                                              Filters out event attributes (onclick, onerror), javascript: URLs, and other XSS vectors.
     *                        - 'allowed_tags' (string|null): Custom allowed HTML tags (e.g., '<p><br><strong>').
     *                                                        If null (default), uses wp_kses_post() allowing all post content tags.
     *                                                        If specified, only the listed tags and their safe attributes are preserved.
     *
     * @return string
     */
    public static function sanitize_text_field( $str, $key = null, ...$args ) {
        if ( is_object( $str ) || is_array( $str ) ) {
            return '';
        }

        $str = (string) $str;

        // Parse optional arguments.
        $options      = isset( $args[0] ) && is_array( $args[0] ) ? $args[0] : array();
        $allow_html   = isset( $options['allow_html'] ) ? (bool) $options['allow_html'] : false;
        $allowed_tags = isset( $options['allowed_tags'] ) ? $options['allowed_tags'] : null;

        $filtered = wp_check_invalid_utf8( $str );

        if ( str_contains( $filtered, '<' ) ) {
            if ( $allow_html ) {
                // When HTML is allowed, use wp_kses for secure sanitization.
                if ( ! is_null( $allowed_tags ) ) {
                    // Convert allowed_tags string to wp_kses format.
                    $allowed_html = self::parse_allowed_tags( $allowed_tags );
                    $filtered     = wp_kses( $filtered, $allowed_html );
                } else {
                    // Allow all safe HTML tags (uses WordPress post content rules).
                    $filtered = wp_kses_post( $filtered );
                }
            } else {
                // Default behavior: strip all HTML tags.
                $filtered = wp_pre_kses_less_than( $filtered );
                // This will strip extra whitespace for us.
                $filtered = wp_strip_all_tags( $filtered, false );

                /*
                 * Use HTML entities in a special case to make sure that
                 * later newline stripping stages cannot lead to a functional tag.
                 */
                $filtered = str_replace( "<\n", "&lt;\n", $filtered );
            }
        }

        if ( ! $allow_html ) {
            $filtered = preg_replace( '/[\r\n\t ]+/', ' ', $filtered );
        }

        if ( ! is_null( $key ) && ! in_array( $key, array( 'prefix', 'suffix' ), true ) ) {
            $filtered = trim( $filtered );
        }

        // Remove percent-encoded characters.
        $found = false;
        while ( preg_match( '/%[a-f0-9]{2}/i', $filtered, $match ) ) {
            $filtered = str_replace( $match[0], '', $filtered );
            $found    = true;
        }

        if ( $found ) {
            // Strip out the whitespace that may now exist after removing percent-encoded characters.
            $filtered = preg_replace( '/ +/', ' ', $filtered );
            if ( ! is_null( $key ) && ! in_array( $key, array( 'prefix', 'suffix' ), true ) ) {
                $filtered = trim( $filtered );
            }
        }

        return $filtered;
    }

    /**
     * Parse allowed tags string into wp_kses compatible format.
     *
     * @since 13.5.3
     * @access private
     *
     * @param string $allowed_tags String of allowed tags (e.g., '<p><br><strong>').
     * @return array Array format compatible with wp_kses.
     */
    private static function parse_allowed_tags( $allowed_tags ) {
        // Extract tag names from the string.
        preg_match_all( '/<(\w+)>/', $allowed_tags, $matches );

        if ( empty( $matches[1] ) ) {
            return array();
        }

        $allowed_html = array();
        foreach ( $matches[1] as $tag ) {
            // Define safe attributes for each tag.
            switch ( $tag ) {
                case 'a':
                    $allowed_html[ $tag ] = array(
                        'href'   => true,
                        'title'  => true,
                        'target' => true,
                        'rel'    => true,
                    );
                    break;
                case 'img':
                    $allowed_html[ $tag ] = array(
                        'src'    => true,
                        'alt'    => true,
                        'title'  => true,
                        'width'  => true,
                        'height' => true,
                    );
                    break;
                default:
                    // For most formatting tags, no attributes needed.
                    $allowed_html[ $tag ] = array();
                    break;
            }
        }

        return $allowed_html;
    }
}
