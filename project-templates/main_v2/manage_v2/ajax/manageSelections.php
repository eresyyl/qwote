<?php
require_once("../../../../../../../wp-load.php");
if($_POST && $_POST['projectId']) {

        $projectId = $_POST['projectId'];
        $scopeId = $_POST['scopeId'];

        $defaultId = array();

        $scopeData = get_field('scopeData',$scopeId);
        $scopeDataDecoded = base64_decode($scopeData);
        $scopeDataArray = json_decode($scopeDataDecoded,true);
        $scopeLevel = get_field('scopeLevel',$scopeId);
        $scopeLevelId = $scopeLevel;
        $scopeLevel = get_term( $scopeLevel, 'selection_level' );
        $scopeLevel = $scopeLevel->name;
        $scopePrice = get_field('scopePrice',$scopeId);
        $scopeTemplateId = get_field('scopeTemplate',$scopeId);
        $templateData = get_field('quote_fields',$scopeTemplateId);

        $scopeDetails = go_scope_details_v2($scopeTemplateId,$scopeId);

        $scopeSelections = get_field('scopeSelections',$scopeId);
        $scopeSelections = base64_decode($scopeSelections);
        $scopeSelections = json_decode($scopeSelections,true);

        $message = '<div class="margin-top-20"><form id="scopeSelections">';
        $message .= '<input type="hidden" name="projectId" value="' . $projectId . '">';
        $message .= '<input type="hidden" name="scopeId" value="' . $scopeId . '">';
        $message .= '<h3 class="text-center">' . $scopeDataArray["projectName"] . ' Options</h3>';
        $message .= '<p class="text-center">Price of this scope will be recalculated after you\'ll save your choices!</p>';
        //$message .= '<div class="text-center"><span class="label label-lg label-default margin-horizontal-10">' . $scopeLevel . '</span>';
        //$message .= '<span class="label label-lg label-dark margin-horizontal-10">$' . $scopePrice . '</span></div>';
        $selectionsExist = false;
        foreach($scopeDetails as $sD) {
          if(array_key_exists('section_type',$sD) && $sD['section_type'] == 'flds') {
            $scopeSectionTitle = $sD['section_title'];
            $radioFirstName = preg_replace("/[^a-zA-Z0-9]/", "", $scopeSectionTitle);
            $radioFirstName = strtolower($radioFirstName);

            foreach($sD['section_values'] as $value) {

              // let's go by Quote Template array and find current Title options
              $selectionRow = 0;
              foreach($templateData as $tD) {
                if($tD['title'] == $scopeSectionTitle) {
                  foreach($tD['fields'] as $field) {
                    $cleanValue = explode(' x', $value);
                    $cleanValue = $cleanValue[0];
                    if($field['title'] == $cleanValue && $field['selections_category'] != null) {
                        $selectionsExist = true;
                        $radioName = preg_replace("/[^a-zA-Z0-9]/", "", $field['title']);
                        $radioName = strtolower($radioName);
                        $message .= '<div class="margin-top-40 margin-horizontal-20">';
                        $message .= '<h4 class="text-center">' . $scopeSectionTitle . ': ' . $field['title'] . '</h4>';
                        // let's get a Selections for category: $field['selections_category'] AND level: $scopeLevelId
                        $selections = get_posts(
                          array(
                            'posts_per_page'=>9999,
                            'post_type'=>'select',
                            'tax_query' => array(
                              array(
                            			'taxonomy' => 'selection_cat',
                            			'field' => 'term_id',
                            			'terms' => array($field['selections_category'])
                            	),
                              array(
                            			'taxonomy' => 'selection_level',
                            			'field' => 'term_id',
                            			'terms' => array($scopeLevelId)
                            	)
                            )
                          )
                        );
                        $message .= '<div class="row margin-top-20 padding-5 selectionsRow-' . $radioName . '">';
                        foreach($selections as $selection) {
                            $selectionDescription = get_field('description',$selection->ID);
                            $selectionSupplier = get_taxonomy('select_supplier',$selection->ID);
                          $selectionRetailPrice = get_field('retail_price',$selection->ID);
                          if($selectionRetailPrice) {
                            $selectionRetailPrice = "$" . $selectionRetailPrice;
                          }
                          else {
                              $selectionRetailPrice = $selectionRetailPrice;
                          }
                          $selectionLabourPrice = 0;
                          $selectionLabour = get_field('labour',$selection->ID);
                          foreach($selectionLabour as $sL) {
                            $selectionLabourPrice = $selectionLabourPrice + $sL['price'];
                          }
                          $selectionLabourPrice = number_format($selectionLabourPrice, 2, '.', '');
                          $selectionMaterialPrice = 0;
                          $selectionMaterial = get_field('material',$selection->ID);
                          foreach($selectionMaterial as $sM) {
                            $selectionMaterialPrice = $selectionMaterialPrice + $sM['price'];
                          }
                          $selectionMaterialPrice = number_format($selectionMaterialPrice, 2, '.', '');
                          $selectionPrice = $selectionLabourPrice + $selectionMaterialPrice;

                          $selectionImage = get_field('photos',$selection->ID);
                          $selectionImage = $selectionImage[0]['photo'];
                          //$selectionImageSize = 'thumbnail';
                          $selectionImageSize ='selections';
                          $selectionImage = wp_get_attachment_image_src( $selectionImage, $selectionImageSize );

                          // get all photos for gallery
                          $selectionImages = get_field('photos',$selection->ID);
                          $selectionGallery = '';
                          if(is_array($selectionImages)) {
                              $i=0;
                              foreach($selectionImages  as $image) {
                                  if($i == 0) { $active = 'active'; } else { $active = ''; }
                                  $selectionGImageSize = 'medium';
                                  $selectionGImage = $image['photo'];
                                  $selectionGImage = wp_get_attachment_image_src( $selectionGImage, $selectionGImageSize );
                                  $selectionGallery .= '<div class="item ' . $active . '">
                                                          <img class="width-full" src="' . $selectionGImage[0] . '" alt="..." />
                                                      </div>';
                                  $i++;
                              }
                          }

                          $selectionChecked = '';
                          // let's see what Selections are selected already
                          if(is_array($scopeSelections)) {
                            // check current Option has selections selected
                            if( array_key_exists($radioFirstName .'_' . $radioName,$scopeSelections)
                              && in_array($selection->ID,$scopeSelections[$radioFirstName .'_' . $radioName]) ) {

                                // this is selected Selection
                                 $selectionDefaultClass = '<div class="ribbon ribbon-horizontal ribbon-reverse ribbon-success">
                                 <span class="ribbon-inner">ADDED</span>
                                 </div>';
                                 $selectionChecked = 'checked';
                                //$defaultId[] = $selection->ID;
                                $message .= '<input type="hidden" class="' . $selection->ID . '" name="'. $radioFirstName .'_' . $radioName . '[]" value="' . $selection->ID . '">';
                              }
                              else {

                                $selectionDefaultClass = '';

                              }
                          }
                          else {
                            $selectionByDefault = get_field('default',$selection->ID);
                            if($selectionByDefault == true) {
                                $selectionChecked = 'checked';
                              $selectionDefaultClass = '<div class="ribbon ribbon-horizontal ribbon-reverse ribbon-success">
                              <span class="ribbon-inner"><i class="icon wb-heart" aria-hidden="true"></i></span>
                            </div>';
                              //$defaultId[] = $selection->ID;
                              $message .= '<input type="hidden" class="' . $selection->ID . '" name="'. $radioFirstName .'_' . $radioName . '[]" value="' . $selection->ID . '">';
                            }
                            else {
                              $selectionDefaultClass = '';
                            }
                          }

                          $selectionRow++;
                          $message .= '<div class="col-md-3"><div class="widget widget-shadow">
                                        <div class="widget-header cover overlay" style="height: calc(100% - 100px);">
                                        <a data-toggle="modal" data-target="#selection_' . $selection->ID . '" href="">
                                          <img class="cover-image" src="' . $selectionImage[0] . '" alt="..." style="height: 100%;">
                                          <div class="overlay-panel overlay-background overlay-top">
                                            <div class="row">
                                              <div class="col-xs-12">
                                                <div class="font-size-20 white">' . $selection->post_title . '</div>
                                                <div class="font-size-14 grey-400">' . $selectionRetailPrice . '</div>
                                              </div>
                                            </div>
                                          </div>
                                         </a>
                                        </div>
                                        <div class="widget-footer text-center bg-white padding-horizontal-30 padding-vertical-20 height-100">
                                          <div class="row no-space">
                                            <div class="col-xs-12">
                                              <input type="checkbox" class="selectionSelect switchy" name="'. $radioFirstName .'_' . $radioName . '_checkbox" data-plugin="switchery" data-inputname="'. $radioFirstName .'_' . $radioName . '" data-name="' . $radioName . '" data-id="' . $selection->ID . '" ' . $selectionChecked . '/>
                                            </div>
                                          </div>
                                        </div>
                                      </div></div>';
                          if( ($selectionRow%4) == 0 ) {
                              $message .= '<div style="clear:both"></div>';
                          }

                          $message1 .= '<li class="text-center">
                                        <div style="height: 315px" class="widget widget-shadow text-center">
                                          <a class="inline-block" data-toggle="modal" data-target="#selection_' . $selection->ID . '" href="#" title="view">
                                          <figure class="widget-header overlay">
                                            <img style="max-height: 200px; height: 200px" class="overlay-figure overlay-scale" src="' . $selectionImage[0] . '" alt="..."></a>
                                         </figure>
                                          <h4 class="widget-title">' . $selection->post_title . '</h4>
                                          <span class="badge badge-md badge-primary ">' . $selectionRetailPrice . '</span>
                                          ' . $selectionDefaultClass . '

                                       </div>
                                       <div class="text-center margin-top-20">
                                         <input type="checkbox" class="selectionSelect switchy" name="'. $radioFirstName .'_' . $radioName . '_checkbox" data-plugin="switchery" data-inputname="'. $radioFirstName .'_' . $radioName . '" data-name="' . $radioName . '" data-id="' . $selection->ID . '" ' . $selectionChecked . '/>
                                       </div>
                                      </li>';
/* <a class="btn btn-sm btn-outline btn-success selectionSelect" data-inputname="'. $radioFirstName .'_' . $radioName . '" data-name="' . $radioName . '" data-id="' . $selection->ID . '">Select</a> */
                          $message .= '<div class="modal fade modal-fill-in" id="selection_' . $selection->ID . '" aria-hidden="true" aria-labelledby="selection_' . $selection->ID . '" role="dialog" tabindex="-1">
                                          <div class="modal-dialog modal-center">
                                              <div class="modal-content">
                                                  <div class="modal-header text-center">
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">×</span>
                                                      </button>
                                                      <h4 class="modal-title">' . $selection->post_title . '</h4>
                                                  </div>
                                                  <div class="modal-body text-center">

                                                  <div class="carousel slide margin-bottom-20" id="sSlide_' . $selection->ID . '" data-ride="carousel">
                                                      <div class="carousel-inner" role="listbox">
                                                          ' . $selectionGallery . '
                                                      </div>
                                                      <a class="left carousel-control" href="#sSlide_' . $selection->ID . '" role="button" data-slide="prev">
                                                          <span class="icon wb-chevron-left" aria-hidden="true"></span>
                                                          <span class="sr-only">Previous</span>
                                                      </a>
                                                      <a class="right carousel-control" href="#sSlide_' . $selection->ID . '" role="button" data-slide="next">
                                                          <span class="icon wb-chevron-right" aria-hidden="true"></span>
                                                          <span class="sr-only">Next</span>
                                                      </a>
                                                    </div>

                                                    <div class="text-center margin-bottom-20"><span class="label label-success"> ' . $selectionSupplier . '</span><span class="label label-default">' . $selectionRetailPrice . '</span></div>
                                                      ' . $selectionDescription . '
                                                  </div>
                                              </div>
                                          </div>
                                      </div>';
                        }
                        $message .= '<div id="' . $radioName . '"></div>';

                        $defaultIdArray = json_encode($defaultId);

                        $defaultId = null;

                        $message .= '</div>';
                        $message .= '</div>';
                    }
                  }
                }
              }

            }
          }
        }

        if($selectionsExist == false) {
          $message .= '<div class="text-center margin-top-40 margin-bottom-20">No options to manage!</div>';
        }

        $message .= '</div>';

        $message .= '<div class="text-center margin-vertical-20">';
        if($selectionsExist == true) {
          $message .= '<a style="cursor:pointer;" class="btn btn-sm btn-outline btn-primary margin-horizontal-10" onclick="saveSelections();">Update Price</a>';
        }
        $message .= '<a style="cursor:pointer;" class="btn btn-sm btn-outline btn-default margin-horizontal-10" onclick="closeScope();">Close</a>';
        $message .= '</form></div>';

        $message .= '<div id="saveSelectionsResponse"></div>';

        echo json_encode( array("message" => $message, "temp" => $selection, "status" => 'success') );
        die;
}
else {
        $message = "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! No POST data!</div>";
        echo json_encode( array("message" => $message, "status" => 'fail') );
        die;
}
?>
