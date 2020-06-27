 <?php

get_header(); ?>
The album details?
<div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
  
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

        	echo 'Album Details here';
  
           
        endwhile;
        ?>
  
        </main><!-- .site-main -->
    </div><!-- .content-area -->
  
<?php get_footer(); ?>