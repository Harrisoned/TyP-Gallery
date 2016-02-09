<?php
	if(isset($_POST['submit']))
	{
		if(isset($_POST['users']) && $_POST['users'] != "")
		{
			setcookie("user_blacklist",strtolower(str_replace('\\',"&#92;",str_replace(' ','%20',str_replace("'","&#039;",$_POST['users'])))),time()+60*60*24*365);
			$new_user_list = $_POST['users'];
		}
		else
		{
			setcookie("user_blacklist",'',time()-60*60*24*365);
			$new_user_list = " ";
		}
		if(isset($_POST['tags']) && $_POST['tags'])
		{
			setcookie("tag_blacklist",str_replace('\\',"&#92;",str_replace(' ','%20',str_replace("'","&#039;",$_POST['tags']))),time()+60*60*24*365);
			$new_tag_list = $_POST['tags'];
		}
		else
		{
			setcookie("tag_blacklist","",time()-60*60*24*365);
			$new_tag_list = " ";
		}
		if(isset($_POST['cthreshold']) && $_POST['cthreshold'] != "")
		{
			if(!is_numeric($_POST['cthreshold']))
			{
				setcookie('comment_threshold',0,time()+60*60*24*365);
				$new_cthreshold = 0;
			}
			else
			{
				setcookie('comment_threshold',$_POST['cthreshold'],time()+60*60*24*365);
				$new_cthreshold = $_POST['cthreshold'];
			}
		}
		else
		{
			setcookie('comment_threshold',"",time()-60*60*24*365);
			$new_cthreshold = 0;
		}
		if(isset($_POST['pthreshold']) && $_POST['pthreshold'] != "")
		{
			if(!is_numeric($_POST['pthreshold']))
			{
				setcookie('post_threshold',0,time()+60*60*24*365);
				$new_pthreshold = 0;
			}
			else
			{
				setcookie('post_threshold',$_POST['pthreshold'],time()+60*60*24*365);
				$new_pthreshold = $_POST['pthreshold'];
			}
		}
		else
		{
			setcookie('post_threshold',"",time()-60*60*24*365);
			$new_pthreshold = 0;
		}
		if(isset($_POST['my_tags']) && $_POST['my_tags'] != "")
		{
			$user = new user();
			setcookie("tags",str_replace(" ","%20",str_replace("'","&#039;",$_POST['my_tags'])),time()+60*60*24*365);
			$new_my_tags = $_POST['my_tags'];
			if($user->check_log())
			{
				$my_tags = $db->real_escape_string($_POST['my_tags']);			
				$query = "UPDATE $user_table SET my_tags = '$my_tags' WHERE id = '$checked_user_id'";
				$db->query($query);
			}
		}
		else
		{
			setcookie("tags",'',time()-60*60*24*365);
			$new_my_tags = " ";
		}
	}
	header("Cache-Control: store, cache");
	header("Pragma: cache");
    $pg = "account";
	require "includes/header.php";
?>
<div id="content">
    <div style="font-size: 11px; color: #5a5a5a; font-family: tahoma, arial, sans-serif; width: 700px; border: 1px solid #f0f0f0; padding: 10px 20px 0px 20px;">
        <div id="user-edit">
            <h3>Account Options</h3><br />
            <p><b>Separate individual tags, ratings and users with spaces.</b> You must have cookies and JavaScript enabled in order for filtering to work.</b></p><br />
        
        <form action="" method="post">
            <div class="option">
                <table class="form" style="font-size: 12px; width: 100%;">
                    <tr>
                        <th width="15%">
                            <label class="block">Tag Blacklist</label>
                            <p>Any post containing a blacklisted tag will be ignored. Note that you can also blacklist ratings.</p>
                        </th>
                        <td width="85%">
                            <textarea cols="50" id="tags" name="tags" rows="6" style="width: 100%;"><?php $new_tag_list != "" ? print $new_tag_list : print str_replace('%20',' ', str_replace("&#039;","'",$_COOKIE['tag_blacklist'])); ?></textarea><br />
                            <a href="#">Having issues with your blacklist saving? Click here</a><br /><br />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label class="block">Comment Threshold</label>
                            <p>Any comment with a score below this will be ignored.</p>
                        </th>
                        <td>
                            <input type="text" name="cthreshold" value="<?php ($new_cthreshold == "" && !isset($_COOKIE['comment_threshold'])) ? print 0 : $new_threshold != "" ? print $new_cthreshold : print $_COOKIE['comment_threshold']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label class="block">Post Threshold</label>
                            <p>Any post with a score below this will be ignored.</p>
                        </th>
                        <td>
                            <input type="text" name="pthreshold" value="<?php ($new_pthreshold == "" && !isset($_COOKIE['post_threshold'])) ? print 0 : $new_pthreshold != "" ? print $new_pthreshold : print $_COOKIE['post_threshold']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label class="block">My Tags</label>
                            <p>These will be accessible when you add or edit a post.</p>
                        </th>
                        <td>
                            <textarea name="my_tags" rows="4" cols="50" style="width: 100%;"><?php $new_my_tags != "" ? print $new_my_tags : print str_replace("%20", " ",str_replace('&#039;',"'",$_COOKIE['tags']));?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label class="block">User Blacklist</label>
                            <p>Any post or comment from a blacklisted user will be ignored.</p>
                        </th>
                        <td>
                            <input type="text" name="users" value="<?php $new_user_list != "" ? print $new_user_list : print str_replace('%20',' ', str_replace("&#039;","'", $_COOKIE['user_blacklist'])); ?>"/>
                        </td>
                    </tr>
                </table>
            </div>
            <input type="submit" name="submit" value="Save"/>
        </div>
    </form></div></div></div></body></html>