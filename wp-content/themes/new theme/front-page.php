<?php get_header();?>

      <div class="container text-center tm-welcome-container">
        <div class="tm-welcome">
          <i class="fas tm-fa-big fa-music tm-fa-mb-big"></i>
          <h1 class="text-uppercase mb-3 tm-site-name">Insertion</h1>
          <p class="tm-site-description">New HTML Website Template</p>
        </div>
      </div>

    </div>

    <div class="container">
      <div class="tm-search-form-container">
        <form action="" method="GET" class="form-inline tm-search-form">
          <div class="text-uppercase tm-new-release">New Release</div>
          <div class="form-group tm-search-box">
            <input type="text" name="keyword" class="form-control tm-search-input" placeholder="Type your keyword ...">
            <input type="submit" value="Search" class="form-control tm-search-submit">
          </div>
          <div class="form-group tm-advanced-box">
            <a href="#" class="tm-text-white">Go Advanced ...</a>
          </div>
        </form>
      </div>



<?php
// query_posts(array(
//    'post_type' => 'Albums',
//    'posts_per_page'=> 4,
//    'orderby'=> 'rand', 
// )); 
$albums = new WP_Query( 
            array(
              'post_type' => 'Albums',
              'posts_per_page'=>4,
              'orderby'=> 'rand',
              'meta_query' => array(
                array(
                  'key' => '_featured_album',
                  'value' => 'yes',
                )
              ),
            ));
?>   	
      <div class="row tm-albums-container grid">
		<?php

			while($albums->have_posts()) : $albums->the_post();  ?>
	        <div class="col-sm-6 col-12 col-md-6 col-lg-3 col-xl-3 tm-album-col">
	        <a href="<?php the_permalink();?>">
	          <figure class="effect-sadie">
				<?php if(has_post_thumbnail()):?>
					<img src="<?php the_post_thumbnail_url('thumb'); ?>" alt="<?php the_title(); ?>" class="img-fluid" class="btn btn-primary" href="">
				<?php endif;?>	          	
	            <figcaption>
	              <h2><?php the_title(); ?></h2>
	              <p><?php the_excerpt(); ?></p>
	            </figcaption>
	          </figure>
                <p> <strong>Author:</strong>
                <?php 
                    $albums_type = get_post_meta( get_the_ID(), 'albums_artist', true);

                    if (!empty( $albums_type ) ) {
                      echo $albums_type;
                    } 
                    ?></p>

                    <p> <strong>Featured Album:</strong>
                        <?php 
                    $featured_type = get_post_meta( get_the_ID(), '_featured_album', true);

                    if (!empty( $featured_type ) ) {
                      echo $featured_type;
                    } 
                    ?></p>

				</a>
	        </div>			
		<?php endwhile; ?>   
      </div>


      <div class="row">
        <div class="col-lg-12">
          <div class="tm-tag-line">
          <h2 class="tm-tag-line-title">Music is your powerful energy.</h2>
          </div>
        </div>
      </div>

 <?php
$albums = new WP_Query( 
            array(
              'post_type' => 'Albums',
              'meta_query' => array(
                array(
                  'key' => '_featured_album',
                  'value' => 'no',
                )
              ),
            ));
 ?>

      <div class="row mb-5">
      	<?php
          $index=0;
          $class1 ="media-body";
		      while ($albums->have_posts()) : $albums->the_post(); ?>

        <?php $index++; $class = ($index % 2 == 0 ? "tm-bg-pink" : "tm-bg-gray");  
        if(has_post_thumbnail()):?>
        <div class="col-xl-12">
          <div class="media-boxes">
            <div class="media">
					<img src="<?php the_post_thumbnail_url('thumb'); ?>" alt="<?php the_title(); ?>" class="mr-3">
				<?php endif;?>	
              
              <!-- <div class="media-body tm-bg-gray"> -->
                <div class="<?php echo $class." ".$class1 ?>">
                <div class="tm-description-box">
                  <h5 class="tm-text-blue"><?php the_title(); ?></h5>
                  <p class="mb-0"><?php the_excerpt(); ?></p>
                </div>
                <div class="tm-buy-box">
                  <a href="#" class="tm-bg-blue tm-text-white tm-buy">buy</a>
                  <span class="tm-text-blue tm-price-tag">$5.50</span>
                </div>
              </div>
            </div>
          </div>
              <?php endwhile; ?> 

          </div> 
        </div>
      </div>

      <div class="row tm-mb-big tm-subscribe-row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 tm-bg-gray tm-subscribe-form">
          <h3 class="tm-text-pink tm-mb-30">Subscribe our updates!</h3>
          <p class="tm-mb-30">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Morbi semper, ligula et pretium porttitor, leo orci accumsan ligula.</p>
          <form action="index.html" method="POST">
            <div class="form-group mb-0">
              <input type="text" class="form-control tm-subscribe-input" placeholder="Your Email">
              <input type="submit" value="Submit" class="tm-bg-pink tm-text-white d-block ml-auto tm-subscribe-btn">
            </div>
          </form>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 img-fluid pl-0 tm-subscribe-img"></div>
      </div>

    

  </div>


<?php get_footer();?>