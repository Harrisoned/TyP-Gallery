<?php 
	echo '<div id="content"><div class="content"><div style="font-size: 11px; color: #5a5a5a; font-family: tahoma, arial, sans-serif; width: 300px; float: left; border: 1px solid #f0f0f0; padding: 10px 20px 0px 20px;">';
	$user = new user(); 
	if($user->check_log())
	{
		echo '<h2>My Account Home</h2><br />
        <a href="index.php?page=login&amp;code=01" style="font-size: 12px; font-weight: bold;">&raquo; Logout</a><br />
		<p>>Make like a tree and get out of here! This will delete the cookies that are required to authenticate your account.</p><br />
		<a href="index.php?page=account_profile&id='.$checked_user_id.'" style="font-size: 12px; font-weight: bold;">&raquo; My Profile</a><br />
		<p>View your profile as others would see it. This page will show your recent uploads, favorites and avatar, if you have one.</p><br />
		<a href="index.php?page=favorites&amp;s=view&amp;id='.$_COOKIE['user_id'].'" style="font-size: 12px; font-weight: bold;">&raquo; My Favorites</a><br />
		<p>View a condensed list of all your favorites on the site. This should be rather short, unless you like everything you see... Which you probably do.</p><br /><br />
		<br />';		
	}
	else
	{
		print '<h2>You are not logged in.</h2><br />
        <a href="index.php?page=login&amp;code=00" style="font-size: 12px; font-weight: bold;">&raquo; Login</a><br />
        <p>If you already have an account you can login here. Alternatively, accessing features that require an account will automatically log you in if you have enabled cookies.</p><br />';
		if($registration_allowed == true)
			echo '<a href="index.php?page=reg" style="font-size: 12px; font-weight: bold;">&raquo; Sign Up</a><br />
            <p>You can access 90% of '.$site_name.' without an account, but you can sign up for that extra bit of functionality. Just a login and password, no email required!</p><br /><br /> <br />';
		else
			echo '<p><b>Registration is closed.</b></p><br /><br /> <br />';
	}
?>
<a href="index.php?page=favorites&amp;s=list" style="font-size: 12px; font-weight: bold;">&raquo; Everyone's Favorites</a><br />
<p>If you like to stalk other people and steal their ideas, you can view their favorites and eventually transform into a clone of them. I swear it's true.</p><br />
<a href="index.php?page=account-options" style="font-size: 12px; font-weight: bold;">&raquo; Options</a><br />
<p>Account options such as blacklists, safe only searching, and almost anything configurable for your account is on this page. You should not really spend too much time here.</p><br />
</div></div></div></body></html>