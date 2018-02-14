<?php 
require_once("../../../../../wp-load.php");
$data = array('data'=>array(array('<a data-selection="1" class="select_selection_remove"><i class="fa fa-minus"></i></a>','test 1','test 2','test 3'),array('<a data-selection="2" class="select_selection_remove"><i class="fa fa-minus"></i></a>','test 1','test 2','test 3')));
echo json_encode( $data );
?>