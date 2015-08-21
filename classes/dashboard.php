<?php

/**
*
*/
class CTPDashBoard {

  var $use_defaults = false;
  var $defaults = array(
    'settings' => array(
      'hide_builtin_posts' => false
    )
  );

  function meta_boxes() {

    add_meta_box(
      'ctp-types',              // id
      __( 'Types <a class="add-new dashicons dashicons-plus" href="post-new.php?post_type=ctp-type">Add New</a>' ),            // title
      array( $this, 'meta_options'),  // callback
      'toplevel_page_content-types-pro',              // screen
      'normal',                       // context
      'high',                          // priority
      array( 'type' => 'types') // callback_args
    );

    add_meta_box(
      'ctp-taxonomies',              // id
      __( 'Taxonomies <a class="add-new dashicons dashicons-plus" href="post-new.php?post_type=ctp-taxonomy">Add New</a>' ),            // title
      array( $this, 'meta_options'),  // callback
      'toplevel_page_content-types-pro',              // screen
      'side',                       // context
      'high',                          // priority
      array( 'type' => 'taxonomies') // callback_args
    );

    add_meta_box(
      'ctp-queries',              // id
      __( 'Queries <a class="add-new dashicons dashicons-plus" href="post-new.php?post_type=ctp-query">Add New</a>' ),            // title
      array( $this, 'meta_options'),  // callback
      'toplevel_page_content-types-pro',              // screen
      'normal',                       // context
      'high',                          // priority
      array( 'type' => 'queries') // callback_args
    );

    add_meta_box(
      'ctp-settings',              // id
      __( 'Bonus Settings ' ),            // title
      array( $this, 'meta_options'),  // callback
      'toplevel_page_content-types-pro',              // screen
      'side',                       // context
      'high',                          // priority
      array( 'type' => 'settings') // callback_args
    );
  }

  function meta_options( $post, $meta_box_args ) {

    $meta_box = $meta_box_args['args']['type'];
    $screen   = get_current_screen();

    if ($screen->id == 'toplevel_page_content-types-pro') {

      global $post;

      $current       = get_option('ctp-settings', false);

      if ($current == '') {

        $this->use_defaults = true;
      }

      $custom_post_types  = wp_count_posts('ctp-type');
      $types_array   = (array) $custom_post_types;

      unset($types_array['auto-draft']);

      $total_types   = array_sum($types_array);

      $custom_taxonomies  = wp_count_posts('ctp-taxonomy');
      $taxonomies_array   = (array) $custom_taxonomies;

      unset($taxonomies_array['auto-draft']);

      $total_taxonomies   = array_sum($taxonomies_array);

      $queries       = wp_count_posts('ctp-query');
      $queries_array = (array) $queries;

      unset($queries_array['auto-draft']);

      $total_queries = array_sum($queries_array);

      $html = array(
        'types' => array(
          array(
            'type'        => 'html',
            'name'        => false,
            'description' => 'Create custom types to display on the front.',
            'html'        => array(
              'prefix' => '<ul>',
              'elements' => array(
                '<li class="dashicons dashicons-list-view">' . $total_types . ' <a href="edit.php?post_type=ctp-type">All</a></li>',
                '<li class="dashicons dashicons-yes">' . $custom_post_types->publish . ' <a href="edit.php?post_status=publish&post_type=ctp-type">Published</a></li>',
                '<li class="dashicons dashicons-category">' . $custom_post_types->draft . ' <a href="edit.php?post_status=draft&post_type=ctp-type">Drafted</a></li>',
                '<li class="dashicons dashicons-trash">' . $custom_post_types->trash . ' <a href="edit.php?post_status=trash&post_type=ctp-type">Trashed</a></li>',
              ),
              'suffix' => '</ul><a class="button-primary" href="edit.php?post_type=ctp-type">Manage</a>',
            ),
          ),
        ),
        'taxonomies' => array(
          array(
            'type'        => 'html',
            'name'        => false,
            'description' => 'Create custom taxonomies to display on the front.',
            'html'        => array(
              'prefix' => '<ul>',
              'elements' => array(
                '<li class="dashicons dashicons-list-view">' . $total_taxonomies . ' <a href="edit.php?post_type=ctp-taxonomy">All</a></li>',
                '<li class="dashicons dashicons-yes">' . $custom_taxonomies->publish . ' <a href="edit.php?post_status=publish&post_type=ctp-taxonomy">Published</a></li>',
                '<li class="dashicons dashicons-category">' . $custom_taxonomies->draft . ' <a href="edit.php?post_status=draft&post_type=ctp-taxonomy">Drafted</a></li>',
                '<li class="dashicons dashicons-trash">' . $custom_taxonomies->trash . ' <a href="edit.php?post_status=trash&post_type=ctp-taxonomy">Trashed</a></li>',
              ),
              'suffix' => '</ul><a class="button-primary" href="edit.php?post_type=ctp-taxonomy">Manage</a>',
            ),
          ),
        ),
        'queries' => array(
          array(
            'type'        => 'html',
            'name'        => false,
            'description' => 'Create custom queries to display on the front.',
            'html'        => array(
              'prefix' => '<ul>',
              'elements' => array(
                '<li class="dashicons dashicons-list-view">' . $total_queries . ' <a href="edit.php?post_type=ctp-query">All</a></li>',
                '<li class="dashicons dashicons-yes">' . $queries->publish . ' <a href="edit.php?post_status=publish&post_type=ctp-query">Published</a></li>',
                '<li class="dashicons dashicons-category">' . $queries->draft . ' <a href="edit.php?post_status=draft&post_type=ctp-query">Drafted</a></li>',
                '<li class="dashicons dashicons-trash">' . $queries->trash . ' <a href="edit.php?post_status=trash&post_type=ctp-query">Trashed</a></li>',
              ),
              'suffix' => '</ul><a class="button-primary" href="edit.php?post_type=ctp-query">Manage</a>',
            ),
          ),
        ),
        'settings' => array(
          array(
            'type'        => 'checkbox',
            'name'        => 'Settings',
          ),
          array(
            'type'        => 'html',
            'name'        => false,
            'html'        => array(
              'elements' => array(
                '<input class="button-primary" type="submit" name="submit" value="Save">'
              )
            ),
          ),
        ),
      );
    }

    $view = new CTPView($this->use_defaults, $this->defaults, $current);
    $view->render($html[$meta_box]);
  }

  function save() {

    if (isset($_POST['submit'])) {

      if ($_POST['ctp-settings'] != null) {

          update_option('ctp-settings', $_POST['ctp-settings']);
      }
      else {

        update_option('ctp-settings', array('settings' => array()));
      }
    }
  }

  function render_layout() {
    ?>
      <div class="wrap">
        <?php screen_icon(); ?>

        <h2><?php esc_html_e('Content Types Pro','ctp'); ?></h2>

        <form name="form" method="post">
          <?php wp_nonce_field( 'some-action-nonce' );

          /* Used to save closed meta boxes and their order */
          wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
          wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>

          <div id="poststuff">

            <div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>">

   <!--            <div id="post-body-content">
              </div> -->

              <div id="postbox-container-1" class="postbox-container">
                <?php do_meta_boxes('','normal',null); ?>
              </div>

              <div id="postbox-container-2" class="postbox-container">
                <?php do_meta_boxes('','side',null); ?>
              </div>
            </div>
          </div>
        </form>
      </div><!-- .wrap -->
    <?php
  }
  function add_screen_meta_boxes() {

    /* Trigger the add_meta_boxes hooks to allow meta boxes to be added */
    do_action('add_meta_boxes_toplevel_page_content-types-pro', null);
    do_action('add_meta_boxes', 'toplevel_page_content-types-pro', null);

    /* Enqueue WordPress' script for handling the meta boxes */
    wp_enqueue_script('postbox');

    /* Add screen option: user can choose between 1 or 2 columns (default 2) */
    add_screen_option('layout_columns', array('max' => 2, 'default' => 2) );
  }

  function print_script_in_footer() {
    ?>
    <script>

    jQuery(document).ready(function(){

      postboxes.add_postbox_toggles(pagenow);

    });

    </script>
    <?php
  }

}