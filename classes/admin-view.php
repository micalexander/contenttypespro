<?php

/**
*
*/
class CTPView {

  public $name;
  public $label;
  public $placeholder   = false;
  public $description   = false;
  public $options       = false;
  public $multiple      = false;
  public $links         = false;
  public $use_defaults  = false;
  public $similar_types = array(
    'text',
    'number',
    'email',
    'phone',
    'date'
  );
  public $valuables = array(
    'text',
    'number',
    'email',
    'phone',
    'date',
    'textarea'
  );
  public $defaults;
  public $current;
  public $post_id;

  public $wp_opts = array(
    'type',
    'tax',
    'query'
  );

  function __construct($use_defaults, $defaults, $current) {

    $this->use_defaults = $use_defaults;
    $this->defaults     = $defaults;
    $this->current      = $current;

  }

  function render( $html ) {

    $elements = '';

    foreach ($html as $element) {

      $this->slug = str_replace(' ', '_', strtolower($element['name']));

      if (!empty($element['alt_name'])) {

        $this->slug = str_replace(' ', '_', strtolower($element['alt_name']));

      }

      if ($element['type'] == 'select') {

        if ($this->defaults[$this->slug] == false) {

          $this->defaults[$this->slug] == '0';

        }
        elseif ($this->defaults[$this->slug] == true) {

          $this->defaults[$this->slug] == '1';

        }
      }

      if ($this->use_defaults) {

        $this->placeholder = $this->defaults[$this->slug];

      }
      else {

        $this->placeholder = $this->current[$this->slug];

      }

      $element = $this->conditional($element);

      switch ($element['type']) {

        case 'date':

          $type = 'text';

          break;


        case 'select':

          $type = null;

          break;

        default:

          $type = $element['type'];

          break;
      }

      $name  = 'ctp-settings[' . $this->slug . ']';
      $name .= $element['multiple'] == true ? '[]' : '' ;
      $value = in_array($element['type'], $this->valuables) ? $this->placeholder : '';

      if (is_array($value)) {

        $value = implode(',', $value);

      }

      $attributes = $this->attributes(
        array(
          'prefix'       => $element['prefix'],
          'suffix'       => $element['suffix'],
          'prefix_space' => $element['prefix_space'],
          'suffix_space' => $element['suffix_space'],
          'id'           => $element['id'],
          'class'        => $element['class'],
          'data'         => $element['data'],
          'multiple'     => $element['multiple'],
          'value'        => $value,
          'type'         => $type,
          'name'         => $name,
        )
      );

      if (in_array($element['type'], $this->similar_types)) {

        $element_type = '<input %s />';

      }
      elseif ($element['type'] == 'textarea') {

        $element_type = '<textarea %s ></textarea>';
        $attributes   = str_replace('type="textarea"', '', $attributes);

        if (!empty($value)) {

          preg_match("/value=\"([^\"]+)\"/", $attributes, $matches);

          $attributes   = str_replace($matches[0], '', $attributes);
          $element_type = '<textarea %s >' . $matches[1] . '</textarea>';

        }

      } else {

        $element_type = $this->$element['type']( $element );

      }

      $parent_class = is_array($element['conditionals']) ? 'hidden ' : '';

      $elements .= '<div class="ctp-field ' . $parent_class . '">';
      $elements .= '<div class="ctp-label">';
      $elements .= '<label>' . $element['name'] . '</label>';
      $elements .= '<p>' . $element['description'] . '</p>';
      $elements .= '</div>';
      $elements .= '<div class="ctp-input">';
      $elements .= vsprintf($element_type, array($attributes ) );
      $elements .= '</div>';
      $elements .= '</div>';
    }

    echo $elements;

  }

  function select( $element ) {

    $keep_case = array(
      'Post Type',
      'Post Types',
    );

    $field_type  = '<select %s >';

    if ($element['options'] != false) {

      foreach ($element['options'] as $value => $option) {

        $selected = in_array( $value, (array) $this->placeholder) ? 'selected' : null;

        $attributes = $this->attributes(
          array(
            'selected' => $selected,
            'value'    => $value
          )
        );

        $option = in_array($element['name'], $keep_case) ? $option : ucfirst($option);

        $field_type .= '<option ' . $attributes . '>' . $option . '</option>';
      }
    }

    $field_type .= '</select>';

    return $field_type;

  }

  function checkbox( $element ) {

    $checkboxes = '';

    if ($this->use_defaults) {

      $placeholders = array();

      foreach ($this->defaults[$this->slug] as $key => $value) {

        if ($value) {

          $placeholders[] = $key;

        }
      }
    }
    else {

      $placeholders = $this->placeholder;
    }

    foreach ($this->defaults[$this->slug] as $box => $value) {

      $attributes = array();

      $checked = in_array($box, (array) $placeholders) ? 'checked' : null;

      $attributes = $this->attributes(
        array(
          'class'        => $element['class'],
          'data'         => $element['data'],
          'multiple'     => $element['multiple'],
          'value'        => $box,
          'type'         => $element['type'],
          'name'         => 'ctp-settings[' . $this->slug . '][]',
          'checked'      => $checked,
        )
      );

      $checkboxes .= '<div class="ctp-box">';
      $checkboxes .= '<input ' . $attributes . '/>';
      $checkboxes .= '<label>' . ucfirst( str_replace('_', ' ', $box) ) . '</label>';
      $checkboxes .= "</div>";

    }

    return $checkboxes;
  }

  function html($html) {

    $formated_html = '';

    foreach ($html['html'] as $type => $element) {

      switch ($type) {

        case 'prefix':

          $prefix = $type == 'prefix' ? $element : '';

          break;

        case 'elements':

          foreach ($element as $el) {

            $formated_html .= $el;

          }

          break;

        case 'suffix':

            $suffix = $type == 'suffix' ? $element : '';

          break;
      }

    }
      return $prefix . $formated_html . $suffix;
  }

  function conditional($element) {

    if (is_array($element['conditionals'])) {

      if (!empty($element['class'])) {

        $element['class'] .= ' conditional';
      }
      else {

        $element['class'] = 'conditional';

      }

      foreach ($element['conditionals'] as $index => $conditional) {

        if (!array_key_exists('type', $conditional)) {

          $element['conditionals'][$index]['type'] = 'is';
        }
      }

      $element['data']['conditions'] = htmlspecialchars(json_encode($element['conditionals']), ENT_QUOTES, 'UTF-8');


      $element['disabled'] = true;
    }

    return $element;

  }

  function attributes($attributes) {

    $formated_attributes = '';

    foreach ($attributes as $attribute => $attr) {


      if (!empty($attributes[$attribute]) && $attributes[$attribute] != '0') {


        switch ($attribute) {


          case 'prefix':

            $formated_attributes .= 'data-prefix="' . $attr . '" ';

            break;

          case 'suffix':

            $formated_attributes .= 'data-suffix="' . $attr . '" ';


            break;

          case 'prefix_space':

            $formated_attributes .= 'data-prefix-space="no" ';


            break;

          case 'suffix_space':

            $formated_attributes .= 'data-suffix-space="no" ';


          case 'type':

            $formated_attributes .= 'type="' . $attr . '" ';


            break;

          case 'id':

            $formated_attributes .= 'id="' . $attr . '" ';

            break;

          case 'class':

            $formated_attributes .= 'class="' . $attr . '" ';

            break;

          case 'data':

            $add_data = '';

            foreach ($attr as $key => $value) {

              $add_data .= 'data-'  . $key . '="' . $value . '" ';
            }

            $formated_attributes .= $add_data;


            break;

          case 'multiple':

            $formated_attributes .= 'multiple ';

            break;


          case 'disabled':

            $formated_attributes .= 'disabled ';

            break;

          case 'name':

            $formated_attributes .= 'name="' . $attr . '" ';

            break;

          case 'placeholder':

            $formated_attributes .= 'placeholder="' . $attr . '" ';

            break;

          case 'value':

            $formated_attributes .= 'value="' . $attr . '" ';

            break;

          case 'checked':

            $formated_attributes .= 'checked="' . $attr . '" ';

            break;

          case 'selected':

            $formated_attributes .= 'selected="' . $attr . '" ';

            break;
        }
      }
    }

    return $formated_attributes;

  }
}