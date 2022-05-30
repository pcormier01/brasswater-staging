<?php 
if( ! defined('WP_UNINSTALL_PLUGIN') ) exit;

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}mdf_query_cache");
//$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}mdf_stat_buffer");
//$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}mdf_stat_tmp");
//die();

