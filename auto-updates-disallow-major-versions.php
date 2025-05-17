<?php

/*
 * Plugin Name: Disallow auto-updates to new major version
 * Plugin URI: https://github.com/szepeviktor/wordpress-auto-updates
 */

add_filter(
    'auto_update_plugin',
    static function ($update, $item) {
        if (empty($item->response) || $item->response !== 'update') {
            return $update;
        }

        $current_major_version = strstr($item->version, '.', true);
        $new_major_version = strstr($item->new_version, '.', true);
        if ($new_major_version !== $current_major_version) {
            return false;
        }

        return $update;
    },
    10,
    2
);
