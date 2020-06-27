<?php

function ets_load_stylesheets()
{

    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), true, 'all');

    wp_enqueue_style('bootstrap');

    wp_register_style('style', get_template_directory_uri() . '/style.css', array(), true, 'all');

    wp_enqueue_style('style');
    
    wp_register_style('fontawesome', get_template_directory_uri() . '/css/fontawesome.css', array(), true, 'all');
    wp_enqueue_script('script', plugin_dir_url(__FILE__) . 'script.js', array('jquery'));
    wp_enqueue_style('script');

    wp_enqueue_style('fontawesome');

}

add_action('wp_enqueue_scripts', 'ets_load_stylesheets');

add_theme_support('menus');
add_theme_support( 'post-thumbnails' );


/*Template Name: Albums*/
function custom_post_type() {


    $labels = array(
        'name'                => _x( 'Albums', 'Post Type General Name', 'Aman' ),
        'singular_name'       => _x( 'Album', 'Post Type Singular Name', 'Aman' ),
        'menu_name'           => __( 'Albums', 'Aman' ),
        'parent_item_colon'   => __( 'Parent Album', 'Aman' ),
        'all_items'           => __( 'All Album', 'Aman' ),
        'view_item'           => __( 'View Album', 'Aman' ),
        'add_new_item'        => __( 'Add New Album', 'Aman' ),
        'add_new'             => __( 'Add New', 'Aman' ),
        'edit_item'           => __( 'Edit Album', 'Aman' ),
        'update_item'         => __( 'Update Album', 'Aman' ),
        'search_items'        => __( 'Search Album', 'Aman' ),
        'not_found'           => __( 'Not Found', 'Aman' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'Aman' ),
    );
          
    $args = array(
        'label'               => __( 'albums', 'Aman' ),
        'description'         => __( 'Album news and reviews', 'Aman' ),
        'labels'              => $labels,
      
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
       
        'taxonomies'          => array( 'genres' ),
        'orderby' => 'rand',
        'post_per_page' => 4,
        'post_status' => 'publish',
        
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
        'taxonomies' => array('category', 'post_tag'),
 
    );
    
    register_post_type( 'albums', $args );
    //  $labels = array(
    //     'name'                => _x( 'Albums2', 'Post Type General Name', 'Aman' ),
    //     'singular_name'       => _x( 'Albums', 'Post Type Singular Name', 'Aman' ),
    //     'menu_name'           => __( 'Albums2', 'Aman' ),
    //     'parent_item_colon'   => __( 'Parent Albums', 'Aman' ),
    //     'all_items'           => __( 'All Albums', 'Aman' ),
    //     'view_item'           => __( 'View Album', 'Aman' ),
    //     'add_new_item'        => __( 'Add New Album', 'Aman' ),
    //     'add_new'             => __( 'Add New', 'Aman' ),
    //     'edit_item'           => __( 'Edit Album', 'Aman' ),
    //     'update_item'         => __( 'Update Album', 'Aman' ),
    //     'search_items'        => __( 'Search Album', 'Aman' ),
    //     'not_found'           => __( 'Not Found', 'Aman' ),
    //     'not_found_in_trash'  => __( 'Not found in Trash', 'Aman' ),
    // );
          
    // $args = array(
    //     'label'               => __( 'albums2', 'Aman' ),
    //     'description'         => __( 'Album news and reviews', 'Aman' ),
    //     'labels'              => $labels,
      
    //     'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
       
    //     'taxonomies'          => array( 'genres' ),
        
    //     'hierarchical'        => false,
    //     'public'              => true,
    //     'show_ui'             => true,
    //     'show_in_menu'        => true,
    //     'show_in_nav_menus'   => true,
    //     'show_in_admin_bar'   => true,
    //     'menu_position'       => 5,
    //     'can_export'          => true,
    //     'has_archive'         => true,
    //     'exclude_from_search' => false,
    //     'publicly_queryable'  => true,
    //     'capability_type'     => 'post',
    //     'show_in_rest' => true,
 
    // );

    
    // register_post_type('MusicAlbum', $args);
    
}
 
add_action( 'init', 'custom_post_type', 0 );


/* Adding metabox to Albums CPT */

function artist_metabox() 
    {
        add_meta_box('artist_name', 'Artist Name',  'album_metabox', 'albums', 'normal', 'high');
    }
add_action('add_meta_boxes', 'artist_metabox');
 
 

function album_metabox($post) {
    $albums_type = get_post_meta($post->ID, 'albums_artist', TRUE);
  
    ?>
    <input type="hidden" name="albums_type_noncename" id="albums_type_noncename" value="<?php echo wp_create_nonce( 'albums_artist'.$post->ID );?>" />

    <input type="text" name="albums_artist" id="albums_artist" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'albums_artist', true ) ); ?>">
    
    <?php
}


function artists_data($post_id) {  
    
    if ( !wp_verify_nonce( $_POST['albums_type_noncename'], 'albums_artist'.$post_id )) {
        return $post_id;
    }
     
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
        return $post_id;
     
    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;
         
     
    $post = get_post($post_id);
    if ($post->post_type == 'albums') { 
        update_post_meta($post_id, 'albums_artist', esc_attr($_POST['albums_artist']) );
                return(esc_attr($_POST['albums_artist']));
    }
    return $post_id;
}

add_action('save_post', 'artists_data');
   

add_action("admin_init", "checkbox_init");

function checkbox_init(){
  add_meta_box("checkbox", "Featured Album", "featured_album", "albums", "normal", "high");
}

function featured_album(){
    global $post;
    $featured_album = get_post_meta($post->ID, '_featured_album', true);
 ?>

    <label>Check for yes</label>
    <?php
    $field_id_checked = '';
    if($featured_album == "yes") $field_id_checked = 'checked="checked"'; ?>
    <input type="checkbox" name="_featured_album" value="yes" <?php echo $field_id_checked; ?>>
    <?php
}

// Save Meta Details
add_action('save_post', 'ets_save_featured_album');

function ets_save_featured_album($post_id){

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    $featured_album = isset($_POST["_featured_album"]) ? $_POST["_featured_album"] : 'no';
    update_post_meta($post_id, "_featured_album", $featured_album);
}



add_image_size('smallest', 260, 390);
add_image_size('largest', 360, 390);


                    // if ( ! function_exists( 'unregister_post_type' ) ) :
                    // function unregister_post_type() {
                    // global $wp_post_types;
                    // if ( isset( $wp_post_types[ 'MusicAlbum' ] ) ) {
                    //     unset( $wp_post_types[ 'MusicAlbum' ] );
                    //     return true;
                    // }
                    // return false;
                    // }
                    // endif;

                    // add_action('init', 'unregister_post_type');


/*Template Name: Albums2*/
    function musicAlbum() {}
    
    
/*Template Name: Footer Area */


function registerFooterWidgetAreas() 
{
  
    register_sidebar( array(
        'name' => __( 'Main widget', 'Aman' ),
        'id' => 'main-widget',
        'description' => __( 'Just for test ', 'Aman' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h5 class="widget-title">',
        'after_title' => '</h5>',
        ) );

    register_sidebar( array(
        'name' => 'Footer Left',
        'id' => 'footer-left',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
        ) );

    register_sidebar( array(
        'name' => 'Footer Middle',
        'id' => 'footer-middle',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
        ) );
    register_sidebar( array(
        'name' => 'Footer Right',
        'id' => 'footer-right',
        'description' => 'Appears in the footer area',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
        ) );
    }
    add_action( 'init', 'registerFooterWidgetAreas' );

function add_dashboard_widget()
{
    wp_add_dashboard_widget("featured_image", "Featured Image", "display_featured_image");
}

function display_featured_image()
{
    echo "Dashbaord widgets";
}

add_action("wp_dashboard_setup", "add_dashboard_widget");



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
              'posts_per_page'=> $instance["image"],
              'meta_query' => array(
                array(
                  'key' => '_featured_album',
                  'value' => 'yes',
                )
              ),
            ) 
        );

            echo $args['before_widget'];
                if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
              while($albums->have_posts()) : $albums->the_post(); 
                     the_post_thumbnail('thumbnail'); 
              
                         endwhile;
 
 
        echo '</div>';

        echo $args['after_widget'];
 
    }
 
    public function form( $instance ) {
 
        $title = '';
        if( !empty( $instance['title'] ) ) {
            $title = $instance['title'];
        }
    
        $image = ! empty($instance['image'])? $instance['image'] : '1';
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        
        <p>
            <input class="widefat" id="<?php get_post_meta( get_the_ID(), '_featured_album', true); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="number" cols="30"  value="<?php echo esc_attr( $image ); ?>" rows="10"></input>
        </p>
        
        <?php
 
    }
 
    public function update( $new_instance, $old_instance ) {
            
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['image'] = ( !empty( $new_instance['image'] ) ) ? strip_tags( $new_instance['image']) : '';
        
       return $new_instance;
    }   
    
}
$featuredImage = new FeaturedImage();