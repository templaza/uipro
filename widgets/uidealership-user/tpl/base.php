<?php

$_is_elementor  = (isset($args['page_builder']) && $args['page_builder'] == 'elementor')?true:false;
$name          = isset($instance['name']) ? $instance['name'] : '';
$name_tag      = isset($instance['name_tag']) ? $instance['name_tag'] : 'h3';
$name_style    = isset($instance['name_heading_style']) && $instance['name_heading_style'] ? ' uk-'. $instance['name_heading_style'] : '';
$name_style    .=isset($instance['name_heading_margin']) && $instance['name_heading_margin'] ? ($instance['name_heading_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['name_heading_margin']) : '';
$name_position = isset($instance['name_position']) && $instance['name_position'] ? $instance['name_position'] : 'after';
$text           = isset($instance['text']) && $instance['text'] ? $instance['text'] : '';

$social_items   = isset($instance['social_items']) ? $instance['social_items'] : array();

//Designation
$designation          = isset($instance['designation']) ? $instance['designation'] : '';
$designation_tag      = isset($instance['designation_tag']) ? $instance['designation_tag'] : 'meta';
$designation_style    = isset($instance['designation_margin']) && $instance['designation_margin'] ? ($instance['designation_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['designation_margin']) : '';
if ($designation_tag == 'lead' || $designation_tag == 'meta') {
	$designation_style  .=  ' uk-text-'.$designation_tag;
	$designation_tag    =   'p';
}

//Designation
$email          = isset($instance['user_email']) ? $instance['user_email'] : '';
$email_tag      = isset($instance['email_tag']) ? $instance['email_tag'] : 'meta';
$email_style    = isset($instance['email_margin']) && $instance['email_margin'] ? ($instance['email_margin'] == 'default' ? ' uk-margin' : ' uk-margin-'. $instance['email_margin']) : '';
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
    echo '<div class="uk-child-width-1-4@m" data-uk-grid>';
    foreach ($users as $user){
        $output .='<div class="ap-dealership-user">';
        $media = '<a href="'.esc_url(get_author_posts_url($user->ID)).'"><img src="'.esc_url( get_avatar_url( $user->ID,300)).'" alt="'.$user->display_name.'"/></a>';
        $name     =  '<'.$name_tag.' class="ui-name uk-card-title'.$name_style.'">'.$user->display_name.'</'.$name_tag.'>';
        if($designation != ''){
            $designation     =  '<'.$designation_tag.' class="ui-designation '.$designation_style.'">'.$designation.'</'.$designation_tag.'>';
        }
        if($email !=''){
            $email     =  '<'.$email_tag.' class="ui-email '.$email_style.'">'.$user->user_email.'</'.$email_tag.'>';
        }
        $output     .=   '<div class="ui-card uk-card'. $card_style . $card_size . $general_styles['container_cls'] .'"' . $general_styles['animation'] . '>';
        if ($media && $image_appear == 'top') {
            $output .=  '<div class="uk-card-media-top ui-media"><div class="uk-inline-clip uk-transition-toggle" tabindex="0">';
            $output .=  $media;
            $output .=  '</div></div>';
        }
        $output     .=  '<div class="uk-card-body' . $general_styles['content_cls'] . '">';
        if ($name_position == 'before') {
            $output         .=  $name.$designation.$email;
        }
        if ($image_appear == 'inside') {
            $output     .=  $media ? '<div class="ui-media"><div class="uk-inline-clip uk-transition-toggle" tabindex="0">'.$media.'</div></div>' : '';
        }
        if ($name_position == 'after') {
            $output         .=  $name.$designation.$email;
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

