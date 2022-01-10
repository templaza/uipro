<?php
global $post;

use Elementor\Utils;


$posts_display = $instance['posts'];

if ( $posts_display->have_posts() ) {

    $style = $html_image = $html_des = $html_link = $ex_class = '';
    if (isset($instance['style']) && $instance['style'] != '' ) {
        $style = $instance['style'];
    }
    $image_size = 'none';
    if ( $instance['image_size'] && $instance['image_size'] <> 'none' ) {
        $image_size = $instance['image_size'];
    }

    $class = 'item-post';

    if ( $instance['title'] ) {
        echo ent2ncr( $args['before_title'] . $instance['title'] . $args['after_title'] );
    }

    if($instance['show_post_count']){
        $total_number_posts = 0;
        if($instance['cat_id'] != 'all'){
            $postsInCat = get_term_by('id', $instance['cat_id'],'category');
            $total_number_posts = $postsInCat -> count;
        }else{
            $total_number_posts = wp_count_posts() -> publish;
        }
        echo '<div class="number-posts">'.sprintf('%d Posts',$total_number_posts).'</div>';
    }

    echo '<ul class="templaza-list-posts' . $ex_class . '" >';
    while ( $posts_display->have_posts() ) {
        $posts_display->the_post();
        if ( $style == 'home-new' || $style == 'sidebar' ) {
            $class = 'item-post';
        }
        if ( $image_size <> 'none' && has_post_thumbnail() ) {
            $html_img = '';
            $class    .= ' has_thumb';
            if ( $image_size == 'custom_image' ) {
                $html_img .= '<div class="article-image image">';
                $html_img .= '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">';
                $html_img .= UIPro_Helper::get_feature_image( get_post_thumbnail_id( $post->ID ), 'full', apply_filters( 'templaza_carousel_post_thumbnail_width', 450 ), apply_filters( 'templaza_carousel_post_thumbnail_height', 267 ), get_the_title() );
                $html_img .= '</a>';
                $html_img .= '</div>';
            } else {
                $html_img .= '<div class="article-image image">';
                $html_img .= '<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">';
                $html_img .= get_the_post_thumbnail( get_the_ID(), $image_size );
                $html_img .= '</a>';
                $html_img .= '</div>';
            }
            $html_image = $html_img;
        }

        if ( $instance['show_description'] && $instance['show_description'] != 'no' ) {
            $html_des = '<div class="description">' . \UIPro_Helper::excerpt($instance['description_limit'] ) . '</div>';
        }

        ?>

        <li <?php post_class( $class ); ?>>
            <?php
            $post_size  = isset($instance['post_size'])?$instance['post_size']:'h3';
            $post_size  =  Utils::validate_html_tag($post_size);
            ?>
            <?php echo ent2ncr( $html_image ); ?>
            <div class="article-title-wrapper">
                <<?php echo $post_size; ?> class="article-heading">
                <?php if(isset($instance['list_icon']) && $instance['list_icon']){?>
                    <span class="bullet <?php echo $instance['list_icon']; ?>"></span>
                <?php }?>
                <a href="<?php echo esc_url( get_permalink( get_the_ID() ) );?>" class="article-title"><?php
                    echo get_the_title(); ?></a>
            </<?php echo $post_size; ?>>
            <?php
            $show_date      = isset($instance['show_date']) && $instance['show_date']?(bool) $instance['show_date']:false;
            $show_author    = isset($instance['show_author']) && $instance['show_author']?(bool) $instance['show_author']:false;
            $show_category  = isset($instance['show_category']) && $instance['show_category']?(bool) $instance['show_category']:false;
            ?>
            <?php if($show_date || $show_author || $show_category){ ?>
                <div class="article-meta uk-article-meta uk-text-meta">
                    <?php if($show_date){ ?>
                        <span class="article-date"><?php echo get_the_date(); ?></span>
                    <?php }?>
                    <?php if($show_author){ ?>
                        <span class="article-author"><?php echo __('Posted in ','uipro').get_the_author_posts_link(); ?></span>
                    <?php }?>
                    <?php if($show_category){ ?>
                        <span class="article-category"><?php the_category(', ');; ?></span>
                    <?php }?>
                </div>
            <?php }?>
            <?php
            echo ent2ncr( $html_des );
            ?>
            </div>
        </li>
        <?php
    }
    echo '</ul>';
    ?>

    <?php
    if ( $instance['text_link'] && $instance['text_link'] != '' ) {
        $text_link  = $instance['text_link'];
        if($instance['link_icon']){
            $text_link  .= '<span class="'.$instance['link_icon'].'"></span>';
        }

        ?>
        <a class="read-more" href="<?php echo esc_url( get_permalink( get_the_ID() ) );?>"><?php echo $text_link;?></a>
        <?php
    }

}

?>