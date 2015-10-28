# Content Types Pro

Easily create Custom Post Types from with-in the admin area of Wordpress.

Why, when there are already plugins that make custom post types?

Good question. I wanted something that was simple to use, had a clean interface, and stuck with Wordpress conventions. Most of the other plugins that create custom post types not only create post types, but also provide the ability to create fields, layouts, and so much more.

I feel like [Advanced Custom Fields](http://www.advancedcustomfields.com/) already does an amazing job making custom fields and I have yet to see a GUI layout builder that I think fits my needs.

If only there was a plugin that made custom post types as simple as ACF makes custom fields....hmmmm... Thus **Content Types Pro** was born.

That being said it is not perfect, but you can help me make it that way.


## Installation

Place the plugin inside the `wp-content/plugins/` directory. Log into the admin area, click on the "Plugins" menu item in the side nav and enable the "Content Types Pro" plugin.

## Usage

After installing the plugin you will see a menu item in the side nav named "Content Types". Clinking this link will reveal four sections, "Types", "Taxonomies", "Queries", and "Bonus Settings".

#### Types

The Types section is where you will create your custom post types. To do this simply input the name of your desired Custom Post Type as the Title, change as many of the default setting that you wish, hit "Publish", and you are good to go.

#### Taxonomies

The Taxonomy section is where you will create taxonomies. This section works very similar to the way that the Types section works. Simply input the name of the taxonomy as the Title make any changes that you may wish to make, publish it, and thats it.

#### Queries

The Queries section is where you will create custom queries in the same way as you would in the Types and Taxonomy sections. The big difference here is you will also choose the content type or taxonomy you wish to associate the query with.

The Queries section comes accompanied by a nifty little function called `get_query()`. This allows you to query your predefined query by passing a few parameters. This will return a WP_Query object using the `$args` that where specified while building the query from within the Queries section.

```php
object get_query(string $slug, string $meta_value, string $meta_value2)
```

**$slug**: *Required* - Slug name of the Content Types Pro query

**$meta_value**: *Optional* -  Override the value to query for. Default is false.

**$meta_value2**: *Optional* - Override the second value to query for in a relation meta query. Default is false.

##### Template Examples

Simple Query

```php
<?php $shoes = get_query('shoes'); ?>

<?php if ( $shoes->have_posts() ) : while ( $shoes->have_posts() ) : the_post(); ?>
<!-- post -->

<?php endwhile; ?>
<!-- post navigation -->

<?php else: ?>
<!-- no posts found -->

<?php endif; ?>
```

The `meta_value` and `meta_value2` parameters come in handy when you need to override the Meta Query values selected when building your Query. For example, you may want use this to filter the results based on a custom field passed in using an [ep_mask](https://make.wordpress.org/plugins/2012/06/07/rewrite-endpoints-api/).

In the example below, lets say that when building your query in Content Types Pro you set the Meta Query setting to "true", the "Key" to size, the "Relation" to "AND", and the "Key2" to color. This would override whatever "Value" and "Value2" was set to. Therefore the results would return all shoes that are size 10 and blue.

```php
<?php $shoes = get_query('shoes', 'blue', 10); ?>

<?php if ( $shoes->have_posts() ) : while ( $shoes->have_posts() ) : the_post(); ?>
<!-- post -->

<?php endwhile; ?>
<!-- post navigation -->

<?php else: ?>
<!-- no posts found -->

<?php endif; ?>
```


***One more thing to note. if you choose to use the `tax_query` setting when creating your query. Choosing "query_var" from the drop down this will pass the query_var `$term` variable to the `term` key allowing for a dynamic query.***

#### Bonus Settings

Extra goodies with more to come. So far you can hide the default 'Post' post type.



