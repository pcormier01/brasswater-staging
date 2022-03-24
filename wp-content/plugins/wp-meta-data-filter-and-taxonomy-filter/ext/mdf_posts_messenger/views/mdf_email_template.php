<?php
$unsobscr_link = "";
$link = explode("?", $subscr['link']);
$unsobscr_link = $link[0] . "?id_user=" . $subscr['user_id'] . "&key=" . $subscr['key'] . "&mdf_skey=" . $subscr['secret_key'];

$search_terms = $subscr['get'];
$posts = new WP_Query(
	array('post_type' => $subscr['attr']["mdf_widget_options"]["slug"], 'post__in' => $posts, 'orderby' => 'date', 'order' => 'DESC', 'posts_per_page' => -1)
);
$product_count = count($posts->posts);
$text_var = array($user->display_name, $user->user_nicename, $product_count);
$text_str = array('[DISPLAY_NAME]', '[USER_NICENAME]', '[PRODUCT_COUNT]');
$text_email = str_replace($text_str, $text_var, $text_email);

?>

<div class="mdf_products" style="width: 80%; margin: 0 auto; background: #fff; ">
    <div style="width: 100%; text-align: center; background: #1e5e80; color: #fff;padding-bottom: 10px;    padding-top: 10px;"> <h3><?php echo $header_email ?> </h3></div>
    <div style="padding: 20px; border: 2px solid #1e5e80">
        <div class="mdf_text_email" style="color: #4a4a4e; margin-bottom: 30px;" ><?php echo $text_email ?></div>
        <style>
            .mdf_search_terms p span{
                margin-left: 10px;
                padding: 3px;
                background: #dfdfdf;
            }
        </style>
        <div class="mdf_search_terms"><p style="color:#6a6969;">

            <?php _e('Terms', 'wp-meta-data-filter-and-taxonomy-filter') ?>:&nbsp;<?php echo $search_terms ?>
        </p></div>
    <?php if ($last_email) { ?>
        <div class="last_email"><?php _e('Attention! This is the last email. If you want to continue get such emails -> Go by next link and subscribe again', 'wp-meta-data-filter-and-taxonomy-filter') ?>
            - <a href="<?php echo $subscr['link'] . "&orderby=date&order=DESC" ?>"><?php _e('Subscribe', 'wp-meta-data-filter-and-taxonomy-filter'); ?></a>
        </div>
    <?php } ?>
        
        <div class="mdf_subscr"><p><?php _e('If you want to Unsubscribe from this newsletter', 'wp-meta-data-filter-and-taxonomy-filter') ?> - <a href="<?php echo $unsobscr_link ?>"><?php _e('unsubscribe', 'wp-meta-data-filter-and-taxonomy-filter') ?></a> </p></div>
        <ul class="products mdf_mail" style="list-style: none; margin-top: 20px" >
    <?php
    if ($posts ->have_posts()) {
	$i = 0;
	while ($posts->have_posts()) : $posts->the_post();
	   // wc_get_template_part('content', 'search');
        ?>
            <li style="width: 30%; text-align: center; display: inline-block; ">
             <div class="thumbnail">
                <?php
                if (has_post_thumbnail())
                {
                    echo '<a href="' . get_permalink() . '" title="' . get_the_title() . '">';
                    echo the_post_thumbnail('thumbnail');
                   // echo '<img style="width: 100%;" src="' . MDTF_HELPER::get_post_featured_image($post->ID, '100x150') . '" alt="" />';
                    echo '</a>';
                }
                ?>
                <div class="caption" style="max-height: 650px; text-align: center; ">
                    <h3><a href="<?php the_permalink() ?>" target="_blank"><?php the_title() ?></a></h3>
                </div>
            </div>
            </li>
            <?php
	    if (++$i >= 9) {
		break;
	    }
	endwhile;
    
	if ($i < count($posts->posts)) {
	    ?>
            <style>
                .mdf_more_text a:hover{
                    background: #557DA1;
                }
            </style>
	    <div style="margin-top: 20px" class="mdf_more_text" >
		<p style="text-align: center;font-size: 18px;" ><a style="padding: 4px;border: 2px solid #557DA1; text-decoration: none;" href="<?php echo $subscr['link'] . "&orderby=date&order=DESC" ?>"><?php _e('See more...', 'wp-meta-data-filter-and-taxonomy-filter') ?></a></p>
	    </div> 
	<?php
	}
    } else {
	echo __('No posts found','wp-meta-data-filter-and-taxonomy-filter');
    }
    wp_reset_postdata();
   
    ?>
</ul><!--/.products-->
<div class="woof_subscr"><p><?php _e('If you want to Unsubscribe from this newsletter', 'wp-meta-data-filter-and-taxonomy-filter') ?> - <a href="<?php echo $unsobscr_link ?>"><?php _e('unsubscribe', 'wp-meta-data-filter-and-taxonomy-filter') ?></a> </p>
        
        
   </div>
    </div>