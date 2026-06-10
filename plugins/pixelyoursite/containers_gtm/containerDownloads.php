<?php

namespace PixelYourSite;
defined('ABSPATH') || exit;

/**
 * containerDownloads class.
 *
 */
abstract class containerDownloads
{
    private $containers_path;

    public function __construct($containers_path) {
        $this->containers_path = $containers_path;
    }

    /**
     * Gets list of allowed files for download from getContainers()
     *
     * @return array Array of filenames allowed for download
     */
    protected function getAllowedFiles() {
        $allowedFiles = [];
        $containers = $this->getContainers();

        foreach ($containers as $container) {
            if (isset($container['file_name']) && !empty($container['file_name'])) {
                $allowedFiles[] = $container['file_name'];
            }
        }

        return $allowedFiles;
    }

    /**
     * Abstract method that must be implemented in child classes
     * to return list of containers with their files
     *
     * @return array Array of containers with file information
     */
    abstract protected function getContainers();

    public function downloadContainerFile($file) {
        if (!current_user_can('manage_pys')) {
            return;
        }

        if (!$file) {
            http_response_code(404);
            echo "File not found.";
            return;
        }

        // Get list of allowed files from getContainers
        $allowedFiles = $this->getAllowedFiles();

        // Check if the requested file is in the allowed list
        if (!in_array($file, $allowedFiles)) {
            error_log("Unauthorized file download attempt: " . $file);
            http_response_code(403);
            echo "Access denied.";
            return;
        }

        // Additional filename sanitization to prevent path traversal
        $file = basename($file); // Remove any paths, keep only filename
        $file = $this->containers_path . $file;

        // Check if file exists and is in the allowed directory
        if (!file_exists($file) || !is_file($file)) {
            error_log("File not found: " . $file);
            http_response_code(404);
            echo "File not found.";
            return;
        }

        // Additional check that file is actually within containers_path
        $realPath = realpath($file);
        $realContainersPath = realpath($this->containers_path);

        if (!$realPath || !$realContainersPath || strpos($realPath, $realContainersPath) !== 0) {
            error_log("Path traversal attempt detected: " . $file);
            http_response_code(403);
            echo "Access denied.";
            return;
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));

        readfile($file);
        exit;
    }
}