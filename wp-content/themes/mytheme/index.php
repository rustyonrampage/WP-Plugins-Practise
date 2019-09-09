<?php get_header(); ?>
<?php
    $search_text = get_search_query();
    $search_query = $search_text == "" ? "Search" : "Search: ". $search_text ; 
    $archive_name = get_the_archive_title();
    $title_text = $archive_name == "Archives" ? $search_query : $archive_name ;
?>
<main role="main" class="container">
  <div class="row">
    <div class="col-md-8 blog-main">
      <h3 class="pb-4 mb-4 font-italic border-bottom">
        <?php print $title_text; ?>
      </h3>
      <?php
        // Blog Posts List
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = array('posts_per_page' => get_option( 'posts_per_page' ),
                      'paged' => $paged,
                    );
        if( $search_text != "" )
            $args['s'] = $search_text;

        $the_query = new WP_Query( $args );
        
        global $wp_query; // Put default query object in a temp variable
        $tmp_query = $wp_query;// Now wipe it out completely
        $wp_query = null; 
        $wp_query = $the_query; // Re-populate the global with our custom query

        if ( $the_query->have_posts() ) : 
          // Start the Loop 
          while ( $the_query->have_posts() ):
             $the_query->the_post(); 
          ?>
            <div class="blog-post">
                <h2 class="blog-post-title"><?php the_title(); ?></h2>
                <p class="blog-post-meta"><?php print get_the_date(); ?> by <?php  the_author_posts_link(); ?></p>
                <p><?php print get_the_excerpt(); ?></p>
                <a href="<?php print get_the_permalink(); ?>" class="stretched-link">Continue reading</a>

            </div><!-- /.blog-post -->
          <?php
          // End the Loop 
          
          endwhile;
          $prev_posts_url = get_previous_posts_page_link();
          $next_posts_url = get_next_posts_page_link(  $the_query->max_num_pages);
          
          global $wp;
          $current_page_url = home_url( $wp->request ).'/';
          
          $prev_link_ui_classes = "btn-outline-primary";
          if( $current_page_url == $prev_posts_url || $prev_posts_url== null)
            $prev_link_ui_classes =  "btn-outline-secondary disabled";

          $next_link_ui_classes = "btn-outline-primary";
          if( $current_page_url == $next_posts_url || $next_posts_url== null)
            $next_link_ui_classes =  "btn-outline-secondary disabled";

          wp_reset_postdata();
          ?>
          <nav class="blog-pagination">
              <a class="btn <?php print $prev_link_ui_classes; ?>" href="<?php print $prev_posts_url; ?>">Older</a>
              <a class="btn <?php print $next_link_ui_classes; ?>"  href="<?php print $next_posts_url; ?>" >Newer</a>
          </nav>
       <?php
       else: 
      // If no posts match this query, output this text. 
          _e( 'Sorry, no more posts available.', 'textdomain' ); 
      endif; 
      ?>
    </div><!-- /.blog-main -->

    <aside class="col-md-4 blog-sidebar">
      <div class="p-4 mb-3 bg-light rounded">
        <h4 class="font-italic">About</h4>
        <p class="mb-0">
          This is a basic blog theme for <em> WordPress </em>. It covers the basics like templates, loops, customizations, 
          utilizing major features and functions.
        </p>
      </div>

      <div class="p-4">
        <h4 class="font-italic">Archives</h4>
        <ol class="list-unstyled mb-0">
        <?php 
          $args = array(
            'type' => 'monthly',
          );
        ?>
        <?php wp_get_archives( $args ); ?>
        </ol>
 
      </div>

      <div class="p-4">
        <h4 class="font-italic">Elsewhere</h4>
        <ol class="list-unstyled">
          <li><a href="https://github.com/rustyonrampage">GitHub</a></li>
          <li><a href="https://twitter.com/rustyonrampage">Twitter</a></li>
          <li><a href="https://www.facebook.com/RustyOnRampage">Facebook</a></li>
        </ol>
      </div>
    </aside><!-- /.blog-sidebar -->

  </div><!-- /.row -->

</main><!-- /.container -->

<?php get_footer(); ?>