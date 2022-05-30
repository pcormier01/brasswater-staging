<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
if (!isset($uniqid))
{
    $uniqid = 'medafi_' . uniqid();
}
?>
<a class="delete_item_from_data_group close-drag-holder" data-item-key="<?php echo $uniqid; ?>" href="#"></a>

<h4>
    <?php _e("Item Name", 'wp-meta-data-filter-and-taxonomy-filter') ?>:
</h4>

<p>
    <input type="text" placeholder="<?php _e("enter item name here", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo(isset($itemdata) ? $itemdata['name'] : "") ?>" name="html_item[<?php echo $uniqid ?>][name]" />
</p>

<br />
<a class="edit-slug button button-small mdf_admin_flter_item_box_toggle" href="#"><?php _e("Toggle", 'wp-meta-data-filter-and-taxonomy-filter') ?></a>
<div style="display:none;" class="mdf_admin_flter_item_box">

    <h4><?php _e("Item Type", 'wp-meta-data-filter-and-taxonomy-filter') ?>:&nbsp;</h4>

    <p>
        <label class="sel">
            <select name="html_item[<?php echo $uniqid ?>][type]" class="data_group_item_select">
                <?php foreach (self::$items_types as $key => $name) : ?>
                    <option <?php echo(isset($itemdata) ? ($itemdata['type'] == $key ? "selected" : "") : "") ?> value="<?php echo $key ?>"><?php _e($name) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </p>

    <br />

    <div class="data_group_item_html">

        <div class="data_group_item_template_slider data_group_input_type" style="display: <?php echo(isset($itemdata) ? ($itemdata['type'] == 'slider' ? "block" : "none") : "none") ?>">
            <h4><?php _e("From^To", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
            <input type="text" placeholder="<?php _e("example", 'wp-meta-data-filter-and-taxonomy-filter') ?>:0^100" value="<?php echo(isset($itemdata) ? $itemdata['slider'] : '') ?>" name="html_item[<?php echo $uniqid ?>][slider]" style="width: 45%;" /><br />
            <h4><?php _e("Slider step", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
            <input type="text" placeholder="<?php _e("0 or empty mean auto step", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo(isset($itemdata['slider_step']) ? $itemdata['slider_step'] : '') ?>" name="html_item[<?php echo $uniqid ?>][slider_step]" style="width: 45%;" /><br />
            <h4><?php _e("Prefix", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
            <input type="text" placeholder="<?php _e("Example: $", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo(isset($itemdata['slider_prefix']) ? $itemdata['slider_prefix'] : '') ?>" name="html_item[<?php echo $uniqid ?>][slider_prefix]" style="width: 45%;" /><br />
            <h4><?php _e("Postfix", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
            <input type="text" placeholder="<?php _e("Example: €", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo(isset($itemdata['slider_postfix']) ? $itemdata['slider_postfix'] : '') ?>" name="html_item[<?php echo $uniqid ?>][slider_postfix]" style="width: 45%;" /><br />
            <h4><?php _e("Prettify", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
            <?php $slider_prettify = (isset($itemdata['slider_prettify']) ? $itemdata['slider_prettify'] : 1) ?>
            <select name="html_item[<?php echo $uniqid ?>][slider_prettify]">
                <option value="1" <?php if ($slider_prettify == 1): ?>selected=""<?php endif; ?>><?php _e("Yes", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                <option value="0" <?php if ($slider_prettify == 0): ?>selected=""<?php endif; ?>><?php _e("No", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
            </select><br />




            <h4><?php _e("Search inside range", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
            <?php $slider_range_value = (isset($itemdata['slider_range_value']) ? (int) $itemdata['slider_range_value'] : 0) ?>
            <select name="html_item[<?php echo $uniqid ?>][slider_range_value]">
                <option value="0" <?php if ($slider_range_value == 0): ?>selected=""<?php endif; ?>><?php _e("No", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                <option value="1" <?php if ($slider_range_value == 1): ?>selected=""<?php endif; ?>><?php _e("Yes", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
            </select><br />
            <i><?php _e("Enabling this mode allows you to set 2 values in post for range-slider - RANGE 'From' and 'To'. Not possible to reflect this. On the front range-slider is single! Doesn work with WooCommerce functionality.", 'wp-meta-data-filter-and-taxonomy-filter') ?></i>


            <?php 
            if (class_exists('WooCommerce')): ?>
                <h4><?php _e("This is woo price, and I want to set range from min price to max price from database", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
                <?php $woo_price_auto = (isset($itemdata['woo_price_auto']) ? $itemdata['woo_price_auto'] : 0) ?>
                <select name="html_item[<?php echo $uniqid ?>][woo_price_auto]">
                    <option value="0" <?php if ($woo_price_auto == 0): ?>selected=""<?php endif; ?>><?php _e("No", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                    <option value="1" <?php if ($woo_price_auto == 1): ?>selected=""<?php endif; ?>><?php _e("Yes", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                </select><br />
            <?php endif; ?>

            <div style="display: none;">
                <h4><?php _e("Is multi value", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
                <?php $slider_multi_value = (isset($itemdata['slider_multi_value']) ? (int) $itemdata['slider_multi_value'] : 0) ?>
                <select name="html_item[<?php echo $uniqid ?>][slider_multi_value]">
                    <option value="0" <?php if ($slider_multi_value == 0): ?>selected=""<?php endif; ?>><?php _e("No", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                    <option value="1" <?php if ($slider_multi_value == 1): ?>selected=""<?php endif; ?>><?php _e("Yes", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                </select><br />
                <i><?php _e("ATTENTION: Do not use it if you do not need!! It takes more resources. Use this mode when you have not a lot of items to filter (about 100)", 'wp-meta-data-filter-and-taxonomy-filter') ?></i><br />
                <i><?php _e("Enabling this mode allows you to set more than 1 value in item for range-slider. For example: 34,45,96 - through comma.", 'wp-meta-data-filter-and-taxonomy-filter') ?></i>
            </div>
        </div>
        
        <!--start range  select   --> 
        
        <div class="data_group_item_template_range_select data_group_input_type" style="display: <?php echo(isset($itemdata) ? ($itemdata['type'] == 'range_select' ? "block" : "none") : "none") ?>">
            <h4><?php _e("From^To", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
            <input type="text" placeholder="<?php _e("example", 'wp-meta-data-filter-and-taxonomy-filter') ?>:0^100" value="<?php echo(isset($itemdata) ? $itemdata['range_select'] : '') ?>" name="html_item[<?php echo $uniqid ?>][range_select]" style="width: 45%;" /><br />
            <h4><?php _e("Slider step", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
            <input type="text" placeholder="<?php _e("0 or empty mean auto step", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo(isset($itemdata['range_select_step']) ? $itemdata['range_select_step'] : '') ?>" name="html_item[<?php echo $uniqid ?>][range_select_step]" style="width: 45%;" /><br />
            <h4><?php _e("Prefix", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
            <input type="text" placeholder="<?php _e("Example: $", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo(isset($itemdata['range_select_prefix']) ? $itemdata['range_select_prefix'] : '') ?>" name="html_item[<?php echo $uniqid ?>][range_select_prefix]" style="width: 45%;" /><br />
            <h4><?php _e("Postfix", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
            <input type="text" placeholder="<?php _e("Example: €", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo(isset($itemdata['range_select_postfix']) ? $itemdata['range_select_postfix'] : '') ?>" name="html_item[<?php echo $uniqid ?>][range_select_postfix]" style="width: 45%;" /><br />
            <h4><?php _e("Prettify", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
         
            <?php
            if (class_exists('WooCommerce')): ?>
                <h4><?php _e("This is woo price, and I want to set range from min price to max price from database", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
                <?php $woo_price_auto = (isset($itemdata['woo_price_auto_range_select']) ? $itemdata['woo_price_auto_range_select'] : 0) ?>
                <select name="html_item[<?php echo $uniqid ?>][woo_price_auto_range_select]">
                    <option value="0" <?php if ($woo_price_auto == 0): ?>selected=""<?php endif; ?>><?php _e("No", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                    <option value="1" <?php if ($woo_price_auto == 1): ?>selected=""<?php endif; ?>><?php _e("Yes", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                </select><br />
            <?php endif; ?>

            <div style="display: none;">
                <h4><?php _e("Is multi value", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
                <?php $slider_multi_value = (isset($itemdata['slider_multi_value']) ? (int) $itemdata['slider_multi_value'] : 0) ?>
                <select name="html_item[<?php echo $uniqid ?>][slider_multi_value]">
                    <option value="0" <?php if ($slider_multi_value == 0): ?>selected=""<?php endif; ?>><?php _e("No", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                    <option value="1" <?php if ($slider_multi_value == 1): ?>selected=""<?php endif; ?>><?php _e("Yes", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                </select><br />
                <i><?php _e("ATTENTION: Do not use it if you do not need!! It takes more resources. Use this mode when you have not a lot of items to filter (about 100)", 'wp-meta-data-filter-and-taxonomy-filter') ?></i><br />
                <i><?php _e("Enabling this mode allows you to set more than 1 value in item for range-slider. For example: 34,45,96 - through comma.", 'wp-meta-data-filter-and-taxonomy-filter') ?></i>
            </div>
        </div>
          <!-- //end range  select   --> 
        
          
          <!-- start search by author  --> 
        
        <div class="data_group_item_template_by_author data_group_input_type" style="display: <?php echo(isset($itemdata) ? ($itemdata['type'] == 'by_author' ? "block" : "none") : "none") ?>">
           <i><?php _e("Show search by author(select)", 'wp-meta-data-filter-and-taxonomy-filter') ?></i>
        </div>
          <!-- //end search by author    --> 
         <!-- start search label  --> 
        <div class="data_group_item_template_label data_group_input_type" style="display: <?php echo(isset($itemdata) ? ($itemdata['type'] == 'label' ? "block" : "none") : "none") ?>;">
            <input type="hidden" value="<?php echo(isset($itemdata) ? $itemdata['label'] : 0) ?>" name="html_item[<?php echo $uniqid ?>][label]" />
            <input style="display: none" type="checkbox" <?php echo(isset($itemdata) ? ($itemdata['label'] ? "checked" : "") : "") ?> class="mdf_option_label" />
        </div>
         
         <!-- //end search label    --> 
        <div class="data_group_item_template_checkbox data_group_input_type" style="display: <?php echo(isset($itemdata) ? ($itemdata['type'] == 'checkbox' ? "block" : "none") : "none") ?>;">
            <input type="hidden" value="<?php echo(isset($itemdata) ? $itemdata['checkbox'] : 0) ?>" name="html_item[<?php echo $uniqid ?>][checkbox]" />
            <input style="display: none" type="checkbox" <?php echo(isset($itemdata) ? ($itemdata['checkbox'] ? "checked" : "") : "") ?> class="mdf_option_checkbox" />
        </div>
        <div class="data_group_item_template_textinput data_group_input_type" style="display: <?php echo(isset($itemdata) ? ($itemdata['type'] == 'textinput' ? "block" : "none") : "none") ?>;">
            <input type="text" placeholder="<?php _e("enter placeholder text", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo(isset($itemdata['textinput']) ? $itemdata['textinput'] : '') ?>" name="html_item[<?php echo $uniqid ?>][textinput]" />&nbsp;
            <?php $target = (isset($itemdata['textinput_target']) ? $itemdata['textinput_target'] : 'self'); ?>
            <select name="html_item[<?php echo $uniqid ?>][textinput_target]" class="mdf_textinput_tag_selector">
                <option <?php selected('self', $target) ?> value="self"><?php _e("self", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                <option <?php selected('title', $target) ?> value="title"><?php _e("post title", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                <option <?php selected('content', $target) ?> value="content"><?php _e("post content", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                <option <?php selected('title_or_content', $target) ?> value="title_or_content"><?php _e("title or content on the same time", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                <option <?php selected('title_and_content', $target) ?> value="title_and_content"><?php _e("title and content on the same time", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                <!-- <option <?php selected('tag', $target) ?> value="tag"><?php _e("tag", 'wp-meta-data-filter-and-taxonomy-filter') ?></option> -->
            </select>&nbsp;


            <!-- <input type="text" style="width: 150px;<?php if ($target != 'tag'): ?>display: none;<?php endif; ?>" class="mdf_textinput_tag" placeholder="<?php _e("enter tag", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo(isset($itemdata['textinput_tag']) ? $itemdata['textinput_tag'] : 'product_tag') ?>" name="html_item[<?php echo $uniqid ?>][textinput_tag]" />&nbsp; -->


            <?php $textinput_mode = (isset($itemdata['textinput_mode']) ? $itemdata['textinput_mode'] : 'like'); ?>
            <select name="html_item[<?php echo $uniqid ?>][textinput_mode]">
                <option <?php selected('like', $textinput_mode) ?> value="like"><?php _e("like", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                <option <?php selected('exact', $textinput_mode) ?> value="exact"><?php _e("exact", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
            </select>&nbsp;
            <?php $textinput_inback_display_as = (isset($itemdata['textinput_inback_display_as']) ? $itemdata['textinput_inback_display_as'] : 'textinput'); ?>
            <select name="html_item[<?php echo $uniqid ?>][textinput_inback_display_as]" class="mdf_textinput_display_as_selector">
                <option <?php selected('textinput', $textinput_inback_display_as) ?> value="textinput"><?php _e("show as textinput in backend", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                <option <?php selected('textarea', $textinput_inback_display_as) ?> value="textarea"><?php _e("show as textarea in backend", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
            </select>
        </div>
        <div class="data_group_item_template_calendar data_group_input_type" style="display: <?php echo(isset($itemdata) ? ($itemdata['type'] == 'calendar' ? "block" : "none") : "none") ?>;">

            <?php _e("jQuery-ui calendar: from - to", 'wp-meta-data-filter-and-taxonomy-filter'); ?>

        </div>
        <div class="data_group_item_template_select data_group_input_type" style="display: <?php echo(isset($itemdata) ? ($itemdata['type'] == 'select' ? "block" : "none") : "none") ?>;">
            <h4><?php _e("Drop-down size", 'wp-meta-data-filter-and-taxonomy-filter') ?>:</h4>
            <input type="text" placeholder="<?php _e("enter a digit from 1 to ...", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo(isset($itemdata['select_size']) ? $itemdata['select_size'] : 1) ?>" name="html_item[<?php echo $uniqid ?>][select_size]" style="width: 45%;" /><br />
            <h4><?php _e("Drop-down first option title", 'wp-meta-data-filter-and-taxonomy-filter') ?>:</h4>
            <input type="text" placeholder="<?php _e("Any", 'wp-meta-data-filter-and-taxonomy-filter') ?>" value="<?php echo(isset($itemdata['select_option_title']) ? $itemdata['select_option_title'] : '') ?>" name="html_item[<?php echo $uniqid ?>][select_option_title]" style="width: 45%;" /><br />
            <i><?php _e("Leave this field empty to use defined in widget string: Any", 'wp-meta-data-filter-and-taxonomy-filter') ?></i><br />

            <br />
            <a href="#" class="add_option_to_data_item_select button" data-append="0" data-group-index="" data-group-item-index="<?php echo $uniqid ?>"><?php _e("Prepend drop-down option", 'wp-meta-data-filter-and-taxonomy-filter') ?></a><br />
            <br /><br />
            <ul class="data_item_select_options">

                <?php if (isset($itemdata)): ?>

                    <?php if (!empty($itemdata['select'])): ?>
                        <?php foreach ($itemdata['select'] as $k => $value) : ?>
                            <li>
                                <input type="text" name="html_item[<?php echo $uniqid ?>][select][]" value="<?php echo $value ?>">&nbsp;<input type="text" class="data_item_select_option_key" placeholder="<?php _e("key for the current option - must be unique", 'wp-meta-data-filter-and-taxonomy-filter') ?>" name="html_item[<?php echo $uniqid ?>][select_key][]" value="<?php echo((isset($itemdata['select_key'][$k]) AND ! empty($itemdata['select_key'][$k])) ? /* sanitize_title */trim($itemdata['select_key'][$k]) : /* sanitize_title */trim($value)) ?>" style="width: 25%;">&nbsp;<a class="delete_option_from_data_item_select remove-button" href="#"></a>
                                &nbsp;<img width="15" style="vertical-align: middle;" src="<?php echo MetaDataFilter::get_application_uri() ?>images/drag_and_drope.png" title="<?php _e("drag and drope", 'wp-meta-data-filter-and-taxonomy-filter') ?>" alt="<?php _e("drag and drope", 'wp-meta-data-filter-and-taxonomy-filter') ?>" />
                                <br />
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>

                <?php endif; ?>

            </ul>
            <br />
            <a href="#" class="add_option_to_data_item_select button" data-append="1" data-group-index="" data-group-item-index="<?php echo $uniqid ?>"><?php _e("Append drop-down option", 'wp-meta-data-filter-and-taxonomy-filter') ?></a><br />
            <br />
            <h4><?php _e("Search inside range.", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
            <?php $select_range_value = (isset($itemdata['select_range_value']) ? (int) $itemdata['select_range_value'] : 0) ?>
            <select name="html_item[<?php echo $uniqid ?>][select_range_value]">
                <option value="0" <?php if ($select_range_value == 0): ?>selected=""<?php endif; ?>><?php _e("No", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                <option value="1" <?php if ($select_range_value == 1): ?>selected=""<?php endif; ?>><?php _e("Yes", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
            </select><br />
            <i><?php _e("Enabling this mode allows you to set 1 decimal value in post for looking it in range. Options of such drop-down must have names as: 0-500, 501-1000, 1001-2000 and etc...", 'wp-meta-data-filter-and-taxonomy-filter') ?></i>

            <br />
            <h4><?php _e("Sort options by alphabetical order", 'wp-meta-data-filter-and-taxonomy-filter') ?></h4>
            <?php $select_sort_value = (isset($itemdata['select_sort_value_by_alphabetical']) ? (int) $itemdata['select_sort_value_by_alphabetical'] : 0) ?>
            <select name="html_item[<?php echo $uniqid ?>][select_sort_value_by_alphabetical]">
                <option value="0" <?php if ($select_sort_value == 0): ?>selected=""<?php endif; ?>><?php _e("No", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
                <option value="1" <?php if ($select_sort_value == 1): ?>selected=""<?php endif; ?>><?php _e("Yes", 'wp-meta-data-filter-and-taxonomy-filter') ?></option>
            </select><br />
            <i><?php _e("Sort options by alphabetical order on the front", 'wp-meta-data-filter-and-taxonomy-filter') ?></i>



        </div>


        <div class="data_group_item_template_taxonomy data_group_input_type" style="display: <?php echo(isset($itemdata) ? ($itemdata['type'] == 'taxonomy' ? "block" : "none") : "none") ?>">
            <i><?php _e("By logic here must be taxonomies constructor. But, to add more flexibility to the plugin,  taxonomies are selected in the widget. So you can use the same group for different post types, or the same post type but different widgets. If there no taxonomies selected in the widget - nothing will appear on front of site in search form of the widget.", 'wp-meta-data-filter-and-taxonomy-filter') ?></i>
        </div>


        <div class="mdf_item_footer" <?php if (isset($itemdata) AND ( $itemdata['type'] == 'taxonomy' OR $itemdata['type'] == 'by_author')): ?>style="display: none;"<?php endif; ?>>

            <h4><?php _e("Item Description", 'wp-meta-data-filter-and-taxonomy-filter') ?>:</h4>

            <textarea name="html_item[<?php echo $uniqid ?>][description]"><?php echo(isset($itemdata) ? $itemdata['description'] : "") ?></textarea><br />


            <h4><?php _e("Item meta key", 'wp-meta-data-filter-and-taxonomy-filter') ?>:</h4>
            <input type="text" placeholder="medafi_total_sales" value="<?php echo $uniqid ?>" name="html_item[<?php echo $uniqid ?>][meta_key]" style="width: 45%;" />&nbsp;<a href="#" class="button mdf_change_meta_key_butt" data-old-key="<?php echo $uniqid ?>"><?php _e("change meta key", 'wp-meta-data-filter-and-taxonomy-filter') ?></a><br />
            <i><b style="color: red;"><?php _e("Attention", 'wp-meta-data-filter-and-taxonomy-filter') ?></b>: <?php _e("meta key must be begin from <b>medafi_</b> prefix, another way you will have problems! If you are using this key somewhere in code be ready to change it there!<br /> Change keys please for saved filter and filters items only, not for new and just created!", 'wp-meta-data-filter-and-taxonomy-filter') ?></i><br />
            <br />


            <div class="mdf_item_footer_reflection" <?php if (isset($itemdata) AND ( $itemdata['type'] == 'map' OR $itemdata['type'] == 'calendar' OR $itemdata['type'] == 'by_author')): ?>style="display: none;"<?php endif; ?>>

                <h4><?php _e("Reflect value from meta key", 'wp-meta-data-filter-and-taxonomy-filter') ?>:</h4>
                <?php
                $is_reflected = isset($itemdata['is_reflected']) ? $itemdata['is_reflected'] : 0;
                $reflected_key = isset($itemdata['reflected_key']) ? $itemdata['reflected_key'] : '';
                ?>
                <input type="hidden" name="html_item[<?php echo $uniqid ?>][is_reflected]" value="<?php echo $is_reflected ?>" />
                <input type="checkbox" class="mdf_is_reflected" <?php if ($is_reflected): ?>checked<?php endif; ?> />&nbsp;<input type="text" <?php if (!$is_reflected): ?>disabled<?php endif; ?> placeholder="<?php if (!$is_reflected): ?>disabled<?php else: ?>enabled<?php endif; ?>" value="<?php echo trim(esc_attr($reflected_key)) ?>" name="html_item[<?php echo $uniqid ?>][reflected_key]" style="width: 45%;" /><br />
                <i><?php _e("Example: <b>_price</b>, where <i>_price</i> is reflected meta field key in products of woocommerce.<br /> Reflection synchronizes data with already existing meta keys and makes them searchable!", 'wp-meta-data-filter-and-taxonomy-filter') ?></i>

            </div>
        </div>

        <div class="data_group_item_template_map data_group_input_type" style="display: <?php echo(isset($itemdata) ? ($itemdata['type'] == 'map' ? "block" : "none") : "none") ?>;">

            <?php _e("Set map info in each post you are going to filter. The data will be applyed on the google map.", 'wp-meta-data-filter-and-taxonomy-filter'); ?>

        </div>


        <?php
        global $post;
        $mdf_section_id = 0;
        if (is_object($post))
        {
            $mdf_section_id = $post->ID;
        }
        ?>

        <input type="hidden" name="html_item[<?php echo $uniqid ?>][mdf_section_id]" value="<?php echo $mdf_section_id ?>" />


    </div>

</div>

<div class="mdf-drag-place"></div>
