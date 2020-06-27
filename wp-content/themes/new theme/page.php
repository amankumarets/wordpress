 <?php get_header();?>

        <div class="row tm-albums-container grid">

        	<h1><?php the_title();?></h1>

        	<?php if(has_post_thumbnail()):?>
        		
        	 <?php endif;?>



        <?php if (have_posts())	: while(have_posts()) : the_post();?>
        	<?php the_excerpt();?>

                <a href="<?php the_permalink();?>"></a>
        <?php endwhile; endif;?>	
        	
        	

        </div>