(function($){
  $(document).ready(function() {

    var CTPTypePage     = '.wp-admin.post-type-ctp-type';
    var CTPTaxonomyPage = '.wp-admin.post-type-ctp-taxonomy';
    var CTPQueryPage    = '.wp-admin.post-type-ctp-query';
    var allPages        = CTPTypePage + ',' + CTPTaxonomyPage + ',' + CTPQueryPage;

    if ($(allPages).length > 0) {

      // Ensure that the title is present before saving.
      $(document).on('keydown', enterPressed);
      $('input[name="save"], input[name="publish"]').on('click', ensureTitle);
      $('input[name="post_title"]').on('blur', addValues);

      function enterPressed(event) {

        if (event.which == 13) {

          addValues();

        }

      };

      function ensureTitle(event) {

        if ($('input[name="post_title"]').val() == '' ) {

          if ($('.ctp-error').length < 1 ) {

            var message = '<div id="message" class="error ctp-error is-dismissible below-h2" style="display: none;"> \
              <p>You must add a title.</p> \
              </div>';

            $(message)
            .insertBefore('form[name="post"')
            .velocity('transition.fadeIn', 500);

          }
          else {

            $('.ctp-error')
              .velocity('callout.flash');

          }

          event.preventDefault();
        }

      };


      function addValue(name, value, format) {

        var field = 'input[name="ctp-settings[' + name + ']';
        var formated;

        if ($(field).val() == '') {

          switch(format) {

              case 'slug':

                  formated = value.toLowerCase().replace(/\s/g, '-');

                  break;

              case 'lower':

                  formated = value.toLowerCase();

                  break;

              case 'plural':

                  formated = pluralize(value).capitalize();

                  break;

              case 'capital':

                  formated = value.capitalize();

                  break;
          }

          var prefix = '';
          var suffix = '';

          if ($(field).is("[data-prefix]")) {

            prefix = $(field).attr('data-prefix') + ' ';

            if ($(field).is("[data-prefix-space]")) {

              if ($(field).attr('data-prefix-space') == 'no') {

                prefix = $(field).attr('data-prefix');

              }

            }


          }

          if ($(field).is("[data-suffix]")) {

            suffix = ' ' + $(field).attr('data-suffix');

            if ($(field).is("[data-suffix-space]")) {

              if ($(field).attr('data-suffix-space') == 'no') {

                suffix = $(field).attr('data-suffix');
              }

            }

          }

          $(field).val(prefix + formated + suffix);

        }
      }



      function addValues() {

        var ctp_name = $('input[name="post_title"]').val();

        if (ctp_name !== '') {
          addValue('name',                       ctp_name, 'capital');
          addValue('singular_name',              ctp_name, 'capital');
          addValue('menu_name',                  ctp_name, 'plural');
          addValue('name_admin_bar',             ctp_name, 'capital');
          addValue('all_items',                  ctp_name, 'plural');
          addValue('add_new',                    ctp_name, 'capital');
          addValue('add_new_item',               ctp_name, 'capital');
          addValue('edit',                       ctp_name, 'capital');
          addValue('edit_item',                  ctp_name, 'capital');
          addValue('new_item',                   ctp_name, 'capital');
          addValue('view',                       ctp_name, 'capital');
          addValue('view_item',                  ctp_name, 'capital');
          addValue('search_items',               ctp_name, 'plural');
          addValue('not_found',                  ctp_name, 'plural');
          addValue('not_found_in_trash',         ctp_name, 'plural');
          addValue('parent_item_colon',          ctp_name, 'capital');
          addValue('rewrite_slug',               ctp_name, 'slug');
          addValue('new_item_name',              ctp_name, 'capital');
          addValue('update_item',                ctp_name, 'capital');
          addValue('popular_items',              ctp_name, 'plural');
          addValue('parent_item',                ctp_name, 'capital');
          addValue('separate_items_with_commas', ctp_name, 'plural');
          addValue('add_or_remove_items',        ctp_name, 'plural');
          addValue('choose_from_most_used',      ctp_name, 'plural');

        }

      };

      function dashicons(icon) {

        if (!icon.id || $(icon.element).attr('value').substring(0,9) != 'dashicons' ) {

          return icon.text;

        }

        return $('<div class="ctp-menu-icon dashicons-before ' + $(icon.element).attr('value') + '"> ' + icon.text + '</div>');
      };

      $('.ctp-input select:not(.ajax)')
        .select2({
          width: 'resolve',
          templateResult: dashicons,
          templateSelection: dashicons
        });

      // $('.ctp-input select:not(.ajax)')
      //   .select2({
      //     width: 'resolve',
      //   });


      $('.ctp-input .ctp-tag')
        .select2({
          width: 'resolve',
          tags: true,
          tokenSeparators: [',', ' ']
        });

      // $('.ctp-input input.ctp-tag')
      //   .select2({
      //     width: 'resolve',
      //     tags: true,
      //     tokenSeparators: [',', ' ']
      //   });

      $('.ctp-field.hidden').hide();
      $('.ctp-field.hidden').find('.conditional').each(function() {

        var input        = this,
            conditionals = JSON.parse($(this).attr('data-conditions'));

        $(conditionals).each(function() {

          var key        = this.key,
              type       = this.type,
              conditions = this.conditions;

          // check to see if the value of the select is in the array of conditions
          // or if it is not in the array of conditions and type is set to "not"
          // if both of these conditions are met then show the input if not hide it
          if (
                conditions.indexOf($('#' + key).val()) > -1 && type == 'is' ||
                conditions.indexOf($('#' + key).val()) == -1 && type == 'not'
             ) {

            $(input)
              .prop('disabled', false)
              .addClass('selected')
              .closest('.ctp-field.hidden')
              .show();
          }
          else {

            $(input)
              .prop('disabled', true)
              .closest('.ctp-field')
              .removeClass('selected')
              .stop()
              .hide();
          }
        });

      });

      $('[data-conditions]').each(function() {

        var conditionals = JSON.parse($(this).attr('data-conditions'));
        var input        = $(this);

        $(conditionals).each(function() {

          var key        = this.key,
              type       = this.type,
              conditions = this.conditions;


          $('#' + key).change(function() {

            // check to see if the value of the select is in the array of conditions
            // or if it is not in the array of conditions and type is set to "not"
            // if both of these conditions are met then show the input if not hide it
            if (
                  conditions.indexOf($(this).val()) > -1 && type == 'is' ||
                  conditions.indexOf($(this).val()) == -1 && type == 'not'
               ) {

              $(input)
                .prop('disabled', false)
                .closest('.ctp-field')
                .addClass('selected')
                .stop()
                .velocity('transition.expandIn', {
                  display: 'table-row',
                  duration: 200
                });
            }
            else {

              $(input)
                .prop('disabled', true)
                .closest('.ctp-field')
                .removeClass('selected')
                .stop()
                .hide();
            }
          });
        });

      });
    }

    String.prototype.capitalize = function() {

      return this.charAt(0).toUpperCase() + this.slice(1);

    }


    $('.ctp-date').pikaday({
      format: 'MMMM Do, YYYY'
    });


    // create scroll link
    $("#ctp-query-options a").click(function() {
      var link = $($(this).attr('href'));
      var divToScroll  = $(link['selector']);

      divToScroll
        .velocity("scroll", {offset: '-50px', duration: 800});

      return false
    });
  });
}(jQuery));