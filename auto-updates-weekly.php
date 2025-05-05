<?php

/*
 * Plugin Name: Reschedule auto-updates to an off-peak hour of the week
 * Description: Benefit from not installing each version 
 * Plugin URI: https://github.com/szepeviktor/wordpress-auto-updates
 */

/*
Remove currently scheduled events.

wp cron event delete wp_version_check
wp cron event delete wp_update_plugins
wp cron event delete wp_update_themes
*/

add_action(
    'plugins_loaded',
    static function () {
        // Originally scheduled "twicedaily"
        remove_action('init', 'wp_schedule_update_checks');
        add_action(
            'init',
            static function () {
                $next_run = (int)date('H') < 3 ? strtotime('today 03:10:30') : strtotime('next day 03:10:30');
                $recurrence = 'weekly';
                if (! wp_next_scheduled('wp_version_check') && ! wp_installing()) {
                    wp_schedule_event($next_run, $recurrence, 'wp_version_check');
                }
                if (! wp_next_scheduled('wp_update_plugins') && ! wp_installing()) {
                    wp_schedule_event($next_run, $recurrence, 'wp_update_plugins');
                }
                if (! wp_next_scheduled('wp_update_themes') && ! wp_installing()) {
                    wp_schedule_event($next_run, $recurrence, 'wp_update_themes');
                }
            }
        );
    },
    10,
    0
);
