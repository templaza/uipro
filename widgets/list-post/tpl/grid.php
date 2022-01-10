<?php
$posts_display = $instance['posts'];

if ( $posts_display->have_posts() ) {

    $number_posts   = $instance['number_posts'] != ''?$instance['number_posts']:4;
    if ( count( $posts_display->posts ) < $number_posts ) {
        $number_posts = count( $posts_display->posts );
    }
	if ( $instance['title'] ) {
		echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}
	$column         = isset($instance['column'])?$instance['column']:3;
    $post_size      = isset($instance['post_size'])?$instance['post_size']:'h3';
    $column_mobile  = isset($instance['column_mobile'])?$instance['column_mobile']:1;
	$column_tablet  = isset($instance['column_tablet'])?$instance['column_tablet']:$column;
	$item_horizontal= isset($instance['item_horizontal'])?(bool)$instance['item_horizontal']:false;
	$custom_class   = " uk-child-width-1-$column@l uk-child-width-1-$column_tablet@m uk-child-width-1-$column_mobile@s";
	$custom_class   = $item_horizontal?'':$custom_class;

	$item_class     = $item_horizontal?' uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin':'';
	?>
    <div class="uk-grid-medium templaza-list-post-grid<?php echo $custom_class; ?>"<?php echo !$item_horizontal?' data-uk-grid':'';?>>
        <?php
        while ($posts_display -> have_posts()){
            $posts_display->the_post();
        ?>

            <div class="templaza-archive-item item-post-grid<?php echo $item_class; ?>"<?php echo $item_horizontal?' data-uk-grid':''; ?>>
                <?php if(!$item_horizontal){ ?>
                <div class="uk-card">
                <?php }?>
                    <?php
                    $html_media = '';
                    if (has_post_thumbnail() ) {
                        $media_class    = 'uk-card-media-'.$instance['img_align'];
                        if($item_horizontal){
                            $media_class    = 'uk-cover-container uk-card-media-'.$instance['img_h_align'];
                            $media_class   .= $instance['img_h_align'] == 'right'?' uk-flex-last@s':'';
                        }

                        $html_media     = '<div class="templaza-grid-media '.$media_class.'"><a href="'. esc_url( get_permalink( get_the_ID() ) ).'">';

                        $img_attrib     = $item_horizontal?'uk-cover':'';
                        if ( ! empty( $instance['img_w'] ) && ! empty( $instance['img_h'] ) ) {
                            $html_media    .= UIPro_Helper::get_feature_image( get_post_thumbnail_id(), 'full',
                                $instance['img_w'], $instance['img_h'],null,null, null, $img_attrib );
                        } else {
                            $html_media    .= UIPro_Helper::get_feature_image( get_post_thumbnail_id(), 'full', null, null, null, null, null,
                                $img_attrib);
                        }

                        $html_media    .= '</a></div>';
                        ?>
                    <?php } ?>
                    <?php if($item_horizontal && !empty($html_media)){?>
                        <?php echo $html_media; ?>
                    <div>
                    <?php }elseif($instance['img_align'] == 'top' && !empty($html_media)){
                        echo $html_media;
                    } ?>
                        <div class="uk-card-body">
                            <<?php echo $post_size; ?> class="uk-cart-title">
                                <a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php echo get_the_title(); ?></a>
                            </<?php echo $post_size; ?>>
                            <?php
                            $show_date      = isset($instance['show_date']) && $instance['show_date']?(bool) $instance['show_date']:false;
                            $show_author    = isset($instance['show_author']) && $instance['show_author']?(bool) $instance['show_author']:false;
                            $show_category  = isset($instance['show_category']) && $instance['show_category']?(bool) $instance['show_category']:false;
                            ?>
                            <?php if($show_date || $show_author || $show_category){ ?>
                            <div class="article-meta uk-article-meta uk-text-meta templaza-post-meta">
                                <?php if($show_date){ ?>
                                    <span class="article-date"><i class="fa fa-calendar"></i><?php echo get_the_date(); ?></span>
                                <?php }?>
                                <?php if($show_author){ ?>
                                    <span class="article-author"><i class="fas fa-user"></i><?php the_author_posts_link(); ?></span>
                                <?php }?>
                                <?php if($show_category){ ?>
                                    <span class="article-category"><i class="fas fa-folder"></i><?php the_category(', ');; ?></span>
                                <?php }?>
                            </div>
                            <?php }?>

                            <?php if(isset($instance['show_description']) && $instance['show_description']){ ?>
                            <div class="desc"><?php echo \UIPro_Helper::excerpt( $instance['description_limit']);?></div>
                            <?php } ?>
                        </div>
                    <?php if($item_horizontal){?>
                    </div>
                    <?php }elseif($instance['img_align'] == 'bottom'){
                        echo $html_media;
                    } ?>
                <?php if(!$item_horizontal){ ?>
                </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php
}
