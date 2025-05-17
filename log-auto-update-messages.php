<?php

/*
 * Plugin Name: Log auto-update messages
 * Plugin URI: https://github.com/szepeviktor/wordpress-auto-updates
 */

add_action(
    'automatic_updates_complete',
    static function ($updateResults) {
        error_log('Automatic update results: '.var_export($updateResults, true));
    },
    10,
    1
);

/*
// The debug email does not contain all messages.
add_filter(
    'automatic_updates_send_debug_email',
    '__return_true',
    10,
    0
);
*/
