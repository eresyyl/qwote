<?php
require_once( ABSPATH . 'wp-load.php');
// getting defaults
$currentUserId = current_user_id();
$projectId = get_the_ID();
// getting Scope of this project
$projectScope = get_field('projectScopes',$projectId);
?>


              <?php foreach($projectScope as $pS) :
                // getting details of Scope
                $scopePriceTemp = get_field('scopePrice',$pS);
                $scopeAdjustment = get_field('totalAdjustment',$pS);
                $scopePrice = $scopePriceTemp + $scopeAdjustment;
                $scopeData = get_field('scopeData',$pS);
                $scopeDataDecoded = base64_decode($scopeData);
                $scopeDataArray = json_decode($scopeDataDecoded,true);
                //var_dump($scopeDataArray);
                $scopeName = $scopeDataArray['projectName'];
                $scopeTemplate = get_field('scopeTemplate',$pS);
                $scopeLevel = $scopeDataArray['projectLevel'];
                $scopeLevel = get_term( $scopeLevel, 'selection_level' );
                //var_dump($scopeLevel);
                ?>
                <div class="col-md-3 text-center margin-0 padding-5 col-xs-6">
                        <div class="margin-bottom-20" style="margin:0 0 20px 0!important;">
                                  <img width="100%" src="<?php the_field('template_image',$scopeTemplate); ?>"><br />
                                  <div style="margin-top: -50px" class="btn-group btn-group-xs" aria-label="small button group" role="group">
                                      <a class="btn btn-small btn-default showScope" data-project="<?php echo $projectId; ?>" data-scope="<?php echo $pS; ?>" role="menuitem"><i class="icon wb-search" aria-hidden="true"></i> View Details</a>
                                      <?php if(!is_contractor()) : ?>
                                          <a data-toggle="tooltip" data-placement="top" data-trigger="hover" data-original-title="Edit Scope" title="" class="btn btn-xs btn-default" href="<?php bloginfo('url'); ?>/edit_scope?projectId=<?php echo $projectId; ?>&scopeId=<?php echo $pS; ?>" role="menuitem"><i class="icon wb-edit" aria-hidden="true"></i></a>
                                          <a class="removeScopeMiddleware btn btn-xs btn-danger" data-project="<?php echo $projectId; ?>" data-scope="<?php echo $pS; ?>" data-names="<?php echo $scopeName; ?>" role="menuitem" data-toggle="modal" data-target="#removeScope"><i class="icon wb-close-mini" aria-hidden="true"></i></a>
                                      <?php endif; ?>
                                  </div>
                                  <br/>

                                    <strong><?php echo $scopeName; ?></strong><br />
                        </div>
                    </div>
                <?php endforeach; ?>


