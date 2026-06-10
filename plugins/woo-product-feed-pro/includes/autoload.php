<?php
/**
 * Plugin autoload file.
 *
 * @package AdTribes\PFP
 */

namespace AdTribes\PFP;

defined( 'ABSPATH' ) || exit;

/**
 * Builds the path to the class file within the plugin directory.
 *
 * @since 13.3.3
 *
 * @param string $class The class name.
 * @return string The full class file path.
 */
function get_class_file_path( $class ) { // phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames.classFound

    $class = ltrim( $class, '\\' );
    $class = str_replace( '\\', DIRECTORY_SEPARATOR, $class );
    $class = mb_substr( $class, 13 );

    return ADT_PFP_PLUGIN_DIR_PATH . "includes/$class.php";
}

/**
 * Namespaced autoload function for the plugin.
 *
 * @since 13.3.3
 *
 * @param string $class The class name.
 */
function autoload( $class ) { // phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames.classFound

    $file = '';
    if ( 'AdTribes\PFP' === mb_substr( $class, 0, 12 ) ) {

        $file = get_class_file_path( $class );

        if ( file_exists( $file ) ) {
            require_once $file;
        }
    }
}

try {
    spl_autoload_register( '\AdTribes\PFP\autoload' );
} catch ( \Exception $exception ) {
    if ( is_admin() ) {
        add_action(
            'admin_notices',
            function () use ( $exception ) {
                ?>
                <div class="error settings-error notice">
                    <p>
                        <strong>Autoload ERROR:</strong>
                        <?php
                        printf(
                            '%s. %s',
                            esc_html( $exception->getMessage() ),
                            esc_html__( 'Please contact support if this issue persists.', 'woo-product-feed-pro' )
                        );
                        ?>
                    </p>
                </div>
                <?php
            }
        );
    } elseif ( current_user_can( 'manage_options' ) ) {
        add_action(
            'wp_footer',
            function () use ( $exception ) {
                ?>
                <div class="error">
                    <p class="text-danger">
                        <strong>Autoload ERROR:</strong>
                        <?php
                        printf(
                            '%s. %s',
                            esc_html( $exception->getMessage() ),
                            esc_html__( 'Please contact support if this issue persists.', 'woo-product-feed-pro' )
                        );
                        ?>
                    </p>
                </div>
                <?php
            }
        );
    }
}
