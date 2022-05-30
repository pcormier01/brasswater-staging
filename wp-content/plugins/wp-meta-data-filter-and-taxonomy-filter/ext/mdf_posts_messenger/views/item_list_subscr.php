<li class="mdf_subscr_item mdf_subscr_item_<?php echo $key ?>">
    <?php
    
    if (!isset($counter)) {
	$counter = __('new', 'wp-meta-data-filter-and-taxonomy-filter');
    }
    ?>
    <a class="mdf_link_to_subscr"  href="<?php echo $link ?>" target="blank" >#<?php echo $counter ?>.&nbsp;<?php echo $subscr_lang ?></a>
    <p class="mdf_tooltip"><span class="mdf_tooltip_data"><?php echo $get ?></span>  <span class="mdf_icon_subscr"></span></p>   
    <a href="#" class="mdf_remove_subscr" data-user="<?php echo $user_id ?>" data-key="<?php echo $key ?>"><img src="<?php echo MDTF_MESSENGER_URI ?>images/delete.png" height="12" width="12" alt="" /></a>
</li>
