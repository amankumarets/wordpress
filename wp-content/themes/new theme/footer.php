<?php wp_footer();?>

<?php if ( !function_exists('dynamic_sidebar') ||
 !dynamic_sidebar('Main widget') ) : ?>
<?php endif; ?>
<section>
  	<div class="row tm-mb-medium">
        <div class="col-4">
	        <?php
				if(is_active_sidebar('footer-left'))
				{
				dynamic_sidebar('footer-left');
				}
			?>  
        </div>


	    <div class="col-4">
	         
		        <?php
					if(is_active_sidebar('footer-middle'))
					{
					dynamic_sidebar('footer-middle');
					}
				?>   
	    </div>



        <div class="col-4">
	          <?php
				if(is_active_sidebar('footer-right'))
				{
				dynamic_sidebar('footer-right');
				}
			  ?>
          
        </div>
    </div>
 </section>     
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <footer class="row">
        <div class="col-xl-12">
          <p class="text-center p-4">Copyright &copy; <span class="tm-current-year">2020</span> Your Company Name           
          - Design:  Tooplate</p>
        </div>
      </footer>
    </div> 

</body>
</html>

