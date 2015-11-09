<?php
/*
Plugin Name: PyroSteveJr - Impersonate
Version: 1.0
Plugin URI: http://pyrostevejr.com/
Description: Impersonate a user
Author: Stephen Phillips (PyroSteveJr)
Author URI: http://pyrostevejr.com/
*/
function impersonate_form($redirect = "") {
	if(empty($redirect)) {
		$redirect = get_the_permalink();
	}
	if( isset ( $_POST['pyrostevejruserID'] ) ) {
		$user_login = $_POST['pyrostevejruserID'];
		$user = get_user_by('login',$user_login);
		if($user) {
			wp_logout();
	    	//do_action('wp_login', $user->user_login, $user);
   			//wp_set_current_user( $user->ID );
    		wp_set_auth_cookie( $user->ID );
	    	wp_safe_redirect($redirect);
			exit();
		}else {
			echo '<h3 style="color: #ff0000">No user with username ' . $user_login . ' was found</h3>';
		}
	}
	
	
	if(is_user_logged_in()) {
		$current_user = wp_get_current_user();
		echo 'Logged in with username: ' . $current_user->user_login . '<br /><br /><br />';
	}
	
	if(!current_user_can( 'activate_plugins' )) {
		echo 'You do not have permission to impersonate a user.<br />';
		exit;
	} 
	
	
	?>
	<form id="pyrostevejr-impersonate-form" autocomplete="on" role="form" action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="pyrostevejruserID">User ID</label>
			<input type="text" class="form-control" id="pyrostevejruserID" name="pyrostevejruserID" placeholder="User ID">
		</div>
        <button type="submit" class="btn btn-default">Submit</button>
	</form>    
    
    <?php
}

