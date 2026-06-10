<?php

namespace PixelYourSite;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class OptinNotice
{
    private static $_instance;
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;

    }
    public function __construct() {
        add_action( 'init', [$this,'init'] );
    }

    function init() {
        global $pagenow;
        if ( ! current_user_can( 'manage_pys' ) ) {
            return;
        }
        // Exclude display of notifications on the update.php screen
        if ( $pagenow === 'update.php' ) {
            return;
        }

        $this->checkEnqueueStyles();

        add_action( 'wp_ajax_pys_optin_add',  [$this,'pys_optin_add']);
        add_action( 'wp_ajax_nopriv_pys_optin_add', [$this,'pys_optin_add']);
        add_action( 'admin_notices', [$this,'adminRenderOptinNotices'], 1 );



    }

    function pys_optin_add()
    {
        $body = array(
            'action'  => 'optin_add',
            'data'  => $_POST
        );

        $response = wp_remote_post( 'https://www.pixelyoursite.com', array(
            'timeout'   => 30,
            'sslverify' => false,
            'user-agent' => 'PixelYourSite/' . PYS_FREE_VERSION . '; ' . get_bloginfo( 'url' ),
            'body'      => $body
        ) );


        if (is_wp_error($response)) {
            wp_send_json_error(null, 420);
        } else {
            $body = wp_remote_retrieve_body($response);
            $decoded_body = json_decode($body, true); // Decode the body to an array
            if (isset($decoded_body['data'])) {
                wp_send_json_success($decoded_body['data']); // Return only the 'data' part
            } else {
                wp_send_json_error('Invalid response format', 422);
            }
        }
    }
    function adminRenderOptinNotices() {

        $user = wp_get_current_user();
        $user_id = $user->ID;

        // never show again for opted-in users
        if ( get_option( 'pys_core_opted_in_dismissed_at' ) || get_user_meta( $user_id, 'pys_core_opted_in_dismissed_at', true ) ) {
            return;
        }

        $first_time_dismissed_at = get_option( 'pys_core_optin_first_time_dismissed_at' ) ?? get_user_meta( $user_id, 'pys_core_optin_first_time_dismissed_at', true );
        $second_time_dismissed_at = get_option( 'pys_core_optin_second_time_dismissed_at' ) ?? get_user_meta( $user_id, 'pys_core_optin_second_time_dismissed_at', true );

        if ($second_time_dismissed_at) {
            /*$month_ago = time() - MONTH_IN_SECONDS;

            if ( $month_ago < $second_time_dismissed_at ) {
                return;
            }

            $header = 'Free PIXELYOURSITE HACKS: Improve your ads return and website tracking - LAST CALL';
            $dismiss_key = 'optin_third_time';*/
            return;
        }

        if ( $first_time_dismissed_at ) {
            $week_ago = time() - WEEK_IN_SECONDS;

            if ( $week_ago < $first_time_dismissed_at ) {
                return; // hide if dismissed less then week ago
            }

            $header = 'PIXELYOURSITE HACKS: Improve your ads return and website tracking with FREE Facebook, Google and Pinterest hacks';
            $dismiss_key = 'optin_second_time';

        } else { // was never dismissed
            $header = 'Free PIXELYOURSITE HACKS: Improve your ads return and website tracking';
            $dismiss_key = 'optin_first_time';
        }



        ?>


        <div class="is-dismissible notice notice-info pys-fixed-notice pys-optin-notice pys-notice-wrapper notice-color-blue">
            <img src="<?php echo PYS_FREE_URL . '/dist/images/logo-original.svg'; ?>" class="pys-notice-logo">
            <div class="pys-notice-content">
                <h4><?php echo $header; ?></h4>
                <form>
                    <div class="pys-notice-form-group">
                        <input type="text" name="name" placeholder="Your name"
                               value="<?php echo esc_attr( $user->first_name ); ?>">
                    </div>
                    <div class="pys-notice-form-group">
                        <input type="email" name="email" required
                               placeholder="Your e-mail" value="<?php echo esc_attr( $user->user_email ); ?>">
                    </div>
                    <?php if ( isWooCommerceActive() ) : ?>
                        <div class="pys-notice-form-group">
                            <div class="small-checkbox">
                                <input type="checkbox" id="optin_tag_woo" name="tag[]" checked
                                       value="with-woo"
                                       class="small-control-input">
                                <label class="small-control small-checkbox-label" for="optin_tag_woo">
                                    <span class="small-control-indicator"><i class="icon-check"></i></span>
                                    <span class="small-control-description"><?php echo __('I use WooCommerce', 'pys'); ?></span>
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ( isEddActive() ) : ?>
                        <div class="pys-notice-form-group">
                            <div class="small-checkbox">
                                <input type="checkbox" id="optin_tag_edd" name="tag[]" checked
                                       value="with-edd"
                                       class="small-control-input">
                                <label class="small-control small-checkbox-label" for="optin_tag_edd">
                                    <span class="small-control-indicator"><i class="icon-check"></i></span>
                                    <span class="small-control-description"><?php echo __('I use Easy Digital Downloads', 'pys'); ?></span>
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="pys-notice-form-group">
                        <button class="btn btn-primary btn-primary-type">SEND ME FREE HACKS</button>
                    </div>
                </form>
                <div class="pys-notice-form-group">
                    <small class="pys-form-text">No spam. You can unsubscribe at any time.</small>
                </div>
            </div>
            <button type="button" class="btn notice-dismiss custom-dismiss-button"><span class="screen-reader-text"><i class="icon-delete"></i></span></button>
        </div>

        <script type="application/javascript">
            jQuery(document).on('click', '.pys-optin-notice .notice-dismiss', function () {
                var $container = jQuery(this);
                jQuery.ajax({
                    url: ajaxurl,
                    data: {
                        action: 'pys_notice_dismiss',
                        nonce: '<?php echo esc_attr( wp_create_nonce( 'pys_notice_dismiss' ) ); ?>',
                        user_id: '<?php echo esc_attr( $user_id ); ?>',
                        addon_slug: 'core',
                        meta_key: '<?php echo esc_attr( $dismiss_key ); ?>'
                    },
                    beforeSend: function () {
                        $container.closest('.pys-notice-wrapper').fadeOut();
                    },
                    success: function (resp) {
                        if (resp.success) {
                            console.log(resp)
                        }
                    }
                })
            });

            jQuery(document).on('submit', '.pys-optin-notice form', function (e) {
                e.preventDefault();

                var $form = jQuery(this),
                    name = $form.find('input[name="name"]').val(),
                    email = $form.find('input[name="email"]').val(),
                    $tags = $form.find('input[name="tag[]"]:checked'),
                    tags = [];

                $tags.each(function (i, elem) {
                    tags.push(jQuery(elem).val());
                });

                jQuery.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    crossDomain: true,
                    data: {
                        action: 'pys_optin_add',
                        name: name,
                        email: email,
                        tags: tags
                    },
                    beforeSend: function () {
                        $form.find('input, button').attr('disabled', true);
                    },
                    success: function (resp) {
                        $form.closest('.pys-notice-wrapper').fadeOut();
                        if (resp.success) {
                            setOptedInMeta();
                        }
                    }
                });

                var setOptedInMeta = function () {
                    jQuery.ajax({
                        url: ajaxurl,
                        method: 'POST',
                        data: {
                            action: 'pys_notice_dismiss',
                            nonce: '<?php echo esc_attr( wp_create_nonce( 'pys_notice_dismiss' ) ); ?>',
                            user_id: '<?php echo esc_attr( $user_id ); ?>',
                            addon_slug: 'core',
                            meta_key: 'opted_in'
                        }
                    });
                };
            });
        </script>

        <?php
    }
    private function checkEnqueueStyles() {
        if ( ! wp_style_is( 'pys_notice' ) ) {
            wp_enqueue_style( 'pys_notice', PYS_FREE_URL . '/dist/styles/notice.min.css', array(), PYS_FREE_VERSION );
        }
    }
}

/**
 * @return OptinNotice
 */
function OptinNotice() {
    return OptinNotice::instance();
}

OptinNotice();

