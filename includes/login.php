<?php
	$user = new user();
	if($_GET['code'] == "00")
	{
		if($user->check_log())
		{
			header("Location:index.php?page=account");
			exit;
		}
		if(isset($_POST['user']) && $_POST['user'] != "" && isset($_POST['pass']) && $_POST['pass'] != "")
		{
			$username = $db->real_escape_string(htmlentities($_POST['user'], ENT_QUOTES, 'UTF-8'));
			$password = $db->real_escape_string($_POST['pass']);
			if(!$user->login($username, $password))
				header("Location:index.php?page=login&code=00");
			else
				header("Location:index.php?page=account");
			exit;
		}
		header("Cache-Control: store, cache");
		header("Pragma: cache");
        $pg = "account";
		require "includes/header.php";
		echo '<div id="content"><div class="content">
        <div style="font-size: 11px; color: #5a5a5a; font-family: tahoma, arial, sans-serif; width: 300px; float: left; border: 1px solid #f0f0f0; padding: 10px 30px 0px 20px;">
            <h2>Login</h2><br />
            <p>You need an account to access some parts of our website. You can register for an account <a href="index.php?page=account&amp;s=reg">here</a>.</p>
            <form method="post" action="">
		      <table><tr><td>
		          Username:<br />
		      <input type="text" name="user" value="" style="width: 100%;" /><br /><br />
		      </td></tr>
		      <tr><td>
		          Password:<br />
		      <input type="password" name="pass" value="" style="width: 100%;" /><br /><br />
		      </td></tr>
		      <tr><td>
		      <input type="submit" name="submit" value="Log in" /><br /><br />
		      </td></tr>
		      <tr><td>
		      <a href="index.php?page=reset_password">Forgotten your password?</a><br /><br />
		      </td></tr></table></form>
              </div></div></div>';
	}
	if($_GET['code'] == "01")
		$user->logout();
?></div></body></html>