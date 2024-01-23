<?php
   require 'config.php';
   session_start();
   if(isset($_SESSION['login_user'])){
   $user_check = $_SESSION['login_user'];
   $ses_sql = $mysqli->query("SELECT username FROM admin WHERE username = '$user_check'");
   $sec_count = mysqli_num_rows($ses_sql);
   if($sec_count == "0"){ 
      header("location:login.php");
   }else{
      while($row = mysqli_fetch_array($ses_sql)){
      $login_session = $row['username'];
      }
   }
   }else{
      header("location:login.php");
      die();
   }
?>