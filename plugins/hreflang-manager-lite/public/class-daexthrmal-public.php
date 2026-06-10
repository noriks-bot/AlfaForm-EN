<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package hreflang-manager-lite
 */

/**
 * This class should be used to work with the public side of WordPress.
 */
class Daexthrmal_Public {

	/**
	 * The singleton instance of the class.
	 *
	 * @var Daexthrmal_Shared
	 */
	protected static $instance = null;

	/**
	 * An instance of the shared class.
	 *
	 * @var Daexthrmal_Shared|null
	 */
	private $shared = null;

	/**
	 * Constructor.
	 */
	private function __construct() {

		// Assign an instance of the plugin info.
		$this->shared = Daexthrmal_Shared::get_instance();

		// Write in front-end head.
		add_action( 'wp_head', array( $this, 'set_hreflang' ) );

		// Prints the log HTML before the closing body tag on the front end.
		add_action( 'wp_footer', array( $this, 'generate_log' ) );

		// Enqueue styles.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		// Load public js.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	/**
	 * Create an instance of this class.
	 *
	 * @return self|null
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Write the connections in the 'head' section of the page.
	 *
	 * @return void
	 */
	public function set_hreflang() {

		// Echo the hreflang connections in the 'head' section of the page.
		$this->shared->echo_hreflang_output( 'page_html' );
	}

	/**
	 * Write the log with the connections.
	 *
	 * @return void
	 */
	public function generate_log() {

		/**
		 * Don't show the tag inspector if:
		 *
		 * - The current user has no edit_others_posts capabilities
		 * - The Tag Inspector is not enabled.
		 */
		if ( ! current_user_can( 'edit_others_posts' ) ||
		     ( 1 !== intval( get_option( 'daexthrmal_show_log' ), 10 ) ) ||
		     ! $this->shared->has_valid_hreflang_tags()
		) {
			return;
		}

		// Echo the log UI element that includes the connections.

		?>

		<div id="daexthrmal-tag-inspector__wrapper" class="daexthrmal-tag-inspector__wrapper">
			<div class="daexthrmal-tag-inspector__header">
				<div class="daexthrmal-tag-inspector__header-wrapper">
					<div class="daexthrmal-tag-inspector__header-wrapper-left">
						<?php $this->shared->echo_icon_svg( 'drag-handle' ); ?>
						<div class="daexthrmal-tag-inspector__title"><?php esc_html_e('Tag Inspector', 'hreflang-manager-lite'); ?></div>
					</div>
					<div class="daexthrmal-tag-inspector__header-wrapper-right">
						<div id="daexthrmal-tag-inspector__header-wrapper-right-expand" class="daexthrmal-tag-inspector__header-wrapper-right-expand daexthrmal-tag-inspector__header-wrapper-right-expand-hidden">
							<?php $this->shared->echo_icon_svg( 'chevron-down' ); ?>
						</div>
						<div id="daexthrmal-tag-inspector__header-wrapper-right-collapse" class="daexthrmal-tag-inspector__header-wrapper-right-collapse">
							<?php $this->shared->echo_icon_svg( 'chevron-up' ); ?>
						</div>
					</div>
				</div>
			</div>
			<div id="daexthrmal-tag-inspector__content" class="daexthrmal-tag-inspector__content">
				<div id="daexthrmal-tag-inspector__table-view">
					<table>
						<thead>
						<tr>
							<th><?php esc_html_e( 'Language/Locale', 'hreflang-manager-lite' ); ?></th>
							<th><?php esc_html_e( 'URL', 'hreflang-manager-lite' ); ?></th>
						</tr>
						</thead>
						<tbody>
						<?php
						$this->shared->echo_table_view();
						?>
						</tbody>
					</table>
				</div>
				<div id="daexthrmal-tag-inspector__tag-view">
					<pre id="tag-view-pre"><?php $this->shared->echo_hreflang_output( 'tag_inspector' ); ?></pre>
				</div>
			</div>
			<div id="daexthrmal-tag-inspector__footer" class="daexthrmal-tag-inspector__footer">
				<div class="daexthrmal-tag-inspector__controls">
					<button id="daexthrmal-tag-inspector__table-view-btn" class="daexthrmal-tag-inspector__table-view-btn daexthrmal-tag-inspector__table-view-btn-active"><?php esc_html_e('Table View', 'hreflang-manager-lite'); ?></button>
					<button id="daexthrmal-tag-inspector__tag-view-btn" class="daexthrmal-tag-inspector__tag-view-btn"><?php esc_html_e('Tag View', 'hreflang-manager-lite'); ?></button>
				</div>
			</div>
		</div>

		<?php
	}

	/**
	 * Enqueue styles.
	 *
	 * @return void
	 */
	public function enqueue_styles() {

		// Enqueue the style used to show the log if the current user has the edit_others_posts capability and if the log is enabled.
		if ( current_user_can( 'edit_others_posts' ) && 1 === ( intval( get_option( 'daexthrmal_show_log' ), 10 ) ) ) {

			wp_enqueue_style(
				$this->shared->get( 'slug' ) . '-tag-inspector',
				$this->shared->get( 'url' ) . 'public/assets/css/tag-inspector.css',
				array(),
				$this->shared->get( 'ver' )
			);

		}
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {

		// Enqueue the script used to handle the tag inspector if the current user has the edit_others_posts capability and if the tag inspector is enabled.
		if ( current_user_can( 'edit_others_posts' ) && 1 === ( intval( get_option( 'daexthrmal_show_log' ), 10 ) ) ) {
			wp_enqueue_script(
				$this->shared->get( 'slug' ) . '-tag-inspector',
				$this->shared->get( 'url' ) . 'public/assets/js/tag-inspector.js',
				array(),
				$this->shared->get( 'ver' ),
				true
			);
		}

	}

}