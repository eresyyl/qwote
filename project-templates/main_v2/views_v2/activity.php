<?php
require_once( ABSPATH . 'wp-load.php');
// getting Current User ID
$current_user_id = current_user_id();
// get project infos
$quote_id = get_the_ID();
?>

<?php if(get_field('activities')) : ?>
        <div class="table-responsive">
                <table class="table table-condensed table-activity">
                        <tbody>
                                <?php $activity = get_field('activities');
                                $activity = array_reverse($activity);
                                foreach($activity as $a) : 
                                        $text = $a['text'];
                                        $type = $a['type'];
                                        $date = $a['date'];
                                        $user_id = $a['user'];
                                        $user_data = go_userdata($user_id); $user_photo = $user_data->avatar;
                                        if($type == 'approved') {
                                                $color = 'green-600';
                                                $icon = 'wb-check';
                                        }
                                        elseif($type == 'cancelled') {
                                                $color = 'red-600';
                                                $icon = 'wb-close';
                                        }
                                        elseif($type == 'done') {
                                                $color = 'blue-600';
                                                $icon = 'wb-pie-chart';
                                        }
                                        elseif($type == 'paid') {
                                                $color = 'yellow-700';
                                                $icon = 'wb-order';
                                        }
                                        elseif($type == 'waiting') {
                                                $color = 'grey-600';
                                                $icon = 'wb-time';
                                        }
                                        elseif($type == 'attachment') {
                                                $color = 'grey-600';
                                                $icon = 'wb-attach-file';
                                        }
                                        elseif($type == 'schedule') {
                                                $color = 'teal-400';
                                                $icon = 'wb-calendar';
                                        }
                                        if($user_data->type == 'Head') {
                                                $user_type = 'Head Contractor';
                                        }
                                        elseif($user_data->type == 'Agent') {
                                                $user_type = 'Agent';
                                        } 
                                        elseif($user_data->type == 'Client') {
                                                $user_type = 'Client';
                                        } 
                                        elseif($user_data->type == 'Contractor') {
                                                $user_type = 'Contractor';
                                        } 
                                        ?>
                                        <tr>
                                                <td><i class="icon <?php echo $icon; ?> <?php echo $color; ?>"></i></td>
                                                <td><div class="avatar avatar-sm pull-left margin-right-5" data-toggle="tooltip" data-placement="right" data-trigger="hover" data-original-title="<?php echo $user_type; ?>: <?php echo $user_data->first_name; ?> <?php echo $user_data->last_name; ?>" title=""><img src="<?php echo $user_photo; ?>" alt=""></div></td>
                                                <td><span class="label label-default"><?php echo $date; ?></span></td>
                                                <td><?php echo $text; ?></td>
                                        </tr>
                                <?php endforeach; ?>
                        </tbody>
                </table>
        </div>
<?php else : ?>
        <p class="text-center margin-top-20">No notifications yet.</p>
<?php endif; ?>