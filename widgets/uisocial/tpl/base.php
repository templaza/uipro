<?php

defined( 'ABSPATH' ) || exit;

use Elementor\Icons_Manager;

$fallback_defaults = [
    'fa fa-facebook',
    'fa fa-twitter',
    'fa fa-google-plus',
];

$class_animation = '';

if ( ! empty( $instance['hover_animation'] ) ) {
    $class_animation = ' elementor-animation-' . $instance['hover_animation'];
}

$migration_allowed = Icons_Manager::is_migration_allowed();

$general_styles     =   \UIPro_Elementor_Helper::get_general_styles($instance);

$social_style           = ( isset(  $instance['social_style'] ) &&  $instance['social_style'] ) ?  $instance['social_style'] : '';
$columns_large_desktop  = ( isset(  $instance['columns_large_desktop'] ) &&  $instance['columns_large_desktop'] ) ?  $instance['columns_large_desktop'].'@xl' : 'auto@xl';
$columns_desktop        = ( isset(  $instance['columns_desktop'] ) &&  $instance['columns_desktop'] ) ?  $instance['columns_desktop'].'@l' : 'auto@l';
$columns_laptop         = ( isset(  $instance['columns_laptop'] ) &&  $instance['columns_laptop'] ) ?  $instance['columns_laptop'].'@m' : 'auto@m';
$columns_tablet         = ( isset(  $instance['columns_tablet'] ) &&  $instance['columns_tablet'] ) ?  $instance['columns_tablet'].'@s' : 'auto@s';
$columns_mobile         = ( isset(  $instance['columns_mobile'] ) &&  $instance['columns_mobile'] ) ?  $instance['columns_mobile'] : 'auto';
$gutter                 = ( isset(  $instance['gutter'] ) &&  $instance['gutter'] ) ? ' uk-grid-' .  $instance['gutter'] : '';

$shape                  = ( isset(  $instance['shape'] ) &&  $instance['shape'] ) ? ' uk-border-' .  $instance['shape'] : '';
?>

<div class="ui-social<?php echo ($social_style != '' ? ' '. $social_style : '').$general_styles['container_cls'] ;
?>"<?php echo $general_styles['animation'];?>>
    <div class="<?php echo 'uk-child-width-'. $columns_large_desktop . ' uk-child-width-'. $columns_desktop
        . ' uk-child-width-'. $columns_laptop . ' uk-child-width-'. $columns_tablet
        . '  uk-child-width-'. $columns_mobile . $gutter ;?>" data-uk-grid>
        <?php
    foreach ( $instance['social_icon_list'] as $index => $item ) {
        $migrated = isset( $item['__fa4_migrated']['social_icon'] );
        $is_new = empty( $item['social'] ) && $migration_allowed;
        $social = '';

        // add old default
        if ( empty( $item['social'] ) && ! $migration_allowed ) {
            $item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
        }

        if ( ! empty( $item['social'] ) ) {
            $social = str_replace( 'fa fa-', '', $item['social'] );
        }

        if ( ( $is_new || $migrated ) && 'svg' !== $item['social_icon']['library'] ) {
            $social = explode( ' ', $item['social_icon']['value'], 2 );
            if ( empty( $social[1] ) ) {
                $social = '';
            } else {
                $social = str_replace( 'fa-', '', $social[1] );
            }
        }
        if ( 'svg' === $item['social_icon']['library'] ) {
            $social = get_post_meta( $item['social_icon']['value']['id'], '_wp_attachment_image_alt', true );
        }

        $link_key = 'link_' . $index;

        $tag_class  =[
//            'elementor-icon',
            'ui-social-icon-link',
//            'elementor-social-icon',
            'elementor-social-icon-' . $social . $class_animation,
            'elementor-repeater-item-' . $item['_id'],
//            'elementor-repeater-item-' . $item['_id'],
        ];
        $tag_class[]    = $shape;

        if($social_style == 'magazine'){
            $tag_class[]    = 'uk-flex uk-flex-stretch';
        }else{
            $tag_class[] = 'uk-icon-button';
//            if(empty($shape)) {
//                $tag_class[] = 'uk-button';
//            }
        }

        $el->add_render_attribute( $link_key, 'class', $tag_class );

        $el->add_link_attributes( $link_key, $item['link'] );
    ?>
        <div class="ui-social-item ui-social-item">
            <a <?php $el->print_render_attribute_string( $link_key ); ?>>
                <?php ?>
                <?php
                if ( $is_new || $migrated ) {
                    Icons_Manager::render_icon( $item['social_icon'], array('class' => array('ui-social-icon')) );
                } else { ?>
                    <i class="uk-grid-item-match ui-social-icon <?php echo esc_attr( $item['social'] ); ?>"></i>
                <?php } ?>
                <?php if($social_style == 'magazine'){ ?>
                <span class="ui-social-title uk-grid-item-match"><?php echo esc_html( ucwords( $item['title'] ) ); ?></span>
                <?php } ?>
            </a>
        </div>
    <?php }?>
    </div>
</div>
