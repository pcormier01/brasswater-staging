<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>

<table class="form-table">
    <tbody>
        <tr valign="top">
            <th scope="row"><?php _e('Select filter category', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <fieldset>

                    <?php
                    if (!empty($mdf_terms))
                    {
                        ?>
                        <select id="mdf_shortcode_cat" name="shortcode_options[shortcode_cat]">
                            <option value="-1"><?php _e('Select filter category', 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                            <?php foreach ($mdf_terms as $term) : ?>
                                <option <?php echo selected($shortcode_options['shortcode_cat'], $term->term_id) ?> value="<?php echo $term->term_id ?>"><?php echo $term->name ?></option>
                            <?php endforeach; ?>
                        </select><br />
                        <?php
                    } else
                    {
                        ?>
                        <input type="hidden" name="shortcode_options[shortcode_cat]" value="-1" />
                        <?php
                        _e('No one filter MDTF Category created!', 'wp-meta-data-filter-and-taxonomy-filter');
                    }
                    ?>

                </fieldset>
            </td>
        </tr>

    </tbody>
</table>

<ul id="mdf_custom_popup_selected_filters">
    <?php
    if ($shortcode_options['shortcode_cat'] > 0)
    {
        echo MetaDataFilterShortcodes::draw_shortcode_html_items($shortcode_options, $html_items);
    }
    ?>

</ul>

<br /><br /><br />
<h3><?php _e('Shortcode options', 'wp-meta-data-filter-and-taxonomy-filter') ?></h3>

<input type="hidden" name="shortcode_options[options]" value="" />
<table class="form-table">
    <tbody>
        <tr valign="top">
            <th scope="row"><?php _e('Taxomies only in filter', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="hidden" name="shortcode_options[options][tax_only_in_filter]" value="<?php echo (int) @$shortcode_options['options']['tax_only_in_filter']; ?>">
                <input type="checkbox" class="mdf_shortcode_options" <?php if ((int) @$shortcode_options['options']['tax_only_in_filter']): ?>checked<?php endif; ?> /> <br />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Ignore filter-category in wp_query', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="hidden" name="shortcode_options[options][ignore_meta_data_filter_cat]" value="<?php echo (int) @$shortcode_options['options']['ignore_meta_data_filter_cat']; ?>">
                <input type="checkbox" class="mdf_shortcode_options" <?php if ((int) @$shortcode_options['options']['ignore_meta_data_filter_cat']): ?>checked<?php endif; ?> /> <br />
                <i><?php _e('Check this if you want to make searching by title/content in all posts of the selected post type slug!', 'wp-meta-data-filter-and-taxonomy-filter') ?></i>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Results output page link', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="text" class="widefat" placeholder="<?php _e('leave this field empty to use output page from the plugin settings', 'wp-meta-data-filter-and-taxonomy-filter') ?>" name="shortcode_options[options][search_result_page]" value="<?php echo @$shortcode_options['options']['search_result_page']; ?>"><br />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Results output template', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="text" class="widefat" placeholder="<?php _e('leave this field empty to use output page from the plugin settings', 'wp-meta-data-filter-and-taxonomy-filter') ?>" name="shortcode_options[options][search_result_tpl]" value="<?php echo @$shortcode_options['options']['search_result_tpl']; ?>"><br />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Custom text for search results', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="text" class="widefat" placeholder="<?php _e('Example: Found &lt;span&gt;%s&lt;/span&gt; items', 'wp-meta-data-filter-and-taxonomy-filter') ?>" name="shortcode_options[options][show_items_count_text]" value="<?php echo @$shortcode_options['options']['show_items_count_text']; ?>"><br />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Custom reset link', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="text" class="widefat" placeholder="<?php _e('Custom reset link. Leave this field empty to reset the form inputs ONLY by ajax.', 'wp-meta-data-filter-and-taxonomy-filter') ?>" name="shortcode_options[options][custom_reset_link]" value="<?php echo @$shortcode_options['options']['custom_reset_link']; ?>"><br />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="mdf_for_premium_label"><?php _e('Auto submit', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="checkbox" class="mdf_shortcode_options" disabled="" /> (<a href="https://pluginus.net/affiliate/meta-data-taxonomies-filter" target="_blank">premium version</a>)<br />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('AJAX Auto recount', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="hidden" name="shortcode_options[options][ajax_auto_submit]" value="<?php echo (int) @$shortcode_options['options']['ajax_auto_submit']; ?>">
                <input type="checkbox" class="mdf_shortcode_options" <?php if ((int) @$shortcode_options['options']['ajax_auto_submit']): ?>checked<?php endif; ?> />&nbsp;
                <?php _e('To use this option please uncheck "Auto submit". Use it to stay on the same page and see results filtered by AJAX.', 'wp-meta-data-filter-and-taxonomy-filter') ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('AJAX items output', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="hidden" name="shortcode_options[options][ajax_results]" value="<?php echo (int) @$shortcode_options['options']['ajax_results']; ?>">
                <input type="checkbox" class="mdf_shortcode_options" <?php if ((int) @$shortcode_options['options']['ajax_results']): ?>checked<?php endif; ?> />&nbsp;
                <?php _e('To use this option please uncheck "Auto submit" and check "AJAX Auto recount"', 'wp-meta-data-filter-and-taxonomy-filter') ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Show count', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="hidden" name="shortcode_options[options][show_count]" value="<?php echo (int) @$shortcode_options['options']['show_count']; ?>">
                <input type="checkbox" class="mdf_shortcode_options" <?php if ((int) @$shortcode_options['options']['show_count']): ?>checked<?php endif; ?> /> <br />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="mdf_for_premium_label"><?php _e('Hide items where count is 0', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="checkbox" class="mdf_shortcode_options" disabled="" />  (<a href="https://pluginus.net/affiliate/meta-data-taxonomies-filter" target="_blank">premium version</a>)<br />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e('Show reset button', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="hidden" name="shortcode_options[options][show_reset_button]" value="<?php echo (int) @$shortcode_options['options']['show_reset_button']; ?>">
                <input type="checkbox" class="mdf_shortcode_options" <?php if ((int) @$shortcode_options['options']['show_reset_button']): ?>checked<?php endif; ?> /> <br />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Show found items count text', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="hidden" name="shortcode_options[options][show_found_totally]" value="<?php echo (int) @$shortcode_options['options']['show_found_totally']; ?>">
                <input type="checkbox" class="mdf_shortcode_options" <?php if ((int) @$shortcode_options['options']['show_found_totally']): ?>checked<?php endif; ?> /> <br />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Filter button text', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <input type="text" class="widefat" name="shortcode_options[options][filter_button_text]" value="<?php echo @$shortcode_options['options']['filter_button_text']; ?>"><br />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Post type', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <?php
                $settings = self::get_settings();
                if (isset($settings['post_types']))
                {
                    if (!empty($settings['post_types']))
                    {
                        ?>
                        <select name="shortcode_options[options][post_type]" onchange="alert('<?php _e('To manage by taxonomies of the selected post type you should press Update button!', 'wp-meta-data-filter-and-taxonomy-filter') ?>')">
                            <?php foreach ($settings['post_types'] as $post_name) : ?>
                                <option <?php echo selected(@$shortcode_options['options']['post_type'], $post_name) ?> value="<?php echo $post_name ?>" class="level-0"><?php echo $post_name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Taxonomies options', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>

                <?php
                $taxonomies_tmp = get_object_taxonomies($shortcode_options['options']['post_type'], 'objects');
                $activated_taxonomies = @$shortcode_options['options']['taxonomies'];
                $output_tax_array = array();
                $taxonomies = array();
                if (!empty($taxonomies_tmp))
                {
                    if (!empty($activated_taxonomies) AND is_array($activated_taxonomies))
                    {
                        foreach ($activated_taxonomies as $tax_key => $val)
                        {
                            if ($val)
                            {
                                if (!isset($taxonomies_tmp[$tax_key]))
                                {
                                    continue;
                                }
                                $output_tax_array[$tax_key] = $taxonomies_tmp[$tax_key]->labels->name;
                            }
                        }
                    }
                    //+++
                    foreach ($taxonomies_tmp as $tax_key => $tax)
                    {
                        if (!key_exists($tax_key, $output_tax_array))
                        {
                            $taxonomies[$tax_key] = $tax->labels->name;
                        }
                    }
                }
                $output_tax_array = array_merge($output_tax_array, $taxonomies);
                ?>
                <?php if (!empty($output_tax_array)): ?>
                    <ul style="margin-left: 15px;" id="mdf_shotcode_taxonomies">
                        <?php foreach ($output_tax_array as $tax_key => $tax_name) : ?>
                            <li style="padding: 5px; border: solid 1px #ccc; margin-bottom: 11px;">
                                <?php $is_checked = (int) @$shortcode_options['options']['taxonomies'][$tax_key]; ?>
                                <input type="hidden" name="shortcode_options[options][taxonomies][<?php echo $tax_key ?>]" value="<?php echo $is_checked ?>">
                                <input type="checkbox" <?php echo checked($is_checked, 1) ?> class="mdf_shortcode_options" />&nbsp;<?php echo $tax_name; ?><br />
                                <div style="height: 5px;"></div>
                                <input type="text" style="width: 400px;" placeholder="<?php _e('taxonomy custom title', 'wp-meta-data-filter-and-taxonomy-filter') ?>" name="shortcode_options[options][taxonomies_title][<?php echo $tax_key ?>]" value="<?php echo @$shortcode_options['options']['taxonomies_title'][$tax_key] ?>">&nbsp;
                                <input type="text" style="width: 120px;" placeholder="<?php _e('block max-height', 'wp-meta-data-filter-and-taxonomy-filter') ?>" name="shortcode_options[options][taxonomies_checkbox_maxheight][<?php echo $tax_key ?>]" value="<?php echo @$shortcode_options['options']['taxonomies_checkbox_maxheight'][$tax_key] ?>">&nbsp;
                                <?php
                                $taxonomies_type = 'select';
                                if (isset($shortcode_options['options']['taxonomies_type'][$tax_key]))
                                {
                                    $taxonomies_type = $shortcode_options['options']['taxonomies_type'][$tax_key];
                                }
                                //***
                                $types = array_merge(self::$tax_items_types, array('multi_select' => __('Multiple checkbox select', 'wp-meta-data-filter-and-taxonomy-filter')));
                                ?>
                                <select name="shortcode_options[options][taxonomies_type][<?php echo $tax_key ?>]">
                                    <?php foreach ($types as $ikey => $iname) : ?>
                                        <option <?php selected($taxonomies_type, $ikey) ?> value="<?php echo $ikey ?>"><?php echo $iname ?></option>
                                    <?php endforeach; ?>
                                </select>&nbsp;
                                <?php
                                $show_child_terms = 0;
                                if (isset($shortcode_options['options']['taxonomies_show_child_terms'][$tax_key]))
                                {
                                    $show_child_terms = $shortcode_options['options']['taxonomies_show_child_terms'][$tax_key];
                                }
                                ?>
                                <select style="<?php if ($taxonomies_type != 'select'): ?>display: none;<?php endif; ?>" name="shortcode_options[options][taxonomies_show_child_terms][<?php echo $tax_key ?>]">
                                    <option <?php selected($show_child_terms, 0) ?> value="0"><?php echo _e('One child below', 'wp-meta-data-filter-and-taxonomy-filter'); ?></option>
                                    <option <?php selected($show_child_terms, 1) ?> value="1"><?php echo _e('All childs below', 'wp-meta-data-filter-and-taxonomy-filter'); ?></option>
                                </select>&nbsp;
                                <?php $is_checked = (int) @$shortcode_options['options']['taxonomies'][$tax_key]; ?>
                                
                                <input type="text" class="text" style="width: 100%;" placeholder="<?php printf(__('exluded terms ids for %s. Example: 11,22,33', 'wp-meta-data-filter-and-taxonomy-filter'), $tax_name) ?>" name="shortcode_options[options][excluded_terms][<?php echo $tax_key ?>]" value="<?php echo @$shortcode_options['options']['excluded_terms'][$tax_key] ?>"><br />
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><?php _e('Additional taxonomies conditions', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <textarea class="widefat" name="shortcode_options[options][additional_taxonomies]"><?php echo @$shortcode_options['options']['additional_taxonomies']; ?></textarea><br />
                <i><b><?php _e('Example', 'wp-meta-data-filter-and-taxonomy-filter') ?></b>: product_cat=96,3^boutiques=77,88. <b><?php _e('Syntax is', 'wp-meta-data-filter-and-taxonomy-filter') ?></b>: taxonomy_name=term_id,term_id,term_id ^ taxonomy_name2=term_id,term_id,term_id <br />...</i>
            </td>
        </tr>

        <?php 
        if(!isset($shortcode_options['options']['woo_search_panel_id'])){
            $shortcode_options['options']['woo_search_panel_id']='';
        }
        ?>
        <tr valign="top">
            <th scope="row"><?php _e('Sort panel', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <?php MDTF_SORT_PANEL::draw_options_select(@$shortcode_options['options']['woo_search_panel_id'], 'shortcode_options[options][woo_search_panel_id]'); ?>
            </td>
        </tr>



        <tr valign="top">
            <th scope="row"><?php _e('Shortcode front skin', 'wp-meta-data-filter-and-taxonomy-filter') ?><br /></th>
            <td>
                <?php $themes = MetaDataFilterShortcodes::get_sh_skins(); ?>
                <select name="shortcode_options[options][skin]">
                    <?php foreach ($themes as $theme) : ?>
                        <option <?php echo selected(@$shortcode_options['options']['skin'], $theme) ?> value="<?php echo $theme ?>"><?php echo $theme ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
    </tbody>
</table>

