<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>

<!-- <div class="mdf-admin-preloader"></div> -->

<div class="woobe-admin-preloader">
    <div class="cssload-loader">
        <div class="cssload-inner cssload-one"></div>
        <div class="cssload-inner cssload-two"></div>
        <div class="cssload-inner cssload-three"></div>
    </div>
</div>

<div class="wrap">
    <div>

        <div>

            <h2 style="font-size: 23px;
                font-weight: 400;
                margin: 0;
                padding: 9px 0 4px 0;
                line-height: 1.3;"><?php if (MetaDataFilter::$is_free): ?><a href="http://wp-filter.com/a/buy" target="_blank" class="button button-primary"><?php _e("GET Premium version", 'wp-meta-data-filter-and-taxonomy-filter') ?></a>&nbsp;<?php endif; ?><?php _e("MDTF Settings", 'wp-meta-data-filter-and-taxonomy-filter') ?> v.<?php echo MetaDataFilter::get_plugin_ver() ?>&nbsp;&nbsp;&nbsp;<a href="https://wp-filter.com/documentation/" target="_blank" class="button"><?php _e("Read", 'wp-meta-data-filter-and-taxonomy-filter') ?></a>&nbsp;&amp;&nbsp; <a href="https://wp-filter.com/video/" target="_blank" class="button"><?php _e("Watch", 'wp-meta-data-filter-and-taxonomy-filter') ?></a></h2>

        </div>

        <div>
            <?php
            try {
                date_default_timezone_set('UTC');
            } catch (Exeption $e) {
                //+++
            }
            $start = mktime(12, 35, 0, 3, 22, 2021);
            $end = mktime(1, 0, 0, 3, 26, 2021);

            if (time() > $start AND time() < $end):
                ?>
                <a href="http://wp-filter.com/a/buy" alt="40% off sale" target="_blank"><img width="400" src="<?= MetaDataFilter::get_application_uri() ?>/images/off40sale-590x60.jpg" alt="40% off sale" /></a>
            <?php endif; ?>
        </div>

    </div>

    <?php if (!empty($_POST)): ?>
        <div class="updated settings-error" id="setting-error-settings_updated"><p><strong><?php _e("Settings are saved.", 'wp-meta-data-filter-and-taxonomy-filter') ?></strong></p></div>
    <?php endif; ?>


    <form action="<?php echo wp_nonce_url(admin_url('edit.php?post_type=' . MetaDataFilterCore::$slug . '&page=mdf_settings'), "update_mdtf" . MetaDataFilterCore::$slug) ?>" method="post">

        <div id="tabs">
            <ul>
                <li><a href="#tabs-1"><?php _e("Main settings", 'wp-meta-data-filter-and-taxonomy-filter') ?></a></li>
                <li><a href="#tabs-3"><?php _e("Front interface", 'wp-meta-data-filter-and-taxonomy-filter') ?></a></li>
                <li><a href="#tabs-2"><?php _e("Miscellaneous", 'wp-meta-data-filter-and-taxonomy-filter') ?></a></li>
                <?php if (class_exists('WooCommerce')): ?>
                    <li><a href="#tabs-4"><?php _e("WooCommerce", 'wp-meta-data-filter-and-taxonomy-filter') ?></a></li>
                <?php endif; ?>
                <li><a href="#tabs-5"><?php _e("In-Built Pagination", 'wp-meta-data-filter-and-taxonomy-filter') ?></a></li>


                <?php if (class_exists('MDF_POSTS_MESSENGER')): ?>
                    <li><a href="#tabs-6"><?php _e("Messenger", 'wp-meta-data-filter-and-taxonomy-filter') ?></a></li>
                <?php endif; ?>
                <?php if (class_exists('MDF_SEARCH_STAT')): ?>
                    <li><a href="#tabs-7"><?php _e("Statistic", 'wp-meta-data-filter-and-taxonomy-filter') ?></a></li>
                <?php endif; ?>

                <li><a href="#tabs-8"><?php _e("Advanced options", 'wp-meta-data-filter-and-taxonomy-filter') ?></a></li>
                <li><a href="#tabs-9"><?php _e("Info", 'wp-meta-data-filter-and-taxonomy-filter') ?></a></li>
            </ul>


            <div id="tabs-1">
                <p>
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label><?php _e("Search Result Page", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <input type="text" class="regular-text" value="<?php echo $data['search_url'] ?>" name="meta_data_filter_settings[search_url]">
                                <p class="description"><?php _e("Link to site page where shows searching results", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php _e("Output search template", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <input type="text" class="regular-text" value="<?php echo $data['output_tpl'] ?>" name="meta_data_filter_settings[output_tpl]">
                                <p class="description"><?php _e("Output template, search by default. For example: search,archive,content or your custom which is in current wp theme. If you want to set double name template, write it in such manner for example: content-special. If you do not understood - leave search!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php _e("Supported post types", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>

                                <?php foreach (MetaDataFilterCore::get_post_types() as $post_type => $post_type_name) : ?>

                                    <fieldset>
                                        <label>
                                            <input type="checkbox" <?php if (@in_array($post_type_name, $data['post_types'])) echo 'checked'; ?> value="<?php echo $post_type_name ?>" name="meta_data_filter_settings[post_types][]" />
                                            <?php echo $post_type_name ?>
                                        </label>
                                    </fieldset>

                                <?php endforeach; ?>
                                <p class="description"><?php _e("Check post types which should be searched", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>

                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php _e("Reset custom link", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <input type="text" class="regular-text" value="<?php echo @$data['reset_link'] ?>" name="meta_data_filter_settings[reset_link]">
                                <p class="description"><?php _e("Leave this field empty if you do not need this. Of course each widget and shortcode has such option too.", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row" class="mdf_for_premium_label"><label><?php _e("Results per page", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <input type="text" class="regular-text" readonly="" placeholder="in premium version" value="" name="meta_data_filter_settings[results_per_page]">
                                <p class="description"><?php _e("Leave this field empty if you want to use wordpress or your theme settings.", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>

                            </td>
                        </tr>
                    </tbody>
                </table>
                </p>
            </div>
            <div id="tabs-2">
                <p>
                <table class="form-table">
                    <tbody>



                        <tr valign="top">
                            <th scope="row"><label><?php _e("Overlay skin", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>

                                <?php
                                $skins = array(
                                    'default' => __('Default', 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'plainoverlay' => __('Plainoverlay', 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'loading-balls' => __('Loading balls', 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'loading-bars' => __('Loading bars', 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'loading-bubbles' => __('Loading bubbles', 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'loading-cubes' => __('Loading cubes', 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'loading-cylon' => __('Loading cyclone', 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'loading-spin' => __('Loading spin', 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'loading-spinning-bubbles' => __('Loading spinning bubbles', 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'loading-spokes' => __('Loading spokes', 'wp-meta-data-filter-and-taxonomy-filter'),
                                );
                                if (!isset($data['overlay_skin'])) {
                                    $data['overlay_skin'] = 'default';
                                }
                                $skin = $data['overlay_skin'];
                                ?>

                                <select name="meta_data_filter_settings[overlay_skin]" style="width: 300px;">
                                    <?php foreach ($skins as $scheme => $title) : ?>
                                        <option value="<?php echo $scheme; ?>" <?php if ($skin == $scheme): ?>selected="selected"<?php endif; ?>><?php echo $title; ?></option>
                                    <?php endforeach; ?>
                                </select>&nbsp;<br />

                                <p class="description"><?php _e("Overlay skin while data loading", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>

                                <?php
                                if (!isset($data['overlay_skin_bg_img'])) {
                                    $data['overlay_skin_bg_img'] = '';
                                }
                                $overlay_skin_bg_img = $data['overlay_skin_bg_img'];
                                ?>
                                <div <?php if ($skin == 'default'): ?>style="display: none;"<?php endif; ?>>

                                    <h4 style="margin-bottom: 5px;"><?php _e('Overlay image background', 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
                                    <input type="text" style="width: 80%;" name="meta_data_filter_settings[overlay_skin_bg_img]" value="<?php echo $overlay_skin_bg_img ?>" /><br />
                                    <i><?php _e('Example', 'wp-meta-data-filter-and-taxonomy-filter') ?>: <?php echo self::get_application_uri() ?>images/overlay_bg.png</i><br />

                                    <div <?php if ($skin != 'plainoverlay'): ?>style="display: none;"<?php endif; ?>>
                                        <br />

                                        <?php
                                        if (!isset($data['plainoverlay_color'])) {
                                            $data['plainoverlay_color'] = '';
                                        }
                                        $plainoverlay_color = $data['plainoverlay_color'];
                                        ?>

                                        <h4 style="margin-bottom: 5px;"><?php _e('Plainoverlay color', 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
                                        <input type="text" name="meta_data_filter_settings[plainoverlay_color]" value="<?php echo $plainoverlay_color ?>" class="mdtf-color-picker" >

                                    </div>

                                </div>


                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row" class="mdf_for_premium_label"><label><?php _e("Loading text", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <input type="text" class="regular-text" placeholder="in premium version" readonly="" value="" name="meta_data_filter_settings[loading_text]">
                                <p class="description"><?php _e("Example: One Moment ...", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                <br />
                                <hr />

                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label><?php _e("Default order by", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <?php
                                if (!isset($data['default_order_by']) OR empty($data['default_order_by'])) {
                                    $data['default_order_by'] = self::$default_order_by;
                                }
                                ?>
                                <input type="text" class="regular-text" value="<?php echo @$data['default_order_by'] ?>" name="meta_data_filter_settings[default_order_by]">
                                <?php
                                $default_orders = array(
                                    'DESC' => __("DESC", 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'ASC' => __("ASC", 'wp-meta-data-filter-and-taxonomy-filter')
                                );
                                if (!isset($data['default_order']) OR empty($data['default_order'])) {
                                    $data['default_order'] = self::$default_order;
                                }
                                ?>
                                <select name="meta_data_filter_settings[default_order]">
                                    <?php foreach ($default_orders as $key => $value) : ?>
                                        <option value="<?php echo $key; ?>" <?php if (@$data['default_order'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="description"><?php printf(__("Example: %s,_price. Default order-by of your filtered posts.", 'wp-meta-data-filter-and-taxonomy-filter'), implode(',', MetaDataFilterCore::$allowed_order_by)) ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label for="mdtf_label_43"><?php _e("Default sort panel", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>

                                        <?php
                                        $sort_panels_query = new WP_Query(array(
                                            'post_type' => MetaDataFilterCore::$slug_woo_sort,
                                            'post_status' => array('publish'),
                                            'orderby' => 'name',
                                            'order' => 'ASC'
                                        ));
//+++
                                        if (!isset($data['default_sort_panel'])) {
                                            $data['default_sort_panel'] = 0;
                                        }
                                        ?>

                                        <?php if ($sort_panels_query->have_posts()): ?>
                                            <select name="meta_data_filter_settings[default_sort_panel]">
                                                <?php while ($sort_panels_query->have_posts()) : ?>
                                                    <?php $sort_panels_query->the_post(); ?>
                                                    <option value="<?php the_ID() ?>" <?php if ($data['default_sort_panel'] == get_the_ID()): ?>selected="selected"<?php endif; ?>><?php the_title() ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                            <?php
                                            wp_reset_postdata();
                                            wp_reset_query();
                                            ?>
                                        <?php else: ?>
                                            <?php _e("No one sort panel created!", 'wp-meta-data-filter-and-taxonomy-filter') ?>
                                            <input type="hidden" name="meta_data_filter_settings[default_sort_panel]" value="0" />
                                        <?php endif; ?>
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e("Will be shown if the searching is not going by default if no panel id is set.", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row" class="mdf_for_premium_label"><label><?php _e("Toggle open sign", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <input type="text" class="regular-text" readonly="" value="+" name="">
                                <p class="description"><?php _e("Toggle open sign on front widget while using toggles for sections.", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row" class="mdf_for_premium_label"><label><?php _e("Toggle close sign", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <input type="text" class="regular-text" readonly="" value="-" name="">
                                <p class="description"><?php _e("Toggle close sign on front widget while using toggles for sections.", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="hide_search_button_shortcode"><?php _e("Hide [mdf_search_button] on mobile devices", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input id="hide_search_button_shortcode" type="checkbox" <?php if (isset($data['hide_search_button_shortcode']) AND $data['hide_search_button_shortcode'] == 1) echo 'checked'; ?> value="1" name="meta_data_filter_settings[hide_search_button_shortcode]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e("Hide button of search button shortcode on mobile devices", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><label for="ignore_sticky_posts"><?php _e("Ignore sticky posts", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input id="ignore_sticky_posts" type="checkbox" <?php if (isset($data['ignore_sticky_posts']) AND $data['ignore_sticky_posts'] == 1) echo 'checked'; ?> value="1" name="meta_data_filter_settings[ignore_sticky_posts]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e("Ignore sticky posts in search results", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label for="show_tax_all_childs"><?php _e("Show terms childs", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input id="show_tax_all_childs" type="checkbox" <?php if (isset($data['show_tax_all_childs']) AND $data['show_tax_all_childs'] == 1) echo 'checked'; ?> value="1" name="meta_data_filter_settings[show_tax_all_childs]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e("Show terms childs always in taxonomies shown as checkboxes", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>

                    </tbody>
                </table>
                </p>
            </div>
            <div id="tabs-3">
                <p>
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label><?php _e("Tooltip theme", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <?php
                                $tooltip_themes = array(
                                    'default' => __("Default", 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'light' => __("Light", 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'noir' => __("Noir", 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'punk' => __("Punk", 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'shadow' => __("Shadow", 'wp-meta-data-filter-and-taxonomy-filter')
                                );
                                ?>
                                <select name="meta_data_filter_settings[tooltip_theme]">
                                    <?php foreach ($tooltip_themes as $key => $value) : ?>
                                        <option value="<?php echo $key; ?>" <?php if ($data['tooltip_theme'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php _e("Tooltip icon image URL", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <input type="text" class="regular-text" placeholder="<?php _e("default icon", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo $data['tooltip_icon'] ?>" name="meta_data_filter_settings[tooltip_icon]">
                                <p class="description"><?php _e("Link to png icon for tooltip in widgets and shortcodes", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php _e("Tooltip max width", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <input type="text" class="regular-text" value="<?php echo @$data['tooltip_max_width'] ?>" name="meta_data_filter_settings[tooltip_max_width]">
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php _e("Tab slideout icon image settings", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <input type="text" class="regular-text" placeholder="<?php _e("default icon url", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo @$data['tab_slideout_icon'] ?>" name="meta_data_filter_settings[tab_slideout_icon]"><br />
                                <input type="text" class="regular-text" placeholder="<?php _e("default icon width", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo @$data['tab_slideout_icon_w'] ?>" name="meta_data_filter_settings[tab_slideout_icon_w]"><br />
                                <input type="text" class="regular-text" placeholder="<?php _e("default icon height", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo @$data['tab_slideout_icon_h'] ?>" name="meta_data_filter_settings[tab_slideout_icon_h]"><br />
                                <p class="description"><?php _e("Link and width/height to png icon for tab slideout shortcode", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php _e("jQuery-ui calendar date format", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <?php
                                $calendar_date_formats = array(
                                    'mm/dd/yy' => __("Default - mm/dd/yy", 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'dd-mm-yy' => __("Europe - dd-mm-yy", 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'yy-mm-dd' => __("ISO 8601 - yy-mm-dd", 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'd M, y' => __("Short - d M, y", 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'd MM, y' => __("Medium - d MM, y", 'wp-meta-data-filter-and-taxonomy-filter'),
                                    'DD, d MM, yy' => __("Full - DD, d MM, yy", 'wp-meta-data-filter-and-taxonomy-filter')
                                );
                                $calendar_date_format = (isset($data['calendar_date_format']) ? $data['calendar_date_format'] : 'mm/dd/yy');
                                ?>
                                <select name="meta_data_filter_settings[calendar_date_format]">
                                    <?php foreach ($calendar_date_formats as $key => $value) : ?>
                                        <option value="<?php echo $key; ?>" <?php if ($calendar_date_format == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php _e("Use chosen js library for drop-downs in the search forms", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input type="checkbox" <?php if (isset($data['use_chosen_js_w']) AND $data['use_chosen_js_w'] == 1) echo 'checked'; ?> value="1" name="meta_data_filter_settings[use_chosen_js_w]" />
                                        <?php _e("for widgets", 'wp-meta-data-filter-and-taxonomy-filter') ?>
                                    </label>
                                </fieldset>
                                <fieldset>
                                    <label>
                                        <input type="checkbox" <?php if (isset($data['use_chosen_js_s']) AND $data['use_chosen_js_s'] == 1) echo 'checked'; ?> value="1" name="meta_data_filter_settings[use_chosen_js_s]" />
                                        <?php _e("for shortcodes", 'wp-meta-data-filter-and-taxonomy-filter') ?>
                                    </label>
                                </fieldset>
                                <img src="<?php echo MetaDataFilter::get_application_uri() ?>images/chosen_selects.png" alt="" /><br />
                                <p class="description"><?php _e("Not compatible with all wp themes. Uncheck the checkbox it is works bad.", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>

                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="use_custom_scroll_bar"><?php _e("Use custom scroll js bar", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input id="use_custom_scroll_bar" type="checkbox" <?php if (isset($data['use_custom_scroll_bar']) AND $data['use_custom_scroll_bar'] == 1) echo 'checked'; ?> value="1" name="meta_data_filter_settings[use_custom_scroll_bar]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e("Beautiful js scroll bars. Sometimes not compatible with some wordpress themes", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>

                        <tr valign="top" colspan="2">
                            <th scope="row"><label for="use_custom_icheck"><?php _e("Use icheck js library for checkboxes", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input id="use_custom_icheck" type="checkbox" <?php if (isset($data['use_custom_icheck']) AND $data['use_custom_icheck'] == 1) echo 'checked'; ?> value="1" name="meta_data_filter_settings[use_custom_icheck]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e("JS CUSTOMIZED CHECKBOXES AND RADIO BUTTONS FOR JQUERY: http://fronteed.com/iCheck/", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                            <td>
                                <?php _e("Skin", 'wp-meta-data-filter-and-taxonomy-filter') ?>:<br />
                                <?php
                                $skins = array(
                                    'flat' => array(
                                        'flat_aero',
                                        'flat_blue',
                                        'flat_flat',
                                        'flat_green',
                                        'flat_grey',
                                        'flat_orange',
                                        'flat_pink',
                                        'flat_purple',
                                        'flat_red',
                                        'flat_yellow'
                                    ),
                                    'line' => array(
                                        //'line_aero',
                                        'line_blue',
                                        'line_green',
                                        'line_grey',
                                        'line_line',
                                        'line_orange',
                                        'line_pink',
                                        'line_purple',
                                        'line_red',
                                        'line_yellow'
                                    ),
                                    'minimal' => array(
                                        'minimal_aero',
                                        'minimal_blue',
                                        'minimal_green',
                                        'minimal_grey',
                                        'minimal_minimal',
                                        'minimal_orange',
                                        'minimal_pink',
                                        'minimal_purple',
                                        'minimal_red',
                                        'minimal_yellow'
                                    ),
                                    'square' => array(
                                        'square_aero',
                                        'square_blue',
                                        'square_green',
                                        'square_grey',
                                        'square_orange',
                                        'square_pink',
                                        'square_purple',
                                        'square_red',
                                        'square_yellow',
                                        'square_square'
                                    )
                                );
                                $skin = (isset($data['icheck_skin']) ? $data['icheck_skin'] : 'flat_blue');
                                ?>
                                <select name="meta_data_filter_settings[icheck_skin]">
                                    <?php foreach ($skins as $key => $schemes) : ?>
                                        <optgroup label="<?php echo $key ?>">
                                            <?php foreach ($schemes as $scheme) : ?>
                                                <option value="<?php echo $scheme; ?>" <?php if ($skin == $scheme): ?>selected="selected"<?php endif; ?>><?php echo $scheme; ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>&nbsp;
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><label><?php _e("Range slider skin", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>

                                <?php
                                $skins = array(
                                    'skinNice' => 'skinNice',
                                    'skinFlat' => 'skinFlat',
                                    'skinSimple' => 'skinSimple'
                                );

                                $skin = (isset($data['ion_slider_skin']) ? $data['ion_slider_skin'] : 'skinNice');
                                ?>

                                <div class="select-wrap">
                                    <select name="meta_data_filter_settings[ion_slider_skin]" class="chosen_select">
                                        <?php foreach ($skins as $key => $value) : ?>
                                            <option value="<?php echo $key; ?>" <?php if ($skin == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <p class="description">
                                    <?php _e('Ion-Range slider js lib skin for range-sliders of the plugin', 'wp-meta-data-filter-and-taxonomy-filter') ?>
                                </p>

                            </td>
                        </tr>

                    </tbody>
                </table>
                </p>
            </div>

            <?php if (class_exists('WooCommerce')): ?>
                <div id="tabs-4">
                    <p>
                    <table class="form-table">
                        <tbody>
                            <tr valign="top">
                                <th scope="row"><label for="mdtf_label_41"><?php _e("Exclude 'out of stock' products from search", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <fieldset>
                                        <label>
                                            <input id="mdtf_label_41" type="checkbox" <?php if (isset($data['exclude_out_stock_products'])) echo 'checked'; ?> value="1" name="meta_data_filter_settings[exclude_out_stock_products]" />
                                        </label>
                                    </fieldset>
                                    <p class="description"></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label for="mdtf_label_42"><?php _e("Try to make shop page AJAXED", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <fieldset>
                                        <label>
                                            <input id="mdtf_label_42" type="checkbox" <?php if (isset($data['try_make_shop_page_ajaxed'])) echo 'checked'; ?> value="1" name="meta_data_filter_settings[try_make_shop_page_ajaxed]" />
                                        </label>
                                    </fieldset>
                                    <p class="description"><?php _e("Check it if you want to make ajax searching directly on woocommerce shop page. BUT! It is not possible for 100% because a lot of wordpress themes developers not use in the right way woocommerce hooks woocommerce_before_shop_loop AND woocommerce_after_shop_loop. Works well with native woocommerce themes as Canvas and Primashop for example!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                </td>
                            </tr>






                        </tbody>
                    </table>
                    </p>
                </div>
            <?php endif; ?>

            <div id="tabs-5">
                <p>
                <table class="form-table">
                    <tbody>

                        <tr valign="top">
                            <th scope="row"><label for="mdtf_label_51"><?php _e('Pagination Label', 'wp-meta-data-filter-and-taxonomy-filter'); ?>:</label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <?php
                                        $var = __('Pages:', 'wp-meta-data-filter-and-taxonomy-filter');
                                        if (isset($data['ajax_pagination']['title'])) {
                                            $var = $data['ajax_pagination']['title'];
                                        }
                                        ?>
                                        <input type="text" class="regular-text" id="mdtf_label_51" value="<?php echo stripslashes(htmlspecialchars($var)) ?>" name="meta_data_filter_settings[ajax_pagination][title]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e('The text/HTML to display before the list of pages.', 'wp-meta-data-filter-and-taxonomy-filter'); ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label for="mdtf_label_52"><?php _e('Previous Page', 'wp-meta-data-filter-and-taxonomy-filter'); ?>:</label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <?php
                                        $var = '&laquo;';
                                        if (isset($data['ajax_pagination']['previouspage'])) {
                                            $var = $data['ajax_pagination']['previouspage'];
                                        }
                                        ?>
                                        <input type="text" class="regular-text" id="mdtf_label_52" value="<?php echo stripslashes(htmlspecialchars($var)) ?>" name="meta_data_filter_settings[ajax_pagination][previouspage]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e('The text/HTML to display for the previous page link.', 'wp-meta-data-filter-and-taxonomy-filter'); ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label for="mdtf_label_53"><?php _e('Next Page', 'wp-meta-data-filter-and-taxonomy-filter'); ?>:</label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <?php
                                        $var = '&raquo;';
                                        if (isset($data['ajax_pagination']['nextpage'])) {
                                            $var = $data['ajax_pagination']['nextpage'];
                                        }
                                        ?>
                                        <input type="text" class="regular-text" id="mdtf_label_53" value="<?php echo stripslashes(htmlspecialchars($var)) ?>" name="meta_data_filter_settings[ajax_pagination][nextpage]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e('The text/HTML to display for the next page link.', 'wp-meta-data-filter-and-taxonomy-filter'); ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label for="mdtf_label_54"><?php _e('Before Markup', 'wp-meta-data-filter-and-taxonomy-filter'); ?>:</label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <?php
                                        $var = '<div class="navigation">';
                                        if (isset($data['ajax_pagination']['before'])) {
                                            $var = $data['ajax_pagination']['before'];
                                        }
                                        ?>
                                        <input type="text" class="regular-text" id="mdtf_label_54" value="<?php echo stripslashes(htmlspecialchars($var)) ?>" name="meta_data_filter_settings[ajax_pagination][before]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e('The HTML markup to display before the pagination code.', 'wp-meta-data-filter-and-taxonomy-filter'); ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label for="mdtf_label_55"><?php _e('After Markup', 'wp-meta-data-filter-and-taxonomy-filter'); ?>:</label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <?php
                                        $var = '</div>';
                                        if (isset($data['ajax_pagination']['after'])) {
                                            $var = $data['ajax_pagination']['after'];
                                        }
                                        ?>
                                        <input type="text" class="regular-text" id="mdtf_label_55" value="<?php echo stripslashes(htmlspecialchars($var)) ?>" name="meta_data_filter_settings[ajax_pagination][after]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e('The HTML markup to display after the pagination code.', 'wp-meta-data-filter-and-taxonomy-filter'); ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label for="mdtf_label_56"><?php _e('Page Range', 'wp-meta-data-filter-and-taxonomy-filter'); ?>:</label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <?php
                                        $var = 3;
                                        if (isset($data['ajax_pagination']['range']) AND!empty($data['ajax_pagination']['range'])) {
                                            $var = $data['ajax_pagination']['range'];
                                        }
                                        ?>
                                        <input type="text" class="regular-text" id="mdtf_label_56" value="<?php echo stripslashes(htmlspecialchars($var)) ?>" name="meta_data_filter_settings[ajax_pagination][range]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e('The number of page links to show before and after the current page. Recommended value: 3', 'wp-meta-data-filter-and-taxonomy-filter'); ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label for="mdtf_label_57"><?php _e('Page Anchors', 'wp-meta-data-filter-and-taxonomy-filter'); ?>:</label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <?php
                                        $var = 1;
                                        if (isset($data['ajax_pagination']['anchor']) AND!empty($data['ajax_pagination']['anchor'])) {
                                            $var = $data['ajax_pagination']['anchor'];
                                        }
                                        ?>
                                        <input type="text" class="regular-text" id="mdtf_label_57" value="<?php echo stripslashes(htmlspecialchars($var)) ?>" name="meta_data_filter_settings[ajax_pagination][anchor]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e('The number of links to always show at beginning and end of pagination. Recommended value: 1', 'wp-meta-data-filter-and-taxonomy-filter'); ?></p>
                            </td>
                        </tr>



                        <tr valign="top">
                            <th scope="row"><label for="mdtf_label_58"><?php _e('Page Gap', 'wp-meta-data-filter-and-taxonomy-filter'); ?>:</label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <?php
                                        $var = 3;
                                        if (isset($data['ajax_pagination']['gap']) AND!empty($data['ajax_pagination']['gap'])) {
                                            $var = $data['ajax_pagination']['gap'];
                                        }
                                        ?>
                                        <input type="text" class="regular-text" id="mdtf_label_58" value="<?php echo stripslashes(htmlspecialchars($var)) ?>" name="meta_data_filter_settings[ajax_pagination][gap]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e('The minimum number of pages in a gap before an ellipsis (...) is added. Recommended value: 3', 'wp-meta-data-filter-and-taxonomy-filter'); ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label for="mdtf_label_59"><?php _e("Markup Display", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input id="mdtf_label_59" type="checkbox" <?php if (isset($data['ajax_pagination']['empty'])) echo 'checked'; ?> value="1" name="meta_data_filter_settings[ajax_pagination][empty]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e('Show "Before Markup" and "After Markup", even if the page list is empty?', 'wp-meta-data-filter-and-taxonomy-filter'); ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label for="mdtf_label_510"><?php _e("Pagination CSS File", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input id="mdtf_label_510" type="checkbox" <?php if (isset($data['ajax_pagination']['css'])) echo 'checked'; ?> value="1" name="meta_data_filter_settings[ajax_pagination][css]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php printf(__('Include the default stylesheet tw-pagination.css? Pagination will first look for <code>tw-pagination.css</code> in your theme directory (<code>themes/%s</code>).', 'wp-meta-data-filter-and-taxonomy-filter'), get_template()); ?></p>
                            </td>
                        </tr>


                    </tbody>
                </table>
                </p>
            </div>


            <?php
            if (class_exists('MDF_POSTS_MESSENGER')):

                $data['label_messenger'] = (isset($data['label_messenger']) ? $data['label_messenger'] : 'Posts Messenger');
                $data['subscr_count'] = (isset($data['subscr_count']) ? $data['subscr_count'] : 2);
                if (!isset($data['use_external_cron'])OR empty($data['use_external_cron'])) {
                    $data['use_external_cron'] = bin2hex(random_bytes(12));
                }
                $data['header_email_messenger'] = (isset($data['header_email_messenger']) ? $data['header_email_messenger'] : __("New Posts by your request", 'wp-meta-data-filter-and-taxonomy-filter'));
                $data['subject_email_messenger'] = (isset($data['subject_email_messenger']) ? $data['subject_email_messenger'] : __("New Posts", 'wp-meta-data-filter-and-taxonomy-filter'));
                $data['text_email_messenger'] = (isset($data['text_email_messenger']) ? $data['text_email_messenger'] : __("Dear [DISPLAY_NAME], we increased the range of our products. Number of new products: [PRODUCT_COUNT]", 'wp-meta-data-filter-and-taxonomy-filter'));
                $data['count_message'] = (isset($data['count_message']) ? $data['count_message'] : -1);
                $data['notes_for_customer_messenger'] = (isset($data['notes_for_customer_messenger']) ? $data['notes_for_customer_messenger'] : "");
                ?>
                <div id="tabs-6">
                    <p>
                    <table class="form-table">
                        <tbody>

                            <tr valign="top">
                                <th scope="row"><label><?php _e("Short Description", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <a href="https://wp-filter.com/extension/post-messenger/" class="button" target="_blank"><?php _e("Read How to use here", 'wp-meta-data-filter-and-taxonomy-filter') ?></a>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e("Label", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <input type="text" class="regular-text" value="<?php echo $data['label_messenger'] ?>" name="meta_data_filter_settings[label_messenger]">
                                    <p class="description"><?php _e("The text before subscription block", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e("WordPress cron period", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <?php
                                    $wp_cron_period = "no";
                                    if (isset($data['wp_cron_period_messenger'])) {
                                        $wp_cron_period = $data['wp_cron_period_messenger'];
                                    }
                                    $cron_periods = array(
                                        'no' => __('No', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'hourly' => __('hourly', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'twicedaily' => __('twicedaily', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'daily' => __('daily', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'week' => __('weekly', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'twicemonthly' => __('twicemonthly', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'month' => __('monthly', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'min1' => __('min1', 'wp-meta-data-filter-and-taxonomy-filter')
                                    );
                                    ?>
                                    <select name="meta_data_filter_settings[wp_cron_period_messenger]">
                                        <?php foreach ($cron_periods as $key => $txt): ?>
                                            <option <?php selected($wp_cron_period, $key) ?> value="<?php echo $key ?>"><?php echo $txt; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description"><?php _e('Period of emailing to subscribed users. Set it to "No" if you going to use external cron. ', 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e("External cron key (is recommended as flexible for timetable)", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <input type="text" class="regular-text" value="<?php echo $data['use_external_cron'] ?>" name="meta_data_filter_settings[use_external_cron]">
                                    <p class="description"><?php _e('For external cron use the next link', 'wp-meta-data-filter-and-taxonomy-filter'); ?>: <i class="woof_cron_link" ><b><?php echo get_home_url() . "?mdf_pm_cron_key=" . $data['use_external_cron']; ?></b></i><br />
                                        <?php _e('To reset the key, just delete it here and save the plugin settings OR write by hands your own. Key should be min 16 symbols.', 'wp-meta-data-filter-and-taxonomy-filter'); ?> </p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e("Max subscriptions per user", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <input type="text" class="regular-text" value="<?php echo $data['subscr_count'] ?>" name="meta_data_filter_settings[subscr_count]">
                                    <p class="description"><?php _e("Maximum number of subscriptions for a single registered user. ", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e("Title of the email", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <input type="text" class="regular-text" value="<?php echo $data['header_email_messenger'] ?>" name="meta_data_filter_settings[header_email_messenger]">
                                    <p class="description"><?php _e("Text in the email header.", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e("Subject of the email", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <input type="text" class="regular-text" value="<?php echo $data['subject_email_messenger'] ?>" name="meta_data_filter_settings[subject_email_messenger]">
                                    <p class="description"><?php _e("Subject of the email. ", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e("Text of the email", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <textarea class="regular-text" style="width: 100%; height: 150px;" name="meta_data_filter_settings[text_email_messenger]" ><?php echo $data['text_email_messenger'] ?></textarea>
                                    <p class="description"><?php _e("Text in the body of the email. You can use next variables: [DISPLAY_NAME], [USER_NICENAME], [PRODUCT_COUNT]. ", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e("Subscription time", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <?php
                                    $date_expire_period = "no";
                                    if (isset($data['date_expire_period_messenger'])) {
                                        $date_expire_period = $data['date_expire_period_messenger'];
                                    }
                                    $date_expire = array(
                                        'no' => __('No limit', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'week' => __('One week', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'twicemonthly' => __('Two weeks', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'month' => __('One month', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'twomonth' => __('Two months', 'wp-meta-data-filter-and-taxonomy-filter'),
                                            //'min1' => __('min1', 'wp-meta-data-filter-and-taxonomy-filter')
                                    );
                                    ?>
                                    <select name="meta_data_filter_settings[date_expire_period_messenger]">
                                        <?php foreach ($date_expire as $key => $txt): ?>
                                            <option <?php selected($date_expire_period, $key) ?> value="<?php echo $key ?>"><?php echo $txt; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description"><?php _e('How long user will get emails after subscription. ', 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e("Emails count", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <input type="text" class="regular-text" value="<?php echo $data['count_message'] ?>" name="meta_data_filter_settings[count_message]">
                                    <p class="description"><?php _e("Maximum number of emails per one subscribed user. -1 means no limit. ", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e("Priority of limitations", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <?php
                                    $priority_limit_messenger = "both";
                                    if (isset($data['priority_limit_messenger'])) {
                                        $priority_limit_messenger = $data['priority_limit_messenger'];
                                    }
                                    $priority_limit = array(
                                        'by_date' => __('By date', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'by_count' => __('By emails count', 'wp-meta-data-filter-and-taxonomy-filter'),
                                        'both' => __('Both', 'wp-meta-data-filter-and-taxonomy-filter'),
                                    );
                                    ?>
                                    <select name="meta_data_filter_settings[priority_limit_messenger]">
                                        <?php foreach ($priority_limit as $key => $txt): ?>
                                            <option <?php selected($priority_limit_messenger, $key) ?> value="<?php echo $key ?>"><?php echo $txt; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="description"><?php _e('Which limitation has priority. Event after which user stop getting the emails. Both - means that any first event ("Subscription time" or "Emails count") of two ones, will reset user subscription.', 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                </td>
                            </tr>

                            <tr valign="top">
                                <th scope="row"><label><?php _e("Notes for customer", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <textarea class="regular-text" style="width: 100%; height: 150px;" name="meta_data_filter_settings[notes_for_customer_messenger]" ><?php echo $data['notes_for_customer_messenger'] ?></textarea>
                                    <p class="description"><?php _e("Any text notes for customer under subscription form.", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    </p>
                </div>
            <?php endif; ?>

            <?php //+++++++++++++++++STAT++++++++++++++++++++++++++++++++  ?>
            <?php if (class_exists('MDF_SEARCH_STAT')): ?>
                <div id="tabs-7">
                    <?php do_action('mdf_print_applications_tabs_content_stat'); ?>
                </div>
            <?php endif; ?>



            <div id="tabs-8">
                <p>
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label for="gmap_js_include_pages"><?php _e("Include Google Map JS on the next pages", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input id="gmap_js_include_pages" type="text" class="regular-text" placeholder="Example: 75,134,96" value="<?php echo @$data['gmap_js_include_pages'] ?>" name="meta_data_filter_settings[gmap_js_include_pages]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e("Some themes has already included google maps js, so maybe you will not need this option. But if you are need this - you can include it on pages (ID) on which you are using map, not on all pages of your site! Set <b>-1</b> if you want to include it on all pages of your site.", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label for="gmap_user_api_key"><?php _e("Google Map  API key", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input id="gmap_user_api_key" type="text" class="regular-text" placeholder="API key" value="<?php echo @$data['gmap_user_api_key'] ?>" name="meta_data_filter_settings[gmap_user_api_key]" />
                                    </label>
                                </fieldset>
                                <p class="description"><?php _e("", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row"><label for="keep_search_data_in"><?php _e("Where to keep search data", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>

                                        <?php
                                        $keep_search_data_in = array(
                                            'transients' => 'transients',
                                            'session' => 'session',
                                        );
                                        ?>

                                        <?php
                                        if (!isset($data['keep_search_data_in']) OR empty($data['keep_search_data_in'])) {
                                            $data['keep_search_data_in'] = self::$where_keep_search_data;
                                        }
                                        ?>
                                        <select name="meta_data_filter_settings[keep_search_data_in]">
                                            <?php foreach ($keep_search_data_in as $key => $value) : ?>
                                                <option value="<?php echo $key; ?>" <?php if ($data['keep_search_data_in'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>


                                    </label>
                                </fieldset>
                                <p class="description"><?php _e("Better keep search data in sessions, but in some of reasons it sometimes not possible, so set it to transients. But transients make additional queries to data base! Set it to sessions when your search is working fine to exclude case when search doesn't work because data cannot be keeps in the session!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>



                        <tr valign="top">
                            <th scope="row"><label for="cache_count_data"><?php _e("Cache dynamic recount number for each item in filter", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>

                                        <?php
                                        $cache_count_data = array(
                                            0 => __("No", 'wp-meta-data-filter-and-taxonomy-filter'),
                                            1 => __("Yes", 'wp-meta-data-filter-and-taxonomy-filter')
                                        );
                                        ?>

                                        <?php
                                        if (!isset($data['cache_count_data']) OR empty($data['cache_count_data'])) {
                                            $data['cache_count_data'] = 0;
                                        }
                                        ?>
                                        <select name="meta_data_filter_settings[cache_count_data]">
                                            <?php foreach ($cache_count_data as $key => $value) : ?>
                                                <option value="<?php echo $key; ?>" <?php if ($data['cache_count_data'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>


                                        <?php if ($data['cache_count_data']): ?>

                                            &nbsp;<a href="#" class="button js_cache_count_data_clear"><?php _e("clear cache", 'wp-meta-data-filter-and-taxonomy-filter') ?></a>&nbsp;<span style="color: green; font-weight: bold;"></span>

                                            &nbsp;
                                            <?php
                                            $clean_period = 0;
                                            if (isset($data['cache_count_data_auto_clean'])) {
                                                $clean_period = $data['cache_count_data_auto_clean'];
                                            }
                                            $periods = array(
                                                0 => __("do not clean cache automatically", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'hourly' => __("clean cache automatically hourly", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'twicedaily' => __("clean cache automatically twicedaily", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'daily' => __("clean cache automatically daily", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'days2' => __("clean cache automatically each 2 days", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'days3' => __("clean cache automatically each 3 days", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'days4' => __("clean cache automatically each 4 days", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'days5' => __("clean cache automatically each 5 days", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'days6' => __("clean cache automatically each 6 days", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'days7' => __("clean cache automatically each 7 days", 'wp-meta-data-filter-and-taxonomy-filter'),
                                            );
                                            ?>
                                            <select name="meta_data_filter_settings[cache_count_data_auto_clean]">
                                                <?php foreach ($periods as $key => $txt): ?>
                                                    <option <?php selected($clean_period, $key) ?> value="<?php echo $key ?>"><?php echo $txt; ?></option>
                                                <?php endforeach; ?>
                                            </select>


                                        <?php endif; ?>

                                    </label>
                                </fieldset>
                                <p class="description"><?php _e("Useful thing when you already started your site and use dynamic recount -> it make recount very fast! Of course if you added new posts which have to be in search results you have to clean this cache! RECOMMENDED to set it to any time-term from the list to avoid query slowing in future!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>


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
                                $sql = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . MetaDataFilterCore::$mdf_query_cache_table . "` (
                                    `mkey` varchar(64) NOT NULL,
                                    `mvalue` text NOT NULL,
                                     KEY `mkey` (`mkey`)
                                  ){$charset_collate}";

                                if ($wpdb->query($sql) === false) {
                                    ?>
                                    <p class="description"><?php _e("MDTF cannot create the database table! Make sure that your mysql user has the CREATE privilege! Do it manually using your host panel&phpmyadmin!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                    <code><?php echo $sql; ?></code>
                                    <input type="hidden" name="meta_data_filter_settings[cache_count_data]" value="0" />
                                    <?php
                                    echo $wpdb->last_error;
                                }
                                ?>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label for="cache_terms_data"><?php _e("Cache terms", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <label>

                                        <?php
                                        $cache_terms_data = array(
                                            0 => __("No", 'wp-meta-data-filter-and-taxonomy-filter'),
                                            1 => __("Yes", 'wp-meta-data-filter-and-taxonomy-filter')
                                        );
                                        ?>

                                        <?php
                                        if (!isset($data['cache_terms_data']) OR empty($data['cache_terms_data'])) {
                                            $data['cache_terms_data'] = 0;
                                        }
                                        ?>
                                        <select name="meta_data_filter_settings[cache_terms_data]">
                                            <?php foreach ($cache_terms_data as $key => $value) : ?>
                                                <option value="<?php echo $key; ?>" <?php if ($data['cache_terms_data'] == $key): ?>selected="selected"<?php endif; ?>><?php echo $value; ?></option>
                                            <?php endforeach; ?>
                                        </select>


                                        <?php if ($data['cache_terms_data']): ?>

                                            &nbsp;<a href="#" class="button js_cache_terms_data_clear"><?php _e("clear cache", 'wp-meta-data-filter-and-taxonomy-filter') ?></a>&nbsp;<span style="color: green; font-weight: bold;"></span>

                                            &nbsp;
                                            <?php
                                            $clean_period = 0;
                                            if (isset($data['cache_terms_data_auto_clean'])) {
                                                $clean_period = $data['cache_terms_data_auto_clean'];
                                            }
                                            $periods = array(
                                                0 => __("do not clean cache automatically", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'hourly' => __("clean cache automatically hourly", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'twicedaily' => __("clean cache automatically twicedaily", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'daily' => __("clean cache automatically daily", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'days2' => __("clean cache automatically each 2 days", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'days3' => __("clean cache automatically each 3 days", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'days4' => __("clean cache automatically each 4 days", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'days5' => __("clean cache automatically each 5 days", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'days6' => __("clean cache automatically each 6 days", 'wp-meta-data-filter-and-taxonomy-filter'),
                                                'days7' => __("clean cache automatically each 7 days", 'wp-meta-data-filter-and-taxonomy-filter'),
                                            );
                                            ?>
                                            <select name="meta_data_filter_settings[cache_terms_data_auto_clean]">
                                                <?php foreach ($periods as $key => $txt): ?>
                                                    <option <?php selected($clean_period, $key) ?> value="<?php echo $key ?>"><?php echo $txt; ?></option>
                                                <?php endforeach; ?>
                                            </select>


                                        <?php endif; ?>

                                    </label>
                                </fieldset>
                                <p class="description"><?php _e("Useful thing when you already set your site IN THE PRODUCTION MODE - its getting terms for filter faster without big MySQL queries! If you actively adds new terms every day or week you can set cron period for cleaning. Another way set: 'not clean cache automatically'!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>

                            </td>
                        </tr>

                        <?php if (isset($_SERVER['SCRIPT_URI']) OR isset($_SERVER['REQUEST_URI'])): ?>
                            <tr valign="top">
                                <th scope="row"><label for="init_on_pages_only"><?php _e("Init plugin on the next site pages <span style='color: red;'>only</span>", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                                <td>
                                    <fieldset>
                                        <textarea name="meta_data_filter_settings[init_on_pages_only]" id="init_on_pages_only" style="width: 100%; height: 150px;"><?php echo @trim($data['init_on_pages_only']) ?></textarea>
                                    </fieldset>
                                    <p class="description"><?php _e("This option excludes initialization of the plugin on all pages of the site except links in the textarea. One row - one link!<br />Example: http://woocommerce.wp-filter.com/ajaxed-search-7/ - slash in the end of the link should be!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                </td>
                            </tr>
                        <?php endif; ?>


                        <tr valign="top">
                            <th scope="row"><label for="custom_css_code"><?php _e("Custom CSS code", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <textarea name="meta_data_filter_settings[custom_css_code]" id="custom_css_code" style="width: 100%; height: 200px;"><?php echo @stripcslashes($data['custom_css_code']) ?></textarea>
                                </fieldset>
                                <p class="description"><?php _e("If you are need to customize something and you don't want to lose your changes after update", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label for="js_after_ajax_done"><?php _e("JavaScript code after AJAX is done", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>
                                <fieldset>
                                    <textarea name="meta_data_filter_settings[js_after_ajax_done]" id="js_after_ajax_done" style="width: 100%; height: 200px;"><?php echo @stripcslashes($data['js_after_ajax_done']) ?></textarea>
                                </fieldset>
                                <p class="description"><?php _e("Use it when you are need additional action after AJAX redraw your products in shop page or in page with shortcode!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                            </td>
                        </tr>


                    </tbody>
                </table>
                </p>
            </div>


            <div id="tabs-9">
                <?php if (time() < 1638403199): ?>
                    <div style="text-align: center;">
                        <a href="https://1.envato.market/DmRod" target="_blank"><img src="https://pluginus.net/wp-content/uploads/2021/11/cybermonday-2021-1.jpg" alt="Cyber Monday 2021"></a><br>

                        <img src="https://pluginus.net/wp-content/uploads/2021/11/cybermonday-2021-timer2.gif" alt="Cyber Monday 2021 timer"><br>
                    </div>
                <?php endif; ?>



                <p>
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label><?php _e("Demo sites", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>

                                <ul style="margin: 6px;">
                                    <li>
                                        <a href="http://wp-filter.com/demo-sites/" target="_blank">All MDTF demo-sites with zip archives for free downloading</a>
                                    </li>

                                </ul>

                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><label><?php _e("Easy entry video tutorial", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>

                                <iframe width="560" height="315" src="https://www.youtube.com/embed/z31-zvX8TfM" frameborder="0" allowfullscreen></iframe>

                            </td>
                        </tr>


                        <tr valign="top">
                            <th scope="row"><label><?php _e("Recommended plugins", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                            <td>

                                <ul style="margin: 6px;">                                   

                                    <li>
                                        <a href="https://wordpress.org/plugins/woocommerce-currency-switcher/" target="_blank" style="color: red;">WooCommerce Currency Switcher</a><br />
                                        <p class="description"><?php _e("WooCommerce Currency Switcher – is the plugin that allows you to switch to different currencies and get their rates converted in the real time!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                    </li>

                                    <li>
                                        <a href="https://bulk-editor.com/" target="_blank" style="color: red;">WOOBE - WooCommerce Bulk Editor Professional</a><br />
                                        <p class="description"><?php _e("WordPress plugin for managing and bulk edit WooCommerce Products data in the reliable and flexible way! Be professionals with managing data of your e-shop!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                    </li>

                                    <li>
                                        <a href="https://wordpress.org/plugins/inpost-gallery/" target="_blank">InPost Gallery</a><br />
                                        <p class="description"><?php _e("Insert Gallery in post, page and custom post types just in two clicks", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                    </li>

                                    <li>
                                        <a href="https://wordpress.org/plugins/custom-post-type-ui/" target="_blank">Custom Post Type UI</a><br />
                                        <p class="description"><?php _e("This plugin provides an easy to use interface to create and administer custom post types and taxonomies in WordPress.", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                    </li>

                                    <li>
                                        <a href="https://wordpress.org/plugins/widget-logic/other_notes/" target="_blank">Widget Logic</a><br />
                                        <p class="description"><?php _e("Widget Logic lets you control on which pages widgets appear using", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                    </li>

                                    <li>
                                        <a href="https://wordpress.org/plugins/wp-super-cache/" target="_blank">WP Super Cache</a><br />
                                        <p class="description"><?php _e("Cache pages, allow to make a lot of search queries on your site without high load on your server!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                    </li>

                                    <li>
                                        <a href="https://wordpress.org/plugins/taxonomy-terms-order/" target="_blank">Category Order and Taxonomy Terms Order</a><br />
                                        <p class="description"><?php _e("Order Categories and all custom taxonomies terms (hierarchically) and child terms using a Drag and Drop Sortable javascript capability", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                    </li>



                                    <li>
                                        <a href="http://codecanyon.pluginus.net/item/popping-sidebars-and-widgets-for-wordpress/8688220" target="_blank">Popping Sidebars and Widgets for WordPress</a><br />
                                        <p class="description"><?php _e("Create popping custom responsive layouts with sidebars and widgets in just a few clicks. Choose from variety of overlays, positioning, page visibility, active period, open/close events, custom styling, custom sidebars and much more.", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                    </li>


                                    <li>
                                        <a href="https://wordpress.org/plugins/autoptimize/" target="_blank">Autoptimize</a><br />
                                        <p class="description"><?php _e("It concatenates all scripts and styles, minifies and compresses them, adds expires headers, caches them, and moves styles to the page head, and scripts to the footer", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                    </li>


                                    <li>
                                        <a href="https://wordpress.org/plugins/pretty-link/" target="_blank">Pretty Link Lite</a><br />
                                        <p class="description"><?php _e("Shrink, beautify, track, manage and share any URL on or off of your WordPress website. Create links that look how you want using your own domain name!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                    </li>




                                    <li>
                                        <a href="https://wordpress.org/plugins/duplicator/" target="_blank">Duplicator</a><br />
                                        <p class="description"><?php _e("Duplicate, clone, backup, move and transfer an entire site from one location to another.", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                                    </li>

                                </ul>

                            </td>
                        </tr>


                    </tbody>
                </table>
                </p>
            </div>

            <div style="float: right; margin-top: 7px;">
                <a href="https://pluginus.net/" target="_blank" style="font-size: 11px; color: #aaa; text-decoration: none;">Powered by PluginUs.NET</a>
            </div>


        </div>
        <p class="submit" style="padding: 9px;"><input type="submit" value="<?php _e("Save Settings", 'wp-meta-data-filter-and-taxonomy-filter') ?>" class="button button-primary" name="meta_data_filter_settings_submit"></p>
    </form>


    <?php if (MetaDataFilter::$is_free): ?>
        <hr />
        <br />

        <h3>READ: <a href="https://wp-filter.com/difference-free-premium-versions-plugin/" target="_blank">Difference between FREE and PREMIUM versions of the plugin</a></h3>

        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 25%;">
                        <h3 style="color: red;">UPGRADE to Full version:</h3>
                        <a href="http://wp-filter.com/a/buy" alt="Get the plugin premium version" target="_blank"><img src="<?php echo self::get_application_uri() ?>images/mdtf_banner.jpg" alt="" style="width: 100%" /></a>
                    </td>
                    <td style="width: 25%;">
                        <h3>WOOCS - WooCommerce Currency Switcher:</h3>
                        <a href="https://currency-switcher.com/" target="_blank"><img src="<?php echo self::get_application_uri() ?>images/woocs.png" style="width: 100%" alt="WOOCS - WooCommerce Currency Switcher" /></a>
                    </td>

                    <td style="width: 25%;">
                        <h3>WOOT - WooCommerce Products Table:</h3>
                        <a href="https://products-tables.com/" target="_blank"><img src="<?php echo self::get_application_uri() ?>images/woot.png" alt="WOOT - WooCommerce Products Table" style="width: 100%" /></a>
                    </td>

                    <td style="width: 25%;">
                        <h3>BEAR - WooCommerce Bulk Editor Professional:</h3>
                        <a href="https://bulk-editor.com/" target="_blank"><img src="<?php echo self::get_application_uri() ?>images/bear.png" width="300" alt="BEAR - WooCommerce Bulk Editor Professional" style="width: 100%" /></a>
                    </td>

                </tr>
            </tbody>
        </table>

    <?php endif; ?>

    <hr />

    <p>
    <h3><?php _e("Mass assign filter-category ID to any posts types", 'wp-meta-data-filter-and-taxonomy-filter') ?></h3>
    <form action="<?php echo wp_nonce_url(admin_url('edit.php?post_type=' . MetaDataFilterCore::$slug . '&page=mdf_settings'), "mdtf_assign" . MetaDataFilterCore::$slug) ?>" method="post">
        <table class="form-table">
            <tbody>

                <tr valign="top">
                    <th scope="row"><label><?php _e("Supported post types", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                    <td>
                        <select name="mass_filter_slug">
                            <?php foreach (MetaDataFilterCore::get_post_types() as $post_type => $post_type_name) : ?>
                                <option value="<?php echo $post_type_name ?>"><?php echo $post_type_name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description"><?php _e("Check post types to which filter ID should be assign. Enter right data, do not joke with it!", 'wp-meta-data-filter-and-taxonomy-filter') ?></p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e("Enter filter-category ID", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                    <td>
                        <input type="text" class="regular-text" value="" name="mass_filter_id">
                        <p class="description">
                            <img src="<?php echo MetaDataFilter::get_application_uri() ?>images/mass_filter_id.png" alt="" /><br />
                        </p>
                    </td>
                </tr>


            </tbody>
        </table>


        <p class="submit"><input type="submit" value="<?php _e("Assign", 'wp-meta-data-filter-and-taxonomy-filter') ?>" class="button button-primary" name="meta_data_filter_assign_filter_id"></p>
    </form>

</p>

<style type="text/css">
    textarea{
        clear: both;
        border-style: solid;
        border-width: 3px;
        overflow: auto;
        padding: 0;
        line-height: 2em !important;
        font-size: 3em;
        /* background-image: -webkit-linear-gradient(rgba(0, 0, 0, .05) 50%, transparent 50%, transparent); */
        background-image: -moz-linear-gradient(rgba(0, 0, 0, .05) 50%, transparent 50%, transparent);
        background-image: -ms-linear-gradient(rgba(0, 0, 0, .05) 50%, transparent 50%, transparent);
        background-image: -o-linear-gradient(rgba(0, 0, 0, .05) 50%, transparent 50%, transparent);
        background-image: linear-gradient(rgba(0, 0, 0, .05) 50%, transparent 50%, transparent);
        -webkit-background-size: 100% 4em;
        background-size: 100% 4em;
        font-family: Monaco, "Andale Mono", "Courier New", Courier, monospace;
        -webkit-transition: all ease-in-out 0.5s;
        transition: all ease-in-out 0.5s;
        margin-bottom: 0;
        position: relative;
        left: 0;
        text-transform: none;
        width: 100%;
    }

</style>

<script type="text/javascript">
    //pre-loader
    jQuery(window).load(function () {
        jQuery(".woobe-admin-preloader").fadeOut("slow");
        jQuery(".mdf-admin-preloader").fadeOut("slow");
    });
    //***
    jQuery(function () {
        try {
            jQuery("#tabs").tabs();
            jQuery('.mdtf-color-picker').wpColorPicker();
        } catch (e) {

        }
        //+++
        jQuery('.js_cache_count_data_clear').click(function () {
            jQuery(this).next('span').html('clearing ...');
            var _this = this;
            var data = {
                action: "mdf_cache_count_data_clear"
            };
            jQuery.post(ajaxurl, data, function () {
                jQuery(_this).next('span').html('cleared!');
            });

            return false;
        });
        //+++
        jQuery('.js_cache_terms_data_clear').click(function () {
            jQuery(this).next('span').html('clearing ...');
            var _this = this;
            var data = {
                action: "mdf_cache_terms_data_clear"
            };
            jQuery.post(ajaxurl, data, function () {
                jQuery(_this).next('span').html('cleared!');
            });

            return false;
        });
        jQuery('#mdf_show_stat_options').click(function () {
            jQuery('.mdf_stat_option').toggle();
        });

    });



</script>
</div>

