<?php
/*
Plugin Name: Author Box After Posts
Plugin URI: http://www.jeriffcheng.com/wordpress-plugins/author-box-after-posts
Description: Adds an author box after your post contents, with avatar and social profile links.
Version: 1.5
Author: Jeriff Cheng
Author URI: http://www.jeriffcheng.com/
*/
/*
Copyright 2014 Jeriff Cheng( Email : hschengyongtao@gmail.com )
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
*/


add_action( 'wp_enqueue_scripts', 'add_authorbox_css' );	
function add_authorbox_css() {
	wp_enqueue_style( 'abap-css', plugins_url( 'abap.css', __FILE__ ) );
}
	
add_filter('user_contactmethods','abap_user_contactmethods',10,1);	
function abap_user_contactmethods( $contactmethods ) {

	/* Remove user contact methods */
  if ( isset( $contactmethods['skype'] ) )
    unset( $contactmethods['skype'] );	
	
  if ( isset( $contactmethods['facebook'] ) )
    unset( $contactmethods['facebook'] );
	
  if ( isset( $contactmethods['twitter'] ) )
    unset( $contactmethods['twitter'] );
	
  if ( isset( $contactmethods['googleplus'] ) )
    unset( $contactmethods['googleplus'] );	
	
  if ( isset( $contactmethods['linkedin'] ) )
    unset( $contactmethods['linkedin'] );	

  if ( isset( $contactmethods['youtube'] ) )
    unset( $contactmethods['youtube'] );	
	
  if ( isset( $contactmethods['flickr'] ) )
    unset( $contactmethods['flickr'] );		
	
  if ( isset( $contactmethods['pinterest'] ) )
    unset( $contactmethods['pinterest'] );	
	
  if ( isset( $contactmethods['instagram'] ) )
    unset( $contactmethods['instagram'] );		
	
  if ( isset( $contactmethods['quora'] ) )
    unset( $contactmethods['quora'] );	
	
	/* Add user contact methods */
  if ( !isset( $contactmethods['skype'] ) )
    $contactmethods['skype'] = __('Skype Username'); 
	
  if ( !isset( $contactmethods['facebook'] ) )
    $contactmethods['facebook'] = __('Facebook URL'); 
	
  if ( !isset( $contactmethods['twitter'] ) )
    $contactmethods['twitter'] = __('Twitter Username'); 
	
  if ( !isset( $contactmethods['googleplus'] ) )
    $contactmethods['googleplus'] = __('Google + URL'); 
	
  if ( !isset( $contactmethods['linkedin'] ) )
    $contactmethods['linkedin'] = __('Linkedin URL'); 
	
  if ( !isset( $contactmethods['youtube'] ) )
    $contactmethods['youtube'] = __('Youtube URL'); 
	
  if ( !isset( $contactmethods['flickr'] ) )
    $contactmethods['flickr'] = __('Flickr URL'); 
	
  if ( !isset( $contactmethods['pinterest'] ) )
    $contactmethods['pinterest'] = __('Pinterest URL'); 

  if ( !isset( $contactmethods['instagram'] ) )
    $contactmethods['instagram'] = __('Instagram URL'); 

  if ( !isset( $contactmethods['quora'] ) )
    $contactmethods['quora'] = __('Quora URL'); 	

  if ( !isset( $contactmethods['abap_avatar'] ) )
    $contactmethods['abap_avatar'] = __('Custom Avatar Image URL'); 	
	
	return $contactmethods;
}

//Custom Avatar
function abap_get_avatar( $avatar, $id_or_email, $size ) {
	if (get_the_author_meta('abap_avatar')){
		$avatar = '<img src="'. get_the_author_meta('abap_avatar').'" alt="' . get_the_author() . '" width="' . $size . '" height="' . $size . '" />';
	}else{
		$avatar = get_avatar(get_the_author_meta('ID') );
	}
    return $avatar;
}


add_filter('the_content', 'add_author_box');
function add_author_box($content) {
	//Define the Main Part of Author Box
	$author_box='<div id="abap_box">
	
	<p><span class="author_photo">'.abap_get_avatar( $avatar, $id_or_email, $size ).'</span><a rel="nofollow" href="'.get_author_posts_url(get_the_author_meta( 'ID' )).'">'.get_the_author_meta('display_name').'</a> &ndash; has written '. get_the_author_posts().' posts on this site.<br>'.get_the_author_meta('description').'</p>
	
	<p class="abap_links"><a href="mailto:'.get_the_author_meta('email').'" title="Send an Email to the Author of this Post">Email</a>';
	
	//Fetch the User Social Contact Infomation
	global $post;
	$abap_skype_url = get_the_author_meta( 'skype' );
	$abap_facebook_url = get_the_author_meta( 'facebook' );
	$abap_twitter_url = 'https://twitter.com/'.get_the_author_meta( 'twitter' );
	$abap_google_url = get_the_author_meta( 'googleplus' );
	$abap_linkedin_url = get_the_author_meta( 'linkedin' );	
	$abap_youtube_url = get_the_author_meta( 'youtube' );
	$abap_flickr_url = get_the_author_meta( 'flickr' );
	$abap_pinterest_url = get_the_author_meta( 'pinterest' );
	$abap_instagram_url = get_the_author_meta( 'instagram' );
	$abap_quora_url = get_the_author_meta( 'quora' );

	if($abap_skype_url){
		$abap_skype_url='&nbsp;&#8226;&nbsp;<a rel="me nofollow" href="skype:'.$abap_skype_url.'?call" target="_blank">Skype </a>';
	}else {
		$abap_skype_url='';
	}
	
	if($abap_facebook_url){
		$abap_facebook_url='&nbsp;&#8226;&nbsp;<a rel="me nofollow" href="' . esc_url($abap_facebook_url) . '" target="_blank">Facebook </a>';
	}else {
		$abap_facebook_url='';
	}
	
	if($abap_twitter_url){	
		$abap_twitter_url='&nbsp;&#8226;&nbsp;<a rel="me nofollow" href="' . esc_url($abap_twitter_url) . '" target="_blank">Twitter</a>';
	}else {
		$abap_twitter_url='';
	}
	
	if($abap_google_url){
		$abap_google_url='&nbsp;&#8226;&nbsp;<a  rel="me nofollow" href="' . esc_url($abap_google_url) . '" target="_blank">Google</a>';
	} else {
		$abap_google_url='';
	}
	if($abap_linkedin_url){
		$abap_linkedin_url='&nbsp;&#8226;&nbsp;<a  rel="me nofollow" href="' . esc_url($abap_linkedin_url) . '" target="_blank">Linkedin</a>';
	} else {
		$abap_linkedin_url='';
	}	
 	if($abap_youtube_url){
		$abap_youtube_url='&nbsp;&#8226;&nbsp;<a  rel="me nofollow" href="' . esc_url($abap_youtube_url) . '" target="_blank">Youtube</a>';
	} else {
		$abap_youtube_url='';
	}	
	
 	if($abap_flickr_url){
		$abap_flickr_url='&nbsp;&#8226;&nbsp;<a  rel="me nofollow" href="' . esc_url($abap_flickr_url) . '" target="_blank">Flickr</a>';
	} else {
		$abap_flickr_url='';
	}	
	
 	if($abap_pinterest_url){
		$abap_pinterest_url='&nbsp;&#8226;&nbsp;<a  rel="me nofollow" href="' . esc_url($abap_pinterest_url) . '" target="_blank">Pinterest</a>';
	} else {
		$abap_pinterest_url='';
	}	
	
 	if($abap_instagram_url){
		$abap_instagram_url='&nbsp;&#8226;&nbsp;<a  rel="me nofollow" href="' . esc_url($abap_instagram_url) . '" target="_blank">Instagram</a>';
	} else {
		$abap_instagram_url='';
	}	
	
 	if($abap_quora_url){
		$abap_quora_url='&nbsp;&#8226;&nbsp;<a  rel="me nofollow" href="' . esc_url($abap_quora_url) . '" target="_blank">Quora</a>';
	} else {
		$abap_quora_url='';
	}	

	//Output
	if(is_single()) {

		$content.= ($author_box.$abap_skype_url.$abap_facebook_url.$abap_twitter_url.$abap_linkedin_url.$abap_google_url.$abap_youtube_url.$abap_flickr_url.$abap_pinterest_url.$abap_instagram_url.$abap_quora_url.'</p></div>');
    }
	
    return $content;
}