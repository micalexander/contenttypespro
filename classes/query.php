<?php
/**
 * query.php
 */


/**
 * This class is used to create metaboxes and save query arguments for later use.
 *
 * This class is associated with the Query page within
 * the plugin. It is used to capture arguments that will
 * be stored in the database for later use.
 *
 *
 * @author  Michael Alexander
 *
 */
class CTPQuery {

  /**
   * To use default args or not
   * @var boolean
   */
  public $use_defaults = false;

  /**
   * An array of default arguments
   * @var array
   */
  public $defaults = array(
    'author__in'             => '',
    'author__not_in'         => '',
    'cat'                    => '',
    'category_name'          => '',
    'category__and'          => '',
    'category__in'           => '',
    'category__not_in'       => '',
    'tag'                    => '',
    'tag_id'                 => '',
    'tag__and'               => '',
    'tag__in'                => '',
    'tag__not_in'            => '',
    'tag_slug__and'          => '',
    'tag_slug__in'           => '',
    'name'                   => '',
    'page_id'                => '',
    'pagename'               => '',
    'post_parent'            => '',
    'post_parent__in'        => '',
    'post_parent__not_in'    => '',
    'post__in'               => '',
    'post__not_in'           => '',
    'has_password'           => 'null',
    'post_password'          => '',
    'post_type'              => '',
    'post_status'            => array(
      'publish'    => true,
      'pending'    => false,
      'draft'      => false,
      'auto-draft' => false,
      'future'     => false,
      'private'    => false,
      'inherit'    => false,
      'trash'      => false
    ),
    'posts_per_page'         => 10,
    'posts_per_archive_page' => 10,
    // 'paged'                  => '',
    // 'page'                   => '',
    'nopaging'               => false,
    'offset'                 => '',
    'ignore_sticky_posts'    => '',
    'order'                  => 'DESC',
    'orderby'                => 'date',
    'meta_key'               => '',
    'meta_value'             => '',
    'type'                   => 'CHAR',
    'type_2'                 => 'CHAR',
    'include_children'       => true,
    'include_children_2'     => true,
    'operator'               => 'IN',
    'operator_2'             => 'IN',
    'meta_compare'           => '=',
    'perm'                   => '',
    'cache_results'          => true,
    'update_post_term_cache' => true,
    'update_post_meta_cache' => true,
    'no_found_rows'          => false,
    'exact'                  => false,
    'sentence'               => false,
  );



  /**
   * Necessary arguments that blueprint each metabox to be
   * added to the page
   *
   * @return void
   */
  function meta_boxes() {

    add_meta_box(
      'ctp-post',                    // id
      __( 'Post Options' ),          // title
      array( $this, 'meta_options'), // callback
      'ctp-query',                   // screen
      'normal',                    // context
      'low',                         // priority
      array( 'type' => 'post')       // callback_args
    );

    add_meta_box(
      'ctp-post-filters',              // id
      __( 'Post Filters' ),            // title
      array( $this, 'meta_options'),   // callback
      'ctp-query',                     // screen
      'normal',                      // context
      'low',                           // priority
      array( 'type' => 'post-filters') // callback_args
    );

    add_meta_box(
      'ctp-parent-filters',              // id
      __( 'Parent Filters' ),            // title
      array( $this, 'meta_options'),     // callback
      'ctp-query',                       // screen
      'normal',                        // context
      'low',                             // priority
      array( 'type' => 'parent-filters') // callback_args
    );

    add_meta_box(
      'ctp-sort',               // id
      __( 'Sorting Options' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'sort')  // callback_args
    );


    add_meta_box(
      'ctp-date',               // id
      __( 'Date Filters' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'date')  // callback_args
    );

    add_meta_box(
      'ctp-pagination',               // id
      __( 'Pagination Options' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'pagination')  // callback_args
    );

    add_meta_box(
      'ctp-meta',               // id
      __( 'Meta Filters' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'meta')  // callback_args
    );

    add_meta_box(
      'ctp-tax',               // id
      __( 'Taxonomy Filters' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'tax_query')  // callback_args
    );

    add_meta_box(
      'ctp-category',               // id
      __( 'Category Filters' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'category')  // callback_args
    );

    add_meta_box(
      'ctp-tag',               // id
      __( 'Tag Filters' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'tag')  // callback_args
    );

    add_meta_box(
      'ctp-author',               // id
      __( 'Author Filters' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'author')  // callback_args
    );

    add_meta_box(
      'ctp-password',               // id
      __( 'Password Filters' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'password')  // callback_args
    );

    add_meta_box(
      'ctp-permission',               // id
      __( 'Permission Filters' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'permission')  // callback_args
    );

    add_meta_box(
      'ctp-sticky',               // id
      __( 'Sticky Filters' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'sticky')  // callback_args
    );

    add_meta_box(
      'ctp-search',               // id
      __( 'Searching Options' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'search')  // callback_args
    );

    add_meta_box(
      'ctp-cache',               // id
      __( 'Cache Options' ),             // title
      array( $this, 'meta_options'),  // callback
      'ctp-query',                    // screen
      'normal',                       // context
      'low',                          // priority
      array( 'type' => 'cache')  // callback_args
    );

    // add_meta_box(
    //   'ctp-query-options',               // id
    //   __( 'Query Options' ),             // title
    //   array( $this, 'meta_options'),  // callback
    //   'ctp-query',                    // screen
    //   'normal',                       // context
    //   'low',                          // priority
    //   array( 'type' => 'menu')  // callback_args
    // );
  }
  /**
   * This method deals with the generation the html for the
   * metaboxes that will be displayed on the query page.
   *
   * This method is called by add_meta_box from the meta_boxes
   * method of this class. It makes sure we are on the ctp-query
   * page and outputs html elements based on the $meta_box_args
   * that are passed to it.
   *
   * With in it is an $html array where each key corresponds with
   * a metabox and the elements/inputs that belong within it.
   *
   * Element
   *
   * @param  object $post         the current post object
   * @param  array $meta_box_args array('type' => '[metabox_name]')
   * @return void
   */
  function meta_options( $post, $meta_box_args ) {


    $meta_box = $meta_box_args['args']['type'];
    $screen   = get_current_screen();

    if ($screen->id == 'ctp-query') {

      global $post;

      $settings = get_post_meta($post->ID, 'ctp-settings', true);
      $current  = !empty($settings) ? $settings : false;
      $args     = get_post_meta($post->ID, 'ctp-args', true);

      if ( !$args ) {

        $this->use_defaults = true;

      }

      /**
       * Array of html elements and form fields to be rendered to the page.
       *
       * $html => (array)
       *   - type        required => (string) html|text|select|date|number|radio|checkbox
       *   - name        optional => (string) the name attribute for the form field
       *   - description optional => (string) description of what this element is for
       *   - id          optional => (string) id of element. requied if used with conditional
       *   - html        optional => (mixed) prefix|suffix|elements required if type is html
       *   used for outputting html instead of form field
       *     - prefix   optional => (string) opening tags e.g. '<ul>'
       *     - suffix   optional => (string) closing tags e.g. '</ul>'
       *     - elements required => (array) array fo elements e.g. array('<li>...</li>','<li>...</li>')
       *   - multiple     optional => (bool)   if this form field ....?
       *   - conditionals optional => (array)  a nested array of conditions
       *     - key         required => (string) id of the form field its condition relys on
       *     - type        optional => (string) is|not defaults to is
       *     - conditions  required => (array) values it should or should not react to
       *     depending on if its type is "is" or "not"
       *   - options      optional => (array)  required for select form field type key/value p
       *   air of options
       *
       * @var array
       */
      $html = array(
        'post' => array(
          array(
            'type'        => 'select',
            'name'        => 'Post Type',
            'description' => 'Retrieves posts by Post Types.',
            'options'     => $this->get_available_types()
          ),
        ),
        'post-filters' => array(
          array(
            'type'        => 'checkbox',
            'name'        => 'Post Status',
            'description' => 'Retrieves posts by Post Status.',
            'class'       => 'icheckbox_flat-green'
          ),
          array(
            'type'        => 'select',
            'name'        => 'Post ID',
            'description' => 'Use author id (available with Version 3.7).',
            'id'          => 'post-select',
            'options' => array(
              'false' => 'any',
              'is-one-of-ids' => 'is one of IDs',
              'is-none-of-ids' => 'is none of IDs'
            ),
          ),
          array(
            'type'        => 'text',
            'name'        => 'Post  In',
            'description' => 'Use post ids ( e.g. 2, 6 ) NOTE: you cannot combine "post__in" and "post__not_in" in the same query.',
            // 'multiple' => true,
            'conditionals' => array(
              array(
                'key'        => 'post-select',
                'conditions' => array(
                  'is-one-of-ids'
                )
              )
            ),
          ),
          array(
            'type'        => 'text',
            'name'        => 'Post Not  In',
            'description' => 'Use post ids ( e.g. 2, 6 ) NOTE: you cannot combine "post__in" and "post__not_in" in the same query.',
            // 'multiple' => true,
            'conditionals' => array(
              array(
                'key'        => 'post-select',
                'conditions' => array(
                  'is-none-of-ids'
                )
              )
            ),
          ),
        ),
        'menu' => array(
          array(
            'type'        => 'html',
            'name'        => false,
            'description' => false,
            'html'          => array(
              'prefix' => '<ul>',
              'suffix' => '</ul>',
              'elements' => array(
                '<li><a href="#ctp-post">Post</a></li>',
                '<li><a href="#ctp-post-filters">Post Filters</a></li>',
                '<li><a href="#ctp-parent-filters">Parent Filters</a></li>',
                '<li><a href="#ctp-sort">Sort</a></li>',
                '<li><a href="#ctp-date">Date</a></li>',
                '<li><a href="#ctp-pagination">Pagination</a></li>',
                '<li><a href="#ctp-meta">Meta</a></li>',
                '<li><a href="#ctp-category">Category</a></li>',
                '<li><a href="#ctp-tag">Tag</a></li>',
                '<li><a href="#ctp-author">Author</a></li>',
                '<li><a href="#ctp-password">Password</a></li>',
                '<li><a href="#ctp-permission">Permission</a></li>',
                '<li><a href="#ctp-sticky">Sticky</a></li>',
                '<li><a href="#ctp-search">Search</a></li>',
                '<li><a href="#ctp-cache">Cache</a></li>',
              )
            )
          ),
        ),
        'parent-filters' => array(
          array(
            'type'        => 'select',
            'name'        => 'Post ID',
            'description' => 'Use author id (available with Version 3.7).',
            'id'          => 'parent-filters',
            'options' => array(
              'false' => 'any',
              'parent-has-one-of-ids' => 'parent has one of IDs',
              'parent-has-none-of-ids' => 'parent has none of IDs'
            ),
          ),
          array(
            'type'        => 'text',
            'name'        => 'Post Parent  In',
            'description' => 'Use post ids ( e.g. 2, 6 ).',
            'multiple' => true,
            'conditionals' => array(
              array(
                'key'        => 'parent-filters',
                'conditions' => array(
                  'parent-has-one-of-ids'
                )
              )
            ),
          ),
          array(
            'type'        => 'text',
            'name'        => 'Post Parent  Not In',
            'description' => 'Use post ids ( e.g. 2, 6 ).',
            'multiple' => true,
            'conditionals' => array(
              array(
                'key'        => 'parent-filters',
                'conditions' => array(
                  'parent-has-none-of-ids'
                )
              )
            ),
          ),
        ),
        'sort' => array(
          array(
            'type'        => 'select',
            'name'        => 'Order',
            'description' => 'Designates the ascending or descending order of the "orderby" parameter. Default to "DESC".',
            'options'     => array(
              'ASC'  => 'ASC',
              'DESC' => 'DESC',
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Orderby',
            'description' => 'Sort retrieved posts by parameter. Defaults to "date".',
            'id'          => 'orderby',
            'options'     => array(
              'none'             => 'none',
              'ID'               => 'ID',
              'author'           => 'author',
              'title'            => 'title',
              'name'             => 'name',
              'date'             => 'date',
              'modified'         => 'modified',
              'parent'           => 'parent',
              'rand'             => 'rand',
              'comment_count'    => 'comment count',
              'menu_order'       => 'menu order',
              'meta_value'       => 'meta value',
              'meta_value_num'   => 'meta value num',
              'title menu_order' => 'title menu order',
              'post__in'         => 'post in',
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Meta Key',
            'description' => 'Custom field key.',
            'class'       => 'ajax',
            'data'        => array(
              'post_id' => $post->ID
            ),
            'conditionals' => array(
              array(
                'key'        => 'orderby',
                'conditions' => array(
                  'meta_value',
                  'meta_value_num'
                )
              )
            )
          ),
        ),
        'date' => array(
          array(
            'type'        => 'select',
            'name'        => 'Date',
            'description' => 'Choose how to filter by.',
            'id'          => 'date',
            'options'     => array(
              0                                   => 'false',
              'specific-date'                     => 'specific date',
              'between-dates'                     => 'between dates',
              'after-date'                        => 'after date',
              'before-date'                       => 'before date',
              // 'after-page-load'                   => 'after page load',
              'before-page-load'                  => 'before page load',
              'between-past-date-and-page-load'   => 'between past date and page load',
              // 'between-page-load-and-future-date' => 'between page load and future date',
            )
          ),
          array(
            'type'        => 'date',
            'name'        => 'Specific Date',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'class'       => 'ctp-date',
            'conditionals' => array(
              array(
                'key'        => 'date',
                'conditions' => array(
                  'specific-date'
                )
              )
            )
          ),
          array(
            'type'        => 'date',
            'name'        => 'After Date',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'class'       => 'ctp-date',
            'conditionals' => array(
              array(
                'key'        => 'date',
                'conditions' => array(
                  'after-date',
                  'between-dates'
                )
              )
            )
          ),
          array(
            'type'        => 'date',
            'name'        => 'Before Date',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'class'       => 'ctp-date',
            'conditionals' => array(
              array(
                'key'        => 'date',
                'conditions' => array(
                  'before-date',
                  'between-dates'
                )
              )
            )
          ),
          array(
            'type'        => 'date',
            'name'        => 'Past Date',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'class'       => 'ctp-date',
            'conditionals' => array(
              array(
                'key'        => 'date',
                'conditions' => array(
                  'between-past-date-and-page-load'
                )
              )
            )
          ),
        ),
        'pagination' => array(
          array(
            'type'        => 'select',
            'name'        => 'Nopaging',
            'description' => 'Show all posts or use pagination. Default value is "false", use paging.',
            'options'     => array(
              0    => 'false',
              1    => 'true'
            )
          ),
          array(
            'type'        => 'number',
            'name'        => 'Posts Per Page',
            'description' => 'Number of post to show per page (available with Version 2.1). Use -1 to show all posts.',
          ),
          array(
            'type'        => 'number',
            'name'        => 'Posts Per Archive Page',
            'description' => 'On archive pages only. Over-rides posts_per_page and show posts on pages where is_archive() or is_search() would be true.',
          ),
          array(
            'type'        => 'number',
            'name'        => 'Offset',
            'description' => 'Number of post to displace or pass over.',
          ),
          array(
            'type'        => 'select',
            'name'        => 'No Found Rows',
            'description' => 'By Setting this parameter to true you are telling wordPress not to count the total rows and reducing load on the DB. Pagination will NOT WORK when this parameter is set to true.',
            'options'     => array(
              0    => 'false',
              1    => 'true'
            )
          ),
        ),
        'tax_query' => array(
          array(
            'type'        => 'select',
            'name'        => 'Tax Query',
            'description' => 'Choose what taxonomy and term to filter by.',
            'id'          => 'tax',
            'options'     => array(
              0      => 'false',
              'true' => 'true',
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Taxonomy',
            'description' => 'Taxonomy.',
            'class'       => 'ajax',
            'data'        => array(
              'post_id' => $post->ID
            ),
            'conditionals' => array(
              array(
                'key'        => 'tax',
                'conditions' => array(
                  'true'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Term',
            'description' => 'Taxonomy term(s).',
            'class'       => 'ajax',
            'conditionals' => array(
              array(
                'key'        => 'tax',
                'conditions' => array(
                  'true'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Include Children',
            'description' => 'Choose to include child terms or not',
            'options'     => array(
              0      => 'false',
              'true' => 'true',
            ),
            'conditionals' => array(
              array(
                'key'        => 'tax',
                'conditions' => array(
                  'true'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Operator',
            'description' => 'Operator to test.',
            'options'     => array(
              'IN'         => 'IN',
              'NOT IN'     => 'NOT IN',
              'AND'        => 'AND',
              'EXISTS'     => 'EXISTS',
              'NOT EXISTS' => 'NOT EXISTS',
            ),
            'conditionals' => array(
              array(
                'key'        => 'tax',
                'conditions' => array(
                  'true'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Relation',
            'alt_name'    => 'tax_relation',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'id' =>'tax_relation',
            'options'     => array(
              'none' => 'N/A',
              'AND'  => 'AND',
              'OR'   => 'OR'
            ),
            'conditionals' => array(
              array(
                'key'        => 'tax',
                'conditions' => array(
                  'true'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Taxonomy 2',
            'description' => 'Taxonomy.',
            'class'       => 'ajax',
            'data'        => array(
              'post_id' => $post->ID
            ),
            'conditionals'  => array(
              array(
                'key'        => 'tax_relation',
                'conditions' => array(
                  'AND',
                  'OR'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Term 2',
            'description' => 'Taxonomy term(s).',
            'class'       => 'ajax',
            'conditionals' => array(
              array(
                'key'        => 'tax_relation',
                'conditions' => array(
                  'AND',
                  'OR'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Include Children 2',
            'description' => 'Choose to include child terms or not',
            'options'     => array(
              0      => 'false',
              'true' => 'true',
            ),
            'conditionals' => array(
              array(
                'key'        => 'tax_relation',
                'conditions' => array(
                  'AND',
                  'OR'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Operator 2',
            'description' => 'Operator to test.',
            'options'     => array(
              'IN'         => 'IN',
              'NOT IN'     => 'NOT IN',
              'AND'        => 'AND',
              'EXISTS'     => 'EXISTS',
              'NOT EXISTS' => 'NOT EXISTS',
            ),
            'conditionals' => array(
              array(
                'key'        => 'tax_relation',
                'conditions' => array(
                  'AND',
                  'OR'
                )
              )
            )
          )
        ),
        'meta' => array(
          array(
            'type'        => 'select',
            'name'        => 'Meta Query',
            'description' => 'Choose what custom field to filter by.',
            'id'          => 'meta',
            'options'     => array(
              0      => 'false',
              'true' => 'true',
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Key',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'class'       => 'ajax',
            'data'        => array(
              'post_id' => $post->ID
            ),
            'conditionals' => array(
              array(
                'key'        => 'meta',
                'conditions' => array(
                  'true'
                )
              )
            )
          ),
          array(
            'type'        => 'text',
            'name'        => 'Value',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'conditionals' => array(
              array(
                'key'         => 'type',
                'type'        => 'not',
                'conditions' => array(
                  'DATE',
                  'NUMERIC',
                  'DATETIME',
                  'DATETIMEOFPAGELOAD',
                )
              ),
              array(
                'key'        => 'meta',
                'conditions' => array(
                  'true'
                )
              ),
            )
          ),
          array(
            'type'        => 'date',
            'name'        => 'Value DATE',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'class'       => 'ctp-date',
            'conditionals' => array(
              array(
                'key'        => 'type',
                'conditions' => array(
                  'DATE',
                  'DATETIME',
                )
              )
            )
          ),
          array(
            'type'        => 'number',
            'name'        => 'Value NUMERIC',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'class'       => 'ctp-number',
            'conditionals' => array(
              array(
                'key'        => 'type',
                'conditions' => array(
                  'NUMERIC'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Compare',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'options'     => array(
              '='         => 'equal to',
              '!='        => 'not equal',
              '>'         => 'greater than',
              '>='        => 'greater than or equal to',
              '<'         => 'less than',
              'LIKE'      => 'LIKE',
              'NOT LIKE'  => 'NOT LIKE',
              'IN'        => 'IN',
              'NOT IN'    => 'NOT IN',
              'BETWEEN'   => 'BETWEEN',
            ),
            'conditionals' => array(
              array(
                'key'        => 'meta',
                'conditions' => array(
                  'true'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Type',
            'id'          => 'type',
            'description' => 'Choose the type for meta value. CHAR (String), NUMERIC, DATE, DATETIME, DATETIME OF PAGELOAD',
            'options'     => array(
              'CHAR'               => 'CHAR',
              'NUMERIC'            => 'NUMERIC',
              'DATE'               => 'DATE',
              'DATETIME'           => 'DATETIME',
              'DATETIMEOFPAGELOAD' => 'DATETIME (OF PAGELOAD)',
              // 'DECIMAL'         => 'DECIMAL',
              // 'SIGNED'          => 'SIGNED',
              // 'TIME'            => 'TIME',
              // 'UNSIGNED'        => 'UNSIGNED'
            ),
            'conditionals' => array(
              array(
                'key'        => 'meta',
                'conditions' => array(
                  'true'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Relation',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'id' =>'relation',
            'options'     => array(
              'none' => 'N/A',
              'AND'   => 'AND',
              'OR'    => 'OR'
            ),
            'conditionals' => array(
              array(
                'key'        => 'meta',
                'conditions' => array(
                  'true'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Key 2',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'class'       => 'ajax',
            'conditionals' => array(
              array(
                'key'        => 'relation',
                'conditions' => array(
                  'AND',
                  'OR'
                )
              )
            )
          ),
          array(
            'type'        => 'text',
            'name'        => 'Value 2',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'conditionals' => array(
              array(
                'key'         => 'type_2',
                'type'        => 'not',
                'conditions'  => array(
                  'DATE',
                  'NUMERIC',
                  'DATETIME',
                  'DATETIMEOFPAGELOAD',
                )
              ),
              array(
                'key'        => 'relation',
                'conditions' => array(
                  'AND',
                  'OR'
                )
              ),
            )
          ),
          array(
            'type'        => 'date',
            'name'        => 'Value 2 DATE',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'class'       => 'ctp-date',
            'conditionals' => array(
              array(
                'key'        => 'type_2',
                'conditions' => array(
                  'DATE',
                  'DATETIME',
                )
              )
            )
          ),
          array(
            'type'        => 'number',
            'name'        => 'Value 2 NUMERIC',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'class'       => 'ctp-number',
            'conditionals' => array(
              array(
                'key'        => 'type_2',
                'conditions' => array(
                  'NUMERIC'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Compare 2',
            'description' => 'Use page id. Return just the child Pages ( e.g. 1 ). (Only works with hierarchical post types).',
            'options'     => array(
              '='         => 'equal to',
              '!='        => 'not equal',
              '>'         => 'greater than',
              '>='        => 'greater than or equal to',
              '<'         => 'less than',
              'LIKE'      => 'LIKE',
              'NOT LIKE'  => 'NOT LIKE',
              'IN'        => 'IN',
              'NOT IN'    => 'NOT IN',
              'BETWEEN'   => 'BETWEEN',
            ),
            'conditionals' => array(
              array(
                'key'        => 'relation',
                'conditions' => array(
                  'AND',
                  'OR'
                )
              )
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Type 2',
            'id'          => 'type_2',
            'description' => 'Choose the type for meta value. CHAR (String), NUMERIC, DATE, DATETIME, DATETIME OF PAGELOAD',
            'options'     => array(
              'CHAR'               => 'CHAR',
              'NUMERIC'            => 'NUMERIC',
              'DATE'               => 'DATE',
              'DATETIME'           => 'DATETIME',
              'DATETIMEOFPAGELOAD' => 'DATETIME (OF PAGELOAD)',
              // 'DECIMAL'         => 'DECIMAL',
              // 'SIGNED'          => 'SIGNED',
              // 'TIME'            => 'TIME',
              // 'UNSIGNED'        => 'UNSIGNED'
            ),
            'conditionals' => array(
              array(
                'key'        => 'relation',
                'conditions' => array(
                  'AND',
                  'OR'
                )
              )
            )
          ),
        ),
        'category' => array(
          array(
            'type'        => 'select',
            'name'        => 'Category',
            'description' => 'Use author id (available with Version 3.7).',
            'id'          => 'category',
            'options' => array(
              'false' => 'false',
              'has-all-categories' => 'has all categories',
              'has-one-of-categories' => 'has one of categories',
              'has-none-of-categories' => 'has none of categories'
            ),
          ),
          array(
            'type'        => 'select',
            'name'        => 'Category And',
            'description' => 'Use category id ( e.g. 2, 6 ).',
            'class'          => 'ctp-tag',
            'options'     => $this->get_available_categories(),
            'multiple' => true,
            'conditionals' => array(
              array(
                'key'        => 'category',
                'conditions' => array(
                  'has-all-categories'
                )
              )
            ),
          ),
          array(
            'type'        => 'select',
            'name'        => 'Category In',
            'description' => 'Use category id ( e.g 2, 6 ).',
            'class'          => 'ctp-tag',
            'options'     => $this->get_available_categories(),
            'multiple' => true,
            'conditionals' => array(
              array(
                'key'        => 'category',
                'conditions' => array(
                  'has-one-of-categories'
                )
              )
            ),
          ),
          array(
            'type'        => 'select',
            'name'        => 'Category Not In',
            'description' => 'Use category id ( e.g. 2, 6 ).',
            'class'          => 'ctp-tag',
            'options'     => $this->get_available_categories(),
            'multiple' => true,
            'conditionals' => array(
              array(
                'key'        => 'category',
                'conditions' => array(
                  'has-none-of-categories'
                )
              )
            ),
          ),
        ),
        'tag' => array(
          array(
            'type'        => 'select',
            'name'        => 'Tags',
            'description' => 'Use author id (available with Version 3.7).',
            'id'          => 'tag',
            'options' => array(
              'false' => 'false',
              'has-all-tags' => 'has all tags',
              'has-one-of-tags' => 'has one of tags',
              'has-none-of-tags' => 'has none of tags'
            ),
          ),
          array(
            'type'        => 'select',
            'name'        => 'Tag  And',
            'description' => 'Use tag ids ( e.g. 2, 6 ).',
            'class'          => 'ctp-tag',
            'conditionals' => array(
              array(
                'key'        => 'tag',
                'conditions' => array(
                  'has-all-tags'
                )
              )
            ),
            'options'     => $this->get_available_tags(),
            'multiple' => true
          ),
          array(
            'type'        => 'select',
            'name'        => 'Tag  In',
            'description' => 'Use tag ids ( e.g. 2, 6 ).',
            'class'          => 'ctp-tag',
            'conditionals' => array(
              array(
                'key'        => 'tag',
                'conditions' => array(
                  'has-one-of-tags'
                )
              )
            ),
            'options'     => $this->get_available_tags(),
            'multiple' => true
          ),
          array(
            'type'        => 'select',
            'name'        => 'Tag  Not In',
            'description' => 'Use tag ids ( e.g. 2, 6 ).',
            'class'          => 'ctp-tag',
            'conditionals' => array(
              array(
                'key'        => 'tag',
                'conditions' => array(
                  'has-none-of-tags'
                )
              )
            ),
            'options'     => $this->get_available_tags(),
            'multiple' => true
          ),
        ),
        'author' => array(
          array(
            'type'        => 'select',
            'name'        => 'Author',
            'description' => 'Use author id (available with Version 3.7).',
            'id'          => 'author',
            'options' => array(
              'false' => 'false',
              'authored-by' => 'Authored By',
              'not-authored-by' => 'Not Authored By'
            ),
          ),
          array(
            'type'        => 'select',
            'name'        => 'Author  In',
            'description' => 'Use author id (available with Version 3.7).',
            'class'          => 'ctp-tag',
            'conditionals' => array(
              array(
                'key'        => 'author',
                'conditions' => array(
                  'authored-by'
                )
              )
            ),
            'options' => $this->get_authors(),
            'multiple' => true
          ),
          array(
            'type'        => 'select',
            'name'        => 'Author Not  In',
            'description' => 'Use author id (available with Version 3.7).',
            'class'          => 'ctp-tag',
            'conditionals' => array(
              array(
                'key'        => 'author',
                'conditions' => array(
                  'not-authored-by'
                )
              )
            ),
            'options' => $this->get_authors(),
            'multiple' => true
          ),
        ),
        'page' => array(
          array(
            'type'        => 'text',
            'name'        => 'Name',
            'description' => 'Use post slug ( e.g. hello-world ).',
          ),
          array(
            'type'        => 'text',
            'name'        => 'Page Id',
            'description' => 'Use page id ( e.g. 1 ).',
          ),
          array(
            'type'        => 'text',
            'name'        => 'Pagename',
            'description' => 'Use page slug ( e.g sample-page ) Display child page using the parent and the child slug separated by slash ( e.g about/contctp_us ).',
          ),
        ),
        'password' => array(
          array(
            'type'        => 'select',
            'name'        => 'Has Password',
            'description' => 'Display based on password settings.',
            'options'     => array(
              0      => 'false',
              1      => 'true',
              'null' => 'null'
            ),
          ),
          array(
            'type'        => 'text',
            'name'        => 'Post Password',
            'description' => 'Show posts with a particular password ( e.g. supersecurepassword ) (available with Version 3.9).',
          ),
        ),
        'search' => array(
          array(
            'type'        => 'select',
            'name'        => 'Exact',
            'description' => 'Flag to make it only match whole titles/posts.',
            'options'     => array(
              0    => 'false',
              1    => 'true'
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Sentence',
            'description' => 'flag to make it do a phrase search.',
            'options'     => array(
              0    => 'false',
              1    => 'true'
            )
          ),
        ),
        'permission' => array(
          array(
            'type'        => 'select',
            'name'        => 'Perm',
            'description' => 'Display published posts, as well as private posts, if the user has the appropriate capability.',
            'options'     => array(
              'readable' => 'readable',
              'editable' => 'editable'
            )
          ),
        ),
        'sticky' => array(
          array(
            'type'        => 'text',
            'name'        => 'Ignore Sticky Posts',
            'description' => "Ignore sticky posts or not (available with Version 3.1, replaced caller_get_posts parameter). Default value is False - don't ignore sticky posts.",
            'options'     => array(
              0    => 'false',
              1    => 'true'
            )
          )
        ),
        'cache' => array(
          array(
            'type'        => 'select',
            'name'        => 'Cache Results',
            'description' => 'Post information cache.',
            'options'     => array(
              0    => 'false',
              1    => 'true'
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Update Post Term Cache',
            'description' => 'Post meta information cache.',
            'options'     => array(
              0    => 'false',
              1    => 'true'
            )
          ),
          array(
            'type'        => 'select',
            'name'        => 'Update Post Meta Cache',
            'description' => 'Post term information cache.',
            'options'     => array(
              0    => 'false',
              1    => 'true'
            )
          ),
        )
      );

      $view = new CTPView($this->use_defaults, $this->defaults, $current);
      $view->render($html[$meta_box]);
    }
  }
  /**
   * This save method is used to save the query post to the database
   * @return void
   */
  function save() {

    global $post;

    $screen = get_current_screen();

    if ($screen->id == 'ctp-query') {

      if (isset($_POST['publish']) || isset($_POST['save'])) {

        if (empty($_POST['ctp-settings'])) {

          $_POST['ctp-settings'] = array();

        } else {

          $_POST['ctp-args'] = $_POST['ctp-settings'];

          if ($_POST['ctp-args']['date'] != 'False') {

            $this->date_query();

          } else {

            unset($_POST['ctp-args']['date']);

          }

          if ($_POST['ctp-args']['meta_query'] != 'False') {

            $this->meta_query();

          } else {

            unset($_POST['ctp-args']['meta_query']);
          }

          if ($_POST['ctp-args']['tax_query'] != 'False') {

            $this->tax_query();

          } else {

            unset($_POST['ctp-args']['tax_query']);
          }
        }

        $this->remove_args();

        $settings = $_POST['ctp-settings'];
        $args     = $_POST['ctp-args'];

        if ($this->use_defaults) {

          $settings = array_merge($this->defaults, $_POST['ctp-settings']);
          $args     = array_merge($this->defaults, $_POST['ctp-args']);
        }

        update_post_meta($post->ID, 'ctp-settings', $settings);
        update_post_meta($post->ID, 'ctp-args', $args );

      }
    }
  }

  function remove_args() {

    unset($_POST['ctp-args']['author']);
    unset($_POST['ctp-args']['tags']);
    unset($_POST['ctp-args']['category']);
    unset($_POST['ctp-args']['post_id']);
    unset($_POST['ctp-args']['date']);
    unset($_POST['ctp-args']['specific_date']);
    unset($_POST['ctp-args']['after_date']);
    unset($_POST['ctp-args']['before_date']);
    unset($_POST['ctp-args']['past_date']);
    unset($_POST['ctp-args']['key']);
    unset($_POST['ctp-args']['value']);
    unset($_POST['ctp-args']['compare']);
    unset($_POST['ctp-args']['key_2']);
    unset($_POST['ctp-args']['value_2']);
    unset($_POST['ctp-args']['compare_2']);
    unset($_POST['ctp-args']['relation']);
    unset($_POST['ctp-args']['tax_relation']);
    unset($_POST['ctp-args']['operator']);
    unset($_POST['ctp-args']['operator_2']);
    unset($_POST['ctp-args']['include_children']);
    unset($_POST['ctp-args']['include_children_2']);
    unset($_POST['ctp-args']['term']);
    unset($_POST['ctp-args']['term_2']);
    unset($_POST['ctp-args']['taxonomy']);
    unset($_POST['ctp-args']['taxonomy_2']);
  }

  function date_query() {

    switch ($_POST['ctp-args']['date']) {

      case 'between-dates':

        $_POST['ctp-args']['date_query'] = array(
          'after'  => $_POST['ctp-settings']['after_date'],
          'before' => $_POST['ctp-settings']['before_date']
        );

        break;

      case 'after-date':

        $_POST['ctp-args']['date_query'] = array(
          'after' => $_POST['ctp-settings']['after_date']
        );

        break;

      case 'before-date':

        $_POST['ctp-args']['date_query'] = array(
          'before' => $_POST['ctp-settings']['before_date']
        );

        break;

      case 'specific-date':

        $_POST['ctp-args']['date_query'] = array(
          array(
            'year'  => date('Y', strtotime($_POST['ctp-settings']['specific_date'])),
            'month' => date('m', strtotime($_POST['ctp-settings']['specific_date'])),
            'day'   => date('d', strtotime($_POST['ctp-settings']['specific_date'])),
          )
        );

        break;

      case 'before-page-load':

        $_POST['ctp-args']['date_query'] = array(
          'before' => 'now'
        );

        break;

      case 'between-past-date-and-page-load':

        $_POST['ctp-args']['date_query'] = array(
          'after'  => $_POST['ctp-settings']['past_date'],
          'before' => 'now'
        );

        break;
    }

  }

  function meta_query() {

    switch ($_POST['ctp-args']['type']) {

      case 'DATE':

        $value = date('Y-m-d', strtotime($_POST['ctp-args']['value_date']));

        break;

      case 'TIME':

        $value = date('H:i:s', strtotime($_POST['ctp-args']['value_date']));

        break;

      case 'DATETIME':

        $value = date('Y-m-d H:i:s', strtotime($_POST['ctp-args']['value_date']));

        break;

      case 'NUMERIC':


        $value = (int) $_POST['ctp-args']['value_numeric'];

        break;

      case 'DATETIMEOFPAGELOAD':

        $value = 'DATETIMEOFPAGELOAD';

        break;

      default:

          $value = strtotime($_POST['ctp-args']['value']);

        break;
    }

    switch ($_POST['ctp-args']['relation']) {


      case 'none':

        if ($_POST['ctp-args']['type'] == 'DATE') {

          $value = date('Y-m-d', strtotime($_POST['ctp-args']['value']));
        }
        else {

          $value = $_POST['ctp-args']['value'];
        }

        $_POST['ctp-args']['meta_query'] = array(
          array(
            'key'     => $_POST['ctp-args']['key'],
            'value'   => $value,
            'compare' => $_POST['ctp-args']['compare'],
            'type'    => $_POST['ctp-args']['type'],
          )
        );

        break;

      default:

        // if ($_POST['ctp-args']['type'] == 'DATE') {

        //   $value   = date('Y-m-d', strtotime($_POST['ctp-args']['value']));
        //   $value_2 = date('Y-m-d', strtotime($_POST['ctp-args']['value_2']));
        // }
        // else {

        //   $value = $_POST['ctp-args']['value'];
        //   $value_2 = $_POST['ctp-args']['value_2'];
        // }

        $_POST['ctp-args']['meta_query'] = array(
          'relation' => $_POST['ctp-args']['relation'],
          array(
            'key'     => $_POST['ctp-args']['key'],
            'value'   => $value,
            'compare' => $_POST['ctp-args']['compare'],
            'type'    => $_POST['ctp-args']['type'],
          ),
          array(
            'key'     => $_POST['ctp-args']['key_2'],
            'value'   => $value_2,
            'compare' => $_POST['ctp-args']['compare_2'],
            'type'    => $_POST['ctp-args']['type_2'],
          )
        );

        break;
    }
  }


  function tax_query() {

    switch ($_POST['ctp-args']['tax_relation']) {

      case 'none':
        $_POST['ctp-args']['tax_query'] = array(
          'post_type' => $_POST['post_type'],
          array(
            'taxonomy' => $_POST['ctp-args']['taxonomy'],
            'field'    => 'slug',
            'terms'   => $_POST['ctp-args']['term'],
          )
        );

        break;

      default:

        $_POST['ctp-args']['tax_query'] = array(
          'relation' => $_POST['ctp-args']['relation'],
          array(
            'taxonomy' => $_POST['ctp-args']['taxonomy'],
            'field'    => 'slug',
            'terms'   => $_POST['ctp-args']['term'],
            'include_children' => $_POST['ctp-args']['include_children'],
            'operator'         => $_POST['ctp-args']['operator'],
          ),
          array(
            'taxonomy'         => $_POST['ctp-args']['taxonomy_2'],
            'field'            => 'slug',
            'terms'            => $_POST['ctp-args']['term_2'],
            'include_children' => $_POST['ctp-args']['include_children_2'],
            'operator'         => $_POST['ctp-args']['operator_2'],
          )
        );

        break;
    }
  }

  function query_columns( $defaults ) {

    $position  = 2;
    $after_pos = array_slice($defaults, $position, count($defaults)-$position, true);
    $defaults  = array_slice($defaults, 0, $position, true);
    $defaults += array("name" => "Name");
    $defaults += $after_pos;

    return $defaults;

  }

  function query_columns_content($column_name, $post_id) {


    $screen = get_current_screen();

    $post = get_post($post_id);

    if ($screen->id == 'edit-ctp-query') {

      switch ( $column_name ) {

        case 'name':

          echo $post->post_name;

          break;

      }
    }
  }

  function get_available_types() {

    return get_post_types('', 'names');

  }

  function get_available_taxonomies($post_type) {

    return get_taxonomies(array('object_type' => array($post_type)), 'names');

  }

  function get_available_terms_of_taxomony($taxonomy) {

    return get_terms($taxonomy, array('fields' => 'id=>slug'));

  }

  function get_available_categories() {

    $taxonomies        = array('category');
    $cat_names         = array();
    $cat_ids           = array();

    foreach (get_terms($taxonomies) as $catgory) {

      $cat_select_ids[$catgory->term_id] = 'ID: ' . $catgory->term_id . ' - ' . $catgory->name;
    }

    return $cat_select_ids;

  }

  function get_available_tags() {
    $tags              = get_tags();
    $tag_select_ids    = array();

    foreach ($tags as $tag) {

      $tag_select_ids[$tag->term_id] = 'ID: ' . $tag->term_id . ' - ' . $tag->name;
    }

    return $tag_select_ids;

  }

  function get_authors() {

    $authors           = get_users();
    $author_names      = array();
    $auth_select_ids   = array();

    foreach ($authors as $author) {

      $first_name = get_the_author_meta( 'first_name', $author->data->ID );
      $last_name  = get_the_author_meta( 'last_name', $author->data->ID );
      $name       = '';

      if (!empty($first_name)) {

        $name .= ucfirst($first_name);

      }

      if (!empty($last_name)) {

        $name .= ' ';
        $name .= ucfirst($last_name);

      }

      if (empty($first_name) || $name == '') {

        $name = $author->data->user_nicename;

      }

      $author_names[$author->data->user_nicename] = $name;
      $auth_tag_ids[$author->data->ID] = "ID: {$author->data->ID} -  $name";

    }

    return $auth_tag_ids;
  }

  function ctp_query_js_footer() {
    ?>
    <script type="text/javascript" >
      jQuery(document).ready(function($) {

        var orderby            = ['meta_value', 'meta_value_num'];
        var relations          = ['AND', 'OR'];
        var postTypeField      = $('select[name="ctp-settings[post_type]"]');
        var orderbyField       = $('select[name="ctp-settings[orderby]"]');
        var metaQueryField     = $('select[name="ctp-settings[meta_query]"]');
        var taxQueryField      = $('select[name="ctp-settings[tax_query]"]');
        var relationField      = $('select[name="ctp-settings[relation]"]#relation')
        var taxRelationField   = $('select[name="ctp-settings[relation]"]#tax_relation');
        var taxField   = $('select[name="ctp-settings[taxonomy]"]');
        var tax2Field   = $('select[name="ctp-settings[taxonomy_2]"]');


        var selects = 'select[name="ctp-settings[post_type]"], \
          select[name="ctp-settings[orderby]"], \
          select[name="ctp-settings[meta_query]"], \
          select[name="ctp-settings[tax_query]"], \
          select[name="ctp-settings[taxonomy]"], \
          select[name="ctp-settings[relation]"]#relation, \
          select[name="ctp-settings[relation]"]#tax_relation';

        var watch = $(selects);

        checkValues();

        watch.each(function() {

          $(this).change(function() {

            checkValues(this);

          });

        });

        function checkValues($el) {

          if (postTypeField.val() != '' && ( orderbyField.val() == 'meta_value' || orderbyField.val() == 'meta_value_num') ) {

            metaKeys('meta_key');
          }

          if (postTypeField.val() != '' && metaQueryField.val() == 'true') {

            metaKeys('key');
          }

          if(postTypeField.val() != '' && relations.indexOf(relationField.val()) > -1) {

            metaKeys('key_2');
          }

          if(postTypeField.val() != '' && taxQueryField.val() == 'true' && $($el).attr('name') != 'ctp-settings[taxonomy]') {

            taxonomy('taxonomy');

          }

          if(postTypeField.val() != '' && relations.indexOf(taxRelationField.val()) > -1 && $($el).attr('name') != 'ctp-settings[taxonomy]') {

            taxonomy('taxonomy_2');

          }

          if ($($el).attr('name') == 'ctp-settings[taxonomy]') {

            var tax = $('select[name="ctp-settings[taxonomy]"]').val();

            terms('term', tax);
          }

          if ($($el).attr('name') == 'ctp-settings[taxonomy_2]') {

            var tax = $('select[name="ctp-settings[taxonomy_2]"]').val();

            terms('term', tax);
          }
        }

        function metaKeys(name) {

          var post_type = postTypeField.val();
          var post_id   = $('[name="ctp-settings[' + name + ']"]').attr('data-post_id');

          var data = {
            'action': 'retrieve_meta_keys',
            'post_type': post_type,
            'post_id': post_id,
            'field': name,
          };

          getResults(data, name);

        };

        function taxonomy(name) {
          var post_type = postTypeField.val();
          var post_id   = $('[name="ctp-settings[' + name + ']"]').attr('data-post_id');

          var data = {
            'action': 'retrieve_taxonomy_terms',
            'post_type': post_type,
            'post_id': post_id,
            'field': name,
          };

          getResults(data, name);

        };

        function terms(name, taxonomy) {
          var post_type = postTypeField.val();
          var post_id   = $('[name="ctp-settings[' + name + ']"]').attr('data-post_id');

          var data = {
            'action':    'retrieve_taxonomy_terms',
            'post_type': post_type,
            'post_id':   post_id,
            'field':     name,
            'taxonomy':  taxonomy
          };

          getResults(data, name);

        };

        function getResults(data, name) {

          // since 2.8 ajaxurl is always defined in the
          // admin header and points to admin-ajax.php
          // if (data.length > 0) {

          $.post(ajaxurl, data, function(response) {

            var responseObj = JSON.parse(response);

            var keys = responseObj['keys'].split(',')

            $('.ctp-input select[name="ctp-settings[' + name + ']"]')
              .empty();



            for (var i = 0; i < keys.length; i++) {

              var option = '<option value"' + keys[i] + '">' + keys[i] + '</option>';

              if (responseObj['selected'] == keys[i]) {

                var option = '<option selected="selected value"' + keys[i] + '">' + keys[i] + '</option>';

              }

              $('.ctp-input select[name="ctp-settings[' + name + ']"]')
                .append(option);
            }

            if (name == 'term' || name == 'term_2') {

              $('.ctp-input select[name="ctp-settings[' + name + ']"]')
                .prepend('<option>query_var</option>');

            }

            $('.ctp-input [name="ctp-settings[' + name + ']"]').select2({
              width: 'resolve',
              tags:  true,
            });

            if (name == 'taxonomy') {

              terms('term', $('.ctp-input [name="ctp-settings[' + name + ']"]').val());
            }

            if (name == 'taxonomy_2') {

              terms('term_2', $('.ctp-input [name="ctp-settings[' + name + ']"]').val());
            }
          });
        }
      });
      </script>
    <?php
  }

  function retrieve_meta_keys_callback() {

    global $wpdb;

    $post_type = $_POST['post_type'];
    $post_id   = $_POST['post_id'];
    $field     = $_POST['field'];

    $query = "
      SELECT DISTINCT($wpdb->postmeta.meta_key)
      FROM $wpdb->posts
      LEFT JOIN $wpdb->postmeta
      ON $wpdb->posts.ID = $wpdb->postmeta.post_id
      WHERE $wpdb->posts.post_type = '%s'
      AND $wpdb->postmeta.meta_key != ''
      AND $wpdb->postmeta.meta_key NOT RegExp '(^[_0-9].+$)'
      AND $wpdb->postmeta.meta_key NOT RegExp '(^[0-9]+$)'
    ";

    $meta_keys = $wpdb->get_col($wpdb->prepare($query, $post_type));

    if (!empty($post_id)) {

      $settings = get_post_meta($post_id, 'ctp-settings', true);

      $selected = !empty($settings[$field]) ? $settings[$field] : '';

    }

    $results = array(
      'selected' => !empty($selected) ? $selected : false,
      'keys'     => implode(',', $meta_keys)
    );

    echo json_encode($results);

    wp_die(); // required to terminate immediately and return a proper response
  }

  function retrieve_taxonomy_terms_callback() {

    global $wpdb;

    $post_type = $_POST['post_type'];
    $post_id   = $_POST['post_id'];
    $field     = $_POST['field'];
    $taxonomy  = $_POST['taxonomy'];


    if ($field == 'taxonomy' || $field == 'taxonomy_2') {

      $options = $this->get_available_taxonomies($post_type);

    }
    elseif ($field == 'term' || $field == 'term_2') {

        $options = $this->get_available_terms_of_taxomony($taxonomy);

    }

    if (!empty($post_id)) {

      $settings = get_post_meta($post_id, 'ctp-settings', true);

      $selected = !empty($settings[$field]) ? $settings[$field] : '';

    }

    $optionsFormated = is_array($options) ? implode(',', $options) : '';

    $results = array(
      'selected' => !empty($selected) ? $selected : false,
      'keys'     => $optionsFormated,
    );

    echo json_encode($results);

    wp_die(); // required to terminate immediately and return a proper response
  }
}