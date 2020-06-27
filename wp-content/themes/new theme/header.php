<!DOCTYPE html>
<html>
<head>

	<?php wp_head();?>

	<div class="tm-main">

    <div class="<?php echo is_front_page() ? 'tm-welcome-section' : ''; ?>">
      <div class="container tm-navbar-container">
      	
        <div class="row">
          <div class="col-xl-12">
            <nav class="navbar navbar-expand-sm">
              <ul class="navbar-nav ml-auto">

                
          		<?php
          			 $primary_menu = wp_get_nav_menu_items('primary-menu');
          			foreach ($primary_menu as $key => $menudata) {
          				
          		?>

          		<li class="nav-item ">
                  <a href="<?php echo $menudata->target; ?>" class="nav-link tm-nav-link tm-text-white active"><?php echo $menudata->title?></a> 
                </li>
          			<?php } ?>


                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>


              	
</head>


<body <?php body_class();?>>