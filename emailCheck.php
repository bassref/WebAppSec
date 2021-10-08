<?php
include "config.php";

if(isset($_POST['email'])){
   $email = mysqli_real_escape_string($con,$_POST['email']);

   $query = "select count(*) as cntEmail from userprofile where email='".$email."'";

   $result = mysqli_query($con,$query);
   $response = "<span style='color: green;'> Email Available.</span>";
   if(mysqli_num_rows($result)){
      $row = mysqli_fetch_array($result);

      $count = $row['cntEmail'];
    
      if($count > 0){
          $response = "<span style='color: red;'>Email already in use.</span>";
      }
   
   }

   echo $response;
   die;
}
