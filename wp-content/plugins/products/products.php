
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
        'supports' => array('title', 'editor', 'thumbnail'),
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

function products_load_css() {
  $plugin_url = plugin_dir_url( __FILE__ );
  wp_enqueue_style( 'product_styles', $plugin_url . 'assets/css/product_style.css' );
}
add_action( 'wp_enqueue_scripts', 'products_load_css' );


// adding fields to CPT
function product_add_custom_box()
{
    //$screens = ['post', 'wporg_cpt'];
    $screens = ['product'];
    foreach ($screens as $screen) {
        add_meta_box(
            'product_box_id',           // Unique ID
            'Product Details',  // Box title
            'product_custom_box_html',  // Content callback, must be of type callable
            $screen                   // Post type
        );
    }
}
function product_custom_box_html($post)
{
    $product_spec_value = get_post_meta($post->ID, 'product_box_id');
    if(count($product_spec_value)>0)
        $product_spec_value = $product_spec_value[0];

    $a = 'a';
    ?>
    <label for="product_specs">A custom field</label>
    <select name="product_specs"  class="postbox">
        <option value="">Select something...</option>
        <option value="something" <?php $product_spec_value == "something" ? print "selected" : "" ?> >Something 1</option>
        <option value="else" <?php $product_spec_value == "else" ? print "selected" : "" ?>>Else xzc</option>
    </select>
    <?php
}
add_action('add_meta_boxes', 'product_add_custom_box');

function product_save_postdata($post_id)
{
    if (array_key_exists('product_specs', $_POST)) {
        update_post_meta(
            $post_id,
            'product_box_id',
            $_POST['product_specs']
        );
    }
}
add_action('save_post', 'product_save_postdata');

?>