<?php
require_once("../../../../../wp-load.php");
if( $_POST ) {
	$redirect = $_POST['redirect'];
	$login_email = $_POST['user_login'];
	$pwd = $_POST['user_password'];
        $remember = $_POST['remember'];
        if($remember == 'on') {
                $remember = true;
        }
        else {
                $remember = false;
        }

        if($login_email == '' || $pwd == '') {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Login or Password can't be empty!</div></div>";
                echo "<script>$('#go-sign-in').html('Sign in');</script>";
                die;
        }

        /*
	$creds = array();
	$creds['user_login'] = $login_email;
	$creds['user_password'] = $pwd;
	$creds['remember'] = $remember;
        $user = wp_signon( $creds, false );
        */

        $user = get_user_by( 'email', $login_email );
        if ( $user && wp_check_password( $pwd, $user->data->user_pass, $user->ID) ) {
                wp_set_current_user( $user->ID, $user->user_login );
                wp_set_auth_cookie( $user->ID );
                do_action( 'wp_login', $user->user_login );
                echo "<div class='margin-top-40'><div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Successfully signed in! You will be redirected to your Account!</div></div>";
				if($redirect != '0' && $redirect != null) {
						$redirect = get_bloginfo('url') . "/?p=" . $redirect;
						echo "<script>$('#go-sign-in').remove(); setTimeout(function(){window.location.href = '" . $redirect . "';},2000);</script>";
				}
				else {
					echo "<script>$('#go-sign-in').remove(); setTimeout(function(){location.reload();},2000);</script>";
				}

                die;
        }
        else {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Wrong email or password!</div></div>";
                echo "<script>$('#go-sign-in').html('Sign in');</script>";
                die;
        }

	die;

}
else {
        echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something goes wrong!</div></div>";
        echo "<script>$('#go-sign-in').html('Sign in');</script>";
        die;
}
?>
