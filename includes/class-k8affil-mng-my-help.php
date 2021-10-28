<?php
class K8affil_Mng_My_Help
{
	#Sync custom taxonomies
  static function impTax( $taxName ){

  	$dec_aff_cat = array();
		$pg=1;
		while ( $pg < 100) {
			$res_aff_cat1 = wp_remote_get( 'https://vpntester.org/wp-json/wp/v2/' . $taxName . '?per_page=100&orderby=id&order=asc&page=' . $pg );
			$dec_aff_cat1 = json_decode( $res_aff_cat1['body'], true );
			$dec_aff_cat1_old = $dec_aff_cat1;
			$dec_aff_cat = array_merge( $dec_aff_cat, $dec_aff_cat1 ) ;
			if( is_array($dec_aff_cat1_old) && count($dec_aff_cat1_old) < 100 ){
				break;
			}
			$pg++;
		}


		// echo '<pre>';
		// print_r( $dec_aff_cat );
		// echo '</pre>';


		if( is_array( $dec_aff_cat ) && count( $dec_aff_cat ) > 0 ){

			foreach ($dec_aff_cat as $value) {
				$label = $value['name'];

				$argz = array(
					'description' => $value['description'],
					'slug' => $value['slug'],
				);

				# if is parent taxonomy
				if( $value['parent'] == 0 ){
					$argz['parent'] = $value['parent'];
				}
				# If children taxonomy with parent
				else{
					$parr =	get_terms(array(
						'taxonomy' => $value['taxonomy'],
						'hide_empty' => false,
						'meta_query' => array(
							array(
							  'key'       => 'k8_acf_or_id',
							  'value'     => $value['parent'],
							  'compare'   => '='
							)
						)

					));
					$argz['parent'] = $parr[0]->term_id;
				}

				$exist = get_term_by( 'slug', $value['slug'], $taxName, OBJECT);
				#Create NEW One
				if( !$exist ){
					$res = wp_insert_term( $label, $taxName, $argz );
					update_field( 'k8_acf_or_id', $value['id'], $taxName . '_' . $res['term_id'] );
					continue;
				}
				#Update Existing
				$argz['name'] = $label;
				$res = wp_update_term( $exist->term_id, $taxName, $argz );
				update_field( 'k8_acf_or_id', $value['id'], $taxName . '_' . $res['term_id'] );

			}//ENDFOREACH
		}
  }


  #UPLOAD IMAGES FROM URL
  static function uplImg( $image_url, $parent_id ){
  	$image = $image_url;
		$get = wp_remote_get( $image );
		$type = wp_remote_retrieve_header( $get, 'content-type' );
		if (!$type)
				return false;
		$mirror = wp_upload_bits( basename( $image ), '', wp_remote_retrieve_body( $get ) );
		$attachment = array(
			'post_title'=> basename( $image ),
			'post_mime_type' => $type
		);
		$attach_id = wp_insert_attachment( $attachment, $mirror['file'], $parent_id );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $mirror['file'] );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		return $attach_id;
  }


  #CHECK IF IMAGE UPLOADED BEFORE
  static function doesUpl( $filename ) {
	  global $wpdb;
	  return intval( $wpdb->get_var( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_wp_attached_file' AND meta_value LIKE '%/$filename'" ) );
	}

	#CHECK IF IMAGE UPLOADED BEFORE
  static function doesUpl2( $filename ) {
	  global $wpdb;
	  return intval( $wpdb->get_var( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_wp_attached_file' AND meta_value LIKE '%$filename'" ) );
	}

	#Retrieve Filename From URL
  static function getFileName( $url ){
		$dash =	strrpos($url,"/") + 1;
		$img = substr($url, $dash);
		return $img;
	}
}