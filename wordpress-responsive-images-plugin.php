<?php

/*
  Plugin Name: Wordrpress Responsive Images
  Description: Provides a service to retrieve on demand images
  Version: 1.0
  Author: Andou
  Author URI: https://github.com/andou
 */


$_wp_resp_img_dir = __DIR__;
//callback registrazione newsletter
add_action('wp_ajax_nopriv_responsiveimg', 'responsiveimg');
add_action('wp_ajax_responsiveimg', 'responsiveimg');

function responsiveimg() {
  $img = $_GET['img'];
  $w = $_GET['w'];
  $h = $_GET['h'];

  if (empty($img) || (empty($h) && empty($w))) {
    http_response_code(400);
  }

  if (empty($w)) {
    $w = null;
  }

  if (empty($h)) {
    $h = null;
  }

  global $_wp_resp_img_dir;
  require_once $_wp_resp_img_dir . '/vendor/autoload.php';

  new \Andou\Autoloader\Autoloader($_wp_resp_img_dir . "/src");
  $app = \Andou\SuperImageResizer\App::getInstance($_wp_resp_img_dir, '/config/config.ini');
  $_newimg = $app->getImageResized($img, $w, $h);
  $app->serve($_newimg);
}
