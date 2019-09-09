<?php
    function add_theme_scripts(){
        // +Stylesheets+
        // Args{ name. path }
        // load the main stylesheet in root folder; style.css
        wp_enqueue_style( 'style', get_stylesheet_uri(), array('bootstrap_css') ); 
        // load the bootstrap stylesheet
	    wp_enqueue_style( 'bootstrap_css', get_theme_file_uri( '/assets/css/bootstrap.min.css' ) );
        // loead the font-awesoome
	    wp_enqueue_style( 'fontawesome_css', get_theme_file_uri( '/assets/css/fontawesome.min.css' ) );

        // +Scripts+
        // Args{ name. path, dependencies, in_footer }
        // load the popper.js on which bootstrap.js depends
        wp_enqueue_script( 'poper_js',  get_theme_file_uri( '/assets/js/popper.min.js' ), array('jquery'), true );
        // load the bootstrap script
        wp_enqueue_script( 'bootstrap_js',  get_theme_file_uri( '/assets/js/bootstrap.min.js' ), array('jquery', 'poper_js'), true );
    }
    add_action( 'wp_enqueue_scripts' , 'add_theme_scripts');

    // Theme supports
	add_theme_support( 'post-thumbnails' );
    
    // CUstomizing our search form 
    function wpdocs_my_search_form( $form ) {
        $form = '   
        <form class="mb-0 mr-3" method="GET" action="'. home_url('/').'">
            <div class="input-group input-group-sm">
            <input type="text" class="form-control search_input" name="s">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary search_button" type="submit"><i class="fas fa-search"></i></button>
            </div>
            </div>
        </form>';
     
        return $form;
    }
    add_filter( 'get_search_form', 'wpdocs_my_search_form' );

?>