<?php

class Config {

  public function __construct(){
    add_action('wp_dashboard_setup', $this->deleteSectionsPainel());
    add_filter('get_user_option_screen_layout_dashboard', $this->screenLayoutDashboard());
    add_filter('screen_options_show_screen', $this->removeScreenOptions());
  }

  public function removeAdminBarMenu($admin_bar, $adminBarArray = array())
  {
    foreach($adminBarArray as $item){
      $admin_bar->remove_menu( $item );
    }
    return $admin_bar;
  }

  public function removeMenuPage($pages)
  {
    foreach($pages as $page){
      remove_menu_page( $page );
    }
  }

  public function removeSubmenuPage($subPages)
  {
    foreach($subPages as $page => $subPage){
      remove_submenu_page( $page, $subPage );
    }
  }

  public function headerScripts($scripts
    ){
    foreach($scripts as $script){
      wp_register_style($script['name'], $script['url'], array(), $script['version']);
      wp_enqueue_style($script['name']);
    }
  }

  public function footerScripts($scripts)
  {
    foreach($scripts as $script){
      wp_register_script($script['name'], $script['url'], array(), $script['version']);
      wp_enqueue_script($script['name']);
    }
  }


  public function removeScreenOptions()
  {
    return false;
  }

  function screenLayoutColumns( $columns )
  {
      $columns['dashboard'] = 1;
      return $columns;
  }

  protected function screenLayoutDashboard()
  {
      return 1;
  }

  protected function deleteSectionsPainel()
  {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
  }

}
