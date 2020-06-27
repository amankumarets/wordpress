<?php get_header();?>
<section>
    <div class="leftside">
    <div class="row">
            <div class="col-3">
                <img src="<?php the_post_thumbnail_url('thumb'); ?>">
            </div>
            <div class="col-9 rightside">
                    <?php while (have_posts()) : the_post(); ?>
                <h2><a href="<?php the_permalink() ?>" style><?php the_title(); ?></a></h2>
                <p><?php the_excerpt(); ?></p>


                <?php the_content();?>
                 <strong>Author:</strong>          
                <?php 
                    $albums_type = get_post_meta( get_the_ID(), 'albums_artist', true);
                        if (!empty( $albums_type ) ) {
                              echo $albums_type;
                    } 
                ?>
            </div>
    </div>
</div>
</section>
<?php endwhile; ?>
