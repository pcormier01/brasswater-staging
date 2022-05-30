<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div class="wrap">
    <h2><?php _e("MDTF Custom Utilities", 'wp-meta-data-filter-and-taxonomy-filter') ?></h2>

    <ol>
        <li>
            <h2><?php _e("Terms to meta", 'wp-meta-data-filter-and-taxonomy-filter') ?></h2>

            <?php
            $post_type = 'product';
            $taxonomies = get_object_taxonomies($post_type, 'objects');
            ?>

            <form method="post" action="" id="mdf_term_meta_form">
                <?php echo $post_type ?>:&nbsp;
                <select id="mdf_term_meta_kind" required="">
                    <option value="">Select what drop to meta field</option>
                    <option value="term_slug">term slug</option>
                    <option value="term_name">term name</option>
                </select>&nbsp;

                <select id="mdf_term_meta_tax" required="">
                    <option value="">Select taxonomy</option>
                    <?php if (!empty($taxonomies)): ?>
                        <?php foreach ($taxonomies as $tax): ?>
                            <option value="<?php echo $tax->name ?>"><?php echo $tax->label ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>&nbsp;
                <input type="text" value="" placeholder="enter meta field key" required="" id="mdf_term_meta_key" />&nbsp;
                <input type="submit" />
            </form>

            <script type="text/javascript">
                jQuery(function ($) {
                    $('#mdf_term_meta_form').submit(function () {
                        var data = {
                            action: "mdf_util_term_to_meta",
                            type: $('#mdf_term_meta_kind').val(),
                            tax: $('#mdf_term_meta_tax').val(),
                            post_type: "<?php echo $post_type ?>",
                            meta_key: $('#mdf_term_meta_key').val()
                        };
                        jQuery.post(ajaxurl, data, function (response) {
                            alert(response);
                        });
                        return false;
                    });
                });
            </script>
        </li>
        <li>
            ---
        </li>
    </ol>

</div>
