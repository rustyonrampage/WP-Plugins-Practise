<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width">
        <!-- Very Important: adds our enqueued styles -->
        <?php wp_head(); ?>
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                font-size: 3.5rem;
                }
            }
        </style>
    </head>

    <body>
    <!-- Yea i dont like this syntax for using template-parts as well -->
    <?php get_template_part( 'template-parts/header', 'banner' ); ?>

