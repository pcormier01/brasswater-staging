<?php
if (!defined('ABSPATH'))
    die('No direct access allowed');
$min = (int) (!empty($min)) ? $min : 0;
$max = (int) (!empty($max)) ? $max : 100;
$step = (int) (!empty($step)) ? $step : 1;
$delta = 0.00001;

$show_selects = true;
if ($min == $max) {
    // $max=$min+$step;
    $show_selects = false;
}
if (empty($cur_max) OR $cur_max > $max) {
    $cur_max = $max;
}
// create array of options
$options = array();
$i = 0;
$cur_val = $min;
$options[] = floatval($min);
while (true) {
    $i++;
    if ($i > 10000) {
        $options[] = "To match";
        break;
    }
    $cur_val = floatval($cur_val + $step);
    if ($cur_val < $max) {
        $options[] = floatval($cur_val);
    } else {
        break;
    }
}
$options[] = floatval($max);
//+++++++++++
if (empty($cur_min)) {
    $cur_min = $min;
}
?>
<?php if ($title) { ?>
    <h3><?php echo $title ?></h3>
<?php } ?>
<div class="mdf_range_select_<?php echo $meta_key ?> mdf_range_select_cont" data-key="<?php echo $meta_key ?>" data-step="<?php echo $step ?>">

    <table style="width: 100%;">
        <tr>
            <td style="width: 49%;">
                <select name="mdf[<?php echo $meta_key ?>][from]" id="<?php echo $meta_key ?>_from" class="mdf_range_select mdf_range_select_from <?php echo $meta_key ?>_from"  >
                    <?php
                    foreach ($options as $val) {
                        ?>
                        <option class="mdf_range_select_option" <?php echo((abs($val - $cur_min) < $delta)) ? "selected='selected'" : ""; ?> value="<?php echo $val ?>" ><?php echo $prefix, " ", $val, " ", $postfix ?></option >
                        <?php
                    }
                    ?>
                </select>
            </td>
            <td>&nbsp;</td>
            <td style="width: 49%;">
                <select name="mdf[<?php echo $meta_key ?>][to]" id="<?php echo $meta_key ?>_to" class="mdf_range_select mdf_range_select_to <?php echo $meta_key ?>_to" >
                    <?php
                    foreach ($options as $val) {
                        ?>
                        <option class="mdf_range_select_option" <?php echo((abs($val - $cur_max) < $delta)) ? "selected='selected'" : ""; ?> value="<?php echo $val ?>" ><?php echo $prefix, " ", $val, " ", $postfix ?> </option >
                        <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>


</div>
<?php 
 