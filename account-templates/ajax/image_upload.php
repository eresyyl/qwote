<?php
require_once("../../../../../wp-load.php");

$location = $_POST['location'];

if (isset($_FILES) ) {
	
	if ( ! function_exists( 'wp_handle_upload' ) ) {
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	$uploadedfile = $_FILES['img'];
	$filename_to_show = $uploadedfile['name'];
	//var_dump($uploadedfile);

	$upload_overrides = array( 'test_form' => false );

	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

	if ( $movefile && !isset( $movefile['error'] ) ) {

		$filename = $movefile['file'];
		$filetype = wp_check_filetype( basename( $filename ), null );
		$wp_upload_dir = wp_upload_dir();
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $filename, 0 );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		
		echo "<input type='hidden' name='photo' value='" . $attach_id . "'>";
		echo "<i class='fa fa-check-circle light-green-800'></i> " . $filename_to_show;
		
	} 


}

?>
