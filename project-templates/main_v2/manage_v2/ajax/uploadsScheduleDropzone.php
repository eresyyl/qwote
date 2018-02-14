<?php
session_start();
require_once("../../../../../../../wp-load.php");
if (isset($_FILES) && $_GET['row'] ) {
	$row = $_GET['row'];
	$rowSession = 'scheduleUploads_' . $row;
	if ( ! function_exists( 'wp_handle_upload' ) ) {
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	$uploadedfile = $_FILES['file'];
	$filename_to_show = $uploadedfile['name'];
	//var_dump($uploadedfile);

	$upload_overrides = array( 'test_form' => false );

	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

	if ( $movefile && !isset( $movefile['error'] ) ) {

		$filename = $movefile['file'];
		$filetype = wp_check_filetype( basename( $filename ), null );
		$wp_upload_dir = wp_upload_dir();
                $attachment_name = preg_replace( '/\.[^.]+$/', '', basename( $filename ) );
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $filename, 0 );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );

                $attach_data = get_post_mime_type( $attach_id );

                if($attach_data == 'image/jpeg') {
                        $attach_img_data = wp_generate_attachment_metadata( $attach_id, $filename );
        		wp_update_attachment_metadata( $attach_id, $attach_img_data );
                }

                $uploaded_url = wp_get_attachment_image_src($attach_id,'thumbnail');

                // checking if cookies already set
                if (isset($_SESSION[$rowSession])) {
                    $scheduleUploads = $_SESSION[$rowSession];
                }
                else {
                    $scheduleUploads = array();
                }
                // add current uploadId to cookie array
                $scheduleUploads[] = $attach_id;
                // saving current upload to cookie
                //setcookie('projectUploads', serialize($projectUploads), time()+3600);
                $_SESSION[$rowSession] = $scheduleUploads;

                /*
                echo "<div class='uploaded_image_section'>";
                        echo "<input type='hidden' name='attachment[]' class='attachment' value='" . $attach_id . "'>";
                        echo "<div style='margin:20px 0 10px 0; position:relative;'>";
                        if($attach_data == 'image/jpeg' || $attach_data == '' || $attach_data == 'image/gif' || $attach_data == 'image/pjpeg' || $attach_data == 'image/png' || $attach_data == 'image/tiff') {
                                echo "<img src='" . $uploaded_url[0] . "' height='100px'><i style='cursor:pointer; position:absolute; top:-5px; right:-5px; color:red;' class='fa fa-times-circle' style='color:red;'></i>";
                        }
                        elseif($attach_data == 'application/pdf' || $attach_data == 'application/msword') {
                                 echo "<img src='" . get_bloginfo('template_url') . "/assets/defaults/attachment.png' height='100px'><i style='cursor:pointer; position:absolute; top:-5px; right:-5px; color:red;' class='fa fa-times-circle' style='color:red;'></i><div style='position:absolute; width:100%; text-align:center; bottom:0;'>" . $filename_to_show . "</div>";
                        }

                        echo "</div>";
                        //echo "<i class='fa fa-check-circle light-green-800'></i> " . $filename_to_show;
                echo "</div>";
                */

	}

}
?>
