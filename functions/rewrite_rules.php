<?php
add_action( 'init', 'rewrite_agent_profile_rules' , 10, 0 );
add_filter( 'query_vars', 'add_custom_agent_profile_var' );
 
function rewrite_agent_profile_rules() {
	global $wp_rewrite;
//Call flush_rules() as a method of the $wp_rewrite object
    add_rewrite_rule( '^agent-profile/([^/]+)/?$', 'index.php?pagename=agent-profile&agent_name=$matches[1]', 'top' );
	
	$wp_rewrite->flush_rules( false );
}
 
function add_custom_agent_profile_var( $vars ) {
    $vars[]  = 'agent_name';
    return $vars;
}
?>
