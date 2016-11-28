<?php
  require_once get_template_directory() . '/core/config.class.php';
  require_once get_template_directory() . '/core/post_type.class.php';
  require_once get_template_directory() . '/core/helper.class.php';

  add_action( 'init', 'initialize', 1);
  function initialize(){
    $config = new Config();

    add_action( 'admin_bar_menu', 'removeAdminBarMenu' );
    add_action('login_head',  'setLogoAdmin');
    add_filter('admin_footer_text', 'setAdminFooterText');
  }

  function removeAdminBarMenu($admin_bar){
    $config = new Config();
    return $config->removeAdminBarMenu($admin_bar, array('wp-logo', 'new-content', 'edit', 'updates', 'search', 'comments'));
  }

  if (function_exists('add_theme_support'))
  {
      add_theme_support('menus');
      add_theme_support('post-thumbnails');
      add_image_size('image-thumbnail', 119, 122, true);
  }

  add_action('admin_init', 'check_plugins');
  function check_plugins(){
    $helper = new Helper();
    $helper->checkDependencies(
      'advanced-custom-fields/acf.php',
      'Você precisa instalar e ativar o plugin <a href="https://wordpress.org/plugins/advanced-custom-fields/">Advanced Custom Fields</a>'
    );

    $helper->checkDependencies(
      'contact-form-7/wp-contact-form-7.php',
      'Você precisa instalar e ativar o plugin <a href="https://br.wordpress.org/plugins/contact-form-7/">Contact Form 7</a>'
    );

    $helper->checkDependencies(
      'timber-library/timber.php',
      'Você precisa instalar e ativar o plugin <a href="https://wordpress.org/plugins/timber-library/">Timber</a>'
    );
  }

  add_action( 'init', 'video_type', 1);
  function video_type() {
      $video = new PostType(
          'Video',
          'video'
      );

      $video->set_labels(
          array(
              'menu_name' => __( 'Meus Videos' ),
              'edit_item' => __( 'Editar Video' )
          )
      );

      $video->set_arguments(
          array(
              'supports' => array( 'title', 'editor', 'thumbnail' )
          )
      );
  }

  add_action( 'admin_menu', 'remove_menu_pages' );
  function remove_menu_pages() {
    $config = new Config();
    $pages = array(
          'edit.php', //posts
          'edit-comments.php', //comments
          'upload.php', //midia
          'link-manager.php', //links
          // 'edit.php?post_type=page', //pages
          // 'themes.php', //apearence
          // 'plugins.php',//plugins
          // 'tools.php', //tools
          // 'options-general.php', //configs
        );

    $config->removeMenuPage($pages);
    // $helper->removeSubmenuPage(array('edit.php' => 'edit-tags.php?taxonomy=category'));
    // $helper->removeSubmenuPage(array('edit.php' => 'edit-tags.php?taxonomy=post_tag'));

  }

  function setAdminFooterText()
  {
    echo 'Implementado por <a href="http://wordpress.org" target="_blank">Wordpress</a>';
  }

  function setLogoAdmin()
  {
      echo '<style  type="text/css"> h1 a {  background-image:url('.get_bloginfo('template_directory').'/webroot/images/admin/logo-login.png)  !important; } </style>';
  }
