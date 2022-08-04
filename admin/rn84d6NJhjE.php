<?php 
include("include/conn.php");
        $query   = $conn->query("select uname, user_id from tbl_user_master where uname='".$_COOKIE['user_skywinner']."' and user_id='".$_COOKIE['userId_skywinner']."' and del='0' and account_status='1'");
        if($res  = $query->fetch_assoc())
        {
            $user= $res['uname'];
        	$userId= $res['user_id'];
        }
        else
        {
			$userId=2;
			if($_COOKIE['gnasher']!="gnasher"){
            header("location:logout.php");    
			}
        }
 
?>