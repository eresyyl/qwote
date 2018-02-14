<?php
require_once(ABSPATH . "wp-load.php");

add_filter( 'wp_mail_from', 'custom_wp_mail_from' );
function custom_wp_mail_from( $original_email_address ) {
	//Make sure the email is from the same domain 
	//as your website to avoid being marked as spam.
        $from = get_field('email_from_address','options');
	return $from;
}

add_filter( 'wp_mail_from_name', 'custom_wp_mail_from_name' );
function custom_wp_mail_from_name( $original_email_from ) {
        $from = get_field('email_from','options');
	return $from;
}


function go_email($subject,$title,$text,$user) {
        $user_data = go_userdata($user);
        $mail = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
         <head>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
          <title>Qwote - Instant Quote</title>
          <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        </head>
        <body style="margin: 0; padding: 20px; background-color: #f1f4f5;">
        <div style="background-color: #fff; border-radius: 4px; padding:25px 20px;">
        <div style="margin:0px 0 20px 0; font-size:18px; text-align:center; color:#37474f;">' . $title . '</div>
        <div>' . $text . '</div>
        </div>
        </body>
        </html>';
        add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
        $m = wp_mail($user_data->email, $subject, $mail);
        return $m;
}
        
?>