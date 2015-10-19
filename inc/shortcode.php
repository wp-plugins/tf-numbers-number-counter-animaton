<?php

if( !class_exists( 'TF_Numbers_Shortcode' ) )
{
  class TF_Numbers_Shortcode
  {
    function __construct()
    {
      add_shortcode( 'tf_numbers', array( $this, 'tf_numbers_shortcode' ) );
    }

    public function tf_numbers_shortcode( $atts )
    {
      /**
        * Call post by name extracting the $name 
        * from the shortcode previously created
        * in custom post column
        */
        extract( shortcode_atts( array(
             'tf_numbers'  => '',
             'name' => ''
          ), $atts )
        );  
          
        $args = array('post_type' => 'tf_stats', 'name' => $name);
        $numbers = get_posts( $args );
        $html = '';
        $ID = $name;
        if( $numbers )
        {
          foreach( $numbers as $number )
          { 
            setup_postdata($number); 
            $vals = get_post_meta( $number->ID, '_tf_stat', true );
            $image =  get_post_meta( $number->ID, '_tf_bg', true );
            $bgc = get_post_meta( $number->ID, '_tf_bgc', true );
            if( !$image ) $image = $bgc;
            $tc = get_post_meta( $number->ID, '_tf_tc', true );
            $ic = get_post_meta( $number->ID, '_tf_ic', true );
            $ctc = get_post_meta( $number->ID, '_tf_ctc', true );
            $nc = get_post_meta( $number->ID, '_tf_nc', true );

            $html .= '<section class="statistics" data-background="'. $image .'" data-title-color="'. $tc .'" data-icons-color="'. $ic .'" data-numbers-color="'. $nc .'" data-count-titles="'. $ctc .'">';
            $html .='<h2>'. apply_filters('the_title', $number->post_title) .'</h2>';
            $html .= '<div class="statistics-inner">';

            foreach( $vals as $key => $value )
            {
              $html .= '<div class="stat" data-count="'. $value['_tf_number'] .'">';
              $html .= '<span class="fa '. $value['_tf_icon'] .'"></span>';
              $html .= '<span class="number"></span>';
              $html .= '<span class="count-title">'. $value['_tf_title']  .'</span>';
              $html .= '</div>';
            }   
            $html .= '</div></section>'; 
          }
        }
        echo $html;
    }

  }//class ends
}//if !class_exists
?>