<div class="container">
  <header class="blog-header py-3" id="header">
    <div class="row flex-nowrap justify-content-between align-items-center">
      <div class="col-4 pt-1">
        <a class="text-muted" href="<?php print get_bloginfo('rss_url'); ?>">Subscribe</a>
      </div>
      <div class="col-4 text-center">
        <a  class="blog-header-logo text-dark" href="<?php print get_bloginfo('wpurl'); ?>"><?php print get_bloginfo('name') ; ?></a>
      </div>
      <div class="col-4 d-flex flex-row justify-content-end align-items-center">
        
        <!-- <a class="text-muted" href="https://getbootstrap.com/docs/4.3/examples/blog/#">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"></circle><path d="M21 21l-5.2-5.2"></path></svg>
        </a> -->
        <?php get_search_form(); ?>

        <?php 
          // Check if a User is logged in or not
          $login_logout = array();
          if( is_user_logged_in() ){
            $login_logout['text'] = "Logout";
            $login_logout['url'] = wp_logout_url(get_bloginfo( 'wpurl' ) );
          }else{
            $login_logout['text'] = "Login";
            $login_logout['url'] = wp_login_url();
          }
          $a = 'a';
        ?>
        <a class="btn btn-sm btn-outline-secondary" href="<?php print $login_logout['url'];  ?>"><?php print $login_logout['text']; ?></a>
      </div>
    </div>
  </header>
    <!-- We gonnna get all the categories -->
  <div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-center">
      <?php 
        $categories = get_categories();
        foreach ($categories as $item) {
          # code...
          print "<a class=\"p-2 text-muted\"  href=\"".get_site_url()."/?cat=".$item->cat_ID."\">".$item->name."</a>";
        }
      ?>
    </nav>
  </div>