<?php

if( !class_exists( 'TF_Numbers' ) )
{
  class TF_Numbers
  {
    static $version = TF_NUMBERS_VERSION;

    protected static function hooks()
      {
         //enqueue front-end scripts and styles 
         add_action( 'wp_enqueue_scripts', array( 'TF_Numbers', 'enqueue_scripts' ) );
         //enqueue back-end scripts and styles
         add_action( 'admin_head', array( 'TF_Numbers', 'admin_enqueue_scripts' ) ); 
         add_action( 'init', array( 'TF_Numbers', 'tf_stats_init' ) );
         add_action( 'cmb2_init', array( 'TF_Numbers', 'numbers_metabox_init' ) );
         add_filter( "manage_edit-tf_stats_columns", array( 'TF_Numbers', "tf_number_post_columns" ) );
         add_action( "manage_tf_stats_posts_custom_column", array( 'TF_Numbers', "tf_number_custom_columns" ), 10, 2 );
         add_filter( 'post_row_actions', array( 'TF_Numbers', 'remove_view_link' ) );
      }

      /**
      * Enqueue scripts and styles
      *
      */
      public static function enqueue_scripts()
      {     
         wp_enqueue_style( 'awesome-admin', TF_NUMBERS_DIR . 'assets/css/font-awesome.min.css', self::$version );
         wp_enqueue_style( 'tf_numbers-style', TF_NUMBERS_DIR . 'assets/css/style.css', self::$version );
         wp_enqueue_script( 'tf_numbers', TF_NUMBERS_DIR . 'assets/js/tf_numbers.js', array(), self::$version, true );
      }

      public static function admin_enqueue_scripts()
      {
           wp_enqueue_style( 'awesome-css', TF_NUMBERS_DIR . 'assets/css/font-awesome.min.css', self::$version );
         ?>
          <style>
               .cmb2_select{font-family: 'FontAwesome'; font-size: 1.2em;}
          </style>
         <?php
      }

      public static function tf_stats_init()
      { 
        $labels = array(
            'name'          => __( 'Random Numbers', 'TF' ),
            'singlular_name'   => __( 'Random Number', 'TF' ),
            'plural_name'   => __( 'Random Numbers', 'TF' ),
            'add_new'       => __('Add Numbers', 'TF'),
            'add_new_item'  => __('Add Numbers', 'TF'),
            'new_item'      => __('New Numbers', 'TF'),
            'edit_item'     => __('Edit Numbers', 'TF'),
            'all_items'     => __('All Numbers', 'TF'),
            'not_found'     => __('No Numbers found', 'TF'),
            'not_found_in_trash'  => __('No Numbers found in trash', 'TF'),
        );  
        register_post_type( 
          'tf_stats', array( 
            'labels' => $labels,
            'public'  => false,
            'supports' => array('title'),
            'rewrite' => false,
            'publicly_queriable' => true, 
            'show_ui' => true, 
            'exclude_from_search' => true,  
            'show_in_nav_menus' => false,  
            'has_archive' => false,
            'menu_icon' => 'dashicons-slides',
            'menu_position'  => 65
          )
        );  
      }

      /**
      * Create metaboxes for every slider layout + options
      *
      */
       public static function numbers_metabox_init()
       {
          $prefix = '_tf_';

          //default and hand layout
          $hgh = new_cmb2_box( array( 
              'id' => $prefix . 'stats_box',
              'title' => __('Random Numbers', 'TF'),
              'object_types' => array( 'tf_stats' )
           ) );

          $hgh_group = $hgh->add_field( array( 
              'id'    => $prefix . 'stat',
              'type'        => 'group',
              'description' => __( 'Add/Remove New Random Number', 'TF' ),
              'options'     => array(
                  'group_title'   => __( 'Random Numbers {#}', 'cmb' ), 
                  'add_button'    => __( 'Add Another Random Number', 'cmb' ),
                  'remove_button' => __( 'Remove Random Number', 'cmb' ),
                  'sortable'      => true,
              ),
            ) 
          );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-visibility"></span> ' . __('Icon', 'TF'),
              'id'   => $prefix . 'icon',
              'type' => 'select',
              'options' => tf_get_icons(),
              'row_classes' => 'tf_icon'
          ) );

         $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons dashicons-edit"></span> ' . __('Number', 'TF'),
              'id'   => $prefix . 'number',
              'desc' => __('Enter some number.', 'TF'),
              'type' => 'text',
          ) );

          $hgh->add_group_field( $hgh_group, array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Title', 'TF'),
              'id'   => $prefix . 'title',
              'type' => 'text',
          ) );

          $options = new_cmb2_box( array( 
              'id' => $prefix . 'stats_bg',
              'context'       => 'side',
              'priority'   => 'high',
              'title' => __('Options', 'TF'),
              'object_types' => array( 'tf_stats' )
           ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Background Image', 'TF'),
              'id'   => $prefix . 'bg',
              'type' => 'file',
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Background Color', 'TF'),
              'id'   => $prefix . 'bgc',
              'type' => 'colorpicker',
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Section Title Color', 'TF'),
              'id'   => $prefix . 'tc',
              'type' => 'colorpicker',
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Icons Color', 'TF'),
              'id'   => $prefix . 'ic',
              'type' => 'colorpicker',
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Numbers Color', 'TF'),
              'id'   => $prefix . 'nc',
              'type' => 'colorpicker',
          ) );

          $options->add_field( array(
              'name' => '<span class="dashicons dashicons-edit"></span> ' . __('Numbers Title Color', 'TF'),
              'id'   => $prefix . 'ctc',
              'type' => 'colorpicker',
          ) );

     }

     /**
      * Add Custom Columns to Zenith Slider
      * post edit screen
      *
      */
      public static function tf_number_post_columns($cols)
      {
        $cols = array(
          'cb' => '<input type="checkbox" />',
          'title' => __('Title', 'zenith'),
          'shortcode' => __('Shortcode', 'zenith')
        );
        return $cols;
      }

      //custom columns callback
      public static function tf_number_custom_columns( $column, $post_id )
      {
        switch( $column )
        {
          case 'shortcode':
            global $post;
            $name = $post->post_name;
            $shortcode = '<span style="border: solid 2px cornflowerblue; background:#fafafa; padding:2px 7px 5px; font-size:17px; line-height:40px;">[tf_numbers name="'.$name.'"]</strong>';
          echo $shortcode; 
          break;
        }
      }

        /**
        * Remove view post link from
        * post edit screen
        *
        * @param $action
        * @return $action
        * @since 1.0
        */
        public static function remove_view_link( $action )
        {
            unset ($action['view']);
            return $action;
        }

     public static function init()
     {
      self::hooks();
     }
  }
}

?>