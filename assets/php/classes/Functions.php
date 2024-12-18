<?php

/**
 *
 */
class Functions {
    /**
     * Checks if an IP address has exceeded the allowed number of attempts within a given time frame.
     *
     * @param string $ip The IP address to check for rate limiting.
     * @param int $limit The maximum number of allowed attempts within the time frame. Default is 5.
     * @param int $timeFrame The time frame in minutes to monitor the attempts. Default is 10 minutes.
     *
     * @return bool Returns true if the IP has not exceeded the limit; otherwise, returns false.
     */
    public static function checkRateLimit(string $ip, int $limit = 5, int $timeFrame = 10): bool
    {
        $result = Connection::getP("SELECT rl_attempts, rl_last_attempt FROM rate_limits_rl WHERE rl_ip = ?", [$ip]);

        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            // Calculate the time elapsed since the last attempt
            $timeElapsed = time() - strtotime($result['rl_last_attempt']);

            // If the time elapsed is greater than the specified time frame, reset the attempt counter
            if ($timeElapsed > $timeFrame * 60) {
                // Update the record to reset attempts and set the last attempt time to now
                Connection::setP("UPDATE rate_limits SET attempts = 1, last_attempt = NOW() WHERE ip = ?", [$ip]);
            } else {
                // If the number of attempts exceeds the limit, return false to block further actions
                if ($result['rl_attempts'] >= $limit) {
                    return false;
                }
                Connection::setP("UPDATE rate_limits_rl SET rl_attempts = rl_attempts + 1 WHERE rl_ip = ?", [$ip]);
            }
        } else {
            Connection::setP("INSERT INTO rate_limits_rl (rl_ip, rl_attempts, rl_last_attempt) VALUES (?, 1, NOW())", [$ip]);
        }

        // If the IP has not exceeded the limit, return true to allow the action
        return true;
    }

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
     * Uploads an image to the specified directory with validation.
     *
     * @param array $image The image file from $_FILES.
     * @return array An array with 'success' (boolean) and 'message' or 'filePath'.
     */
    public static function uploadImage(array $image): array
    {
        $targetDir = "../assets/img/";

        // Ensure the directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Get file details
        $fileName = basename($image["name"]);
        $fileName = preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $fileName); // Sanitize file name
        $returnFileName = uniqid('', true) . '_' . $fileName;
        $targetFilePath = $targetDir . $returnFileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allowed file types
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($fileType, $allowedTypes)) {
            return ['success' => false, 'message' => "Only JPG, JPEG, PNG, GIF, and WEBP files are allowed."];
        }

        // Check if file is a valid image
        $check = getimagesize($image["tmp_name"]);
        if ($check === false) {
            return ['success' => false, 'message' => "File is not a valid image."];
        }

        // Limit file size (example: max 2MB)
        if ($image["size"] > 2 * 1024 * 1024) {
            return ['success' => false, 'message' => "File size exceeds the 2MB limit."];
        }

        // Attempt to move the uploaded file
        if (move_uploaded_file($image["tmp_name"], $targetFilePath)) {
            return ['success' => true, 'filePath' => htmlspecialchars($returnFileName)];
        } else {
            return ['success' => false, 'message' => "Error: There was an issue uploading your file."];
        }
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
            if (!isset($method[$data]) || empty($data)) {
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