<?php

class CTPAdminMenu {

  function __construct() {

    // actions
    add_action('admin_menu',            array($this, 'admin_menu'));

  }


  function admin_menu() {

    // bail early if no show_admin
    if( !ctp_get_setting('show_admin') ) {

      return;

    }

    // add parent menu pages
    add_menu_page(__("Content Types",'ctp'), __("Content Types",'ctp'), ctp_get_setting('capability'), 'content-types-pro', array(new CTPDashboard, 'render_layout'), false, '80.026');

    // add child menu pages
    add_submenu_page('content-types-pro', __('Types','ctp'), __('Types','ctp'), ctp_get_setting('capability'), 'edit.php?post_type=ctp-type' );

    add_submenu_page('content-types-pro', __('Taxonomies','ctp'), __('Taxonomies','ctp'), ctp_get_setting('capability'), 'edit.php?post_type=ctp-taxonomy' );

    add_submenu_page('content-types-pro', __('Queries','ctp'), __('Queries','ctp'), ctp_get_setting('capability'),'edit.php?post_type=ctp-query' );

  }

}


// initialize
new CTPAdminMenu();

?>
