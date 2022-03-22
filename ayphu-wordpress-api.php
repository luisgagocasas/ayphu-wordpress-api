<?php
/*
  Plugin Name: Ayphu Api
  Plugin URI: https://ayphu.com
  Description: Practica de creacion de apis usando WordPress headless
  Version: 1.0.0
  Author: Ayphu
  Author URI: https://ayphu.com
  License: GPLv2 or later
  Text Domain: ayphu
*/

add_action( 'rest_api_init', function () {
  register_rest_route( 'ayphu/v1', '/list/',
    [
    'methods' => 'GET',
    'callback' => 'infoUser',
    ]
  );
  register_rest_route( 'ayphu/v1', '/post/',
    [
    'methods' => 'GET',
    'callback' => 'listPost',
    ]
  );
});



function infoUser( WP_REST_Request $request ) {

  $edad = $request->get_param( 'edad' );

  $object = new stdClass();
  $object->firstname = 'Jean';
  $object->lastname  = 'Garcia';
  $object->color     = 'Rojo';
  $object->edad      = $edad;

  return $object;
}

function listPost() {
  $posts_list = get_posts( array( 'type' => 'post' ) );
  $post_data  = array( "posts" => array());

  foreach( $posts_list as $posts) {
    $post_id    = $posts->ID;
    $post_title = $posts->post_title;
    $post_data["posts"][] = [
      "id"    => $post_id,
      "title" => $post_title
    ];
  }

  wp_reset_postdata();
  return rest_ensure_response( $post_data );
 }