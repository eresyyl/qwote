<?php
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$projectId = get_the_ID();
$projectScope = get_field('projectScopes',$projectId);
?>

<div class="full_proposal">
        <?php if(get_field('full_proposal',$quote_id)) : ?>
                <?php $editor = get_field('full_proposal',$quote_id); ?>
        <?php else : ?>
          <?php $message = ''; ?>
          <?php foreach($projectScope as $pS) : ?>
            <?php
              $scopeId = $pS;
              $scopeData = get_field('scopeData',$scopeId);
              $scopeDataDecoded = base64_decode($scopeData);
              $scopeDataArray = json_decode($scopeDataDecoded,true);
              $scopeLevel = get_field('scopeLevel',$scopeId);
              $scopeLevel = get_term( $scopeLevel, 'selection_level' );
              $scopeLevel = $scopeLevel->name;
              $scopePrice = get_field('scopePrice',$scopeId);
              $scopeTemplateId = get_field('scopeTemplate',$scopeId);
              $scopeTemplateData = get_field('quote_fields',$scopeTemplateId);

              $scopeDetails = go_scope_details_v2($scopeTemplateId,$scopeId);

              $message .= '<h2>' . $scopeDataArray["projectName"] . '</h2>';
              foreach($scopeDetails as $sD) {
                if($sD['section_type'] == 'flds') {
                  $message .= '<h3>';
                  $message .= $sD['section_title'];
                  $message .= '</h3> ';
                  $lastElement = end($sD['section_values']);
                  foreach($sD['section_values'] as $value) {
                    if($value == NULL) {
                        $message .= '<strong>Undefined</strong><br />';
                    }
                    else {
                      $message .= '<strong>' . $value . '</strong><br />';

                      // showing description of selected value
                      foreach($scopeTemplateData as $std) {
                        if($std['title'] == $sD['section_title']) {
                          foreach($std['fields'] as $field) {
                            if($field['title'] == $value && $field['description'] != '') {
                              $message .= $field['description'];
                            }
                          }
                        }
                      }

                    }
                  }
                }
              }
            ?>
          <?php endforeach; ?>
          <?php $editor = $message; ?>
        <?php endif; ?>

        <form id="full_proposal">
                <input type="hidden" class="proposal_quote_id" value="<?php echo $quote_id; ?>">
        <?php
        $settings = array('quicktags'=>false,'teeny'=>true,'editor_height'=>200,'media_buttons'=>false,'textarea_name'=>'newContent');
        wp_editor( $editor, 'tiny_editor', $settings ); ?>
        </form>
        <div class="proposal_response margin-vertical-20"></div>
        <div class="text-center">
            <a class="btn btn-outline btn-default save_proposal">Save Proposal</a>
        </div>
</div>
