<?php

if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) exit();

// delete plugin options
delete_option('elfsight_instagram_feed_other_products_hidden');
delete_option('elfsight_instagram_feed_latest_version');
delete_option('elfsight_instagram_feed_last_check_datetime');

?>
