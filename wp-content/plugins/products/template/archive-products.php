
<?php get_header(); ?>

<h1 class="display-4"> Our Products </h1>
<div class="card-columns">

<?php
    if ( have_posts() ) : 

        while ( have_posts() ) : the_post();
            $image_url = get_the_post_thumbnail_url( get_the_ID() );
            ?>
                <div class="card" style="width: 18rem;">
                    <?php if($image_url): ?>
                        <img class=" product_card_img" height="30%" src="<?php print $image_url;  ?>" alt="Card image cap">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php print get_the_title(); ?></h5>
                        <p class="card-text"> <?php print wp_trim_words( get_the_content(), 20 ); ?> </p>
                        <a href="<?php print get_the_permalink(); ?>" class="btn btn-primary">Details</a>
                    </div>
                </div>
            <?php
        endwhile;
    else :
        _e( 'Sorry, no posts matched your criteria.', 'textdomain' );
    endif;
?>
    </div>

</div>
<?php get_footer(); ?>