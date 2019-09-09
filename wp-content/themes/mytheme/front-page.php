
<?php get_header(); ?>
   <!-- Featured Post -->
   <?php 
      $featured_post_ids = array();
      // select sticky post or most recent post if sticky isn't set
      $args = array( 
                    'numberposts' => 1,
                    'post__in' => get_option( 'sticky_posts' ),
                    'ignore_sticky_posts' => 1);
      $featured_post = wp_get_recent_posts( $args );
      $rendered_feature_post = array(
        "title" => "Untitled",
        "text" => "There is no post buddy.",
        "link" => site_url(),
        "background_image" => "",
        "date" => ""
      );
      if(sizeof($featured_post)>0){
        array_push( $featured_post_ids, $featured_post[0]['ID'] );
        $rendered_feature_post['title'] = $featured_post[0]["post_title"];
        $rendered_feature_post['text'] = wp_trim_words( $featured_post[0]["post_content"], 23 );
        $rendered_feature_post['date'] = $featured_post[0]["post_date"];
        $rendered_feature_post['link'] = $featured_post[0]["guid"];
        $$rendered_feature_post['image']  = get_the_post_thumbnail_url( $featured_post[0]["ID"] );
      }
    ?>
  <div style="background-image:url(<?php print $$rendered_feature_post['image'] ?>)" class="jumbotron  p-4 p-md-5 text-white rounded bg-dark">
    <div class="col-md-6 px-0">
      <h1 class="display-4 font-italic"><?php print $rendered_feature_post['title']; ?></h1>
      <p class="lead my-3"><?php print $rendered_feature_post['text']; ?></p>
      <p class="lead mb-0"><a href="<?php print $rendered_feature_post['link']; ?>" class="text-white font-weight-bold">Continue reading...</a></p>
    </div>
  </div>

  <?php 
  // Featured posts row: 2 latest posts only
    $args = array(
      'numberposts' => 2,
      'exclude' => $featured_post_ids
    );
    $featured_posts = wp_get_recent_posts( $args );
  ?>
  <?php 
    if( sizeof($featured_posts) > 0 ): 
      print "<div class=\"row mb-2\">";
      foreach($featured_posts as $idx=> $item):
        // init
        array_push( $featured_post_ids, $item['ID'] );
        $category_text = "General";
        $cat = get_the_category( $item['ID'] );
        $even_odd_classes = $idx % 2 == 0? "text-primary":"text-success";
        //$published_date = date_parse($item['post_date']);
        $published_date = date_format ( date_create($item['post_date']) , "M, Y" ); 
        if(sizeof($cat)>0)
          $category_text = $cat[0]->name;
        // endinit
  ?>
    <div class="col-md-6">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 <?php print $even_odd_classes; ?>">
            <?php print $category_text." ".$even_odd; ?>
          </strong>
          <h3 class="mb-0"><?php print $item['post_title']; ?></h3>
          <div class="mb-1 text-muted"><?php print $published_date; ?></div>
          <p class="card-text mb-auto"><?php print wp_trim_words( $item['post_content'], 15 ); ?></p>
          <a href="<?php print $item['guid']; ?>" class="stretched-link">Continue reading</a>
        </div>
        <div class="col-auto d-none d-lg-block">
          <img class="img" style="object-fit: cover;" width="200" height="250"  src="<?php print get_the_post_thumbnail_url($item['ID']); ?>" alt="">
        </div>
      </div>
    </div>
  <?php 
    endforeach;
    print "</div>";
    endif; 
  ?>
</div>

<main role="main" class="container">
  <div class="row">
    <div class="col-md-8 blog-main">
      <h3 class="pb-4 mb-4 font-italic border-bottom">
        More News
      </h3>
      <?php
        // Blog Posts List
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = array('posts_per_page' => get_option( 'posts_per_page' ),
                      'paged' => $paged,
                      'post__not_in' => $featured_post_ids, 
                    );
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

