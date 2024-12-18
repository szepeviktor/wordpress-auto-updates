<?php

/*
 * Plugin Name: Reschedule auto-updates to once a month
 * Description: Benefit from not installing each version
 * Plugin URI: https://github.com/szepeviktor/wordpress-auto-updates
 */

add_action(
    'plugins_loaded',
    static function () {
        add_filter(
            'cron_schedules',
            static function ($schedules) {
                $schedules['monthly'] = ['interval' => MONTH_IN_SECONDS, 'display' => __('Once Monthly')];
                return $schedules;
            },
            10,
            1
        );
        // Originally scheduled "twicedaily"
        remove_action('init', 'wp_schedule_update_checks');
        add_action(
            'init',
            static function () {
                $next_run = time();
                $recurrence = 'monthly';
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
