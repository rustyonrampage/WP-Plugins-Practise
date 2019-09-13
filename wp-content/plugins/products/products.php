
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



?>