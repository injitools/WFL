<?php
/**
 * Class Response
 *
 * Response helper
 */

class Response {
    /**
     * Stop php script and redirect user
     *
     * @param string $href
     * @param string $text
     * @param string $status
     */
    public static function redirect($href, $text = '', $status = 'info') {
        if ($href === null) {
            $href = $_SERVER['REQUEST_URI'];
        }
        if ($text) {
            Msg::add($text, $status);
        }
        if (!headers_sent()) {
            header("Location: {$href}");
        } else {
            echo '\'"><script>window.location="' . $href . '";</script>';
        }
        echo "Перенаправление на: <a href = '{$href}'>{$href}</a>";
        exit();
    }
}