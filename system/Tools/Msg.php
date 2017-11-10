<?php

/**
 * Class Msg
 *
 * Simple alerts storage
 */
class Msg {
    /**
     * Add alert to storage
     *
     * @param string $text
     * @param string $status
     * @return bool
     */
    public static function add($text = 'Message', $status = 'info') {
        $_SESSION['_msgs'][] = [
            'text' => $text,
            'status' => $status,
        ];
        return true;
    }
}