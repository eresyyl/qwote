<?php
require_once("../../../../../wp-load.php");
//var_dump($_POST);

$currentUserId = current_user_id();
if($_POST) {

    $selectionTitle = $_POST['selectionTitle'];
    $selectionPrice = $_POST['selectionPrice'];
    $selectionDescription = $_POST['selectionDescription'];
    $selectionCategory = $_POST['selectionCategory'];
    $selectionLevel = $_POST['selectionLevel'];
    $selectionBrand = $_POST['selectionBrand'];
    $selectionSupplier = $_POST['selectionSupplier'];

    $selectionInformation = array(
            'post_title' => $selectionTitle,
            'post_content' => '',
            'post_author' => $currentUserId,
            'post_type' => 'select',
            'post_status' => 'publish'
    );
    $selectionId = wp_insert_post( $selectionInformation );

    // terms
    wp_set_post_terms($selectionId,$selectionCategory,'selection_cat');
    wp_set_post_terms($selectionId,$selectionLevel,'selection_level');
    wp_set_post_terms($selectionId,$selectionBrand,'selection_brand');
    wp_set_post_terms($selectionId,$selectionSupplier,'selection_supplier');

    // update fields
    update_field('field_573f5a6fe00fa',$selectionDescription,$selectionId);
    update_field('field_5754c9c037527',$selectionPrice,$selectionId);

    //photos
    $selectionPhotos = $_POST['attachment'];
    foreach($selectionPhotos as $photo) {
        $newPhotos[] = array('photo'=>intval($photo));
    }
    update_field('field_573f5a50e00f8',$newPhotos,$selectionId);

    // labour prices
    $selectionLabourTitle = $_POST['selectionLabourTitle'];
    $selectionLabourDescription = $_POST['selectionLabourDescription'];
    $selectionLabourPrice = $_POST['selectionLabourPrice'];
    $labourCount = count($selectionLabourTitle);
    $i = 0;
    while($i < $labourCount) {
        $selectionLabour[] = array('title'=>$selectionLabourTitle[$i],'price'=>$selectionLabourPrice[$i],'description'=>$selectionLabourDescription[$i]);
        $i++;
    }
    update_field('field_573f5a7ee00fb',$selectionLabour,$selectionId);

    // material prices
    $selectionMaterialTitle = $_POST['selectionMaterialTitle'];
    $selectionMaterialDescription = $_POST['selectionMaterialDescription'];
    $selectionMaterialPrice = $_POST['selectionMaterialPrice'];
    $MaterialCount = count($selectionMaterialTitle);
    $i = 0;
    while($i < $MaterialCount) {
        $selectionMaterial[] = array('title'=>$selectionMaterialTitle[$i],'price'=>$selectionMaterialPrice[$i],'description'=>$selectionMaterialDescription[$i]);
        $i++;
    }
    update_field('field_573f5ad6e00ff',$selectionMaterial,$selectionId);


    $message = "";
    echo json_encode( array("message" => $message, "status" => 'success') );
    die;

}
else {
    $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong!</div>";
    echo json_encode( array("message" => $message, "status" => 'fail') );
    die;
}
?>
