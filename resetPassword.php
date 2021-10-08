<?php
session_start();
include "config.php";
if(isset($_POST["submit"]) && (!empty($_POST["email"]))){
    $email = $_POST["email"];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!$email) {
        $error .="<p>Invalid email address please type a valid email address!</p>";
        }
    else
        {
        $sel_query = "SELECT * FROM `userprofile` WHERE email='".$email."'";
        $results = mysqli_query($con,$sel_query);
        $row = mysqli_num_rows($results);
        if ($row==""){
        $error .= "<p>No user is registered with this email address!</p>";
        }
}
   if($error!=""){
   echo "<div class='error'>".$error."</div>
   <br /><a href='javascript:history.go(-1)'>Go Back</a>";
   }
    else{
        $expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
        $expDate = date("Y-m-d H:i:s",$expFormat);
        $tempPassword = md5(2418*2+$email);
        $addKey = substr(md5(uniqid(rand(),1)),3,10);
        $tempPassword = $tempPassword . $addKey;
        // Insert Temp Table
        mysqli_query($con,"INSERT INTO `passwordresets` (`email`, `tempPassword`, `expiryDate`, `emailSent`)VALUES ('".$email."', '".$tempPassword."', '".$expiryDate."', '".$emailSent."');");
        $to = $email;
        $subject = 'Password Reset';
        $message = 'Use this code to reset your password'.$tempPassword;
        $headers = "From: rephaeledwards@gmail.com\r\n";
        if (mail($to, $subject, $message, $headers)) {
            echo '<p>An email has been sent to you with instructions on how to reset your password.</p><br>';
        } 
        else {
            echo "Error, Email address does not exist";
        }    
    }
    }
?>
<html>
    <body>
    <style>            
            .center {
            box-sizing: border-box;  
            width: 50px;
            margin: auto;
            width: 18%;
            border: 2px solid #000000;
            padding: 15px;
            right: -200px;
            }

            div.loc {
            position: relative;
            right: -240px;
            } 
            
            #resetButton{
                position: relative;
                right: -80px;
                width: 160px;
            }
            
        </style>
    </body>
    <div class="center">
        <form method="post" action="" name="reset"><br />
            <label><strong>Enter Your Email Address:</strong></label><br /><br />
            <input type="email" name="email" placeholder="email@email.com" />
            <br /><br />
            <input id="resetButton" type="submit" value="Reset Password"/>
        </form>
    </div>
    
</html> 