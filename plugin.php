<?php
/**
* Plugin Name: firstage-plugin
* Plugin URI: https://thefirstage.org/
* Short codes and snippets for the first age
* Version: 0.1
* Author: Alicia Wilkerson
* Author URI: https://akddev.net
**/



function characterStory($charId) {
  if(!$charId) return 'No associated character found';

  $ch = curl_init();
  // IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
  // in most cases, you should set it to true
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, "https://thefirstage.org/pages/character/$charId/story");
  $result = curl_exec($ch);
  curl_close($ch);

  $obj = json_decode($result);
  $output =  '';
  foreach($obj as $value) {
    $url = "https://thefirstage.org/forums/thread-{$value->tid}.html";
    $block = "<div class=\"character-story\" id=\"thread-{$value->tid}\"><a href=\"{$url}\">{$value->subject}</a></div>";
    $output .= $block;
  }
  return $output;
}

add_shortcode('character-story', 'characterStory');