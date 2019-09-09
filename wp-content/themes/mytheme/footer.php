    <footer>
        <!-- Yea i dont like this syntax for using template-parts as well -->
        <?php get_template_part( 'template-parts/footer', 'contact' ); ?>
        <script>
            var $ = jQuery.noConflict();
        </script>
        <!-- WP footer; includes scripts refs we enqueued -->
        <?php wp_footer(); ?>
    </footer>
</body>
</html>