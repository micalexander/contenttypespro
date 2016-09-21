<?php

class CTPTaxonomy {
  public $use_defaults = false;
  public $defaults = array(
    'name'                       => '',
    'singular_name'              => '',
    'menu_name'                  => '',
    'all_items'                  => '',
    'add_new_item'               => '',
    'new_item_name'              => '',
    'edit_item'                  => '',
    'new_item'                   => '',
    'view_item'                  => '',
    'update_item'                => '',
    'search_items'               => '',
    'popular_items'              => '',
    'not_found'                  => '',
    'parent_item'                => '',
    'parent_item_colon'          => '',
    'separate_items_with_commas' => '',
    'add_or_remove_items'        => '',
    'choose_from_most_used'      => '',
    'not_found'                  => '',
    'description'                => '',
    'public'                     => true,
    'show_ui'                    => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
    'show_in_quick_edit'         => true,
    'show_admin_column'          => true,
    'hierarchical'               => true,
    'rewrite'                    => true,
    'rewrite_slug'               => '',
    'rewrite_end_point_mask'     => '',
    'rewrite_options'            => array(
      'with_front'   => true,
      'hierarchical' => true,
    ),
    'capabilities' => array(
      'manage_terms' => true,
      'edit_terms'   => true,
      'delete_terms' => true,
      'assign_terms' => true,
    ),
    'sort'      => false,
    'query_var' => true,
  );

  function meta_boxes() {

    add_meta_box(
      'ctp-description',              // id
      __( 'Description' ),            // title
      array( $this, 'meta_options'),  // callback
      'ctp-taxonomy',                 // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'description') // callback_args
    );

    add_meta_box(
      'ctp-labels',                  // id
      __( 'Labels' ),                // title
      array( $this, 'meta_options'), // callback
      'ctp-taxonomy',                // screen
      'normal',                      // context
      'low',                         // priority
      array( 'type' => 'labels')     // callback_args
    );

    add_meta_box(
      'ctp-settings',                // id
      __( 'Advanced Settings' ),     // title
      array( $this, 'meta_options'), // callback
      'ctp-taxonomy',                // screen
      'normal',                      // context
      'low',                         // priority
      array( 'type' => 'settings')   // callback_args
    );
  }

  function meta_options( $post, $meta_box_args ) {

    $meta_box = $meta_box_args['args']['type'];
    $screen   = get_current_screen();

    if ($screen->id == 'ctp-taxonomy') {

      global $post;

      $settings = get_post_meta($post->ID, 'ctp-settings', true);
      $current  = !empty($settings) ? $settings : false;
      $args     = get_post_meta($post->ID, 'ctp-args', true);

      if ( !$args ) {

        $this->use_defaults = true;

      }

      $html = array(
        'description' => array(
          array(
            'type'        => 'select',
            'name'        => 'Post Types',
            'description' => 'The name given for the "Add New" dropdown on admin bar. Defaults to "singular_name" if it exists, "name".',
            'options'     => $this->get_available_types(),
            'multiple' => true,
          ),
          array(
            'type'        => 'textarea',
            'name'        => 'Description',
            'description' => 'A short descriptive summary of what the post type is.'
          )
        ),
        'labels'  => array(
          array(
            'type'        => 'text',
            'name'        => 'Name',
            'description' => 'General name for the post type, usually plural.',
            'prefix'      => ''
          ),
          array(
            'type'        => 'text',
            'name'        => 'Singular Name',
            'description' => 'name for one object of this post type. Defaults to value of "name"',
            'prefix'      => ''
          ),
          array(
            'type'        => 'text',
            'name'        => 'Menu Name',
            'description' => 'The menu name text. This string is the name to give menu items. Defaults to a value of "name"',
            'prefix'      => ''
          ),
          array(
            'type'        => 'text',
            'name'        => 'All Items',
            'description' => 'The all items text used in the menu. Default is the value of "name".',
            'prefix'      => 'All'
          ),
          array(
            'type'        => 'text',
            'name'        => 'Add New Item',
            'description' => 'The add new item text. Default is Add New Post/Add New Page.',
            'prefix'      => 'Add New'
          ),
          array(
            'type'        => 'text',
            'name'        => 'New Item Name',
            'description' => "The edit item text. In the UI, this label is used as the main header on the post's editing panel.",
            'prefix'      => 'New',
            'suffix'      => 'Name',
          ),
          array(
            'type'        => 'text',
            'name'        => 'Edit Item',
            'description' => 'The edit item text.',
            'prefix'      => 'Edit'
          ),
          array(
            'type'        => 'text',
            'name'        => 'New Item',
            'description' => 'The new item text.',
            'prefix'      => 'New'
          ),
          array(
            'type'        => 'text',
            'name'        => 'View Item',
            'description' => 'The view item text. Default is View Post/View Page',
            'prefix'      => 'View'
          ),
          array(
            'type'        => 'text',
            'name'        => 'View Item',
            'description' => 'The view item text. Default is View Post/View Page',
            'prefix'      => 'View'
          ),
          array(
            'type'        => 'text',
            'name'        => 'Update Item',
            'description' => 'The update item text. Default is Search Posts/Search Pages',
            'prefix'      => 'Search'
          ),
          array(
            'type'        => 'text',
            'name'        => 'Search Items',
            'description' => 'The search items text. Default is Search Posts/Search Pages',
            'prefix'      => 'Search'
          ),
          array(
            'type'        => 'text',
            'name'        => 'Popular Items',
            'description' => 'The popular items text. Default is Search Posts/Search Pages',
            'prefix'      => 'Popular'
          ),
          array(
            'type'        => 'text',
            'name'        => 'Not Found',
            'description' => 'The not found text. Default is No posts found/No pages found',
            'prefix'      => 'No',
            'suffix'      => 'found',
          ),
          array(
            'type'        => 'text',
            'name'        => 'Parent Item',
            'description' => 'The parent item text.',
            'prefix'      => 'No',
            'suffix'      => 'found in Trash.'
          ),
          array(
            'type'        => 'text',
            'name'        => 'Parent Item Colon',
            'description' => 'The parent text. This string is used only in hierarchical post types. Default is "Parent Page"',
            'prefix'       => 'Parent',
            'suffix'       => ':',
            'suffix_space' => 'no'
          ),
          array(
            'type'        => 'text',
            'name'        => 'Separate Items With Commas',
            'description' => 'The separate item with commas text used in the taxonomy meta box.',
            'prefix'       => 'Separate',
            'suffix'       => 'With Commas',
          ),
          array(
            'type'        => 'text',
            'name'        => 'Add Or Remove Items',
            'description' => 'The add or remove items text and used in the meta box when JavaScript is disabled.',
            'prefix'       => 'Add Or Remove',
          ),
          array(
            'type'        => 'text',
            'name'        => 'Choose From Most Used',
            'description' => 'The choose from most used text used in the taxonomy meta box.',
            'prefix'       => 'Choose from the most used',
          )
        ),
        'settings' => array(
          array(
            'type'        => 'select',
            'name'        => 'Rewrite',
            'description' => 'Whether or not WordPress should use rewrites for this post type',
            'options'     => array(
              0         => 'False',
              1         => 'True',
            )
          ),
          array(
            'type'        => 'checkbox',
            'name'        => 'Rewrite Options',
            'description' => 'Whether or not WordPress should use rewrites for this post type. *Rewrite must be set to true for this to take affect',
          ),
          array(
            'type'        => 'text',
            'name'        => 'Rewrite Slug',
            'description' => 'Custom post type slug to use instead of the default. *Rewrite must be set to true for this to take affect.',
          ),
          array(
            'type'        => 'text',
            'name'        => 'Rewrite End Point Mask',
            'description' => 'Custom post type slug to use instead of the default. *Rewrite must be set to true for this to take affect.',
          ),
          array(
            'type'        => 'select',
            'name'        => 'Hierarchical',
            'description' => 'Whether the post type is hierarchical (e.g. page). Allows Parent to be specified.',
            'options'     => array(
              0         => 'False',
              1         => 'True',
            )
          ),
          array(
            'type'        => 'checkbox',
            'name'        => 'Capabilities',
            'description' => 'Capabilities for this taxonomy.',
          ),
          array(
            'type'        => 'select',
            'name'        => 'Public',
            'description' => 'Controls how the type is visible to authors and readers ',
            'options'     => array(
              0         => 'False',
              1         => 'True',
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Query Var',
            'description' => 'Sets the query_var key for this post type.',
            'options'     => array(
              0         => 'False',
              1         => 'True',
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Show Ui',
            'description' => 'Whether to generate a default UI for managing this post type in the admin.',
            'options'     => array(
              0         => 'False',
              1         => 'True',
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Show In Nav Menus',
            'description' => 'Whether post_type is available for selection in navigation menus.',
            'options' => array(
              0         => 'False',
              1         => 'True',
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Show Tagcloud',
            'description' => 'Whether to allow the Tag Cloud widget to use this taxonomy.',
            'options' => array(
              0         => 'False',
              1         => 'True',
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Show In Quick Edit',
            'description' => 'Whether to show the taxonomy in the quick/bulk edit panel.',
            'options' => array(
              0         => 'False',
              1         => 'True',
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Show Admin Column',
            'description' => 'Whether to allow automatic creation of taxonomy columns on associated types table.',
            'options' => array(
              0         => 'False',
              1         => 'True',
            )
          ),
        )
      );

      $view = new CTPView($this->use_defaults, $this->defaults, $current);
      $view->render($html[$meta_box]);
    }
  }

 function save() {

    global $post;

    $screen = get_current_screen();

    if ($screen->id == 'ctp-taxonomy') {

      if (isset($_POST['publish']) || isset($_POST['save'])) {

        if (empty($_POST['ctp-settings'])) {

          $_POST['ctp-settings'] = array();

        } else {

          if (!empty($_POST['ctp-settings']['rewrite_end_point_mask'])) {

            $option = get_option('ctp-masks');
            $masks  = explode(',', $_POST['ctp-settings']['rewrite_end_point_mask']);

            $_POST['ctp-settings']['rewrite_end_point_mask'] = $masks ;

            $option[$post->ID] = array_map('strtolower', $masks);

            update_option('ctp-masks', $option );

          }
        }

        update_option('ctp-flush-rewrite', true);

        $settings = $_POST['ctp-settings'];

        if ($this->use_defaults) {

          $settings = array_merge($this->defaults, $_POST['ctp-settings']);

        }

        update_post_meta($post->ID, 'ctp-settings', $settings);

        update_post_meta($post->ID, 'ctp-args', $settings);
      }
    }
  }

  function get_available_types() {

    return get_post_types('', 'names');

  }

  function register() {

    global $wpdb;

    $query = "
      SELECT     $wpdb->posts.post_name, $wpdb->postmeta.meta_value
      FROM       $wpdb->posts
      INNER JOIN $wpdb->postmeta
      ON         $wpdb->posts.id = $wpdb->postmeta.post_id
      WHERE      $wpdb->posts.post_type = '%s'
      AND        $wpdb->posts.post_status = '%s'
      AND        $wpdb->postmeta.meta_key = '%s'
    ";

    $results = $wpdb->get_results($wpdb->prepare($query, 'ctp-taxonomy', 'publish', 'ctp-args'
      ));

    if ( !empty($results) ) {

      foreach ($results as $result) {

        $args = maybe_unserialize($result->meta_value);

        if ($args['rewrite'] == 1) {

          foreach ($args['rewrite_options'] as $key => $option) {

            $args['rewrite_options'][$option] = true;

            unset($args['rewrite_options'][$key]);

          }

          $rewrite_options         = $args['rewrite_options'];
          $rewrite_options['slug'] = sanitize_title( $args['rewrite_slug'] );

          if (!empty($args['rewrite_end_point_mask'])) {

            $ep_mask = 0;
            $masks   = $args['rewrite_end_point_mask'];

            foreach ($masks as $mask) {

              $ep_mask |= constant(strtoupper('ep_' . $mask));

            }

            foreach ($masks as $mask) {

              add_rewrite_endpoint( $mask, constant(strtoupper('ep_' . $mask) ) );

            }

            $rewrite_options['ep_mask'] = $ep_mask;

          }
        }
        else {

          $rewrite_options = false;

        }

        $final_args = array(
            'labels'  => array(
              'name'                       => __( $args['name'] ),
              'singular_name'              => __( $args['singular_name'] ),
              'menu_name'                  => __( $args['menu_name'] ),
              'all_items'                  => __( $args['all_items'] ),
              'add_new_item'               => __( $args['add_new_item'] ),
              'new_item_name'              => __( $args['new_item_name'] ),
              'edit_item'                  => __( $args['edit_item'] ),
              'new_item'                   => __( $args['new_item'] ),
              'view_item'                  => __( $args['view_item'] ),
              'update_item'                => __( $args['update_item'] ),
              'search_items'               => __( $args['search_items'] ),
              'popular_items'              => __( $args['popular_items'] ),
              'not_found'                  => __( $args['not_found'] ),
              'parent_item'                => __( $args['parent_item'] ),
              'parent_item_colon'          => __( $args['parent_item_colon'] ),
              'separate_items_with_commas' => __( $args['separate_items_with_commas'] ),
              'add_or_remove_items'        => __( $args['add_or_remove_items'] ),
              'choose_from_most_used'      => __( $args['choose_from_most_used'] ),
              'not_found'                  => __( $args['not_found'] ),
            ),
            'public'              => $args['public']              == '1' ? true : false,
            'exclude_from_search' => $args['exclude_from_search'] == '1' ? true : false,
            'show_ui'             => $args['show_ui']             == '1' ? true : false,
            'show_in_nav_menus'   => $args['show_in_nav_menus']   == '1' ? true : false,
            'show_tagcloud'       => $args['show_tagcloud']       == '1' ? true : false,
            'show_in_quick_edit'  => $args['show_in_quick_edit']  == '1' ? true : false,
            'show_admin_column'   => $args['show_admin_column']   == '1' ? true : false,
            'hierarchical'        => $args['hierarchical']        == '1' ? true : false,
            'query_var'           => $args['query_var']           == '1' ? true : false,
            'description'         => $args['description'],
            'capabilities'        => $args['capabilities'],
            'rewrite'             => $rewrite_options ,
        );

        register_taxonomy(
          rtrim(substr($result->post_name, 0, 20), "-"),
          $args['post_types'],
          $final_args
        );
      }
    }
  }
}