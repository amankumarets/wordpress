add_action( 'add_meta_boxes', 'featured_album_metabox' );

function featured_album_metabox() 
{
    add_meta_box(
        'featured_album',
        'Featured album',
        'featured_album',
        'featured',
        'normal',
        'default'
    );
}


function featured_album($post) 
{
    wp_nonce_field( basename( __FILE__ ), 'featured_album' );
   
    echo '<input type="text" name="Author" >';
    echo '<input type="checkbox" name="featured album">';    
}

add_action('save_post','featured_album');

function featured_album_save($post_id)
{
    if (defined('DOING_AUTAUTOSAVE')&& DOING_AUTAUTOSAVE) 
        return;
    if (!wp_verify_nonce($post_id['featured_album_nonce'], basename(__FILE__)))
        return;
    if ('page'==$_POST['post_type']){
        if(!current_user_can('edit_page',$post_id))
            return;
    }else{
        if(!current_user_can('edit_post',$post_id))
            return;
    }


$featured_album_author=$_POST['featured_album_author'];
update_post_meta($post_id,'featured_album_author',$featured_album_author);
$featured_album_time=$_POST['featured_album_time'];
update_post_meta($post_id,'featured_album_time',$featured_album_time);
}







function featured_metabox() 
    {
        add_meta_box('featured_album', 'Featured Album',  'feature_metabox', 'albums', 'normal', 'high');
    }
add_action('add_meta_boxes', 'featured_metabox');
   



   function feature_metabox($post) {
    $featured_type = get_post_meta($post->ID, 'featured_albums', TRUE);
    
    ?>
    <input type="hidden" name="featured_type_noncename" id="featured_type_noncename" value="<?php echo wp_create_nonce( 'featured_albums'.$post->ID );?>" />

    <input type="checkbox" name="featured_albums" id="featured_albums" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'featured_albums', true ) ); ?>"> Yes.<br/>

    <input type="checkbox" name="featured_albums" id="featured_albums" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'featured_albums', true ) ); ?>"> No<br/>
    
    <?php
} 

function featured_data($post_id) {  
    
    if ( !wp_verify_nonce( $_POST['featured_type_noncename'], 'featured_albums'.$post_id )) {
        return $post_id;
    }
     
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
        return $post_id;

    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;
     
    $post = get_post($post_id);
    if ($post->post_type == 'albums') { 
        update_post_meta($post_id, 'featured_albums', esc_attr($_POST['featured_albums']) );
                return(esc_attr($_POST['featured_albums']));
    }
    return $post_id;
}
add_action('save_post', 'featured_data');




function featured_album(){
  global $post;
  $custom = get_post_custom($post->ID);
   $field_id = $custom["field_id"];
 ?>

  <label>Check for yes</label>
  <?php $field_id_value = get_post_meta($post->ID, 'field_id', true);
  if($field_id_value == "yes") $field_id_checked = 'checked="checked"'; ?>
    <input type="checkbox" name="field_id" value="yes">
  <?php

}

// Save Meta Details
add_action('save_post', 'save_details');

function save_details(){
  global $post;

if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post->ID;
}

  update_post_meta($post->ID, "field_id", $_POST["field_id"]);
}




public function form( $instance ) {
 
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
        $text = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( '', 'text_domain' );
        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'Text' ) ); ?>"><?php echo esc_html__( 'Text:', 'text_domain' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" cols="30" rows="10"><?php echo esc_attr( $text ); ?></textarea>
        </p>
        <?php
 
    }







$text = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( '', 'text_domain' );



<p><?php  get_post_meta( get_the_ID(), 'field_id', true); ?></p>


class FeaturedImage extends WP_Widget {
 
    function __construct() {
 
        parent::__construct(
            'featured-image',  // Base ID
            'Featured Image'   // Name
        );
 
        add_action( 'widgets_init', function() {
            register_widget( 'FeaturedImage' );
        });
 
    }
 
    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );
 
    public function widget( $args, $instance ) {
 
        echo $args['before_widget'];
 
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
 
        // echo '<div class="textwidget">';
 
        // echo esc_html__( $instance['text'], 'text_domain' );
 
        echo '</div>';

        if ( ! is_single() || get_post_type() != 'post' ) {
            return;
        }

        if ( ! has_post_thumbnail() ) {
            return;
        }

        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        the_post_thumbnail( strip_tags( $instance['size'] ) );
 
        echo $args['after_widget'];
 
    }
 
    public function form( $instance ) {
 
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
        // $text = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( '', 'text_domain' );
        $featured_type = ! empty($instance['image'])? $instance['image'] : esc_html__( '', '' ); 
        $size          = ! empty( $instance['size'] ) ? $instance['size'] : 'full';
        $allowed_sizes = $this->get_sizes();
        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        
      <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'Featured Image' ) ); ?>"><?php echo esc_html__( 'Featured Image:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php get_post_meta( get_the_ID(), 'field_id', true); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="number" cols="30" rows="10"><?php echo esc_attr( $featured_type ); ?></input>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Image Size:', 'featured-image' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
                <?php foreach ( $allowed_sizes as $value => $name ) : ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $size, $value ); ?>><?php echo esc_html( $name ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
 
    }
 
    public function update( $new_instance, $old_instance ) {









        class FeaturedImage extends WP_Widget {
 
    function __construct() {
 
        parent::__construct(
            'featured-image',  // Base ID
            'Featured Image'   // Name
        );
 
        add_action( 'widgets_init', function() {
            register_widget( 'FeaturedImage' );
        });
 
    }
 
    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );
 
    public function widget( $args, $instance ) {


        $albums = new WP_Query( 
            array(
              'post_type' => 'albums',
              'posts_per_page'=>2,
              'meta_query' => array(
                array(
                  'key' => '_featured_album',
                  'value' => 'yes',
                )
              ),
            // Other query properties
            ) 
        );
              while($albums->have_posts()) : $albums->the_post(); 
                     the_post_thumbnail('thumbnail'); 
                         endwhile;

 
        echo $args['before_widget'];
 
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
 
        // echo '<div class="textwidget">';
 
        // echo esc_html__( $instance['text'], 'text_domain' );
 
        echo '</div>';

        if ( ! is_single() || get_post_type() != 'post' ) {
            return;
        }

        if ( ! has_post_thumbnail() ) {
            return;
        }

        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        the_post_thumbnail( strip_tags( $instance['size'] ) );
 
        echo $args['after_widget'];
 
    }
 
    public function form( $instance ) {
 
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
        // $text = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( '', 'text_domain' );
        $featured_type = ! empty($instance['image'])? $instance['image'] : esc_html__( '', '' ); 
        $size          = ! empty( $instance['size'] ) ? $instance['size'] : 'full';
        $allowed_sizes = $this->get_sizes();
        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        
      <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'Featured Image' ) ); ?>"><?php echo esc_html__( 'Featured Image:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php get_post_meta( get_the_ID(), 'field_id', true); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="number" cols="30" rows="10"><?php echo esc_attr( $featured_type ); ?></input>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Image Size:', 'featured-image' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
                <?php foreach ( $allowed_sizes as $value => $name ) : ?>
                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $size, $value ); ?>><?php echo esc_html( $name ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
 
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = array();
 
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['image'] = ( !empty( $new_instance['image'] ) ) ? $new_instance['image'] : '';
        
        $instance['size']  = ( ! empty( $new_instance['size'] ) && array_key_exists( $new_instance['size'], $this->get_sizes() ) ) ? strip_tags( $new_instance['size'] ) : 'full';
       
    }
    public function get_sizes() {
        $sizes = array(
            'thumbnail' => __( 'Thumbnail', 'featured-image' ),
            'medium'    => __( 'Medium', 'featured-image' ),
            'large'     => __( 'Large', 'featured-image' ),
            'full'      => __( 'Full', 'featured-image' )
        );

        return apply_filters( 'featured-image/image-sizes', $sizes );
    }

}
$featuredImage = new FeaturedImage();
 
        $instance = array();
 
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['image'] = ( !empty( $new_instance['image'] ) ) ? $new_instance['image'] : '';
        
        $instance['size']  = ( ! empty( $new_instance['size'] ) && array_key_exists( $new_instance['size'], $this->get_sizes() ) ) ? strip_tags( $new_instance['size'] ) : 'full';
       
    }
    public function get_sizes() {
        $sizes = array(
            'thumbnail' => __( 'Thumbnail', 'featured-image' ),
            'medium'    => __( 'Medium', 'featured-image' ),
            'large'     => __( 'Large', 'featured-image' ),
            'full'      => __( 'Full', 'featured-image' )
        );

        return apply_filters( 'featured-image/image-sizes', $sizes );
    }

}
$featuredImage = new FeaturedImage();









add_action( 'widgets_init', 'featured_init' );

function featured_init() {
    register_widget( 'featured_albums' );
}

class featured_albums extends WP_Widget
{

    public function __construct()
    {
        $widget_details = array(
            'classname' => 'featured_albums',
            'description' => 'Creates a featured item consisting of a title, image, description and link.'
        );

        parent::__construct( 'featured_albums', 'Featured Item Widget', $widget_details );

        add_action('admin_enqueue_scripts', array($this, 'assets'));
    }


public function assets()
{
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('uploader', plugin_dir_url(__FILE__) . 'script.js', array('jquery'));
    wp_enqueue_style('thickbox');
}


    public function widget( $args, $instance )
    {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }

        ?>

        <p>
        <img src='<?php echo $instance['image'] ?>'>
        </p>
        
        
        <?php

        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {  
        return $new_instance;
    }

    public function form( $instance )
    {

        $title = '';
        if( !empty( $instance['title'] ) ) {
            $title = $instance['title'];
        }

       

        $image = '';
        if(isset($instance['image']))
        {
            $image = $instance['image'];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>


        <p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
            <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
            <input class="upload_image_button" type="button" value="Upload Image" />
        </p>
    <?php
    }
}





<input type="hidden" name="albums_type_noncename" id="albums_type_noncename" value="<?php echo wp_create_nonce( 'albums_artist'.$post->ID );?>">

 
    if ( !wp_verify_nonce( $_POST['albums_type_noncename'], 'albums_artist'.$post_id )) {
        return $post_id;
    }






     


            <div class="media">
              <?php if(has_post_thumbnail()):?>
                    <img src="http://localhost/wordpress/wp-content/uploads/2020/06/insertion-140x140-02.jpg" alt="<?php the_title(); ?>" class="mr-3">
                <?php endif;?>  
              <div class="media-body tm-bg-pink-light">
                <div class="tm-description-box">
                  <h5 class="tm-text-pink"><?php the_title(); ?></h5>
                  <p class="mb-0">Donec est felis, posuere viverra dapibus ac, pretium vel libero. Aliquam consectetur, arcu eget euismod congue, tortor metus vehicula.</p>
                </div>
                <div class="tm-buy-box">
                  <a href="#" class="tm-bg-pink tm-text-white tm-buy">buy</a>
                  <span class="tm-text-pink tm-price-tag">$7.25</span>
                </div>
              </div>
            </div>

            <div class="media">
              <?php if(has_post_thumbnail()):?>
                    <img src="http://localhost/wordpress/wp-content/uploads/2020/06/insertion-140x140-03.jpg" alt="<?php the_title(); ?>" class="mr-3">
                <?php endif;?>  
              <div class="media-body tm-bg-gray">
                <div class="tm-description-box">
                  <h5 class="tm-text-blue">Quisque dignissim porta nunc</h5>
                  <p class="mb-0">In neque felis, fringilla vel orci ut, sodales consectetur purus. Vivamus eget urna vitae ante pellentesque iaculis. Praesent sit amet.</p>
                </div>
                <div class="tm-buy-box">
                  <a href="#" class="tm-bg-blue tm-text-white tm-buy">buy</a>
                  <span class="tm-text-blue tm-price-tag">$6.80</span>
                </div>
              </div>
            </div>

            <div class="media">
              <?php if(has_post_thumbnail()):?>
                    <img src="http://localhost/wordpress/wp-content/uploads/2020/06/insertion-140x140-04.jpg" alt="<?php the_title(); ?>" class="mr-3">
                <?php endif;?>  
              <div class="media-body tm-bg-pink-light">
                <div class="tm-description-box">
                  <h5 class="tm-text-pink">Vestibulum mattis quam sodales</h5>
                  <p class="mb-0">Curabitur id tempor orci. Fusce efficitur in enim sit amet sodales. Proin id gravida leo. Phasellus non quam et justo faucibus rhoncus.</p>
                </div>
                <div class="tm-buy-box">
                  <a href="#" class="tm-bg-pink tm-text-white tm-buy">buy</a>
                  <span class="tm-text-pink tm-price-tag">$3.75</span>
                </div>
              </div>
            </div>

            <div class="media">
              <?php if(has_post_thumbnail()):?>
                    <img src="http://localhost/wordpress/wp-content/uploads/2020/06/insertion-140x140-05-1.jpg" alt="<?php the_title(); ?>" class="mr-3">
                <?php endif;?>  
              <div class="media-body tm-bg-gray">
                <div class="tm-description-box">
                  <h5 class="tm-text-blue">Vestibulum mattis quam sodales</h5>
                  <p class="mb-0">Maecenas sit amet nibh faucibus, tincidunt nisl sit amet, elementum eros. Fusce congue ligula gravida lorem lacinia.</p>
                </div>
                <div class="tm-buy-box">
                  <a href="#" class="tm-bg-blue tm-text-white tm-buy">buy</a>
                  <span class="tm-text-blue tm-price-tag">$5.25</span>
                </div>
              </div>
            </div>




            <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'Featured Image' ) ); ?>"><?php echo esc_html__( 'Featured Image:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php get_post_meta( get_the_ID(), '_featured_album', true); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="number" cols="30" rows="10"><?php echo esc_attr( $albums ); ?></input>
        </p>



         // $albums = new WP_Query( 
        //     array(
        //       'post_type' => 'albums',
        //       // 'posts_per_page'=>2,
        //       'meta_query' => array(
        //         array(
        //           'key' => '_featured_album',
        //           'value' => 'yes',
        //         )
        //       ),
        //     ) 
        // );

        //       while($albums->have_posts()) : $albums->the_post(); 
        //              the_post_thumbnail('thumbnail'); 
        //                  endwhile;




        
class FeaturedImage extends WP_Widget {
 
    function __construct() {
 
        parent::__construct(
            'featured-image',  // Base ID
            'Featured Image'   // Name
        );
 
        add_action( 'widgets_init', function() {
            register_widget( 'FeaturedImage' );
        });
 
    }
 
    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );
 
    public function widget( $args, $instance ) {

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 10;
        if ( ! $number )
            $number = 10;

        echo '</div>';

        $albums = new WP_Query( apply_filters( 'widget_posts_args', 
            array( 'posts_per_page' => $number,
                'meta_query' => array(
                array(
                  'key' => '_featured_album',
                  'value' => 'yes',  
              )
             )
            )
           )
          );

        if ($albums->have_posts()) :

        while ( $albums->have_posts() ) : $albums->the_post();
             endwhile; 
       
            echo $args['before_widget'];
                if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        echo $args['after_widget'];
        }

         // if ( $title ) echo $before_title . $title . $after_title; 
 
    }

    public function form( $instance ) {
    
        $title = '';
        if( !empty( $instance['title'] ) ) {
            $title = $instance['title'];
        }
        
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 2;
       
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        
        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        
        <?php
 
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = array();
 
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['image'] = ( !empty( $new_instance['image'] ) ) ? $new_instance['image'] : '';
        $instance['number'] = (int) $new_instance['number'];
    
       return $new_instance;
    }
    
}
$featuredImage = new FeaturedImage();