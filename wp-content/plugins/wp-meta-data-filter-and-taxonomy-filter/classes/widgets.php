<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php

class MetaDataFilter_Search extends WP_Widget {

//Widget Setup
    function __construct() {

        parent::__construct(__CLASS__, __('MDTF', 'wp-meta-data-filter-and-taxonomy-filter'), array(
            'classname' => __CLASS__,
            'description' => __('Meta Data Filter - search and filter data by taxonomies and meta fileds.', 'wp-meta-data-filter-and-taxonomy-filter')
                )
        );
    }

//Widget view
    function widget($args, $instance) {
		if(!isset($instance['meta_data_filter_slug'])){
			$instance['meta_data_filter_slug'] = "";
		}		
        $args['instance'] = $instance;
        $args['sidebar_id'] = (isset($args['id']))?$args['id']:'';
        $args['sidebar_name'] = (isset($args['name']))?$args['name']:'';
		
        MetaDataFilter::front_script_includer();
        echo MetaDataFilterHtml::render_html(MetaDataFilterCore::get_application_path() . 'views/widgets/search.php', $args);
    }

//Update widget
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance[MetaDataFilterCore::$slug_cat] = $new_instance[MetaDataFilterCore::$slug_cat];
        $instance['meta_data_filter_slug'] = $new_instance['meta_data_filter_slug'];
        $instance['hide_meta_filter_values'] = (isset($new_instance['hide_meta_filter_values'])) ? $new_instance['hide_meta_filter_values'] : false;
        $instance['hide_tax_filter_values'] = (isset($new_instance['hide_tax_filter_values'])) ? $new_instance['hide_tax_filter_values'] : false;
        $instance['show_checkbox_items_count'] = (isset($new_instance['show_checkbox_items_count'])) ? $new_instance['show_checkbox_items_count'] : false;
        $instance['show_select_items_count'] = (isset($new_instance['show_select_items_count'])) ? $new_instance['show_select_items_count'] : false;
        $instance['show_slider_items_count'] = (isset($new_instance['show_slider_items_count'])) ? $new_instance['show_slider_items_count'] : false;
        $instance['show_items_count_dynam'] = (isset($new_instance['show_items_count_dynam'])) ? $new_instance['show_items_count_dynam'] : false;
        $instance['hide_items_where_count_0'] = (isset($new_instance['hide_items_where_count_0'])) ? $new_instance['hide_items_where_count_0'] : false;
        $instance['act_without_button'] = false;
        $instance['and_or'] = $new_instance['and_or'];
        $instance['title_for_any'] = $new_instance['title_for_any'];
        $instance['title_for_filter_button'] = $new_instance['title_for_filter_button'];
        $instance['show_filter_button_after_each_block'] = (isset($new_instance['show_filter_button_after_each_block'])) ? $new_instance['show_filter_button_after_each_block'] : false;
        $instance['taxonomies'] = (isset($new_instance['taxonomies'])) ? $new_instance['taxonomies'] : '';
        $instance['taxonomies_options_hide'] = $new_instance['taxonomies_options_hide'];
        $instance['taxonomies_options_show_how'] = $new_instance['taxonomies_options_show_how'];
        $instance['taxonomies_options_select_size'] = $new_instance['taxonomies_options_select_size'];
        $instance['taxonomies_options_tax_title'] = $new_instance['taxonomies_options_tax_title'];
        $instance['taxonomies_options_checkbox_max_height'] = $new_instance['taxonomies_options_checkbox_max_height'];
        $instance['taxonomies_options_behaviour'] = $new_instance['taxonomies_options_behaviour'];
        $instance['taxonomies_options_show_count'] = (isset($new_instance['taxonomies_options_show_count'])) ? $new_instance['taxonomies_options_show_count'] : false;
        $instance['taxonomies_options_post_recount_dyn'] = (isset($new_instance['taxonomies_options_post_recount_dyn'])) ? $new_instance['taxonomies_options_post_recount_dyn'] : false;
        $instance['taxonomies_options_hide_terms_0'] = false;
        $instance['taxonomies_options_show_child_terms'] = $new_instance['taxonomies_options_show_child_terms'];
        $instance['taxonomies_options_terms_section_toggle'] = $new_instance['taxonomies_options_terms_section_toggle'];
        $instance['show_reset_button'] = (isset($new_instance['show_reset_button'])) ? $new_instance['show_reset_button'] : false;
        $instance['show_found_totally'] = (isset($new_instance['show_found_totally'])) ? $new_instance['show_found_totally'] : false;
        $instance['ajax_items_recount'] = (isset($new_instance['ajax_items_recount'])) ? $new_instance['ajax_items_recount'] : false;
        $instance['search_result_page'] = $new_instance['search_result_page'];
        $instance['search_result_tpl'] = $new_instance['search_result_tpl'];
        $instance['show_items_count_text'] = (isset($new_instance['show_items_count_text'])) ? $new_instance['show_items_count_text'] : false;
        $instance['reset_link'] = $new_instance['reset_link'];
        $instance['ajax_output'] = (isset($new_instance['ajax_output'])) ? $new_instance['ajax_output'] : false;
        $instance['woo_search_panel_id'] = (isset($new_instance['woo_search_panel_id'])) ? $new_instance['woo_search_panel_id'] : false;
        $instance['additional_taxonomies'] = $new_instance['additional_taxonomies'];
        $instance['filter_categories_addit'] = $new_instance['filter_categories_addit'];
        $instance['ajax_results'] = (isset($new_instance['ajax_results'])) ? $new_instance['ajax_results'] : false;

        return $instance;
    }

//Widget form
    function form($instance) {
        wp_enqueue_script('mdf_popup', MetaDataFilter::get_application_uri() . 'js/pn_popup/pn_advanced_wp_popup.js', array('jquery', 'jquery-ui-core', 'jquery-ui-draggable'));
        wp_enqueue_style('mdf_popup', MetaDataFilter::get_application_uri() . 'js/pn_popup/styles.css');
//Defaults
        $defaults = array(
            'title' => __('Meta Data Filter', 'wp-meta-data-filter-and-taxonomy-filter'),
            MetaDataFilterCore::$slug_cat => 0,
            'meta_data_filter_slug' => '',
            'hide_meta_filter_values' => 'false',
            'hide_tax_filter_values' => 'false',
            'show_checkbox_items_count' => 'true',
            'show_select_items_count' => 'true',
            'show_slider_items_count' => 'true',
            'show_items_count_dynam' => 'true',
            'hide_items_where_count_0' => 'false',
            'act_without_button' => 'false',
            'and_or' => 'and',
            'title_for_any' => __('Any', 'wp-meta-data-filter-and-taxonomy-filter'),
            'title_for_filter_button' => __('Filter', 'wp-meta-data-filter-and-taxonomy-filter'),
            'show_filter_button_after_each_block' => 'false',
            'taxonomies' => array(),
            'taxonomies_options_hide' => array(),
            'taxonomies_options_show_how' => 'select',
            'taxonomies_options_select_size' => 1,
            'taxonomies_options_tax_title' => '',
            'taxonomies_options_checkbox_max_height' => 0,
            'taxonomies_options_behaviour' => 'AND',
            'taxonomies_options_show_count' => 'true',
            'taxonomies_options_post_recount_dyn' => 'true',
            'taxonomies_options_hide_terms_0' => 'false',
            'taxonomies_options_show_child_terms' => 0,
            'taxonomies_options_terms_section_toggle' => 0,
            'show_reset_button' => 'true',
            'show_found_totally' => 'true',
            'ajax_items_recount' => 'false',
            'search_result_page' => '',
            'search_result_tpl' => '',
            'reset_link' => '',
            'show_items_count_text' => __('Found &lt;span&gt;%s&lt;/span&gt; items', 'wp-meta-data-filter-and-taxonomy-filter'),
            'ajax_output' => 'false',
            'woo_search_panel_id' => 0,
            'additional_taxonomies' => '',
            'filter_categories_addit' => '',
            'ajax_results' => 'false'
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $args = array();
        $args['instance'] = $instance;
        $args['widget'] = $this;
        wp_enqueue_script('meta_data_filter_widget', MetaDataFilterCore::get_application_uri() . 'js/widget_back.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'));
        echo MetaDataFilterHtml::render_html(MetaDataFilterCore::get_application_path() . 'views/widgets/search_form.php', $args);
    }

}

class MetaDataFilter_TaxSearch extends WP_Widget {

//Widget Setup
    function __construct() {
        parent::__construct(__CLASS__, __('MDTF Taxonomies only', 'wp-meta-data-filter-and-taxonomy-filter'), array(
            'classname' => __CLASS__,
            'description' => __('MDTF Taxonomies - search and filter data by taxonomies only.', 'wp-meta-data-filter-and-taxonomy-filter')
                )
        );
    }

//Widget view
    function widget($args, $instance) {
        $args['instance'] = $instance;
        $args['sidebar_id'] = (isset($args['id']))?$args['id']:'';
        $args['sidebar_name'] = (isset($args['name']))?$args['name']:'';
        MetaDataFilter::front_script_includer();
        echo MetaDataFilterHtml::render_html(MetaDataFilterCore::get_application_path() . 'views/widgets/search.php', $args);
    }

//Update widget
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance[MetaDataFilterCore::$slug_cat] = $new_instance[MetaDataFilterCore::$slug_cat];
        $instance['meta_data_filter_slug'] = $new_instance['meta_data_filter_slug'];
        $instance['hide_meta_filter_values'] = $new_instance['hide_meta_filter_values'];
        $instance['hide_tax_filter_values'] = $new_instance['hide_tax_filter_values'];
        if (isset($new_instance['show_checkbox_items_count'])) {
            $instance['show_checkbox_items_count'] = $new_instance['show_checkbox_items_count'];
        }
        if (isset($new_instance['show_select_items_count'])) {
            $instance['show_select_items_count'] = $new_instance['show_select_items_count'];
        }
        if (isset($new_instance['show_slider_items_count'])) {
            $instance['show_slider_items_count'] = $new_instance['show_slider_items_count'];
        }
        if (isset($new_instance['show_items_count_dynam'])) {
            $instance['show_items_count_dynam'] = $new_instance['show_items_count_dynam'];
        }
        if (isset($new_instance['hide_items_where_count_0'])) {
            $instance['hide_items_where_count_0'] = $new_instance['hide_items_where_count_0'];
        }
        $instance['act_without_button'] = false;
        if (isset($new_instance['and_or'])) {
            $instance['and_or'] = $new_instance['and_or'];
        }
        if (isset($new_instance['title_for_any'])) {
            $instance['title_for_any'] = $new_instance['title_for_any'];
        }
        $instance['title_for_filter_button'] = $new_instance['title_for_filter_button'];
        if (isset($new_instance['show_filter_button_after_each_block'])) {
            $instance['show_filter_button_after_each_block'] = $new_instance['show_filter_button_after_each_block'];
        }
        $instance['taxonomies'] = $new_instance['taxonomies'];
        $instance['taxonomies_options_hide'] = $new_instance['taxonomies_options_hide'];
        $instance['taxonomies_options_show_how'] = $new_instance['taxonomies_options_show_how'];
        $instance['taxonomies_options_select_size'] = $new_instance['taxonomies_options_select_size'];
        $instance['taxonomies_options_tax_title'] = $new_instance['taxonomies_options_tax_title'];
        $instance['taxonomies_options_checkbox_max_height'] = $new_instance['taxonomies_options_checkbox_max_height'];
        $instance['taxonomies_options_behaviour'] = $new_instance['taxonomies_options_behaviour'];
        $instance['taxonomies_options_show_count'] = (isset($new_instance['taxonomies_options_show_count'])) ? $new_instance['taxonomies_options_show_count'] : false;
        $instance['taxonomies_options_post_recount_dyn'] = (isset($new_instance['taxonomies_options_post_recount_dyn'])) ? $new_instance['taxonomies_options_post_recount_dyn'] : false;
        $instance['taxonomies_options_hide_terms_0'] = false;
        $instance['taxonomies_options_show_child_terms'] = $new_instance['taxonomies_options_show_child_terms'];
        $instance['taxonomies_options_terms_section_toggle'] = $new_instance['taxonomies_options_terms_section_toggle'];
        $instance['show_reset_button'] = (isset($new_instance['show_reset_button'])) ? $new_instance['show_reset_button'] : false;
        $instance['show_found_totally'] = (isset($new_instance['show_found_totally'])) ? $new_instance['show_found_totally'] : false;
        $instance['ajax_items_recount'] = (isset($new_instance['ajax_items_recount'])) ? $new_instance['ajax_items_recount'] : false;
        $instance['search_result_page'] = $new_instance['search_result_page'];
        $instance['search_result_tpl'] = $new_instance['search_result_tpl'];
        $instance['show_items_count_text'] = $new_instance['show_items_count_text'];
        $instance['reset_link'] = $new_instance['reset_link'];
        $instance['ajax_output'] = (isset($new_instance['ajax_output'])) ? $new_instance['ajax_output'] : false;
        $instance['woo_search_panel_id'] = $new_instance['woo_search_panel_id'];
        $instance['additional_taxonomies'] = $new_instance['additional_taxonomies'];
        if (isset($new_instance['filter_categories_addit'])) {
            $instance['filter_categories_addit'] = $new_instance['filter_categories_addit'];
        }
        $instance['ajax_results'] = (isset($new_instance['ajax_results'])) ? $new_instance['ajax_results'] : false;

        return $instance;
    }

//Widget form
    function form($instance) {
        wp_enqueue_script('mdf_popup', MetaDataFilter::get_application_uri() . 'js/pn_popup/pn_advanced_wp_popup.js', array('jquery', 'jquery-ui-core', 'jquery-ui-draggable'));
        wp_enqueue_style('mdf_popup', MetaDataFilter::get_application_uri() . 'js/pn_popup/styles.css');
//Defaults
        $defaults = array(
            'title' => __('MDTF Taxonomies', 'wp-meta-data-filter-and-taxonomy-filter'),
            MetaDataFilterCore::$slug_cat => MetaDataFilter::WIDGET_TAXONOMIES_ONLY,
            'meta_data_filter_slug' => '',
            'hide_meta_filter_values' => 'true',
            'hide_tax_filter_values' => 'false',
            'show_checkbox_items_count' => 'false',
            'show_select_items_count' => 'false',
            'show_slider_items_count' => 'false',
            'show_items_count_dynam' => 'false',
            'hide_items_where_count_0' => 'false',
            'act_without_button' => 'false',
            'and_or' => 'and',
            'title_for_any' => __('Any', 'wp-meta-data-filter-and-taxonomy-filter'),
            'title_for_filter_button' => __('Filter', 'wp-meta-data-filter-and-taxonomy-filter'),
            'show_filter_button_after_each_block' => 'false',
            'taxonomies' => array(),
            'taxonomies_options_hide' => array(),
            'taxonomies_options_show_how' => 'select',
            'taxonomies_options_select_size' => 1,
            'taxonomies_options_tax_title' => '',
            'taxonomies_options_checkbox_max_height' => 0,
            'taxonomies_options_behaviour' => 'AND',
            'taxonomies_options_show_count' => 'true',
            'taxonomies_options_post_recount_dyn' => 'true',
            'taxonomies_options_hide_terms_0' => 'false',
            'taxonomies_options_show_child_terms' => 0,
            'taxonomies_options_terms_section_toggle' => 0,
            'show_reset_button' => 'true',
            'show_found_totally' => 'true',
            'ajax_items_recount' => 'false',
            'search_result_page' => '',
            'search_result_tpl' => '',
            'reset_link' => '',
            'show_items_count_text' => __('Found &lt;span&gt;%s&lt;/span&gt; items', 'wp-meta-data-filter-and-taxonomy-filter'),
            'ajax_output' => 'false',
            'woo_search_panel_id' => 0,
            'additional_taxonomies' => '',
            'filter_categories_addit' => '',
            'ajax_results' => 'false'
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $args = array();
        $args['instance'] = $instance;
        $args['widget'] = $this;
        wp_enqueue_script('meta_data_filter_widget', MetaDataFilterCore::get_application_uri() . 'js/widget_back.js', array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'));
        echo MetaDataFilterHtml::render_html(MetaDataFilterCore::get_application_path() . 'views/widgets/search_form_tax.php', $args);
    }

}

//for single post,page or single custom
class MetaDataFilter_PostData extends WP_Widget {

//Widget Setup
    function __construct() {

        parent::__construct(__CLASS__, __('MDTF single page', 'wp-meta-data-filter-and-taxonomy-filter'), array(
            'classname' => __CLASS__,
            'description' => __('MDTF single post data', 'wp-meta-data-filter-and-taxonomy-filter')
                )
        );
    }

//Widget view
    function widget($args, $instance) {
        $args['instance'] = $instance;
        wp_enqueue_script('jquery');
        MetaDataFilter::front_script_includer();
        echo MetaDataFilterHtml::render_html(MetaDataFilterCore::get_application_path() . 'views/widgets/post_data.php', $args);
    }

//Update widget
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance[MetaDataFilterCore::$slug_cat] = $new_instance[MetaDataFilterCore::$slug_cat];
        $instance['meta_data_filter_slug'] = $new_instance['meta_data_filter_slug'];
        $instance['show_absent_items'] = $new_instance['show_absent_items'];

        return $instance;
    }

//Widget form
    function form($instance) {
//Defaults
        $defaults = array(
            'title' => __('Single Post Meta Data', 'wp-meta-data-filter-and-taxonomy-filter'),
            'show_absent_items' => 'false',
            'meta_data_filter_slug' => 'post'
        );
        $instance = wp_parse_args((array) $instance, $defaults);
        $args = array();
        $args['instance'] = $instance;
        $args['widget'] = $this;
        wp_enqueue_script('meta_data_filter_widget', MetaDataFilterCore::get_application_uri() . 'js/widget_back.js', array('jquery'));
        echo MetaDataFilterHtml::render_html(MetaDataFilterCore::get_application_path() . 'views/widgets/post_data_form.php', $args);
    }

}
