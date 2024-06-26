<?php

/**
 *
 */
class Functions {
    /**
     * Logs out the current user by destroying the session and clearing session cookies.
     *
     * @return void
     */
    public static function logout(): void {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
        session_unset();
        session_destroy();
        session_write_close();
    }

    /**
     * Encrypts the given text using AES-256-CBC encryption.
     *
     * @param string $text The text to be encrypted.
     * @return string The encrypted text.
     */
    public static function encrypt(string $text): string {
        $secret_key = 'CC6pxqR1nXZ213sk6Y4R';
        $key = hash('sha256', $secret_key);

        return openssl_encrypt($text, "AES-256-CBC", $key);
    }

    /**
     * Make an HTTP request to a specified URL with optional data and method.
     *
     * @param array  $data   The data to be sent in the request.
     * @param string $url    The URL to send the request to.
     * @param string $method The HTTP method for the request (default is "POST").
     *
     * @return string The response content from the HTTP request.
     */
    public static function httpRequest(array $data, string $url, string $method = "POST"): string {
        // use key 'http' even if you send the request to https://...
        $options = [
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => $method,
                "content" => http_build_query($data),
            ],
        ];

        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }

    /**
     * Checks with isset function for array of values for HTTP method
     * USAGE EXAMPLE: Functions::isset_values(["register","username","email"], $_POST)
     *
     * @return bool
     */
    public static function issetValues(array $datalist, array $method): bool {
        foreach ($datalist as $data) {
            if (!isset($method[$data])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Decrypts the given encrypted text using AES-256-CBC decryption.
     *
     * @param string $text The text to be decrypted.
     * @return string The decrypted text.
     */
    public static function decrypt(string $text): string {
        $secret_key = 'CC6pxqR1nXZ213sk6Y4R';
        $key = hash('sha256', $secret_key);

        return openssl_decrypt($text, "AES-256-CBC", $key);
    }

    /**
     * Appends a "Back" link to the given string, allowing users to navigate back using JavaScript.
     *
     * @param string $s The string to which the "Back" link is appended.
     * @return string The input string with the appended "Back" link.
     */
    public static function back(string $s): string {
        return $s . " <a href='javascript:history.back()'>back</a>";
    }

    /**
     * Checks if the current page matches the provided page name and returns an "active" class if they match.
     *
     * @param string $curr The name of the current page being compared.
     * @return string Returns an empty string if the current page doesn't match $curr; otherwise, returns "active".
     */
    public static function checkCurrent(string $curr): string {
        $page = ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME));
        $page = strtolower($page);

        if ($page == $curr) {
            return "active";
        }

        return "";
    }

    /**
     * Generates a CSRF token and stores it in the session for form submissions to prevent CSRF attacks.
     *
     * @return void
     */
    public static function generateCsrfToken(): void {
        $_SESSION["csrf_token"] = md5(uniqid(mt_rand(), true));
    }

    /**
     * Retrieves the stored CSRF token from the session for form submission validation.
     *
     * @return string The CSRF token.
     */
    public static function getCsrfToken(): string {
        return $_SESSION["csrf_token"];
    }
}