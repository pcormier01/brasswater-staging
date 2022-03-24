<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div class="wrap">

    <input type="hidden" name="mdf_const_links_values" value="" />
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row"><label><?php _e("Use this link on your site", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                <td>
                    <fieldset>
                        <?php echo $page_mdf_link ?>
                    </fieldset>
                </td>
            </tr>


            <tr valign="top">
                <th scope="row"><label><?php _e("Drop new link here", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                <td>
                    <fieldset>
                        <textarea name="mdf_new_link" style="width:100%; height:200px;" placeholder="<?php _e("Drop here right link only for updating constant link!!", 'wp-meta-data-filter-and-taxonomy-filter') ?>"></textarea>
                    </fieldset>
                </td>
            </tr>


            <?php if (empty($page_mdf_string)): ?>

                <tr valign="top">
                    <th scope="row" style="color: red; font-weight: bold;"><label><?php _e("ATTENTION", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                    <td>
                        <fieldset>
                            <?php _e("Link is inspired. Recreate this one on the front on the same browser!", 'wp-meta-data-filter-and-taxonomy-filter') ?>
                        </fieldset>
                    </td>
                </tr>

            <?php else: ?>
                <tr valign="top">
                    <th scope="row" style="color: green; font-weight: bold;"><label><?php _e("ALL IS OK", 'wp-meta-data-filter-and-taxonomy-filter') ?></label></th>
                    <td>
                        <fieldset>
                        </fieldset>
                    </td>
                </tr>

            <?php endif; ?>
        </tbody>
    </table>



    <div class="clear"></div>

</div>

