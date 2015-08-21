<?php
/*
Plugin Name: Content Types Pro
Plugin URI: http://www.micalexander.com/
Description: Extend Wordpress by adding additional Content Types
Version: 0.0.1
Author: michael alexander
Author URI: http://www.micalexander.com/
Copyright: Micahel Alexander
Text Domain: ctp
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('ctp') ) :

class ctp {

  // vars
  var $settings;

  /**
   * __construct A dummy constructor to ensure CTP is only initialized once
   * @return N/A
   */
  function __construct() {

    /* Do nothing here */

  }

  /**
   * initialize The real constructor to initialize CTP
   * @return N/A
   */
  function initialize() {

    // vars
    $this->settings = array(
      // basic
      'name'             => __('Content Types Pro', 'ctp'),
      'version'          => '0.0.1',

      // urls
      'basename'         => plugin_basename( __FILE__ ),
      'path'             => plugin_dir_path( __FILE__ ),
      'dir'              => plugin_dir_url( __FILE__ ),

      // options
      'show_admin'       => true,
      'show_updates'     => true,
      'stripslashes'     => false,
      'local'            => true,
      'json'             => true,
      'save_json'        => '',
      'load_json'        => array(),
      'default_language' => '',
      'current_language' => '',
      'capability'       => 'manage_options',
      'uploader'         => 'wp',
      'autoload'         => false
    );

    // include helpers
    include_once('helpers/helpers.php');

    // include classes
    ctp_include('classes/admin-view.php');
    ctp_include('classes/dashboard.php');
    ctp_include('classes/type.php');
    ctp_include('classes/taxonomy.php');
    ctp_include('classes/query.php');

    // actions
    add_action('init', array($this, 'wp_init'), 1);
    add_action('init', array(new CTPType, 'register'), 2);
    add_action('init', array(new CTPTaxonomy, 'register'), 2);
    add_action('init', array($this, 'flush_rewrites'), 3);
    add_action('admin_bar_menu', array($this, 'admin_bar_items'), 999);
    add_action('admin_menu', array($this, 'admin_menu_pages'));

    // admin
    if( is_admin() ) {

      $ctp_custom_post_type = new CTPType;
      $ctp_taxonomy         = new CTPTaxonomy;
      $ctp_query            = new CTPQuery;
      $ctp_dashboard        = new CTPDashboard;

      ctp_include('classes/admin-menu.php');

      add_action('current_screen', array($this, 'deregister_scripts'), 100 );
      add_action('current_screen', array($this, 'deregister_styles'), 100 );
      add_action('admin_enqueue_scripts', array($this, 'register_styles') );
      add_action('admin_enqueue_scripts', array($this, 'register_scripts') );
      add_action('add_meta_boxes', array($ctp_custom_post_type, 'meta_boxes'));
      add_action('add_meta_boxes', array($ctp_taxonomy, 'meta_boxes'));
      add_action('add_meta_boxes', array($ctp_query, 'meta_boxes'));
      add_action('load-toplevel_page_content-types-pro', array($ctp_dashboard, 'add_screen_meta_boxes'));
      add_action('admin_footer-toplevel_page_content-types-pro', array($ctp_dashboard, 'print_script_in_footer'));
      add_action('add_meta_boxes_toplevel_page_content-types-pro', array($ctp_dashboard, 'meta_boxes'));
      add_action('init', array($ctp_dashboard, 'save'));
      add_action('save_post', array($ctp_custom_post_type, 'save'));
      add_action('save_post', array($ctp_taxonomy, 'save'));
      add_action('save_post', array($ctp_query, 'save'));
      add_filter('manage_edit-ctp-query_columns', array($ctp_query, 'query_columns'), 10, 1);
      add_action('manage_pages_custom_column', array($ctp_query, 'query_columns_content'), 10, 2);
      add_action('admin_footer', array($ctp_query, 'ctp_query_js_footer'));
      add_action('wp_ajax_retrieve_meta_keys', array($ctp_query, 'retrieve_meta_keys_callback'));
    }
  }


  /**
   * wp_init This function will run on the WP init action and setup many things
   * @return N/A
   */
  function wp_init() {

    // vars
    $cap     = ctp_get_setting('capability');
    $version = ctp_get_setting('version');
    $lang    = get_locale();
    $scripts = array();
    $styles  = array();

    register_post_type(
      'ctp-type',
      array(
        'labels' => array(
          'name'               => __( 'Types', 'ctp' ),
          'singular_name'      => __( 'Type', 'ctp' ),
          'add_new'            => __( 'Add New' , 'ctp' ),
          'add_new_item'       => __( 'Add New Type' , 'ctp' ),
          'edit_item'          => __( 'Edit Type' , 'ctp' ),
          'new_item'           => __( 'New Type' , 'ctp' ),
          'view_item'          => __( 'View Type', 'ctp' ),
          'search_items'       => __( 'Search Types', 'ctp' ),
          'not_found'          => __( 'No Types found', 'ctp' ),
          'not_found_in_trash' => __( 'No Types found in Trash', 'ctp' ),
        ),
        'public'          => false,
        'show_ui'         => true,
        '_builtin'        => false,
        'capability_type' => 'post',
        'capabilities'    => array(
          'edit_post'    => $cap,
          'delete_post'  => $cap,
          'edit_posts'   => $cap,
          'delete_posts' => $cap,
        ),
        'hierarchical' => true,
        'rewrite'      => false,
        'query_var'    => false,
        'supports'     => array('title'),
        'show_in_menu' => false,
      )
    );

    register_post_type(
      'ctp-taxonomy',
      array(
        'labels' => array(
          'name'               => __( 'Taxonomies', 'ctp' ),
          'singular_name'      => __( 'Taxonomy', 'ctp' ),
          'add_new'            => __( 'Add New' , 'ctp' ),
          'add_new_item'       => __( 'Add New Taxonomy' , 'ctp' ),
          'edit_item'          => __( 'Edit Taxonomy' , 'ctp' ),
          'new_item'           => __( 'New Taxonomy' , 'ctp' ),
          'view_item'          => __( 'View Taxonomy', 'ctp' ),
          'search_items'       => __( 'Search Taxonomies', 'ctp' ),
          'not_found'          => __( 'No Taxonomies found', 'ctp' ),
          'not_found_in_trash' => __( 'No Taxonomies found in Trash', 'ctp' ),
        ),
        'public'          => false,
        'show_ui'         => true,
        '_builtin'        => false,
        'capability_type' => 'post',
        'capabilities'    => array(
          'edit_post'    => $cap,
          'delete_post'  => $cap,
          'edit_posts'   => $cap,
          'delete_posts' => $cap,
        ),
        'hierarchical' => true,
        'rewrite'      => false,
        'query_var'    => false,
        'supports'     => array('title'),
        'show_in_menu' => false,
      )
    );

    register_post_type(
      'ctp-query',
      array(
        'labels' => array(
          'name'               => __( 'Queries', 'ctp' ),
          'singular_name'      => __( 'Query', 'ctp' ),
          'add_new'            => __( 'Add New' , 'ctp' ),
          'add_new_item'       => __( 'Add New Query' , 'ctp' ),
          'edit_item'          => __( 'Edit Query' , 'ctp' ),
          'new_item'           => __( 'New Query' , 'ctp' ),
          'view_item'          => __( 'View Query', 'ctp' ),
          'search_items'       => __( 'Search Queries', 'ctp' ),
          'not_found'          => __( 'No Queries found', 'ctp' ),
          'not_found_in_trash' => __( 'No Queries found in Trash', 'ctp' ),
        ),
        'public'          => false,
        'show_ui'         => true,
        '_builtin'        => false,
        'capability_type' => 'post',
        'capabilities'    => array(
          'edit_post'    => $cap,
          'delete_post'  => $cap,
          'edit_posts'   => $cap,
          'delete_posts' => $cap,
        ),
        'hierarchical' => true,
        'rewrite'      => false,
        'query_var'    => false,
        'supports'     => array('title'),
        'show_in_menu' => false,
      )
    );

    $this->define_ep_masks();

    // remove_post_type_support('postype-slug', '');

  }

  function admin_bar_items() {

    global $wp_admin_bar;

    $option = get_option('ctp-settings', false);

    if ($option) {

      if (in_array('hide_builtin_posts', $option['settings'])) {

        $wp_admin_bar->remove_node( 'new-post' );

      }
    }
  }

  function admin_menu_pages() {

    $option = get_option('ctp-settings', false);

    if ($option) {

      if (in_array('hide_builtin_posts', $option['settings'])) {

        remove_menu_page('edit.php');

      }
    }
  }

  function register_scripts() {

    $scripts = array(

      array(
        'handle' => 'pluralize',
        'src'    => plugin_dir_url( __FILE__ ) . 'assets/js/vendor/pluralize.js',
        'deps'   => array(),
      ),
      array(
        'handle' => 'moment',
        'src'    => plugin_dir_url( __FILE__ ) . 'assets/js/vendor/moment.min.js',
        'deps'   => array(),
      ),
      array(
        'handle' => 'pikaday',
        'src'    => plugin_dir_url( __FILE__ ) . 'assets/js/vendor/pikaday.js',
        'deps'   => array(),
      ),
      array(
        'handle' => 'pikaday-jquery',
        'src'    => plugin_dir_url( __FILE__ ) . 'assets/js/vendor/pikaday.jquery.js',
        'deps'   => array('jquery', 'pikaday'),
      ),
      array(
        'handle' => 'velocity',
        'src'    => 'http://cdn.jsdelivr.net/velocity/1.1.0/velocity.min.js',
        'deps'   => array('jquery'),
      ),
      array(
        'handle' => 'velocity',
        'src'    => 'http://cdn.jsdelivr.net/velocity/1.1.0/velocity.min.js',
        'deps'   => array('jquery'),
      ),
      array(
        'handle' => 'velocity-ui',
        'src'    => 'http://cdn.jsdelivr.net/velocity/1.1.0/velocity.ui.min.js',
        'deps'   => array('velocity'),
      ),
      array(
        'handle' => 'ctp-select2',
        'src'    => plugin_dir_url( __FILE__ ) . 'assets/js/vendor/select2.full.min.js',
        'deps'   => array(),
      ),
      array(
        'handle' => 'ctp-script',
        'src'    => plugin_dir_url( __FILE__ ) . 'assets/js/ctp-script.js',
        'deps'   => array(
          'pluralize',
          'velocity',
          'pikaday',
          'ctp-select2'
        ),
      ),
    );

    $screen = get_current_screen();

    if ($screen->id == 'ctp-type'     ||
        $screen->id == 'ctp-query'    ||
        $screen->id == 'ctp-taxonomy' ||
        $screen->id == 'toplevel_page_content-types-pro') {

      foreach( $scripts as $script ) {

        // todo: add version number and make sure
        // that site scripts are not enqued in admin area
        wp_register_script( $script['handle'], $script['src'], $script['deps'] );

        wp_enqueue_script($script['handle']);
      }
    }
  }


  function register_styles() {

    $styles = array(

      array(
        'handle' => 'ctp-select2',
        'src'    => plugin_dir_url( __FILE__ ) . 'assets/css/vendors/select2.css',
        'deps'   => array(),
      ),
      array(
        'handle' => 'ctp-styles',
        'src'    => plugin_dir_url( __FILE__ ) . 'assets/css/ctp-styles.css',
        'deps'   => array(),
      ),
      array(
        'handle' => 'icheck',
        'src'    => plugin_dir_url( __FILE__ ) . 'assets/css/flat/green.css',
        'deps'   => array(),
      ),

    );

    $screen = get_current_screen();

    if ($screen->id == 'ctp-type'     ||
        $screen->id == 'ctp-query'    ||
        $screen->id == 'ctp-taxonomy' ||
        $screen->id == 'toplevel_page_content-types-pro') {
      foreach( $styles as $style ) {

        // todo: add version number and make sure
        // that site styles are not enqued in admin area
        wp_register_style( $style['handle'], $style['src'], $style['deps'] );

        wp_enqueue_style($style['handle']);

      }
    }
  }

  function deregister_scripts() {

    $screen = get_current_screen();

    if ($screen->id == 'ctp-type'     ||
        $screen->id == 'ctp-query'    ||
        $screen->id == 'ctp-taxonomy' ||
        $screen->id == 'toplevel_page_content-types-pro') {

      wp_deregister_script( 'select2' );
      wp_deregister_script( 'acf-input' );
      wp_deregister_script( 'acf-field-group' );
      wp_deregister_script( 'acf-pro-input' );
      wp_deregister_script( 'acf-pro-field-group' );
      wp_deregister_script( 'select2-l10n' );

    }
  }

  function deregister_styles() {

    $screen = get_current_screen();

    if ($screen->id == 'ctp-type'     ||
        $screen->id == 'ctp-query'    ||
        $screen->id == 'ctp-taxonomy' ||
        $screen->id == 'ctp-dashboard') {

      wp_deregister_style( 'select2' );

    }
  }

  function flush_rewrites() {

    $flush = get_option( 'ctp-flush-rewrite', false );

    if ($flush) {

      flush_rewrite_rules( false );
    }

    update_option( 'ctp-flush-rewrite', false );
  }

  function define_ep_masks() {

    $masks = get_option( 'ctp-masks', false );

    if ($masks != false) {

      $power   = pow(2,21);

      foreach ($masks as $post_ids) {

        foreach ($post_ids as $mask) {

          define(strtoupper('ep_' . $mask), $power++ );

        }
      }
    }
  }
}


function ctp() {

  global $ctp;

  if( !isset($ctp) ) {

    $ctp = new ctp();

    $ctp->initialize();

  }

  return $ctp;
}


// initialize
ctp();

endif; // class_exists check

?>
