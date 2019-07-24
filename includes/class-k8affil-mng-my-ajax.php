<?php
class K8affil_Mng_My_Ajax
{
  function __construct()
  {
    //Sync Affiliate categories and type
    add_action('wp_ajax_nopriv_k8affil_act_typecat', array( $this, 'k8affil_act_typecat' ));
    add_action('wp_ajax_k8affil_act_typecat', array( $this, 'k8affil_act_typecat' ));

    add_action('wp_ajax_nopriv_k8affil_act_vend', array( $this, 'k8affil_act_vend' ));
    add_action('wp_ajax_k8affil_act_vend', array( $this, 'k8affil_act_vend' ));

    add_action('wp_ajax_nopriv_k8affil_act_coup', array( $this, 'k8affil_act_coup' ));
    add_action('wp_ajax_k8affil_act_coup', array( $this, 'k8affil_act_coup' ));

  }
  public function final( $arrr ){
    echo json_encode( $arrr );
    exit();
  }
  #Sync Affiliate categories and type
  public function k8affil_act_typecat(){
    $arrr = array();
    extract( $_POST );
    #Sent not from website
    if( !isset( $action ) || $action != 'k8affil_act_typecat' ){
      $arrr['error'] = 'Submit via website, please';
      $this->final($arrr);
    }
    #Affiliate Taxonomies
    K8affil_Mng_My_Help::impTax('affcoups_coupon_category');
    K8affil_Mng_My_Help::impTax('affcoups_coupon_type');
    $arrr[''] = 'ok!';
    $this->final($arrr);
  }

  #Sync Affiliate Vendors
  public function k8affil_act_vend(){
    $arrr = array();
    extract( $_POST );
    #Sent not from website
    if( !isset( $action ) || $action != 'k8affil_act_vend' ){
      $arrr['error'] = 'Submit via website, please';
      $this->final($arrr);
    }

    $res =  wp_remote_get( 'https://vpn-anbieter-vergleich-test.de/wp-json/wp/v2/affcoups_vendor?per_page=100' );
    $decc = json_decode( $res['body'], true );
    foreach ($decc as $postt) {
      $ar = array(
        'post_type'   => 'affcoups_vendor',
        'post_status' => 'publish',
        'order'        => 'DESC',
        'orderby'      => 'date',
        'posts_per_page' => -1,
        'offset'         => 0,
        'meta_key'       => 'k8_acf_or_id',
        'meta_value' => (int)$postt['id'],
        'meta_compare'   => '=',
      );
      $queryy = new WP_Query( $ar );
      $postarr = array(
        'post_title' => $postt['title']['rendered'],
        'post_date' => $postt['date'],
        'post_status' => $postt['status'],
        'post_name' => $postt['slug'],
        'post_type' => $postt['type'],
      );

      #Update Existing post
      if( count($queryy->posts) > 0 ){
        $postarr['ID'] = $queryy->posts[0]->ID;
        $pid = wp_update_post( $postarr );
      }
      #Create new
      else{
        $pid = wp_insert_post( $postarr );
      }
      update_field( 'k8_acf_or_id', $postt['id'], $pid );
      $pm_arr = array(
        'affcoups_vendor_url',
        'affcoups_vendor_description'
      );
      foreach ($pm_arr as $item) {
        if( isset( $postt['k8_vend'][$item][0] ) ){
          update_post_meta( $pid, $item, $postt['k8_vend'][$item][0] );
        }
      }


        #Check if image Already uploaded before
      $img_nam = K8affil_Mng_My_Help::getFileName($postt['k8_feat_img']);
      $imgg_id = K8affil_Mng_My_Help::doesUpl( $img_nam );
      if( $imgg_id == 0 ){
        #Upload feature image
        $imgg_id = K8affil_Mng_My_Help::uplImg( $postt['k8_feat_img'], $pid );
      }
      #set post meta image
      update_post_meta( $pid, 'affcoups_vendor_image', $imgg_id );


    }
    $arrr[''] = 'ok!';
    $this->final($arrr);
  }

  #Sync Coupons
  public function k8affil_act_coup(){
    $arrr = array();
    extract( $_POST );
    #Sent not from website
    if( !isset( $action ) || $action != 'k8affil_act_coup' ){
      $arrr['error'] = 'Submit via website, please';
      $this->final($arrr);
    }

    $res =  wp_remote_get( 'https://vpn-anbieter-vergleich-test.de/wp-json/wp/v2/affcoups_coupon?per_page=100' );
    $decc = json_decode( $res['body'], true );

    foreach ($decc as $postt) :
      $ar = array(
        'post_type'   => 'affcoups_coupon',
        'post_status' => 'publish',
        'order'        => 'DESC',
        'orderby'      => 'date',
        'posts_per_page' => -1,
        'offset'         => 0,
        'meta_key'       => 'k8_acf_or_id',
        'meta_value' => (int)$postt['id'],
        'meta_compare'   => '=',
      );
      $queryy = new WP_Query( $ar );


      $postarr = array(
        'post_title' => $postt['title']['rendered'],
        'post_content' => $postt['k8_cont'],
        'post_date' => $postt['date'],
        'post_status' => $postt['status'],
        'post_name' => $postt['slug'],
        'post_type' => $postt['type'],
        'post_excerpt' => $postt['k8_exc'],
        'menu_order' => $postt['menu_order'],
      );

      #Update Existing post
      if( count($queryy->posts) > 0 ){
        $postarr['ID'] = $queryy->posts[0]->ID;
        $pid = wp_update_post( $postarr );
      }

      #Create new
      else{
        $pid = wp_insert_post( $postarr );
      }

      update_field( 'k8_acf_or_id', $postt['id'], $pid );

      $pm_arr = array(
        // 'affcoups_coupon_vendor',
        'affcoups_coupon_discount',
        'affcoups_coupon_code',
        'affcoups_coupon_valid_from',
        'affcoups_coupon_valid_until',
        'affcoups_coupon_url',
        'affcoups_coupon_title',
        'affcoups_coupon_description',
        'affcoups_coupon_featured',
        'affcoups_coupon_highlighted'
      );

      foreach ($pm_arr as $item) {
        if( isset( $postt['k8_pm'][$item][0] ) ){
          update_post_meta( $pid, $item, $postt['k8_pm'][$item][0] );
        }
      }


       #Check if image Already uploaded before
      $img_nam = K8affil_Mng_My_Help::getFileName($postt['k8_feat_img']);
      $imgg_id = K8affil_Mng_My_Help::doesUpl( $img_nam );
      if( $imgg_id == 0 ){
        #Upload feature image
        $imgg_id = K8affil_Mng_My_Help::uplImg( $postt['k8_feat_img'], $pid );
      }
      #set post meta image
      update_post_meta( $pid, 'affcoups_coupon_image', $imgg_id );
      

      #Set Vendor
      if( isset( $postt['k8_pm']['affcoups_coupon_vendor'] ) && $postt['k8_pm']['affcoups_coupon_vendor'][0] != 0 ){
        $orig_vend_id = $postt['k8_pm']['affcoups_coupon_vendor'][0];
        $argg = array(
          'post_type'   => 'affcoups_vendor',
          'post_status' => 'publish',
          'order'        => 'DESC',
          'orderby'      => 'date',
          'posts_per_page' => -1,
          'offset'         => 0,
          'meta_key'       => 'k8_acf_or_id',
          'meta_value' => (int)$orig_vend_id,
          'meta_compare'   => '=',
        );
        $quer = new WP_Query( $argg );
        if( is_array($quer->posts) && count($quer->posts) > 0 ){
          update_post_meta( $pid, 'affcoups_coupon_vendor', $quer->posts[0]->ID );
        }
      }

      #TAXONOMIES
      #Type
      if(is_array( $postt['k8_aff_typ']) && count($postt['k8_aff_typ']) > 0  ){
        foreach ($postt['k8_aff_typ'] as $v) {
          wp_set_object_terms( $pid, array($v['slug']), 'affcoups_coupon_type', true );
        }
      }
      #Category
      if(is_array( $postt['k8_aff_cat']) && count($postt['k8_aff_cat']) > 0  ){
        foreach ($postt['k8_aff_cat'] as $v) {
          wp_set_object_terms( $pid, array($v['slug']), 'affcoups_coupon_category', true );
        }
      }

    endforeach;


    $arrr[''] = 'ok!';
    $this->final($arrr);
  }
}
new K8affil_Mng_My_Ajax;