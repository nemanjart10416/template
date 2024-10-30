<?php

/**
 *
 */
class UserInput {
    /**
     * @param string $data
     * @return string
     */
    public static function sanitize(string $data): string {
        // Remove whitespace from the beginning and end of the string
        $data = trim($data);

        // Remove NULL bytes
        $data = preg_replace('/\x00/', '', $data);

        // Strip HTML and PHP tags from the string
        $data = strip_tags($data);

        // Convert special characters to HTML entities to prevent XSS attacks
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    public static function sanitizeJs(string $str): string {
        return json_encode($str, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
    }
}