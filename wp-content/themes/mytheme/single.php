
<?php get_header(); ?>

<?php
    if ( have_posts() ) : 
        while ( have_posts() ) : the_post();
            $image_url = get_the_post_thumbnail_url( get_the_ID() );
            ?>
            <div class="blog-post">
              
                <?php if($image_url): ?>
                    <div class="parallax mb-4" style='background-image:url(<?php print $image_url ?>)'></div>
                <?php endif; ?>
                <h2 class="blog-post-title"><?php print get_the_title(); ?></h2>
                <p class="blog-post-meta">
                    <?php print get_the_date(); ?> By <?php  the_author_posts_link(); ?>
                </p>
                <?php the_content(); ?>
                <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                ?>
            </div>
            <?php
        endwhile;
    else :
        _e( 'Sorry, no posts matched your criteria.', 'textdomain' );
    endif;
?>

</div>
<?php get_footer(); ?>

