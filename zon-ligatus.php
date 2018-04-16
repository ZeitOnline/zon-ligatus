<?php
/**
 * Plugin Name: ZON Ligatus
 * Plugin URI:
 * Description: Adds ligatus content recommendation to ZON blog themes
 * Version: 0.0.1
 * Author: Thomas Puppe
 * License: GPLv3 or later
 */

class ZON_Ligatus
{

  public function __construct() {
    add_action( 'wp_head', array( $this, 'ligatus_meta_tags' ) );
  }

  public function ligatus_meta_tags() {
    if( is_single() ) {
      echo '<meta property="ligatus:article_access_status" content="free">';
      echo '<meta property="ligatus:hide_recommendations" content="False">';
      echo '<meta property="ligatus:do_not_index" content="False">';
      echo '<meta property="ligatus:section" content="' . $this->ligatus_meta_tag_ressort() . '">';

      $tags = $this->ligatus_meta_tag_tags();
      if ( strlen( $tags ) > 0 ) {
        echo '<meta property="ligatus:special" content="' . $tags . '">';
      }
    }
  }

  private function ligatus_meta_tag_ressort() {
  	return get_option( 'zon_ressort_main' ) ?: 'blogs';
  }

  private function ligatus_meta_tag_tags() {
    $currentPostID = get_the_ID();
    $tags = wp_get_post_tags( $currentPostID );
    $tagNames = array_map(create_function('$o', 'return $o->name;'), $tags);
    return join(', ', $tagNames);
  }

  public static function ligatus_container() {
  	echo '<aside id="ligatus" class="ad-container"><script async src="https://a-ssl.ligatus.com/?ids=101846&t=js&s=1"></script></aside>';
  }

}

new Zon_Ligatus();
