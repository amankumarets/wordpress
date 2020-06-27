<?php
get_header();
?>


        

<?php
while (have_posts()) : the_post(); ?>
<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
<p><?php the_excerpt(); ?></p>
<p><?php  get_post_meta( get_the_ID(), 'field_id', true); ?></p>
<?php get_the_post_thumbnail( $post->ID, 'large');?>

<p> <strong>Author:</strong>          
<?php 
    $albums_type = get_post_meta( get_the_ID(), 'albums_artist', true);
        if (!empty( $albums_type ) ) {
              echo $albums_type;
    } 
?></p>
<?php endwhile;?>


