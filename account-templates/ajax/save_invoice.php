<?php
require_once("../../../../../wp-load.php");
// var_dump($_POST);
$current_user_id = current_user_id();
$current_user_data = go_userdata($current_user_id);
if($_POST) {
        $company_name = $_POST['company_name'];
        $company_email = $_POST['company_email'];
        $company_phone = $_POST['company_phone'];
        $company_address = $_POST['address'];
        $tax_name = $_POST['tax_name'];
        $tax_value = $_POST['tax_value'];
        $ipi = $_POST['ipi'];
        $company_logo = $_POST['photo'];


        if($company_name == '') {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Company name is required!</div></div>";
                echo "<script>$('#save_invoice').html('Save');</script>";
                die;
        }
        else {
            if(is_headcontractor()) {
                update_field('field_569cf2f275e77',$company_name,'options');
            }
            elseif(is_agent()) {
                update_field('field_5772807fd1988',$company_name,'user_' . $current_user_id);
            }

        }

        if($company_email == '') {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Company email is required!</div></div>";
                echo "<script>$('#save_invoice').html('Save');</script>";
                die;
        }
        else {
            if(is_headcontractor()) {
                update_field('field_569ce8cb7cc78',$company_email,'options');
            }
            elseif(is_agent()) {
                update_field('field_5772807fd1b9b',$company_email,'user_' . $current_user_id);
            }
        }

        if($company_phone == '') {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Company phone is required!</div></div>";
                echo "<script>$('#save_invoice').html('Save');</script>";
                die;
        }
        else {
            if(is_headcontractor()) {
                update_field('field_569ce8d07cc79',$company_phone,'options');
            }
            elseif(is_agent()) {
                update_field('field_5772807fd1ca7',$company_phone,'user_' . $current_user_id);
            }
        }

        if($company_address == '') {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Company address is required!</div></div>";
                echo "<script>$('#save_invoice').html('Save');</script>";
                die;
        }
        else {
            if(is_headcontractor()) {
                update_field('field_569ce8bf7cc77',$company_address,'options');
            }
            elseif(is_agent()) {
                update_field('field_5772807fd1a92',$company_address,'user_' . $current_user_id);
            }
        }

        if($tax_name == '') {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Tax name is required!</div></div>";
                echo "<script>$('#save_invoice').html('Save');</script>";
                die;
        }
        else {
            if(is_headcontractor()) {
                update_field('field_569ce8dd7cc7a',$tax_name,'options');
            }
            elseif(is_agent()) {
                update_field('field_5772807fd1d98',$tax_name,'user_' . $current_user_id);
            }
        }

        if($tax_value == '') {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Tax value is required!</div></div>";
                echo "<script>$('#save_invoice').html('Save');</script>";
                die;
        }
        else {
            if(is_headcontractor()) {
                update_field('field_569ce8e77cc7b',$tax_value,'options');
            }
            elseif(is_agent()) {
                update_field('field_5772807fd1e85',$tax_value,'user_' . $current_user_id);
            }
        }

        if($ipi == '') {
                echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Invoice Payment Instructions are required!</div></div>";
                echo "<script>$('#save_invoice').html('Save');</script>";
                die;
        }
        else {
            if(is_headcontractor()) {
                update_field('field_569d48324119f',$ipi,'options');
            }
            elseif(is_agent()) {
                update_field('field_5772807fd1f70',$ipi,'user_' . $current_user_id);
            }
        }

        if($company_logo != '') {
            if(is_headcontractor()) {
                update_field('field_569ce8a87cc76',$company_logo,'options');
            }
            elseif(is_agent()) {
                
                update_field('field_5772807fd187a',$company_logo,'user_' . $current_user_id);
            }

        }

        echo "<div class='margin-top-40'><div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Invoice settings updated!</div></div>";
        echo "<script>$('#save_invoice').html('Save');</script>";
        die;

}
else {
    echo "<div class='margin-top-40'><div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>No POST data!</div></div>";
    echo "<script>$('#save_invoice').html('Save');</script>";
    die;
}
?>
