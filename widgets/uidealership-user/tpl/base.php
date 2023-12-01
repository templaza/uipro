<?php
$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$name          = isset($instance['name']) ? $instance['name'] : '';
$name_tag      = isset($instance['name_tag']) ? $instance['name_tag'] : 'h3';
$name_style    = isset($instance['name_heading_style']) && $instance['name_heading_style'] ? ' uk-'. $instance['name_heading_style'] : '';
$name_position = isset($instance['name_position']) && $instance['name_position'] ? $instance['name_position'] : 'after';
$text           = isset($instance['text']) && $instance['text'] ? $instance['text'] : '';
$limit           = isset($instance['user_limit']) && $instance['user_limit'] ? $instance['user_limit'] : '';
$user_orderby           = isset($instance['user_orderby']) && $instance['user_orderby'] ? $instance['user_orderby'] : 'login';
$user_order           = isset($instance['user_order']) && $instance['user_order'] ? $instance['user_order'] : 'ASC';

$large_desktop_columns    = ( isset( $instance['large_desktop_columns'] ) && $instance['large_desktop_columns'] ) ? $instance['large_desktop_columns'] : '4';
$desktop_columns    = ( isset( $instance['desktop_columns'] ) && $instance['desktop_columns'] ) ? $instance['desktop_columns'] : '4';
$laptop_columns     = ( isset( $instance['laptop_columns'] ) && $instance['laptop_columns'] ) ? $instance['laptop_columns'] : '3';
$tablet_columns     = ( isset( $instance['tablet_columns'] ) && $instance['tablet_columns'] ) ? $instance['tablet_columns'] : '2';
$mobile_columns     = ( isset( $instance['mobile_columns'] ) && $instance['mobile_columns'] ) ? $instance['mobile_columns'] : '1';
$column_grid_gap    = ( isset( $instance['column_grid_gap'] ) && $instance['column_grid_gap'] ) ? ' uk-grid-'. $instance['column_grid_gap'] : '';

$cover_image    = (isset($instance['cover_image']) && $instance['cover_image']) ? intval($instance['cover_image']) : 0;
$cover_image    = $cover_image ? ' tz-image-cover uk-cover-container' : '';
$ukcover_image    = $cover_image ? ' data-uk-cover' : '';
$image_transition   = ( isset( $instance['image_transition'] ) && $instance['image_transition'] ) ? ' uk-transition-' . $instance['image_transition'] . ' uk-transition-opaque' : '';
$flash_effect   =   isset($instance['flash_effect']) ? intval($instance['flash_effect']) : 0;
$imgclass         =  $flash_effect ? ' ui-image-flash-effect uk-position-relative uk-overflow-hidden' : '';

//Product Number
$user_product_number          = isset($instance['user_product_number']) ? $instance['user_product_number'] : '';
$product_label          = isset($instance['product_label']) ? $instance['product_label'] : '';
$product_label_regular          = isset($instance['product_label_regular']) ? $instance['product_label_regular'] : '';
$product_number_tag      = isset($instance['product_number_tag']) ? $instance['product_number_tag'] : 'meta';
$product_number_style    = '';
if ($product_number_tag == 'lead' || $product_number_tag == 'meta') {
	$product_number_style  .=  ' uk-text-'.$product_number_tag;
	$product_number_tag    =   'p';
}

//Email
$show_email          = isset($instance['user_email']) ? $instance['user_email'] : '';
$email_tag      = isset($instance['email_tag']) ? $instance['email_tag'] : 'meta';
$email_style    = '';
if ($email_tag == 'lead' || $email_tag == 'meta') {
	$email_style  .=  ' uk-text-'.$email_tag;
	$email_tag    =   'p';
}
$media  = '';
$icon_mail  = '';
$icon_phone  = '';
$icon_address  = '';
$show_address          = isset($instance['user_address']) ? $instance['user_address'] : '';
$address_icon    =   isset($instance['address_icon']) ? $instance['address_icon'] : array();
if ($address_icon && isset($address_icon['value'])) {
    if (is_array($address_icon['value']) && isset($address_icon['value']['url']) && $address_icon['value']['url']) {
        $icon_address   .=  '<span><img src="'.$address_icon['value']['url'].'" alt="svg-icon" data-uk-svg /></span>';
    } elseif (is_string($address_icon['value']) && $address_icon['value']) {
        $icon_address   .=  '<span><i class="' . $address_icon['value'] . '" aria-hidden="true"></i></span>';
    }
}
$email_icon    =   isset($instance['email_icon']) ? $instance['email_icon'] : array();
if ($email_icon && isset($email_icon['value'])) {
    if (is_array($email_icon['value']) && isset($email_icon['value']['url']) && $email_icon['value']['url']) {
        $icon_mail   .=  '<span><img src="'.$email_icon['value']['url'].'" alt="svg-icon" data-uk-svg /></span>';
    } elseif (is_string($email_icon['value']) && $email_icon['value']) {
        $icon_mail   .=  '<span><i class="' . $email_icon['value'] . '" aria-hidden="true"></i></span>';
    }
}
$show_number          = isset($instance['user_number']) ? $instance['user_number'] : '';
$phone_icon    =   isset($instance['phone_icon']) ? $instance['phone_icon'] : array();
if ($phone_icon && isset($phone_icon['value'])) {
    if (is_array($phone_icon['value']) && isset($phone_icon['value']['url']) && $phone_icon['value']['url']) {
        $icon_phone   .=  '<span><img src="'.$phone_icon['value']['url'].'" alt="svg-icon" data-uk-svg /></span>';
    } elseif (is_string($phone_icon['value']) && $phone_icon['value']) {
        $icon_phone   .=  '<span><i class="' . $phone_icon['value'] . '" aria-hidden="true"></i></span>';
    }
}

$image_appear   =   ( isset( $instance['image_appear'] ) && $instance['image_appear'] ) ? $instance['image_appear'] : '';

//Card Style
$card_style     = isset($instance['card_style']) ? ' uk-card-'. $instance['card_style'] : '';
$card_size      = isset($instance['card_size']) ? ' uk-card-'. $instance['card_size'] : '';

$general_styles = \UIPro_Elementor_Helper::get_general_styles($instance);
$output         = '';

$user_role   = ( isset( $instance['user_role'] ) && $instance['user_role'] ) ? $instance['user_role'] : '';
if(!empty($user_role)){
    $users = get_users( [ 'role__in' => $user_role, 'number' =>$limit, 'orderby' =>$user_orderby, 'order' => $user_order] );
}
$product_label_txt = $address = $email = $number ='';
if(!empty($users)){
    echo '<div class="uk-grid ap-dealer-users uk-child-width-1-'.$large_desktop_columns.'@xl uk-child-width-1-'.$desktop_columns.'@l uk-child-width-1-'.$laptop_columns.'@m uk-child-width-1-'.$tablet_columns.'@s uk-child-width-1-'. $mobile_columns . $column_grid_gap.'" data-uk-grid>';
    foreach ($users as $user){
        $pageid         = (int)get_option('options_dealership_dealer_page_id',0);
        $pageid         = !empty($pageid)?$pageid:get_the_ID();
        $url            = get_permalink($pageid).$user -> user_login;

        if(count_user_posts( $user->ID , "ap_product"  )==1){
            $product_label_txt = $product_label_regular;
        }else{
            $product_label_txt = $product_label;
        }
        $media = '<a class="uk-position-relative uk-display-block '.$cover_image.' '.$imgclass.'" href="'.esc_url($url).'"><img '.$ukcover_image.' class="'.$image_transition.' " src="'.esc_url( get_avatar_url( $user->ID,300)).'" alt="'.$user->display_name.'"/></a>';
        $name     =  '<'.$name_tag.' class="ui-name uk-card-title'.$name_style.'"><a href="'.esc_url($url).'">'.$user->display_name.'</a></'.$name_tag.'>';
        if($user_product_number != ''){
            $user_product_number     =  '<'.$product_number_tag.' class="ui-product-number '.$product_number_style.'">'.count_user_posts( $user->ID , "ap_product"  ). ' '.$product_label_txt.'</'.$product_number_tag.'>';
        }
        if($show_address =='yes'){
            $map_location   = get_field('_dls_map_location', 'user_'.$user -> ID);
            if(!empty($map_location)){
                $address = '<div class="ui-address">'.$icon_address.$map_location.'</div>';
            }
        }
        if($show_email =='yes'){
            $email     =  '<'.$email_tag.' class="ui-email '.$email_style.'">'.$icon_mail.$user->user_email.'</'.$email_tag.'>';
        }
        if($show_number =='yes'){
            $phone_number   = get_field('phone', 'user_'.$user -> ID);
            if($phone_number){
                $number     =  '<div class="ui-phone">'.$icon_phone.$phone_number.'</div>';
            }else{
                $number = '';
            }

        }
        $output     ='<div class="ap-dealership-user">';
        $output     .=   '<div class="ui-card uk-card'. $card_style . $card_size . $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
        if ($media && $image_appear == 'top') {
            $output .=  '<div class="uk-card-media-top ui-media"><div class=" uk-transition-toggle" tabindex="0">';
            $output .=  $media;
            $output .=  '</div></div>';
        }
        $output     .=  '<div class="uk-card-body' . $general_styles['content_cls'] . '">';
        if ($name_position == 'before') {
            $output         .=  $name.$address.$email.$number.$user_product_number;
        }
        if ($image_appear == 'inside') {
            $output     .=  $media ? '<div class="ui-media"><div class="uk-inline-clip uk-transition-toggle" tabindex="0">'.$media.'</div></div>' : '';
        }
        if ($name_position == 'after') {
            $output         .=  $name.$address.$email.$number.$user_product_number;
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

