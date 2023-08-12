<?php

class Functions {
    /**
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
     * @param string $text
     * @return string
     */
    public static function encrypt(string $text): string {
        $secret_key = 'CC6pxqR1nXZ213sk6Y4R';
        $key = hash('sha256', $secret_key);

        return openssl_encrypt($text, "AES-256-CBC", $key);
    }

    /**
     * @param string $text
     * @return string
     */
    public static function decrypt(string $text): string {
        $secret_key = 'CC6pxqR1nXZ213sk6Y4R';
        $key = hash('sha256', $secret_key);

        return openssl_decrypt($text, "AES-256-CBC", $key);
    }

    /**
     * @param string $s
     * @return string
     */
    public static function nazad(string $s): string {
        return $s . " <a href='javascript:history.back()'>nazad</a>";
    }

    /**
     * @param string $curr
     * @return string
     */
    public static function check_current(string $curr): string {
        $page = ucfirst(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME));
        $page = strtolower($page);

        if ($page == $curr) {
            return "active";
        }

        return "";
    }

    /**
     * @return void
     */
    public static function generate_csrf_token(): void {
        $_SESSION["csrf_token"] = md5(uniqid(mt_rand(), true));
    }

    /**
     * @return string
     */
    public static function get_csrf_token(): string {
        return $_SESSION["csrf_token"];
    }
}