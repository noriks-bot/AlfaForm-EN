<?php

namespace PixelYourSite;
defined('ABSPATH') || exit;

/**
 * PYS_Logger class.
 *
 */
class PYS_Logger
{

    protected $isEnabled = false;
    /**
     * Stores open file handles.
     */
    protected $handle = null;

	protected $log_path = null;

    /**
     * Option name for storing log file random suffix
     */
    const LOG_SUFFIX_OPTION = 'pys_free_log_file_suffix';

	public function __construct( ) {
		$this->log_path = trailingslashit( PYS_FREE_PATH ).'logs/';
	}

    public function init() {
        $this->isEnabled = PYS()->getOption('pys_logs_enable');

        // Migrate old log files to new randomized names (one-time operation)
        $this->maybe_migrate_log_files();

        // Always ensure protection files exist, regardless of logging being enabled
        // This prevents PII exposure even if logs were created before and logging is now disabled
        $this->create_protection_files();
    }

    /**
     * Get or generate random suffix for log file names
     * This suffix is stored in WordPress options and persists across requests
     *
     * @return string Random suffix (32 characters hex string)
     */
    public static function get_log_suffix() {
        $suffix = get_option( self::LOG_SUFFIX_OPTION );

        if ( empty( $suffix ) ) {
            $suffix = self::generate_random_suffix();
            update_option( self::LOG_SUFFIX_OPTION, $suffix, false );
        }

        return $suffix;
    }

    /**
     * Generate a cryptographically secure random suffix
     *
     * @return string Random suffix (32 characters hex string)
     */
    protected static function generate_random_suffix() {
        if ( function_exists( 'wp_generate_password' ) ) {
            // Use WordPress function for better compatibility
            return wp_hash( wp_generate_password( 32, true, true ) . time() . wp_rand() );
        }

        // Fallback to PHP random_bytes
        return bin2hex( random_bytes( 16 ) );
    }

    /**
     * Migrate old log files to new randomized names
     * This runs once when the suffix doesn't exist yet
     *
     * @return void
     */
    protected function maybe_migrate_log_files() {
        // Check if migration is needed (suffix option doesn't exist)
        $suffix = get_option( self::LOG_SUFFIX_OPTION );

        if ( ! empty( $suffix ) ) {
            // Already migrated
            return;
        }

        // Generate new suffix
        $new_suffix = self::generate_random_suffix();
        update_option( self::LOG_SUFFIX_OPTION, $new_suffix, false );

        // Migrate existing log files
        $this->migrate_log_file( 'pys_debug.log', 'pys_debug_' . $new_suffix . '.log' );
    }

    /**
     * Rename a log file from old name to new name
     *
     * @param string $old_name Old file name
     * @param string $new_name New file name
     * @return bool True if renamed successfully or file didn't exist
     */
    protected function migrate_log_file( $old_name, $new_name ) {
        $old_path = $this->log_path . $old_name;
        $new_path = $this->log_path . $new_name;

        if ( file_exists( $old_path ) && is_writable( $old_path ) ) {
            return @rename( $old_path, $new_path );
        }

        return true;
    }

    /**
     * Destructor.
     *
     * Cleans up open file handles.
     */
    public function __destruct() {
        if ( is_resource( $this->handle ) ) {
            fclose( $this->handle ); // @codingStandardsIgnoreLine.
        }
    }

    public function debug($message,$args = null) {
        $this->log('debug',$message,$args);
    }

    public function error($message,$args = null) {
        $this->log('error',$message,$args);
    }

    protected function log($level,$message,$args = null) {
        if(!$this->isEnabled) return;
        if($args) {
            $message .= " \nArgs: ".print_r($args,true);
        }
        $this->handle(time(),$level,$message,[]);
    }

    /**
     * Handle a log entry.
     *
     * @param int    $timestamp Log timestamp.
     * @param string $level emergency|alert|critical|error|warning|notice|info|debug.
     * @param string $message Log message.
     * @param array  $context {
     *      Additional information for log handlers.
     * }
     *
     * @return bool False if value was not handled and true if value was handled.
     */
    protected function handle( $timestamp, $level, $message, $context ) {

        $time_string = date( 'c', $timestamp );
        $entry = "{$time_string} {$level} {$message}";

        return $this->add( $entry );
    }

    /**
     * Open log file for writing.
     *
     * @param string $mode Optional. File mode. Default 'a'.
     * @return bool Success.
     */
    protected function open(  $mode = 'a' ) {
        if ( $this->is_open() ) {
            return true;
        }

        $file = static::get_log_file_path(  );

        if ( $file ) {
            if ( ! file_exists( $file ) ) {
                if( !is_dir( $this->log_path ) ) {
                    if (!mkdir($concurrentDirectory = $this->log_path, 0755, true) && !is_dir($concurrentDirectory)) {
                        throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                    }
                }
                $temphandle = @fopen( $file, 'w+' ); // @codingStandardsIgnoreLine.
                if ( is_resource( $temphandle ) ) {
                    @fclose( $temphandle ); // @codingStandardsIgnoreLine.
                    if ( ! defined( 'FS_CHMOD_FILE' ) ) {
                        define( 'FS_CHMOD_FILE', 0644 );
                    }
                    @chmod( $file, FS_CHMOD_FILE ); // @codingStandardsIgnoreLine.
                }
            }

            $resource = @fopen( $file, $mode ); // @codingStandardsIgnoreLine.

            if ( $resource ) {
                $this->handle = $resource;
                return true;
            }
        }

        return false;
    }

    /**
     * Create protection files (.htaccess and index.php) in logs directory
     * to prevent direct access to log files
     *
     * @return void
     */
    protected function create_protection_files() {
        if ( ! is_dir( $this->log_path ) ) {
            return;
        }

        // Create .htaccess file to deny access
        $htaccess_file = $this->log_path . '.htaccess';
        if ( ! file_exists( $htaccess_file ) ) {
            $htaccess_content = "# Deny access to all files in this directory\n";
            $htaccess_content .= "# Apache 2.4+\n";
            $htaccess_content .= "<IfModule authz_core_module>\n";
            $htaccess_content .= "    Require all denied\n";
            $htaccess_content .= "</IfModule>\n\n";
            $htaccess_content .= "# Apache 2.2\n";
            $htaccess_content .= "<IfModule !authz_core_module>\n";
            $htaccess_content .= "    Deny from all\n";
            $htaccess_content .= "</IfModule>\n";

            @file_put_contents( $htaccess_file, $htaccess_content );
            @chmod( $htaccess_file, 0644 );
        }

        // Create index.php file to prevent directory listing
        $index_file = $this->log_path . 'index.php';
        if ( ! file_exists( $index_file ) ) {
            $index_content = "<?php\n// Silence is golden.\n";
            @file_put_contents( $index_file, $index_content );
            @chmod( $index_file, 0644 );
        }
    }

    /**
     * Get a log file path.
     *
     * @return string The log file path or false if path cannot be determined.
     */
    public static function get_log_file_path( ) {
        return trailingslashit( PYS_FREE_PATH ).'logs/' . static::get_log_file_name( );
    }
    public static function get_log_file_url( ) {

        return trailingslashit( PYS_FREE_URL ) .'logs/'. static::get_log_file_name( );
    }

	public function downloadLogFile() {
        if ( ! current_user_can( 'manage_pys' ) ) {
            return;
        }
		$file = static::get_log_file_path();
		if ($file) {

			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));

            if (file_exists($file)) {
                readfile($file);
            } else {
                error_log("File not found: " . $file);
            }
			exit;
		} else {
			http_response_code(404);
			echo "File not found.";
		}
	}

    /**
     * Get a log file name.
     *
     * File names consist of the handle, followed by a random suffix, .log.
     * The random suffix prevents direct access to log files on Nginx servers.
     *
     * @return string The log file name.
     */
    public static function get_log_file_name( ) {
        return 'pys_debug_' . self::get_log_suffix() . '.log';
    }

    /**
     * Check if a handle is open.
     *
     * @return bool True if $handle is open.
     */
    protected function is_open( ) {
        return is_resource( $this->handle );
    }

    /**
     * Close a handle.
     *
     * @return bool success
     */
    protected function close() {
        $result = false;

        if ( $this->is_open() ) {
            $result = fclose( $this->handle ); // @codingStandardsIgnoreLine.
            $this->handle = null;
        }

        return $result;
    }

    /**
     * Add a log entry to chosen file.
     *
     * @param string $entry Log entry text.
     *
     * @return bool True if write was successful.
     */
    protected function add( $entry ) {
        $result = false;

        if ( $this->open() && is_resource( $this->handle ) ) {
            $result = fwrite( $this->handle, $entry . PHP_EOL ); // @codingStandardsIgnoreLine.
        }

        return false !== $result;
    }

    public function getLogs( ) {
        if(is_file( static::get_log_file_path() ))
            return file_get_contents(static::get_log_file_path());
        return "";
    }

    /**
     * Remove/delete the chosen file.
     *
     * @return bool
     */
    public function remove( )
    {
        if ( ! current_user_can( 'manage_pys' ) ) {
            return;
        }
        $removed = false;
        $file = realpath($this::get_log_file_path());
        if (is_file($file) && is_writable($file)) { // phpcs:ignore WordPress.VIP.FileSystemWritesDisallow.file_ops_is_writable
            $this->close(); // Close first to be certain no processes keep it alive after it is unlinked.
            $removed = unlink($file); // phpcs:ignore WordPress.VIP.FileSystemWritesDisallow.file_ops_unlink
        }

        return $removed;
    }
}