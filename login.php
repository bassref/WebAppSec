<?php
//<!--Rephael Edwards
//CMPS 5363
///Homework2-->
session_start();
include "config.php";
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

// functions to validate the input
if( isset( $_SESSION['counter'])) 
{
    $_SESSION['counter'] += 1;
}
else {
    $_SESSION['counter'] = 1;
}


$fname = $lname = $address1 = $address2 = $city = $zip = 
$country = $serNum = $purDate = $itemPur = $usedFor = $state =
$email = $username = $password = $comments = $hashed_password= $checkboxValues="";

$errorList = "";

    //assign the values from the form and validate
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
            //validate names
            if (empty($_POST['fname']) OR empty($_POST['lname']))
            {
                $errorList = "First and last names are needed";
            }

            elseif(!filter_var($_POST['fname'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $errorList = "Please enter a valid first name.";
            } 

            elseif(!filter_var($_POST['lname'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $errorList = "Please enter a valid last name.";
            } 
            else{
                $fname = trim($_POST['fname']);
                $lname = trim($_POST['lname']);
            }
/*             echo $errorList;
            echo $fname; */

            if(!empty($_POST['address1']))
            {
                $address1 = trim($_POST['address1']);
            }
            if(empty($address1))
            {
                $errorList = "Please enter an address.";     
            }

            if(!empty($_POST['address2']))
            {
                $address2 = trim($_POST['address2']);
            }
            
            if(!empty($_POST['city']))
            {
                $city = filter_var($_POST['city'],FILTER_SANITIZE_STRING);
            }
            if(empty($city))
            {
                $errorList = "Please enter a city.";     
            }
            
          
            if(isset($_POST['state']))
            {
                $state = $_POST['state'];
            }                        
                  
                         
            if(!empty($_POST['zip']))
            {
                $zip = filter_var($_POST['zip'], FILTER_VALIDATE_INT);
            }
            
            if(!empty($_POST['country']))
            {
                $country = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
            }
    
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //var_dump($hashed_password);
    
            if(!empty($_POST['email']))
            {
                $email= filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            }
            $purDate = $_POST['purDate'];
            $serNum = $_POST['serNum'];
            $itemPur = $_POST['itemPurchased'];
            
            $username = $_POST['username'];
            $comments = $_POST['comments'];
            if(!empty(is_array(($_POST['opSys']))))
            {
                $arr = array();
                foreach($_POST['opSys'] as $value)
                {
                    $arr[] = $value;
                }
                $checkboxValues = '"'.implode(',', $arr).'"';
            }
            if(empty(is_array(($_POST['opSys']))))
            {
                echo '<div class="error">Checkbox must be selected!</div>';
            }                    
     
        //insert the values into the database
            
        $sql = "INSERT INTO userprofile(firstname, lastname, profileID, address1, address2, city, state, zip, country,email)
        VALUES('$fname','$lname',NULL,'$address1','$address2','$city','$state','$zip','$country','$email')";

        $userIns = "INSERT INTO user(userName, password, profileID) VALUES ('$username', '$hashed_password', NULL)";

        $purchIns = "INSERT INTO purchasedetails(itemID, purchaseDate, serialNumber, itemUse, networkOS, profileID, comment)
        VALUES(NULL,'$purDate','$serNum','$usedFor','$checkboxValues',NULL,'$comments')";

        if($con->query($sql) === TRUE){
			$to      = $email;
			$subject = 'You made an account!';
			$message = 'You have come this far, and still you understand nothing.';
			$headers = 'From: thesols@lunasol.xyz' . "\r\n" .
			'Reply-To: rephie0000@gmail.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

			$em = mail($to, $subject, $message, $headers); 
			echo "Email sent.";
			//echo " {$em}";
        }
        if($con->query($sql)===FALSE){
            echo "Unsuccessful. Try again later.";
        }
        
        $con->close();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Login
        </title>
    </head>
    <body>
        <style>
            
            .lname { 
                display: inline-block; 
                width: 40%;
            }
            .lname .cf-medium {
                width:97%;
            }

            .center {
            box-sizing: border-box;  
            width: 300px;
            margin: auto;
            width: 50%;
            border: 2px solid #000000;
            padding: 15px;
            }

            #dropList option{
                width:150px;
            }

            div.loc {
            position: relative;
            right: -240px;
            } 

            #radBut{
                position: relative;                
                display: inline-block;
                right: 0px;
                width: 40%;
                padding: 15px;
            }

            #checkBox{
                position: relative;
                display: inline-block;
                right: -5px;
                width: 360px; 
                padding: 5px;
            }

            #commentBox{
                position: relative; 
                padding: 5px;
                right: -140px
            }

            #loginButton {
                position: relative;
                border: 1px solid;
                padding: 10px;
                box-shadow: 5px 10px;
                right: -150px;
                width: 140px;
            }

            #cancelButton{
                position: relative;
                border: 1px solid;
                padding: 10px;
                box-shadow: 5px 10px;
                right: -190px;
                width: 120px;
            }
            
        </style>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          
                <div class="center">
                    <!--HTML for the first section with input text boxes-->
                    
                    <div class="center">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" pattern="[a-zA-Z0-9]+" minlength="3" maxlength="15"><br><br>
                        
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,}">
                    </div>
                    
                    
                        
                    <!--HTML for the buttons-->
                    <br><br>
                    <input id="loginButton" type="submit" value="Log In">
                    <input id="cancelButton" type="submit" value="Cancel">
                </div>
        </form>    
    </body>
</html>
