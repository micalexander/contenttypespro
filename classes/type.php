<?php

class CTPType {

  var $use_defaults = false;
  var $defaults = array(
    'name'                => '',
    'singular_name'       => '',
    'menu_name'           => '',
    'name_admin_bar'      => '',
    'all_items'           => '',
    'add_new'             => 'Add New',
    'add_new_item'        => '',
    'edit_item'           => '',
    'new_item'            => '',
    'view_item'           => '',
    'search_items'        => '',
    'not_found'           => '',
    'not_found_in_trash'  => '',
    'parent_item_colon'   => '',
    'description'         => '',
    'public'              => true,
    'exclude_from_search' => false,
    'show_ui'             => true,
    'show_in_nav_menus'   => true,
    'show_in_menu'        => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 5,
    'menu_icon'           => 'dashicons-star-filled',
    'capability_type'     => 'post',
    'hierarchical'        => false,
    'supports'            => array(
      'title'           => true,
      'editor'          => true,
      'excerpt'         => false,
      'trackbacks'      => false,
      'custom_fields'   => false,
      'comments'        => false,
      'revisions'       => true,
      'featured_image'  => false,
      'author'          => true,
      'page_attributes' => false,
      'post_formats'    => false,
      'none'            => false,
    ),
    'has_archive'            => true,
    'rewrite'                => true,
    'rewrite_slug'           => '',
    'rewrite_end_point_mask' => '',
    'rewrite_options' => array(
      'with_front' => true,
      'feeds'      => true,
      'pages'      => true,
    ),
    'query_var'           => true,
    'built_in_taxonomies' => array(
      'category' => false,
      'post_tag' => false,
    ),
  );

  var $bools = array(
    'rewrite_options'
  );

  function meta_boxes() {

    add_meta_box(
      'ctp-description',              // id
      __( 'Description' ),            // title
      array( $this, 'meta_options'),  // callback
      'ctp-type',              // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'description') // callback_args
    );

    add_meta_box(
      'ctp-labels',                  // id
      __( 'Labels' ),                // title
      array( $this, 'meta_options'), // callback
      'ctp-type',                    // screen
      'normal',                      // context
      'low',                         // priority
      array( 'type' => 'labels')     // callback_args
    );

    add_meta_box(
      'ctp-settings',                // id
      __( 'Advanced Settings' ),     // title
      array( $this, 'meta_options'), // callback
      'ctp-type',                    // screen
      'normal',                      // context
      'low',                         // priority
      array( 'type' => 'settings')   // callback_args
    );
  }

  function meta_options( $post, $meta_box_args ) {

    $meta_box = $meta_box_args['args']['type'];
    $screen   = get_current_screen();

    if ($screen->id == 'ctp-type') {

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
            'type'        => 'textarea',
            'name'        => 'Description',
            'description' => 'A short descriptive summary of what the post type is.'
          ),
          array(
            'type'        => 'select',
            'name'        => 'Menu Icon',
            'description' => 'The menu icon to display',
            'options' => array(
              'dashicons-admin-appearance'        => 'admin appearance',
              'dashicons-admin-collapse'          => 'admin collapse',
              'dashicons-admin-comments'          => 'admin comments',
              'dashicons-admin-generic'           => 'admin generic',
              'dashicons-admin-home'              => 'admin home',
              'dashicons-admin-links'             => 'admin links',
              'dashicons-admin-media'             => 'admin media',
              'dashicons-admin-network'           => 'admin network',
              'dashicons-admin-page'              => 'admin page',
              'dashicons-admin-plugins'           => 'admin plugins',
              'dashicons-admin-post'              => 'admin post',
              'dashicons-admin-settings'          => 'admin settings',
              'dashicons-admin-site'              => 'admin site',
              'dashicons-admin-tools'             => 'admin tools',
              'dashicons-admin-users'             => 'admin users',
              'dashicons-align-center'            => 'align center',
              'dashicons-align-left'              => 'align left',
              'dashicons-align-none'              => 'align none',
              'dashicons-align-right'             => 'align right',
              'dashicons-analytics'               => 'analytics',
              'dashicons-arrow-down'              => 'arrow down',
              'dashicons-arrow-down-alt'          => 'arrow down alt',
              'dashicons-arrow-down-alt2'         => 'arrow down alt2',
              'dashicons-arrow-left'              => 'arrow left',
              'dashicons-arrow-left-alt'          => 'arrow left alt',
              'dashicons-arrow-left-alt2'         => 'arrow left alt2',
              'dashicons-arrow-right'             => 'arrow right',
              'dashicons-arrow-right-alt'         => 'arrow right alt',
              'dashicons-arrow-right-alt2'        => 'arrow right alt2',
              'dashicons-arrow-up'                => 'arrow up',
              'dashicons-arrow-up-alt'            => 'arrow up alt',
              'dashicons-arrow-up-alt2'           => 'arrow up alt2',
              'dashicons-art'                     => 'art',
              'dashicons-awards'                  => 'awards',
              'dashicons-backup'                  => 'backup',
              'dashicons-book'                    => 'book',
              'dashicons-book-alt'                => 'book alt',
              'dashicons-businessman'             => 'businessman',
              'dashicons-calendar'                => 'calendar',
              'dashicons-camera'                  => 'camera',
              'dashicons-cart'                    => 'cart',
              'dashicons-category'                => 'category',
              'dashicons-chart-area'              => 'chart area',
              'dashicons-chart-bar'               => 'chart bar',
              'dashicons-chart-line'              => 'chart line',
              'dashicons-chart-pie'               => 'chart pie',
              'dashicons-cloud'                   => 'cloud',
              'dashicons-dashboard'               => 'dashboard',
              'dashicons-dismiss'                 => 'dismiss',
              'dashicons-download'                => 'download',
              'dashicons-edit'                    => 'edit',
              'dashicons-editor-aligncenter'      => 'editor aligncenter',
              'dashicons-editor-alignleft'        => 'editor alignleft',
              'dashicons-editor-alignright'       => 'editor alignright',
              'dashicons-editor-bold'             => 'editor bold',
              'dashicons-editor-customchar'       => 'editor customchar',
              'dashicons-editor-distractionfree'  => 'editor distractionfree',
              'dashicons-editor-help'             => 'editor help',
              'dashicons-editor-indent'           => 'editor indent',
              'dashicons-editor-insertmore'       => 'editor insertmore',
              'dashicons-editor-italic'           => 'editor italic',
              'dashicons-editor-justify'          => 'editor justify',
              'dashicons-editor-kitchensink'      => 'editor kitchensink',
              'dashicons-editor-ol'               => 'editor ol',
              'dashicons-editor-outdent'          => 'editor outdent',
              'dashicons-editor-paste-text'       => 'editor paste text',
              'dashicons-editor-paste-word'       => 'editor paste word',
              'dashicons-editor-quote'            => 'editor quote',
              'dashicons-editor-removeformatting' => 'editor removeformatting',
              'dashicons-editor-rtl'              => 'editor rtl',
              'dashicons-editor-spellcheck'       => 'editor spellcheck',
              'dashicons-editor-strikethrough'    => 'editor strikethrough',
              'dashicons-editor-textcolor'        => 'editor textcolor',
              'dashicons-editor-ul'               => 'editor ul',
              'dashicons-editor-underline'        => 'editor underline',
              'dashicons-editor-unlink'           => 'editor unlink',
              'dashicons-editor-video'            => 'editor video',
              'dashicons-exerpt-view'             => 'exerpt view',
              'dashicons-facebook'                => 'facebook',
              'dashicons-facebook-alt'            => 'facebook alt',
              'dashicons-feedback'                => 'feedback',
              'dashicons-flag'                    => 'flag',
              'dashicons-format-aside'            => 'format aside',
              'dashicons-format-audio'            => 'format audio',
              'dashicons-format-chat'             => 'format chat',
              'dashicons-format-gallery'          => 'format gallery',
              'dashicons-format-image'            => 'format image',
              'dashicons-format-quote'            => 'format quote',
              'dashicons-format-status'           => 'format status',
              'dashicons-format-video'            => 'format video',
              'dashicons-forms'                   => 'forms',
              'dashicons-googleplus'              => 'googleplus',
              'dashicons-groups'                  => 'groups',
              'dashicons-hammer'                  => 'hammer',
              'dashicons-id'                      => 'id',
              'dashicons-id-alt'                  => 'id alt',
              'dashicons-image-crop'              => 'image crop',
              'dashicons-image-flip-horizontal'   => 'image flip horizontal',
              'dashicons-image-flip-vertical'     => 'image flip vertical',
              'dashicons-image-rotate-left'       => 'image rotate left',
              'dashicons-image-rotate-right'      => 'image rotate right',
              'dashicons-images-alt'              => 'images alt',
              'dashicons-images-alt2'             => 'images alt2',
              'dashicons-info'                    => 'info',
              'dashicons-leftright'               => 'leftright',
              'dashicons-lightbulb'               => 'lightbulb',
              'dashicons-list-view'               => 'list view',
              'dashicons-location'                => 'location',
              'dashicons-location-alt'            => 'location alt',
              'dashicons-lock'                    => 'lock',
              'dashicons-marker'                  => 'marker',
              'dashicons-menu'                    => 'menu',
              'dashicons-migrate'                 => 'migrate',
              'dashicons-minus'                   => 'minus',
              'dashicons-networking'              => 'networking',
              'dashicons-no'                      => 'no',
              'dashicons-no-alt'                  => 'no alt',
              'dashicons-performance'             => 'performance',
              'dashicons-plus'                    => 'plus',
              'dashicons-portfolio'               => 'portfolio',
              'dashicons-post-status'             => 'post status',
              'dashicons-pressthis'               => 'pressthis',
              'dashicons-products'                => 'products',
              'dashicons-redo'                    => 'redo',
              'dashicons-rss'                     => 'rss',
              'dashicons-screenoptions'           => 'screenoptions',
              'dashicons-search'                  => 'search',
              'dashicons-share'                   => 'share',
              'dashicons-share-alt'               => 'share alt',
              'dashicons-share-alt2'              => 'share alt2',
              'dashicons-shield'                  => 'shield',
              'dashicons-shield-alt'              => 'shield alt',
              'dashicons-slides'                  => 'slides',
              'dashicons-smiley'                  => 'smiley',
              'dashicons-sort'                    => 'sort',
              'dashicons-star-empty'              => 'star empty',
              'dashicons-star-filled'             => 'star filled',
              'dashicons-star-half'               => 'star half',
              'dashicons-tag'                     => 'tag',
              'dashicons-translation'             => 'translation',
              'dashicons-trash'                   => 'trash',
              'dashicons-twitter'                 => 'twitter',
              'dashicons-undo'                    => 'undo',
              'dashicons-update'                  => 'update',
              'dashicons-upload'                  => 'upload',
              'dashicons-vault'                   => 'vault',
              'dashicons-video-alt'               => 'video alt',
              'dashicons-video-alt2'              => 'video alt2',
              'dashicons-video-alt3'              => 'video alt3',
              'dashicons-visibility'              => 'visibility',
              'dashicons-welcome-add-page'        => 'welcome add page',
              'dashicons-welcome-comments'        => 'welcome comments',
              'dashicons-welcome-learn-more'      => 'welcome learn more',
              'dashicons-welcome-view-site'       => 'welcome view site',
              'dashicons-welcome-widgets-menus'   => 'welcome widgets menus',
              'dashicons-welcome-write-blog'      => 'welcome write blog',
              'dashicons-wordpress'               => 'wordpress',
              'dashicons-wordpress-alt'           => 'wordpress alt',
              'dashicons-yes'                     => 'yes',              'dashicons-yes'                     => 'Yes',
            )
          ),
          array(
            'type'        => 'number',
            'name'        => 'Menu Position',
            'description' => 'The position in the menu order the post type should appear. show_in_menu must be true.',
          ),
          array(
            'type'        => 'checkbox',
            'name'        => 'Supports',
            'description' => 'Adds support for specified the specified metabox',
          ),
          array(
            'type'        => 'checkbox',
            'name'        => 'Built In Taxonomies',
            'description' => 'Adds Categories or Tags support',
          ),
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
            'name'        => 'Name Admin Bar',
            'description' => 'The name given for the "Add New" dropdown on admin bar. Defaults to "singular_name" if it exists, "name".',
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
            'name'        => 'Add New',
            'description' => 'The add new text. The default is "Add New".',
          ),
          array(
            'type'        => 'text',
            'name'        => 'Add New Item',
            'description' => 'The add new item text. Default is Add New Post/Add New Page.',
            'prefix'      => 'Add New'
          ),
          array(
            'type'        => 'text',
            'name'        => 'Edit Item',
            'description' => "The edit item text. In the UI, this label is used as the main header on the post's editing panel.",
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
            'name'        => 'Search Items',
            'description' => 'The search items text. Default is Search Posts/Search Pages',
            'prefix'      => 'Search'
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
            'name'        => 'Not Found in Trash',
            'description' => 'The not found in trash text. Default is No posts found in Trash/No pages found in Trash.',
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
            'type'        => 'select',
            'name'        => 'Has Archive',
            'description' => 'Enables post type archives. Will use $post_type as archive slug by default.',
            'options'     => array(
              0         => 'False',
              1         => 'True',
            )
          ),
          array(
            'type'        => 'text',
            'name'        => 'Capability Type',
            'description' => 'The string to use to build the read, edit, and delete capabilities.',
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
            'name'        => 'Exclude From Search',
            'description' => 'Whether to exclude posts with this post type from front end search results.',
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
            'name'        => 'Publicly Queryable',
            'description' => 'Whether queries can be performed on the front end as part of parse_request()',
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
            'name'        => 'Show In Menu',
            'description' => 'Where to show the post type in the admin menu. show_ui must be true.',
            'options' => array(
              0         => 'False',
              1         => 'True',
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Show In Admin Bar',
            'description' => 'Whether to make this post type available in the WordPress admin bar.',
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

    if ($screen->id == 'ctp-type') {

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

        $settings = $this->format_bools($settings);

        update_post_meta($post->ID, 'ctp-args', $settings);

      }
    }
  }

  function format_bools($settings) {

    foreach ($this->bools as $boolify) {

      $bool_cage = $settings[$boolify];

      $settings[$boolify] = array();

      foreach ($this->defaults[$boolify] as $bool => $value) {

        if (in_array($bool, $bool_cage)) {

          $settings[$boolify][$bool] = true;
        }
        else {

          $settings[$boolify][$bool] = false;
        }
      }
    }

    return $settings;

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

    $results = $wpdb->get_results($wpdb->prepare($query, 'ctp-type', 'publish', 'ctp-args'
      ));

    if ( !empty($results) ) {

      foreach ($results as $result) {

        $args = maybe_unserialize($result->meta_value);

        if ($args['rewrite'] == 1) {

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
            'name'               => __( $args['name'] ),
            'singular_name'      => __( $args['singular_name'] ),
            'menu_name'          => __( $args['menu_name'] ),
            'name_admin_bar'     => __( $args['name_admin_bar'] ),
            'all_items'          => __( $args['all_items'] ),
            'add_new'            => __( $args['add_new'] ),
            'add_new_item'       => __( $args['add_new_item'] ),
            'edit_item'          => __( $args['edit_item'] ),
            'new_item'           => __( $args['new_item'] ),
            'view_item'          => __( $args['view_item'] ),
            'search_items'       => __( $args['search_items'] ),
            'not_found'          => __( $args['not_found'] ),
            'not_found_in_trash' => __( $args['not_found_in_trash'] ),
            'parent_item_colon'  => __( $args['parent_item_colon'] ),
          ),
          'public'                 => $args['public']                 == 'False' ? false : true,
          'exclude_from_search'    => $args['exclude_from_search']    == 'False' ? false : true,
          'show_ui'                => $args['show_ui']                == 'False' ? false : true,
          'show_in_nav_menus'      => $args['show_in_nav_menus']      == 'False' ? false : true,
          'show_in_menu'           => $args['show_in_menu']           == 'False' ? false : true,
          'show_in_menu_admin_bar' => $args['show_in_menu_admin_bar'] == 'False' ? false : true,
          'hierarchical'           => $args['hierarchical']           == 'False' ? false : true,
          'has_archive'            => $args['has_archive']            == 'False' ? false : true,
          'query_var'              => $args['query_var']              == 'False' ? false : true,
          'description'            => $args['description'],
          'menu_position'          => intval($args['menu_position']),
          'menu_icon'              => $args['menu_icon'],
          'capability_type'        => $args['capability_type'],
          'supports'               => $args['supports'],
          'rewrite'                => $rewrite_options,
        );

        if (!empty($args['built_in_taxonomies'])) {

          $final_args['taxonomies'] = $args['built_in_taxonomies'];

        }

        register_post_type(
          rtrim(substr($result->post_name, 0, 20), "-"),
          $final_args
        );
      }
    }
  }
}