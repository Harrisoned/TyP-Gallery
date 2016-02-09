<?php
    $n_query = "SELECT notice FROM notices ORDER BY id DESC LIMIT 1;";
    $n_exec = $db->query($n_query) or die($db->error);
    $n_result = $n_exec->fetch_assoc();
    if(!$n_result['notice'] == ""){
        $the_notice = $n_result['notice'];
    } else {
        $the_notice = "No hay notices to show";
    }
    $n_exec->free_result();
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>'.$site_name.'</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" media="screen" href="default.css" title="default" />
		<link rel="SHORTCUT ICON" href="favicon.png" />
		<meta name="keywords" content="porn, sex, imageboard" />
		<meta name="description" content="TyP-Gallery v1.0.0" />
		<meta name="rating" content="" />
		<link rel="search" type="application/opensearchdescription+xml" title="TyP-Gallery" href="typ.xml" />
		<script src="'.$site_url.'script/prototype.js" type="text/javascript"></script>
		<script src="'.$site_url.'script/global.js" type="text/javascript"></script>
		<script src="'.$site_url.'script/scriptaculous.js" type="text/javascript"></script>
		<script src="'.$site_url.'script/builder.js" type="text/javascript"></script>
		<script src="'.$site_url.'script/effects.js" type="text/javascript"></script>
		<script src="'.$site_url.'script/dragdrop.js" type="text/javascript"></script>
		<script src="'.$site_url.'script/controls.js" type="text/javascript"></script>
		<script src="'.$site_url.'script/slider.js" type="text/javascript"></script>
		<script src="'.$site_url.'script/notes.js" type="text/javascript"></script>
		<!--[if lt IE 7]>
			<style type="text/css">
				body div#post-view > div#right-col > div > div#note-container > div.note-body{
				overflow: visible;
			 }
			</style>
		<script src="http://ie7-js.googlecode.com/svn/trunk/lib/IE7.js" type="text/javascript"></script>
		<![endif]-->
	</head>
	<body>
		<div id="header"><table cellspacing="0" cellpadding="0" style="margin: 0px; padding: 5px 0px 0px 15px; width: 100%;">
			<tr>
				<td style="width: 300px; vertical-align: middle;"><span style="font-size: 24px; font-weight: bold;"><a href="'.$site_url.'">'.$site_name.'</a></span></td>
				<td style="font-size: 11px; vertical-align: middle; padding-right: 50px;"><b>Notice: </b>'.$the_notice.'</td>
				<td style="width: 100px;">&nbsp;</td>
			</tr>
			</table>
	<ul class="flat-list" id="navbar">
        <li'.($pg == 'account' ? ' class="current-page"' : '').'>
            <a href="index.php?page=account&amp;s=home">My Account</a>
        </li>
        <li'.($pg == 'post' ? ' class="current-page"' : '').'>
            <a href="index.php?page=post&amp;s=list&amp;tags=all">Posts</a>
        </li>
        <li'.($pg == 'comment' ? ' class="current-page"' : '').'>
            <a href="./index.php?page=comment&amp;s=list">Comments</a>
        </li>
        <li'.($pg == 'alias' ? ' class="current-page"' : '').'>
            <a href="index.php?page=alias&amp;s=list">Aliases</a>
        </li>
        <li'.($pg == 'forum' ? ' class="current-page"' : '').($pg == 'forum2' ? ' class="current-page"' : '').'>
            <a href="index.php?page=forum&amp;s=list">Forum</a>
        </li>
        <li>
            <a href="tos.php" target="_blank" style="color: #00ff00;"><b>Terms of Service</b></a>
        </li>
	</ul>
    <ul class="flat-list" id="subnavbar">';
    if($pg == 'account'){
        echo '<li><a href="index.php?page=account&amp;s=home">Home</a></li>';
        $user = new user();
        if($user->check_log()) {
            echo '<li><a href="index.php?page=account_profile&id='.$checked_user_id.'">My Profile</a></li>
            <li><a href="index.php?page=favorites&amp;s=view&amp;id='.$_COOKIE['user_id'].'">My Favorites</a></li>';
        } else {
            echo '<li><a href="index.php?page=account&amp;s=home">Home</a></li>
            <li><a href="index.php?page=login&amp;code=00">Login</a></li>';
            if($registration_allowed == true){
                echo '<li><a href="index.php?page=reg">Sign Up</a></li>';
            }
        }
        echo '<li><a href="index.php?page=account-options">Options</a></li>';
    } else if($pg == 'post'){
        echo '<li><a href="index.php?page=post&amp;s=list">List</a></li>
        <li><a href="index.php?page=post&amp;s=add">Upload</a></li>
        <li><a href="index.php?page=post&amp;s=random">Random</a></li>
        <li><a href="#">Contact Us</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Help</a></li>';
    } else if($pg == 'comment'){
        echo '<li><a href="index.php?page=comment&amp;s=list">List</a></li>
       <li><a href="#">Help</a></li>';
    } else if($pg == 'alias'){
        echo '<li><a href="index.php?page=alias&s=list">List</a></li>
       <li><a href="#">Add</a></li>';
    } else if($pg == 'forum'){
        echo '<li><a href="#">New Topic</a></li>
       <li><a href="#">Help</a></li>';
    } else if($pg == 'forum2'){
        echo '<li><a href="#">Add Reply</a></li>
       <li><a href="#">Help</a></li>';
    }
    echo '<li id="notice"></li>
    </ul>
    </div>
	<div id="long-notice"></div>
	<div class="success-notice" style="display: none;"><a href="index.php?page=gmail">You have mail</a></div>';
?>