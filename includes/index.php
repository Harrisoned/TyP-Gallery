<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
<?php
	echo '<title>'.$site_name.'</title>
	<link rel="stylesheet" type="text/css" media="screen" href="'.$site_url.'default.css" title="default" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	</head>
	<body>
	<div id="static-index">
		<h1 style="font-size: 52px; margin-top: 60px;"><a href="'.$site_url.'">'.$site_name.'</a></h1>
	';
?>
				<div class="space" id="links" style="margin-bottom: 10px;">
					<a href="index.php?page=post&amp;s=list" title="A paginated list of every post"><b>Posts</b></a>
					<a href="index.php?page=comment&amp;s=list">Comments</a>
					<a href="index.php?page=forum&amp;s=list">Forum</a>
					<a href="index.php?page=account&amp;s=home" title="My Account">My Account</a>
				</div>
		<form action="index.php?page=search" method="post">
		<center>
			<div style="width: 500px; padding: 0px; margin-bottom: 10px; text-align: left;">
					<input id="tags" name="tags" size="30" type="text" value="" class="main_search_text" />
					<input name="searchDefault" class="main_search" type="submit" value="" />
				</div>
		</center>
		</form>
	<div style="font-size: 80%; margin-bottom: 2em;">
		<p>
<?php
	$query = "UPDATE $hit_counter_table SET count=count+1";
	$db->query($query);
	$query = "SELECT t1.pcount, t2.count FROM $post_count_table AS t1 JOIN $hit_counter_table as t2 WHERE t1.access_key='posts'";
	$result = $db->query($query);
	$row = $result->fetch_assoc();
	echo 'Serving '.number_format($row['pcount']).' posts  -  Running <a href="https://github.com/xfirespeed/TyP-Gallery">TyP Gallery</a> Alpha v1.2.4
	</p><br />';
	for ($i=0;$i<strlen($row['pcount']);$i++) 
	{
		$digit=substr($row['pcount'],$i,1);
		print '<img src="./counter/'.$digit.'.gif" border="0" alt="'.$digit.'"/>'; 						
	}
	echo '<br /><br /><small>Total number of visitors so far:'.number_format($row['count']).'</small>
	<br /><br /></div></div><br /><br /><br /><br />
	</body></html>';
?>