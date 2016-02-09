<?php
	if(!isset($_GET['uname']) && !isset($_GET['id']))
	{
		header('Location: index.php');
		exit;
	}
	if(isset($_GET['id']) && is_numeric($_GET['id']) || isset($_GET['uname']) && $_GET['uname'] != "")
	{
		if(isset($_GET['uname']))
		{
			$uname = $db->real_escape_string($_GET['uname']);
			$query = "SELECT id FROM $user_table WHERE user='$uname'";
			$result = $db->query($query) or die($db->error);
			$row = $result->fetch_assoc();
			$result->close();
			$id = $row['id'];
		}
		else
			$id = $db->real_escape_string($_GET['id']);
		$query = "SELECT t1.user, t1.avatar, t1.record_score, t1.post_count, t1.comment_count, t1.tag_edit_count, t1.forum_post_count, t1.signup_date, t2.group_name FROM $user_table as t1 JOIN $group_table AS t2 ON t2.id=t1.ugroup WHERE t1.id='$id'";
		$result = $db->query($query) or die($db->error);
		$row = $result->fetch_assoc();
		if($result->num_rows == 0)
		{
			header('Location: index.php?page=post&s=list');
			exit;
		}
        $pg = "account";
		require 'includes/header.php';
		$result->close();
		$user = $row['user'];
		$query = "SELECT fcount FROM $favorites_count_table WHERE user_id='$id'";
		$result = $db->query($query) or die($db->error);
		$r = $result->fetch_assoc();
		$result->close();
		($r == '') ? $row['fcount'] = 0 : $row['fcount'] = $r['fcount'];
		?>
			<div id="content"><center>
                <table style="padding: 0px; margin: 0px; width: 100%;">
                    <tr>
                        <td style="width: 162px;"><span style="font-size: 14px; font-weight: bold;"><?php print $row['user']; ?></span><br />
                            <span style="color: #545454; font-size: 11px;"><?php print ucfirst(mb_strtolower($row['group_name'],'UTF-8')); ?></span><br />
                            <?php
                                $user2 = new user();
                                if($user2->gotpermission('is_admin')){ echo '<b><a href="'.$site_url.'admin/index.php?page=ban_user&user_id='.$id.'" style="font-size: 11px;">Ban User</a></b>'; } ?>
                        </td>
                        <td style="font-size: 11px; vertical-align: middle;">You may add this user as your friend or leave a message on their comment section. Do not give out any personal information on this area, or any area of the site. There is no need for it. Also, this comment area is not subject to moderation so have fun creating drama! :3</td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="width: 162px; text-align: center;">
                            <?php
                                if(!$row['avatar'] == '0'){
                                    $query_avt = "SELECT directory as dir, image FROM $post_table WHERE id='".$row['avatar']."'";
                                    $avt = $db->query($query_avt) or die($db->error);
                                    $ravt = $avt->fetch_assoc();
                                    if(!$ravt['image'] == ""){
                                        echo '<img src="'.$thumbnail_url.$ravt['dir'].'/thumbnail_'.$ravt['image'].'" alt="avatar" style="border: 1px solid #d9d9d9; margin-top: 0px;" /><br />';
                                    } else {
                                        echo '<img src="layout/avatar_anonymous.jpg" alt="avatar" style="border: 1px solid #d9d9d9; margin-top: 0px;" /><br />';
                                    }
                                    $avt->free_result();
                                } else {
                                    echo '<img src="layout/avatar_anonymous.jpg" alt="avatar" style="border: 1px solid #d9d9d9; margin-top: 0px;" /><br />';
                                }
                            ?>
                            <div style="padding-top: 10px;"></div>
                            <center>
                                <div style="font-size: 11px; color: #373737; width: 160px; text-align: left;">
                                    <table cellpadding="0" cellspacing="0" style="width: 100%; padding: 0px; margin: 0px;">
                                        <tr>
                                            <td style="text-align: center;">
                                                <b>Account Statistics</b><br /><br />
                                            </td>
                                        </tr>
                                        <tr><td>
                                            <table cellpadding="0" cellspacing="0" class="highlightable" style="width: 100%; padding: 0px; margin: 0px;">
                                                <tr><td>Joined</td>
                                                    <td style="text-align: center;"><small><?php if(!is_null($row['signup_date']) && $row['signup_date']!=""){ print mb_substr($row['signup_date'],0,strlen($row['signup_date'])-9,'UTF-8');} else { echo "N/A";} ?></small></td>
                                                </tr>
                                                <tr><td><b>Posts</b></td>
                                                    <td style="text-align: center;"><a href="index.php?page=post&amp;s=list&amp;tags=user:<?php print $row['user']; ?>"><?php print $row['post_count']; ?></a></td>
                                                </tr>
                                                <tr><td>Favorites</td>
                                                    <td style="text-align: center;"><a href="index.php?page=favorites&amp;s=view&amp;id=<?php print $id;?>"><?php print $row['fcount']; ?></a></td>
                                                </tr>
                                                <tr><td>Comments</td>
                                                    <td style="text-align: center;"><?php print $row['comment_count']; ?></td>
                                                </tr>
                                                <tr><td>Tag Edits</td>
                                                    <td style="text-align: center;"><a href="index.php?page=account&amp;s=tag_edits&id=<?php echo $id; ?>"><?php print $row['tag_edit_count']; ?></a></td>
                                                </tr>
                                                <tr><td>Forum Posts</td>
                                                    <td style="text-align: center;"><?php print $row['forum_post_count']; ?></td>
                                                </tr>
                                            </table>
                                        </td></tr>
                                    </table>
                                </div>
                            </center>
                        </td>
<?php
		$cache = new cache();
		$domain = $cache->select_domain();
?>
                        <td style="width: 100%; border: 1px solid #ebebeb; padding: 10px;">
                            <div style="font-size: 18px; font-weight: bold; padding-bottom: 10px;">Recent Favorites</div>
                            <table class="highlightable" style="width: 100%; padding: 0px; margin: 0px;">
<?php 
		$query = "SELECT favorite FROM $favorites_table WHERE user_id='$id' ORDER BY added DESC LIMIT 5";
		$result = $db->query($query) or die($db->error);
		while($row = $result->fetch_assoc())
		{
			$query = "SELECT id, directory as dir, image, tags, owner, rating, score FROM $post_table WHERE id='".$row['favorite']."'";
			$res = $db->query($query) or die($db->error);
			$r = $res->fetch_assoc();
			?>
                                <tr>
                                    <td style="width: 60px; padding: 5px; text-align: center;">
                                        <span id="p<?php print $r['id']; ?>"><a href="index.php?page=post&amp;s=view&amp;id=<?php print $r['id']; ?>"><img style="max-width: 50px;" src="<?php print $thumbnail_url.'/'.$r['dir']; ?>/thumbnail_<?php print $r['image']; ?>" alt="<?php print $r['tags'].' rating:'.$r['rating'].' score:'.$r['score'].' user:'.$r['owner']; ?>" class="preview" title="<?php print $r['tags'].' rating:'.$r['rating'].' score:'.$r['score'].' user:'.$r['owner']; ?>"></img></a></span>
                                    </td>
                                    <td style="padding: 5px; vertical-align: middle;">
                                        <span style="font-size: 11px;">Added favorite #<a href="index.php?page=post&amp;s=view&amp;id=<?php print $r['id']; ?>"><?php print $r['id']; ?></a> N/A</span>
                                    </td>
                                </tr>
        <?php
			$res->close();
		}
		if($result->num_rows<1)
		{
			print '<tr>
                        <td style="padding: 5px; font-size: 11px;">No favorites have been added by this user yet!</td>
                    </tr>';
		}
?>
                            </table>
                            <div style="font-size: 18px; font-weight: bold; padding-bottom: 10px; padding-top: 15px;">Recent Uploads</div>
                            <table class="highlightable" style="width: 100%; padding: 0px; margin: 0px;">
<?php
		$query = "SELECT id, directory as dir, image, tags, rating, score, owner FROM $post_table WHERE owner='$user' ORDER BY id DESC LIMIT 5";
		$result = $db->query($query) or die($db->error);
		while($row = $result->fetch_assoc())
		{
?>
                                <tr>
                                        <td style="padding: 5px; width: 60px; text-align: center;">
                                            <span id="p<?php print $row['id']; ?>">
                                                <a href="index.php?page=post&amp;s=view&amp;id=<?php print $row['id']; ?>"><img src="<?php print $thumbnail_url.'/'.$row['dir']; ?>/thumbnail_<?php print $row['image']; ?>" alt="<?php print $row['tags'].' rating:'.$row['rating'].' score:'.$row['score'].' user:'.$row['owner']; ?>" class="preview" title="<?php print $row['tags'].' rating:'.$row['rating'].' score:'.$row['score'].' user:'.$row['owner']; ?>" style="max-width: 50px;"/></a>
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <span style="font-size: 11px;">Uploaded #<a href="index.php?page=post&amp;s=view&amp;id=<?php print $row['id']; ?>"><?php print $row['id']; ?></a> N/A</span>
                                        </td>
                                </tr>
<?php
		}
		if($result->num_rows<1)
		{
			echo '<tr>
                        <td style="padding: 5px; font-size: 11px;">No posts have been added by this user yet!</td>
                    </tr>';
		}
		$result->close();
		echo'</table></td>
                    <td>
                        <div style="border: 1px solid #ebebeb; padding: 15px; font-size: 11px; color: #373737; width: 400px;">
	                       <img src="layout/about_me.png" alt="about" />
                           <br /><br /></div></td></tr>
                </table></center></div></body></html>';
	}
?>