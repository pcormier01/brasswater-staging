<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<h2><?php printf(__('Terms items of "%s"', 'wp-meta-data-filter-and-taxonomy-filter'), $tax_name); ?></h2>
<ul>
    <li>
        <select class="mdf_popup_terms_show_how" style="width: 50%;">
            <?php
            $types = array_merge(self::$tax_items_types, array('multi_select' => __('Multiple checkbox select', 'wp-meta-data-filter-and-taxonomy-filter')));
            ?>
            <?php foreach ($types as $key => $value) : ?>
                <option <?php if ($show_how == $key): ?>selected<?php endif; ?> value="<?php echo $key ?>"><?php echo $value ?></option>
            <?php endforeach; ?>
        </select>&nbsp;<b><?php echo _e('Show as', 'wp-meta-data-filter-and-taxonomy-filter'); ?></b>:
    </li>
    <li>
        <input class="mdf_popup_terms_tax_title" style="width: 50%;" type="text" name="" value="<?php echo $tax_title; ?>" /><b>&nbsp;<?php echo _e('Custom name/title for taxonomies', 'wp-meta-data-filter-and-taxonomy-filter'); ?></b><br />
        <i><?php echo _e('Leave this field empty to show taxonomy name as title. Use syntax like: <b>Country^Region^City</b> to display parents and childs with another titles in first drop-down option.', 'wp-meta-data-filter-and-taxonomy-filter'); ?></i>
    </li>
    <li class="mdf_selects_item" <?php if ($show_how != 'select'): ?>style="display: none;"<?php endif; ?>>
        <input class="mdf_popup_terms_select_size" style="width: 50%;" type="text" name="" value="<?php echo $select_size; ?>" />&nbsp;<b><?php echo _e('Drop-down size', 'wp-meta-data-filter-and-taxonomy-filter'); ?></b><br />
    </li>
    <li class="mdf_checkboxes_item" <?php if ($show_how != 'checkbox'): ?>style="display: none;"<?php endif; ?>>
        <input class="mdf_popup_terms_checkbox_max_height" style="width: 50%;" placeholder="px" type="text" name="" value="<?php echo $checkbox_max_height; ?>" />&nbsp;<b><?php echo _e('Block max height', 'wp-meta-data-filter-and-taxonomy-filter'); ?></b><br />
        <i><?php echo _e('Set 0 if you do not want to set max-height for this taxonomy', 'wp-meta-data-filter-and-taxonomy-filter'); ?></i>
    </li>

    <?php
    if (!isset($show_child_terms))
    {
        $show_child_terms = 0;
    }
    ?>
    <li class="mdf_selects_item" <?php if ($show_how != 'select'): ?>style="display: none;"<?php endif; ?>>
        <select style="width: 50%;" class="mdf_popup_terms_show_child_terms">
            <option <?php selected($show_child_terms, 0) ?> value="0"><?php echo _e('No', 'wp-meta-data-filter-and-taxonomy-filter'); ?></option>
            <option <?php selected($show_child_terms, 1) ?> value="1"><?php echo _e('Yes', 'wp-meta-data-filter-and-taxonomy-filter'); ?></option>
        </select>&nbsp;<b><?php echo _e('Show all child terms at once below', 'wp-meta-data-filter-and-taxonomy-filter'); ?></b><br />
        <table style="width: 100%;">
            <tr>
                <td>
                    <img src="<?php echo MetaDataFilter::get_application_uri() ?>images/show_child_terms.png" alt="<?php echo _e('Show all child terms at once below', 'wp-meta-data-filter-and-taxonomy-filter'); ?>" /><br />
                </td>
                <td style="width: 100%;">
                    <i><?php echo _e('Use this option if you are using title like Country^Region^City', 'wp-meta-data-filter-and-taxonomy-filter'); ?></i>
                </td>
            </tr>
        </table>
    </li>
    <li>
        <?php
        $toggles = array(
            0 => __("No toogle", 'wp-meta-data-filter-and-taxonomy-filter'),
            1 => __("Opened", 'wp-meta-data-filter-and-taxonomy-filter'),
            2 => __("Closed", 'wp-meta-data-filter-and-taxonomy-filter')
        );
        if (!isset($terms_section_toggle))
        {
            $terms_section_toggle = 0;
        }
        ?>
        <select name="mdf_popup_terms_section_toggles" class="mdf_popup_terms_section_toggles">
            <?php foreach ($toggles as $key => $value) : ?>
                <option <?php echo selected($terms_section_toggle, $key) ?> value="<?php echo $key ?>"><?php echo $value ?></option>
            <?php endforeach; ?>
        </select><br />
        <i><?php echo _e('How to use toggle with the current taxonomy block', 'wp-meta-data-filter-and-taxonomy-filter'); ?></i>
    </li>
</ul>

<script type="text/javascript">
    jQuery(function () {
        jQuery('.mdf_popup_terms_show_how').change(function () {
            switch (jQuery(this).val()) {
                case 'select':
                    jQuery('.mdf_selects_item').show(200);
                    jQuery('.mdf_checkboxes_item').hide(200);
                    jQuery('.mdf_popup_terms_section_toggles').show(200);
                    break;
                case 'checkbox':
                    jQuery('.mdf_selects_item').hide(200);
                    jQuery('.mdf_checkboxes_item').show(200);
                    jQuery('.mdf_popup_terms_section_toggles').show(200);
                    break;
                case 'multi_select':
                    jQuery('.mdf_selects_item').hide(200);
                    jQuery('.mdf_checkboxes_item').show(200);
                    jQuery('.mdf_popup_terms_section_toggles').hide(200);
                    break;
            }
        });
    });
</script>


<ul class="mdf_childs_terms">
    <?php mdf_print_childs_terms($terms_list, $hidden_term, 0); ?>
</ul>


<?php

function mdf_print_childs_terms($terms, $hidden_term, $level)
{
    ?>
    <?php foreach ($terms as $term_id => $term) : ?>
        <li>
            <div>
                <b><?php _e('Name', 'wp-meta-data-filter-and-taxonomy-filter'); ?></b>:&nbsp;<i style="color: #000;"><?php echo $term['name'] ?></i><br />
                <b><?php _e('Post Count', 'wp-meta-data-filter-and-taxonomy-filter'); ?></b>:&nbsp;<?php echo $term['count'] ?><br />
                <b><?php _e('Hide', 'wp-meta-data-filter-and-taxonomy-filter'); ?></b>:&nbsp;<input type="checkbox" <?php echo(in_array($term_id, $hidden_term)) ? 'checked' : '' ?> data-term-id="<?php echo $term_id ?>" style="opacity: 1 !important; position: relative;" class="mdf_popup_terms_checkbox" value="0" /><br />
            </div>
            <?php if (!empty($term['childs']) AND is_array($term['childs'])): ?>
                <ul style="<?php echo(in_array($term_id, $hidden_term)) ? 'display:none' : '' ?>">
                    <?php mdf_print_childs_terms($term['childs'], $hidden_term, $level + 1); ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
    <?php
}
