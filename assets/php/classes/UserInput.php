<?php

class UserInput {
    /**
     * @param string $data
     * @return string
     */
    public static function sanitize(string $data): string {
        //returns a string with whitespace stripped from the beginning and end of string
        $data = trim($data);

        //Strip HTML and PHP tags from a string. This function tries to return a string with all NULL bytes, HTML, and PHP tags stripped from a given string
        $data = strip_tags($data);

        //Convert special characters to HTML entities. This is one of the famous methods to prevent XSS
        $data = htmlspecialchars($data);

        //NULL byte %00
        $data = str_replace(chr(0), '', $data);
        $data = str_replace("%00", "", $data);
        $data = str_replace("%0", "", $data);
        return str_replace("\0", "", $data);
    }
}