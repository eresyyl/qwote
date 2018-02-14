<?php
require_once("../../../../../wp-load.php");
if($_POST && $_POST['userId']) {

        $userId = $_POST['userId'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        wp_update_user( array(
            'ID' => $userId,
            'first_name' => $firstName,
            'last_name' => $lastName
        ));
        update_field('field_567abde81ecf4',$phone,'user_' . $userId);
        update_field('field_56947f06c6ecf',$address,'user_' . $userId);

        $message = '';
        echo json_encode( array("message" => $message, "status" => 'success', "newFirstName" => $firstName, "newLastName" => $lastName, "newPhone" => $phone, "newAddress" => $address) );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
