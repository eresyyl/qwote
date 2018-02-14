<?php
require_once(ABSPATH . "wp-load.php");

add_action('init', 'selections_objects_v2');
function selections_objects_v2(){

  $labels = array(
    'name' => __('Selections v2','go'),
    'singular_name' => __('Selection','go')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    //'show_in_menu' => 'edit.php?post_type=project',
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    //'menu_position' => null,
    'supports' => array('title','editor','author')
  );
  register_post_type('select',$args);

  $labels = array(
  'name' => 'Categories',
  'singular_name' => 'Category',
  'menu_name' => 'Categories',
  );
  register_taxonomy('selection_cat', array('select'), array(
  'hierarchical' => true,
  'show_ui' => true,
  'labels' => $labels,
  'query_var' => true,
  'rewrite' => array( 'slug' => 'selection_cat' ),
   ));

  $labels = array(
  'name' => 'Suppliers',
  'singular_name' => 'Supplier',
  'menu_name' => 'Suppliers',
  );
  register_taxonomy('selection_supplier', array('select'), array(
  'hierarchical' => true,
  'show_ui' => true,
  'labels' => $labels,
  'query_var' => true,
  'rewrite' => array( 'slug' => 'selection_supplier' ),
   ));

  
  $labels = array(
  'name' => 'Levels',
  'singular_name' => 'Level',
  'menu_name' => 'Levels',
  );
  register_taxonomy('selection_level', array('select'), array(
  'hierarchical' => true,
  'show_ui' => true,
  'labels' => $labels,
  'query_var' => true,
  'rewrite' => array( 'slug' => 'selection_level' ),
   ));

   $labels = array(
   'name' => 'Brands',
   'singular_name' => 'Brand',
   'menu_name' => 'Brands',
   );
   register_taxonomy('selection_brand', array('select'), array(
   'hierarchical' => true,
   'show_ui' => true,
   'labels' => $labels,
   'query_var' => true,
   'rewrite' => array( 'slug' => 'selection_brand' ),
    ));

}

add_action('init', 'scope_objects');
function scope_objects(){

  $labels = array(
    'name' => __('Scopes','go'),
    'singular_name' => __('Scope','go')
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => 'edit.php?post_type=project',
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author')
  );
  register_post_type('scope',$args);

}
?>
