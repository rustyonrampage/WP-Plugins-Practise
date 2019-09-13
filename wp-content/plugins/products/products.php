
<?php 
/*
Plugin Name: Products
Description: Basic plugin to test 
Author: Asad Jakhar
*/
function product_cpt(){
    register_post_type('product', array(
        'label' => 'Product',
        'labels' => array(
            'name' => 'Products',
            'singular_name' => 'Product',
            'add_new_item' => "Add new Product",
            'edit_item' => 'Edit Product'
        ),
        'supports' => array('title', 'editor', 'comments', 'revisions', 'author',
                            'thumbnail', 'custom-fields', 'post-formats'),
        'public' => true,
        'has_archive' => true
    ));
    flush_rewrite_rules();
}
add_action('init', 'product_cpt');


function product_cpt_deactivation() {
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'product' );
    // clear the permalink to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'product_cpt_deactivation' );


add_filter('template_include', 'products_template');
function products_template( $template ) {
  if ( is_post_type_archive('product') ) {
    $theme_files = array('archive-products.php','template/archive-products.php');
    $exists_in_theme = locate_template($theme_files, false);
    if ( $exists_in_theme != '' ) {
      return $exists_in_theme;
    } else {
      return plugin_dir_path(__FILE__) . 'template/archive-products.php';
    }
  }
  return $template;
}

?>