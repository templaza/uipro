<?php

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$name          = isset($instance['name']) ? $instance['name'] : '';
$name_tag      = isset($instance['name_tag']) ? $instance['name_tag'] : 'h3';
$name_style    = isset($instance['name_heading_style']) && $instance['name_heading_style'] ? ' uk-'. $instance['name_heading_style'] : '';
$name_position = isset($instance['name_position']) && $instance['name_position'] ? $instance['name_position'] : 'after';
$text           = isset($instance['text']) && $instance['text'] ? $instance['text'] : '';

$large_desktop_columns    = ( isset( $instance['large_desktop_columns'] ) && $instance['large_desktop_columns'] ) ? $instance['large_desktop_columns'] : '4';
$desktop_columns    = ( isset( $instance['desktop_columns'] ) && $instance['desktop_columns'] ) ? $instance['desktop_columns'] : '4';
$laptop_columns     = ( isset( $instance['laptop_columns'] ) && $instance['laptop_columns'] ) ? $instance['laptop_columns'] : '3';
$tablet_columns     = ( isset( $instance['tablet_columns'] ) && $instance['tablet_columns'] ) ? $instance['tablet_columns'] : '2';
$mobile_columns     = ( isset( $instance['mobile_columns'] ) && $instance['mobile_columns'] ) ? $instance['mobile_columns'] : '1';
$column_grid_gap    = ( isset( $instance['column_grid_gap'] ) && $instance['column_grid_gap'] ) ? ' uk-grid-'. $instance['column_grid_gap'] : '';


//Product Number
$user_product_number          = isset($instance['user_product_number']) ? $instance['user_product_number'] : '';
$product_label          = isset($instance['product_label']) ? $instance['product_label'] : '';
$product_number_tag      = isset($instance['product_number_tag']) ? $instance['product_number_tag'] : 'meta';
$product_number_style    = isset($instance['product_number_margin']) && $instance['product_number_margin'] ? ($instance['product_number_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['product_number_margin']) : '';
if ($product_number_tag == 'lead' || $product_number_tag == 'meta') {
	$product_number_style  .=  ' uk-text-'.$product_number_tag;
	$product_number_tag    =   'p';
}

//Email
$email          = isset($instance['user_email']) ? $instance['user_email'] : '';
$email_tag      = isset($instance['email_tag']) ? $instance['email_tag'] : 'meta';
$email_style    = '';
if ($email_tag == 'lead' || $email_tag == 'meta') {
	$email_style  .=  ' uk-text-'.$email_tag;
	$email_tag    =   'p';
}
$media          = '';
$image_appear   =   ( isset( $instance['image_appear'] ) && $instance['image_appear'] ) ? $instance['image_appear'] : '';

//Card Style
$card_style     = isset($instance['card_style']) ? ' uk-card-'. $instance['card_style'] : '';
$card_size      = isset($instance['card_size']) ? ' uk-card-'. $instance['card_size'] : '';

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$output         = '';

$user_role   = ( isset( $instance['user_role'] ) && $instance['user_role'] ) ? $instance['user_role'] : '';
if(!empty($user_role)){
    $users = get_users( [ 'role__in' => $user_role ] );
}
if(!empty($users)){
    echo '<div class="ap-dealer-users uk-child-width-1-'.$large_desktop_columns.'@xl uk-child-width-1-'.$desktop_columns.'@l uk-child-width-1-'.$laptop_columns.'@m uk-child-width-1-'.$tablet_columns.'@s uk-child-width-1-'. $mobile_columns . $column_grid_gap.'" data-uk-grid>';
    foreach ($users as $user){
        $url    = get_permalink( get_the_ID()).$user -> user_login;
        $media = '<a href="'.esc_url($url).'"><img class="uk-transition-scale-up uk-transition-opaque" src="'.esc_url( get_avatar_url( $user->ID,300)).'" alt="'.$user->display_name.'"/></a>';
        $name     =  '<'.$name_tag.' class="ui-name uk-card-title'.$name_style.'"><a href="'.esc_url($url).'">'.$user->display_name.'</a></'.$name_tag.'>';
        if($user_product_number != ''){
            $user_product_number     =  '<'.$product_number_tag.' class="ui-product-number '.$product_number_style.'">'.count_user_posts( $user->ID , "ap_product"  ). ' '.$product_label.'</'.$product_number_tag.'>';
        }
        if($email !=''){
            $email     =  '<'.$email_tag.' class="ui-email '.$email_style.'">'.$user->user_email.'</'.$email_tag.'>';
        }
        $output     ='<div class="ap-dealership-user">';
        $output     .=   '<div class="ui-card uk-card'. $card_style . $card_size . $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
        if ($media && $image_appear == 'top') {
            $output .=  '<div class="uk-card-media-top ui-media"><div class="uk-inline-clip uk-transition-toggle" tabindex="0">';
            $output .=  $media;
            $output .=  '</div></div>';
        }
        $output     .=  '<div class="uk-card-body' . $general_styles['content_cls'] . '">';
        if ($name_position == 'before') {
            $output         .=  $name.$email.$user_product_number;
        }
        if ($image_appear == 'inside') {
            $output     .=  $media ? '<div class="ui-media"><div class="uk-inline-clip uk-transition-toggle" tabindex="0">'.$media.'</div></div>' : '';
        }
        if ($name_position == 'after') {
            $output         .=  $name.$email.$user_product_number;
        }
        $output     .=  '<div class="ui-card-text">'.$text.'</div>';

        $output     .=  '</div>';
        if ($media && $image_appear == 'bottom') {
            $output .=  '<div class="uk-card-media-top ui-media"><div class="uk-inline-clip uk-transition-toggle" tabindex="0">';
            $output .=  $media;
            $output .=  '</div></div>';
        }
        $output     .=  '</div>';
        $output     .=  '</div>';
        echo ent2ncr($output);
    }
    echo '</div>';
}

