<?php

/**
 * ctp_get_setting This function will return a value from the settings array found in the ctp object (Credits to ACF)
 * @param  string $name    setting
 * @param  string $default setting checker
 * @return setting         setting value
 */
function ctp_get_setting( $name, $default = null ) {

  // vars
  $settings = ctp()->settings;


  // find setting
  $setting = ctp_maybe_get( $settings, $name, $default );

  // return
  return $setting;

}

/**
 * ctp_maybe_get This function returns a setting if it exist (Credits to ACF)
 * @param  array $array    takes array of settings
 * @param  string $key     setting to look for
 * @param  array $default  settings checker
 * @return array           setting if exist
 */
function ctp_maybe_get( $array, $key, $default = null ) {

  // vars
  $keys = explode('/', $key);

  // loop through keys
  foreach( $keys as $k ) {

    // return default if does not exist
    if( !isset($array[ $k ]) ) {

      return $default;

    }

    // update $array
    $array = $array[ $k ];

  }

  // return
  return $array;

}

/**
 * ctp_include includes file if it exists (Credits to ACF)
 * @param  string $file string of file
 * @return null       includes the file
 */
function ctp_include( $file ) {

  $path = ctp_get_path( $file );

  if( file_exists($path) ) {

    include_once( $path );

  }

}


/**
 * ctp_get_path get the path of an asset with in CTP
 * @param  string $path path from plugin root
 * @return string       full path to plugin asset
 */
function ctp_get_path( $path ) {

  return ctp_get_setting('path') . $path;

}


/**
 * get_query This function returns a WP_Query object by passing the CTP query slug
 * @param  string  $slug        CTP Query slug
 * @param  string  $meta_value  Meta value to query for
 * @param  string  $meta_value2 Second value to query for in a relation meta query
 * @return object               WP_Query object
 */
function get_query( $slug, $meta_value = false, $meta_value2 = false ) {

  global $wpdb;

  $boolify = array(
    'tag',
    'tag_id',
    'has_password',
    'nopaging',
    'cache_results',
    'update_post_term_cache',
    'update_post_meta_cache',
    'exact',
    'sentence',
    'no_found_rows',
  );

  $query = "
    SELECT     $wpdb->postmeta.meta_value
    FROM       $wpdb->postmeta
    INNER JOIN $wpdb->posts
    ON         $wpdb->posts.id = $wpdb->postmeta.post_id
    WHERE      $wpdb->posts.post_type = '%s'
    AND        $wpdb->posts.post_name = '%s'
    AND        $wpdb->posts.post_status = '%s'
    AND        $wpdb->postmeta.meta_key = '%s'
  ";

  $result = $wpdb->get_row($wpdb->prepare($query, 'ctp-query', $slug, 'publish', 'ctp-args'
    ));

  $custom_args = maybe_unserialize($result->meta_value);

  if (!empty($custom_args)) {

    foreach ($custom_args as $arg => $value) {

      if ($arg == 'meta_query') {

        if (!empty($meta_value)) {

          $custom_args[$arg][0]['value'] = $meta_value;
        }

        if (!empty($meta_value2) && !empty( $custom_args[$arg][1])) {

          $custom_args[$arg][1]['value'] = $meta_value2;
        }


        if (!empty($value[0]['type'])) {

          if ($value[0]['type'] == 'DATETIMEOFPAGELOAD') {

            $custom_args[$arg][0]['value'] = date('Y-m-d H:i:s', strtotime('now'));
            $custom_args[$arg][0]['type']  = 'DATETIME';
          }
        }

        if (!empty($value[0]['type_2'])) {

          if ($value[0]['type_2'] == 'DATETIMEOFPAGELOAD') {

            $custom_args[$arg][0]['value_2'] = date('Y-m-d H:i:s', strtotime('now'));
            $custom_args[$arg][0]['type_2']  = 'DATETIME';
          }
        }
      }

      if (in_array($arg, $boolify)) {

        $custom_args[$arg] = $value == '1' ? true : false;

      }

      if ($arg == 'tax_query') {

        if ($custom_args[$arg][0]['terms'] == 'query_var') {

          global $term;

          $custom_args[$arg][0]['terms'] = $term;

        }
      }
    }

    $custom_query = new WP_Query( $custom_args );

    wp_reset_postdata();

    return $custom_query;

  }

  return false;

}

