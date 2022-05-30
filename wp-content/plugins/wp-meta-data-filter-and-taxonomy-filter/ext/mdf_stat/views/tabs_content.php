<?php
if (!defined('ABSPATH'))
    die('No direct access allowed');
?>

<p>
<table class="form-table">
    <tbody>
        <tr valign="top">
            <th scope="row"><label><?php _e('Notice:', 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
            <td>
                <a href="https://wp-filter.com/extension/statistic/" class="button" target="_blank"><?php echo __('Read How to use here', 'wp-meta-data-filter-and-taxonomy-filter') ?></a>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <a href="javascript:void(0);" id="mdf_show_stat_options"  class="button"><?php _e('Show/Hide statistic options', 'wp-meta-data-filter-and-taxonomy-filter') ?></a>
            </th>
            <td>
                <p class="description" style="color:red;">
                    <?php
                    $is_enabled = 0;
                    if (isset($data['stat_is_enabled'])) {
                        $is_enabled = $data['stat_is_enabled'];
                    }
                    $stat_activated_mode = array(
                        0 => __('Disabled', 'wp-meta-data-filter-and-taxonomy-filter'),
                        1 => __('Enabled', 'wp-meta-data-filter-and-taxonomy-filter')
                    );

                    if (!$is_enabled) {
                        _e('Statistics collection is not enabled. Click on the previous button to see activation drop-down and DataBase options.', 'wp-meta-data-filter-and-taxonomy-filter');
                    }
                    ?>
                </p>
            </td>
        </tr>

        <tr valign="top" class="mdf_stat_option">
            <th scope="row"><label><?php _e("Statistic", 'wp-meta-data-filter-and-taxonomy-filter') ?>:</label></th>
            <td>               

                <select name="meta_data_filter_settings[stat_is_enabled]">
                    <?php foreach ($stat_activated_mode as $key => $txt): ?>
                        <option <?php selected($is_enabled, $key) ?> value="<?php echo $key ?>"><?php echo $txt; ?></option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php _e('Should be enabled to start assembling.', 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
            </td>
        </tr>
        <!--+++++++++++++-->
        <tr valign="top" class="mdf_stat_option">
            <th scope="row"><label><?php _e("Server options for statistic", 'wp-meta-data-filter-and-taxonomy-filter') ?>:</label></th>
            <td>
                <?php
                if (!isset($data['server_options']) OR empty($data['server_options'])) {
                    $data['server_options'] = array(
                        'host' => '',
                        'host_db_name' => '',
                        'host_user' => '',
                        'host_pass' => '',
                    );
                }

                $server_options = $data['server_options'];
                if ($is_enabled AND (empty($server_options['host']) OR empty($server_options['host_user']) OR empty($server_options['host_db_name']) OR empty($server_options['host_pass']))) {
                    echo '<div class="error"><p class="description">' . sprintf(__('Statistic -> Statistic options -> "Stat server options" inputs should be filled in by right data, another way not possible to collect statistical data!', 'wp-meta-data-filter-and-taxonomy-filter')) . '</p></div>';
                }
                ?>


                <label style="margin-bottom: 5px; display: inline-block;"><?php _e('Host', 'wp-meta-data-filter-and-taxonomy-filter') ?></label>:
                <input type="text" class="regular-text" name="meta_data_filter_settings[server_options][host]" value="<?php echo $server_options['host'] ?>" /><br />
                <br />
                <label style="margin-bottom: 5px; display: inline-block;"><?php _e('User', 'wp-meta-data-filter-and-taxonomy-filter') ?></label>:
                <input type="text" class="regular-text" name="meta_data_filter_settings[server_options][host_user]" value="<?php echo $server_options['host_user'] ?>" /><br />
                <br />
                <label style="margin-bottom: 5px; display: inline-block;"><?php _e('DB Name', 'wp-meta-data-filter-and-taxonomy-filter') ?></label>:
                <input type="text" class="regular-text" name="meta_data_filter_settings[server_options][host_db_name]" value="<?php echo $server_options['host_db_name'] ?>" /><br />
                <br />
                <label style="margin-bottom: 5px; display: inline-block;"><?php _e('Password', 'wp-meta-data-filter-and-taxonomy-filter') ?></label>:
                <input type="text" class="regular-text" name="meta_data_filter_settings[server_options][host_pass]" value="<?php echo $server_options['host_pass'] ?>" /><br />
                <br/>
                <span id="mdf_stat_connection"  class="button"><?php _e('Check DB connection', 'wp-meta-data-filter-and-taxonomy-filter') ?></span>
                <p class="description"><?php _e('This data is very important for assembling statistics data, so please fill fields very responsibly. To collect statistical data uses a separate MySQL table.', 'wp-meta-data-filter-and-taxonomy-filter') ?>

                </p>
            </td>
        </tr>
        <!--+++++++++++++-->
        <tr valign="top" class="mdf_stat_option">
            <th scope="row"><label><?php _e("Collect Statistic for", 'wp-meta-data-filter-and-taxonomy-filter') ?>:</label></th>
            <td>
                <?php
                if (!isset($data['post_type_for_stat']) OR empty($data['post_type_for_stat']) OR ! is_array($data['post_type_for_stat'])) {
                    $data['post_type_for_stat'] = array();
                }
                if (is_array($data['post_types']) AND ! empty($data['post_types'])) {
                    ?>
                    <select multiple="" name="meta_data_filter_settings[post_type_for_stat][]"  class="chosen_select">
                        <?php foreach ($data['post_types'] as $post_t) { ?>
                            <option value="<?php echo $post_t ?>" <?php if (in_array($post_t, $data['post_type_for_stat'])): ?>selected="selected"<?php endif; ?>><?php echo $post_t ?></option>
                        <?php } ?>
                    </select><br />
                    <p class="description"><?php _e('Select taxonomies and metadata which you want to track for each post type.', 'wp-meta-data-filter-and-taxonomy-filter') ?></p>

                <?php } ?>
                <?php
                foreach ($data['post_type_for_stat'] as $post_type) {
                    ?>
                    <div class="mdf_stat_post_type">
                        <h4><?php
                            _e("Post type:", 'wp-meta-data-filter-and-taxonomy-filter');
                            echo $post_type
                            ?> </h4>
                        <?php
                        $all_items = array();
                        $taxonomies = MDF_SEARCH_STAT::get_all_taxonomies($post_type);
                        if (!empty($taxonomies)) {
                            foreach ($taxonomies as $slug => $t) {
                                $all_items[urldecode($slug)] = $t->labels->name;
                            }
                        }

                        asort($all_items);
                        if (!isset($data['items_for_stat'][$post_type]['tax']) OR empty($data['items_for_stat'][$post_type]['tax'])) {
                            $data['items_for_stat'][$post_type]['tax'] = array();
                        }
                        if (!isset($data['items_for_stat'][$post_type]['meta']) OR empty($data['items_for_stat'][$post_type]['meta'])) {
                            $data['items_for_stat'][$post_type]['meta'] = "";
                        }
                        $items_for_stat = (array) $data['items_for_stat'][$post_type]['tax'];
                        if (!empty($all_items)) {
                            ?>
                            <label><?php _e("Taxonomies:", 'wp-meta-data-filter-and-taxonomy-filter'); ?></label><br>
                            <select multiple="" name="meta_data_filter_settings[items_for_stat][<?php echo $post_type ?>][tax][]" class="chosen_select">
                                <?php foreach ($all_items as $key => $value) : ?>
                                    <option value="<?php echo $key; ?>" <?php if (in_array($key, $items_for_stat)): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                <?php endforeach; ?>
                            </select><br>
                        <?php } ?>
                        <label><?php _e("Meta data:", 'wp-meta-data-filter-and-taxonomy-filter'); ?></label><br>
                        <textarea class="regular-text" style="width: 100%; height: 150px;" name="meta_data_filter_settings[items_for_stat][<?php echo $post_type ?>][meta]" ><?php echo $data['items_for_stat'][$post_type]['meta'] ?></textarea>
                        <p class="description"><?php _e("Insert meta keys separated by end of line (press enter button).", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>


                    </div> <hr>
                    <?php
                }
                ?>
            </td>
        </tr>
        <!--+++++++++++++-->
        <tr valign="top" class="mdf_stat_option">
            <th scope="row"><label><?php _e('Max requests per unique user', 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
            <?php
            if (!isset($data['user_max_requests']) OR empty($data['user_max_requests'])) {
                $data['user_max_requests'] = 10;
            }
            $user_max_requests = intval($data['user_max_requests']);
            if ($user_max_requests <= 0) {
                $user_max_requests = 10;
            }
            ?>
            <td>
                <input type="text" class="regular-text" value="<?php echo $user_max_requests ?>" name="meta_data_filter_settings[user_max_requests]">
                <p class="description"><?php _e("How many search requests will be catched and written down into the statistical mySQL table per 1 unique user before cron will assemble the data ", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
            </td>
        </tr>
        <!--+++++++++++++-->
        <tr valign="top" class="mdf_stat_option">
            <th scope="row"><label><?php _e("Max deep of the search request", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
            <?php
            if (!isset($data['request_max_deep']) OR empty($data['request_max_deep'])) {
                $data['request_max_deep'] = 5;
            }
            $request_max_deep = intval($data['request_max_deep']);
            if ($request_max_deep <= 0) {
                $request_max_deep = 5;
            }
            ?>
            <td>
                <input type="text" class="regular-text" value="<?php echo $request_max_deep ?>" name="meta_data_filter_settings[request_max_deep]">
                <p class="description"><?php _e("How many taxonomies per one search request will be written down into the statistical mySQL table for 1 unique user. The excess data will be truncated! Number 5 is recommended. More depth - more space in the DataBase will be occupied by the data. ", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
            </td>
        </tr>

        <!--+++++++++++++-->
        <tr valign="top" class="mdf_stat_option">
            <th scope="row"><label><?php _e("How to assemble statistic", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
            <td>
                <?php
                $cron_systems = array(
                    0 => __('WordPress Cron', 'wp-meta-data-filter-and-taxonomy-filter'),
                    1 => __('External Cron', 'wp-meta-data-filter-and-taxonomy-filter')
                );

                if (!isset($data['cron_system'])) {
                    $data['cron_system'] = 0;
                }
                $cron_system = $data['cron_system'];
                ?>

                <select name="meta_data_filter_settings[cron_system]">
                    <?php foreach ($cron_systems as $key => $txt): ?>
                        <option <?php selected($cron_system, $key) ?> value="<?php echo $key ?>"><?php echo $txt; ?></option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php _e('Use WordPress Cron if your site has a lot of traffic, and external cron if the site traffic is not big. External cron is more predictable with time of execution, but additional knowledge how to set it correctly is required (<i style="color: orange;">External cron will be ready in the next version of the extension</i>)', 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
            </td>
        </tr>
        <!--+++++++++++++-->
        <tr valign="top" class="mdf_stat_option cron_sys_1" style="visibility: <?php echo($cron_system == 1 ? 'visible' : 'hidden') ?>;">
            <th scope="row"><label><?php _e("Secret key for external cron", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
            <?php
            if (!isset($data['cron_secret_key']) OR empty($data['cron_secret_key'])) {
                $data['cron_secret_key'] = 'mdtf_stat_updating';
            }
            $cron_secret_key = sanitize_title($data['cron_secret_key']);
            ?>

            <td>
                <input type="text" class="regular-text" value="<?php echo $data['cron_secret_key'] ?>" name="meta_data_filter_settings[cron_secret_key]">
                <p class="description"><?php printf(__("Enter any random text in the field and use it in the external cron with link like: %s", 'wp-meta-data-filter-and-taxonomy-filter'), get_site_url() . '?mdf_stat_collection=' . $data['cron_secret_key']) ?></p>
            </td>
        </tr>
        <!--+++++++++++++-->
        <tr valign="top" class="mdf_stat_option cron_sys_0"style="visibility: <?php echo($cron_system == 0 ? 'visible' : 'hidden') ?>;">
            <th scope="row">
                <label><?php _e("WordPress Cron period", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
            <td>
                <?php
                $wp_cron_periods = array(
                    'hourly' => __('hourly', 'wp-meta-data-filter-and-taxonomy-filter'),
                    'twicedaily' => __('twicedaily', 'wp-meta-data-filter-and-taxonomy-filter'),
                    'daily' => __('daily', 'wp-meta-data-filter-and-taxonomy-filter'),
                    'week' => __('weekly', 'wp-meta-data-filter-and-taxonomy-filter'),
                    'month' => __('monthly', 'wp-meta-data-filter-and-taxonomy-filter'),
                        //'min1' => __('min1', 'wp-meta-data-filter-and-taxonomy-filter')
                );

                if (!isset($data['wp_cron_period'])) {
                    $data['wp_cron_period'] = 'daily';
                }
                $wp_cron_period = $data['wp_cron_period'];
                ?>

                <select name="meta_data_filter_settings[wp_cron_period]">
                    <?php foreach ($wp_cron_periods as $key => $txt): ?>
                        <option <?php selected($wp_cron_period, $key) ?> value="<?php echo $key ?>"><?php echo $txt; ?></option>
                    <?php endforeach; ?>
                </select>
                <p class="description"><?php _e('12 hours recommended', 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
            </td>
        </tr>
        <!--+++++++++++++-->
        <tr valign="top" class="mdf_stat_option">
            <th scope="row"><label><?php _e("Max terms or taxonomies per graph", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
            <?php
            if (!isset($data['max_items_per_graph']) OR empty($data['max_items_per_graph'])) {
                $data['max_items_per_graph'] = 10;
            }
            $max_items_per_graph = intval($data['max_items_per_graph']);
            if ($max_items_per_graph <= 0) {
                $max_items_per_graph = 10;
            }
            ?>
            <td>
                <input type="text" class="regular-text" value="<?php echo $max_items_per_graph ?>" name="meta_data_filter_settings[max_items_per_graph]">
                <p class="description"><?php _e("How many taxonomies and terms to show on the graphs. Use no more than 10 to understand situation with statistical data", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
            </td>
        </tr>
        <!--+++++++++++++-->
        <?php global $wp_locale; ?>
        <tr valign="top" >
            <th scope="row"><label><?php _e("Select period:", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
            <td>
                <?php if (!empty($stat_min_date)): ?>
                    <div style="font-size: 12px; font-style: italic;"><?php printf(__('(Statistic collected from: %s %d)', 'wp-meta-data-filter-and-taxonomy-filter'), $wp_locale->get_month($stat_min_date[1]), $stat_min_date[0]) ?></div>
                <?php endif; ?>

                <input type="hidden" id="mdf_stat_calendar_from" value="0" />
                <input type="text" readonly="readonly" style="font-size: 1.2em;" class="regular-text mdf_stat_calendar mdf_stat_calendar_from" placeholder="<?php _e('From', 'wp-meta-data-filter-and-taxonomy-filter') ?>" />
                &nbsp;
                <input type="hidden" id="mdf_stat_calendar_to" value="0" />
                <input type="text" readonly="readonly" style="font-size: 1.2em;" class="regular-text mdf_stat_calendar mdf_stat_calendar_to" placeholder="<?php _e('To', 'wp-meta-data-filter-and-taxonomy-filter') ?>" /><br />

                <br />
                <p class="description"><?php _e("Select the time period for which you want to see statistical data", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
            </td>
        </tr>
        <!--+++++++++++++-->
        <tr valign="top" >
            <th scope="row"><label><?php _e("Statistical parameters:", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
            <td>
                <?php
                if (!empty($data['post_type_for_stat'])) {

                    $default_type = $data['post_type_for_stat'][0];
                    ?>
                    <select id="mdf_stat_post_type">
                        <?php foreach ($data['post_type_for_stat'] as $post_type): ?>
                            <option value="<?php echo $post_type ?>"<?php ($post_type == $default_type) ? "seleckted" : ""; ?>><?php echo $post_type ?></option>
                        <?php endforeach; ?>
                    </select><br />

                    <div id="mdf_stat_snipet_var">
                        <?php echo MDF_SEARCH_STAT::draw_tax_and_meta_var($default_type) ?>
                    </div>
                <?php } else {
                    ?> <p class="description"><?php _e("Choose post type in the statistics settings!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p> <?php }
                ?>
                <a href="javascript: mdf_stat_calculate();" class="button button-primary button-large"><?php _e('Calculate Statistics', 'wp-meta-data-filter-and-taxonomy-filter') ?></a><br />
                <p class="description"><?php _e('Select taxonomy(-ies) and/or meta_data (combination) OR leave this field empty to see general data for all the most requested taxonomies', 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
            </td>
        </tr>
        <!--+++++++++++++-->
        <tr valign="top" >
            <th scope="row"><label><?php _e("Graphics:", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
            <td>
                <div class="mdf-control mdf-upload-style-wrap" style="width: 100%;">

                    <ul id="mdf_stat_get_monitor"></ul>

                    <div id="mdf_stat_charts_list">
                        <!-- <a href="javascript: window.print();" id="woof_stat_print_btn" class="button button-primary"><?php _e('Print Graphs', 'wp-meta-data-filter-and-taxonomy-filter') ?></a> -->
                        <div id="chart_div_1" style="width: 100%; height: 600px;"></div>
                        <div id="chart_div_1_set" style="width: 100%; height: auto;"></div>
                        <!-- <div id="chart_div_2" style="width: 100%; height: 600px;"></div> -->
                    </div>

                </div>
                <!-- <div class="woof-description" style="width: 30%;">
                    <p class="description">
                <?php _e('xxx', 'wp-meta-data-filter-and-taxonomy-filter') ?>
                    </p>
                </div> -->
            </td>
        </tr>

        <!--+++++++++++++-->

        <?php
        global $wpdb;

        $charset_collate = '';
        if (method_exists($wpdb, 'has_cap') AND $wpdb->has_cap('collation')) {
            if (!empty($wpdb->charset)) {
                $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
            }
            if (!empty($wpdb->collate)) {
                $charset_collate .= " COLLATE $wpdb->collate";
            }
        }
//***
        $sql = "CREATE TABLE IF NOT EXISTS `{$table_stat_buffer}` (
                                    `id` int(11) NOT NULL AUTO_INCREMENT,
                                    `hash` text COLLATE utf8_unicode_ci NOT NULL,
                                    `user_ip` text COLLATE utf8_unicode_ci NOT NULL,
                                    `post_type` text COLLATE utf8_unicode_ci NOT NULL,
                                    `type` text COLLATE utf8_unicode_ci NOT NULL,
                                    `filter_id` int(11) NOT NULL,
                                    `key_id` text COLLATE utf8_unicode_ci NOT NULL,
                                    `value` text COLLATE utf8_unicode_ci NOT NULL,
                                    `time` int(11) NOT NULL,
                                    PRIMARY KEY (`id`)
                                  ) ENGINE=MyISAM {$charset_collate};";

        if ($wpdb->query($sql) === false) {
            ?>
        <p class="description"><?php _e("MDTF cannot create database table for statistic! Make sure that your mysql user has the CREATE privilege! Do it manually using your host panel&amp;phpmyadmin!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
        <code><?php echo $sql; ?></code>
        <?php
        echo $wpdb->last_error;
    }

    //***
    $sql = "CREATE TABLE IF NOT EXISTS `{$table_stat_tmp}` (
                                    `id` int(11) NOT NULL AUTO_INCREMENT,
                                    `user_ip` text COLLATE utf8_unicode_ci NOT NULL,
                                    `post_type` text COLLATE utf8_unicode_ci NOT NULL,
                                    `tax_data` text COLLATE utf8_unicode_ci NOT NULL,
                                    `meta_data` text COLLATE utf8_unicode_ci NOT NULL,
                                    `hash` text COLLATE utf8_unicode_ci NOT NULL,
                                    `time` int(11) NOT NULL,
                                    `is_collected` int(1) NOT NULL DEFAULT '0',
                                    PRIMARY KEY (`id`)
                                  ) ENGINE=MyISAM  {$charset_collate};";

    if ($wpdb->query($sql) === false) {
        ?>
        <p class="description"><?php _e("MDTF cannot create database table for statistic! Make sure that your mysql user has the CREATE privilege! Do it manually using your host panel&amp;phpmyadmin!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
        <code><?php echo $sql; ?></code>
        <?php
        echo $wpdb->last_error;
    }
    ?>
</tbody>
</table>
</p>

<style type="text/css">
    .mdf_stat_option{
        display:none;
    }
    #mdf_stat_print_btn{
        display: none;
    }

    .mdf_stat_calendar{
        width: 40% !important;
    }

    #mdf_stat_get_monitor{
        font-size: 10px;
        height: auto;
        max-height: 75px;
        overflow: auto;
    }

    #mdf_stat_get_monitor li{
        padding: 0;
        margin: 0 0 3px 0;
        line-height: normal;
    }

    .woof_stat_one_graph .woof_stat_graph_title{
        display: block;
        font-weight: bold;
        font-size: 16px;
        padding-top: 50px;
    }

    @media print{
        #adminmenumain,
        .woo-nav-tab-wrapper{
            display: none;
        }

        #wpcontent{
            margin: 0;
            padding: 0;
        }

        #chart_div_1{
            padding: 50px;
            page-break-before:always;
            page-break-after:always;
        }

        .mdf_stat_one_graph{
            padding: 50px;
            page-break-before:auto;
            page-break-after:always;
        }
    }
    #mdf_stat_redraw_var .chosen-container{
        margin-bottom: 10px;
        margin-top: 5px;
    }
    #mdf_stat_redraw_var .chosen-choices{
        min-height: 25px;
    }
    #ui-datepicker-div{
        display: none;
    }
    .mdf_notice{
        color:red;
        padding: 10px;
        border: solid 1px orange;
    }
    /*
        @media print
        {
            body * { visibility: hidden; padding:0 !important;margin: 0 !important; }
            #woof_stat_charts_list * { visibility: visible;padding:0 !important;margin: 0 !important;  }

        }


    */
</style>

<script type="text/javascript">
    jQuery(function ($) {
        //reset cache of "Statistical parameters" drop-down
        jQuery("#mdf_stat_snippet option[selected]").removeAttr("selected");

        //+++
        //*** Load the Visualization API and the corechart package.
        try {
            google.charts.load('current', {'packages': ['corechart', 'bar']});
        } catch (e) {
            console.log('<?php _e('Google charts library not loaded! If site is on localhost just disable statistic extension in tab Extensions!', 'wp-meta-data-filter-and-taxonomy-filter') ?>');
        }
        //+++
        jQuery('.mdf_cron_system').change(function () {
            var state = parseInt(jQuery(this).val(), 10);
            if (state === 1) {
                //external
                jQuery('.mdf_external_cron_option').show(200);
                jQuery('.mdf_wp_cron_option').hide(200);
            } else {
                jQuery('.mdf_external_cron_option').hide(200);
                jQuery('.mdf_wp_cron_option').show(200);
            }
        });
    });

    //+++

    //stat

    function mdf_stat_draw_graphs() {
        mdf_stat_process_monitor('<?php _e('drawing graphs ...', 'wp-meta-data-filter-and-taxonomy-filter') ?>');

        try {
            console.log(mdf_stat_data);
            if (mdf_stat_data.length) {
                var graph1 = {};
                //***

                var counter = 1;
                var templ_search = mdf_stat_get_request_snippets();
                if (templ_search.tax === null && templ_search.meta === null) {
                    var data1 = mdf_stat_data[0];
                    counter = 1;
                    for (tn in data1) {
                        if (counter > parseInt(mdf_stat_vars.max_items_per_graph, 10)) {
                            break;
                        }
                        graph1[tn] = data1[tn];
                        counter++;
                    }

                    //+++
                    var data2 = mdf_stat_data[1];
                    counter = 1;
                    var graph_count = 0;
                    for (i in data2) {

                        var graph = {};
                        var html = "";
                        var id = 'chart_div_1_set_' + graph_count;
                        html = '<div class="mdf_stat_one_graph"><span class="mdf_stat_graph_title">' + data2[i]['tax_name'] + '</span>';
                        html += "<div id='" + id + "' style='width: 100%; height: 500px;'></div></div>";
                        jQuery('#chart_div_1_set').append(html);
                        counter = 1;

                        for (term_name in data2[i]['terms']) {
                            if (counter > parseInt(mdf_stat_vars.max_items_per_graph, 10)) {
                                break;
                            }
                            //+++
                            graph[term_name] = parseInt(data2[i]['terms'][term_name], 10);
                            counter++;
                        }
                        //console.log(id);
                        //console.log(graph);
                        drawChart1(graph, id);
                        graph_count++;
                    }

                } else {
                    var counter = 1;
                    jQuery(mdf_stat_data).each(function (i, request_block) {
                        //counter = 0;
                        jQuery(request_block).each(function (ii, item) {
                            if (counter > parseInt(mdf_stat_vars.max_items_per_graph, 10)) {
                                return;
                            }
                            //+++
                            if (graph1[item.vname] !== undefined) {
                                graph1[item.vname] = graph1[item.vname] + parseInt(item.val, 10);
                            } else {
                                graph1[item.vname] = parseInt(item.val, 10);
                            }

                            counter++;
                        });
                    });
                }
                drawChart1(graph1, 'chart_div_1');
                //***

                /*
                 var graph2 = [['Name', 'Value', {role: 'style'}]];
                 //console.log(woof_stat_data);
                 jQuery(woof_stat_data).each(function (i, request_block) {
                 jQuery(request_block).each(function (ii, item) {
                 graph2[graph2.length] = [item.vname, item.val, 'opacity: 0.2'];
                 });
                 });
                 drawChart2(graph2);
                 */
            }

            mdf_stat_process_monitor('<?php _e('finished!', 'wp-meta-data-filter-and-taxonomy-filter') ?>');
            jQuery('#mdf_stat_print_btn').show(200);
        } catch (e) {
            console.log('<?php _e('Looks like troubles with JavaScript!', 'wp-meta-data-filter-and-taxonomy-filter') ?>');
        }

        return false;
    }


    //+++


    function drawChart1(graph1, id) {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'X');
        data.addColumn('number', 'Y');
        var rows_data = [];

        jQuery.each(graph1, function (index, value) {
            rows_data.push([index + " (" + value + ")", value]);
        });
        data.addRows(rows_data);
        /*
         data.addRows([
         ['Mushrooms', 3],
         ['Onions', 1],
         ['Olives', 2]
         ]);
         */

        // Set chart options
        var options = {
            'title': 'Graph 1',
            //'width': 800,
            //'height': 600,
            chartArea: {left: 0, top: 0, width: "100%", height: "100%"}
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById(id));
        chart.draw(data, options);
    }


    function drawChart2(graph2) {
        var data = google.visualization.arrayToDataTable(graph2);
        /*
         var data = google.visualization.arrayToDataTable([
         ['Name', 'Value', {role: 'style'}],
         ['2010', 10, 'color: gray'],
         ['2020', 14, 'color: #76A7FA'],
         ['2030', 16, 'opacity: 0.2'],
         ['2040', 22, 'stroke-color: #703593; stroke-width: 4; fill-color: #C5A5CF'],
         ['2050', 28, 'stroke-color: #871B47; stroke-opacity: 0.6; stroke-width: 8; fill-color: #BC5679; fill-opacity: 0.2']
         ]);
         */
        // Set chart options
        var options = {
            'title': 'Graph 2',
            //'width': 800,
            //'height': 600,
            chartArea: {left: 0, top: 0, width: "100%", height: "100%"}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_2'));
        chart.draw(data, options);

    }
    jQuery('#mdf_stat_post_type').change(function () {
        var data = {
            action: "draw_mdf_taxmeta_var",
            mdf_stat_post_type: jQuery(this).val(),
        };
        jQuery.post(ajaxurl, data, function (content) {
            jQuery('#mdf_stat_redraw_var').html(content);
            jQuery(".chosen_select").chosen({width: "50%"});
        });
    });
    jQuery('#mdf_stat_connection').click(function () {
        var data = {
            action: "mdf_stat_check_connection",
            mdf_stat_host: jQuery("input[name='meta_data_filter_settings[server_options][host]']").val(),
            mdf_stat_user: jQuery("input[name='meta_data_filter_settings[server_options][host_user]']").val(),
            mdf_stat_name: jQuery("input[name='meta_data_filter_settings[server_options][host_db_name]']").val(),
            mdf_stat_pswd: jQuery("input[name='meta_data_filter_settings[server_options][host_pass]']").val(),

        };
        jQuery.post(ajaxurl, data, function (content) {
            alert(content);
        });
    });

    jQuery('select[name="meta_data_filter_settings[cron_system]"]').click(function () {

        if (jQuery(this).val() == 1) {
            jQuery('.cron_sys_1').css('visibility', 'visible');
            jQuery('.cron_sys_0').css('visibility', 'hidden');
        } else {
            jQuery('.cron_sys_0').css('visibility', 'visible');
            jQuery('.cron_sys_1').css('visibility', 'hidden');
        }
    });


</script>

