<?php
	require "../inv.header.php";
	$user = new user();
	$ip = $db->real_escape_string($_SERVER['REMOTE_ADDR']);	
	if($user->banned_ip($ip))
		exit;
	if(is_numeric($_GET['id'])) {
		if($user->check_log()) {
			$id = $db->real_escape_string($_GET['id']);
			$query = "SELECT COUNT(*) FROM users WHERE id='$checked_user_id' AND avatar='$id'";
			$result = $db->query($query);
			$row = $result->fetch_assoc();
			if($row['COUNT(*)'] < 1){
				$result->free_result();
                $query = "UPDATE users SET avatar='$id' WHERE id='$checked_user_id'";
				if($db->query($query)){
					echo "3";
				}
			} else {
                echo "1";
		    }
        } else {
            echo "2";
	   }
    }
?>